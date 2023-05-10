<template>
  <v-app>
    <!-- Шапка сайта -->
    <app_bar :user_id="user_id" />

    <!-- Левое меню сайта -->
    <nav_bar :user_id="user_id" />

    
    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>
      
    </v-main>
    
  </v-app>
</template>

<script> 

import app_bar from './components/app_bar'
import nav_bar from './components/nav_bar'

export default {
  name: 'index',
  data () {
    return {
    }
  },
  mounted() {
  },
  methods: {
  },
  props: {
    user_id: Number,
  },
  components: {
    app_bar,
    nav_bar
  },
  computed: {
  },
};
</script>

<style>
#main {
  background: #f1f1f1;
}
</style>
