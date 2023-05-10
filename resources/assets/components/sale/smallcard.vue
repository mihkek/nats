<template>
<v-hover v-slot="{ hover }">
  <v-card class="my-3" :elevation="hover ? 12 : 2" @click.stop="openCard">
    <v-container fluid>
      <v-layout row wrap>
        <v-flex md2 xs7 class="text-center">
          <v-card class="text-center" flat color="#eee" height="175" width="175">
            <v-img
              height="175"
              width="175"
              v-if="item.photo != null"
              :src="'/storage/avatars/auctions/'+item.photo"
            ></v-img>
            <v-icon size="44" style="margin-top: 65.5px;" v-else>mdi-camera</v-icon>
          </v-card>
        </v-flex>
        <v-flex md8>
          <v-card flat color="transparent">
            <v-card-title class="pa-2 mb-1 pt-0">
              {{item.title}}
            </v-card-title>
            <v-card-subtitle class="px-2 pb-2">
              Создан {{item.created_at}}
            </v-card-subtitle>
            <v-card-text class="pa-2" v-html="item.description"></v-card-text>
          </v-card>
        </v-flex>        
        <v-flex md2>
          <v-list>
            <v-list-item three-line>
              <v-list-item-content>
                <v-list-item-subtitle>
                  Текущая ставка
                </v-list-item-subtitle>
                <v-list-item-title class="title">
                  {{formatPrice(item.start_price)}} руб.
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-subtitle class="mb-2">
                  Дата окончания
                </v-list-item-subtitle>
                <v-list-item-title>
                  {{formatDate(item.date)}} {{item.time}}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-flex>        
      </v-layout>
    </v-container>
  </v-card>
</v-hover>  
</template>
<script>
  export default {
    data: () => ({
    }),
    props: {
      item: Object,
    },
    computed: {
      auth_user: {
        get() { return this.$store.state.auth_user }
      },
    },
    created() {
    },
    mounted () {
    },
    methods: {
      openCard() {
        location.href = '/admin/sale/now/card/'+this.item.id
      },
      formatDate(date) {
        if (!date) { return }
        else {
          const [ year, month, day ] = date.split('-')
          return day+'/'+month+'/'+year
        }
      },
      formatPrice(value) {
        let val = (value/1).toFixed(0)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      },
    },
    watch: {
      item: function (val) {
        this.updateCalendar()
      },
    }
  };
</script>
