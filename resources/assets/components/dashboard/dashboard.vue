<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card class="rounded-lg" outlined flat>
            <v-card-title>Новые ставки</v-card-title>
            <v-card-text>
            <v-data-table
              :items="bet_items"
              :headers="headers"
              color="transparent"
              :mobile-breakpoint="100"
              :locale="$vuetify.lang.current"
              :loading="loading"
              :sort-by="['created']"
              :sort-desc="['DESC']"
              calculate-widths
            >
            </v-data-table>
            </v-card-text>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>
          <v-card class="rounded-lg" outlined flat>
            <v-card-title>Новые аукционы</v-card-title>
            <v-card-text>
            <v-data-table
              :items="items"
              :headers="headers"
              color="transparent"
              :mobile-breakpoint="100"
              :locale="$vuetify.lang.current"
              :loading="loading"
              :sort-by="['created']"
              :sort-desc="['DESC']"
              calculate-widths
            >
            </v-data-table>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-app>
</template>

<script> 
import FieldAccess from '../fieldaccess/FieldAccess'
import snackbar from '../snackbar'
import Alert from '../snippets/Alert'

export default {
  name: 'dashboard',
  data () {
    return {
      headers: [
        { text: 'Создан', value: 'created_at' },
        { text: 'Название', value: 'title' },
        { text: 'Текущая ставка', value: 'start_price' },
      ],
      loading: false,
      bet_items: [],
    }
  },
  props: {
    user_id: Number,
  },
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id}).then(res =>{
    })
  },
  components: {
    FieldAccess, Alert, snackbar
  },
  methods: {
    getItems() {
      this.loading = true
      let params = {
        now: true,
        user_id: this.user_id
      }
      this.$store.dispatch('GET_AUCTIONS', params).then(res => {
      })
      .finally(() => (this.loading = false))
    },
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    goTo(val) {
      location.href = val
    },
    actionItem(val) {
      this.selectedItem = Object.assign({}, this.next_orderer)
      this.selectedItem.action_type = val
      this.ordererdialog = true
    },
    getTodayOrders() {
      this.$store.dispatch('GET_USER_TODAY_ORDERERS', { id: this.user_id })
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    formatDateWithoutYear (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}`
    },
    formatDateTime(val) {
      return val
    },
    maskedPhone(val) {
      if (val.length == 10) {
        return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9]
      }
      else {
        return val
      }
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
    auth_user(val) {
      this.getItems()
    }
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    items: {
      get() { return this.$store.state.auction.items }
    },
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    },
    auctions: {
      get() { return this.$store.state.auction.items },
      set(val) { this.$store.state.auction.items = val }
    },
  },
};
</script>
