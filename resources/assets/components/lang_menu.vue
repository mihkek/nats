<template>
  <v-card id="create">
    <v-speed-dial
      v-model="fab"
      :bottom="true"
      :left="true"
      :direction="'right'"
      :transition="'slide-y-reverse-transition'"
    >
      <template v-slot:activator>
        <v-btn
          v-model="fab"
          color="blue darken-2"
          dark
          fab
          :loading="loading"
        >
          <v-icon v-if="fab">mdi-close</v-icon>
          <v-avatar size="40" color="transparent" v-else>
            <v-img v-if="!loading" :src="'/storage/avatars/flags/'+selectedItem.name+'.gif'" alt="alt"></v-img>
          </v-avatar>
        </v-btn>
      </template>
      <v-btn fab dark small color="green" v-for="item in items" :key="item.code" v-if="item.code != selectedItem.code" @click.stop="submit(item)">
        <v-avatar size="40" color="transparent">
          <v-img v-if="!loading" :src="'/storage/avatars/flags/'+item.name+'.gif'" alt="alt"></v-img>
        </v-avatar>
      </v-btn>
    </v-speed-dial>
  </v-card>
</template>

<script> 
export default {
  name: 'lang_menu',
  data () {
    return {
      loading: false,
      fab: false,
      selectedItem: {},
    }
  },
  methods: {
    submit(item) {
      item.user_id = this.auth_user.id
      this.$store.dispatch('CHANGE_LANG', item).then(res => {
        location.reload()
      })
    },
  },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_LANG_ITEMS').then(res => { this.loading = false })
  },
  watch: {
    items: function (val) {
      if (val != undefined) {
        val.map(country => { if (country.code == this.lang.current) { this.selectedItem = country } })
      }
    },
  },
  computed: {
    lang: {
      get() { return this.$vuetify.lang }
    },
    items: {
      get() { return this.$store.state.lang.items }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
  },
};
</script>
