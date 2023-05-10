<template>
<v-app id="vue_block">
	<v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md6>
        <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <FieldAccess model="configer_user" field="card_title" :field_name="__('user.card_title')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('user.card_title')"></h4></v-list-item-content>
                  <v-list-item-icon>
                    <FieldAccessReloginButton :accessData="accessData" :id="item.id" />
                  </v-list-item-icon>
                </v-list-item>  
                </FieldAccess>
                <FieldAccess model="configer_user" field="avatar" :field_name="__('user.photo')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content>
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.avatar"></v-img></v-avatar>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="item.id > 0 && accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.photo'), val: 'avatar', type: 'file' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="role_id" :field_name="__('user.role')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.role')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.role != undefined">{{item.role.name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right"  v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.role'), val: 'role_id', type: 'select', options: roles })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="subdivision_id" :field_name="__('user.subdivision')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('user.subdivision')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.subdivision_id != null">{{subdivisions.find(el => el.id == item.subdivision_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.subdivision'), val: 'subdivision_id', type: 'select', options: subdivisions })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="name_family" :field_name="__('user.last_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.surname')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.last_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.surname'), val: 'last_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="name" :field_name="__('user.name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.first_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.name'), val: 'first_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="middle_name" :field_name="__('user.middle_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.middle_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.middle_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.middle_name'), val: 'middle_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="phone" :field_name="__('user.phone')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.phone}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.phone'), val: 'phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="configer_user" field="email" :field_name="__('user.email')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block"  v-html="__('user.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.email}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.email'), val: 'email', type: 'text', rules: email_rules })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>


                <FieldAccess model="configer_user" field="confirm" :field_name="__('user.confirm')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Подтвержден</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.confirm != null ? 'Да' : 'Нет'}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Подтвержден', val: 'confirm', type: 'select', options: [ { id: 'on', title: 'Да' }, { id: null, title: 'Нет' } ] })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>





                <template v-if="item.id > 0">
                  <FieldAccess model="configer_user" field="archive" :field_name="item.deleted == 'on' ? __('buttons.archive_configer_user_cancel') : __('buttons.archive_configer_user') " v-slot="{ accessData }">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item py-1" style="min-height: 0;">
                    </v-list-item>
                    <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' " >
                      <v-list-item-content>
                        <v-list-item-title>
                          <v-btn :color="item.deleted == 'on' ? 'green lighten-1' : 'red lighten-1' " dark depressed class="rounded-btn" @click.stop="archiveDialog = !archiveDialog">
                            <v-icon left v-html="item.deleted == 'on' ? 'mdi-restore' : 'mdi-archive' "></v-icon> <span v-html="item.deleted == 'on' ? __('buttons.archive_configer_user_cancel') : __('buttons.archive_configer_user') "></span>
                          </v-btn>
                        </v-list-item-title>
                      </v-list-item-content>
                      <v-list-item-icon class="ml-2 my-auto">
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </v-list-item>
                  </FieldAccess>
                </template>
                
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
			</v-flex>
      <v-flex md6 xs12 v-if="item.id > 0">
          <v-card color="transparent" flat >
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('user.change_pass')"></h4></v-list-item-content>
                </v-list-item>  
              <FieldAccess model="configer_user" field="change_pass" :field_name="__('user.change_pass')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item pt-2 px-2">
                      <v-list-item-content class="inline-block text-center" >
                        <v-dialog v-model="pass_dialog" max-width="420">
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary" class="rounded-btn" v-on="on" v-if="accessData.canEdit"> <v-icon left>mdi-pencil</v-icon> <span v-html="__('buttons.change_label')"></span></v-btn>
                      </template>
                      <v-card color="#fafafa">
                        <v-form v-model="valid" ref="changePass">
                          <v-card-title primary-titleb v-html="__('user.change_pass')"></v-card-title>
                          <v-card-text>
                            <v-text-field
                              solo
                              flat
                              required
                              v-model="pass"
                              :rules="rules"
                              :type="show_pass ? 'text' : 'password'"
                              :append-icon="show_pass ? 'mdi-eye-off' : 'mdi-eye'"
                              @click:append="show_pass = !show_pass"
                              @input="checkPassConfirm"
                              autocomplete="off"
                              class="mb-2"
                            ></v-text-field>
                            <v-text-field
                              solo
                              flat
                              required
                              v-model="confirm_pass"
                              :rules="rules"
                              :type="show_confirm_pass ? 'text' : 'password'"
                              :append-icon="show_confirm_pass ? 'mdi-eye-off' : 'mdi-eye'"
                              @click:append="show_confirm_pass = !show_confirm_pass"
                              @input="checkPassConfirm"
                              autocomplete="off"
                              :error-messages="!flag ? '' : __('forms.error_confirm_pass')"
                            ></v-text-field>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" small text @click.stop="pass_dialog = !pass_dialog" v-html="__('buttons.cancel')"></v-btn>
                            <v-btn color="primary" small text @click.stop="submitPass" :loading="loading" v-html="__('buttons.submit')"></v-btn>
                          </v-card-actions>
                        </v-form>
                      </v-card>
                        </v-dialog>
                      </v-list-item-content>
                      <v-list-item-action>
                          <FieldAccessButton :accessData="accessData" />
                      </v-list-item-action>
                    </v-list-item>  
              </FieldAccess>
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
        </v-flex>
		</v-layout>
    <v-divider class="d-flex d-md-none"></v-divider>
    <v-layout v-if="item.id > 0">
      <v-flex xs12>
        <user_tabs :item="item" :auth_user="auth_user"/>
      </v-flex>
    </v-layout>
	</v-container>
  <snackbar />
  <v-dialog v-model="archiveDialog" max-width="420px">
    <v-card>
      <v-card-title primary-title>
        <span v-if="item.deleted != 'on'">Убрать пользователя в архив</span>
        <span v-else>Восстановить пользователя</span>
      </v-card-title>
      <v-card-text v-if="item.deleted != 'on'">
        Вы уверены что хотите убрать пользователя в архив?
      </v-card-text>
      <v-card-text v-else>
        Вы уверены что хотите восстановить пользователя из архива?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" small text @click.stop="archiveDialog = !archiveDialog" v-html="__('buttons.cancel')"></v-btn>
        <v-btn color="primary" small text @click.stop="archiveItem" v-html="__('buttons.submit')" v-if="item.deleted != 'on'"></v-btn>
        <v-btn color="primary" small text @click.stop="restoreItem" v-html="__('buttons.submit')" v-else></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
</v-app>
</template>

<script> 
import snackbar from '../snackbar'
import {TheMask} from 'vue-the-mask'
import editdialog from '../editdialog'
import user_tabs from './user_tabs'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'
import AdminPanel from '../snippets/AdminPanel'

export default {
  name: 'user_card',
  data () {
    return {
      item: {},
      dialog: false,
      genders: [ { id: 'M', title: __('forms.gender_male') }, { id: 'F', title: __('forms.gender_female') } ],
      pass_dialog: false,
      pass: null,
      confirm_pass: null,
      show_pass: false,
      show_confirm_pass: false,
      valid: false,
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      flag: false,
      new_flag: false,
      phone_rules: [
        v => !!v || __('forms.required_field'),
      ],
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      email_rules: [
        v => !!v || __('forms.required_field'),
        v => /.+@.+/.test(v) || __('forms.email_error'),
      ],
      archiveDialog: false,
    }
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  components: {TheMask, snackbar, FieldAccess, FieldAccessButton, editdialog, user_tabs, AdminPanel, FieldAccessReloginButton},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.getRoles()
    this.getCities()
    this.getSubdivisions()
    this.getItem()
  },
  created() {
    var vm = this
    window.onbeforeunload = 
        function (ev) {
            if (vm.new_flag == true) {
              var is_asked = true;
              var e = ev || window.event;
              window.focus(is_asked);
              if (is_asked) {
                  is_asked = false;
                  var showstr = "CUSTOM_MESSAGE";
                  if (e) { //for ie and firefox
                      e.returnValue = showstr;
                  }
                  return showstr; //for safari and chrome
              }
            }
        };
  },
  methods: {
    archiveItem() {
      this.$store.dispatch('DELETE_CONFIGER_USER', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    restoreItem() {
      this.$store.dispatch('RESTORE_CONFIGER_USER', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS')
    },
    getCities() {
      this.$store.dispatch('GET_CITIES')
    },
    checkPassConfirm() {
      if (this.confirm_pass != null) {
        if (this.pass != this.confirm_pass) { this.flag = true }
        else { this.flag = false }
      }
    },
    submitPass() {
      this.loading = true
      this.item.password = this.pass
      this.$store.dispatch('EDIT_USER_PASS', this.item).then(res => { this.getItem() })
    },
  	goTo(val) {
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      if (this.new == true) { this.new_flag = true }
      if (this.checkFields()) {
        this.new_flag = false
        this.loading = true
        this.item.user_id = this.user_id
        if (this.item.field.type != 'file') {
          this.item._lang = this.locale
          this.$store.dispatch('EDIT_CONFIGER_USER', this.item ).then(res => { 
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/configer/users/card/'+res.user.id }
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
        else {
          let form = new FormData();
          form.append('file', this.item.file)
          form.append('id', this.item.id)
          this.$store.dispatch('EDIT_CONFIGER_USER_AVATAR', form).then(res => { this.getItem() })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
      }
      else {
        this.user = this.item
        this.roles.map(role => {
          if (role.id == this.item.role_id) { this.item.role = role }
        })
        this.dialog = false
        this.tabledialog = false
      }
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.role_id == undefined) { flag = false }
        if (this.item.name_family == undefined) { flag = false }
        if (this.item.name == undefined) { flag = false }
        if (this.item.name_patronymic == undefined) { flag = false }
        if (this.item.phone == undefined) { flag = false }
        if (this.item.email == undefined) { flag = false }
        return flag
      }
      else {
        return true
      }
    },
    getItem() {
      if (this.item_id > 0) {
        let params = {
          id: this.item_id,
          _lang: this.locale,
          user_id: this.user_id
        }
        this.$store.dispatch('GET_CONFIGER_USER', params).then(res => { this.loading = false; this.dialog = false; this.pass_dialog = false; })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
      }
      else {
        this.loading = false
      }


      console.log(this.item);
    },
    getRoles() {
      this.$store.dispatch('GET_USER_ROLES', { user_id: this.user_id } ).then(res => {
        this.roles.map(role => { role.title = role.name })
      })
      .catch(error => { this.loading = false })
    },
    formatDate(date) {
        if (!date) { return }
        else {
          const [ year, month, day ] = date.split('-')
          return day+'/'+month+'/'+year
        }
      },
    maskedPhone(val) {
    },
  },
  watch: {
    auth_user: function (val) {
    },
    user: function (val) {
      this.item = Object.assign({}, val)
      this.item.role_id = Number(this.item.role_id)
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.user)
        this.item.role_id = Number(this.item.role_id)
      }
    },
    locale: function (val) {
      this.loading = true
      this.$store.dispatch('GET_CUSTOMER_USERS', { user_id: this.user_id, '_lang': val})
      this.getItem()
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    cities: {
      get() { return this.$store.state.cities }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    user: {
      get() { return this.$store.state.configer_users.item },
      set(val) { this.$store.state.configer_users.item = val }
    },
    roles: {
      get() { return this.$store.state.configer_roles.items },
      set(val) { this.$store.state.configer_roles.items = val }
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
};
</script>

<style>
	
</style>