<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
    <v-layout row wrap v-if="auth_user.role_id != 1000">
   	  <v-flex xs6>
   	    <v-card flat class="pa-8 radius text-center">
   	    	<span class="d-block mb-2 font-weight-medium">Всего начислено</span>
   	  		<span class="display-1 primary--text">{{formatPrice(total.come)}}</span>
   	    </v-card>
   	  </v-flex>
   	  <v-flex xs6>
   	  	<v-card flat class="pa-8 radius text-center">
   	  		<span class="d-block mb-2 font-weight-medium">Текущий баланс</span>
   	  		<span class="display-1 primary--text">{{formatPrice(total.balance)}}</span>
   	  	</v-card>
   	  </v-flex>
   	</v-layout>
    <v-layout row wrap>
      <v-flex md12>
        <v-card class="rounded-card px-4 py-4" flat>
          <v-toolbar color="transparent" flat dense height="38px">
            <v-toolbar-items>
              <v-text-field
                hide-details
                solo
                flat
                prepend-icon="mdi-magnify"
                dense
                v-model="search"
              >
                <template v-slot:label>
                  <span v-html="__('buttons.search_label')"></span>
                </template>
              </v-text-field>
            </v-toolbar-items>
          </v-toolbar>
          <v-card outlined class="rounded-card mt-1">
          <v-data-table
            :items="items"
            :headers="headers"
            :search="search"
            color="transparent"
            :items-per-page="10"
            locale="ru"
            :loading="loading"
            class="rounded-card"
            :sort-by="['created']"
            :sort-desc="['desc']"
            :mobile-breakpoint="100"
          >
            <!-- ТЕМЛЕЙТЫ ДЛЯ ПЕРЕДАЧИ HTML ШАПКИ ТАБЛИЦЫ -->
            <template v-slot:header.created="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.sum="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.description="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.user.email="{ header }"><span v-html="header.text"></span></template>
            <!-- .... -->
              
            
            <template v-slot:item="{ item }">
              <tr class="table-row">
                <td class="d-none d-md-table-cell">{{formatDate(item.created)}}</td>
                <td class=""><span :class="item.sum > 0 ? 'red--text' : 'primary--text'"><b>{{item.sum}}</b></span></td>
                <td class="">
                  <template v-if="item.orderer_id > 0">
                    <span v-html="__('billing.history_write_off')"></span> <a :href="'/admin/orderer/now/card/'+item.orderer_id" class="primary--text"><span v-html="__('billing.history_lesson_from')"></span> {{formatDate(item.orderer.date_time)}}</a>, 
                    <template v-if="item.orderer.directory_firm_id > 0"><span v-html="__('billing.history_in_directory_firm')"></span> "<a :href="'/admin/directory/firms/'+item.orderer.directory_firm_id" class="primary--text">{{item.orderer.directory_firm.full_name}}</a>"</template>
                    <template v-if="item.orderer.orderer_additional_place_id > 0">"<a class="primary--text">{{item.orderer.additional_place.title}}</a>"</template>,
                    <span v-html="__('billing.history_directory_person')"></span> "<a :href="'/admin/directory/people/'+item.orderer.directory_person_id" class="primary--text">{{item.orderer.directory_person.full_name}}</a>"
                  </template>
                  <template v-else>{{item.description}}</template>
                </td>
                <td class="d-none d-md-table-cell" v-if="auth_user.role_id == 1000"><span v-if="item.user != null">{{item.user.email}}</span></td>
              </tr>
            </template>
          </v-data-table>     
          </v-card>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import FieldAccess from '../fieldaccess/FieldAccess'
import AdminPanel from '../snippets/AdminPanel'
import Alert from '../snippets/Alert'

export default {
  name: 'billing_history',
  data () {
    return {
      search: '',
      loading: false,
      headers: [
        { text: __('billing.history_date_time'), title: 'billing.history_date_time', value: 'created', class: 'd-none d-md-table-cell' },
        { text: __('billing.history_amount'), title: 'billing.history_amount', value: 'sum' },
        { text: __('billing.history_comment'), title: 'billing.history_comment', value: 'description' },
        { text: __('billing.history_user'), title: 'billing.history_user', value: 'user.email', class: 'd-none d-md-table-cell' }
      ],
    }
  },
  props: {
    user_id: Number,
  },
  components: {snackbar, FieldAccess, AdminPanel, Alert},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.getItems()
    this.headers.map(head => {
      if (head.text == head.title) {
        head.text = '<span class="no_translate">'+head.title+'</span>'
      }
    })
  },
  methods: {
    getItems() {
      this.$store.dispatch('GET_BILLING_HISTORY', { user_id: this.user_id }).then(res => { this.loading = false; })
      .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
    formatDate(val) {
      if (!val) return null
      const [date, time] = val.split(' ')
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year} ${time || ''}`
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { this.headers.splice(this.headers.length-1, 1) }
    },
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    items: {
      get() { return this.$store.state.billing.history }
    },
    total: {
      get() { return this.$store.state.billing.total }
    },
  },
};
</script>
