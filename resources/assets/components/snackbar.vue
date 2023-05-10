<template>
  <v-snackbar 
    v-model="snackbar.show" 
    :vertical="false" 
    right 
    :class="snackbar.status == 0 ? 'red--text' : 'green--text' "
  >
    {{snackbar.text}}
    <v-btn 
      color="white" 
      text 
      @click="snackbar.show = false" 
      x-small
      v-text=""
    >
      <span v-html="__('buttons.close')"></span>
    </v-btn>
  </v-snackbar>
</template>

<script> 
export default {
  name: 'snackbar',
  data () {
    return {
    }
  },
  computed: {
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    }
  },
};
</script>
