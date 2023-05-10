<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
	<input v-model="savedOptions" style="position:absolute; visibility: hidden;" />
    <v-layout row wrap>
      <v-flex md12>
        <v-card class="rounded-lg">
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 md6>
                <v-text-field
                  backgroundColor="#f1f1f1"
                  hide-details
                  solo
                  prepend-icon="mdi-magnify"
                  v-model="filter.search"
				  @change="getItems"
                >
                  <template v-slot:label>
                    <span v-html="__('buttons.search_label')"></span>
                  </template>
                </v-text-field>
              </v-flex>
			  <v-flex md6 xs12>
				<v-card flat color="transparent">
					<v-layout row wrap>
						<v-flex xs12 md6>
							<v-text-field
								solo
								type="date"
								label="Начало периода"
								hide-details
								@change="getItems"
								v-model="filter.date_from"
								clearable
							>
								<template v-slot:prepend>
									<span class="my-1">С</span>
								</template>
							</v-text-field>
						</v-flex>
						<v-flex xs12 md6>
							<v-text-field
								solo
								type="date"
								label="Конец периода"
								hide-details
								@change="getItems"
								v-model="filter.date_to"
								clearable
							>
								<template v-slot:prepend>
									<span class="my-1">По</span>
								</template>
							</v-text-field>
                    	</v-flex>
						
                  	</v-layout>
                </v-card>
              </v-flex>
			  <v-flex xs12 md12>
                <v-autocomplete
               	  :items="regions"
				  v-model="filter.region"
               	  label="Регионы"
               	  solo
				  hide-details
               	  item-text="title"
				  item-value="id"
				  multiple
				  chips
				  backgroundColor="#fafafa"
				  prepend-icon="mdi-map"
				  @change="getItems"
				  clearable
               	></v-autocomplete>
			  </v-flex>
            </v-layout>
          </v-container>
          <v-divider class="my-0"></v-divider>
          <v-data-table
            :items="items"
            :headers="headers"
            color="transparent"
            :mobile-breakpoint="100"
            :locale="$vuetify.lang.current"
            :loading="loading"
            class="rounded-card"
			:custom-sort="customSort"
			:footer-props="{itemsPerPageOptions:[25,50,100,-1]}"
			:options.sync="options"
          >
            <template v-slot:item="{ item }">
              <tr class="table-row" @click.stop="item.deleted == 'on' ? goTo('/admin/directory/people_archive/'+item.id) : goTo('/admin/directory/people/'+item.id)">
                <td>
                  <v-list-item dense class="px-0">
                    <v-list-item-content style="flex-direction:row; flex-wrap:nowrap;">
                      <v-list-item-title v-html='item.created_at'></v-list-item-title>
					  <v-tooltip top v-if="item.confirm != null">
					  	<template v-slot:activator="{on}">
						  <v-btn color="success" v-on="on" icon x-small class="mx-1" style="flex: none; justify-content: flex-end;"><v-icon color="success" size="18">mdi-check</v-icon></v-btn>
						</template>
					    <span class="caption">Подтвержден</span>
					  </v-tooltip> 
					  <v-tooltip top v-if="item.confirm == null">
						<template v-slot:activator="{on}">
					      <v-btn color="orange" v-on="on" icon x-small class="mx-1" style="flex: none; justify-content: flex-end;"><v-icon color="orange" size="18">mdi-bell-outline</v-icon></v-btn>
						</template>
					  <span class="caption">Новый</span>
					  </v-tooltip> 
					  
					</v-list-item-content>
                  </v-list-item>
                </td>
                <td>
                  <v-list-item dense class="px-0">
                    <v-list-item-content>
                      <v-list-item-title v-html='item.company_name'></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td>
                  <v-list-item dense class="px-0">
                    <v-list-item-content>
                      <v-list-item-title v-html='item.company_inn'></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td>
                  <v-list-item dense class="px-0">
                    <v-list-item-avatar size="32" class="mr-2">
                      <v-img :src="'/storage/avatars/50x50.'+item.profile_photo" v-if="item.profile_photo != '' && item.profile_photo != null"></v-img>
                      <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title v-html='item.full_name'></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td class="d-none d-md-table-cell">
                  <template v-if="item.phone != ''">
                    <v-list-item dense class="px-0">
                      <v-list-item-icon class="mr-2">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" class="my-icon-btn" icon :href="'callto:'+item.phone" small v-on="on"><v-icon small>mdi-phone-outgoing</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.phone_tooltip')">{{__('buttons.phone_tooltip')}}</span>
                        </v-tooltip>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title v-html='item.phone'></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </template>
                </td>
                <td class="d-none d-md-table-cell">
                  <template v-if="item.email != ''">
                    <v-list-item dense  class="px-0">
                      <v-list-item-icon class="mr-2">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="#244467" class="my-icon-btn" icon :href="'callto:'+item.email" small v-on="on"><v-icon small>mdi-email-outline</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                        </v-tooltip>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title v-html='item.email'></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </template>
                </td>
              </tr>
            </template>
          </v-data-table>
        </v-card>
      </v-flex>
      <snackbar />
    </v-layout>
					<v-toolbar color="transparent" flat dense>
						<v-spacer></v-spacer>
					    <v-btn color="warning" class="rounded-btn" @click.stop="getXls()" small><v-icon left>mdi-download</v-icon> <span>Скачать в XLS</span></v-btn>
					</v-toolbar>
  </v-container>
</v-app>
</template>

<script> 
import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import AdminPanel from '../../snippets/AdminPanel'
import snackbar from '../../snackbar'
import Alert from '../../snippets/Alert'
import { innRegions } from '../../../js/utils.js'

export default {
  name: 'directory_people_list',
  data () {
    return {
	  filter: {
	  	search: '',
      	date_from: '',
      	date_to: '',
		subdivision: {},
	  	region: '',
	  },
      search: '',
	  date_from: '',
	  date_to: '',
      loading: false,
      role_id: 102,
      expanded: [],
      subdivision: {},
      headers: [
        { text: 'Зарегистрирован', value: 'created_at' },
        { text: 'Наименование организации', value: 'company_name' },
        { text: 'ИНН', value: 'company_inn' },
        { text: 'ФИО', value: 'full_name' },
        { text: 'Телефон', value: 'phone' },
        { text: 'Email', value: 'email' },
      ],
	  page: 1,
	  options: {},
	  savedOptions: {},
	  defaultOptions: {
	  	page: 1,
	    sortBy: ['created_at'],
  	    sortDesc: [true],
		itemsPerPage: 25,
	  },
	  queryString: '',

	  region: '',
      regions: innRegions.items,
    }
  },
  props: {
    user_id: Number,
    is_delete: Boolean,
	listnew: Boolean,
  },
  components: { FieldAccess, FieldAccessButton, AdminPanel, snackbar, Alert },
  mounted() {
	this.restoreOptions()
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
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    goTo(val) {
      location.href = val;
    },
    getItems() {
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        is_delete: this.is_delete,
        subdivision_id: this.subdivision.id,
        role_id: [ 102 ],
      }
      params.search = this.filter.search
      params.date_from = this.filter.date_from
      params.date_to = this.filter.date_to
      params.region = this.filter.region
      params.deleted = this.is_delete
      params.listnew = this.listnew
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', params ).then(res => {
	  	this.loading = false
		this.options.page = this.page
		this.setHistory()
	  })
      .catch(error => { this.loading = false })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    checkHeaders() {
      this.table_headers.map(head => {
        if (head.text == head.title) {
          head.text = '<span class="no_translate">'+head.title+'</span>'
        }
      })
    },
	customSort: function(items, index, isDesc) {
      items.sort((a, b) => {
          if (index[0]=='created_at') {
		  	var [adate, atime] = a[index].split(' ')
			var [aday, amonth, ayear] = adate.split('.')
			var a_comp = ayear+'.'+amonth+'.'+aday+' '+atime 
		  	var [bdate, btime] = b[index].split(' ')
			var [bday, bmonth, byear] = bdate.split('.')
			var b_comp = byear+'.'+bmonth+'.'+bday+' '+btime 
            if (!isDesc[0]) {
                return a_comp.localeCompare(b_comp)
            } else {
                return b_comp.localeCompare(a_comp)
            }
          }
          else {
            if(typeof a[index] !== 'undefined') {
			  var a_comp = (typeof a[index] === 'string' || a[index] instanceof String) ? a[index].toLowerCase() : a[index]
			  var b_comp = (typeof b[index] === 'string' || b[index] instanceof String) ? b[index].toLowerCase() : b[index]
              if (!isDesc[0]) {
                 return a_comp < b_comp ? -1 : 1
              }
              else {
                 return b_comp < a_comp ? -1 : 1
              }
            }
          }
      });
      return items;
    },
	getXls() {
      this.loading = true
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        is_delete: this.is_delete,
        subdivision_id: this.subdivision.id,
        role_id: [ 102 ],
		excel: true,
      }
      params.search = this.filter.search
      params.date_from = this.filter.date_from
      params.date_to = this.filter.date_to
      params.deleted = this.is_delete
      params.listnew = this.listnew
      params.region = this.filter.region
	  axios.post('/admin/directory/people/get', params).then(res => {
        if (res.data.status != 1) console.log(res.data)
		else location.href = res.data.link
      })
      .finally(() => (this.loading = false))
	},

	restoreOptions () {
		this.savedOptions = this.defaultOptions
        this.queryString = '?sb='+this.options.sortBy+'&sd='+this.options.sortDesc+'&p='+this.options.page+'&pp='+this.options.itemsPerPage+'&s='+this.filter.search+'&df='+this.filter.date_from+'&dt='+this.filter.date_to+'&l='+this.filter.region
//		console.log('restore', window.location.search)
		if (window.location.search && window.location.search != this.queryString) {
//			console.log('restore loading saved', window.location.search)
			this.queryString = window.location.search
			this.savedOptions.sortBy = [this.optionFromQS('sb')] || this.defaultOptions.sortBy
			this.savedOptions.sortDesc = [this.optionFromQS('sd')=='true'?true:false] || this.defaultOptions.sortDesc
			this.savedOptions.page = this.optionFromQS('p') || this.defaultOptions.page
			this.savedOptions.itemsPerPage = this.optionFromQS('pp') || this.defaultOptions.itemsPerPage
			this.filter.search = this.optionFromQS('s') || this.filter.search
			this.filter.date_from = this.optionFromQS('df') || this.filter.date_from
			this.filter.date_to = this.optionFromQS('dt') || this.filter.date_to
			this.filter.region = this.optionFromQS('l').length > 0 ? this.optionFromQS('l').split(',') : this.filter.region
		}
		this.page = this.savedOptions.page
		this.options = this.savedOptions
//		console.log('restore options', this.options)
	},
	setHistory() {
	  this.queryString = '?sb='+this.options.sortBy+'&sd='+this.options.sortDesc+'&p='+this.options.page+'&pp='+this.options.itemsPerPage+'&s='+this.filter.search+'&df='+this.filter.date_from+'&dt='+this.filter.date_to+'&l='+this.filter.region
//	  console.log('watch options', this.options)
//	  console.log('watch search', window.location.search)
//	  console.log('watch queryString', this.queryString)
	  if (this.queryString != window.location.search) {
//	    console.log('watch replaceState', this.queryString)
	    history.replaceState(null, null, this.queryString)
	  }
	  this.savedOptions = this.options
	},
	optionFromQS (name) {
	  var url = window.location.href
      name = name.replace(/[\[\]]/g, '\\$&')
      var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'), results = regex.exec(url)
      if (!results) return null
      if (!results[2]) return ''
      return decodeURIComponent(results[2].replace(/\+/g, ' '))
	},
  },
  watch: {
    filter: function () {
//	  console.log('filter updated');
	  this.setHistory()
	  this.getItems()
	},
    auth_user: function (val) {
      this.subdivision = this.subdivisions.find(el => el.id == val.subdivision_id)
    },
    subdivision(val) {
      if (val != undefined) {
        this.loading = true
        this.getItems()
      }
	  this.setHistory()
    },
    region(val) {
      if (val != undefined) this.getItems()
    },
    locale: function (val) {
      this.loading = true
      this.getItems()
    },
	options: function () {
	  this.setHistory()
	},
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },  
    items: {
      get() { return this.$store.state.directory_people.items },
      set(val) { this.$store.state.directory_people.items = val }
    },
    table_headers: {
      get() { return this.$store.state.directory_people.table_headers },
      set(val) { this.$store.state.directory_people.table_headers = val }
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