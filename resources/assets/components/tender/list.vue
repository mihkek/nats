<template>
  <v-app>
    <v-main>
      <v-container fluid id="main" grid-list-xl class="px-0 py-0">

        <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
          <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
        </FieldAccess>
        <input v-model="savedOptions" style="position:absolute; visibility: hidden;"/>
        <v-layout row wrap>
          <template v-if="deleted!=true">
            <v-flex xs12>
              <v-card flat color="transparent">
                <v-container fluid class="pa-0">
                  <v-layout row wrap>
                    <v-flex :class="now ? 'md6 xs12' : 'md3 xs12' ">
                      <v-card flat class="rounded-lg">
                        <v-text-field
                            prepend-inner-icon="mdi-magnify"
                            label="Поиск"
                            solo
                            hide-details
                            v-model="filter.search"
                            @change="getItems"
                        ></v-text-field>
                      </v-card>
                    </v-flex>
                    <v-flex :class="now ? 'md6 xs12' : 'md3 xs12' ">
                      <v-autocomplete
                          prepend-inner-icon="mdi-map-marker-outline"
                          :items="delivery_regions"
                          v-model="filter.region"
                          label="Регион"
                          item-text="title"
                          item-value="id"
                          solo
                          multiple
                          hide-details
                          @change="getItems"
                      >
                        <template v-slot:selection="{ item, index }">
						<span
                v-if="filter.region.length > 0 && index === 0"
                _lass="text-caption"
            >
						  {{ regionName(filter.region.length) }}
						</span>
                        </template>
                      </v-autocomplete>
                    </v-flex>

                    <v-flex md6 xs12 v-if="now == false">
                      <v-card class="px-2">
                        <v-chip-group multiple v-model="status_group">
                          <template>
                            <v-chip
                                label
                                v-for="(status, i) in status_options"
                                :key="i+1"
                                :color="status.color_calendar"
                                dark
                                :outlined="status_group.indexOf(i) == -1"
                                :active-class="'white--text'"
                            >
                              {{ status.title }}
                            </v-chip>
                          </template>
                        </v-chip-group>
                      </v-card>
                    </v-flex>
                  </v-layout>
                  <v-layout row wrap>
                    <v-flex xs12 md4>
                      <v-select
                          :items="date_options"
                          item-text="text"
                          item-value="value"
                          v-model="filter.date_filter"
                          solo
                          hide-details
                          @change="getItems"
                      ></v-select>
                    </v-flex>
                    <v-flex md8 xs12>
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
                  </v-layout>
                </v-container>
              </v-card>
            </v-flex>
          </template>
          <v-flex xs12>
            <v-card class="my-4" tile>
              <v-data-table
                  :items="items"
                  :headers="headers"
                  :mobile-breakpoint="100"
                  :locale="$vuetify.lang.current"
                  :loading="loading"
                  calculate-widths
                  :footer-props="{itemsPerPageOptions:[25,50,100]}"
                  :options.sync="options"
              >
                <template v-slot:item="{ item }">
                  <template v-if="deleted==true">
                    <tr class="table-row font-weight-medium">
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.article }}</p>
                            <v-list-item-subtitle style="font-weight:400;">{{ item.created_formated }}
                            </v-list-item-subtitle>

                              
                          </v-list-item-content>
                        </v-list-item>
                      </td>


                      <td style="max-width: 30vw;">
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <v-list-item-title style="white-space: normal;">{{ item.title }}</v-list-item-title>
                            <v-list-item-subtitle>{{ item.delivery_region }}</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.active_material }}</p>
                            <v-list-item-subtitle v-if="item.is_analog == 1">или аналог</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.size }} {{ item.unit }}</p>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.date_formated }}

                              <v-tooltip top v-if="item.deliv_interval < 4" content-class='custom-tooltip'>
                                <template v-slot:activator="{ on }">
                                  <v-icon size="18" color="orange" v-on="on"
                                          style="position:absolute; margin:-2px 0 0 3px;">mdi-truck-fast
                                  </v-icon>
                                </template>
                                <span class="caption">Доставка {{ item.delivery_date_formated }}</span>
                              </v-tooltip>

                            </p>
                            <v-list-item-subtitle
                                :style="item.datediff < 0 ? 'color:#c66;' : item.datediff < 14 ? 'color:#d94;font-weight:400;' : 'font-weight:400;' ">
                              {{ item.datediff }} дн.
                            </v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content v-if="item.rate != undefined">
                            <v-list-item-title class="title success--text" v-if="auth_user.role_id == 102"
                                               style="line-height:90%;">
                              {{ formatPrice(item.rate.price * item.size) }} ₽<br>
                              <span
                                  class="grey--text font-weight-normal text-subtitle-2">({{
                                  formatPrice(item.rate.price)
                                }} ₽/{{ item.unit }})</span>
                            </v-list-item-title>
                            <v-list-item-title class="title success--text" v-else>{{ formatPrice(item.rate.price) }}
                              ₽<span class="font-weight-light">/{{ item.unit }}</span></v-list-item-title>

                          </v-list-item-content>
                          <v-list-item-content v-else>
                            <v-list-item-title class="grey--text text--lighten-1 title">0 ₽</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item-actions>
                          <v-list-item-action>
                            <v-btn color="success" depressed class="rounded-btn   text-decoration-none"
                                   v-on:click="deleteItem(item.id,index)">Восстановить
                            </v-btn>
                          </v-list-item-action>
                          <v-list-item-action>
                            <v-btn color="success" depressed class="rounded-btn  text-decoration-none"
                                   @click.stop="goTo(item)">Посмотреть
                            </v-btn>
                          </v-list-item-action>
                        </v-list-item-actions>

                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr class="table-row font-weight-medium" @click.stop="goTo(item)"> <!---->
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.article }}      

      <v-tooltip right
      v-if="auth_user.role_id === 102 && own === false"    
           
      >
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
           @click.stop="addMyTender(item.id)"   
        >
          mdi-basket
        </v-icon>
      </template>
      <span>Добавить в мои тендеры</span>
    </v-tooltip>


                            <!--<v-chip
                                label                             
                                v-if="auth_user.role_id === 102 && own === false"    
                                @click.stop="addMyTender(item.id)"                      
                            >
                              <v-icon
                                  size="20"
                                  center
                              >mdi-basket
                              </v-icon>                           
                            </v-chip>-->

                            </p>
                            <v-list-item-subtitle style="font-weight:400;">{{ item.created_formated }}
                            </v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td style="max-width: 30vw;">
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <v-list-item-title style="white-space: normal;">{{ item.title }}</v-list-item-title>
                            <v-list-item-subtitle>{{ item.delivery_region }}</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.active_material }}</p>
                            <v-list-item-subtitle v-if="item.is_analog == 1">или аналог</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.size }} {{ item.unit }}</p>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content>
                            <p class="my-0">{{ item.date_formated }}

                              <v-tooltip top v-if="item.deliv_interval < 4" content-class='custom-tooltip'>
                                <template v-slot:activator="{ on }">
                                  <v-icon size="18" color="orange" v-on="on"
                                          style="position:absolute; margin:-2px 0 0 3px;">mdi-truck-fast
                                  </v-icon>
                                </template>
                                <span class="caption">Доставка {{ item.delivery_date_formated }}</span>
                              </v-tooltip>

                            </p>
                            <v-list-item-subtitle
                                :style="item.datediff < 0 ? 'color:#c66;' : item.datediff < 14 ? 'color:#d94;font-weight:400;' : 'font-weight:400;' ">
                              {{ item.datediff }} дн.
                            </v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>
                        <v-list-item class="px-0">
                          <v-list-item-content v-if="item.rate != undefined">
                            <v-list-item-title class="title success--text" v-if="auth_user.role_id == 102"
                                               style="line-height:90%;">
                              {{ formatPrice(item.rate.price * item.size) }} ₽<br>
                              <span
                                  class="grey--text font-weight-normal text-subtitle-2">({{
                                  formatPrice(item.rate.price)
                                }} ₽/{{ item.unit }})</span>
                            </v-list-item-title>
                            <v-list-item-title class="title success--text" v-else>{{ formatPrice(item.rate.price) }}
                              ₽<span class="font-weight-light">/{{ item.unit }}</span></v-list-item-title>

                          </v-list-item-content>
                          <v-list-item-content v-else>
                            <v-list-item-title class="grey--text text--lighten-1 title">0 ₽</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </td>
                      <td>

                        <template v-if="item.status == 0">
                          <v-chip
                              label
                              color="red"
                              dark
                          >
                            <v-icon
                                size="20"
                                left
                            >mdi-cancel
                            </v-icon>
                            <span>Отменен</span>
                          </v-chip>
                        </template>
                        <template v-if="item.status == 1">
                          <v-chip
                              label
                              v-if="item.user_rate != undefined"
                              :color="item.rate.price == item.user_rate.price ? 'success' : 'orange' "
                              dark
                          >
                            <v-icon
                                v-html="item.rate.price == item.user_rate.price ? 'mdi-progress-check' : 'mdi-progress-alert' "
                                size="20"
                                left
                            ></v-icon>
                            <span>{{ formatPrice(item.user_rate.price) }} ₽</span>
                          </v-chip>

                          <v-chip
                              label
                              v-else-if="item.rate != undefined"
                          >
                            <v-icon
                                size="20"
                                left
                            >mdi-progress-clock
                            </v-icon>
                            <span>Идут торги</span>
                          </v-chip>

                          <v-chip
                              label
                              v-else
                              color="info"
                          >
                            <v-icon
                                size="20"
                                left
                            >mdi-plus-circle-outline
                            </v-icon>
                            <span>Новый</span>
                          </v-chip>
                        </template>
                        <template v-if="item.status == 2">
                          <v-chip
                              label
                              color="teal"
                              dark
                          >
                            <v-icon
                                size="20"
                                left
                            >mdi-flag
                            </v-icon>
                            <span>Завершен</span>
                          </v-chip>
                        </template>
                        


                      </td>
                    </tr>
                  </template>


                </template>

              </v-data-table>
            </v-card>
          </v-flex>
        </v-layout>

        <v-toolbar color="transparent" flat dense v-if="auth_user.role_id == 1000">
          <v-spacer></v-spacer>
          <v-btn color="warning" class="rounded-btn" @click.stop="getXls()" small>
            <v-icon left>mdi-download</v-icon>
            <span>Скачать в XLS</span></v-btn>
        </v-toolbar>
      </v-container>





    <v-container fluid v-if="auth_user.role_id == 1000 || auth_user.role_id == 101">
        <v-card flat color="transparent">
            <v-flex xs2 class="float-left">
                <a href="http://www.proagro.su/" target="_blank">
                    <img class='img-responsive' src="/img/banners/proagro-1.jpg" style="padding: 3px;">
                </a>
            </v-flex>
            <v-flex xs2 class="float-left">
                <a href="https://b2bservice.su/" target="_blank">
                    <img class='img-responsive' src="/img/banners/betobe-1.jpg" style="padding: 3px;">
                </a>
            </v-flex>
            <v-flex xs2 class="float-left">
                <a href="http://www.flora-center.ru/" target="_blank">
                    <img class='img-responsive' src="/img/banners/101.jpg" style="padding: 3px;">
                </a>
            </v-flex>
            <v-flex xs2 class="float-left">
                <a href="https://b2bservice.su/" target="_blank">
                    <img class='img-responsive' src="/img/banners/102.jpg" style="padding: 3px;">
                </a>
            </v-flex>
            <v-flex xs2 class="float-left">
                <a href="http://www.proagro.su/" target="_blank">
                    <img class='img-responsive' src="/img/banners/proagro-3.jpg" style="padding: 3px;">
                </a>
            </v-flex>
            <v-flex xs2 class="float-left">
                <a href="https://b2bservice.su/" target="_blank">
                    <img class='img-responsive' src="/img/banners/betobe-2.jpg" style="padding: 3px;">
                </a>
            </v-flex>
        </v-card>
    </v-container>


    </v-main>
  </v-app>
</template>

<script>
import auction_smallcard from './smallcard'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import delivery_regions_data from '../constants/delivery_regions_data.js'

export default {
  name: 'tender_list',
  data() {
    return {
      filter: {
        search: '',
        date_from: '',
        date_to: '',
        date_filter: 1,
        selected_status: [],
        region: '',
      },
      headers: [
        {text: 'Номер', value: 'created_at', width: 190},

        {text: 'Наименование / Регион поставки', value: 'title'},
        {text: 'Активное вещество', value: 'active_material'},
        {text: 'Объем', value: 'size'},
        {text: 'Дата окончания', value: 'over_date'},
        {text: 'Текущее предложение', value: 'rate.price'},
        {text: 'Статус', value: 'rates.length', width: 170},
      ],
      search: '',
      expanded: [],
      date_options: [
        {text: 'Дата окончания', value: 1},
        {text: 'Дата создания', value: 2},
      ],
      date_filter: 1,
      deal_options: [
        {text: 'Без назначенного дела', value: 1},
        {text: 'С просроченным делом', value: 2},
        {text: 'Без ответственного', value: 3},
        {text: 'Содержит жалобу', value: 4},
      ],
      deal_filter: '',
      false_options: [
        {text: 'Живут далее 50 км.', value: 1},
        {text: 'Не тот клиент', value: 2},
        {text: 'Ребенок инвалид', value: 3},
        {text: 'Анкету заполнили без родителя', value: 4},
        {text: 'Клиента заставили оставить данные', value: 5},
        {text: 'Клиенту ничего не рассказывали про школу', value: 6},
        {text: 'Лид заполнен не на родителя', value: 7},
      ],
      false_value: '',
      selected_status: [],
      date_from: '',
      date_to: '',
      selectedItems: [],
      selected: {},
      tabledialog: false,
      false_dialog: false,
      status_dialog: false,
      action_loading: false,
      new_status: '',
      deal_date: '',
      deal_time: '',
      status_dialog_type: '',
      delete_dialog: false,
      status_group: [],
      notifications_filter: null,
      subdivision: {},
      confirm_dialog: false,

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
      delivery_regions: delivery_regions_data.delivery_regions_data,
    }
  },
  props: {
    user_id: Number,
    status: Array,
    type: String,
    own: Boolean,
    now: Boolean,
    deleted: Boolean,
  },
  mounted() {
    this.restoreOptions()
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
//	if (this.own == true) this.now = null
//    console.log('own:'+this.own+' now:'+this.now)
    this.getItems()
  },
  methods: {

    //150122
    addMyTender(id) {
       let params = {};
       params.auction_id = id; 
       params.user_id = this.user_id;      
       axios.post('/api/auction/add_my_tender', params).then(res => {
        alert("Тендер добавлен в мои тендеры");         
       });
    },

    deleteItem(item, index) {
      event.preventDefault();
      let app = this;
      this.axios.get('/admin/my-auction/delete/' + item).then(response => {
        app.items.splice(index, 1);
      }).catch(error => {
        return error.response.data;
      });
    },
    goTo(item) {
      let val = ''
      if (item.status == 1) {
        if (item.type == 'rise') val = '/admin/auction/now/card/' + item.id
        else if (item.type == 'drop') val = '/admin/tender/now/card/' + item.id
      } else {
        if (item.type == 'rise') val = '/admin/auction/list/card/' + item.id
        else if (item.type == 'drop') val = '/admin/tender/list/card/' + item.id
      }
      location.href = val
    },
    getItems() {
      this.loading = true
      let params = {
        status: this.status,
        user_id: this.user_id,
      }
      if (this.filter.selected_status.length > 0) params.status = this.filter.selected_status
      else params.status = this.$props.status
      params.date_filter = this.filter.date_filter
      params.date_from = this.filter.date_from
      params.date_to = this.filter.date_to
      params.user_id = this.user_id
      params.type = this.type
      params.now = this.now
      params.own = this.own
      params.search = this.filter.search
      params.region = this.filter.region
      params.deleted_auction = this.deleted == true ? 1 : 0
      //      console.log(params)
      this.$store.dispatch('GET_TENDERS', params).then(res => {
        this.options.page = this.page
        this.setHistory()
      })
          .finally(() => (this.loading = false))
    },
    formatPrice(value) {
      if (value != null) {
        let val = (value / 1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      } else {
        return '0.00'
      }
    },
    getXls() {
      this.loading = true
      let params = {
        status: this.status,
        user_id: this.user_id,
        excel: true,
      }
      if (this.filter.selected_status.length > 0) params.status = this.filter.selected_status
      else params.status = this.$props.status
      params.date_filter = this.filter.date_filter
      params.date_from = this.filter.date_from
      params.date_to = this.filter.date_to
      params.user_id = this.user_id
      params.type = this.type
      params.now = this.now
      params.own = this.own
      params.search = this.filter.search
      params.region = this.filter.region
      axios.post('/admin/auction/get', params).then(res => {
        if (res.data.status != 1) console.log(res.data)
        else location.href = res.data.link
      })
          .finally(() => (this.loading = false))
    },
    restoreOptions() {
      this.savedOptions = this.defaultOptions
      this.queryString =
          '?sb=' + this.options.sortBy +
          '&sd=' + this.options.sortDesc +
          '&p=' + this.options.page +
          '&pp=' + this.options.itemsPerPage +
          '&s=' + this.filter.search +
          '&df=' + this.filter.date_from +
          '&dt=' + this.filter.date_to +
          '&dfr=' + this.filter.date_filter +
          '&l=' + this.filter.region +
          '&st=' + this.filter.selected_status
      /*
            '?sb='+this.options.sortBy+
            '&sd='+this.options.sortDesc+
            '&p='+this.options.page+
            '&pp='+this.options.itemsPerPage+
            '&s='+this.filter.search+
            '&df='+this.filter.date_from+
            '&dt='+this.filter.date_to+
            '&l='+this.filter.region+
            '&st='+this.filter.selected_status
      */
//		console.log('restore', window.location.search)
      if (window.location.search && window.location.search != this.queryString) {
//			console.log('restore loading saved', window.location.search)
        this.queryString = window.location.search
        this.savedOptions.sortBy = [this.optionFromQS('sb')] || this.defaultOptions.sortBy
        this.savedOptions.sortDesc = [this.optionFromQS('sd') == 'true' ? true : false] || this.defaultOptions.sortDesc
        this.savedOptions.page = this.optionFromQS('p') || this.defaultOptions.page
        this.savedOptions.itemsPerPage = this.optionFromQS('pp') || this.defaultOptions.itemsPerPage
        this.filter.search = this.optionFromQS('s') || this.filter.search
        this.filter.date_from = this.optionFromQS('df') || this.filter.date_from
        this.filter.date_to = this.optionFromQS('dt') || this.filter.date_to
        this.filter.date_filter = this.optionFromQS('dfr') * 1 || this.filter.date_filter
        this.filter.selected_status = this.optionFromQS('st').length > 0 ? this.optionFromQS('st').split(',') : this.$props.status
        this.filter.region = this.optionFromQS('l').length > 0 ? this.optionFromQS('l').split(',') : this.filter.region
        var temp_statuses = []
        this.status_options.forEach((status_option, i) => {
          if (!!~this.filter.selected_status.indexOf(status_option.id.toString())) {
            temp_statuses.push(i)
          }
        })
        this.status_group = temp_statuses
      }
      this.page = this.savedOptions.page
      this.options = this.savedOptions
//		console.log('restore options', this.options)
    },
    setHistory() {
      this.queryString =
          '?sb=' + this.options.sortBy +
          '&sd=' + this.options.sortDesc +
          '&p=' + this.options.page +
          '&pp=' + this.options.itemsPerPage +
          '&s=' + this.filter.search +
          '&df=' + this.filter.date_from +
          '&dt=' + this.filter.date_to +
          '&dfr=' + this.filter.date_filter +
          '&l=' + this.filter.region +
          '&st=' + this.filter.selected_status

//	  console.log('watch options', this.options)
//	  console.log('watch search', window.location.search)
//	  console.log('watch queryString', this.queryString)
      if (this.queryString != window.location.search) {
//	    console.log('watch replaceState', this.queryString)
        history.replaceState(null, null, this.queryString)
      }
      this.savedOptions = this.options
    },
    optionFromQS(name) {
      var url = window.location.href
      name = name.replace(/[\[\]]/g, '\\$&')
      var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'), results = regex.exec(url)
      if (!results) return null
      if (!results[2]) return ''
      return decodeURIComponent(results[2].replace(/\+/g, ' '))
    },
    regionName(number) {
      if (number % 100 > 10 && number % 100 < 20) return number + ' регионов '
      if (number % 10 == 1) return number + ' регион '
      if (number % 10 > 0 && number % 10 < 5) return number + ' региона '
      return number + ' регионов '
    },
  },
  components: {
    auction_smallcard,
    FieldAccess,
    FieldAccessButton,
    AdminPanel
  },
  watch: {
    filter: function () {
//	  console.log('filter updated');
      this.setHistory()
      this.getItems()
    },
    status_group(val) {
      this.filter.selected_status = []
      val.map(i => {
        this.filter.selected_status.push(this.status_options[i].id)
      })
      this.setHistory()
      this.getItems()
    },
    options: function () {
      this.setHistory()
    },
  },
  computed: {
    loading: {
      get() {
        return this.$store.state.loading
      },
      set(val) {
        this.$store.state.loading = val
      }
    },
    items: {
      get() {
        return this.$store.state.auction.tenders
      }
    },
    auth_user: {
      get() {
        return this.$store.state.auth_user
      },
    },
    status_options: {
      get() {
        return this.$store.state.auction.status_options
      },
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
};
</script>
<style>
.custom-tooltip {
  margin-top: -3.5em;
}
.v-input__slot .v-select__selections span {
  margin-right: 5px;
}
</style>
