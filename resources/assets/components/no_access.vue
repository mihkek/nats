<template>
  <v-app id="vue_block" style="height: 75vh;">
  <v-container fluid grid-list-xl class="px-0 py-0" style="height: 100%;">
    <v-flex xs12 style="height: 100%;" class="d-flex">
      
    <v-card
    class="mx-auto my-auto"
    color="transparent"
    flat
    max-width="600"
  >
    <v-card-title class="headline text-center mb-2" >
      <v-spacer></v-spacer>
      <span v-html="__('no_access.title')"></span>
      <v-spacer></v-spacer>
    </v-card-title>
    <v-card-subtitle class="subtitle text-center mb-4 body-2" v-html="__('no_access.subtitle')"></v-card-subtitle>
    <v-card-text class="text-center body-2" v-html="__('no_access.text')" ></v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="primary" v-html="__('buttons.support')" text small href="/admin/helpdesk"></v-btn>
      <v-spacer></v-spacer>
    </v-card-actions>
  </v-card>
    </v-flex>
  </v-container>
  </v-app>
</template>

<script> 
export default {
  name: 'no_access',
  data () {
    return {
    }
  },
  computed: {

  },
};
</script>
