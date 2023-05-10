<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <Alert :user_id="user_id"/>
    <v-layout row wrap>
      <v-flex xs12>
        <v-card class="rounded-lg">
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 md6>
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
              </v-flex>
              <v-flex xs12 md6>
                <v-select
                  :items="subdivisions"
                  v-model="subdivision"
                  label="Подразделение"
                  v-if="auth_user.role_id == 1000"
                  solo
                  flat
                  item-text="title"
                  return-object
                  hide-details
                  required
                  dense
                  class="mx-3"
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
          <v-divider class="my-0"></v-divider>
          <v-data-table
            :items="items"
            :headers="headers"
            :search="search"
            color="transparent"
            :mobile-breakpoint="100"
            :locale="$vuetify.lang.current"
            :loading="loading"
            :sort-by="['full_name']"
            :expanded.sync="expanded"
          >
            <template v-slot:expanded-item="{ headers, item }">
              <td :colspan="headers.length" class="px-0">
                <v-list color="#fff" dense two-line subheader>
                </v-list>
              </td>
            </template>
            <template v-slot:item="{ item }">
              <tr class="table-row" @click.stop="item.deleted == 'on' ? goTo('/admin/promoters/archive/'+item.id) : goTo('/admin/promoters/list/'+item.id)">
                <td class="px-2"><span class="caption">{{item.subdivision.name}}</span></td>
                <td class="px-2"><span class="caption">{{item.code_opc}}</span></td>
                <td class="px-2">
                  <v-list-item dense class="px-0 caption">
                    <v-list-item-avatar size="32" class="mr-2">
                      <v-img :src="'/storage/avatars/50x50.'+item.profile_photo" v-if="item.profile_photo != '' && item.profile_photo != null"></v-img>
                      <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title class="primary--text caption" v-html='item.full_name'></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td class="px-2"><span class="caption">{{formatDate(item.birthday)}}</span></td>
                <td class="px-2">
                  <template v-if="item.main_phone != ''">
                    <v-list-item dense class="px-0">
                      <v-list-item-icon class="mr-2">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" class="my-icon-btn " icon :href="'callto:'+item.main_phone" small v-on="on"><v-icon small>mdi-phone-outgoing</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.phone_tooltip')">{{__('buttons.phone_tooltip')}}</span>
                        </v-tooltip>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title class="caption" v-html='item.main_phone'></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </template>
                </td>
                <td class="px-2">
                  <template v-if="item.scripts_rate != null">
                    <v-chip 
                      small 
                      dark 
                      v-if="item.scripts_rate > 4" :color="item.scripts_rate > 7 ? 'green' : 'amber'" 
                      v-html="item.scripts_rate"
                      label
                    ></v-chip>
                    <v-chip 
                      small 
                      dark 
                      v-else 
                      color="red" 
                      v-html="item.scripts_rate"
                      label
                    ></v-chip>
                  </template>
                </td>
                <td class="px-2"><span class="caption">{{formatDate(item.hired_date)}}</span></td>
                <td class="px-2"><span class="caption">{{formatDate(item.fired_date)}}</span></td>
              </tr>
            </template>
          </v-data-table>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
  <snackbar />
</v-app>
</template>

<script> 
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import snackbar from '../snackbar'
import Alert from '../snippets/Alert'



export default {
  name: 'promoter_list',
  data () {
    return {
      search: '',
      loading: false,
      role_id: 102,
      expanded: [],
      headers: [
        { id: 1, text: 'Подразделение', value: 'subdivision.name', width: 150, class: 'px-2' },
        { id: 2, text: 'Код OPC', value: 'code_opc', width: 100, class: 'px-2'  },
        { id: 3, text: 'ФИО', value: 'full_name', class: 'px-2' },
        { id: 4, text: 'Дата рождения', value: 'birthday', width: 100, class: 'px-2' },
        { id: 5, text: 'Телефон', value: 'main_phone', class: 'px-2' },
        { id: 6, text: 'Знание скрипта', value: 'scripts_rate', width: 90, class: 'px-2' },
        { id: 7, text: 'Дата приема на работу', value: 'hired_date', width: 100, class: 'px-2'  },
        { id: 8, text: 'Дата увольнения', value: 'fired_date', width: 110, class: 'px-2' },
      ],
      subdivision: {},
    }
  },
  props: {
    user_id: Number,
    is_delete: Boolean,
  },
  components: { FieldAccess, FieldAccessButton, AdminPanel, snackbar, Alert },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id}).then(res =>{
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
        subdivision_id: this.subdivision.id
      }
      this.$store.dispatch('GET_PROMOTERS', params ).then(res => { this.loading = false }).then(res => {
      })
      .catch(error => { this.loading = false })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7 ('+val[0]+val[1]+val[2]+') '+val[3]+val[4]+val[5]+'-'+val[6]+val[7]+'-'+val[8]+val[9] }
      else { return val }
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
  },
  watch: {
    auth_user: function (val) {
      this.subdivision = this.subdivisions.find(el => el.id == val.subdivision_id)
    },
    subdivision(val) {
      if (val != undefined) {
        this.loading = true
        this.getItems()
      }
    },
    locale: function (val) {
      this.loading = true
      this.getItems()
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
      get() { return this.$store.state.promoters.items },
      set(val) { this.$store.state.promoters.items = val }
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

<style>
  
</style>