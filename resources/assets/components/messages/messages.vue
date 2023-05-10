<template>
  <div>
  <v-card class="mb-3" flat outlined>
  	 <v-list>
        <v-list-item v-for="message in messages" :key="message.id">
                  <v-list-item-content>
                    <v-list-item-title>{{message.name}} </small>
                     <v-btn elevation="2" x-small class="my-1 success--text" @click.stop="dialogAnswer(message.user_from)">
                      <v-icon size="18" color="success">mdi-check</v-icon><span class="ml-1">Ответить на сообщение</span>
                    </v-btn>
                    </v-list-item-title>
                  <v-list-item-subtitle>{{message.created_at}}</v-list-item-subtitle>
                  <p class="message-text">{{message.message}}</p>
                  </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="messages.length === 0">
                  <v-list-item-content>
                    <v-list-item-title>Сообщений нет</v-list-item-title>                           
        </v-list-item-content>
        </v-list-item>
    </v-list>
  </v-card>
<v-card class="mb-3" flat outlined>
<v-list>
      <v-list-item>
            <v-list-item-content>    
                <v-list-item-subtitle class="text-center">
                 <v-btn
                    depressed
                    color="success"
                    @click.stop="dialogMessage"
                    class="rounded-btn"
                >
                  <v-icon left size="20">mdi-plus</v-icon>
                Написать сообщение
                </v-btn>       
                 </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-list>
  </v-card>

    <v-dialog v-model="message_dialog" max-width="420">
      <v-card color="#f6f6f6">
        <v-card-title>
          Написать сообщение
        </v-card-title>
        <v-card-text>

          <v-textarea
              solo
              flat
              dense
              v-model="new_message"             
              auto-grow
            ></v-textarea>
           
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="message_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="sendMessage">Отправить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-dialog v-model="answer_dialog" max-width="420">
      <v-card color="#f6f6f6">
        <v-card-title>
          Ответ на сообщение
        </v-card-title>
        <v-card-text>

          <v-textarea
              solo
              flat
              dense
              v-model="new_answer"             
              auto-grow
            ></v-textarea>
           
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="answer_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="sendAnswerMessage">Отправить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</div>
</template>

<script> 
export default {
  name: 'messages',
  data () {
    return {
      message_dialog: false,
      answer_dialog: false,
      new_message: "",
      new_answer: "",
      messages: [],
      answer_user: null,
    }
  },
  props: {
    auth_user: Object,
    auction_id: Number,
    user_auction: Number,
  },
  mounted() {
    this.loadMessages();
    console.log(this.auth_user)
  },
  methods: {
    loadMessages() {               
       if (this.auction_id !== undefined && this.auth_user !== undefined) {      
          let auth_user_id = this.auth_user.id; 
          let auction_id = this.auction_id; 
          let params = {           
            auction_id: auction_id,
            user_id: auth_user_id,
          };
          let api_messages = "/api/messages/get_messages";
          if (this.auth_user.role_id === 1000) {
            api_messages = "/api/messages/get_admin_messages";
          }  
          axios.post(api_messages, params)
          .then(response => this.messages = response.data.data)       
      }
    },
    dialogMessage() {
      this.message_dialog = true;
    },

    dialogAnswer(user_id) {
      this.answer_dialog = true;
      this.answer_user = user_id;
    },
    sendMessage() {
      if (this.new_message !== "") {
        let auth_user_id = this.auth_user.id;

        /*let name = this.auth_user.name || '';
        name += " ";
        name += this.auth_user.last_name || '';
        name += " ";
        name += this.auth_user.middle_name  || ''; */
        let name = "";
        if (this.auth_user.company_name) {
          name = this.auth_user.company_name; 
        } else {
          name = this.auth_user.name || '';
        }

        let auction_id = this.auction_id;
        let user_auction = this.user_auction;
        let user_from = auth_user_id;
        let user_to = user_auction;  

          let params = {
            new_message: this.new_message,
            name: name,
            auction_id: auction_id,
            user_auction: user_auction,
            user_from: user_from,
            user_to: user_to,
          };          
          axios.post('/api/messages/send', params).then(res => {
           alert("Сообщение отправлено на проверку");
           this.new_message = "";
           this.message_dialog = false;
           this.loadMessages();
          });
        }
    },
    sendAnswerMessage() {
      if (this.new_answer !== "") {
        let auth_user_id = this.auth_user.id;

        let name = "";
        if (this.auth_user.company_name) {
          name = this.auth_user.company_name; 
        } else {
          name = this.auth_user.name || '';
        }

        let auction_id = this.auction_id;
        let user_auction = this.user_auction;
        let user_from = auth_user_id;
        let user_to = this.answer_user;  

          let params = {
            new_message: this.new_answer,
            name: name,
            auction_id: auction_id,
            user_auction: user_auction,
            user_from: user_from,
            user_to: user_to,
          };          
          axios.post('/api/messages/send', params).then(res => {
           alert("Сообщение отправлено на проверку");
           this.new_answer = "";
           this.answer_dialog = false;
           this.loadMessages();
          });
        }
    },
  }

};
</script>


<style>
.message-text {
  font-size: 16px;
  line-height: 1.4;
}
</style>