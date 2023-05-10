<template>
    <v-container fluid>
        <!-- HTML -->
        <v-card color="transparent" flat class="my-3">
            <v-card-title class="news-title">               
               <v-spacer></v-spacer>
               <span class="h2">Актуальные новости с полей</span>
               <v-spacer></v-spacer>
            </v-card-title>
        </v-card>
        <v-card flat color="transparent" class="mb-3">
            <v-flex xs12>
                <v-layout row wrap>

                  <div class="swiper-container">
                        <div class="swiper-wrapper">

                    <div class="swiper-slide" v-for="ns in news" :key="ns.id"> 
                    <div class="swiper-slide-box"> 
                    <v-card
                    class="mx-auto"
                    max-width="400"
                    >
                    <!--<div class="slide-box-img">
                    <a class="post-img" :href="'/news/'+ns.id"><img
                    :src="ns.image!='underfined'&&ns.image.length>=1?ns.image:'/img/no-image.jpg'"></a>
                    </div>-->
                    <v-card-subtitle class="pb-0">
                    {{ ns.created_formated }}
                    </v-card-subtitle>
                    <v-card-title><a :href="'/news/'+ns.slug">{{ ns.title }}</a></v-card-title>
                    <v-card-text class="swiper-slide-text text--primary">
                    <div>{{ ns.description }}</div>
                    </v-card-text>
                    <v-card-actions>
                    <v-btn
                    color="primary"
                    text
                    :href="'/news/'+ns.slug"
                    target="_blank"
                    >Просмотр</v-btn>
                    </v-card-actions>
                    </v-card>                
                    </div>
                    </div>

                        </div>
                         <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Add Pagination -->
                        <!--<div class="swiper-pagination"></div>-->
              </div>
                  
                </v-layout>
            </v-flex>
        </v-card>
   </v-container>
</template>

<!-- CSS -->
<style>
.swiper-slide-box {
  width: auto;
}   
.swiper-slide-text {
  width: auto;
}
.swiper-button-prev {
    color: green; 
}
.swiper-button-next {
    color: green; 
}
</style>


<script> 
export default {
    name: 'slider_block',
    data () {
        return {
           swiper: null,
           loading: true,
           news: []
        }
    },
    mounted() {
      this.getNews();      
    },
    methods: {
      getNews() {
        this.loading = true;
        let params = {}
        axios.post('/index/get_news', params).then(res => {
          this.news = res.data.news;
        })
        .finally(() => {this.loading = false; this.initSlider(); })
      },
      initSlider() {
        this.swiper = new window.Swiper('.swiper-container', {
      cssMode: true,
      slidesPerView: 4,
      spaceBetween: 40,
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        480: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        640: {
          slidesPerView: 4,
          spaceBetween: 40,
        }
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      /*pagination: {
        el: '.swiper-pagination'
      },*/
      mousewheel: false,
      keyboard: true,
      });
      }
    },
    props: {
    },
    components: {     
    },
    computed: {
    },
};
</script>


