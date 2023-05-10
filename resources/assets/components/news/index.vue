<template>

  <v-app>
    <!-- Шапка сайта -->
    <app_bar :user_id="user_id" />

    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>

      <v-container fluid grid-list-lg>

        <v-layout row wrap>

          <!-- ТЕНДЕРЫ -->
          <v-flex md9 xs12>
            <tenders_block :user_id="user_id"/>
            <reviews_block />
          </v-flex>

          <!-- САЙДБАР -->
          <v-flex md3 xs12>
            <sidebar />
          </v-flex>

        </v-layout>

        <!--
                <v-divider class="my-0"></v-divider>
                <v-layout row wrap>
                  <v-flex xs12>
                    <news_block />
                  </v-flex>
                </v-layout>
        -->

        <v-divider class="my-0"></v-divider>
        <v-layout row wrap>
          <v-flex xs12>
            <brands />
          </v-flex>
        </v-layout>

      </v-container>
    </v-main>

    <!-- Подвал -->
    <footer_bar :user_id="user_id" />
  </v-app>
</template>

<script>

import app_bar from './components/app_bar'
import footer_bar from './components/footer_bar'
import tenders_block from './components/tenders_block'
import sidebar from './components/sidebar'
import brands from './components/brands'
import news_block from './components/news_block'
import reviews_block from './components/reviews_block'

export default {
  name: 'index',
  data () {
    return {
      counters: {
        userscount: "–",
        tenderscount: "–",
        summcount: "–"
      },
      userscount: 0,
      tenderscount: 0,
      summcount: 0,
      userscountTweened: 0,
      tenderscountTweened: 0,
      summcountTweened: 0,
      opacity: 0,
      opacityTweened: 0,
    }
  },
  mounted() {
    this.getCounters()
  },
  methods: {
    getCounters() {
      this.loading = true
      let params = {
      }
      axios.post('/index/get_counters', params).then(res => {
        this.counters = res.data.counters
        this.userscount = this.counters.userscount
        this.tenderscount = this.counters.tenderscount
        this.summcount = this.counters.summcount
        this.opacity = 1
      })
    },
    formatNumber: function (value) {
      var parts = value+""
      parts = parts.split('')
      var valueformated = ""
      var count = 0
      while(parts.length > 0){
        if (count%3 == 0 && count > 0) valueformated = "&nbsp;"+valueformated
        valueformated = parts.pop()+valueformated
        count++
      }
      return valueformated
    }
  },
  props: {
    user_id: Number,
  },
  components: {
    app_bar,
    footer_bar,
    tenders_block,
    reviews_block,
    sidebar,
    brands,
    news_block
  },
  computed: {
    userscountformated: function () {
      return this.formatNumber(this.userscountTweened.toFixed(0));
    },
    tenderscountformated: function () {
      return this.formatNumber(this.tenderscountTweened.toFixed(0));
    },
    summcountformated: function () {
      return this.formatNumber(this.summcountTweened.toFixed(0));
    }
  },
  watch: {
    userscount: function(newValue) {
      gsap.to(this.$data, { duration: 2.5, ease: "power1", userscountTweened: newValue });
    },
    tenderscount: function(newValue) {
      gsap.to(this.$data, { duration: 2.5, ease: "power1", tenderscountTweened: newValue });
    },
    summcount: function(newValue) {
      gsap.to(this.$data, { duration: 2.5, ease: "power1", summcountTweened: newValue });
    },
    opacity: function(newValue) {
      gsap.to(this.$data, { duration: 1, ease: "power1", opacityTweened: newValue });
    }
  },
};
</script>

<style>
.theme--light.v-data-table {
  background: transparent !important;
}
#main {
  background: #f1f1f1;
}
.counter { font-size: 14px; }
@media all and (max-width: 767px) {
  .counter { font-size: 13px; }
}
@media all and (max-width: 599px) {
  .counter { font-size: 12px; }
  .titlenats { font-size: 200%; }
}
@media all and (max-width: 498px) {
  .titlenats { font-size: 175%; }
  .counter { font-size: 11px; }
}
</style>
