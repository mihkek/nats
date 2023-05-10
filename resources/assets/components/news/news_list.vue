<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
      <v-layout row wrap>
        <v-flex md3 xs12 v-for="item in items" :key="item.id">
          <v-card>
              <v-img :src="item.img" height="194"></v-img>
              <v-card-title class="headline" v-text="item.title"></v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text color="primary" :href="item.href" small><span v-html="__('buttons.read_more')"></span></v-btn>
              </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  <snackbar />

  </v-app>
</template>

<script> 
import snackbar from '../snackbar'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import Alert from '../snippets/Alert'

export default {
  name: 'news',
  data () {
    return {
      items: [
        {
          id: 1,
          title: 'Заголовок новости',
          text: 'Описание новости',
          img: 'https://cdn.vuetifyjs.com/images/cards/mountain.jpg',
          href: '/admin/news/2019/09/11/name-news',
          date: '24/04/2020'
        },
        {
          id: 2,
          title: 'Заголовок новости',
          text: 'Описание новости',
          img: 'https://cdn.vuetifyjs.com/images/cards/mountain.jpg',
          href: '/admin/news/2019/09/11/name-news',
          date: '24/04/2020'
        },
        {
          id: 3,
          title: 'Заголовок новости',
          text: 'Описание новости',
          img: 'https://cdn.vuetifyjs.com/images/cards/mountain.jpg',
          href: '/admin/news/2019/09/11/name-news',
          date: '24/04/2020'
        }
      ],
    }
  },
  components: {AdminPanel, FieldAccess, snackbar, Alert},
};
</script>