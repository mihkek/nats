<template>
  <v-card color="transparent" flat>
    <v-card color="transparent" flat class="mb-2" v-if="directory_firm_people.length > 0" v-for="person in directory_firm_people" :key="person.id">
      <ul class="list-group pl-0 ml-0">
        <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>

            <FieldAccess model="directory_firm_person" field="full_name" :field_name="__('directory_firm.person_full_name')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="person.full_name || __('directory_firm.person_full_name')"></h4></v-list-item-content>
                <v-list-item-icon class="ml-2 text-right">
                  <v-tooltip top v-if="accessData.canEdit">
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_full_name'), val: 'full_name', type: 'title' }, person)"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <v-tooltip top v-if="accessData.canEdit">
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="deleteItem(person)"><v-icon>mdi-minus-circle-outline</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.delete_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>  
              <v-divider class="my-0"></v-divider>
            </FieldAccess>

            <FieldAccess model="directory_firm_person" field="position" :field_name="__('directory_firm.person_position')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.person_position')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">{{person.position}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right">
                  <v-tooltip top v-if="accessData.canEdit">
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_position'), val: 'position', type: 'text' }, person)"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
            </FieldAccess>

            <FieldAccess model="directory_firm_person" field="main_phone" :field_name="__('directory_firm.person_phone')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.person_phone')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">{{person.main_phone}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right" >
                  <v-tooltip top v-if="person.main_phone != null">
                    <template v-slot:activator="{ on }">
                      <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'callto:'+person.main_phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
                  </v-tooltip>
                  <v-tooltip top v-if="accessData.canEdit">
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_phone'), val: 'main_phone', type: 'text', rules: [], mask: '+7 (###) ###-##-##'}, person)"><v-icon>mdi-sync</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                  </v-tooltip>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
            </FieldAccess>

            <FieldAccess model="directory_firm_person" field="main_email" :field_name="__('directory_firm.person_email')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.person_email')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">{{person.main_email}}</v-list-item-content>
                <v-list-item-icon class="ml-2 text-right" >
                  <v-tooltip top v-if="person.main_email != null">
                    <template v-slot:activator="{ on }">
                      <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+person.main_email" v-on="on" target="_blank"><v-icon>mdi-email-outline</v-icon></v-btn>
                    </template>
                    <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                  </v-tooltip>
                  <v-tooltip top v-if="accessData.canEdit">
                    <template v-slot:activator="{ on }">
                      <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_email'), val: 'main_email', type: 'text', rules: [] }, person)"><v-icon>mdi-sync</v-icon></v-btn>
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

    <v-card color="transparent" flat v-show="new_flag">
      <ul class="list-group pl-0 ml-0">
        <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
        <v-list class="py-0" dense>
          <v-list-item class="cardform-list-item pr-1 pb-2">
            <v-list-item-content class="inline-block"><h4 class="font-weight-bold my-0" v-html="__('directory_firm.person_new')"></h4></v-list-item-content>
            <v-list-item-action class="ml-2 text-right">
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem({ text: __('directory_firm.person_new'), val: 'full_name', type: 'title' })">
                    <v-icon>mdi-sync</v-icon>
                  </v-btn>
                </template>
                <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
              </v-tooltip>
            </v-list-item-action>
          </v-list-item>
          <v-divider class="my-0"></v-divider>
          <v-list-item class="cardform-list-item pr-1">
            <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.person_position')"></v-list-item-content>
            <v-list-item-content class="body-2 inline-block text-right">{{item.main_position}}</v-list-item-content>
            <v-list-item-icon class="ml-2 text-right" >
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_position'), val: 'position', type: 'text' }, person)"><v-icon>mdi-sync</v-icon></v-btn>
                </template>
                <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
              </v-tooltip>
            </v-list-item-icon>
          </v-list-item>
          <v-divider class="my-0"></v-divider>
          <v-list-item class="cardform-list-item pr-1">
            <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.person_phone')"></v-list-item-content>
            <v-list-item-content class="body-2 inline-block text-right">{{item.main_phone}}</v-list-item-content>
            <v-list-item-icon class="ml-2 text-right" >
              <v-tooltip top v-if="item.main_phone != null">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.main_phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                </template>
                <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
              </v-tooltip>
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_phone'), val: 'main_phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##', href: 'callto:', href_icon: '', href_caption: __('buttons.phone_tooltip') }, person)"><v-icon>mdi-sync</v-icon></v-btn>
                </template>
                <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
              </v-tooltip>
            </v-list-item-icon>
          </v-list-item>
          <v-divider class="my-0"></v-divider>
          <v-list-item class="cardform-list-item pr-1">
            <v-list-item-content class="body-2 inline-block"  v-html="__('directory_firm.person_email')"></v-list-item-content>
            <v-list-item-content class="body-2 inline-block text-right">{{item.main_email}}</v-list-item-content>
            <v-list-item-icon class="ml-2 text-right" >
              <v-tooltip top v-if="item.main_email != null">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.main_email" v-on="on" target="_blank"><v-icon>mdi-email-outline</v-icon></v-btn>
                </template>
                <span class="caption" v-html="__('buttons.email_tooltip')"></span>
              </v-tooltip>
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.person_email'), val: 'main_email', type: 'text', rules: email_rules }, person)"><v-icon>mdi-sync</v-icon></v-btn>
                </template>
                <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
              </v-tooltip>
            </v-list-item-icon>
          </v-list-item>

          
        </v-list>
        <li class="list-group-item py-2" style="border-top: 0px;"></li>
      </ul>
    </v-card>

    <FieldAccess model="directory_firm_person" field="can_add" :field_name="__('buttons.add_person')" v-slot="{ accessData }">
      <v-card color="transparent" flat class="text-center mt-2">
        <v-btn :color="new_flag == true ? 'red' : 'primary' " dark class="rounded-btn mx-1" @click.stop="new_flag = !new_flag">
          <span v-show="!new_flag"><v-icon left>mdi-shuffle-variant</v-icon><span v-html="__('buttons.add_person')"></span></span>
          <span v-show="new_flag"><v-icon left>mdi-cancel</v-icon><span v-html="__('buttons.cancel')"></span></span>
        </v-btn>
        <FieldAccessButton :accessData="accessData" />
      </v-card>
    </FieldAccess>

    <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
    <v-dialog v-model="deldialog" max-width="320px">
      <v-card color="#fafafa" v-if="deldialog">
        <v-card-title primary-title v-html="__('forms.delete')"></v-card-title>
        <v-card-text><span v-html="__('forms.delete_text')"></span> {{item.name}}?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="deldialog = !deldialog" small v-html="__('buttons.cancel')"></v-btn>
          <v-btn color="primary" text @click.stop="submitDelete" small v-html="__('buttons.delete')"></v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>


<script> 
import editdialog from '../../editdialog'
import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'

export default {
  name: 'directory_firm_people_list',
  data () {
    return {
      item: {},
      new_flag: false,
      dialog: false,
      deldialog: false,
      phone_rules: [
        v => !!v || __('forms.required_field'),
        v => v.length == 18 || __('forms.phone_error'),
      ],
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      email_rules: [
        v => !!v || __('forms.required_field'),
        v => /.+@.+/.test(v) || __('forms.email_error'),
      ],
    }
  },
  props: {
    firm: Object,
  },
  components: { FieldAccessButton, FieldAccess, editdialog },
  mounted() {

  },
  methods: {
    editItem(field, person) {
      if (person != undefined) { this.item = Object.assign({}, person) }
      else { this.item = {} }
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      this.item.directory_firm_id = this.$props.firm.id
      this.item._lang = this.locale
      this.$store.dispatch('EDIT_DIRECTORY_FIRM_PERSON', this.item).then(res => { this.$emit('refresh'); this.dialog = false; this.new_flag = false;  })
      .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
    },
    deleteItem(person) {
      this.item = person
      this.deldialog = true
    },
    submitDelete() {
      this.$store.dispatch('DEL_DIRECTORY_FIRM_PERSON', this.item).then(res => { this.$emit('refresh'); this.deldialog = false; })
    },
  },
  watch: {
    dialog: function (val) {
      if (val == false) { this.item = {} }
    },
    deldialog: function (val) {
      if (val == false) { this.item = {} }
    },
    'item.id': function (val) {
      this.new_flag = false
    },
  },
  computed: {
    fields: {
      get() { return this.$store.state.directory_firms.person_profile_card_fields },
    },
    directory_firm_people: {
      get() { return this.$store.state.directory_firms.item.people },
      set(val) { this.$store.state.directory_firms.item.people = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
    lang: {
      get() {
        return this.$store.state.directory_people.lang
      }
    }
  },
};
</script>
