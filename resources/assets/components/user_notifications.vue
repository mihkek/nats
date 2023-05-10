<template>
  	<v-card flat class="rounded-lg">
  		qq
  	</v-card>
</template>

<script> 
export default {
  name: 'snackbar',
  data () {
    return {
    	items: [...Array(4)].map((_, i) => `Item ${i}`),
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
