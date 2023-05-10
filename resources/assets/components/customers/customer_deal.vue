<template>
  <v-card flat outlined>
    
  </v-card>
</template>


<script> 
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'customer_deal',
  data () {
    return {

    }
  },
  props: {
    user_id: Number,
    customer: Object,
  },
  components: { 
    FieldAccess, 
    FieldAccessButton 
  },
  mounted() {

  },
  methods: {

  },
  watch: {

  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
    lang: {
      get() {
        return this.$store.state.directory_people.lang
      }
    }
  },
};
</script>
