<template>
  <v-card>
    <v-card-title v-if="item.auction.title.length > 0" class="px-6 pt-6 mr-6" style="line-height: 1.2;">
      <span style="word-break:normal;">{{ item.auction.title }}<br><span class="font-weight-regular">{{ item.auction.active_material }}</span>
	    <span v-if="item.auction.is_analog == 1">
		  <span v-if="item.auction.is_analog" class="font-weight-regular"><br>или аналог
		    <template v-if="item.auction.exclude_analogs && item.auction.exclude_analogs.length>=1"> за исключанием:
              <template v-for="(analog, index) in item.auction.exclude_analogs">{{ index > 0 ?  "; " + analog : analog }}</template>
            </template>
          </span>
		</span>
	  </span>
      <v-spacer></v-spacer>
      <v-btn color="grey darken-3" icon small text @click.stop="$emit('close')" absolute right top>
        <v-icon small>mdi-close</v-icon>
      </v-btn>
    </v-card-title>
    <!--
        <v-card-subtitle class="mt-1 pb-2">
                <v-chip label> <v-icon left size="20">mdi-city-variant</v-icon> <span class="font-weight-medium">{{item.user.company_name}}</span></v-chip>
            </v-card-subtitle>
    -->
    <v-card-text style="max-height: 75vh;" class="py-0 px-2">
      <v-container fluid grid-list-md class="py-0">
        <v-divider class="mx-2 my-0"></v-divider>
        <v-layout row wrap>
          <v-flex md4>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Объем:</p>
                <v-list-item-title>
                  {{ item.auction.size }} {{ item.auction.unit }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
          <v-flex md8>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Дата окончания:</p>
                <v-list-item-title>
                  {{ item.auction.date_formated }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
        </v-layout>
        <v-divider class="mx-2 my-0"></v-divider>
        <v-layout row wrap>
          <v-flex md4>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Срок доставки:</p>
                <v-list-item-title>
                  до {{ item.auction.delivery_date_formated }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
          <v-flex md8>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Способ доставки:</p>
                <v-list-item-title>
                  {{ delivery_conditions.find(el => el.id == item.auction.delivery_condition).title }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
          <v-flex md12 v-if="item.auction.delivery_condition == 1 || item.auction.delivery_condition == 3">
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Регион отгрузки:</p>
                <v-list-item-title>
                  {{ item.auction.delivery_region }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
        </v-layout>
        <v-divider class="mx-2 my-0"></v-divider>
        <v-layout row wrap>
          <v-flex xs12>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Условия оплаты:</p>
                <v-list-item-title>
                  {{ payment_conditions.find(el => el.id == item.auction.payment_condition).title }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0">Особые условия:</p>
                <v-list-item-title>
                  {{ item.auction.special_terms || 'нет' }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
        </v-layout>
        <v-divider class="mx-2 my-0"></v-divider>
      </v-container>
    </v-card-text>
    <v-card-actions class="pb-4">
      <v-container fluid>
        <v-layout row wrap>
          <v-flex md4>
            <v-list-item class="px-2">
              <v-list-item-content>
                <p class="mb-2 label text-left px-0"> 
                  <span v-if="item.rate != undefined">Текущая цена</span><span v-else>Стартовая цена</span>:
                </p>
                <v-list-item-title>
                  <span style="font-size: 24px; line-height: 32px; zoom: 1;" class="font-weight-bold"
                        v-if="item.rate != undefined">{{ formatPrice(item.rate.price) }} ₽<span
                      class="font-weight-light">/{{ item.auction.unit }}</span></span>
                  <span style="font-size: 24px; line-height: 32px; zoom: 1;" class="font-weight-bold grey--text" v-else>{{ item.auction.start_price }} ₽</span>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-flex>
          <v-flex md8>
            <v-card-actions class="pt-6">
              <v-spacer></v-spacer>
              <v-btn color="success" large :href="'/admin/sale/now/card/'+item.auction.id">Предложить цену</v-btn>

            </v-card-actions>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card-actions>
  </v-card>
</template>

<!-- ТУТ CSS -->
<style>

</style>


<script>
import payment_conditions_data from '../../../constants/payment_conditions_data.js'

export default {
  name: 'sale_dialog',
  data() {
    return {
      delivery_conditions: [
        {id: 1, title: 'Со склада поставщика'},
        {id: 2, title: 'Поставка на склад покупателя'},
        {id: 3, title: 'Транспортной компанией до терминала'},
      ],
      payment_conditions: payment_conditions_data.payment_conditions_data,
    }
  },
  mounted() {

  },
  methods: {
    formatPrice(value) {
      if (value != null) {
        let val = value
//        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      } else {
        return '0.00'
      }
    },
  },
  props: {
    item: Object,
  },
  components: {},
  computed: {},
};
</script>
