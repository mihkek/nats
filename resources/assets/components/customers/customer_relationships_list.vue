<template>
  <v-card color="transparent" flat>
    <v-card color="transparent" flat class="mb-2">
      <ul class="list-group pl-0 ml-0">
        <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            
            <v-list-item class="cardform-list-item pr-1 pb-2" style="min-height: 52px;">
              <v-list-item-content class="inline-block"><h4 class="font-weight-bold my-0" v-html="__('customer.characteristics')"></h4></v-list-item-content>
            </v-list-item>
            <v-divider class="my-0"></v-divider>

            <FieldAccess model="customer" field="type_id" :field_name="__('customer.type')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.type')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right" v-if="item.type != null">{{item.type.title}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                  <v-tooltip top >
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.type'), val: 'type_id', type: 'select', options: customer_types })"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>
            
            <FieldAccess model="customer" field="directory_person" :field_name="__('customer.directory_person')" v-slot="{ accessData }">
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.directory_person')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right" v-if="item.directory_person_id != null">{{item.directory_person.full_name}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                  <v-tooltip top >
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem(__('customer.directory_person'), 'directory_person', directory_people, directory_person_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>

            <FieldAccess model="customer" field="directory_firm" :field_name="__('customer.directory_firm')" v-slot="{ accessData }">
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.directory_firm')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right" v-if="item.directory_firm_id != null">{{item.directory_firm.full_name}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                  <v-tooltip top >
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem(__('customer.directory_firm'), 'directory_firm', directory_firms, directory_firm_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>

          </v-list>
        <li class="list-group-item py-2" style="border-top: 0px;"></li>
      </ul>
    </v-card>
    <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
    <v-dialog v-model="tabledialog" max-width="90%"><tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="item"/></v-dialog>
  </v-card>
</template>


<script> 
import tabledialog from '../tabledialog'
import editdialog from '../editdialog'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'customer_relationships_list',
  data () {
    return {
      item: {},
      new_flag: false,
      dialog: false,
      tabledialog: false,
    }
  },
  props: {
    user_id: Number,
  },
  components: { FieldAccess, FieldAccessButton, tabledialog, editdialog },
  mounted() {
    this.item = Object.assign({}, this.customer)
    this.item.type_id = Number(this.item.type_id)
    this.getItems()
  },
  methods: {
    editTableItem(text, val, items, headers) {
      let field = { text: text, val: val, items: items, headers: headers }
      this.item.field = field
      this.tabledialog = true
    },
    editItem(field) {
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      this.item._lang = this.locale
      this.$store.dispatch('EDIT_CUSTOMER', this.item ).then(res => { this.$emit('refresh'); this.dialog = false; this.tabledialog = false })
      .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
    },
    getItems() {
      this.$store.dispatch('GET_CUSTOMER_TYPES', { user_id: this.user_id, _lang: this.locale }).then(res => { console.log(this.customer_types) })
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_FIRMS', { user_id: this.user_id, _lang: this.locale })
    }
  },
  watch: {
    customer: function (val) {
      this.item = Object.assign({}, val)
    },
    locale: function (val) {
      this.getItems()
    }
  },
  computed: {
    customer: {
      get() { return this.$store.state.customers.item },
      set(val) { this.$store.state.customers.item = val }
    },
    customer_types: {
      get() { return this.$store.state.customers.types },
    },
    directory_person_headers: {
      get() { return this.$store.state.directory_people.table_headers },
      set(val) { this.$store.state.directory_people.table_headers = val }
    },
    directory_people: {
      get() { return this.$store.state.directory_people.items },
      set(val) { this.$store.state.directory_people.items = val }
    },
    directory_firm_headers: {
      get() { return this.$store.state.directory_firms.table_headers },
      set(val) { this.$store.state.directory_firms.table_headers = val }
    },
    directory_firms: {
      get() { return this.$store.state.directory_firms.items },
      set(val) { this.$store.state.directory_firms.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },  
    locale: {
      get() { return this.$store.state.lang.lang },
    }
  },
};
</script>
