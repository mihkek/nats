<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
      <Alert :user_id="user_id"/>
    <v-layout row wrap>
      <v-flex md12>
        <v-card class="rounded-lg">
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 md4>
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
              <v-flex xs12 md4>
                <v-select
                  :items="types"
                  v-model="type"
                  label="Тип"
                  solo
                  flat
                  item-text="title"
                  return-object
                  hide-details
                  required
                  dense
                ></v-select>
              </v-flex>
              <v-flex xs12 md4 v-show="type.id == 1">
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
                ></v-select>
              </v-flex>
              <v-flex xs12 md4 v-show="type.id == 2">
                <v-select
                  :items="cities"
                  v-model="city"
                  label="Город"
                  v-if="auth_user.role_id == 1000"
                  solo
                  flat
                  item-text="title"
                  return-object
                  hide-details
                  required
                  dense
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
          <v-divider class="my-0"></v-divider>
          <v-data-table
              :items="items"
              :headers="table_headers"
              :search="search"
              color="transparent"
              :mobile-breakpoint="100"
              locale="ru"
              :loading="loading"
              class="rounded-card"
              :sort-by="['full_name']"
              :expanded.sync="expanded"
              calculate-width
            >
              <template v-slot:header.full_name="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.main_metro="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.main_phone="{ header }"><span v-html="header.text"></span></template>
              
              <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" class="px-0">
                  <v-list color="#fff" dense two-line subheader>
                    <v-list-item :href="'callto:'+item.main_phone" v-if="item.main_phone != ''">
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-phone</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.main_phone}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('directory_firm.phone')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item :href="'mailto:'+item.main_email" v-if="item.main_email != ''">
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-email-outline</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.main_email}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('directory_firm.email')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item :href="'https://yandex.ru/maps/?ll=37.618174%2C55.754998&mode=search&text='+item.main_address" v-if="item.address != ''">
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-web</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.main_address}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('directory_firm.address')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.main_metro != ''">
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-alpha-m-circle</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.main_metro}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('directory_firm.metro')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                  </v-list>
                </td>
              </template>
              <template v-slot:item="{ item }">
                <tr class="table-row" @click.stop="item.deleted ? goTo('/admin/directory/firms_archive/'+item.id) : goTo('/admin/directory/firms/'+item.id)">
                  <td class="d-table-cell d-md-none px-0 py-0 text-center">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                    </v-tooltip>
                  </td>
                  <td>
                    <v-list-item dense class="px-0">
                      <v-list-item-avatar size="32" class="mr-2">
                        <v-img :src="'/storage/avatars/50x50.'+item.profile_photo" v-if="item.profile_photo != '' && item.profile_photo != null"></v-img>
                        <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title class="primary--text" v-html='item.full_name'></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </td>
                  <td class="d-none d-lg-table-cell">{{item.main_metro}}</td>
                  <td class="d-none d-md-table-cell">
                    <template v-if="item.main_phone != ''">
                      <v-list-item dense class="px-0">
                        <v-list-item-icon class="mr-2">
                          <v-tooltip top>
                            <template v-slot:activator="{ on }">
                              <v-btn color="primary" class="my-icon-btn" icon :href="'callto:'+item.main_phone" small v-on="on"><v-icon small>mdi-phone-outgoing</v-icon></v-btn>
                            </template>
                            <span class="caption" v-html="__('buttons.phone_tooltip')">{{__('buttons.phone_tooltip')}}</span>
                          </v-tooltip>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title v-html='item.main_phone'></v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                  </td>
                  <td class="d-none d-md-table-cell">
                    <template v-if="item.main_email != ''">
                      <v-list-item dense  class="px-0">
                        <v-list-item-icon class="mr-2">
                          <v-tooltip top>
                            <template v-slot:activator="{ on }">
                              <v-btn color="#244467" class="my-icon-btn" icon :href="'callto:'+item.main_email" small v-on="on"><v-icon small>mdi-email-outline</v-icon></v-btn>
                            </template>
                            <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title v-html='item.main_email'></v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                  </td>
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
import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import AdminPanel from '../../snippets/AdminPanel'
import snackbar from '../../snackbar'
import Alert from '../../snippets/Alert'

export default {
  name: 'directory_firms_list',
  data () {
    return {
      search: '',
      loading: false,
      expanded: [],
      subdivision: {},
      city: {},
      type: { id: 1, title: 'Для занятий' },
      types: [
        { id: 1, title: 'Для занятий' },
        { id: 2, title: 'Торговые центры' },
      ]
    }
  },
  props: {
    user_id: Number,
    is_delete: Boolean,
  },
  components: { FieldAccess, FieldAccessButton, AdminPanel, snackbar, Alert },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id}).then(res => {
      this.getSubdivisions()
      this.getCities()
      this.checkHeaders()
    })
  },
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS').then(res => {
        this.subdivision = this.subdivisions.find(el => el.id == this.auth_user.subdivision_id)
      })
    },
    getCities() {
      this.$store.dispatch('GET_CITIES').then(res => {
        if (this.auth_user.subdivision != undefined) this.city = this.cities.find(el => el.id == this.auth_user.subdivision.city_id)
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
        city_id: this.city.id,
        type: this.type.id,
      }
      this.$store.dispatch('GET_DIRECTORY_FIRMS', params).then(res => { this.loading = false; })
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
  },
  watch: {
    auth_user: function (val) {
      this.subdivision = this.subdivisions.find(el => el.id == val.subdivision_id)
    },
    subdivision(val) {
      if (val != undefined && this.type.id == 1) {
        this.loading = true
        this.getItems()
      }
    },
    city(val) {
      if (val != undefined && this.type.id == 2) {
        this.loading = true
        this.getItems()
      }
    },
    type(val) {
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
    cities: {
      get() { return this.$store.state.cities }
    },
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    items: {
      get() { return this.$store.state.directory_firms.items },
      set(val) { this.$store.state.directory_firms.items = val }
    },
    table_headers: {
      get() { return this.$store.state.directory_firms.table_headers },
      set(val) { this.$store.state.directory_firms.table_headers = val }
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