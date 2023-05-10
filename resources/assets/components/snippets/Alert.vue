<template>
  <!--<v-alert
    type="warning"
    elevation="2"
    style="border-radius: 8px !important;"
    dense
    v-if="errors.length > 0"
  >
    <template v-for="(item, i) in errors">
      <v-row align="center">
        <v-col class="grow py-1" v-html="item.text"></v-col>
        <v-col class="shrink py-1">
          <v-btn :href="item.link" v-html="item.link_text" small class="rounded-btn" :elevation="1" color="primary"></v-btn>
        </v-col>
      </v-row>
    </template>
  </v-alert>-->
</template>

<script> 

export default {
  name: 'Alert',
  data () {
    return {
      errors: [],
    }
  },
  props: {
    item: Object,
    user_id: Number,
  },
  methods: {
    translateErrors() {
      this.errors.map(error => {
        if (error.text == error.title) { error.text = '<span class="no_translate">'+error.title+'</span>' }
        if (error.link_text == error.link_text_title) { error.link_text = '<span class="no_translate">'+error.link_text_title+'</span>' }
      })
    },
  },
  mounted() {
    this.errors = []
    axios.post('/admin/users/check_complete', {id: this.user_id}).then(res => {
      res.data.errors.map(error => {
        if (error == 'empty_customer') {
          this.errors.push({
            text: __('alert.empty_customer'),
            title: 'alert.empty_customer',
            link_text: __('alert.empty_customer_link'),
            link_text_title: 'alert.empty_customer_link',
            link: '/admin/customer/add',
          })
        }
        if (error == 'empty_directory_firm') {
          this.errors.push({
            text: __('alert.empty_directory_firm'),
            title: 'alert.empty_directory_firm',
            link_text: __('alert.empty_directory_firm_link'),
            link_text_title: 'alert.empty_directory_firm_link)',
            link: '/admin/directory/add_firm',
          })
        }
        if (error == 'empty_directory_person') {
          this.errors.push({
            text: __('alert.empty_directory_person'),
            title: 'alert.empty_directory_person',
            link_text: __('alert.empty_directory_person_link'),
            link_text_title: 'alert.empty_directory_person_link)',
            link: '/admin/directory/add_person',
          })
        }
      })
      this.translateErrors()
    })
  },
};
</script>