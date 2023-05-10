<template>
    <v-flex xs12>

        <!-- ЗАГОЛОВОК -->
        <v-card color="transparent" flat class="my-3">
            <v-card-title class="pb-0 justify-center">
                <h1 class="my-0 last-title">Последние распродажи</h1>
                <v-flex class="text-center">
                    <a href="/admin/sale/add" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success">
                        <span class="v-btn__content">Разместить распродажу</span>
                    </a>
                </v-flex>
            </v-card-title>
        </v-card>

        <v-spacer></v-spacer>

        <v-card flat color="transparent" class="mb-3">
            <v-flex xs12>
              <v-layout row wrap>
                <v-flex xs12>
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
                      <template v-slot:append>
                        <v-btn color="info"   depressed text rounded  dark @click.stop="show_filter = !show_filter">
                          <v-icon>mdi-tune-vertical</v-icon>
                          <span class="d-none d-md-flex ml-2">Расширенный поиск</span>
                        </v-btn>
                      </template>
                    </v-text-field>
                  </v-card>
                </v-flex>
                <v-expand-transition>
                  <div v-show="show_filter" style="width: 100%;">
                    <v-card flat color="transparent">
                      <v-container fluid grid-list-lg>
                        <v-layout row wrap>
            						  <v-flex md6 xs12>
            							<v-select
            							  prepend-inner-icon="mdi-map-marker-outline"
            							  :items="delivery_regions"
            							  v-model="region"
            							  label="Регион"
            							  item-text="title"
            							  item-value="id"
            							  solo
            							  flat
            							  multiple
            							  hide-details
            							  @change="getItems"
            							>
            							  <template v-slot:selection="{ item, index }">
            								<span
            								  v-if="region.length > 0 && index === 0"
            								  _lass="text-caption"
            								>
            								  {{ regionName(region.length) }}
            								</span>
            							  </template>
            							</v-select>
            						  </v-flex>
                          <v-flex xs12 md6>
                            <v-card flat outlined>
                              <v-select
                                :items="date_options"
                                item-text="text"
                                item-value="value"
                                v-model="date_filter"
                                solo
                                flat
                                hide-details
                                @change="getItems"
                                color="info"
                              ></v-select>
                            </v-card>
                          </v-flex>
                          <v-flex md12 xs12>
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
                                      prefix="С"
                                      color="info"
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
                                	    clearable
                                      prefix="По"
                                      color="info"
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
        <!-- ТЕНДЕРЫ -->
		<v-card flat color="transparent" class="my-2 text-center" v-if="loading == false && auctions.length == 0">
		Распродажи с заданными критериями не найдены
		</v-card>
        <v-data-table
          :headers="headers"
          :items="auctions"
          item-key="id"
          :search="search"
          hide-default-footer
          hide-default-header
          :sort-by="['auction.id']"
          :sort-desc="[true]"
          @page-count="pageCount = $event"
          :page.sync="page"
          :items-per-page="itemsPerPage"
        >
          <template v-slot:body="{ items }">
            <v-container fluid grid-list-lg>
              <v-layout row wrap>
                <v-flex xs12 v-for="(item, i) in items" :key="i">

                  <!-- КАРТОЧКА ТЕНДЕРА -->
                  <sale_card :item="item" @open="open(item)"/>

                </v-flex>
              </v-layout>
            </v-container>
          </template>
        </v-data-table>
        <v-flex xs12 class="my-4">
          <!--<v-pagination
            v-model="page"
            :length="pageCount"
			:total-visible="11"
            color="info"
          ></v-pagination>-->

          <v-flex class="text-center"><v-btn><a href="/sales">Показать больше</a></v-btn></v-flex>

        </v-flex>
        <v-dialog v-model="dialog" scrollable max-width="500px">
            <sale_dialog @close="dialog = false" :item="selected" />
        </v-dialog>
    </v-flex>
</template>

<script> 

import sale_card from './auction/sale_card'
import sale_dialog from './auction/sale_dialog'
import delivery_regions_data from '../../constants/delivery_regions_data.js'

export default {
  name: 'sales_block',
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
      itemsPerPage: 5,
      headers: [
        { value: 'auction.id', text: 'Номер' },
        { value: 'auction.title', text: 'Название' },
        { value: 'auction.active_material', text: 'Активный материал' },
        { value: 'auction.created', text: 'Создан' },
        { value: 'auction.date_formated', text: 'Дата окончания' },
        { value: 'rate.price', text: 'Текущая ставка' },
      ],
      date_options: [
        { text: 'Дата окончания', value: 1 },
        { text: 'Дата создания', value: 2 },
      ],
      date_filter: 1,
      date_from: '',
      date_to: '',
	  region: '',
	  delivery_regions: delivery_regions_data.delivery_regions_data,
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
        user_id: this.user_id,
        now: true,
        type: 'sale',
        status: [1],
        date_filter: this.date_filter,
        date_from: this.date_from,
        date_to: this.date_to,
      	region: this.region,
        limit: 5,
      }
      axios.post('/index/get_auctions', params).then(res => {
        this.auctions = res.data.auctions;
        //console.log(res.data.auctions)
      })
      .finally(() => (this.loading = false))
    },
	regionName(number) {
	  if (number%100 > 10 && number%100 < 20) return number +' регионов'
	  if (number%10 == 1) return number +' регион'
	  if (number%10 > 0 && number%10 < 5) return number +' региона'
	  return number +' регионов'
	},
  },
  props: {
    user_id: Number,
  },
  components: {
    sale_card,
    sale_dialog
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user }
    }
  },
};
</script>

<style>

</style>
