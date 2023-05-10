<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">

      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>

      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card flat outlined class="my-3">
            <v-card-title>
              {{$props.new ? 'Новая группа' : 'Группа '+item.title}}
            </v-card-title>
            <v-divider class="my-0"></v-divider>
            <v-list class="py-0" color="#fdfdfd">
              <v-list-item class="pr-0">
                <v-list-item-content>
                  <v-list-item-title>Название</v-list-item-title>
                </v-list-item-content>
                <v-list-item-content>
                  <v-list-item-title class="text-right">{{item.title}}</v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                  <v-tooltip top >
                    <template v-slot:activator="{ on }">
                      <v-btn 
                        color="red darken-1" 
                        icon 
                        x-small 
                        v-on="on" 
                        class="my-icon-btn" 
                        @click.stop="editItem({ text: __('customer_group.title'), val: 'title', type: 'text' })"
                      >
                        <v-icon>mdi-sync</v-icon>
                      </v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                </v-list-item-action>
              </v-list-item>
              <FieldAccess model="customers_group" field="subdivision_id" field_name="Подразделение" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span>Подразделение</span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.subdivision_id != null">{{subdivisions.find(el => el.id == item.subdivision_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Подразделение', val: 'subdivision_id', type: 'select', options: subdivisions })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              <template v-if="item.id > 0">
                <v-divider class="my-0"></v-divider>
                  <v-list-item class="pr-0">
                    <v-list-item-content>
                      <v-list-item-title>Статус</v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-title class="text-right">
                        {{status_options.find(el => el.id == item.status).title}}
                      </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn 
                            color="red darken-1" 
                            icon 
                            x-small 
                            v-on="on" 
                            class="my-icon-btn" 
                            @click.stop="editItem({ text: __('customer_group.status'), val: 'status', type: 'select', options: status_options  })"
                          >
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-action>
                  </v-list-item>
                <FieldAccess model="customer" field="delete_group" :field_name="item.delete == 'on' ? __('buttons.restore_item') : __('buttons.delete_item') " v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' " >
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-btn :color="item.deleted == 'on' ? 'green lighten-1' : 'red lighten-1' " dark depressed class="rounded-btn" @click.stop="delete_dialog = !delete_dialog">
                          <v-icon left v-html="item.deleted == 'on' ? 'mdi-restore' : 'mdi-archive' "></v-icon> <span v-html="item.deleted == 'on' ? __('buttons.restore_item') : __('buttons.delete_item') "></span>
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
          </v-card>
          <template v-if="item_id > 0">
            <customers_group_timetable :item="item" @refresh="getItem" />
          </template>
        </v-flex>
        <v-flex md6 xs12>
          <template v-if="item_id > 0">
            <customers_group_composition :item="item" @refresh="getItem" />
          </template>
        </v-flex>
      </v-layout>
      <v-dialog v-model="dialog" max-width="420px">
        <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
      </v-dialog>
      <v-dialog v-model="delete_dialog" max-width="420px">
        <v-card>
          <v-card-title>
            {{item.deleted == 'on' ? 'Восстановить' : 'Удалить' }}
          </v-card-title>
          <v-card-text>
            Вы действительно хотите {{item.deleted == 'on' ? 'восстановить' : 'удалить' }} данную группу клиентов?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click.stop="delete_dialog = !delete_dialog">Отмена</v-btn>
            <v-btn color="primary" text @click.stop="submitDelete" :loading="loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
    <snackbar />
  </v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'
import Alert from '../snippets/Alert'
import editdialog from '../editdialog'

import customers_group_timetable from './customers_group_timetable'
import customers_group_composition from './customers_group_composition'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'


export default {
  name: 'customers_groups',
  data () {
    return {
      item: {},
      action_loading: false,
      loading: false,
      search: '',
      dialog: false,
      delete_dialog: false,
      status_options: [
        { id: 1, title: 'Активна' },
        { id: 2, title: 'Обучение завершено' },
        { id: 0, title: 'Рассформирована' },
      ],
      
    }
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  components: {TheMask, snackbar, FieldAccess, FieldAccessButton, AdminPanel, Alert, editdialog, customers_group_timetable, customers_group_composition },
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
    this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS')
    if (this.item_id > 0) {
      this.loading = true
      this.getItem()
    }
  },
  methods: {
    submitDelete() {
      this.$store.dispatch('DELETE_CUSTOMERS_GROUP', this.item).then(res => {
        this.getItem()
      })
    },
    submitEdit() {
      if (this.checkFields()) {
        this.loading = true
        this.item.user_id = this.user_id
        this.$store.dispatch('EDIT_CUSTOMERS_GROUP', this.item).then(res => {
          if (!(this.item_id > 0)) location.href = '/admin/customer/groups/card/'+res.group.id
          else this.getItem()
        })
      }
      else {
        this.group = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    goTo(val) {
      location.href = val;
    },
    getItem() {
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        id: this.item_id,
      }
      this.$store.dispatch('GET_CUSTOMERS_GROUP', params ).then(res => { 
        this.dialog = false
        this.delete_dialog = false
      })
      .finally(() => (this.loading = false))
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    checkFields() {
      let flag = true
      if (!this.item.title) flag = false
      if (!this.item.subdivision_id) flag = false
      return flag
    },
  },
  watch: {
    locale: function (val) {
      this.loading = true
      this.getItem()
    },
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.group)
      }
    },
    group: function (val) {
      this.item = Object.assign({}, val)
      if (this.item.id > 0) this.item.status = Number(val.status)
      
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    group: {
      get() { return this.$store.state.customers.group },
      set(val) { this.$store.state.customers.group = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    lang: {
      get() {
        return this.$store.state.directory_people.lang
      }
    }
  },
};
</script>

<style>
  
</style>