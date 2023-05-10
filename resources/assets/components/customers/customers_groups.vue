<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">

      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>

      <v-layout row wrap>
        <v-flex xs12>
          <v-card class="rounded-lg">
          <v-container fluid>
            <v-layout row wrap>
              <v-flex md4 xs12>
                <v-text-field
                  hide-details
                  solo
                  flat
                  prepend-icon="mdi-magnify"
                  v-model="search"
                  backgroundColor="#fdfdfd"
                  dense
                >
                  <template v-slot:label>
                    <span v-html="__('buttons.search_label')"></span>
                  </template>      
                </v-text-field>
              </v-flex>
              <v-flex md4 xs12>
                <v-select
                  :items="subdivisions"
                  v-model="subdivision"
                  label="Подразделение"
                  v-if="auth_user.role_id == 1000"
                  solo
                  flat
                  item-text="title"
                  return-object
                  hide-details
                  backgroundColor="#fdfdfd"
                  required
                  dense
                ></v-select>
              </v-flex>
              <v-flex md4 xs12 class="text-right">
                <v-btn color="success" class="rounded-btn" depressed href="/admin/customer/groups/new"><v-icon left>mdi-plus</v-icon>Создать группу</v-btn>
              </v-flex>
              <v-flex xs12>
                <v-card class="rounded-lg" outlined flat>
                  <v-card flat color="#fdfdfd" class="px-2 rounded-lg">
                    <v-chip-group center-active multiple v-model="status_group">
                      <v-chip 
                        v-for="(status, i) in status_options"
                        :key="i+1"
                        label
                        outlined
                        filter
                        :active-class="status.color+' '+status.color+'--text'"
                      >
                        {{ status.title }}
                      </v-chip>
                  </v-chip-group>
                  </v-card>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
          <v-data-table
            :items="items"
            :headers="headers"
            hide-default-header
            hide-default-footer
             class="rounded-lg"
            :search="search"
            color="transparent"
            :loading="loading"
            :locale="$vuetify.lang.current"
            :sort-by="['first_date']"
            :mobile-breakpoint="100"
          >
            <template v-slot:body="{ items }">
              <v-card flat color="transparent">
                <v-container fluid grid-list-lg>
                  <v-layout row wrap>
                    <v-flex lg4 md6 sm6 xs12 v-for="item in items" :key="item.id">
                      <v-card flat outlined :href="'/admin/customer/groups/card/'+item.id" style="text-decoration: none !important;" class="rounded-lg">
                        <v-card color="#fdfdfd" flat class="py-2 rounded-lg">
                        <v-card-title class="pb-4">
                          {{item.title}} 
                        </v-card-title>
                        <v-list dense subheader color="transparent">
                          <v-list-item>
                              <v-list-item-subtitle class="mb-1">Период обучения</v-list-item-subtitle>
                              <v-list-item-title class="text-right">{{formatDate(item.first_date)}} - {{formatDate(item.last_date)}}</v-list-item-title>
                          </v-list-item>
                          <v-list-item>
                              <v-list-item-subtitle class="mb-1">Следующее занятие</v-list-item-subtitle>
                              <v-list-item-title class="text-right" v-if="item.next_date != 'none'">{{formatDate(item.next_date) || '-'}}</v-list-item-title>
                              <v-list-item-title v-else class="text-right">Занятия завершены</v-list-item-title>
                          </v-list-item>
                          <v-list-item>
                              <v-list-item-subtitle class="mb-1">Количество учеников</v-list-item-subtitle>
                              <v-list-item-title class="text-right">{{item.customers_qnt || '-'}}</v-list-item-title>
                          </v-list-item>
                          <v-list-item>
                              <v-list-item-subtitle class="mb-1">Количество расторженцев</v-list-item-subtitle>
                              <v-list-item-title class="text-right">-</v-list-item-title>
                          </v-list-item>
                          <v-list-item>
                              <v-list-item-subtitle class="mb-1">Приостановившие договор</v-list-item-subtitle>
                              <v-list-item-title class="text-right">-</v-list-item-title>
                          </v-list-item>
                        </v-list>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-card flat>
                            <v-chip 
                              :color="status_options.find(el => el.id == item.status).color"
                              outlined
                              label
                              small
                              v-html="status_options.find(el => el.id == item.status).title"
                            ></v-chip>
                          </v-card>
                        </v-card-actions>
                        </v-card>
                      </v-card>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card>
            </template>
          </v-data-table>
        </v-card>
        </v-flex>
      </v-layout>

    </v-container>
    <snackbar />
  </v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'
import Alert from '../snippets/Alert'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'customers_groups',
  data () {
    return {
      loading: false,
      search: '',
      headers: [
        { value: 'title', text: 'Номер' },
      ],
      selected_status: [],
      status_group: [],
      subdivision: {},
      status_options: [
        { id: 1, title: 'Активная', color: 'green' },
        { id: 2, title: 'Обучение завершено', color: 'blue' },
        { id: 0, title: 'Рассформированая', color: 'red' },
      ],
    }
  },
  props: {
    user_id: Number,
    is_delete: Boolean,
  },
  components: {TheMask, snackbar, FieldAccess, FieldAccessButton, AdminPanel, Alert },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id}).then(res => {
      this.getSubdivisions()
    })
  },
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS').then(res => {
        this.subdivision = this.subdivisions.find(el => el.id == this.auth_user.subdivision_id)
      })
    },
    goTo(val) {
      location.href = val;
    },
    getItems() {
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        subdivision_id: this.subdivision.id
      }
      if (this.selected_status.length > 0) params.status = this.selected_status
      this.$store.dispatch('GET_CUSTOMERS_GROUPS', params ).then(res => { this.loading = false;})
      .catch(error => { this.loading = false })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    formatDate(date) {
      if (!date) { return }
      else {
        const [ year, month, day ] = date.split('-')
        return day+'/'+month+'/'+year
      }
    },
  },
  watch: {
    subdivision(val) {
      if (val != undefined) {
        this.loading = true
        this.getItems()
      }
    },
    status_group(val) {
      this.selected_status = []
      val.map(i => {
        this.selected_status.push(this.status_options[i].id)
      })
      this.getItems()
    },
    locale: function (val) {
      this.loading = true
      this.getItems()
    },
    successful: function (val) {
      this.loading = true
      this.getItems()
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    items: {
      get() { return this.$store.state.customers.groups },
      set(val) { this.$store.state.customers.groups = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
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