<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
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
					  	  label="Поиск"
					  	></v-text-field>
						</v-toolbar-items>
						<v-spacer></v-spacer>
						<v-btn color="success" @click.stop="newItem" small to="/admin/configer/roles/new">Добавить</v-btn>
					</v-toolbar>
					<v-card outlined class="rounded-card mt-1">
						<v-data-table
							:items="items"
        					:headers="headers"
        					:search="search"
        					color="transparent"
        					:items-per-page="25"
        					locale="ru"
        					:loading="loading"
        					class="rounded-card"
              				:sort-by="['id']"
        				>
        				<template v-slot:item.actions="{ item }">
        					<v-tooltip top>
        						<template v-slot:activator="{ on }">
        							<v-btn color="grey" icon @click.stop="editItem(item)" v-on="on"><v-icon small>mdi-sync</v-icon></v-btn>
        						</template>
        						<span class="caption">Редактировать</span>
        					</v-tooltip>
    					</template>
        				</v-data-table>     
					</v-card>
				</v-card>
			</v-flex>
		</v-layout>
	</v-container>
    <v-dialog v-model="dialog" max-width="420px">
    	<v-card color="#fafafa">
    		<v-card-title primary-title>{{dialog_title}}</v-card-title>
    		<v-card-text class="py-4">
    			<v-text-field
    				label="Наименование"
    				v-model="selectedItem.name"
    				solo
    				flat
    			></v-text-field>
    			<v-textarea
    				label="Описание"
    				v-model="selectedItem.description"
    				solo
    				flat
    			></v-textarea>
    		</v-card-text>
    		<v-card-actions>
    			<v-spacer></v-spacer>
    			<v-btn color="primary" text @click.stop="dialog = !dialog">Отмена</v-btn>
    			<v-btn color="primary" text @click.stop="submit">Сохранить</v-btn>
    		</v-card-actions>
    	</v-card>
    </v-dialog>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'


export default {
  name: 'roles_list',
  data () {
    return {
      loading: false,
      search: '',
      headers: [
      	{ id: 1, text: 'ID', value: 'id' },
      	{ id: 2, text: 'Наименование', value: 'name' },
      	{ id: 3, text: 'Описание', value: 'description' },
      	{ id: 4, text: 'Действия', value: 'actions', sortable: false },
      ],
      dialog: false,
      dialog_title: '',
      selectedItem: {},
    }
  },
  props: {
    user_id: Number,
  },
  components: {TheMask, snackbar},
  mounted() {
    this.loading = true
  	this.getItems()
  },
  methods: {
  	newItem() {
  		this.selectedItem = {}
  		this.dialog_title = 'Добавить роль'
  		this.dialog = true
  	},
  	editItem(item) {
  		this.selectedItem = Object.assign({}, item)
  		this.dialog_title = 'Редактировать роль'
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
  },
  computed: {
    items: {
      get() { return this.$store.state.configer_roles.items },
      set(val) { this.$store.state.configer_roles.items = val }
    },
  },
};
</script>

<style>
	
</style>