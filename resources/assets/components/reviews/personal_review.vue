<template>
  <v-app id="vue_block" style="background: transparent !important;" >
      <v-alert
          border="left"
          type="error"
          v-model="error"
          icon="mdi-information"
      >{{ error_text }}</v-alert>
      <v-alert
          border="left"
          type="success"
          v-model="success"
          icon="mdi-information"
      >Спасибо за ваш отзыв.</v-alert>
    <v-form v-if="!success" @submit.prevent="submit">
      <v-card class="mx-auto" style="max-width: 600px;">
        <v-toolbar gray>
          <v-card-title class="title font-weight-regular">Ваш отзыв</v-card-title>
          <v-spacer></v-spacer>
        </v-toolbar>
          <v-textarea v-model="review" solo rows="5" style="padding: 15px;"></v-textarea>
        <v-divider></v-divider>
        <v-card-actions><v-btn @click="review='';">Очистить</v-btn>
          <v-spacer></v-spacer>
          <v-btn class="white--text" color="deep-purple accent-4" type="submit">Отправить</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-app>
</template>

<script>

export default {
  data () {
    return {
	  id: '',
	  review: '',
	  error: false,
	  error_text: '',
	  success: false,

    }
  },
  props: {
    user_id: Number
  },
  mounted() {
  },
  components: {  },
  methods: {
	submit() {

      if (!this.review) {
        this.error_text = 'Заполните данные.';
        this.error = true;
        setTimeout(()=>{
          this.error=false;
        },3000)
      } else {
        axios.post('/admin/personal/review', {'review' : this.review})
        .then((result) => {
            this.success = true;
        })
        .catch(() => {
           this.error_text = 'Не удалось сохранить отзыв.';
           this.error = true;
           setTimeout(()=>{
             this.error=false;
           },3000)

       });
      }
    }
  },
  directives: {
  },
  watch: {
  },
  computed: {
  },
};
</script>
