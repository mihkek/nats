<template>
  <v-card height="100%" flat color="#fdfdfd" style="min-height: calc(100vh - 105px);">
    <template v-for="(item, i) in items">
      <requester_card :item="item" @edit="editItem(item)"/>
      <v-divider class="mt-4 mb-0" v-if="i != items.length-1"></v-divider>
    </template>
    <template v-if="!(items.length > 0)">
      <v-card height="100%" flat>
        <v-card-text class="text-center">
          Пусто
        </v-card-text>
      </v-card>
    </template>
  </v-card>
</template>
<script>

import * as easings from 'vuetify/es5/services/goto/easing-patterns'
import { mask } from 'vue-the-mask'
import requester_card from './requester_card'

export default {
    data() {
        return {
          loading: false,
        }
    },
    mounted() {
      this.getItems()
    },
    components: { requester_card },
    directives: { mask },
    methods: {
      editItem(item) {
        this.$emit('edit', item)
      },
      getItems() {
        this.loading = true
        let params = {}
        params.user_id = this.user_id
        params.promoter_id = this.auth_user.promoter_id
        params.subdivision_id = this.auth_user.subdivision_id
        params.date = 'today'
        params._lang = this.locale
        console.log(params)
        this.$store.dispatch('GET_REQUESTERS', params)
        .finally(() => (this.loading = false))
      },
    },
    props: {
        user_id: Number,
        tab: Number,
    },
    watch: {
      tab(val) {
        if (val == 1) this.getItems()
      }
    },
    computed: {
      items: {
        get() { return this.$store.state.requester.items },
        set(val) { this.$store.state.requester.items = val }
      },
      auth_user: {
          get() { return this.$store.state.auth_user }
      },
      locale: {
          get() {
              return this.$store.state.lang.lang
          },
      },
    },
};
</script>
