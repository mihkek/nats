<template>
  <v-card flat outlined class="my-3">
    <v-card-title>
      Список учащихся
      <v-spacer></v-spacer>
      <span v-if="item.customers != undefined">({{item.customers.length}})</span>
    </v-card-title>
    <v-divider class="my-0"></v-divider>
    <v-list two-line subheader color="#fdfdfd">
      <template v-if="item.customers != undefined">
      <template v-for="(customer, index) in item.customers">
        <v-list-item
          :key="customer.id"
          three-line
          :href="'/admin/customer/list/card/'+customer.id"
          target="_blank"
          style="text-decoration: none !important;"
        >
          <v-list-item-avatar>
            <v-img :src="'/storage/avatars/50x50.'+customer.avatar" v-if="customer.avatar != null"></v-img>
            <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title v-html="customer.child_full_name"></v-list-item-title>
            <v-list-item-subtitle>
              <span v-html="customer.main_phone"></span> &mdash; <span class="caption" v-html="'Родственник - '+customer.full_name"></span>.
            </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-action v-if="is_edit">
            <v-btn color="red" icon small @click.prevent="deleteCustomer(customer)"><v-icon size="18">mdi-delete</v-icon></v-btn>
          </v-list-item-action>
        </v-list-item>
        <v-divider class="my-0" v-if="index != item.customers.length-1"></v-divider>
      </template>
      <template v-if="item.customers.length > 0">
        <v-divider class="my-0"></v-divider>
        <FieldAccess model="customer_group" field="edit_customers" :field_name="__('buttons.edit_customers')" v-slot="{ accessData }">
          <v-list-item dense class="text-center  pt-2" :class=" accessData.canAdmin  ? 'pr-0' : '' " style="min-height: 52px;">
            <v-list-item-content>
              <v-list-item-title>
                <v-btn :color="is_edit ? 'grey darken-3' : 'grey darken-1' " dark depressed class="rounded-btn" @click.stop="is_edit = !is_edit">
                  <v-icon left v-html="is_edit ? 'mdi-check' : 'mdi-pencil' "></v-icon> 
                  <span v-html="is_edit ? 'Завершить' : 'Изменить список' "></span>
                </v-btn>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-icon class="ml-2 my-auto">
              <FieldAccessButton :accessData="accessData" />
            </v-list-item-icon>
          </v-list-item>
        </FieldAccess>
      </template>
      </template>
      <FieldAccess model="customer_group" field="add_customers" :field_name="__('buttons.add_customers')" v-slot="{ accessData }">
        <v-list-item dense class="text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' "  style="min-height: 52px;">
          <v-list-item-content>
            <v-list-item-title>
              <v-btn color="green lighten-1" dark depressed class="rounded-btn" @click.stop="addCustomers" :loading="loading">
                <v-icon left>mdi-plus</v-icon> <span >Добавить</span>
              </v-btn>
            </v-list-item-title>
          </v-list-item-content>
          <v-list-item-icon class="ml-2 my-auto">
            <FieldAccessButton :accessData="accessData" />
          </v-list-item-icon>
        </v-list-item>
      </FieldAccess>
    </v-list>
    <v-dialog v-model="delete_dialog" max-width="420">
      <v-card>
        <v-card-title>
          Удалить
        </v-card-title>
        <v-card-text>
          Вы действительно хотите удалить клиента из группы?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="cancelDeteleCustomer">Отменить</v-btn>
          <v-btn color="primary" text @click.stop="submitDeleteCustomers" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="420" scrollable>
      <v-card>
        <v-card-title>
          Добавить клиентов в группу
          <v-spacer></v-spacer>
          <span>({{selected_customers.length}})</span>
        </v-card-title>
        <v-divider class="my-0"></v-divider>
        <v-card-text style="height: 560px;" class="px-0">
          <v-list>
            <v-list-item three-line v-for="(customer, i) in customers" :key="i" @click.stop="selectCustomer(customer, i)">
              <v-list-item-avatar>
                <v-img :src="'/storage/avatars/50x50.'+customer.avatar" v-if="customer.avatar != null"></v-img>
                <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title v-html="customer.child_full_name"></v-list-item-title>
                <v-list-item-subtitle>
                  <span class="text--primary" v-html="customer.main_phone"></span> &mdash; <span class="caption" v-html="'Родственник - '+customer.full_name"></span>.
                </v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-icon class="my-auto">
                <v-icon
                  v-html="selected_customers.indexOf(customer) == -1 ? 'mdi-checkbox-blank-outline' : 'mdi-checkbox-marked-outline' "
                  :color="selected_customers.indexOf(customer) == -1 ? 'grey lighten-2' : 'green' "
                ></v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card-text>
        <v-divider class="my-0"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="cancelAddCustomers">Отменить</v-btn>
          <v-btn color="primary" text @click.stop="submitAddCustomers" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  props: {
    item: Object,
  },
  data: () => ({
    dialog: false,
    loading: false,
    selected_customers: [],
    is_edit: false,
    delete_dialog: false,
  }),
  components: { FieldAccess, FieldAccessButton },
  methods: {
    submitDeleteCustomers() {
      this.loading = true
      let params = {
        customers: this.selected_customers,
        group_id: null,
      }
      this.$store.dispatch('SIGN_CUSTOMERS_GROUP', params).then(res => {
        this.selected_customers = []
        this.delete_dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.loading = false))
    },
    cancelDeteleCustomer() {
      this.selected_customers = []
      this.delete_dialog = false
    },
    deleteCustomer(item) {
        this.selected_customers = []
        this.selected_customers.push(item)
        this.delete_dialog = true
    },
    submitAddCustomers() {
      this.loading = true
      let params = {
        customers: this.selected_customers,
        group_id: this.item.id
      }
      this.$store.dispatch('SIGN_CUSTOMERS_GROUP', params).then(res => {
        this.selected_customers = []
        this.dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.loading = false))
    },
    selectCustomer(customer, index) {
      if (this.selected_customers.indexOf(customer) == -1) this.selected_customers.push(customer)
      else this.selected_customers.splice(this.selected_customers.indexOf(customer), 1)
    },
    cancelAddCustomers() {
      this.selected_customers = []
      this.dialog = false
    },
    addCustomers() {
      this.loading = true
      let params = {
        group_id: -1,
        user_id: this.auth_user.id,
        subdivision_id: this.item.subdivision_id,
      }
      this.$store.dispatch('GET_CUSTOMERS', params).then(res => {
        this.dialog = true
      })
      .finally(() => (this.loading = false))
    }
  },
  computed: {
    customers: {
      get() { return this.$store.state.customers.items }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    }
  }
};
</script>
