<template>
  <v-app id="vue_block" style="background: transparent !important;">
    <v-form v-model="valid" ref="form" @submit.prevent="submit">
      <v-card max-width="840" class="mx-auto my-12">
        <v-card flat color="transparent" class="pa-6 text-center">
          <h3 class="font-blue my-0" style="font-size: 28px; font-weight: 400;">РЕГИСТРАЦИЯ</h3>
          <span v-show="item.type != null" class="font-weight-light grey--text text--darken-1">как {{
              item.type == 'customer' ? 'покупатель' : 'поставщик'
            }}</span>
        </v-card>
        <v-card-text class="pb-0">
          <v-expand-transition>
            <v-container class="px-0 py-0" v-show="item.type == null">
              <v-layout row wrap>
                <v-flex md6 xs12 class="pa-6">
                  <v-card height="200" color="#fafafa" @click.stop="item.type = 'customer'">
                    <v-row
                        class="fill-height"
                        align="center"
                        justify="center"
                    >
                      <v-sheet flat color="transparent">
                        <v-card-text class="text-center py-2">
                          <v-icon size="80">mdi-account-tie</v-icon>
                        </v-card-text>
                        <v-card-title class="headline">
                          Покупатель
                        </v-card-title>
                      </v-sheet>
                    </v-row>
                  </v-card>
                </v-flex>
                <v-flex md6 xs12 class="pa-6">
                  <v-card height="200" color="#fafafa" @click.stop="item.type = 'supplier'">
                    <v-row
                        class="fill-height"
                        align="center"
                        justify="center"
                    >
                      <v-sheet flat color="transparent">
                        <v-card-text class="text-center py-2">
                          <v-icon size="80">mdi-truck</v-icon>
                        </v-card-text>
                        <v-card-title class="headline">
                          Поставщик
                        </v-card-title>
                      </v-sheet>
                    </v-row>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-expand-transition>

          <v-expand-transition>
            <v-container class="px-0 py-0 pb-5" v-show="item.type != null">
              <v-layout row wrap>
                <v-flex md6 xs12 class="px-4">
                  <v-subheader class="px-0">Данные о пользователе</v-subheader>
                  <v-text-field
                      :label="item.type == 'customer' ? 'Фамилия Имя Отчество *' : 'Фамилия *'"
                      required
                      filled
                      dense
                      :rules="rules"
                      v-model="item.last_name"
                  ></v-text-field>
                  <v-text-field
                      label="Имя *"
                      filled
                      dense
                      :rules=rulesswitch
                      v-model="item.first_name"
                      v-show="item.type != 'customer'"
                  ></v-text-field>

                  <v-text-field
                      label="Отчество *"
                      filled
                      dense
                      :rules=rulesswitch
                      v-model="item.middle_name"
                      v-show="item.type != 'customer'"
                  ></v-text-field>


                  <v-text-field
                      label="Email *"
                      filled
                      dense
                      :rules="email_rules"
                      v-model="item.email"
                  ></v-text-field>
                  <v-text-field
                      :label="item.type == 'customer' ? 'Мобильный телефон для SMS-подтверждения *' : 'Мобильный телефон *'"
                      filled
                      dense
                      :rules="phone_rules"
                      v-mask="'+7(###)###-##-##'"
                      v-model="item.phone"
                  ></v-text-field>
                  <!-- Проверка (подтверждение) номера телефона отключена до решения проблемы с доставкой СМС на номера МТС -->
                  <v-layout row wrap v-show="item.type != 'customer'">
                    <v-flex xs6 class="px-3 py-2">
                      <v-text-field
                          label="Код из SMS *"
                          filled
                          dense
                          :rules="sms_rules"
                          v-mask="'######'"
                          v-model="item.sms"
                          :value=item.sms
                          :disabled="!phoneValid"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs6 class="px-3 py-2">
                      <v-btn color="primary" type="button" large :loading="loading"
                             :disabled="!phoneValid || smsSent > 0" @click.stop="sendSms" class="px-3 my-1">Получить код
                      </v-btn>
                    </v-flex>

                    <span class=" px-3" v-show="smsSent <= 0 && 1 == 0" style="margin:-1em 0 1.5em 0; color:#933;"><b>Внимание, отправка кода на номера МТС временно не работает.</b> Используйте номера других мобильных операторов.</span>

                    <span class=" px-3" v-show="smsSent > 0" style="margin:-1em 0 1.5em 0;">SMS с кодом отправлено.<br>Новое можно будет отправить через {{ smsSent }} секунд</span>
                  </v-layout>
                  <!-- -->
                  <v-switch :filled="false" v-model="item.site_agree" :rules="rules" required hide-details>
                    <template v-slot:label>
                      <div>
                        Я согласен
                        <v-dialog
                            v-model="site_agree_dialog"
                            scrollable
                            max-width="720"
                            persistent
                        >
                          <template v-slot:activator="{ on }">
                            <a @click.prevent v-on="on" class="info--text">
                              с регламентом
                            </a>
                          </template>
                          <v-card color="#fafafa">
                            <v-card-title>
                              Регламент электронной торговой площадки
                              <v-spacer></v-spacer>
                              <v-btn color="grey darken-3" icon small @click.stop="site_agree_dialog = false">
                                <v-icon size="18">mdi-close</v-icon>
                              </v-btn>
                            </v-card-title>
                            <v-card-text style="max-height: 69vh" class="pa-2">
                              <reglament :usertype="item.type"/>
                            </v-card-text>
                            <v-card-actions>
                              <v-btn color="grey darken-3" text @click.stop="site_agree_dialog = false">Закрыть</v-btn>
                              <v-spacer></v-spacer>
                              <v-btn color="primary" @click.stop="site_agree">Согласиться</v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                        электронной торговой площадки
                      </div>
                    </template>
                  </v-switch>

                  <v-switch :filled="false" v-model="item.service_agree" :rules="rules" required hide-details
                            v-if="item.type == 'supplier'">
                    <template v-slot:label>
                      <div>
                        Я согласен
                        <v-dialog
                            v-model="service_agree_dialog"
                            scrollable
                            max-width="720"
                            persistent
                        >
                          <template v-slot:activator="{ on }">
                            <a @click.prevent v-on="on" class="info--text">
                              с договором оказания услуг
                            </a>
                          </template>
                          <v-card color="#fafafa">
                            <v-card-title>
                              Договор оказания услуг
                              <v-spacer></v-spacer>
                              <v-btn color="grey darken-3" icon small @click.stop="service_agree_dialog = false">
                                <v-icon size="18">mdi-close</v-icon>
                              </v-btn>
                            </v-card-title>
                            <v-card-text style="max-height: 69vh" class="pa-2">
                              <serviceagreement :usertype="item.type"/>
                            </v-card-text>
                            <v-card-actions>
                              <v-btn color="grey darken-3" text @click.stop="service_agree_dialog = false">Закрыть
                              </v-btn>
                              <v-spacer></v-spacer>
                              <v-btn color="primary" @click.stop="service_agree">Согласиться</v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                        площадки
                      </div>
                    </template>
                  </v-switch>

                  <v-switch :filled="false" v-model="item.data_agree" :rules="rules" required hide-details>
                    <template v-slot:label>
                      <div>
                        Я согласен
                        <v-dialog
                            v-model="data_agree_dialog"
                            scrollable
                            max-width="720"
                            persistent
                        >
                          <template v-slot:activator="{ on }">
                            <a @click.prevent v-on="on" class="info--text">
                              с договором на сбор
                            </a>
                          </template>
                          <v-card color="#fafafa">
                            <v-card-title>
                              Договор на сбор персональных данных
                              <v-spacer></v-spacer>
                              <v-btn color="grey darken-3" icon small @click.stop="data_agree_dialog = false">
                                <v-icon size="18">mdi-close</v-icon>
                              </v-btn>
                            </v-card-title>
                            <v-card-text style="max-height: 69vh" class="pa-2">
                              <personaldata/>
                            </v-card-text>
                            <v-card-actions>
                              <v-btn color="grey darken-3" text @click.stop="data_agree_dialog = false">Закрыть</v-btn>
                              <v-spacer></v-spacer>
                              <v-btn color="primary" text @click.stop="data_agree">Согласиться</v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                        персональных данных
                      </div>
                    </template>
                  </v-switch>

                  <!--
                                  <v-switch value input-value="true" hide-details>
                                    <template v-slot:label>
                                      <div>
                                        Хочу получать оповещения о новых торгах по электронной почте
                                      </div>
                                    </template>
                                  </v-switch>
                  -->

                  <v-switch value input-value="true" hide-details>
                    <template v-slot:label>
                      <div>
                        Хочу получать информацию об изменении ставок по торгам, в которых я принимаю участие
                      </div>
                    </template>
                  </v-switch>


                </v-flex>
                <v-flex md6 xs12 class="px-4">
                  <v-subheader class="px-0">Данные об организации</v-subheader>
                  <v-text-field
                      label="Название компании *"
                      required
                      filled
                      dense
                      :rules="rules"
                      v-model="item.company_name"
                  ></v-text-field>
                  <v-text-field
                      label="ИНН *"
                      filled
                      dense
                      required
                      :rules="rules"
                      v-model="item.company_inn"
                  ></v-text-field>

                  <v-text-field
                      label="Площадь хозяйства в Гектарах *"
                      filled
                      dense
                      v-model="item.ga"
                      v-show="item.type === 'customer'"
                  ></v-text-field>
                  <v-text-field
                      label="ОГРН/ОГРНИП *"
                      dense
                      filled
                      v-model="item.company_ogrn"
                      :rules=rulesswitch
                      v-show="item.type != 'customer'"
                  ></v-text-field>
                  <v-text-field
                      label="Рассчетный счет *"
                      dense
                      filled
                      v-model="item.company_bank_account"
                      :rules=rulesswitch
                      v-show="item.type != 'customer'"
                  ></v-text-field>
                  <v-text-field
                      label="Корреспондентский счет *"
                      dense
                      filled
                      v-model="item.company_correspondent_account"
                      :rules=rulesswitch
                      v-show="item.type != 'customer'"
                  ></v-text-field>
                  <v-text-field
                      label="БИК Банка *"
                      dense
                      filled
                      v-model="item.company_bank_bik"
                      :rules=rulesswitch
                      v-show="item.type != 'customer'"
                  ></v-text-field>

                  <v-text-field
                      label="Адрес склада компании"
                      dense
                      filled
                      v-model="item.company_warehouse_address"
                      v-show="item.type != 'customer'"
                  ></v-text-field>

                  <v-text-field
                      label="Сайт компании"
                      dense
                      filled
                      v-model="item.company_web_site"
                      v-show="item.type != 'customer'"
                  ></v-text-field>

                  <v-textarea
                      label="Описание компании"
                      dense
                      filled
                      auto-grow
                      v-model="item.company_description"
                      v-show="item.type != 'customer'"
                  ></v-textarea>

                </v-flex>
              </v-layout>
            </v-container>
          </v-expand-transition>
        </v-card-text>
        <v-card-actions class="pa-4" v-show="item.type != null">
          <v-btn color="grey darken-3" depressed outlined text large @click.stop="item.type = null" class="px-6">Назад
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" type="submit" large :loading="loading" class="px-6">Регистрация</v-btn>
        </v-card-actions>
        <v-card-actions class="pa-4" v-show="item.type == null">
          <v-btn color="blue-grey" text outlined dark block depressed large href="/login"
                 class="px-6 text-decoration-none font-weight-medium">Вернуться к авторизации
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
    <snackbar/>
  </v-app>
</template>

<script>
import snackbar from '../snackbar'
import {mask} from 'vue-the-mask'

import offert from './components/offert'
import reglament from './components/reglament'
import serviceagreement from './components/serviceagreement'
import personaldata from './components/personaldata'

export default {
  data() {
    return {
      item: {
        type: null,
        first_name: '',
        last_name: '',
        middle_name: '',
        phone: '',
        email: '',
        company_name: '',
        company_inn: '',
        company_ogrn: '',
        company_bank_account: '',
        company_correspondent_account: '',
        company_bank_bik: '',
        company_warehouse_address: '',
        company_web_site: '',
        company_description: '',
        site_agree: false,
        service_agree: false,
        data_agree: false,
        sms: false,
        smscheck: false,
        ga: null,
      },
      site_agree_dialog: false,
      service_agree_dialog: false,
      data_agree_dialog: false,
      valid: false,
      phoneValid: false,
      smsSent: 0,
      resendTimeout: false,
      rulesswitch: 'rules',
      smsCodeValid: false,

      rules: [
        v => !!v || __('forms.required_field'),
      ],
      phone_rules: [
        v => !!v || __('forms.required_field'),
        v => v.length == 16 || __('forms.phone_error'),
      ],
      email_rules: [
        v => !!v || __('forms.required_field'),
        v => /.+@.+/.test(v) || __('forms.email_error'),
      ],
      sms_rules: false,
      /* chernyshkov 20210819 */
      smsid: false,

      id: '',
      city: {},
      place: {},
      loading: false,
      step: 1,
    }
  },
  mounted() {
  },
  components: {snackbar, offert, serviceagreement, reglament, personaldata},
  methods: {
    data_agree() {
      this.item.data_agree = true
      this.data_agree_dialog = false
    },
    site_agree() {
      this.item.site_agree = true
      this.site_agree_dialog = false
    },
    service_agree() {
      this.item.service_agree = true
      this.service_agree_dialog = false
    },
    getCities() {
      this.$store.dispatch('GET_CITIES').then(res => {
        this.city = this.cities[0]
      })
    },
    sendSms() {
      this.smsSent = 90
      this.smstimeout()
      let params = {}
      params.phone = this.item.phone
      axios.post('/auth/get_smscode', params).then(res => {
        console.log(res.data);
        if (res.data.status == 1) {
          this.item.smscheck = res.data.smscheck
          /* chernyshkov 20210819 */
          this.smsid = res.data.smsid
//			 console.log(res.data.response)
        } else {
          this.item.smscheck = 21
          this.item.sms = 123456
          clearTimeout(this.resendTimeout);
          this.smsSent = 0
        }
      })
          .catch(error => {
            this.item.smscheck = 21
            this.item.sms = 123456
            clearTimeout(this.resendTimeout);
            this.smsSent = 0
          })
          .finally(() => {
            this.loading = false
            this.smsCheckSumm()
          })
    },
    /* chernyshkov 20210819 */
    checkSMSStatus() { /* проверяем, действительно ли смс отправилось (на данный момент не использутеся) */
      console.log(this.smsid)
      let params = {}
      params.smsid = this.smsid
      axios.post('/auth/get_smsstatus', params).then(res => {
        console.log(this.smsSent + " " + res.data);
        if (res.data.status == 1) {
          console.log(res.data.status_code)
        } else {
        }
      })
          .catch(error => {
//		  this.item.smscheck = 21
//		  this.item.sms = 123456
//		  clearTimeout(this.resendTimeout);
//		  this.smsSent = 0
          })
          .finally(() => {
            this.loading = false
//		  this.smsCheckSumm()
          })
    },
    smstimeout() {
      if (this.smsSent > 0) this.resendTimeout = setTimeout(() => {
        this.smstimeout()
      }, 1000)
      this.smsSent = this.smsSent - 1
//		if (this.smsSent%30 == 0) this.checkSMSStatus()
    },

    smsCheckSumm() {
      var fullcode = Array.from(this.item.phone.replace(/[^0-9]/ig, "") + '' + this.item.sms)
      var checksum = 0
      while (fullcode.length > 0) {
        checksum += parseInt(fullcode.shift(), 10);
      }
//	    console.log(checksum+" "+this.item.smscheck)
      this.smsCodeValid = (checksum == this.item.smscheck)
    },
    submit() {
      if (this.valid) {
        this.loading = true
        if (this.item.type == 'customer') {
          this.item.role_id = 101
        } else if (this.item.type == 'supplier') {
          this.item.role_id = 102
        }
        axios.post('/auth/register', this.item).then(res => {
          this.$store.commit('SET_SNACKBAR', res.data)
          if (res.data.status == 1) {
            this.$refs.form.reset()
            location.href = res.data.url
          }
        })
            .finally(() => (this.loading = false))
      } else {
        this.$refs.form.validate()
      }
    }
  },
  directives: {
    mask
  },
  props: {},
  watch: {
    city(val) {
      this.place = val.items[0]
    },
    'item.type'(val) {
      this.$refs.form.resetValidation()
      this.rulesswitch = this.item.type == 'customer' ? false : this.rules
      this.sms_rules = this.item.type == 'customer' ? false : [
        v => !!v || __('forms.required_field'),
        v => v.length == 6 || 'Код состоит из 6 символов',
        v => this.smsCodeValid || 'Не совпадает с последним отправленным',
      ]
    },
    'item.phone'(val) {
      if (val.length == 16) this.phoneValid = true
      else this.phoneValid = false
    },
    'item.sms'(val) {
      this.smsCheckSumm()
    },
  },
  computed: {
    cities: {
      get() {
        return this.$store.state.cities
      }
    },
    array: {
      get() {
        let array = []
        let i = 1;
        while (i <= 100) {
          array.push(i)
          i++;
        }
        return array
      }
    }
  },
};
</script>

<style>
.v-input__control .v-input__slot {
  border: none !important;
  border-radius: 0 !important;
}

.v-input--switch__thumb {
  border-radius: 50% !important;
}
</style>
