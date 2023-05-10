<template>
  <v-card class="rounded-lg px-4">
    <v-chip-group active-class="blue--text" v-model="selected" @change="changeType">
      <v-chip label filter :key="1">
        <v-icon size="16" left>mdi-phone-outgoing</v-icon>
        <span class="mr-3">Просроченных платежей</span>
        <v-avatar size="18" color="red" style="border-radius: 50% !important;">
          <span class="white--text">{{item.pays}}</span>
        </v-avatar>
      </v-chip>
    </v-chip-group>
    <!-- <v-toolbar flat>
      <v-list-item-group>
        <v-list-item  @click.stop="select(1)" :active="selected == 1" color="blue">
          <v-list-item-action><v-icon>mdi-phone-outgoing</v-icon></v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Просроченных звонков</v-list-item-title>
          </v-list-item-content>
          <v-list-item-avatar color="red" style="border-radius: 50% !important;">
            <span class="white--text">{{item.calls}}</span>
          </v-list-item-avatar>
        </v-list-item>
        <v-divider vertical class="my-0 mx-4"></v-divider>
        <v-list-item  @click.stop="select(2)" :active="selected == 2" color="blue">
          <v-list-item-action><v-icon>mdi-clipboard-text-play</v-icon></v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Просроченных записей</v-list-item-title>
          </v-list-item-content>
          <v-list-item-avatar color="red" style="border-radius: 50% !important;">
            <span class="white--text">{{item.records}}</span>
          </v-list-item-avatar>
        </v-list-item>
        </v-list-item-group>
    </v-toolbar> -->
  </v-card>
</template>

<script> 
export default {
  name: 'customer_notifications',
  data () {
    return {
      selected: '',
    }
  },
  props: {
    user_id: Number,
  },
  mounted() {
    this.getItems()
  },
  methods: {
    changeType() {
      this.$emit('select', this.selected)
    },
    getItems() {
      this.$store.dispatch('GET_CUSTOMERS_NOTIFICATIONS', { user_id: this.user_id })
    },
  },
  computed: {
    item: {
      get() { return this.$store.state.customers.notifications },
      set(val) { this.$store.state.customers.notifications = val }
    }
  },
};
</script>
