<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <v-layout row wrap>
        <v-flex md7>
          <tenders/>

          <dashboardsubliers/>
          <!--<auctions />-->
          <!--<rates />-->
        </v-flex>
        <v-flex md5>
          <!-- <personal />
          <support /> -->
          <reviews/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-divider class="my-0"></v-divider>
    <ads/>
    <snackbar/>
  </v-app>
</template>

<script>
import snackbar from '../snackbar'
import tenders from './components/tenders'
import dashboardsubliers from './components/dashboardsubliers'
import reviews from './components/reviews'
import ads from './components/ads'
import auctions from './components/auctions'
import rates from './components/rates'
import personal from './components/personal'
import support from './components/support'

export default {
  name: 'customer_dashboard',
  data() {
    return {}
  },
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
  },
  components: {
    dashboardsubliers,
    tenders,
    reviews,
    ads,
    auctions,
    rates,
    personal,
    support,
    snackbar
  },
  methods: {
    formatDate(date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    formatDateWithoutYear(date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}`
    },
  },
  props: {
    user_id: Number,
  },
  watch: {},
  computed: {
    snackbar: {
      get() {
        return this.$store.state.snackbar
      },
      set(val) {
        this.$store.state.snackbar = val
      }
    },
    auth_user: {
      get() {
        return this.$store.state.auth_user
      }
    },
  },
};
</script>
