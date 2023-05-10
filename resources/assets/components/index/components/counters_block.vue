<template>
    <div>
          <!--<div class="container container--fluid" style="padding: 1.5em 36px; margin: 0px; background: rgba(0, 0, 0, 0.3);">
                    <div class="layout row wrap" style="margin: 0px; max-width: 960px;">
                        <div class="flex sm3 xs12">
                            <h5 class="counter" style="margin: 0.25em 0px 0px; line-height: 150%; text-transform: uppercase; padding: 0.5em 0px; opacity: 1;"><b style="font-size: 250%;" id="counter-1"></b><br>пользователей</h5>
                        </div>
                        <div class="flex sm3 xs12">
                            <h5 class="counter" style="margin: 0.25em 0px 0px; line-height: 150%; text-transform: uppercase; padding: 0.5em 0px; opacity: 1;"><b style="font-size: 250%;" id="counter-2"></b><br>Тендеров</h5>
                        </div>
                        <div class="flex sm6 xs12">
                            <h5 class="counter" style="margin: 0.25em 0px 0px; line-height: 150%; text-transform: uppercase; padding: 0.5em 0px; opacity: 1;"><b style="font-size: 250%;" id="counter-3"></b><b style="font-size: 150%;">&nbsp;₽</b><br>Общая стоимость тендеров<br></h5>
                        </div>
                    </div>
                </div>-->

        <!---- Счетчики px-3 py-2 text-uppercase ---->
        <v-container fluid style="padding: 1.5em 36px;margin:0 0; background:rgba(0,0,0,.3);">
            <v-layout row wrap style="margin:0;max-width:960px;">
            
              <v-flex sm3 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(userscountformated)" style="font-size:250%;"></b><br>пользователей</h5>
              </v-flex>
                
              <v-flex sm3 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(tenderscountformated)" style="font-size:250%;"></b><br>прошло тендеров</h5>
              </v-flex>

              <v-flex sm6 xs12>
                <h5 style="margin:.25em 0 0 0; line-height:150%; text-transform:uppercase; padding:.5em 0" v-bind:style="{opacity:opacityTweened}" class="counter"><b v-html="(summcountformated)" style="font-size:250%;"></b><b style="font-size:150%;">&nbsp;₽</b><br>Общая стоимость тендеров<br></h5>
              </v-flex>

            </v-layout>
        </v-container>

    </div>
</template>

<!--CSS-->
<style>

</style>

<script> 
export default {
    name: 'counters_block',
    data () {
        return {
            loading: false,
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
          axios.get('/index/get_counters', params).then(res => {
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
        },

    },
    props: {
    },
    components: {
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
        },
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
        },
      },

};
</script>

