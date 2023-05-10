import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import promoters from './modules/promoters'
import directory_people from './modules/directory/people/directory_people_module'
import directory_firms from './modules/directory/firms/directory_firms_module'
import customers from './modules/customers/customers_module'
import orderers from './modules/orderers/orderers_module'
import users from './modules/users/users_module'
import personal_settings from './modules/settings/personal/personal_settings_module'
import configer_roles from './modules/configer/roles/roles_module'
import configer_drugs from './modules/configer/drugs/drugs_module'
import configer_users from './modules/configer/users/users_module'
import configer_subdivisions from './modules/configer/subdivisions/subdivisions_module'
import billing from './modules/billing/billing_module'
import requester from './modules/requester/requester_module'
import auction from './modules/auction'
import review from './modules/review'
import report from './modules/report'
import lang from './modules/lang';
import fieldaccess from './modules/fieldaccess'


export default new Vuex.Store({
  modules: {
    directory_people: directory_people,
    directory_firms: directory_firms,
    customers: customers,
    orderers: orderers,
    users: users,
    personal_settings: personal_settings,
    configer_roles: configer_roles,
    configer_drugs: configer_drugs,
    configer_users: configer_users,
    billing: billing,
    requester: requester,
    fieldaccess,
    lang,
    promoters,
    configer_subdivisions,
    report,
    auction,
    review
  },
  state: {
    snackbar: {
      show: false,
      status: 1,
      text: ''
    },
    loading: false,
    auth_user: {},
    cities: [],
  },
  mutations: {
    SET_SNACKBAR(state, payload) {
      if (payload.status != undefined) {
        state.snackbar.status = payload.status
        state.snackbar.text = payload.text
        state.snackbar.show = true
      }
      else { console.log(payload) }
    },
    SET_AUTH_USER(state, payload) {
      state.auth_user = payload.user
    },
    SET_CITIES(state, payload) {
      state.cities = []
      payload.cities.map(city => {
        city.title = city.name
        city.value = city.id
        state.cities.push(city)
      })
    },
  },
  actions: {
    GET_CITIES: async(context, payload) => {
      let {data} = await axios.post('/get_cities', payload)
      context.commit('SET_CITIES', data)
    },
    GET_AUTH_USER: async(context, payload) => {
      let {data} = await axios.post('/admin/users/get', payload)
      context.commit('SET_AUTH_USER', data)
    },
    AUTH_GO: async(context, payload) => {
      let {data} = await axios.post('/auth/go', payload)
      if (data.status == '0') context.commit('SET_SNACKBAR', data)
      /*else $cookies.set('promoter_id', payload.id, 60 * 60 * 4);*/
      return data
    },
    EXIT_GO: async(context, payload) => {
      $cookies.remove('promoter_id');
      /*let {data} = await axios.post('/logout')*/
    },
    CHECK_AUTH: async(context, payload) => {
      /*if ($cookies.get('promoter_id') > 0) {
        let params = { id: $cookies.get('promoter_id') }
        let {data} = await axios.post('/auth/go', params)
        return data
      }*/
    },
  },

})
