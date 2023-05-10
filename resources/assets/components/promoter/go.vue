<template>
  <v-app id="vue_block" style="background: transparent !important;" >
    <v-form v-model="valid" ref="form" @submit.prevent="submit">
    <v-card flat max-width="420" class="mx-auto my-12">
      <v-card-title class="pa-4">
        <v-spacer></v-spacer>
        АВТОРИЗАЦИЯ OPC
        <v-spacer></v-spacer>
      </v-card-title>
      <v-card-text class="pa-4">
      	<v-autocomplete
          label="OPC"
          solo
          flat
          backgroundColor="rgb(232, 240, 254)"
          required
          v-model="id"
          :items="array"
        ></v-autocomplete>
        <!-- <v-text-field
          label="OPC"
          solo
          flat
          backgroundColor="rgb(232, 240, 254)"
          required
          v-model="id"
          type="number"
        ></v-text-field> -->
        <v-select
          :items="cities"
          v-model="city"
          label="Город"
          solo
          flat
          backgroundColor="rgb(232, 240, 254)"
          item-text="title"
          return-object
          required
        ></v-select>
        <v-select
          :items="city.items"
          v-model="place"
          label="Место"
          solo
          flat
          backgroundColor="rgb(232, 240, 254)"
          item-text="full_name"
          return-object
          required
        ></v-select>
      </v-card-text>
      <v-card-actions class="pa-4">
        <v-spacer></v-spacer>
        <v-btn color="primary" depressed block type="submit" large :loading="loading">Войти</v-btn>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
    </v-form>
     <snackbar />
  </v-app>
</template>

<script> 
import snackbar from '../snackbar'

export default {
  data () {
    return {
      valid: false,
      id: '',
      city: {},
      place: {},
      loading: false,
    }
  },
  mounted() {
    this.$store.dispatch('CHECK_AUTH').then(res => {
      if (res != undefined && res.status == 1) { window.location = '/promoter' }
    })
    this.getCities()
  },
  components: { snackbar },
  methods: {
    getCities() {
      this.$store.dispatch('GET_CITIES').then(res => {
        this.city = this.cities[0]
      })
    },
    submit() {
      if (this.valid) {
        this.loading = true
        let params = {
        	id: this.id,
        	city_id: this.city.id,
          directory_firm_id: this.place.id,
        }
        this.$store.dispatch('AUTH_GO', params).then(res => {
          if (res.status == 1) { window.location = '/promoter' }
        })
        .finally(() => (this.loading = false))
      }
    }
  },
  props: {

  },
  watch: {
    city(val) {
      this.place = val.items[0]
    }
  },
  computed: {
    cities: {
      	get() { return this.$store.state.cities }
    },
    array: {
    	get() {
    		let array = []
    		let i = 1;
			while (i <= 100) { 
			  array.push(i)
			  i++;
			}
			return array
    	}
    }
  },
};
</script>
