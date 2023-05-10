<template>
  <v-card flat color="transparent">
    <ul class="list-group pl-0 ml-0 no-border">
      <li class="list-group-item py-2" style="border: 0px !important; background: #e1e5ec !important;"></li>
      <v-list dense color="#e1e5ec" class="py-0">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-subtitle class="caption grey--text text--darken-1" v-html="__('date_logger.id_text')"></v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-content class="text-right inline-block"><v-list-item-subtitle class="caption">{{item.id}}</v-list-item-subtitle></v-list-item-content>
        </v-list-item>
        <v-divider class="my-0"></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-subtitle class="caption grey--text text--darken-1" v-html="__('date_logger.created_text')"> </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-content class="text-right inline-block"> <v-list-item-subtitle class="caption grey--text text--darken-1">{{item.created_at}}</v-list-item-subtitle></v-list-item-content>
        </v-list-item>
        <v-divider class="my-0"></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-subtitle class="caption grey--text text--darken-1"  v-html="__('date_logger.updated_text')"> </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-content class="text-right inline-block"><v-list-item-subtitle class="caption grey--text text--darken-1">{{item.updated_at}}</v-list-item-subtitle></v-list-item-content>
        </v-list-item>
      </v-list>
      <li class="list-group-item py-2" style="border: 0px !important; background: #e1e5ec !important;"></li>
    </ul>
  </v-card>
</template>

<script> 

export default {
  name: 'DateLogger',
  data () {
    return {

    }
  },
  props: {
    item: Object,
    user_id: Number,
  },
};
</script>