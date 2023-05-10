<template>
  <v-card flat color="#fff" tile>
    <v-container fluid grid-list-xl>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>

                <FieldAccess model="directory_firm" field="rent" :field_name="__('directory_firm.rent')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('directory_firm.rent_title')"></h4></v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>  
                </FieldAccess>

                <FieldAccess model="directory_firm" field="price" :field_name="__('directory_firm.price')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.price')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{formatPrice(item.price)}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right mr-1">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.price'), val: 'price', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
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
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
  </v-card>
</template>

<script>
import FieldAccess from '../../fieldaccess/FieldAccess'
import editdialog from '../../editdialog'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import { mask } from 'vue-the-mask'

export default {
  props: {
    item: Object,
  },
  data () {
    return {
      dialog: false,
    }
  },
  components: { FieldAccess, FieldAccessButton, editdialog },
  mounted() {
  },
  watch: {
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.directory_firm)
      }
    },
  },
  methods: {
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      this.item._lang = this.locale
      this.$store.dispatch('EDIT_DIRECTORY_FIRM', this.item ).then(res => { 
        this.getItem()
      })
    },
    getItem() {
      this.$store.dispatch('GET_DIRECTORY_FIRM', { id: this.item.id, '_lang': this.locale }).then(res => { this.dialog = false;  })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error);  })
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
  },
  computed: {
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
    directory_firm: {
      get() { return this.$store.state.directory_firms.item },
    }
  },
  directives: {  mask },
};
</script>
