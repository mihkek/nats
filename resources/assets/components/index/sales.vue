<template>
  <div>
    <!-- Шапка сайта -->
    <!--<app_bar :user_id="user_id" />-->

    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>
      <v-container fluid grid-list-lg>
        <v-layout row wrap>
          <v-flex xs12>
            <!-- ЗАГОЛОВОК -->
            <v-card color="transparent" flat class="my-3">
                <v-card-title>
                    <h1 class="my-0 display-1">Все распродажи</h1>
                </v-card-title>
                <v-card-subtitle class="pb-0">
                    <a href="/admin/sale/add" class="px-1 success--text">Разместить распродажу</a>
                </v-card-subtitle>
            </v-card>
            <v-card flat color="transparent" class="mb-3">
              <v-flex xs12>
                <v-layout row wrap>
                  <v-flex xs9 lg9 md8>
                    <v-card flat outlined>
                      <v-text-field
                        solo
                        flat
                        label="Введите фразу или слово"
                        v-model="search"
                        prepend-inner-icon="mdi-magnify"
                        hide-details
                        color="info"
                      >
                      </v-text-field>
                    </v-card>
                  </v-flex>
                  <v-flex xs3 lg3 md4 class="ma-auto">
                    <v-btn color="info" block height="46" depressed dark @click.stop="show_filter = !show_filter">
                      <v-icon>mdi-tune-vertical</v-icon>
                      <span class="d-none d-md-flex ml-2">Расширенный поиск</span>
                    </v-btn>
                  </v-flex>
                  <v-expand-transition>
                    <div v-show="show_filter" style="width: 100%;">
                      <v-card flat color="transparent">
                        <v-container fluid grid-list-lg>
                          <v-layout row wrap>
                            <v-flex xs12 md4>
                              <v-card flat outlined>
                                <v-select
                                  :items="date_options"
                                  item-text="text"
                                  item-value="value"
                                  v-model="date_filter"
                                  solo
                                  flat
                                  hide-details
                                  color="info"
                                  @change="getItems"
                                ></v-select>
                              </v-card>
                            </v-flex>
                            <v-flex md8 xs12>
                              <v-card flat color="transparent">
                              	<v-layout row wrap>
                              		<v-flex xs12 md6>
                                    <v-card flat outlined>
                                  	  <v-text-field
                                  	    solo
                                  	    flat
                                  	    type="date"
                                  	    label="Начало периода"
                                  	    hide-details
                                  	    @change="getItems"
                                  	    v-model="date_from"
                                  	    clearable
                                        color="info"
                                        prefix="С"
                                  	  >
                                  	  </v-text-field>
                                    </v-card>
                              		</v-flex>
                              		<v-flex xs12 md6>
                                    <v-card flat outlined>
                                  	  <v-text-field
                                  	    solo
                                  	    flat
                                  	    type="date"
                                  	    label="Конец периода"
                                  	    hide-details
                                  	    @change="getItems"
                                  	    v-model="date_to"
                                        color="info"
                                  	    clearable
                                        prefix="По"
                                  	  >
                                  	  </v-text-field>
                                    </v-card>
                              		</v-flex>
                              	</v-layout>
                              </v-card>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card>
                    </div>
                  </v-expand-transition>
                </v-layout>
              </v-flex>
            </v-card>
            <!-- АУКЦИОНЫ -->
            <v-data-table
              :headers="headers"
              :items="auctions"
              item-key="id"
              :search="search"
              hide-default-footer
              hide-default-header
              :sort-by="['auction.created_at']"
              :sort-desc="['desc']"
              @page-count="pageCount = $event"
              :page.sync="page"
              :items-per-page="itemsPerPage"
            >
              <template v-slot:body="{ items }">
                <v-container fluid grid-list-lg>
                  <v-layout row wrap>
                    <v-flex xs12 v-for="(item, i) in items" :key="i">

                      <!-- КАРТОЧКА РАСПРОДАЖИ -->
                      <sale_card :item="item" @open="open(item)"/>

                    </v-flex>
                  </v-layout>
                </v-container>
              </template>
            </v-data-table>
            <v-flex xs12 class="my-4">
              <v-pagination
                v-model="page"
                :length="pageCount"
                color="info"
              ></v-pagination>
            </v-flex>
          </v-flex>
          <v-dialog v-model="dialog" scrollable max-width="500px">
            <sale_dialog @close="dialog = false" :item="selected" />
          </v-dialog>
        </v-layout>
      </v-container>
    </v-main>
    
    <!-- Подвал -->
    <!--<footer_bar :user_id="user_id" />-->
  </div>
</template>

<script> 

import app_bar from './components/app_bar'
import footer_bar from './components/footer_bar'
import sale_card from './components/auction/sale_card'
import sale_dialog from './components/auction/sale_dialog'

export default {
  name: 'sales',
  data () {
    return {
      loading: false,
      selected: {},
      dialog: false,
      auctions: [],
      search: '',
      show_filter: false,
      pageCount: 0,
      page: 1,
      itemsPerPage: 10,
      headers: [
        { value: 'auction.id', text: 'Номер' },
        { value: 'auction.title', text: 'Название' },
        { value: 'auction.description', text: 'Описание' },
        { value: 'auction.created_at', text: 'Создан' },
        { value: 'auction.date_time', text: 'Дата окончания' },
        { value: 'auction.start_price', text: 'Дата окончания' },
        { value: 'rate.price', text: 'Текущая ставка' },
      ],
      date_options: [
        { text: 'Дата окончания', value: 1 },
        { text: 'Дата создания', value: 2 },
      ],
      date_filter: 1,
      date_from: '',
      date_to: '',
    }
  },
  mounted() {
    this.loading = true
    this.getItems()
  },
  methods: {
    open(item) {
      /*this.selected = Object.assign({}, item)
      this.dialog = true*/
      if (item.auction.id !== undefined) {
        location.href = "/sales/" + item.auction.id;
      }
    },
    getItems() {
        this.loading = true
        let params = {
            now: true,
            type: 'sale',
            status: [1],
            date_filter: this.date_filter,
            date_from: this.date_from,
            date_to: this.date_to,
        }
        axios.post('/index/get_auctions', params).then(res => {
            this.auctions = res.data.auctions
        })
        .finally(() => (this.loading = false))
    },
  },
  props: {
    user_id: Number,
  },
  components: {
    app_bar,
    footer_bar,
    sale_card,
    sale_dialog,
  },
  computed: {
  },
};
</script>

<style>

</style>
