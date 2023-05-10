<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
    </v-container>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import Alert from '../snippets/Alert'

export default {
  name: 'billing_pay',
  data () {
    return {
      
    }
  },
  props: {
    user_id: Number,
  },
  components: {AdminPanel, FieldAccess, snackbar, Alert},
  mounted() {
   
  },
  methods: {
   
  },
  watch: {

  },
  computed: {
    loading: {
      get() { return this.$store.state.loading },
    },
  },
};
</script>
