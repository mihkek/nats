<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Панель админа" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
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
                  <span v-html="__('forms.search_label')"></span>
                </template>      
              </v-text-field>
						</v-toolbar-items>
						<v-spacer></v-spacer>
						<v-btn color="success" class="rounded-btn" @click.stop="newItem" small><v-icon left>mdi-plus</v-icon> <span v-html="__('buttons.add')"></span></v-btn>
					</v-toolbar>
					<v-card outlined class="rounded-card mt-1">
						<v-data-table
							:items="items"
        					:headers="headers"
        					:search="search"
        					color="transparent"
        					:items-per-page="25"
                  :locale="$vuetify.lang.current"
        					:loading="loading"
        					class="rounded-card"
                  :sort-by="['id']"
                  :mobile-breakpoint="100"
                  :expanded.sync="expanded"
                  calculate-width
        				>
                <template v-slot:header.id="{ header }"><span v-html="__('role.id')"></span></template>
                <template v-slot:header.name="{ header }"><span v-html="__('role.name')"></span></template>
                <template v-slot:header.description="{ header }"><span v-html="__('role.description')"></span></template>
                <template v-slot:header.actions="{ header }"><span v-html="__('role.actions')"></span></template>

                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="px-0">
                    <v-list color="#f1f1f1" dense>
                      <v-list-item>
                        <v-list-item-subtitle>{{__('role.id')}} - {{item.id}}</v-list-item-subtitle>
                      </v-list-item>
                      <v-list-item>
                        <v-list-item-content>{{item.description}}</v-list-item-content>
                      </v-list-item>
                    </v-list>
                  </td>
                </template>
                <template v-slot:item="{ item }">
                  <tr class="table-row">
                    <td class="d-table-cell d-md-none px-0 py-0 text-center">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                        </v-tooltip>
                      </td>
                    <td class="d-none d-md-table-cell">{{item.id}}</td>
                    <td>{{item.name}}</td>
                    <td class="d-none d-md-table-cell">{{item.description}}</td>
                    <td class="text-right">
                      <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="grey" icon @click.stop="editItem(item)" v-on="on"><v-icon small>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    </td>
                  </tr>
                </template>
        		</v-data-table>     
					</v-card>
				</v-card>
			</v-flex>
		</v-layout>
	</v-container>
    <v-dialog v-model="dialog" max-width="520px">
    	<v-card color="#fafafa">
    		<v-card-title primary-title v-html="__('role.managment')"></v-card-title>
    		<v-card-text class="py-4">
          <v-text-field
            v-model="selectedItem.new_id"
            solo
            flat
          >
            <template v-slot:label>
              <span v-html="__('role.id')"></span>
            </template>
          </v-text-field>
    			<v-text-field
    				v-model="selectedItem.name"
    				solo
    				flat
    			>
            <template v-slot:label>
              <span v-html="__('role.name')"></span>
            </template>   
          </v-text-field>
    			<v-textarea
    				v-model="selectedItem.description"
    				solo
    				flat
    			>
          <template v-slot:label>
              <span v-html="__('role.description')"></span>
            </template>     
          </v-textarea>
    		</v-card-text>
    		<v-card-actions>
    			<v-spacer></v-spacer>
    			<v-btn color="primary" text @click.stop="dialog = !dialog" v-html="__('buttons.cancel')"></v-btn>
    			<v-btn color="primary" text @click.stop="submit" v-html="__('buttons.submit')"></v-btn>
    		</v-card-actions>
    	</v-card>
    </v-dialog>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'roles_list',
  data () {
    return {
      loading: false,
      search: '',
      headers: [
        { id: 0, text: '', value: 'expanded', align: 'center', sortable: false, class: 'd-table-cell d-md-none' },
      	{ id: 1, text: __('role.id'), value: 'id', class: 'd-none d-md-table-cell' },
      	{ id: 2, text: __('role.name'), value: 'name' },
      	{ id: 3, text: __('role.description'), value: 'description', class: 'd-none d-md-table-cell' },
      	{ id: 4, text: __('role.actions'), value: 'actions', sortable: false },
      ],
      dialog: false,
      dialog_title: '',
      selectedItem: {},
      expanded: [],
    }
  },
  props: {
    user_id: Number,
  },
  components: {TheMask, snackbar, AdminPanel, FieldAccess, FieldAccessButton},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
  	this.getItems()
  },
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
  	newItem() {
  		this.selectedItem = {}
  		this.dialog_title = __('role.new_role')
  		this.dialog = true
  	},
  	editItem(item) {
  		this.selectedItem = Object.assign({}, item)
      this.selectedItem.new_id = this.selectedItem.id
  		this.dialog_title = __('role.edit_role')
  		this.dialog = true
  	},
  	submit() {
  		this.$store.dispatch('EDIT_USER_ROLE', this.selectedItem).then(res => { this.getItems() })
  	},
  	goTo(val) {
      location.href = val;
    },
    getItems() {
      this.$store.dispatch('GET_USER_ROLES', { user_id: this.user_id } ).then(res => { this.loading = false; this.dialog = false; })
      .catch(error => { this.loading = false })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
    }
  },
  computed: {
    items: {
      get() { return this.$store.state.configer_roles.items },
      set(val) { this.$store.state.configer_roles.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
  },
};
</script>

<style>
	
</style>