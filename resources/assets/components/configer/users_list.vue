<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md12>
				<v-card class="rounded-card px-4 py-4" flat>
					<v-toolbar color="transparent" flat dense>
						<v-toolbar-items>
              				<v-select
               				  	:items="subdivisions"
               				  	v-model="filter.subdivision"
               				  	label="Подразделение"
               				  	v-if="auth_user.role_id == 1000"
               				  	solo
               				  	item-text="title"
               				  	return-object
               				  	hide-details
               				  	required
               				  	class="mx-3"
								backgroundColor="#fafafa"
               				></v-select>
						</v-toolbar-items>
						<v-spacer></v-spacer>
            			<v-btn color="success" class="rounded-btn mx-3"  @click.stop="goTo('/admin/configer/users/new')" small><v-icon left>mdi-plus</v-icon> <span v-html="__('buttons.add')"></span></v-btn>
					</v-toolbar>
					  <v-layout row wrap>
						<v-flex xs12 md6>
					  		<v-text-field
					  		  	hide-details
					  		  	solo
					  		  	prepend-icon="mdi-magnify"
					  		  	v-model="filter.search"
								backgroundColor="#fafafa"
								@change="getItems"
					  		>
               					<template v-slot:label>
               					  	<span v-html="__('forms.search_label')"></span>
               					</template>      
              				</v-text-field>
						</v-flex>
						<v-flex xs12 md3>
							<v-text-field
								solo
								type="date"
								label="Начало периода"
								hide-details
								v-model="filter.date_from"
								clearable
								@change="getItems"
							>
								<template v-slot:prepend>
									<span class="my-1">С</span>
								</template>
							</v-text-field>
						</v-flex>
						<v-flex xs12 md3>
							<v-text-field
								solo
								type="date"
								label="Конец периода"
								hide-details
								v-model="filter.date_to"
								clearable
								@change="getItems"
							>
								<template v-slot:prepend>
									<span class="my-1">По</span>
								</template>
							</v-text-field>
                    	</v-flex>
						<v-flex xs12 md12>
              				<v-select
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
               				></v-select>
						</v-flex>
                    </v-layout>
                    <v-card outlined class="rounded-card mt-1">
						<v-data-table
							:items="items"
        					:headers="headers"

							color="transparent"
              				:mobile-breakpoint="100"
        					locale="ru"
        					:loading="loading"
        					class="rounded-card"
							:custom-sort="customSort"
              				:expanded.sync="expanded"
							:footer-props="{itemsPerPageOptions:[25,50,100,-1]}"
							:options.sync="options"
        				>
              				<template v-slot:header.id="{ header }"><span v-html="__('user.id')"></span></template>
              				<template v-slot:header.full_name="{ header }"><span v-html="__('user.full_name')"></span></template>
              				<template v-slot:header.role.name="{ header }"><span v-html="__('user.role')"></span></template>
              				<template v-slot:header.email="{ header }"><span v-html="__('user.email')"></span></template>
              				<template v-slot:header.phone="{ header }"><span v-html="__('user.phone')"></span></template>
              				<template v-slot:header.created="{ header }"><span v-html="__('user.created_at')"></span></template>

              				<template v-slot:expanded-item="{ headers, item }">
              				  <td :colspan="headers.length" class="px-0">
              				    <v-list color="#f1f1f1" dense>
              				      <v-list-item>
              				        <v-list-item-subtitle v-html="__('user.id')"></v-list-item-subtitle>
              				        <v-list-item-title class="text-right">{{item.id}}</v-list-item-title>
              				      </v-list-item>
              				      <v-divider class="my-0"></v-divider>
              				      <v-list-item>
              				        <v-list-item-subtitle v-html="__('user.role')"></v-list-item-subtitle>
              				        <v-list-item-title class="text-right">{{item.role.name}}</v-list-item-title>
              				      </v-list-item>
              				      <v-divider class="my-0"></v-divider>
              				      <v-list-item>
              				        <v-list-item-subtitle v-html="__('user.email')"></v-list-item-subtitle>
              				        <v-list-item-title class="text-right">{{item.email}}</v-list-item-title>
              				      </v-list-item>
              				      <v-divider class="my-0"></v-divider>
              				      <v-list-item>
              				        <v-list-item-subtitle v-html="__('user.phone')"></v-list-item-subtitle>
              				        <v-list-item-title class="text-right">{{item.phone}}</v-list-item-title>
              				      </v-list-item>
              				      <v-divider class="my-0"></v-divider>
              				      <v-list-item>
              				        <v-list-item-subtitle v-html="__('user.created')"></v-list-item-subtitle>
              				        <v-list-item-title class="text-right">{{item.created}}</v-list-item-title>
              				      </v-list-item>
              				    </v-list>
              				  </td>
              				</template>
              				<template v-slot:item="{ item }">
              				  <tr class="table-row" @click.stop="goTo('/admin/configer/users/card/'+item.id)">
              				    <td class="d-table-cell d-md-none px-0 py-0 text-center">
              				        <v-tooltip top>
              				          <template v-slot:activator="{ on }">
              				            <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
              				          </template>
              				          <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
              				        </v-tooltip>
              				      </td>
              				    <td class="d-none d-md-table-cell">{{item.id}}</td>
              				    <td>
									{{item.full_name}}
									<v-tooltip top v-if="item.confirm != null && item.deleted == ''">
										<template v-slot:activator="{on}">
											<v-btn color="success" v-on="on" icon x-small class="mx-1" style="margin-top:-2px;"><v-icon color="success" size="18">mdi-check-circle-outline</v-icon></v-btn>
										</template>
										<span class="caption">Подтвержден</span>
									</v-tooltip> 
									<v-tooltip top v-if="item.confirm == null && item.deleted == ''">
										<template v-slot:activator="{on}">
											<v-btn color="success" v-on="on" icon x-small class="mx-1" style="margin-top:-2px;"><v-icon color="orange" size="18">mdi-checkbox-blank-circle-outline</v-icon></v-btn>
										</template>
										<span class="caption">Не заходил ни разу</span>
									</v-tooltip> 
									<v-tooltip top v-if="item.deleted == 'on'">
										<template v-slot:activator="{on}">
											<v-btn color="red" v-on="on" icon x-small class="mx-1" style="margin-top:-2px;"><v-icon color="red" size="18">mdi-minus-circle-outline</v-icon></v-btn>
										</template>
										<span class="caption">Удален</span>
									</v-tooltip> 
								</td>
              				    <td class="d-none d-md-table-cell">{{item.role.name}}</td>
              				    <td class="d-none d-md-table-cell">{{item.email}}</td>
              				    <td class="d-none d-md-table-cell">{{item.phone}}</td>
              				    <td class="d-none d-md-table-cell">{{item.created}}</td>
              				  </tr>
              				</template>
        				</v-data-table>     
					</v-card>
					<v-toolbar color="transparent" flat dense class="mt-3">
						<v-spacer></v-spacer>
					    <v-btn color="warning" class="rounded-btn"  @click.stop="getXls()" small><v-icon left>mdi-download</v-icon> <span>Скачать в XLS</span></v-btn>
					</v-toolbar>

				</v-card>
			</v-flex>
		</v-layout>
	</v-container>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {mask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import { innRegions } from '../../js/utils.js'

export default {
  name: 'users_list',
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
      headers: [
        { id: 0, text: '', value: 'expanded', width: 30, align: 'center', sortable: false, class: 'd-table-cell d-md-none' },
      	{ id: 1, text: __('user.id'), value: 'id', class: 'd-none d-md-table-cell' },
      	{ id: 2, text: __('user.full_name'), value: 'full_name' },
      	{ id: 3, text: __('user.role'), value: 'role.name', class: 'd-none d-md-table-cell' },
        { id: 4, text: __('user.email'), value: 'email', class: 'd-none d-md-table-cell' },
        { id: 5, text: __('user.phone'), value: 'phone', class: 'd-none d-md-table-cell' },
        { id: 6, text: __('user.created_at'), value: 'created', class: 'd-none d-md-table-cell' },
      ],
	  page: 1,
	  options: {},
	  savedOptions: {},
	  defaultOptions: {
	  	page: 1,
	    sortBy: ['created'],
  	    sortDesc: [true],
		itemsPerPage: 25,
	  },
	  queryString: '',
	  
	  dialog: false,
      pass_dialog: false,
      dialog_title: '',
      selectedItem: {},
      expanded: [],
      subdivision: {},
	  
	  region: '',
      regions: innRegions.items,
    }
  },
  props: {
    user_id: Number,
	deleted: String,
  },
  components: {snackbar, AdminPanel, FieldAccess, FieldAccessButton},
  mounted() {
	this.restoreOptions()
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id }).then(res => {
      this.getSubdivisions()
      this.getRoles()
    })
  },
  methods: {
  	getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS').then(res => {
        this.filter.subdivision = this.subdivision = this.subdivisions.find(el => el.id == this.auth_user.subdivision_id)
      })
    },
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    editPass(item) {
      this.selectedItem = Object.assign({}, item)
      this.pass_dialog = true
    },
  	newItem() {
  		this.selectedItem = {}
  		this.dialog_title = 'Добавить сотрудника'
  		this.dialog = true
  	},
  	editItem(item) {
  		this.selectedItem = Object.assign({}, item)
      	this.selectedItem.role_id = Number(item.role_id)
  		this.dialog_title = 'Редактировать сотрудника'
  		this.dialog = true
  	},
    submitPass() {
      this.$store.dispatch('EDIT_USER_PASS', this.selectedItem).then(res => { this.getItems() })
    },
  	submit() {
  		this.$store.dispatch('EDIT_CONFIGER_USER', this.selectedItem).then(res => { this.getItems() })
  	},
  	goTo(val) {
      location.href = val;
    },
    getItems() {
		
    	this.loading = true
    	let params = {
    		user_id: this.user_id,
    		_lang: this.locale,
    		subdivision_id: this.filter.subdivision.id,
			deleted: this.deleted,
    	}
        params.search = this.filter.search
        params.date_from = this.filter.date_from
        params.date_to = this.filter.date_to
        params.region = this.filter.region
      	this.$store.dispatch('GET_USER_LIST', params).then(res => { 
			  this.dialog = false
			  this.pass_dialog = false
//			  console.log('getItems 1', this.options)
			  this.options.page = this.page
//			  console.log('getItems 2', this.options)
			  this.setHistory()
		})
      	.finally(() => (this.loading = false))
    },
    getRoles() {
      this.$store.dispatch('GET_USER_ROLES', { user_id: this.user_id } ).then(res => {
        this.roles.map(role => { role.title = role.name })
      })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    formatDate (val) {
      if (!val) return null
      else {
        const [date, time] = val.split(' ')
        const [year, month, day] = date.split('-')
        return `${day}.${month}.${year} ${time}`
      }
    },
	customSort: function(items, index, isDesc) {
      items.sort((a, b) => {
          if (index[0]=='created') {
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
		  	if (index[0] == 'role.name') index = 'role_id'
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
    	subdivision_id: this.filter.subdivision.id,
		deleted: this.deleted,
        excel: true,
      }
      params.search = this.filter.search
      params.date_from = this.filter.date_from
      params.date_to = this.filter.date_to
	  params.region = this.filter.region
	  axios.post('/admin/configer/users/get', params).then(res => {
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
    subdivision(val) {
      if (val != undefined) this.getItems()
	  this.setHistory()
    },
	search: function () {
	  this.setHistory()
	},
	date_to: function () {
	  this.setHistory()
	},
	date_from: function () {
	  this.setHistory()
	},
    region(val) {
      if (val != undefined) this.getItems()
	  this.setHistory()
    },
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
      this.filter.subdivision = this.subdivision = this.subdivisions.find(el => el.id == val.subdivision_id)
    },
    locale: function (val) {
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
    items: {
      get() { return this.$store.state.configer_users.items },
      set(val) { this.$store.state.configer_users.items = val }
    },
    roles: {
      get() { return this.$store.state.configer_roles.items },
      set(val) { this.$store.state.configer_roles.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    loading: {
      get() { return this.$store.state.loading },
	  set(val) { this.$store.state.loading = val }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
  directives: { mask }
};
</script>

<style>
	
</style>