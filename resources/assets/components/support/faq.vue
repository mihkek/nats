<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
      <v-layout row wrap>
        <v-flex xs12>
          <v-expansion-panels popout flat hover>
             <v-expansion-panel v-for="(item,i) in items" :key="item.id" >
               <v-expansion-panel-header expand-icon="mdi-menu-down"><h4 v-text="item.title" class="font-weight-medium"></h4></v-expansion-panel-header>
               <v-expansion-panel-content><p v-text="item.text"></p></v-expansion-panel-content>
             </v-expansion-panel>
           </v-expansion-panels>
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
  name: 'faq',
  data () {
    return {
      items: [
        {
          id: 1,
          title: 'Вопрос 1',
          text: 'Turns out semicolon-less style is easier and safer in TS because most gotcha edge cases are type invalid as well.',
        },
        {
          id: 2,
          title: 'Вопрос 2',
          text: 'Turns out semicolon-less style is easier and safer in TS because most gotcha edge cases are type invalid as well.',
        },
        {
          id: 3,
          title: 'Вопрос 3',
          text: 'Turns out semicolon-less style is easier and safer in TS because most gotcha edge cases are type invalid as well.',
        }
      ],
    }
  },
  components: {AdminPanel, FieldAccess, snackbar, Alert},
};
</script>