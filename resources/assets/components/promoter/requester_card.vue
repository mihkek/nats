<template>
  <v-card :key="i" :elevation="1">
    <v-card-actions class="px-4 grey--text pt-4">
      <span class="caption">{{item.created_at}}</span>
      <v-spacer></v-spacer>
      <v-btn color="grey" x-small class="rounded-lg" outlined @click.stop="$emit('edit')">Изменить</v-btn>
    </v-card-actions>
    <v-list class="py-0" dense>
      <v-list-item three-line>
        <v-list-item-content>
          <v-list-item-subtitle>Родитель</v-list-item-subtitle>
          <v-list-item-title>{{item.customer_full_name}}</v-list-item-title>
          <v-list-item-subtitle>{{item.customer_main_phone}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>Ребенок</v-list-item-subtitle>
          <v-list-item-title>
            {{item.customer_child_full_name}}
            <span class="grey--text mx-3">
              {{item.customer_age}}
              <template v-if="item.customer_age == 1">год</template>
              <template v-else-if="item.customer_age <= 4">года</template>
              <template v-else>лет</template>
            </span>
          </v-list-item-title>
        </v-list-item-content>
        <v-list-item-action></v-list-item-action>
      </v-list-item>
    </v-list>
    <v-card-actions>
      <v-btn small text outlined color="grey">OPC: <span>{{auth_user.code_opc}}</span></v-btn>
      <v-spacer></v-spacer>
      <v-btn
        @click="show = !show"
        small
        text
        class="text-capitalize"
      >
        Подробнее <v-icon size="18" right>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
      </v-btn>
    </v-card-actions>
    <v-expand-transition>
      <div v-show="show">
        <v-divider class="my-0"></v-divider>
        <v-subheader>Тестирование</v-subheader>
        <v-list subheader dense>
          <v-list-item three-line>
            <v-list-item-content>
              <v-list-item-title>
                <span class="grey--text mr-2">Тест №1</span>
                Дерево {{item.first_test}}
              </v-list-item-title>
              <v-list-item-title>
                <span class="grey--text mr-2">Тест №2</span>
                Картинка {{item.second_test}}
              </v-list-item-title>
              <v-list-item-title>
                <span class="grey--text mr-2">Тест №3</span>
                {{item.third_test}}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-subheader>Фотографии</v-subheader>
        <v-card-text class="pt-0">
          <v-container fluid grid-list-lg class="px-0">
            <v-layout row wrap>
              <v-flex xs4>
                <v-card class="rounded-lg" flat>
                  <v-img
                      :src="'/storage/avatars/children/'+item.customer_photo_one"
                      :lazy-src="'/storage/avatars/children/'+item.customer_photo_one"
                      aspect-ratio="1"
                      class="grey lighten-2 rounded-lg"
                    >
                  </v-img>
                </v-card>
              </v-flex>
              <v-flex xs4>
                <v-card class="rounded-lg" flat>
                  <v-img
                      :src="'/storage/avatars/children/'+item.customer_photo_two"
                      :lazy-src="'/storage/avatars/children/'+item.customer_photo_two"
                      aspect-ratio="1"
                      class="grey lighten-2 rounded-lg"
                    >
                  </v-img>
                </v-card>
              </v-flex>
              <v-flex xs4>
                <v-card class="rounded-lg" flat>
                  <v-img
                      :src="'/storage/avatars/children/'+item.customer_photo_three"
                      :lazy-src="'/storage/avatars/children/'+item.customer_photo_three"
                      aspect-ratio="1"
                      class="grey lighten-2 rounded-lg"
                    >
                  </v-img>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>
<script>

export default {
    data() {
        return {
          loading: false,
          show: false,
        }
    },
    mounted() {

    },
    components: {  },
    methods: {
    },
    props: {
        item: Object,
    },
    watch: {},
    computed: {
      auth_user: {
        get() { return this.$store.state.auth_user }
      }
    },
};
</script>


