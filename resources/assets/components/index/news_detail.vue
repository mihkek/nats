<template>

  <v-app>
    <!-- Шапка сайта -->
    <app_bar :user_id="user_id"/>

    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>

      <v-container fluid grid-list-lg>

        <v-layout row wrap>

          <!-- ТЕНДЕРЫ -->
          <v-flex md12 xs12>
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="section-title card">
                    <h1>{{ news.title }}</h1>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="card">
                    <div v-html="news.content"></div>
                  </div>
                </div>


              </div>
            </div>
          </v-flex>

        </v-layout>


      </v-container>
    </v-main>

    <!-- Подвал -->
    <footer_bar :user_id="user_id"/>
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
  data() {
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
      let params = {}
      axios.post('/index/get_counters', params).then(res => {
        this.counters = res.data.counters
        this.userscount = this.counters.userscount
        this.tenderscount = this.counters.tenderscount
        this.summcount = this.counters.summcount
        this.opacity = 1
      })
    },
    formatNumber: function (value) {
      var parts = value + ""
      parts = parts.split('')
      var valueformated = ""
      var count = 0
      while (parts.length > 0) {
        if (count % 3 == 0 && count > 0) valueformated = "&nbsp;" + valueformated
        valueformated = parts.pop() + valueformated
        count++
      }
      return valueformated
    }
  },
  props: {
    user_id: Number,
    news: Array,
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
    userscount: function (newValue) {
      gsap.to(this.$data, {duration: 2.5, ease: "power1", userscountTweened: newValue});
    },
    tenderscount: function (newValue) {
      gsap.to(this.$data, {duration: 2.5, ease: "power1", tenderscountTweened: newValue});
    },
    summcount: function (newValue) {
      gsap.to(this.$data, {duration: 2.5, ease: "power1", summcountTweened: newValue});
    },
    opacity: function (newValue) {
      gsap.to(this.$data, {duration: 1, ease: "power1", opacityTweened: newValue});
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

.counter {
  font-size: 14px;
}

@media all and (max-width: 767px) {
  .counter {
    font-size: 13px;
  }
}

@media all and (max-width: 599px) {
  .counter {
    font-size: 12px;
  }

  .titlenats {
    font-size: 200%;
  }
}

@media all and (max-width: 498px) {
  .titlenats {
    font-size: 175%;
  }

  .counter {
    font-size: 11px;
  }
}

.card {
  background: #fff;
  padding: 15px;
  border-radius: 15px;
}

.post {
  margin-bottom: 40px;
}

.post .post-img {
  display: block;
  -webkit-transition: .2s opacity;
  transition: .2s opacity;
}

.post .post-img > img {
  width: 100%;
}

.post .post-meta {
  margin-top: 15px;
  margin-bottom: 15px;
}

.post-meta .post-category.cat-1 {
  background-color: #4bb92f;
}

.post-meta .post-category {
  font-size: 13px;
  text-transform: uppercase;
  padding: 3px 10px;
  font-weight: 600;
  border-radius: 2px;
  margin-right: 15px;
  color: #fff;
  background-color: #212631;
  -webkit-transition: .2s opacity;
  transition: .2s opacity;
}

.post-meta .post-date {
  font-size: 13px;
  font-weight: 600;
}

.post .post-title {
  font-size: 18px;
  margin-bottom: 0;
}
</style>
