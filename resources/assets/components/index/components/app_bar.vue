<template>
  <v-app-bar
    class="elevation-2"
    color="#fff"
    app
    clipped-left
    tile
    height="50"
  >
    <!-- ТУТ HTML КОД -->

        <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #fff;">
          <div class="container-fluid" style="padding-right: 35px; padding-left: 25px;">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a v-if="user_id>0" class="navbar-brand" href="/admin" style="padding: 2px 20px;"><img src="/img/logo/on-white-middle1.png" alt="" style="height: 45px;"></a>
              <a v-else class="navbar-brand" href="/" style="padding: 2px 20px;"><img src="/img/logo/on-white-middle1.png" alt="" style="height: 45px;"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="/" v-if="menu_main">Главная</a><a v-else class="active">Главная</a></li>
                <li><a href="/about_service" v-if="menu_about">О проекте</a><a v-else class="active">О проекте</a></li>
                <li><a href="/services" v-if="menu_services">Услуги</a><a v-else class="active">Услуги</a></li>                
                <li><a href="/tenders" v-if="menu_tender">Все тендеры</a><a v-else class="active">Все тендеры</a></li>
                <!--<li><a href="/auctions" v-if="menu_auction">Все аукционы</a><a v-else class="active">Все аукционы</a></li>-->
                 <li><a href="/sales" v-if="menu_sale">Все распродажи</a><a v-else class="active">Все распродажи</a></li>
                <li><a href="/news" v-if="menu_news">Актуальное в АПК</a><a v-else class="active">Актуальное в АПК</a></li>
                <li v-if="user_id>0"><a href="/admin">Кабинет</a></li>
                <li v-else><a href="/registration">Регистрация</a></li>
                <li v-if="user_id>0"></li><li v-else><a href="/login">Вход</a></li>
              </ul>
            </div>
          </div>
        </nav>

    <div class="clearfix"></div>

  </v-app-bar>
</template>

<!-- ТУТ CSS -->
<style>

</style>

<script>
export default {
  name: 'app_bar',
  data () {
    return {
      menu_main: true,
      menu_services: true,
      menu_about: true,
      menu_tender: true,
      menu_auction: true,
      menu_sale: true,
      menu_news: true,
    }
  },
  mounted() {
    let link = location.href;
    console.log(location.href);
    if (link === "https://agtender.com/") {
      this.menu_main = false;
    }
    if (link === "https://agtender.com/services") {
      this.menu_services = false;
    }
    if (link === "https://agtender.com/about_service") {
      this.menu_about = false;
    }
    if (link === "https://agtender.com/tenders") {
      this.menu_tender = false;
    }
    if (link === "https://agtender.com/auctions") {
      this.menu_auction = false;
    }
    if (link === "https://agtender.com/sales") {
      this.menu_sale = false;
    }
    if (link === "https://agtender.com/news") {
      this.menu_news = false;
    }
  },
  methods: {
  },
  props: {
    user_id: Number,
  },
  components: {
  },
  computed: {
    active: {
      get() {
        let uri = window.location.href.split('/');
        if (uri[3] != undefined) return uri[3]
      }
    }
  },
};
</script>
