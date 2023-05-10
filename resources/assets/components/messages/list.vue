<template>
<v-app>
  <v-main>
<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Панель админа" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md12>
        <v-card class="rounded-card px-4 py-4" flat>
          <v-toolbar color="transparent" flat dense height="38px">
            <v-toolbar-items>
              <v-text-field
                hide-details
                solo
                flat
                prepend-icon="mdi-magnify"
                dense
                v-model="search"
              >
                <template v-slot:label>
                  <span v-html="__('forms.search_label')"></span>
                </template>      
              </v-text-field>
            </v-toolbar-items>
            <v-spacer></v-spacer>

            <!--<v-btn color="success" class="rounded-btn" @click.stop="newItem" small>
              <v-icon left>mdi-plus</v-icon> <span v-html="__('buttons.add')"></span></v-btn>-->
          </v-toolbar>

          <v-card outlined class="rounded-card mt-1">
            <v-data-table
                  :items="items"
                  :headers="headers"
                  :search="search"
                  color="transparent"
                  :items-per-page="50"
                  :locale="$vuetify.lang.current"
                  :loading="loading"
                  class="rounded-card"
                  :sort-by="['id']"
                  :mobile-breakpoint="100"
                  :expanded.sync="expanded"
                  calculate-width
                >
                <template v-slot:header.id="{ header }"><span v-html="'ID'"></span></template>  
                <template v-slot:header.date="{ header }"><span v-html="'Дата'"></span></template>  
                <template v-slot:header.auction_id="{ header }"><span v-html="'Тендер'"></span></template>
                <template v-slot:header.name="{ header }"><span v-html="'Имя'"></span></template>
                <template v-slot:header.message="{ header }"><span v-html="'Сообщение'"></span></template>
                <template v-slot:header.published="{ header }"><span v-html="'Опубликован'"></span></template>
                <template v-slot:header.actions="{ header }"><span v-html="'Действия'"></span></template>

                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="px-0">
                    <v-list color="#f1f1f1" dense>
                      <v-list-item>
                        <v-list-item-subtitle>'ID' - {{item.id}}</v-list-item-subtitle>
                      </v-list-item>
                      <v-list-item>
                        <v-list-item-content>{{item.message}}</v-list-item-content>
                      </v-list-item>
                    </v-list>
                  </td>
                </template>
                <template v-slot:item="{ item }">
                  <tr class="table-row">
                    <!--<td class="d-table-cell d-md-none px-0 py-0 text-center">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                        </v-tooltip>
                      </td>-->
                    <td class="d-none d-md-table-cell">{{item.id}}</td>
                    <td>{{item.created_at}}</td>
                    <td>{{item.auction_id}}</td>
                    <td>{{item.name}}</td>
                    <td class="d-none d-md-table-cell">{{item.message}}</td>
                    <td class="d-none d-md-table-cell"><span v-if="item.published === 1">Да</span><span v-if="item.published === 0">Нет</span></td>
                    <td class="text-right">
                      <span class="caption" @click="deleteItem(item)">Удалить</span>
                      <span class="caption" @click.stop="editItem(item)" v-if="item.published === 0">Изменить</span>
                      <span class="caption" @click.stop="publishMessage(item.id)" v-on="on" v-if="item.published === 0">Одобрить</span>
                    <!--<v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="grey" icon @click.stop="deleteItem(item)" v-on="on"><v-icon small>mdi-thumb-down</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.delete_tooltip')"></span>
                    </v-tooltip>  
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="grey" icon @click.stop="editItem(item)" v-on="on" v-if="item.published === 0"><v-icon small>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="grey" icon @click.stop="publishMessage(item.id)" v-on="on" v-if="item.published === 0"><v-icon small>mdi-thumb-up</v-icon></v-btn>                        
                      </template>
                      <span class="caption" v-html="'Одобрить'"></span>
                    </v-tooltip>
                  -->
                    </td>
                  </tr>
                </template>
            </v-data-table>     
          </v-card>


        </v-card>
      </v-flex>
    </v-layout>

     <v-toolbar color="transparent" flat dense>
          <v-spacer></v-spacer>
          <v-btn color="warning" class="rounded-btn" @click.stop="getMessagesXls()" small>
            <v-icon left>mdi-download</v-icon>
            <span>Скачать в XLS</span></v-btn>
        </v-toolbar>
  </v-container>




    <v-dialog v-model="dialog" max-width="520px">
      <v-card color="#fafafa">
        <v-card-title primary-title v-html="'Редактор сообщений'"></v-card-title>
        <v-card-text class="py-4">
          <v-textarea
            v-model="selectedItem.message"
            solo
            flat
          >
          <template v-slot:label>
              <span v-html="__('role.description')"></span>
            </template>     
          </v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="dialog = !dialog" v-html="__('buttons.cancel')"></v-btn>
          <v-btn color="primary" text @click.stop="editMessage" v-html="__('buttons.submit')"></v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  <snackbar />
   </v-main>
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import AdminPanel from '../snippets/AdminPanel'  
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'messages_list',
  data () {
    return {
      dialog: false,
      message_dialog: false,
      new_message: "",
      headers: [
        /*{ id: 0, text: '', value: 'expanded', align: 'center', sortable: false, class: 'd-table-cell d-md-none' },  */      
        { id: 1, text: 'ID', value: 'id', class: 'd-none d-md-table-cell' },
        { id: 2, text: 'Дата', value: 'date', class: 'd-none d-md-table-cell' },
        { id: 3, text: 'Тендер', value: 'auction_id', class: 'd-none d-md-table-cell' },
        { id: 4, text: 'Имя', value: 'name' },
        { id: 5, text: 'Сообщение', value: 'message', class: 'd-none d-md-table-cell' },
        { id: 6, text: 'Опубликован', value: 'published', class: 'd-none d-md-table-cell' },
        { id: 7, text: 'Действия', value: 'actions', sortable: false },
      ],
      items: [],
      loading: false,
      search: '',
      dialog_title: '',
      selectedItem: {
        id: null,
        message: null,
      },
      expanded: [],
    }
  },
  components: {TheMask, snackbar, AdminPanel, FieldAccess, FieldAccessButton},
  props: {
    
    user_id: Number,
    is_new: Boolean,
    
  },
  mounted() {
    this.loadMessages();

  },
  methods: {
    getMessagesXls() {   
      this.loading = true
      let params = {       
      }     
      axios.post('/api/messages/get_xls', params).then(res => {
        if (res.data.status != 1) console.log(res.data)
        else location.href = res.data.link
      })
         .finally(() => (this.loading = false))
    },

    loadMessages() {    
      let api_messages = "/api/messages/index/";
      if (this.is_new) {
        api_messages = "/api/messages/index_new";
      } 
      axios.get(api_messages)
          .then(response => this.items = response.data.data);      
    },

    publishMessage(id) {
          let params = {
            id: id,
          };          
          axios.post('/api/messages/publish', params).then(res => {
           alert("Сообщение одобрено");           
           this.loadMessages();
          });
    },

    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },

    editItem(item) {
      /*this.selectedItem = Object.assign({}, item)*/
      this.selectedItem.id = item.id
      this.selectedItem.message = item.message
      this.dialog_title ='Редактировать сообщение'
      this.dialog = true
    },

    editMessage() {
          let params = {
            id: this.selectedItem.id,
            text: this.selectedItem.message,
          };          
          axios.post('/api/messages/update', params).then(res => {
           alert("Сообщение изменено"); 
           this.selectedItem.id = null;
           this.selectedItem.message = null;         
           this.loadMessages();
           this.dialog = false;
          });
    },

    deleteItem(item) {
        if (confirm('Удалить сообщение?')) {
          axios.get('/api/messages/destroy/'+item.id).then(res => {
           alert("Сообщение удалено");           
           this.loadMessages();
          });
        }
    },

  }

};
</script>


