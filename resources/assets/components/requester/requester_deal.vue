<template>
    <v-card color="transparent" flat>
      <v-card color="transparent" flat class="mb-2">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            <FieldAccess model="requester" field="deal" :field_name="__('requester.deal')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('requester.deal')"></h4></v-list-item-content>
                <v-list-item-icon v-if="accessData.canEdit">
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>
            <v-divider class="my-0"></v-divider>
            <template v-if="requester.is_deal > 0">
              <v-list-item three-line class="cardform-list-item py-4">
                <v-list-item-icon class="my-auto"><v-icon>mdi-phone-outgoing</v-icon></v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title class="title green--text" v-html="deal_options.find(el => el.value == item.is_deal).text"></v-list-item-title>
                  <v-list-item-subtitle class="title" v-html="formatDate(item.deal_date)"></v-list-item-subtitle>
                  <v-list-item-subtitle class="title" v-html="item.deal_time"></v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
            </template>
            <template>
              <FieldAccess model="is_deal" field="false" :field_name="__('requester.is_deal')" v-slot="{ accessData }" >
                <v-list-item class="cardform-list-item pr-1 pt-4">
                  <v-list-item-content>
                    <v-list-item-title>
                      <v-btn block color="primary" dark depressed class="rounded-btn" @click.stop="dialog = true">
                        <v-icon left>mdi-shuffle-variant</v-icon>
                        <span v-html="item.is_deal > 0 ? __('buttons.rule_deal'): __('buttons.set_deal')"></span>
                      </v-btn>
                    </v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 my-auto">
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
            </template>
          </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card color="rgb(250, 250, 250)">
          <v-card-title class="py-4">Дело</v-card-title>
          <v-card-text>
            <v-select
              :items="deal_options"
              item-text="text"
              item-value="value"
              v-model="item.is_deal"
              label="Действие"
              solo
              flat
              dense
            ></v-select>
            <v-text-field
              label="Дата"
              v-model="item.deal_date"
              type="date"
              solo
              flat
              dense
            ></v-text-field>
            <v-text-field
              label="Время"
              v-model="item.deal_time"
              type="time"
              solo
              flat
              dense
            ></v-text-field>
          </v-card-text>     
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" small text @click.stop="dialog = false">Отмена</v-btn>
            <v-btn color="primary" small text @click.stop="submitEdit" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>  
        </v-card>
      </v-dialog>
    </v-card>
</template>
<script> 
import tabledialog from '../tabledialog'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'

export default {
  name: 'orderer_relationships',
  data () {
    return {
      dialog: false,
      deal_options: [
        { text: 'Позвонить', value: 1 },
        { text: 'Тест', value: 2 },
      ],
      action_loading: false,
    }
  },
  props: {
    user_id: Number,
    item: Object,
  },
  components: { FieldAccess, FieldAccessButton, FieldAccessReloginButton, tabledialog },
  mounted() {
    this.item = Object.assign({}, this.requester)
    this.item.is_deal = Number(this.requester.is_deal)
    this.getItems()
  },
  methods: {
    deleteUser() {
      this.item.user = null
      this.item.user_id = null
      this.$emit('submit', this.item)
    },
    deleteDirectoryFirm() {
      this.item.directory_firm = null
      this.item.directory_firm_id = null
      this.item.additional_place = null
      this.item.additional_place_id = null
      this.$emit('submit', this.item)
    },
    deleteDirectoryPerson() {
      this.item.directory_person = null
      this.item.directory_person_id = null
      this.$emit('submit', this.item)
    },
    editItem (text, val, items, headers, options) {
      let field = { text: text, val: val, items: items, headers: headers, options: options }
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      this.dialog = false
      this.$emit('submit', this.item)
      /*this.$store.dispatch('EDIT_ORDERER', this.item).then(res => {
        if (this.item_id > 0) { this.$emit('refresh'); this.dialog = false; }
        else { location.href = '/admin/orderer/now/card/'+res.orderer.id }
      })*/
    },
    getItems() {
      this.$store.dispatch('GET_CUSTOMERS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_FIRMS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_COMPANY_USERS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_ORDERER_ADDITIONAL_PLACES', { user_id: this.user_id, _lang: this.locale })
    },
    formatDate(val) {
      if (!val) { return ''}
      else {
        const [ year, month, day ] = val.split('-')
        return day+'/'+month+'/'+year
      }
    }
  },
  watch: {
    requester: function (val) {
      this.item = Object.assign({}, val)
      this.item.is_deal = Number(val.is_deal)
    },
  },
  computed: {
    customer_headers: {
      get() { return this.$store.state.customers.table_headers }
    },
    customers: {
      get() { return this.$store.state.customers.items }
    },
    directory_firm_headers: {
      get() { return this.$store.state.directory_firms.table_headers }
    },
    directory_firms: {
      get() { return this.$store.state.directory_firms.items }
    },
    directory_person_headers: {
      get() { return this.$store.state.directory_people.table_headers }
    },
    directory_people: {
      get() { return this.$store.state.directory_people.items }
    },
    requester: {
      get() { return this.$store.state.requester.item },
      set(val) { this.$store.state.requester.item = val }
    },
    orderer_additional_places: {
      get() { return this.$store.state.orderers.additional_places },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val },
    },
    locale: {
      get() { return this.$store.state.lang.lang }
    },
    company_users: {
      get() { return this.$store.state.configer_users.company_users },
      set(val) { this.$store.state.configer_users.company_users = val },
    },
    company_user_headers: {
      get() { return this.$store.state.configer_users.company_user_headers },
      set(val) { this.$store.state.configer_users.company_user_headers = val },
    },
  },
};



</script>
