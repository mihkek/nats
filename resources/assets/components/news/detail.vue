<template>

  <v-app>
    <!-- Шапка сайта -->
    <app_bar :user_id="user_id" />

    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>

      <!-- ТОП БАННЕР -->
      <v-card
          class="flex"
          flat
          tile
          dark
          app
          color="#456018"
      >
        <!--        <img class='img-responsive' src="/img/custom/bg01.jpg" style="margin-bottom: -25px;"> -->

        <div style="display: flex; flex-direction:column; align-content: flex-end; justify-content: flex-end; flex-wrap:nowrap; height:30vw; min-height:480px;background:url(/img/custom/bg02.jpg) 85% 50%; background-size:cover; margin-bottom:-25px;">
          <!-- Счетчики px-3 py-2 text-uppercase -->
          <v-container fluid style="padding: 1.5em 36px;margin:0 0; background:rgba(0,0,0,.3);">
            <v-layout row wrap style="margin:0;max-width:960px;">

              <v-flex sm3 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(userscountformated)" style="font-size:250%;"></b><br>пользователей</h5>
              </v-flex>

              <v-flex sm3 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(tenderscountformated)" style="font-size:250%;"></b><br>Тендеров</h5>
              </v-flex>

              <v-flex sm6 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(summcountformated)" style="font-size:250%;"></b><b style="font-size:150%;">&nbsp;₽</b><br>Общая стоимость тендеров<br></h5>
              </v-flex>

            </v-layout>
          </v-container>
          <h1 style="padding: .5em 36px .75em 36px; width:100%; box-sixing:border-box; font-weight: bold; text-shadow: 0 2px 35px #000;" class="titlenats">Национальная Аграрная Тендерная Система (НАТС)</h1>
        </div>

        <v-container fluid grid-list-lg>
          <v-layout row wrap>
            <v-flex md6 xs12>
              <template>
                <v-flex xs12>
                  <!-- ЗАГОЛОВОК -->
                  <v-card color="transparent" flat class="my-3">
                    <v-card-title>
                      <h1 class="my-0 display-1">Покупателям</h1>
                    </v-card-title>
                    <v-card-subtitle class="pb-0">
                      <ul>
                        <li>Значительное снижение цены на ХСЗР</li>
                        <li>Экономия времени</li>
                        <li>Расширение круга поставщиков</li>
                        <li>Увеличение прозрачности и эффективности закупок</li>
                      </ul>
                    </v-card-subtitle>
                  </v-card>
                </v-flex>
              </template>

            </v-flex>
            <v-flex md6 xs12>

              <template>
                <v-flex xs12>
                  <!-- ЗАГОЛОВОК -->
                  <v-card color="transparent" flat class="my-3">
                    <v-card-title>
                      <h1 class="my-0 display-1">Поставщикам</h1>
                    </v-card-title>
                    <v-card-subtitle class="pb-0">
                      <ul>
                        <li>Стабильный рынок сбыта</li>
                        <li>Экономия расходов на рекламу и содержание персонала</li>
                        <li>Расширение горизонта сбыта продукции, заявки из всех регионов РФ</li>
                      </ul>
                    </v-card-subtitle>
                  </v-card>
                </v-flex>
              </template>

            </v-flex>
          </v-layout>

        </v-container>
      </v-card>

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
