<template>
    <v-card flat outlined class="mb-3">
      <v-card-title class="my-0" style="background: #fdfdfd;">
        <v-spacer></v-spacer>
        <span class="h4">История ставок</span>
        <v-spacer></v-spacer>
      </v-card-title>
      <v-divider class="my-0"></v-divider>
      <v-sheet flat color="transparent" v-show="!loading">
        <v-list dense subheader v-if="items.length > 0" >
          <template v-for="(item, i) in items">
            <v-list-item :key="i" three-line>
              <v-list-item-avatar size="48">
                <v-img v-if="item.auction.photo != null" :src="'storage/avatars/auctions/'+item.auction.photo"></v-img>
                <v-icon v-else>mdi-camera</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-subtitle class="caption"><span v-html="item.auction.type == 'rise' ? 'Аукцион' : 'Тендер' "></span> #{{item.auction.id}}</v-list-item-subtitle>
                <v-list-item-title>


                  <a class="info--text text--darken-3" 
                  :href="item.auction.status == 1 ?
                   '/admin/'+(item.auction.type == 'rise' ? 'auction' : 'tender')+'/now/card/'+item.auction.id :
                    '/admin/'+(item.auction.type == 'rise' ? 'auction' : 'tender')+'/list/card/'+item.auction.id "
                  >{{item.auction.title}}</a>


                </v-list-item-title>
                <v-list-item-subtitle>Ставка сделана - {{item.created_formated}}</v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <span class="font-weight-medium" :class="item.auction.price == item.price ? 'success--text' : 'red--text' ">{{formatPrice(item.price)}} ₽<span class="font-weight-light">/{{item.auction.unit}}</span></span>
                <span v-if="item.auction.price != item.price" class="caption success--text"><v-icon size="16" color="success">mdi-menu-up</v-icon>{{formatPrice(item.auction.price)}}</span>
              </v-list-item-action>
            </v-list-item>
            <v-divider class="ma-2" v-if="i != items.length - 1" :key="i"></v-divider>
          </template>
        </v-list>
        <v-card-text class="text-center" v-else>
          <v-card class="pa-4" flat color="#fafafa" outlined>
            <span class="grey--text">Ставок нет</span>
          </v-card>
        </v-card-text>
      </v-sheet>
      <v-sheet v-show="loading">
        <v-card-text class="text-center">
          <v-card class="pa-4" flat color="#fafafa" outlined>
            <v-progress-circular
              :size="50"
              color="primary"
              indeterminate
            ></v-progress-circular>
          </v-card>
        </v-card-text>
      </v-sheet>
      <v-card-actions class="pa-1">
      </v-card-actions>
    </v-card>
</template>

<script> 
export default {
  name: 'dashboard_rates',
  data () {
    return {
      loading: false,
    }
  },
  mounted() {

  },
  methods: {
    getItems() {
      this.loading = true
      let params = {
        user_id: this.auth_user.id,
        limit: 5,
        orderBy: 'id',
        orderType: 'desc'
      }
      this.$store.dispatch('GET_RATES', params).then(res => {
      })
      .finally(() => (this.loading = false))
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
    formatPrice(value) {
      let val = (value/1).toFixed(0)
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
  },
  props: {
    
  },
  watch: {
    auth_user(val) {
      this.getItems()
    }
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    items: {
      get() { return this.$store.state.auction.rates }
    },
  },
};
</script>
