<template>
  <v-card flat outlined class="mb-3">
    <v-card-title class="my-0" style="background: #fdfdfd;">
      <v-spacer></v-spacer>
      <span class="h4" v-if="this.auth_user.id"><span v-if="this.auth_user.role_id == 101">Ваши</span><span
          v-else>Мои</span> тендеры</span>
      <v-spacer></v-spacer>
    </v-card-title>
    <v-divider class="my-0"></v-divider>
    <v-data-table
        :items="items"
        :headers="headers"
        :mobile-breakpoint="100"
        :locale="$vuetify.lang.current"
        :loading="loading"
        :sort-by="['created_at']"
        :sort-desc="['DESC']"
        calculate-widths
        hide-default-header
        hide-default-footer
        dense
    >

      <!-- СТРОЧКА ТАБЛИЦЫ -->
      <template v-slot:item="{ item,index }">
        <tr class="table-row font-weight-medium">
          <td class="pa-0" :colspan="headers.length">
            <v-card flat color="transparent">

              <v-list-item three-line :href="(item.auction.type==='drop') ? '/admin/tender/now/card/'+item.auction_id : '/admin/auction/now/card/'+item.auction_id" class="text-decoration-none">
                <v-list-item-content>
                  <v-list-item-title>
                    <span class="h5">{{ item.auction.title }}</span>
                  </v-list-item-title>
                  <v-list-item-subtitle>
                    {{ item.auction.active_material }} <span v-if="item.auction.is_analog == 1">или аналог</span>
                  </v-list-item-subtitle>
                  <v-card-actions class="pa-0 mt-1 mb-0">
                    <span class="caption grey--text" style="line-height:125%;"
                          v-html="item.created_formated+''+((item.auction.delivery_condition == 2 || item.auction.delivery_condition == 3) ? '<br>'+item.auction.delivery_region : '')"></span>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-list-item-content>
                <v-list-item-action>
                  <span class="font-weight-bold success--text mb-2"
                        v-if="item.price != undefined">{{ formatPrice(item.auction.price) }} ₽<span
                      class="font-weight-light">/{{ item.auction.unit }}</span></span>
                  <span class="font-weight-bold success--text mb-2" v-else>0 ₽</span>
                  <!--                  <span class="caption grey&#45;&#45;text">до {{ item.over_date }}</span>-->
                </v-list-item-action>
                <v-list-item-action>
                  <v-btn color="success" depressed class="rounded-btn  text-decoration-none"
                         v-on:click="deleteItem(item.auction_id,index)">Удалить
                  </v-btn>
                </v-list-item-action>

              </v-list-item>
            </v-card>
          </td>
        </tr>
      </template>
    </v-data-table>
    <v-divider class="my-0"></v-divider>
    <v-card-actions class="pa-4" style="background: #fdfdfd;">
      <v-spacer></v-spacer>
      <v-btn color="success" depressed class="rounded-btn px-6 text-decoration-none" :href="all_tenders_link">Смотреть
        все
      </v-btn>
      <v-spacer></v-spacer>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'dashboard_tenders',
  data() {
    return {
      type: 'drop',
      status: [1, 2],
      loading: false,
      my_auction_history: '',
      headers: [
        {text: 'Создан', value: 'created', class: 'px-2'},
        {text: 'Дата окончания', value: 'date_formated', class: 'px-2'},
        {text: 'Наименование', value: 'title', class: 'px-2'},
        {text: 'Активное вещество', value: 'active_material', class: 'px-2'},
        {text: 'Текущая ставка', value: 'rate.price', class: 'px-2'},
      ],
    }
  },
  mounted() {
    this.getAuctionHistoryList();
  },
  methods: {
    deleteItem(item, index) {
      event.preventDefault();
      let app = this;
      this.axios.get('/admin/my-auction/add/' + item).then(response => {
        app.items.splice(index, 1);
      }).catch(error => {
        return error.response.data;
      });
    },
    getAuctionHistoryList() {
      let app = this;
      this.axios.get('/admin/my-auction/list').then(response => {
        console.log(response.data);
        app.my_auction_history = response.data.my_auction_history;
      }).catch(error => {
        return error.response.data;
      });
    },
    getItems() {
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
      this.$store.dispatch('GET_AUCTIONS', params).then(res => {
        this.options.page = this.page
      }).finally(() => (this.loading = false))

    }
    ,
    formatDate(date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    }
    ,
    formatDateWithoutYear(date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}`
    }
    ,
    formatPrice(value) {
      let val = (value / 1).toFixed(0)
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    }
    ,
  },
  props: {
    user_id: Number,
  },
  watch: {
    auth_user(val) {
      this.getItems()
    }
  },
  computed: {
    auth_user: {
      get() {
        return this.$store.state.auth_user
      }
    },
    items: {
      get() {
        return this.$store.state.auction.rates
      }
    },
    status_options: {
      get() {
        return this.$store.state.auction.status_options
      },
    },
    all_tenders_link: {
      get() {
        return this.auth_user.role_id == 101 ? '/admin/tender/mylist' : '/admin/tender/now'
      },
    },
  },
};
</script>
