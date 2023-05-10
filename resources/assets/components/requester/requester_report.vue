<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md9>
        <v-data-table
          :items="report.items"
          :headers="headers"
          :search="search"
          color="transparent"
          :mobile-breakpoint="100"
          :locale="$vuetify.lang.current"
          :loading="loading"
          class="rounded-card"
          calculate-widths
        >
        	<template v-slot:item.promoter.code_opc="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-list-item class="px-0" v-on="on">
                  <v-list-item-title class="caption" v-if="item.promoter != null">
                    <a class="indigo--text font-weight-bold">{{item.promoter.code_opc}}</a>
                  </v-list-item-title>
                </v-list-item>
              </template>
              <span class="caption">{{item.promoter.full_name}}</span>
            </v-tooltip> 
          </template>
        </v-data-table>
      </v-flex>
      <v-flex md3>
        <v-card class="rounded-lg" flat color="#fafafa">
          <v-card-title>Фильтр</v-card-title>
          <v-card-text class="pa-4">
            <v-text-field
              label="Date From"
              v-model="date_from"
              type="date"
              solo
              flat
              dense
            ></v-text-field>

            <v-text-field
              label="Date To"
              v-model="date_to"
              type="date"
              solo
              flat
              dense
            ></v-text-field>

          </v-card-text>
          <v-card-actions class="pa-4">
            <v-btn color="indigo" dark class="rounded-lg" @click.stop="getItems" :loading="loading" block>Применить</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
  <snackbar />
</v-app>
</template>

<script> 
import {TheMask} from 'vue-the-mask'
import { dateParsed, dateVerbal, getDateTimeFromTimestamp, getTimestampFromDate } from '../../js/utils'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import snackbar from '../snackbar'

export default {
  name: 'requester_report',
  data () {
    return {
      date_from: '',
      date_to: '',
      headers: [
        { text: 'ОРС', value: 'promoter.code_opc' },
        { text: 'Количество лидов', value: 'qnt' },
        { text: 'Количество ложных', value: 'false' },
        { text: 'Количество отказов', value: 'cancel' },
        { text: '% пришедших', value: 'successfull_percent' },
        { text: '% ложных', value: 'false_percent' },
        { text: '% отказа', value: 'cancel_percent' },
      ],
      expanded: [],
    }
  },
  props: {
    user_id: Number,
  },
  components: {TheMask, FieldAccess, FieldAccessButton, AdminPanel, snackbar},
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
  },
  methods: {
    getItems(status) {
      let params = { user_id: this.$props.user_id }
      params._lang = this.locale
      params.date_from = this.date_from
      params.date_to = this.date_to
      this.loading = true
      this.$store.dispatch('GET_REQUESTER_REPORT', params).then(res => { this.loading = false; })
      .catch(error => { this.loading = false })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7('+val[1]+val[2]+val[3]+')'+val[4]+val[5]+val[6]+'-'+val[7]+val[8]+'-'+val[9]+val[10] }
      else { return val }
    },
    formatDateTime(val) {
      if (!val) return null
      const [date, time] = val.split(' ')
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year} ${time}`
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
  },
  watch: {
    locale: function(val) {
      this.loading = true
      this.getItems()
    },
    auth_user: function(val) {
      this.loading = true
      this.getItems()
    },
    report(val) {
      if (val.date_from != null) this.date_from = val.date_from
      if (val.date_from != null) this.date_to = val.date_to
    }
  },
  computed: {
    report: {
      get() { return this.$store.state.requester.report },
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    status_options: {
      get() { return this.$store.state.requester.status_options },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val } 
    },
    locale: {
      get() { return this.$store.state.lang.lang } 
    }
  },
};
</script>

<style>
  
</style>