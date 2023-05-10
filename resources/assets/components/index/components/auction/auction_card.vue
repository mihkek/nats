<template>
  <v-hover v-slot="{ hover }">
    <v-card :elevation="hover ? 6 : 2" :href="'/auctions/'+item.auction.id" target="_blank">
      <v-container grid-list-xs fluid>

        <v-layout row wrap>
          <v-flex md8>
            <v-card flat color="transparent" class="my-1">
              <v-btn color="success" icon text x-small absolute style="left: 0; top: 8px;" size="8">
                <v-icon size="8">mdi-circle-slice-8</v-icon>
              </v-btn>
              <v-card-text class="py-2 px-6">
                <span class="grey--text text--darken-3 font-weight-bold mr-3"
                      style="font-size: 16px;">{{ item.auction.article }}</span><br>
                <span class="grey--text text--lighten-1 font-weight-light"
                      style="font-size: 13px;">от {{ item.auction.created }}</span>
              </v-card-text>
              <v-card-text primary-title class="py-0 px-6 subtitle">
                <p class="font-weight-medium text-decoration-none my-0 mat-title" style="">
                  <span>{{ item.auction.title }}<br><span class="font-weight-regular">{{ item.auction.active_material }}</span>
                    <span v-if="item.auction.is_analog" class="font-weight-regular"><br>или аналог
                      <template v-if="item.auction.exclude_analogs && item.auction.exclude_analogs.length>=1">
                        за исключением:
                        <template v-for="(analog, index) in item.auction.exclude_analogs">{{ index > 0 ?  "; " + analog : analog }}</template>
                      </template>
                    </span>
			      </span>

                </p>
              </v-card-text>
              <!--
                    <v-card-actions class="px-6">
                            <span class="grey--text text--darken-3 font-weight-light text-uppercase" style="font-size: 14px;">{{item.user.company_name}}</span>
                          </v-card-actions>
              -->
              <v-card-actions class="px-6">
                <span class="grey--text text--darken-3 font-weight-light"
                      style="font-size: 14px;">
                  <!-- {{
                    item.auction.delivery_condition == 1 ? 'Со склада поставщика' : item.auction.delivery_region
                  }}-->
                  {{
                    item.auction.delivery_region !== undefined ? item.auction.delivery_region : '' 
                  }}
                </span>
              </v-card-actions>
            </v-card>
          </v-flex>
          <v-flex md4 class="my-auto">
            <v-list>
              <v-list-item three-line>
                <v-list-item-content>
                  <v-list-item-subtitle class="grey--text text--darken-2 font-weight-medium mb-1">
                    <span v-if="item.rate != undefined">Текущая цена</span><span v-else>Стартовая цена</span>
                  </v-list-item-subtitle>
                  <v-list-item-title class="mb-2">
                    <span style="" class="price-title font-weight-bold"
                          v-if="item.rate != undefined">{{ formatPrice(item.rate.price) }} ₽<span
                        class="font-weight-light">/{{ item.auction.unit }}</span></span>
                    <span style="" class="price-title font-weight-bold grey--text"
                          v-else>{{ item.auction.start_price }} ₽</span>
                          
                  </v-list-item-title>
                  <v-list-item-subtitle class="grey--text text--darken-3 font-weight-medium">
                    Окончание:<br>{{ item.auction.date_formated }} ({{ item.auction.datediff }} дн.)
                  </v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </v-hover>
</template>

<!-- ТУТ CSS -->
<style>

</style>


<script>
export default {
  name: 'auction_card',
  data() {
    return {}
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
