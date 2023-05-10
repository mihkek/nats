<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
      <Alert :user_id="user_id"/>
    <v-layout row wrap>
      <v-flex md12>
        <v-chip-group mandatory active-class="white--text" v-if="now == true">
          <v-chip color="primary" style="border-radius: 16px !important;" dark filter filter-icon="mdi-check-circle-outline" @click.stop="getItems([1,2])">
            <span class="white--text font-weight-medium" v-html="__('requester.all_status')"></span>
          </v-chip>
          <v-chip v-for="option in status_options" :key="option.id" :color="option.color_calendar" style="border-radius: 16px !important;" dark filter filter-icon="mdi-check-circle-outline" @click.stop="getItems([option.id])" v-if="option.id != 3 && option.id != 4">
            <span class="white--text font-weight-medium" v-html="option.title"></span>
          </v-chip>
        </v-chip-group>
        <v-chip-group mandatory active-class="white--text" v-else>
          <v-chip color="primary" style="border-radius: 16px !important;" dark filter filter-icon="mdi-check-circle-outline" @click.stop="getItems([3,4])">
            <span class="white--text font-weight-medium" v-html="__('requester.all_status')"></span>
          </v-chip>
          <v-chip v-for="option in status_options" :key="option.id" :color="option.color_calendar" style="border-radius: 16px !important;" dark filter filter-icon="mdi-check-circle-outline" @click.stop="getItems([option.id])" v-if="option.id == 3 || option.id == 4">
            <span class="white--text font-weight-medium" v-html="option.title"></span>
          </v-chip>
        </v-chip-group>
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
					<v-card outlined class="rounded-card">
            <v-data-table
						  :items="items"
        			:headers="table_headers"
        			:search="search"
        			color="transparent"
        			:mobile-breakpoint="100"
              :locale="$vuetify.lang.current"
        			:loading="loading"
        			class="rounded-card"
              :sort-by="['date_time']"
              :sort-desc="['DESC']"
              :expanded.sync="expanded"
              calculate-widths
        		>

              <template v-slot:header.date_time="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.status="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.customer.full_name="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.directory_person.full_name="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.directory_firm.full_name="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.price="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.directory_person_amount="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.directory_firm_amount="{ header }"><span v-html="header.text"></span></template>

              <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" class="px-0">
                  <v-list color="#fafafa">
                    <v-list-item v-if="item.customer != null" :href="'/admin/customer/list/card/'+item.customer.id">
                      <v-list-item-avatar >
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.customer.avatar != null" :src="'/storage/avatars/50x50.'+item.customer.avatar" alt="" ></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle v-html="__('orderer.customer')"></v-list-item-subtitle>
                        <v-list-item-title>
                          <v-tooltip top>
                            <template v-slot:activator="{on}">
                              <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/customer/list/card/'+item.customer.id">{{item.customer.full_name || ''}}</a>
                            </template>
                            <span class="caption" v-html="__('buttons.customer_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.directory_firm != null" :href="'/admin/directory/firms/'+item.directory_firm.id">
                      <v-list-item-avatar >
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.directory_firm.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_firm.avatar" alt="" ></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle v-html="__('orderer.directory_firm')"></v-list-item-subtitle>
                        <v-list-item-title>
                          <v-tooltip top>
                            <template v-slot:activator="{on}">
                              <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/directory/firms/'+item.directory_firm_id">{{item.directory_firm.full_name || ''}}</a>
                            </template>
                            <span class="caption" v-html="__('buttons.directory_firm_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.directory_person != null" :href="'/admin/directory/people/'+item.directory_person.id">
                      <v-list-item-avatar>
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.directory_person.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_person.avatar" alt=""></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle  v-html="__('orderer.directory_person')"></v-list-item-subtitle>
                        <v-list-item-title>
                          <v-tooltip top>
                            <template v-slot:activator="{on}">
                              <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/directory/people/'+item.directory_person_id">{{item.directory_person.full_name || ''}}</a>
                            </template>
                            <span class="caption" v-html="__('buttons.directory_person_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.additional_place != null">
                      <v-list-item-avatar >
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.additional_place.avatar != null" :src="'/storage/avatars/additional_places/'+item.additional_place.avatar" alt=""></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle v-html="__('orderer.directory_firm')">{{__('orderer.directory_firm')}}</v-list-item-subtitle>
                        <v-list-item-title><a class="font-weight-medium primary--text">{{item.additional_place.title || ''}}</a></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <template v-if="auth_user.role_id == 1000 || auth_user.role_id == 101">
                      <v-list-item v-if="item.price != ''">
                        <v-list-item-icon class="mr-4"><v-icon color="primary">mdi-cash</v-icon></v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-subtitle v-html="__('orderer.price')" ></v-list-item-subtitle>
                          <v-list-item-title>{{formatPrice(item.price)}}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                    <template v-if="auth_user.role_id == 1000 || auth_user.role_id == 103">
                      <v-list-item v-if="item.directory_firm_amount != ''">
                        <v-list-item-icon class="mr-4"><v-icon color="primary">mdi-cash</v-icon></v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-subtitle v-html="__('orderer.directory_firm_amount')"></v-list-item-subtitle>
                          <v-list-item-title >{{formatPrice(item.directory_firm_amount)}}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                    <template v-if="auth_user.role_id == 1000 || auth_user.role_id == 102">
                      <v-list-item v-if="item.directory_person_amount != ''">
                        <v-list-item-icon class="mr-4"><v-icon color="primary">mdi-cash</v-icon></v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-subtitle v-html="__('orderer.directory_person_amount')"></v-list-item-subtitle>
                          <v-list-item-title v-if="item.directory_person_amount > 0">{{formatPrice(item.directory_person_amount)}}</v-list-item-title>
                          <v-list-item-title v-if="item.directory_person_amount[item.directory_person.specialist_level] != undefined">{{formatPrice(item.directory_person_amount[item.directory_person.specialist_level][1])}}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                  </v-list>
                </td>
              </template>
              <template v-slot:item="{ item }">
                <tr class="table-row font-weight-medium" @click.stop="goTo(item)">
                  <td class="d-table-cell d-md-none px-0 py-0 text-center">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                    </v-tooltip>
                  </td>
                  <td >
                    <v-list-item-title class="caption">
                      {{formatDate(item.date)}} {{item.time}}
                    </v-list-item-title>
                  </td>
                  <td class="white--text" >
                    <v-chip small :color="item.order_status.color_calendar" style="border-radius: 16px !important;"><span class="white--text" v-html="item.order_status.title"></span></v-chip>
                  </td>
                  <td class="ava d-none d-md-table-cell">
                    <template v-if="item.customer != null">
                      <div class="pr-1" v-if="item.customer.avatar != null"><img :src="'/storage/avatars/50x50.'+item.customer.avatar" alt=""></div>
                      <div class="pr-1" v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                      <div>
                        <v-tooltip top>
                          <template v-slot:activator="{on}">
                            <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/customer/list/card/'+item.customer_id">{{item.customer.full_name || ''}}</a>
                          </template>
                          <span class="caption" v-html="__('buttons.customer_tooltip')"></span>
                        </v-tooltip>
                      </div>
                    </template>
                  </td>
                  <td class="ava d-none d-md-table-cell">
                    <template v-if="item.directory_person != null">
                      <div class="pr-1" v-if="item.directory_person.avatar != null"><img :src="'/storage/avatars/50x50.'+item.directory_person.avatar" alt=""></div>
                      <div class="pr-1" v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                      <div>
                        <v-tooltip top>
                          <template v-slot:activator="{on}">
                            <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/directory/people/'+item.directory_person_id">{{item.directory_person.full_name || ''}}</a>
                          </template>
                          <span class="caption" v-html="__('buttons.directory_person_tooltip')"></span>
                        </v-tooltip>
                      </div>
                    </template>
                  </td>
                  <td class="ava d-none d-md-table-cell">
                    <template v-if="item.directory_firm != null">
                      <div class="pr-1" v-if="item.directory_firm.avatar != null"><img :src="'/storage/avatars//50x50.'+item.directory_firm.avatar" alt=""></div>
                      <div class="pr-1" v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                      <div>
                        <v-tooltip top v-if="item.directory_firm_id != null">
                          <template v-slot:activator="{on}">
                            <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/directory/firms/'+item.directory_firm_id">{{item.directory_firm.full_name || ''}}</a>
                          </template>
                          <span class="caption" v-html="__('buttons.directory_firm_tooltip')"></span>
                        </v-tooltip>
                      </div>
                    </template>
                    <template v-else-if="item.additional_place != null">
                      <div class="pr-1" v-if="item.additional_place.avatar != null"><img :src="'/storage/avatars/additional_places/'+item.additional_place.avatar" alt=""></div>
                      <div><a class="font-weight-medium primary--text">{{item.additional_place.title || ''}}</a></div>
                    </template>
                  </td>
                  <td class="d-none d-md-table-cell" v-if="auth_user.role_id == 1000 || auth_user.role_id == 101">
                    <v-list-item-title class="caption">{{formatPrice(item.price)}}</v-list-item-title>
                  </td>
                  <td class="d-none d-md-table-cell" v-if="auth_user.role_id == 1000 || auth_user.role_id == 102">
                    <v-list-item-title class="caption">{{formatPrice(item.directory_person_amount)}}</v-list-item-title>
                    <!-- <v-list-item-title class="caption" v-if="item.directory_person_amount > 0">{{formatPrice(item.directory_person_amount)}}</v-list-item-title>
                    <v-list-item-title class="caption" v-if="item.directory_person_amount[item.directory_person.specialist_level] != undefined">{{formatPrice(item.directory_person_amount[item.directory_person.specialist_level][1])}}</v-list-item-title> -->
                  </td>
                  <td class="d-none d-md-table-cell" v-if="auth_user.role_id == 1000 || auth_user.role_id == 103">
                    <v-list-item-title class="caption">{{formatPrice(item.directory_firm_amount)}}</v-list-item-title>
                  </td>
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
import {TheMask} from 'vue-the-mask'
import { dateParsed, dateVerbal, getDateTimeFromTimestamp, getTimestampFromDate } from '../../js/utils'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import snackbar from '../snackbar'
import Alert from '../snippets/Alert'

export default {
  name: 'orderers_list',
  data () {
    return {
      search: '',
      loading: false,
      expanded: [],
    }
  },
  props: {
    status: Array,
    user_id: Number,
    now: Boolean,
  },
  components: {TheMask, FieldAccess, FieldAccessButton, AdminPanel, snackbar, Alert},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
    this.getItems()
    this.checkHeaders()
  },
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
  	goTo(item) {
      let val = ''
      if (this.$props.status[0] == 3) { val = '/admin/orderer/list/card/'+item.id }
      else { val = '/admin/orderer/now/card/'+item.id }
  		location.href = val
  	},
    getItems(status) {
      let params = { user_id: this.$props.user_id }
      if (status != undefined) { params.status = status }
      else { params.status = this.$props.status }
      params._lang = this.locale
      this.loading = true
      this.$store.dispatch('GET_ORDERERS', params).then(res => { this.loading = false; console.log(this.items) })
      .catch(error => { this.loading = false })
    },
    /*getItems(status) {
      let params = { status: this.$props.status, user_id: this.$props.user_id, '_lang': this.locale }
      this.loading = true
      this.$store.dispatch('GET_ORDERERS', params).then(res => { this.loading = false; })
      .catch(error => { this.loading = false })
    },*/
    maskedPhone(val) {
    	if (val.length == 10) { return '+7('+val[1]+val[2]+val[3]+')'+val[4]+val[5]+val[6]+'-'+val[7]+val[8]+'-'+val[9]+val[10] }
    	else { return val }
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
    checkHeaders() {
      this.table_headers.map(head => {
        if (head.text == head.title) {
          head.text = '<span class="no_translate">'+head.title+'</span>'
        }
      })
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id == 1000) {}
      else if (val.role_id == 101) {
        this.table_headers.splice(this.table_headers.length - 2, 2)
      }
      else if (val.role_id == 102) {
        this.table_headers.splice(this.table_headers.length - 1, 1)
        this.table_headers.splice(this.table_headers.length - 3, 1)
      }
      else if (val.role_id == 103) {
        this.table_headers.splice(this.table_headers.length - 2, 1)
        this.table_headers.splice(this.table_headers.length - 3, 1)
      }
    },
    locale: function (val) {
      this.loading = true
      this.getItems()
    },
  },
  computed: {
    table_headers: {
      get() { return this.$store.state.orderers.table_headers },
      set(val) { this.$store.state.orderers.table_headers = val }
    },
    items: {
      get() { return this.$store.state.orderers.items },
      set(val) { this.$store.state.orderers.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
    status_options: {
      get() { return this.$store.state.orderers.status_options },
    },
  },
};
</script>

<style>
	
</style>