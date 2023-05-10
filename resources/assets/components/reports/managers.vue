<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <Alert :user_id="user_id"/>
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
                  dense
                  v-model="filter.date_from"
                  type="date"
                ></v-text-field>
              </v-flex>
              <v-flex md4 xs12>
                <v-text-field
                  hide-details
                  solo
                  flat
                  dense
                  v-model="filter.date_to"
                  type="date"
                ></v-text-field>
              </v-flex>
              <v-flex md2 xs12>
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
                  required
                  dense
                ></v-select>
              </v-flex>
              <v-flex md2 xs12 class="text-right">
                <v-btn 
                  color="success"
                  v-html="'Сформировать'"
                  :loading="loading"
                  @click.stop="getItems"
                  :disabled="loading"
                ></v-btn>
              </v-flex>
            </v-layout>
          </v-container>
          <v-divider class="my-0"></v-divider>
          <v-data-table
            :items="items"
            :headers="headers"
            :search="search"
            color="transparent"
            :mobile-breakpoint="100"
            :locale="$vuetify.lang.current"
            :loading="loading"
            :sort-by="['opc_code']"
            :expanded.sync="expanded"
            :items-per-page="-1"
            hide-default-footer
          >
            <template v-slot:item="{ item }">
              <tr class="table-row">
                <td class="px-2 text-center">
                  <span class="caption">{{item.user_id}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.requesters_count}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.cancel_count}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.cancel_percent}}%</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.deal_count}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.deal_percent}}%</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.waiting_count}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{item.waiting_percent}}%</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{formatPrice(item.pays_amount)}}</span>
                </td>
                <td class="px-2">
                  <span class="caption">{{formatPrice(item.total_amount)}}</span>
                </td>
              </tr>
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
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import snackbar from '../snackbar'
import Alert from '../snippets/Alert'

export default {
  name: 'managers_report',
  data () {
    return {
      search: '',
      loading: false,
      role_id: 102,
      expanded: [],
      filter: {
        date_from: '',
        date_to: '',
      },
      subdivision: {},
      headers: [
        { id: 1, text: '№ КМ', value: 'user_id', width: 80, class: 'px-2', align: 'center' },
        { id: 2, text: 'Презентаций', value: 'requesters_count', width: 90, class: 'px-2'  },
        { id: 3, text: 'Отказы', value: 'cancel_count', width: 110, class: 'px-2' },
        { id: 4, text: '% отказов', value: 'cancel_percent', width: 140, class: 'px-2' },
        { id: 5, text: 'Сделок', value: 'deal_count', width: 110, class: 'px-2' },
        { id: 6, text: '% сделок', value: 'deal_percent', width: 120, class: 'px-2' },
        { id: 7, text: 'В ожидании', value: 'waiting_count', width: 100, class: 'px-2'  },
        { id: 8, text: '% в ожидании', value: 'waiting_percent', width: 110, class: 'px-2' },
        { id: 9, text: 'Оплаты', value: 'pays_amount', width: 120, class: 'px-2' },
        { id: 10, text: 'Общая сумма', value: 'total_amount', width: 130, class: 'px-2' },
      ],
    }
  },
  props: {
    user_id: Number,
  },
  components: { FieldAccess, FieldAccessButton, AdminPanel, snackbar, Alert },
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
    this.getSubdivisions()
  },
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS').then(res => {
        this.subdivision = this.subdivisions.find(el => el.id == this.auth_user.subdivision_id)
      })
    },
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    goTo(val) {
      location.href = val;
    },
    getItems() {
      this.loading = true
      let params = this.filter
      params.user_id = this.user_id
      params.subdivision_id = this.subdivision.id
      this.$store.dispatch('GET_MANAGERS_REPORT', params).then(res => {
      })
      .finally(() => (this.loading = false))
    },
    formatPrice(value) {
      let val = (value/1).toFixed(2)
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
  },
  watch: {
    auth_user(val) {
      this.subdivision = this.subdivisions.find(el => el.id == val.subdivision_id)
    },
    subdivision(val) {
      if (val != undefined) this.getItems()
    },
    locale: function (val) {
      this.getItems()
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    items: {
      get() { return this.$store.state.report.items },
      set(val) { this.$store.state.report.items = val }
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
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