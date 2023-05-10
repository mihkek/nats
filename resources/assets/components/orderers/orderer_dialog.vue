<template>
    <v-card color="#fff" >
      <v-form v-model="valid">
          <template v-if="item.action_val == 'confirm'">
            <v-card-title primary-title class="mb-1" v-html="__('orderer.confirm_lesson')"></v-card-title>
            <v-card-subtitle class="caption" v-html="__('orderer.confirm_lesson_description')"></v-card-subtitle>
            <v-card-text>
              <template v-if="item.subscriptions.length > 0">
                <template v-for="subscription in item.subscriptions">
                <v-list-item @click.stop="toogleSubscription(subscription)" :key="subscription.id">
                  <v-list-item-icon><v-icon v-html="subscription.is_on == 1 ? 'mdi-check-box-outline' :  'mdi-checkbox-blank-outline'" :color="subscription.is_on == 1 ? 'green' :  'grey'"></v-icon></v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-subtitle class="green--text">Активный абонемент</v-list-item-subtitle>
                    <v-list-item-title>
                      Завершить занятие по абонементу
                    </v-list-item-title>
                    <v-list-item-subtitle class="caption font-weight-medium">Осталось {{subscription.number_of_paid_orderers - subscription.number_of_completed_classes}} занятий</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
                </template>
                <v-divider class="mb-8 mt-0"></v-divider>
              </template>
              <template v-if="!(item.last_flag == true && item.last_toogle == 0)">

                <v-text-field
                  v-model="item.next_orderer_date"
                  type="date"
                  required
                  filled
                  :rules="rules"
                  label="Дата следующего занятия *"
                  class="mb-2"
                >
                  <template v-slot:label>
                    <span>Время следующего занятия</span><span class="red--text"> *</span>
                  </template>
                </v-text-field>

                <v-text-field
                  v-model="item.next_orderer_time"
                  required
                  :rules="rules"
                  filled
                  type="time"
                  class="mb-2"
                  label="Время"
                >
                  <template v-slot:label>
                    <span>Время следующего занятия</span><span class="red--text"> *</span>
                  </template>
                </v-text-field>

                <v-text-field
                  v-if="item.next_orderer_directory_firm != null"
                  v-model="item.new_place.full_name"
                  required
                  filled
                  :rules="rules"
                  readonly
                  class="mb-2"
                  label="Помещение для проведения следующего занятия"
                >
                  <template v-slot:label>
                    <span>Помещение для проведения следующего занятия</span><span class="red--text"> *</span>
                  </template>
                  <template v-slot:append>
                    <v-tooltip top>
                      <template v-slot:activator="{on}">
                        <v-btn color="red" icon x-small v-on="on" @click.stop="editItem(__('orderer.place'), 'new_place', directory_firms, directory_firm_headers, orderer_additional_places)"><v-icon small>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption">Изменить помещение</span>
                    </v-tooltip>
                  </template>

                </v-text-field>


              </template>
              <v-checkbox v-model="item.last_flag" v-if="item.last_flag != true || item.last_flag == true && item.last_toogle == 0">
                <template v-slot:label>
                  <span class="caption" v-html="__('orderer.is_last')"></span>
                </template>
              </v-checkbox>
              <template v-if="item.last_flag == true && item.last_toogle != 0">
                <v-card flat color="transparent" class="mb-4 my-4">
                  <v-btn-toggle v-model="item.last_toogle">
                    <v-btn small><v-icon small>mdi-check</v-icon></v-btn>
                    <v-btn small><v-icon small>mdi-cancel</v-icon></v-btn>
                  </v-btn-toggle>
                  <span class="caption grey--text text--darken-2 ml-2"><b v-html="__('orderer.confirm_last')"></b></span>
                </v-card>
              </template>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="black" small text @click.stop="$emit('close')" v-html="__('buttons.cancel')"></v-btn>
              <v-btn color="black" small text @click.stop="confirm" :loading="loading" v-html="__('buttons.submit')"></v-btn>
            </v-card-actions>         
          </template>
          <template v-else-if="item.action_val == 'transfer'">
            <v-card-title primary-title class="mb-1" v-html="__('orderer.transfer_lesson')"></v-card-title>
              <v-card-text>
                <v-text-field
                  v-model="item.transfer_reason"
                  label="Причина переноса *"
                  required
                  :rules="rules"
                  class="mb-2"
                  filled
                >
                  <template v-slot:label>
                    <span v-html="__('orderer.action_reason')"></span><span class="red--text"> *</span>
                  </template>
                </v-text-field>
                <v-textarea
                  v-model="item.transfer_comment"
                  required
                  :rules="rules"
                  class="mb-2"
                  filled
                  label="Комментарий"
                >
                  <template v-slot:label>
                    <span v-html="__('orderer.action_comment')"></span><span class="red--text"> *</span>
                  </template>
                </v-textarea>
                <v-text-field
                  filled
                  class="mb-2"
                  v-model="item.next_orderer_date"
                  type="date"
                  label="Дата"
                >
                  <template v-slot:label>
                    <span>Дата</span><span class="red--text"> *</span>
                  </template>
                </v-text-field>
                  <v-text-field
                  filled
                   v-model="item.next_orderer_time"
                    class="mb-2"
                   required
                   :rules="rules"
                    label="Время"
                   type="time"
                >
                  <template v-slot:label>
                    <span>Время</span><span class="red--text"> *</span>
                  </template>
                </v-text-field>
                <v-text-field
                  v-if="item.next_orderer_directory_firm != null"
                  v-model="item.new_place.full_name"
                  required
                    label="Помещение для проведения следующего занятия"
                    class="mb-2"
                  :rules="rules"
                  filled
                  readonly
                >
                  <template v-slot:label>
                    <span>Помещение для проведения занятия</span><span class="red--text"> *</span>
                  </template>
                  <template v-slot:append>
                    <v-tooltip top>
                      <template v-slot:activator="{on}">
                        <v-btn color="red" icon x-small v-on="on" @click.stop="editItem(__('orderer.place'), 'new_place', directory_firms, directory_firm_headers, orderer_additional_places)"><v-icon small>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption">Изменить помещение</span>
                    </v-tooltip>
                  </template>
                </v-text-field>
              </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="black" small text @click.stop="$emit('close')" v-html="__('buttons.cancel')"></v-btn>
              <v-btn color="black" small text @click.stop="transfer" :loading="loading" v-html="__('buttons.submit')"></v-btn>
            </v-card-actions>     
          </template>
          <template v-else-if="item.action_val == 'cancel'">
            <v-card-title primary-title class="mb-1" v-html="__('orderer.cancel_lesson')"></v-card-title>
            <v-card-text>
              <v-text-field
                v-model="item.cancel_reason"
                required
                :rules="rules"
                :label="__('orderer.cancel_reason')"
                class="mb-2"
                filled
              >
                <template v-slot:label>
                  <span v-html="__('orderer.cancel_reason')"></span><span class="red--text"> *</span>
                </template>
              </v-text-field>
              <v-textarea
                v-model="item.cancel_comment"
                required
                :rules="rules"
                :label="__('orderer.action_comment')"
                class="mb-2"
                filled
              >
                <template v-slot:label>
                  <span v-html="__('orderer.action_comment')"></span><span class="red--text"> *</span>
                </template>
              </v-textarea>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="black" small text @click.stop="$emit('close')" v-html="__('buttons.cancel')"></v-btn>
              <v-btn color="black" small text @click.stop="cancel" :loading="loading" v-html="__('buttons.submit')"></v-btn>
            </v-card-actions>     
          </template>
          <template v-else-if="item.action_val == 'close'">
            <v-card-title primary-title class="mb-1">Закрыть занятие</v-card-title>
            <v-card-subtitle class="caption">Завершить и оплатить занятие</v-card-subtitle>
            <v-card-text>
            <template v-if="item.subscription != null">
              <v-divider class="my-0"></v-divider>
              <v-list-item @click.stop="toogleSubscription(item)">
                <v-list-item-icon><v-icon v-html="item.subscription.is_on == 1 ? 'mdi-check-box-outline' :  'mdi-checkbox-blank-outline'" :color="item.subscription.is_on == 1 ? 'green' :  'grey'"></v-icon></v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-subtitle class="green--text">Активный абонемент</v-list-item-subtitle>
                  <v-list-item-title>
                    Завершить занятие по абонементу
                  </v-list-item-title>
                  <v-list-item-subtitle class="caption font-weight-medium">Осталось {{item.subscription.number_of_paid_orderers - item.subscription.number_of_completed_classes}} занятий</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="mb-8 mt-0"></v-divider>

            </template>
            <template v-else>
              
            </template>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" small text v-html="__('buttons.cancel')" @click.stop="$emit('close')"></v-btn>
                <v-btn color="primary" small text v-html="__('buttons.submit')" @click.stop="close"></v-btn>
              </v-card-actions>
          </template>
        </v-form>
        <v-dialog v-model="dialog" width="95%"><tabledialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
      </v-card>
</template>

<script> 
import { mask } from 'vue-the-mask'
import tabledialog from '../tabledialog'


export default {
  name: 'orderer_dialog',
  data () {
    return {
      loading: false,
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      valid: false,
      now: new Date().toISOString().substr(0, 10),
      dialog: false,
    }
  },
  components: {
    tabledialog
  },
  props: {
    item: Object,
  },
  methods: {
    submitEdit() {
      this.dialog = false
      if (this.item.new_place.full_name == undefined && this.item.new_place.title != undefined) {
        this.item.new_place.full_name = this.item.new_place.title
      }
    },
    editItem(text, val, items, headers, options) {
      let field = { text: text, val: val, items: items, headers: headers, options: options }
      this.item.field = field
      this.dialog = true
    },
    toogleSubscription(item) {
      this.item.subscriptions.map(subscription => {
        if (subscription.id == item.id) {
          if (subscription.is_on == 1) { subscription.is_on = 0 }
          else if (subscription.is_on == 0) { subscription.is_on = 1 }
        }
        else {
          subscription.is_on = 0
        }
      })
    },
    confirm() {
      if (this.item.last_flag == true && this.item.last_toogle == 0) {
        this.$store.dispatch('CONFIRM_ORDERER', this.item).then(res => { this.$emit('refresh') })
      }
      else {
        if (this.check() == true) {
          this.item.next_orderer_time = this.formatTime(this.item.next_orderer_time)
          this.item._lang = this.locale
          if (this.valid == true) { 
            this.$store.dispatch('CONFIRM_ORDERER', this.item).then(res => { 
              if (res.next_orderer_id > 0) {
                location.href = '/admin/orderer/now/card/'+res.next_orderer_id
              }
              else {
                this.$emit('refresh')
              }
            }) 
          }
        }
      }
    },
    transfer() {
      if (this.check() == true) {
        this.item.next_orderer_time = this.formatTime(this.item.next_orderer_time)
        this.item._lang = this.locale
        if (this.valid == true) { this.$store.dispatch('TRANSFER_ORDERER', this.item).then(res => { this.$emit('refresh') }) }
      }
    },
    cancel() {
      this.item._lang = this.locale
      if (this.valid == true) { this.$store.dispatch('CANCEL_ORDERER', this.item).then(res => { this.$emit('refresh') }) }
    },
    close() {
      this.item._lang = this.locale
      if (this.valid == true) { this.$store.dispatch('CLOSE_ORDERER', this.item).then(res => { this.$emit('refresh') }) }
    },
    check() {
      if (this.item.next_orderer_date >= this.now) {
        return true
      }
      else {
        let send = {
          status: 0,
          text: __('forms.date_error')
        }
        this.$store.commit('SET_SNACKBAR', send)
        this.item.next_orderer_date = ''
        return false
      }
    },
    formatTime(val) {
      if (val != undefined) { return val.slice(0,2) + ':' + val.slice(-2) }
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
  },
  mounted() {
    if (this.item.directory_firm != null) {
      let newItem = {
        option: false,
        full_name: this.item.directory_firm.full_name,
        id: this.item.directory_firm.id
      }
      this.item.new_place = newItem
    }
    else if (this.item.additional_place != null) {
      let newItem = {
        option: true,
        full_name: this.item.additional_place.title,
        id: this.item.additional_place.id
      }
      this.item.new_place = newItem
    }
    this.item.next_orderer_directory_firm = Object.assign({}, this.item)
  },
  watch: {
    'item.last_flag': function(val) {
      if (val == false) { this.item.last_toogle = null }
    },
    'item.last_toogle': function(val) {
      if (val == 1) { this.item.last_flag = false; this.item.last_toogle = null }
    },
  },
  computed: {
    locale: {
      get() { return this.$store.state.lang.lang }
    },
    directory_firm_headers: {
      get() { return this.$store.state.directory_firms.table_headers }
    },
    directory_firms: {
      get() { return this.$store.state.directory_firms.items }
    },
    orderer_additional_places: {
      get() { return this.$store.state.orderers.additional_places },
    },
  },
  directives: {  mask },
};
</script>
