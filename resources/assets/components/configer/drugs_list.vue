<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Панель админа" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md12>
		<v-card class="rounded-card px-4 py-4" flat>
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs8 md9>
				  <v-text-field
					backgroundColor="#f1f1f1"
					hide-details
					solo
					_flat
					prepend-icon="mdi-magnify"
					_dense
					v-model="search"
					>
					<template v-slot:label>
					  <span v-html="__('forms.search_label')"></span>
					</template>      
				  </v-text-field>
			  </v-flex>
              <v-flex xs4 md3>
				<v-spacer></v-spacer>
				<v-btn color="success" class="rounded-btn my-2" @click.stop="newItem" small style="float:right"><v-icon left>mdi-plus</v-icon> <span v-html="__('buttons.add')"></span></v-btn>
			  </v-flex>
            </v-layout>
          </v-container>
		  <v-card outlined class="rounded-card mt-1">
			<v-data-table
			  :items="items"
			  :headers="headers"
			  :search="search"
			  color="transparent"
			  :items-per-page="25"
			  :locale="$vuetify.lang.current"
			  :loading="loading"
			  :footer-props="{itemsPerPageOptions:[25,50,100,-1]}"
			  class="rounded-card"
			  :sort-by="['title']"
			  :mobile-breakpoint="100"
			  :expanded.sync="expanded"
			  calculate-width
			>
                <template v-slot:header.title="{ header }"><span v-html="__('drug.title')"></span></template>
                <template v-slot:header.active_material="{ header }"><span v-html="__('drug.active_material')"></span></template>
                <template v-slot:header.actions="{ header }"><span v-html="__('drug.actions')"></span></template>

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
                    <td>{{item.title}}</td>
                    <td class="d-none d-md-table-cell">{{item.active_material}}</td>
                    <td class="text-right">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="green" icon @click.stop="editItem(item)" v-on="on"><v-icon small>mdi-pencil</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red" icon @click.stop="deleteItem(item)" v-on="on"><v-icon small>mdi-delete</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.delete_tooltip')"></span>
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
    		<v-card-title primary-title v-html="__('drug.drug_edit')"></v-card-title>
    		<v-card-text class="py-4">
    			<v-text-field
    				v-model="selectedItem.title"
    				solo
    				flat
    			>
            <template v-slot:label>
              <span v-html="__('drug.title')"></span>
            </template>   
          </v-text-field>
    			<v-textarea
    				v-model="selectedItem.active_material"
    				solo
    				flat
    			>
          <template v-slot:label>
              <span v-html="__('drug.active_material')"></span>
            </template> 
          </v-textarea>

          <span>Аналоги (Через ;)</span>

          <v-textarea
            v-model="selectedItem.analogs"
            solo
            flat
          >
          <template v-slot:label>
              <span></span>
            </template> 
          </v-textarea>     




          <span>Действующее вещество 1</span>
          <v-textarea
            v-model="selectedItem.dv1"
            solo
            flat
          >
          <template v-slot:label>
              <span></span>
            </template> 
          </v-textarea>

          <span>Действующее вещество 2</span>
          <v-textarea
            v-model="selectedItem.dv2"
            solo
            flat
          >
          <template v-slot:label>
              <span></span>
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
    <v-dialog v-model="deletedialog" max-width="520px">
    	<v-card color="#f2f2f2">
    		<v-card-title primary-title v-html="__('drug.delete_title')"></v-card-title>
    		<v-card-text class="py-4" v-html="" style="font-size:110%; background:#fff;"><b>{{selectedItem.title}}</b><br>{{selectedItem.active_material}}</v-card-text>
    		<v-card-text class="py-4" style="font-size:110%;color:darkenred;">Эту операцию нельзя будет отменить.</v-card-text>
    		<v-card-actions>
    			<v-spacer></v-spacer>
    			<v-btn color="primary" text @click.stop="deletedialog = !deletedialog" v-html="__('buttons.cancel')"></v-btn>
				<v-btn color="red white--text" class="rounded-btn my-2" @click.stop="deletedrug" small><v-icon left>mdi-delete</v-icon> <span>Удалить</span></v-btn>
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
  name: 'drugs_list',
  data () {
    return {
      loading: false,
      search: '',
      headers: [
        { id: 0, text: '', value: 'expanded', align: 'center', sortable: false, class: 'd-table-cell d-md-none' },
      	{ id: 1, text: 'Средство', value: 'title' },
      	{ id: 2, text: 'Активное вещество', value: 'active_material', class: 'd-none d-md-table-cell' },
      	{ id: 3, text: 'Редактировать', value: 'actions', sortable: false },
      ],
      dialog: false,
      dialog_title: '',
      deletedialog: false,
      deletedialog_title: '',
      selectedItem: {
        title: null,
        active_material: null,
        analogs: null,
        dv1: null,
        dv2: null,
      },
      expanded: [],
      analog_options: [],
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
    this.getTitleOptions()
  },
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
  	newItem() {
  		this.selectedItem = {}
  		this.dialog_title = 'Новое средство'
  		this.dialog = true
  	},
  	editItem(item) {
  		this.selectedItem = Object.assign({}, item)
  		this.dialog_title = 'Изменение средства'
  		this.dialog = true
  	},
  	deleteItem(item) {
  		this.selectedItem = Object.assign({}, item)
  		this.deletedialog_title = 'Удаление средства'
  		this.deletedialog = true
  	},
  	submit() {
  		this.$store.dispatch('EDIT_DRUG', this.selectedItem).then(res => { this.getItems() })
  	},
  	deletedrug() {
  		this.$store.dispatch('DELETE_DRUG', this.selectedItem).then(res => { this.getItems() })
  	},
  	goTo(val) {
      location.href = val;
    },
    getItems() {
      this.$store.dispatch('GET_DRUGS', { user_id: this.user_id } ).then(res => { this.loading = false; this.dialog = false; this.deletedialog = false; })
      .catch(error => { this.loading = false })
    },
    getTitleOptions() {
      axios
          .get("/admin/auction/get_title_options")
          .then(response => this.analog_options = response.data)
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
    }
  },
  computed: {
    items: {
      get() { return this.$store.state.configer_drugs.items },
      set(val) { this.$store.state.configer_drugs.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
  },
};
</script>

<style>
	
</style>