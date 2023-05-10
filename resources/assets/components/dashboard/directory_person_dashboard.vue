<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <v-layout row wrap>
        <v-flex md7>
          <tenders/>
          <!-- <auctions /> -->
        </v-flex>
        <v-flex md5>
          <active_tenders :user_id="user_id" :type="'drop'" :own="true" :now="true"/>
          <rates/>
          <!-- <personal />
          <support /> -->
        </v-flex>
      </v-layout>
    </v-container>
    <snackbar/>
  </v-app>
</template>

<script>
import snackbar from '../snackbar'
import tenders from './components/tenders'
import reviews from './components/reviews'
import auctions from './components/auctions'
import rates from './components/rates'
import personal from './components/personal'
import support from './components/support'
import active_tenders from './components/active_tenders'

export default {
  name: 'directory_person_dashboard',
  data() {
    return {}
  },
  props: {
    user_id: Number,
  },
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
  },
  components: {
    tenders,
    reviews,
    auctions,
    rates,
    personal,
    support,
    snackbar,
    active_tenders,
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
