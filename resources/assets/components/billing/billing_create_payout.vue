<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
    <v-layout row wrap>
      <v-flex md6 xs12>
        <v-card color="transparent" flat>
          <ul class="list-group pl-0 ml-0">
            <li class="list-group-item py-3" style="border-bottom: 0px;"></li>
            <v-card flat style="border-right: 1px solid #ddd; border-left: 1px solid #ddd;">
              <v-card-title primary-title class="pb-4 pt-0"><v-icon class="mr-4">mdi-wallet</v-icon> <span>Добавить выплату</span></v-card-title>
              <v-card-text class="pt-4">
                <v-container fluid class="px-0 py-0">
                  <v-layout row wrap>
                    <v-flex md4>
                      <v-text-field
                        outlined
                        append-icon="mdi-currency-rub"
                        v-model="item.sum"
                        type="number"
                      >
                        <template v-slot:label>
                           <span v-html="__('billing.amount_label')"></span>
                        </template>
                      </v-text-field>
                    </v-flex>
                    <v-flex md8>
                      <v-text-field
                        outlined
                        append-icon="mdi-account"
                        v-model="item.user_email"
                        @click.stop="editTableItem( 'Выберите пользователя', 'user', directory_users, user_headers)"
                      >
                        <template v-slot:label>
                           <span>Выберите пользователя</span>
                        </template>
                      </v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-textarea
                        auto-grow
                        outlined
                        append-icon="mdi-comment"
                        v-model="item.comment"
                      >
                        <template v-slot:label>
                           <span v-html="__('billing.pay_comment')"></span>
                        </template>
                      </v-textarea>
                    </v-flex>
                    <v-flex xs12 class="text-center">
                      <v-btn color="success" class="rounded-btn" x-large @click.stop="submit">
                        <v-icon left>mdi-cart</v-icon>
                        <span v-html="__('buttons.pay')"></span>
                      </v-btn>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
            </v-card>
            <!-- <v-list class="py-0" dense>
              <v-list-item class="cardform-list-item pb-2">
                <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0"></h4></v-list-item-content>
              </v-list-item>
            </v-list> -->
            <li class="list-group-item py-3" style="border-top: 0px;"></li>
          </ul>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
  <v-dialog v-model="tabledialog" max-width="90%"><tabledialog v-if="tabledialog" @submit="submitSelect" @close="tabledialog = !tabledialog" :item="item"/></v-dialog>
  <snackbar />
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import tabledialog from '../tabledialog'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'

export default {
  name: 'billing_create',
  data () {
    return {
      tabledialog: false,
      item: {},
      user_headers: [
        { id: 1, text: __('billing.user_id'), value: 'id' },
        { id: 2, text: __('billing.user_full_name'), value: 'full_name' },
        { id: 2, text: __('billing.user_email'), value: 'email' },
      ],
    }
  },
  props: {
    user_id: Number,
  },
  components: {snackbar, tabledialog, AdminPanel, FieldAccess},
  mounted() {
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.$store.dispatch('GET_DIRECTORY_USERS', { user_id: this.user_id })
  },
  methods: {
    submitSelect() {
      this.item.user_email = this.item.user.email
      this.tabledialog = false
    },
    submit() {
      let data = {
        user_id: this.item.user.id,
        sum: this.item.sum,
        comment: this.item.comment,
      }
      this.$store.dispatch('CREATE_USER_BILLING_PAYOUT', data).then(res => {
        this.item = {}
      })
    },
    editTableItem(text, val, items, headers) {
      let field = { text: text, val: val, items: items, headers: headers }
      this.item.field = field
      this.tabledialog = true
    },
  },
  watch: {
    auth_user: function (val) {
      if (val.role_id != 1000) { location.href = '/admin' }
    },
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    directory_users: {
      get() { return this.$store.state.configer_users.directory_users },
    },
  },
};
</script>
