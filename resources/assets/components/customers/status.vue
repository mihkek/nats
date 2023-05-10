<template>
  <v-layout row wrap>
    <v-flex xs12 class="py-0">
      <v-card flat color="transparent">
        <v-chip-group center-active>
          <v-chip
            v-for="status in status_options"
            :key="status.id"
            :color="status.color"
            :outlined="item.status != status.id ? true : false"
            :dark="item.status == status.id ? true : false"
            label
            :style="item.status != status.id ? 'background: #fff !important;' : ''"
            :class="item.status == status.id ? 'elevation-4 white--text' : '' "
            @click.stop="changeStatus(status)"
            :disabled="status.id != item.status && status.disabled"
            tag
            v-if="status.show != false"
          >
            <v-icon left size="18">{{status.icon}}</v-icon>
            <span v-html="status.title"></span>
          </v-chip>
        </v-chip-group>
      </v-card>
    </v-flex>
    <v-dialog v-model="dialog" max-width="420px">
      <v-card>
        <v-card-title primary-title>
          Укажите причину
        </v-card-title>
        <v-card-text>
          <v-radio-group
            v-model="customer.status_option"
            column
          >
            <v-radio
              v-for="option in selected.items"
              :key="option.id"
              :label="option.title"
              :value="option.id"
              :ripple="false"
            ></v-radio>
          </v-radio-group>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" small text @click.stop="dialog = false" v-html="__('buttons.cancel')"></v-btn>
          <v-btn color="primary" small text @click.stop="submit" v-html="__('buttons.submit')"></v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script> 
export default {
  name: 'customer_status',
  data () {
    return {
      customer: {},
      selected: {},
      dialog: false,
      status_options: [
        { id: 1, title: 'В процессе обучения', color: 'green', icon: 'mdi-play-circle-outline' },
        { id: 2, title: 'Приостановил обучение', color: 'amber', icon: 'mdi-pause-circle-outline' },
        { id: 3, title: 'Окончил обучение', color: 'blue', icon: 'mdi-check-circle-outline' },
        { 
          id: 4, 
          title: 'Расторг договор', 
          color: 'red', 
          icon: 'mdi-cancel',
          items: [
            { id: 1, title: 'Не понравилось обучение' },
            { id: 2, title: 'Дорого' },
            { id: 3, title: 'Уехали в другой город' },
            { id: 4, title: 'У ребенка хроническая болезнь' },
            { id: 5, title: 'Без объяснения причины' },  
          ]         
        },
      ],
    }
  },
  props: {
    user_id: Number,
    item: Object,
  },
  mounted() {
    this.customer = Object.assign({}, this.item)
    this.customer.status_option = Number(this.item.status_option)
  },
  methods: {
    submit() {
        this.loading = true
        this.customer.status = this.selected.id
        this.customer._lang = this.locale
        this.$store.dispatch('EDIT_CUSTOMER', this.customer).then(res => {
          this.dialog = false
          this.$emit('refresh')
        })
        .finally(() => (this.loading = false))
    },
    changeStatus(status) {
      if (status.items != undefined) {
        this.selected = Object.assign({}, status)
        this.dialog = true
      }
      else {
        this.loading = true
        this.customer.status = status.id
        this.customer.status_option = null
        this.customer._lang = this.locale
        this.$store.dispatch('EDIT_CUSTOMER', this.customer).then(res => {
          this.$emit('refresh')
        })
        .finally(() => (this.loading = false))
      }
    },
  },
  watch: {
    item(val) {
      this.customer = Object.assign({}, val)
    this.customer.status_option = Number(val.status_option)
    }
  },
  computed: {
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
};
</script>
