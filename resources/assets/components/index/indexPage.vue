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

		<div style="display: flex; flex-direction:column; align-content: flex-end; justify-content: flex-end; 
    flex-wrap:nowrap; height:25vw; min-height:600px;background:url(/img/custom/bg02.jpg) 85% 50%; 
    background-size:cover; margin-bottom:-25px;">
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


    <v-container fluid grid-list-lg>
          <v-layout row wrap>
            <v-flex md10 xs12>
          <v-layout row wrap>
            <v-flex md6 xs12>
              <template>
                <v-flex xs12>
                   <div class="tender-box"><a href="/tenders" class="tender-box-btn button-1">
                    <span class="tender-box-btn-left"></span>
                   <span>Тендеры</span>
                  <span class="tender-box-btn-right"></span>
                 </a></div>
                </v-flex>
              </template>
            </v-flex>
            <!--<v-flex md4 xs12>
              <template>
                <v-flex xs12>
                  <div class="tender-box"><a href="/auctions" class="tender-box-btn button-2">Аукционы</a></div>
                </v-flex>
              </template>
            </v-flex>-->
            <v-flex md6 xs12>
              <template>
                <v-flex xs12>
                  <div class="tender-box"><a href="/sales" class="tender-box-btn button-3">Распродажи</a></div>
                </v-flex>
              </template>
            </v-flex>
          </v-layout>
          </v-flex>
          </v-layout>
        </v-container>



		</div>





      </v-card>

      <v-container fluid grid-list-lg>

        <v-layout row wrap>

          <!-- ТЕНДЕРЫ -->
          <v-flex md10 xs12>

              <v-layout row wrap>
                <v-flex md6 xs12 class="box-tenders"> 
                 <tenders_block :user_id="user_id"/>
                </v-flex>
                <!--<v-flex md4 xs12 class="box-auctions">
                  <auctions_block :user_id="user_id"/>
                </v-flex>-->
                <v-flex md6 xs12 class="box-sales">
                  <sales_block :user_id="user_id"/>
                </v-flex>
              </v-layout>

            <maintext_block />
            <reviews_block />
           

          </v-flex>
          
          <!-- САЙДБАР -->
          <v-flex md2 xs12>
            <sidebar />
          </v-flex>

        </v-layout>

        <v-divider class="my-0"></v-divider>
        <v-layout row wrap>
          <v-flex xs12>
            <slider_block />
            
          </v-flex>
        </v-layout>


        <!--<v-divider class="my-0"></v-divider>
        <v-layout row wrap>
          <v-flex xs12>
            <news_block />
          </v-flex>
        </v-layout>-->


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
import auctions_block from './components/auctions_block'
import sales_block from './components/sales_block'
import sidebar from './components/sidebar'
import brands from './components/brands'
import news_block from './components/news_block'
import reviews_block from './components/reviews_block'
import maintext_block from './components/maintext_block'
import slider_block from './components/slider_block';

export default {
  name: 'indexPage',
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
    auctions_block,
    sales_block,
    reviews_block,
    sidebar,
    brands,
    news_block,
    maintext_block,
    slider_block
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
.box-auctions {
  border-left: 1px solid #ccc;
  border-right: 1px solid #ccc;
}

.theme--light.v-data-table {
  background: transparent !important;
}
#main {
  background: #f1f1f1;
}
.header-main-box {
  border: 1px solid #ccc;
  background: transparent !important;
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
.rekl-title-box {
  text-align: center;
}

.rekl-title {
  padding: 60px 0 0 0;
  text-transform: uppercase;
}

.tender-box {
  margin: 40px 60px 20px 60px;
}
.tenders_block{
  padding: 100px;
}

.tender-box .tender-box-btn {
  display: block;
  width: 100%;
  max-width: 320px;
  margin:  0 auto;
  color: #fff ;
  padding: 25px 40px;
   background: url('/img/main-page/button-green.png') no-repeat center center; 
   background-size: cover;  
  font-size: 26px;
  line-height: 30px;
  text-transform: uppercase;
  font-weight: bold;
  border-radius: 25px;
  text-align: center;
  text-decoration: none;
 box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.tender-box .tender-box-btn:hover {
   box-shadow: 0 14px 28px rgba(255,255,255,0.25), 0 10px 10px rgba(0,0,0,0.22);
}


.tender-box-title {
  text-align: center;
  text-transform: uppercase;
  margin: 0 0 20px 0;
}
.tender-box .tender-box-link {
  color: #fff;
  display: block;
  text-decoration: none;
}

@media all and (max-width: 1400px) {
.tender-box {
    margin: 40px 10px 20px 10px;
}
}

@media all and (max-width: 767px) {
  .tenders_block{
  padding:20px;
}
.tender-box {
   margin: 0px 20px 0 20px;
}
  .tender-box .tender-box-btn {
  padding: 20px 20px;
  font-size: 20px;
  line-height: 20px;
  border-radius: 20px;
}
}
.last-title {
    font-size: 24px;
    font-weight: 600;
    line-height: 2.5rem;
    letter-spacing: 0.0073529412em;
    font-family: "Roboto", sans-serif;
}
.price-title {
font-size: 24px; line-height: 32px; zoom: 1;
}
.mat-title {
font-size: 16px; line-height: 20px; color: #065894;  
}
@media all and (max-width: 1400px) {
.mat-title {
font-size: 14px;
}
}


@media all and (max-width: 767px) {
.last-title {
font-size: 25px;
}
}
@media all and (max-width: 767px) {
.news-title {
font-size: 26px;
}
}
.brend-title {
    font-size: 30px;
    text-align: center;
}
@media all and (max-width: 767px) {
.brend-title {
font-size: 20px;
}
}

</style>
