<template>
  <v-card class="mb-3" flat outlined v-if="item.status > 0">
    <v-list>
      <template v-if="item.status == 1">
        <FieldAccess :model="'tender'" field="rates_price"
                     field_name="Текущее предложение" v-slot="{ accessData }">
          <v-list-item v-if="item.rate != undefined">
            <v-list-item-content>
              <p class="grey--text font-weight-regular mb-2 mt-0"
                 v-html="item.status == 1 ? 'Текущее <br/>предложение' : 'Итоговое <br/>предложение' "></p>
              <v-list-item-title class="display-2 success--text mb-2 font-weight-medium">{{ formatPrice(item.price) }} ₽<span
                  class="font-weight-light">/{{ item.unit }}</span></v-list-item-title>

              <span v-if="item.rate.title_name" class="font-weight-light">препарат: {{ item.rate.title_name }}</span>
                  
              <span v-if="item.rate.is_analog ==1" class="font-weight-light">аналог: {{ item.rate.analog_name }}</span>
              <div v-if="auth_user.id == item.user_id || auth_user.role_id == 1000 || item.rate.user.id == auth_user.id">
                <span v-if="item.rate.user.company_check_file !== undefined && item.rate.user.company_check_file !== null">
                <a :href="'/storage/proofs/'+item.rate.user.company_check_file" 
                class="blue--text font-weight-medium mb-2" 
                style="text-decoration: underline;"
                target="_blank" 
                >{{ item.rate.user.company_name }}</a>
                </span>
                <span v-else>
                 {{ item.rate.user.company_name }}
                </span>
              </div>
            </v-list-item-content>
            <v-list-item-action v-if="accessData.canEdit">
              <FieldAccessButton :accessData="accessData"/>
            </v-list-item-action>
          </v-list-item>
          <v-card-text class="text-center grey--text py-6" v-else>
            Предложений нет
          </v-card-text>
        </FieldAccess>

        <FieldAccess :model="'tender'" field="rates_confirm"
                     field_name="Принять текущее предложение" v-slot="{ accessData }"
                     v-if="item.completed == 1 && (auth_user.id == item.user_id || auth_user.role_id == 1000)">
          <v-divider class="my-0"></v-divider>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-subtitle class="text-center">
                <v-btn
                    depressed
                    color="success"
                    dark
                    @click.stop="confirm_dialog = true"
                    class="rounded-btn"
                >
                  <v-icon left size="20">mdi-check</v-icon>
                  Принять предложение
                </v-btn>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action v-if="accessData.canEdit">
              <FieldAccessButton :accessData="accessData"/>
            </v-list-item-action>
          </v-list-item>
        </FieldAccess>

        <FieldAccess :model="'tender'" field="rates_cancel"
                     field_name="Отменить текущее предложение" v-slot="{ accessData }"
                     v-if="item.completed == 1 && (auth_user.id == item.user_id || auth_user.role_id == 1000)">
          <v-divider class="my-0"></v-divider>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-subtitle class="text-center">
                <v-btn
                    depressed
                    color="red"
                    dark
                    @click.stop="cancel_dialog = true"
                    class="rounded-btn"
                >
                  <v-icon left size="20">mdi-cancel</v-icon>
                  Отменить предложение
                </v-btn>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action v-if="accessData.canEdit">
              <FieldAccessButton :accessData="accessData"/>
            </v-list-item-action>
          </v-list-item>
        </FieldAccess>

        <FieldAccess :model="'tender'" field="rates_add"
                     field_name="Добавить предложение" v-slot="{ accessData }" v-if="item.completed == 0">
          <v-divider class="my-0"></v-divider>
          <v-list-item>
            <v-list-item-content class="text-center">
              <v-list-item-subtitle class="text-center">
                <v-btn
                    depressed
                    color="grey lighten-3"
                    @click.stop="setRate"
                    class="rounded-btn"
                >
                  <v-icon left size="20">mdi-plus</v-icon>
                  Добавить предложение
                </v-btn>
                <br><br>
                <v-btn
                    depressed
                    color="grey lighten-3"
                    @click.stop="setRateAnalog"
                    class="rounded-btn"
                    v-if="item.is_analog == 1"
                >
                  <v-icon left size="20">mdi-plus</v-icon>
                  Предложить аналог
                </v-btn>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action v-if="accessData.canEdit">
              <FieldAccessButton :accessData="accessData"/>
            </v-list-item-action>
          </v-list-item>
        </FieldAccess>
      </template>
      <template v-if="item.rates.length > 0">
        <FieldAccess :model="'tender'" field="rates_history"
                     field_name="История ставок" v-slot="{ accessData }">
          <v-divider class="my-0" v-if="item.status == 1"></v-divider>
          <v-card flat color="transparent">
            <FieldAccessButton :accessData="accessData" :absolute="true"
                               :style="'position: absolute; right: 20px; top: 20px;'"/>
            <v-list subheader>
              <v-subheader>
                История ставок
                <v-spacer></v-spacer>
              </v-subheader>
              <v-list-item two-line v-for="rate in item.rates" :key="rate.id"
                           :color="rate.status == 0 ? 'grey lighten-5' : 'transparent' "
                           :class="rate.block==true?'-rate-blocked':''">

                <v-list-item-action>
                  <v-icon v-if="rate.status == 0" color="red">mdi-cancel</v-icon>
                  <v-icon v-else v-html="item.type == 'rise' ? 'mdi-transfer-up' : 'mdi-transfer-down' "
                          color="success"></v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <div>
                    {{
                      block_arr.includes(rate.id) == true ? 'Пользователь заблокировал вас, для более подробной информации просим написать администратору торговой площадки' : ''
                    }}
                  </div>
                  <v-list-item-title>
                    <span class="font-weight-light" v-if="auth_user.id == rate.user.id">Моя ставка -</span>
                    <span class="font-weight-medium mx-1">{{ formatPrice(rate.price) }} ₽<span
                        class="font-weight-light">/{{ item.unit }}</span></span>

                    <span v-if="rate.title_name"
                          class="font-weight-medium mx-1">препарат: {{ rate.title_name }}</span> 

                    <span v-if="rate.is_analog == 1"
                          class="font-weight-medium mx-1">аналог: {{ rate.analog_name }}</span>

                    <span v-if="rate.status == 0"
                          class="grey--text caption font-weight-light mx-1">Предложение отменено</span>
                  </v-list-item-title>
                  <v-list-item-subtitle>
                    Ставка создана - {{ rate.created_formated }}
                  </v-list-item-subtitle>
                </v-list-item-content>



                <v-list-item-icon  v-if="auth_user.role_id == 1000">
                  <b>{{ rate.user.company_name }}</b><br>
                </v-list-item-icon>

                <v-list-item-icon v-if="auth_user.role_id == 1000">
                  <v-tooltip top>
                    <template v-slot:activator="{on}">
                      <v-btn v-on="on" color="red" icon small @click.stop="deleteItem(rate)">
                        <v-icon size="18">mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span class="caption">Удалить предложение</span>
                  </v-tooltip>
                </v-list-item-icon>


                <v-list-item-icon v-else-if="auth_user.role_id == 101 && auth_user.id == item.user_id" class="v-list-q">
                  <b>{{ rate.user.company_name }}</b><br>
                  <template v-if="rate.block==true">
                    <v-btn color="red">
                      Поставщик заблокирован
                    </v-btn>
                  </template>
                  <template v-else="">
                    <v-btn v-on="on" color="red" @click.stop="blockItem(rate)">
                      Заблокировать Поставщика
                    </v-btn>
                  </template>
                </v-list-item-icon>
                <v-list-item-icon v-else="">
                  
                </v-list-item-icon>



              </v-list-item>
            </v-list>
          </v-card>
        </FieldAccess>
      </template>
    </v-list>







    <v-dialog v-model="confirm_dialog" scrollable persistent max-width="420">
      <v-card>
        <v-card-title>
          Принять предложение
        </v-card-title>
        <v-card-text>
          <v-list color="#fafafa">
            <v-list-item v-if="item.rate != undefined">
              <v-list-item-content>
                <p class="grey--text font-weight-regular mb-2 mt-0"
                   v-html="item.status == 1 ? 'Текущее <br/>предложение' : 'Итоговое <br/>предложение' "></p>
                <v-list-item-title class="display-2 success--text mb-2 font-weight-medium">{{ formatPrice(item.price) }}
                  ₽/{{ item.unit }}
                </v-list-item-title>
                <a href="#" class="blue--text font-weight-medium mb-2"
                   style="text-decoration: underline;">{{ item.rate.user.company_name }}</a>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="confirm_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="confirmRate" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>





    <v-dialog v-model="cancel_dialog" scrollable persistent max-width="420">
      <v-card>
        <v-card-title>
          Отменить предложение
        </v-card-title>
        <v-card-text>
          <v-list color="#fafafa">
            <v-list-item v-if="item.rate != undefined">
              <v-list-item-content>
                <p class="grey--text font-weight-regular mb-2 mt-0"
                   v-html="item.status == 1 ? 'Текущее <br/>предложение' : 'Итоговое <br/>предложение' "></p>
                <v-list-item-title class="display-2 success--text mb-2 font-weight-medium">{{ formatPrice(item.price) }}
                  ₽
                </v-list-item-title>
                <a href="#" class="blue--text font-weight-medium mb-2"
                   style="text-decoration: underline;">{{ item.rate.user.company_name }}</a>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="cancel_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="cancelRate" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>









    <v-dialog v-model="dialog" scrollable persistent max-width="420">
      <v-form @submit.prevent="addRate" v-model="valid" ref="ref">
        <v-card>
          <v-card-title>
            Новое предложение
          </v-card-title>
          <v-card-text style="max-height: 70vh;">

            <p>Выберете препарат</p>
             <vue-select
                label=""
                :options="title_names"
                class="vueSelect"
                required
                v-model="newRate.title_name"
            >
            </vue-select>

            <v-text-field
                :label="'Ваше предложение (₽ за '+item.unit+')'"
                v-model="newRate.value"
                filled
                required
                :rules="rateRules"
                :prepend-icon="item.type == 'rise' ? 'mdi-transfer-up' : 'mdi-transfer-down' "
                @input="errorRate = false"
                :error="errorRate"
                :messages="[errorText]"
                :persistent-hint="errorRate"
            >
            </v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey darken-3" text @click.stop="dialog = false">Отменить</v-btn>
            <v-btn color="grey darken-3" text type="submit" :loading="loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>



    <!-- Окно предложить аналог-->
    <v-dialog v-model="dialog_analog" scrollable persistent max-width="420">
      <v-form @submit.prevent="addRateAnalog" v-model="valid" ref="ref">
        <v-card>
          <v-card-title>
            Новое предложение (аналог)

            
          </v-card-title>
          <v-card-text style="max-height: 70vh;">
            <v-text-field
                :label="'Ваше предложение (₽ за '+item.unit+')'"
                v-model="newRateAnalog.value"
                filled
                required
                :rules="rateRules"
                :prepend-icon="item.type == 'rise' ? 'mdi-transfer-up' : 'mdi-transfer-down' "
                @input="errorRate = false"
                :error="errorRate"
                :messages="[errorText]"
                :persistent-hint="errorRate"
            >
            </v-text-field>
        
            <p>Поиск аналога из списка</p>
            <vue-select
                :label="Аналог"
                :options="title_options"
                class="vueSelect"
                required
                v-model="newRateAnalog.analog_name"
            >
            </vue-select>
           
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey darken-3" text @click.stop="dialog_analog = false">Отменить</v-btn>
            <v-btn color="grey darken-3" text type="submit" :loading="loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>

    <v-dialog v-model="delete_dialog" scrollable persistent max-width="420">
      <v-card>
        <v-card-title>
          Удалить предложение
        </v-card-title>
        <v-card-text style="max-height: 70vh;">
          Вы действительно хотите убрать предложение от продавца.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="delete_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="submitDelete" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-dialog v-model="block_dialog" scrollable persistent max-width="420">
      <v-card>
        <v-card-title>
          Заблокировать поставщика
          {{ block_item.user != null && block_item.user != 'underfined' ? block_item.user.company_name : '' }}
        </v-card-title>
        <v-card-text style="max-height: 70vh;">
          Вы действительно хотите заблокировать поставщика.
        </v-card-text>

        <!--        <v-card-text style="max-height: 70vh;">-->
        <!--          Напишите причину блокировки.-->
        <!--        </v-card-text>-->
        <v-textarea
            solo
            flat
            dense
            placeholder="Напишите причину блокировки"
            v-model="block_item.description"
            auto-grow
            class="q-textarea-bordered"
        ></v-textarea>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="block_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="submitBlock" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>
<style>
.q-textarea-bordered .v-text-field__slot {
  padding: 0px !important;
  margin: 0px !important;
}
.q-textarea-bordered textarea {
  padding: 5px 15px !important;
  border: 1px solid #66666687;
}
.v-list-q {
  display: block !important;
  text-align: right !important;
}
.v-list-q .v-btn {
  font-size: 11px !important;
  padding: 5px 10px !important;
  color: #fff !important;
}
</style>
<script>

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  data() {
    return {
    title_options: [],
    title_names: ['2,4-Дактив, КЭ', 'Абакус Прайм, СЭ'],
    dialog: false,
    dialog_analog: false,
    block_dialog: false,
    loading: false,
    newRate: {value: null, title_name: null},
    newRateAnalog: {value: null},
    history_dialog: false,
    valid: false,
    rateRules: [
      v => !!v || 'Введите ставку',
    ],
    errorRate: false,
    errorText: '',
    block_arr: '',
    cancel_dialog: false,
    confirm_dialog: false,
    selected: {},
    block_item: {
      'description': '',
    },
    delete_dialog: false,
  }
  },
  props: {
    item: Object,
    vselect_titles: Object,
    vselect_titles2: Object,
    block_subliers_user: Object
  },
  components: {
    FieldAccess,
    FieldAccessButton,
  },
  computed: {
    auth_user: {
      get() {
        return this.$store.state.auth_user
      }
    },
  },
  created() {
  },
  mounted() {
    let app = this;
    axios.get('/admin/auction/blocked/').then(function (response) {
      //console.log(response);
      //console.log(response.data.block_arr);
      app.block_arr = response.data.block_arr
      //console.log(app.block_arr);
    }).catch(function (error) {
    })
    // загрузка всех аналогов с сервера
    //this.getTitleOptions();
    //this.getAnalogOptions();
    this.getDvOptions();
  },
  methods: {
    //получить все опции препаратов по дв 060423
    getDvOptions() {
      let active_material = this.item.active_material;      
        if (active_material !== undefined) {
        axios.post('/admin/configer/dv_drugs', { active_material: active_material }).then(res => {
        if (res.data.drugs !== undefined) {
          this.title_names = res.data.drugs
        }
       })
      }
    },
    submitBlock() {
      let app = this;
      this.loading = true
      this.download_loading = true
      axios.post('/admin/block-user/', this.block_item).then(function (response) {
        app.loading = false
        app.download_loading = false
        app.block_dialog = false;
        let params = {}
        params.id = app.item.id
        params._lang = 'ru'
        params.user_id = app.auth_user.id
        app.$store.dispatch('GET_AUCTION', params).then(res => {
          //console.log('test');
        }).finally(() => (app.loading = false))
      }).catch(function (error) {
        app.loading = false
        app.download_loading = false
        app.block_dialog = false;
      })

    },
    submitDelete() {
      this.loading = true
      this.$store.dispatch('DELETE_AUCTION_RATE', this.selected).then(res => {
        this.$emit('refresh')
        this.delete_dialog = false
      })
          .finally(() => (this.loading = false))
    },
    deleteItem(item) {
      this.selected = Object.assign({}, item)
      this.delete_dialog = true
    },
    blockItem(item) {
      this.block_item = Object.assign({}, item)
      this.block_dialog = true
    },
    confirmRate() {
      this.loading = true
      this.$store.dispatch('CONFIRM_AUCTION_RATE', this.item).then(res => {
        this.$emit('refresh')
        this.confirm_dialog = false
      })
          .finally(() => (this.loading = false))
    },
    cancelRate() {
      this.loading = true
      this.$store.dispatch('CANCEL_AUCTION_RATE', this.item).then(res => {
        this.$emit('refresh')
        this.cancel_dialog = false
      })
          .finally(() => (this.loading = false))
    },
    setRate() {
      this.dialog = true
    },
    // получить все опции аналогов old
    /*getTitleOptions() {
      axios
          .get("/admin/auction/get_title_options")
          .then(response => {
            let obj = response.data;
            let newarr = [];
             for (let option of obj) {
                newarr.push(option.title)
              }   
              this.title_options = newarr;
          })
    },*/
    //получить все опции аналогов 141022
    /*getAnalogOptions() {
      let title = this.item.title;      
        if (title !== undefined) {
        axios.post('/admin/configer/analog_drugs', { title: title}).then(res => {
        if (res.data.drugs !== undefined) {
          this.title_options = res.data.drugs
        }
       })
      }
    },*/
    setRateAnalog() {  
      if (this.item.exclude_analogs != 'underfined' && this.item.exclude_analogs != undefined && this.item.exclude_analogs != null) {
        this.title_options = this.title_options.filter(item => !this.item.exclude_analogs.includes(item))
      }
      this.dialog_analog = true
    },
    addRate() {
      if (this.valid == true && this.newRate.value > 0) {  
        if (this.item.type == 'rise' && this.newRate.value <= this.item.price) {
          this.errorText = 'Ваше ставка должна превышать ' + this.formatPrice(this.item.price) + ''
          this.errorRate = true
          return false
        }
        if (this.item.type == 'drop' || this.item.type == 'dropdv') {

          if (this.newRate.title_name === null && this.item.type == 'dropdv') {
            this.errorText = 'Препарат не выбран'
            this.errorRate = true
            return false
          }

          if (this.item.price == null) {
            if (this.newRate.value <= 0) {
              this.errorText = 'Предложите цену выше 0'
              this.errorRate = true
              return false
            }
          } else {
            if (this.newRate.value >= this.item.price) {
              this.errorText = 'Предложите цену ниже текущей ' + this.formatPrice(this.item.price) + ''
              this.errorRate = true
              return false
            }
          }
        }
        this.newRate.user_id = this.auth_user.id
        this.newRate.auction_id = this.item.id
        this.loading = true
        this.$store.dispatch('ADD_AUCTION_RATE', this.newRate).then(res => {
          this.dialog = false
          this.errorRate = false
          this.errorText = ''
          this.newRate = {}
          this.$emit('refresh')
        })
            .finally(() => (this.loading = false))
      }
    },
    addRateAnalog() {
      if (this.valid == true && this.newRateAnalog.value > 0) {
        if (this.item.price == null) {
          if (this.newRateAnalog.value <= 0) {
            this.errorText = 'Предложите цену выше 0'
            this.errorRate = true
            return false
          }
        }
        this.newRateAnalog.user_id = this.auth_user.id
        this.newRateAnalog.auction_id = this.item.id
        this.loading = true
        this.$store.dispatch('ADD_AUCTION_RATE_ANALOG', this.newRateAnalog).then(res => {
          this.dialog_analog = false
          this.errorRate = false
          this.errorText = ''
          this.newRateAnalog = {}
          this.$emit('refresh')
        })
            .finally(() => (this.loading = false))
      }
    },
    openCard() {
      location.href = '/admin/auction/now/card/' + this.item.id
    },
    formatDate(date) {
      if (!date) {
        return
      } else {
        const [year, month, day] = date.split('-')
        return day + '/' + month + '/' + year
      }
    },
    formatPrice(value) {
      if (!value) return ''
      let val = (value / 1).toFixed(0)
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
  },
  watch: {
    item: function (val) {
    },
  }  
};
</script>
