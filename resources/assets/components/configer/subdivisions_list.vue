<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
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
            <v-btn color="success" class="rounded-btn" href="/admin/configer/subdivisions/new" small><v-icon left>mdi-plus</v-icon> <span v-html="__('buttons.add')"></span></v-btn>
					</v-toolbar>
					<v-card outlined class="rounded-card mt-1">
						<v-data-table
							:items="items"
        			:headers="headers"
        			:search="search"
        			color="transparent"
        			:items-per-page="25"
              :mobile-breakpoint="100"
        			locale="ru"
        			:loading="loading"
        			class="rounded-card clickable_table"
              :sort-by="['name']"
              :sort-desc="['DESC']"
              @click:row="goToItem"
        		>
              <!-- <template v-slot:header.id="{ header }"><span v-html="__('user.id')"></span></template>
              <template v-slot:header.full_name="{ header }"><span v-html="__('user.full_name')"></span></template>
              <template v-slot:header.role.name="{ header }"><span v-html="__('user.role')"></span></template>
              <template v-slot:header.email="{ header }"><span v-html="__('user.email')"></span></template>
              <template v-slot:header.phone="{ header }"><span v-html="__('user.phone')"></span></template>
              <template v-slot:header.created="{ header }"><span v-html="__('user.created_at')"></span></template> -->
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
import {mask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'users_list',
  data () {
    return {
      search: '',
      headers: [
        { value: 'id', text: 'ID' },
        { value: 'name', text: 'Наименование' },
        { value: 'full_name', text: 'Полное имя' },
        { value: 'city.name', text: 'Город' },
        { value: 'inn', text: 'ИНН' },
      ],
    }
  },
  props: {
    user_id: Number,
  },
  components: {snackbar, AdminPanel, FieldAccess, FieldAccessButton},
  mounted() {
    this.loading = true
    this.getItems()
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
  },
  methods: {
    goToItem(item) {
      location.href = '/admin/configer/subdivisions/card/'+item.id
    },
    getItems() {
      this.$store.dispatch("GET_CONFIGER_SUBDIVISIONS").then(res => {

      })
      .finally(() => (this.loading = false))
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
    },
    locale: function (val) {
      this.loading = true
      this.getItems()
    },
  },
  computed: {
    items: {
      get() { return this.$store.state.configer_subdivisions.items },
      set(val) { this.$store.state.configer_subdivisions.items = val }
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