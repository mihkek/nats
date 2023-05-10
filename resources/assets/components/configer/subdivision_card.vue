<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md6>
        <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('subdivision.card_title')"></h4></v-list-item-content>
                </v-list-item>  

                <FieldAccess model="subdivision" field="full_name" :field_name="__('subdivision.full_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.full_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.full_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.full_name'), val: 'full_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="name" :field_name="__('subdivision.name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.name'), val: 'name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="city_id" :field_name="__('subdivision.city')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('subdivision.city')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.city_id != null">{{cities.find(el => el.id == item.city_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.city'), val: 'city_id', type: 'select', options: cities })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="legal_address" :field_name="__('subdivision.legal_address')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.legal_address')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.legal_address}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.legal_address'), val: 'legal_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="physical_address" :field_name="__('subdivision.physical_address')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.physical_address')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.physical_address}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.physical_address'), val: 'physical_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="inn" :field_name="__('subdivision.inn')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.inn')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.inn}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.inn'), val: 'inn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="kpp" :field_name="__('subdivision.kpp')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.kpp')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.kpp}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.kpp'), val: 'kpp', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="ogrn" :field_name="__('subdivision.ogrn')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.ogrn')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.ogrn}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.ogrn'), val: 'ogrn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="checking_account" :field_name="__('subdivision.checking_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.checking_account')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.checking_account}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.checking_account'), val: 'checking_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="correspondence_account" :field_name="__('subdivision.correspondence_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.correspondence_account')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.correspondence_account}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.correspondence_account'), val: 'correspondence_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="subdivision" field="bik" :field_name="__('subdivision.bik')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('subdivision.bik')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.bik}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('subdivision.bik'), val: 'bik', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
      </v-flex>
    </v-layout>
    <v-divider class="d-flex d-md-none"></v-divider>
    <v-layout v-if="item.id > 0">
      <v-flex xs12>
        <subdivision_tabs :item="item" :auth_user="auth_user"/>
      </v-flex>
    </v-layout>
  </v-container>
  <snackbar />
  <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import editdialog from '../editdialog'
import subdivision_tabs from './subdivision_tabs'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'

export default {
  name: 'subdivision_card',
  data () {
    return {
      item: {},
      dialog: false,
      pass_dialog: false,
      pass: null,
      confirm_pass: null,
      show_pass: false,
      show_confirm_pass: false,
      valid: false,
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      flag: false,
      new_flag: false,
      phone_rules: [
        v => !!v || __('forms.required_field'),
      ],
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      email_rules: [
        v => !!v || __('forms.required_field'),
        v => /.+@.+/.test(v) || __('forms.email_error'),
      ],
    }
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  components: {TheMask, snackbar, FieldAccess, FieldAccessButton, editdialog, subdivision_tabs, AdminPanel},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.getCities()
    this.getItem()
  },
  created() {
    var vm = this
    window.onbeforeunload = 
        function (ev) {
            if (vm.new_flag == true) {
              var is_asked = true;
              var e = ev || window.event;
              window.focus(is_asked);
              if (is_asked) {
                  is_asked = false;
                  var showstr = "CUSTOM_MESSAGE";
                  if (e) { //for ie and firefox
                      e.returnValue = showstr;
                  }
                  return showstr; //for safari and chrome
              }
            }
        };
  },
  methods: {
    getCities() {
      this.$store.dispatch('GET_CITIES')
    },
    checkPassConfirm() {
      if (this.confirm_pass != null) {
        if (this.pass != this.confirm_pass) { this.flag = true }
        else { this.flag = false }
      }
    },
    submitPass() {
      this.loading = true
      this.item.password = this.pass
      this.$store.dispatch('EDIT_USER_PASS', this.item).then(res => { this.getItem() })
    },
    goTo(val) {
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      if (this.new == true) { this.new_flag = true }
      if (this.checkFields()) {
        this.new_flag = false
        this.loading = true
        if (this.item.field.type != 'file') {
          this.item._lang = this.locale
          this.$store.dispatch('EDIT_CONFIGER_SUBDIVISION', this.item ).then(res => { 
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/configer/subdivisions/card/'+res.subdivision.id }
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
        else {
        }
      }
      else {
        this.subdivision = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.name == undefined) { flag = false }
        if (this.item.full_name == undefined) { flag = false }
        if (this.item.legal_address == undefined) { flag = false }
        if (this.item.physical_address == undefined) { flag = false }
        if (this.item.inn == undefined) { flag = false }
        if (this.item.city_id == undefined) { flag = false }
        if (this.item.kpp == undefined) { flag = false }
        if (this.item.ogrn == undefined) { flag = false }
        if (this.item.checking_account == undefined) { flag = false }
        if (this.item.correspondence_account == undefined) { flag = false }
        if (this.item.bik == undefined) { flag = false }
        return flag
      }
      else {
        return true
      }
    },
    getItem() {
      if (this.item_id > 0) {
        this.$store.dispatch('GET_CONFIGER_SUBDIVISION', { id: this.item_id, _lang: this.locale }).then(res => { this.dialog = false; })
        .finally(() => (this.loading = false))
      }
      else {
        this.loading = false
      }
    },
    maskedPhone(val) {
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
    },
    subdivision: function (val) {
      this.item = Object.assign({}, val)
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.subdivision)
      }
    },
    locale: function (val) {
      this.loading = true
      this.$store.dispatch('GET_CUSTOMER_USERS', { user_id: this.user_id, '_lang': val})
      this.getItem()
    },
  },
  computed: {
    cities: {
      get() { return this.$store.state.cities }
    },
    subdivision: {
      get() { return this.$store.state.configer_subdivisions.item },
      set(val) { this.$store.state.configer_subdivisions.item = val }
    },
    cities: {
      get() { return this.$store.state.cities }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
};
</script>

<style>
  
</style>