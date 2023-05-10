<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <Alert :user_id="id"/>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card flat class="rounded-card py-2 px-2" height="100%">
            <v-card-title class="text-center text-uppercase" v-html="__('dashboard.today_orderers')"></v-card-title>
            <v-card-text>
              <v-card color="#fafafa" flat>
              <v-data-table
                :items="today_orderers"
                :headers="headers"
                locale="ru"
                class="dialog-datatable"
                hide-default-footer
                color="transparent"
                :sort-by="['date_time']"
                :mobile-breakpoint="100"
                :expanded.sync="expanded"
                :sort-desc="['DESC']"
                calculate-width
              >
                <template v-slot:header.date_time="{ header }"><span v-html="__('orderer.title')"></span></template>
                <template v-slot:header.status="{ header }"><span v-html="__('orderer.status')"></span></template>
                <template v-slot:header.customer_id="{ header }"><span v-html="__('orderer.customer')"></span></template>


                <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" class="px-0">
                  <v-list color="#fafafa">
                    <v-list-item v-if="item.directory_firm != null" :href="'/admin/directory/firms/'+item.directory_firm.id">
                      <v-list-item-icon class="mr-4">
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.directory_firm.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_firm.avatar" alt=""></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.directory_firm.full_name}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('orderer.directory_firm')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.directory_person != null" :href="'/admin/directory/people/'+item.directory_person.id">
                      <v-list-item-icon class="mr-4">
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.directory_person.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_person.avatar" alt=""></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.directory_person.full_name}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('orderer.directory_person')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="item.directory_firm_amount != ''">
                      <v-list-item-icon class="mr-4"><v-icon color="primary">mdi-cash</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{formatPrice(item.directory_firm_amount)}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('orderer.directory_firm_amount')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                  <v-divider class="my-0"></v-divider>
                </td>
              </template>
                <template v-slot:item="{ item }">
                  <tr class="table-row" @click.stop="selectRow(item)">
                    <td class="d-table-cell px-0 py-0 text-center">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                      </v-tooltip>
                    </td>
                    <td class="caption"><span class="d-none d-md-flex">{{formatDate(item.date)}}<br /></span>{{item.time}}</td>
                    <td class="white--text" >
                      <v-chip :color="item.order_status.color_calendar" small style="border-radius: 16px !important;">
                        <span class="white--text" v-html="item.order_status.title"></span>
                      </v-chip>
                    </td>
                    <td class="ava caption">
                      <template v-if="item.customer_id != null">
                        <div v-if="item.customer.avatar != null"><img :src="'/storage/avatars/50x50.'+item.customer.avatar" alt=""></div>
                        <div v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                        <div>
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <a :href="'/admin/customer/list/card/'+item.customer_id" v-on="on">{{item.customer.full_name || ''}}</a>
                          </template>
                          <span class="caption" v-html="__('buttons.customer_tooltip')"></span>
                        </v-tooltip>
                        </div>
                      </template>
                    </td>
                    <!-- <td class="ava caption d-none d-md-table-cell">
                      <template v-if="item.directory_firm_id != null">
                        <div class="pr-1" v-if="item.directory_firm.avatar != null"><img :src="'/storage/avatars/50x50.'+item.directory_firm.avatar" alt=""></div>
                        <div class="pr-1" v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                        <div>
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <a :href="'/admin/directory/firms/'+item.directory_firm_id" v-on="on">{{item.directory_firm.full_name || ''}}</a>
                          </template>
                          <span class="caption">Открыть карточку помещения</span>
                        </v-tooltip>
                        </div>
                      </template>
                      <template v-if="item.orderer_additional_place_id != null">
                        <div class="pr-1" v-if="item.additional_place.avatar != null"><img :src="'/storage/avatars/additional_places/'+item.additional_place.avatar" alt=""></div>
                        <div class="pr-1" v-else><img src="/storage/avatars/50x50.nophoto.png" alt=""></div>
                        <div>{{item.additional_place.title || ''}}</div>
                      </template>
                    </td> -->
                  </tr>
                </template>
              </v-data-table>
              </v-card>
            </v-card-text>
            <v-card flat class="text-center py-4 mb-4">
                <v-btn color="success" class="my-1 mx-1 rounded-btn" depressed href="/admin/orderer/now" small><v-icon left small>mdi-format-list-bulleted</v-icon><span v-html="__('buttons.list')"></span></v-btn>
                <v-btn color="success" class="my-1 mx-1 rounded-btn" depressed href="/admin/orderer/calendar" small><v-icon left small>mdi-calendar</v-icon><span v-html="__('buttons.calendar')"></span></v-btn>
            </v-card>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>
          <v-card flat class="rounded-card py-4 px-4" height="100%">
              <v-list-item three-line class="mt-4">
                <v-list-item-content>
                <v-list-item-title class="display-4 text-center primary--text font-weight-bold mb-2">0</v-list-item-title>
                <v-list-item-subtitle class="title font-weight-regular text-center mb-4 black--text">РУБЛЕЙ</v-list-item-subtitle>
                <v-list-item-subtitle class="subtitle-1 text-center mb-4">Начислено за работу с даты последней оплаты</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <v-card flat class="text-center mt-2">
                <v-btn color="primary" class="my-1 mx-1 rounded-btn" depressed href="/admin/billing/history"><v-icon left>mdi-wallet</v-icon>ФИНАНСЫ</v-btn>
              </v-card>
          </v-card>
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card flat class="rounded-card py-4 px-4" height="100%">
              <v-list-item three-line class="mt-4">
                <v-list-item-content>
                <v-list-item-title class="display-4 text-center primary--text font-weight-bold mb-2">0</v-list-item-title>
                <v-list-item-subtitle class="title font-weight-regular text-center mb-4 black--text">РУБЛЕЙ</v-list-item-subtitle>
                <v-list-item-subtitle class="subtitle-1 text-center mb-4">Начислено за привлеченных клиентов</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <v-card flat class="text-center mt-2 pb-4 mb-4">
                <v-btn color="primary" dark class="my-1 mx-1 rounded-btn" depressed href="/admin/billing/history"><v-icon left>mdi-wallet</v-icon>ФИНАНСЫ</v-btn>
                <v-btn color="primary" dark class="my-1 mx-1 rounded-btn" depressed href="/admin/afillater"><v-icon left>mdi-link-variant</v-icon>СПИСОК ПРИГЛАШЕННЫХ</v-btn>
              </v-card>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>
          <v-card flat class="rounded-card py-4 px-4" height="100%">
              <v-list-item three-line class="mt-4">
                <v-list-item-content>
                <v-list-item-title class="display-4 text-center primary--text font-weight-bold mb-2"><v-icon size="80" color="primary">mdi-account</v-icon></v-list-item-title>
                <v-list-item-subtitle class="title font-weight-regular text-center mb-4 black--text" v-html="__('dashboard.personal_settings')"></v-list-item-subtitle>
                <v-list-item-subtitle class="subtitle-1 text-center mb-4" v-html="__('dashboard.personal_settings_text')"></v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <v-card flat class="text-center mt-2 pb-4 mb-4">
                <v-btn color="primary" dark class="my-1 mx-1 rounded-btn" depressed href="/admin/settings/personal"><v-icon left>mdi-cogs</v-icon><span v-html="__('buttons.edit')"></span></v-btn>
              </v-card>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-app>
</template>

<script> 
import Alert from '../snippets/Alert'

export default {
  name: 'directory_firm_dashboard',
  data () {
    return {
      next_orderer: {},
      headers: [
        { text: '', value: 'expanded', width: 30, align: 'center', sortable: false },
        { text: 'Занятие',  value: 'date_time' },
        { text: 'Статус',  value: 'status' },
        { text: 'Клиент',  value: 'customer_id' },
        /*{ text: 'Сумма',  value: 'amount' },*/
      ],
      items: [],
      expanded: [],
    }
  },
  mounted() {
    this.getTodayOrders()
  },
  components: {
    Alert
  },
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    selectRow(item) {
      location.href = '/admin/orderer/now/card/'+item.id
    },
    actionItem(val) {
      this.selectedItem = Object.assign({}, this.next_orderer)
      this.selectedItem.action_type = val
      this.ordererdialog = true
    },
    getTodayOrders() {
      this.$store.dispatch('GET_USER_TODAY_ORDERERS', { id: this.$props.id })
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    formatDateWithoutYear (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}`
    },
    formatDateTime(val) {
      return val
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
  },
  props: {
    id: Number,
  },
  watch: {
    today_orderers: function(val) {
      this.today_orderers.map(orderer => {
        this.status_options.map(option => {
          if (option.title == option.text) {
            option.title = '<span class="no_translate">'+option.text+'</span>'
          }
          if (option.id == orderer.status) {
            orderer.order_status = option
          }
        })
      })
    },
  },
  computed: {
    selectedItem: {
      get() { return this.$store.state.selectedItem },
      set(val) { this.$store.state.selectedItem = val }
    },
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    },
    today_orderers: {
      get() { return this.$store.state.users.today_orderers },
      set(val) { this.$store.state.users.today_orderers = val }
    },
    status_options: {
      get() { return this.$store.state.orderers.status_options },
    }
  },
};
</script>
