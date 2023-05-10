<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }" >
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat class="mb-2">
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>

                <FieldAccess model="directory_firm" field="full_name" :field_name="__('directory_firm.full_name')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="item.full_name || __('directory_firm.full_name')"> <span class="red--text">*</span></h4></v-list-item-content>

                    <FieldAccessReloginButton :accessData="accessData" v-if="item.user != undefined" :id="item.user.id" />
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.full_name'), val: 'full_name', type: 'title' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>  
                </FieldAccess>

                <FieldAccess model="directory_firm" field="profile_photo" :field_name="__('directory_firm.photo')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content>
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.profile_photo == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.profile_photo"></v-img></v-avatar>
                    </v-list-item-content>
                    <template v-if="accessData.canEdit">
                      <v-list-item-icon class="ml-2 text-right" v-if="item.id > 0">
                        <v-tooltip top >
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.photo'), val: 'profile_photo', type: 'file' })"><v-icon>mdi-sync</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="type" :field_name="__('directory_firm.type')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_firm.type')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.type != undefined">{{types.find(el => el.id == item.type).title || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.type'), val: 'type', type: 'select', options: types })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="main_city" :field_name="__('directory_firm.city')" v-slot="{ accessData }" v-if="item.type == 2">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_firm.city')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.city_id != null">{{cities.find(el => el.id == item.city_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.city'), val: 'city_id', type: 'select', options: cities })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="subdivision_id" :field_name="__('directory_firm.subdivision')" v-slot="{ accessData }" v-if="item.type != 2">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_firm.subdivision')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.subdivision_id != null">{{subdivisions.find(el => el.id == item.subdivision_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.subdivision'), val: 'subdivision_id', type: 'select', options: subdivisions })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>



                <!-- <FieldAccess model="directory_firm" field="main_city" :field_name="__('directory_firm.city')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.city')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_city}}</v-list-item-content>
                    <template v-if="accessData.canEdit">
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.city'), val: 'main_city', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess> -->

                <FieldAccess model="directory_firm" field="main_metro" :field_name="__('directory_firm.metro')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.metro')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_metro}}</v-list-item-content>
                    <template v-if="accessData.canEdit">
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.metro'), val: 'main_metro', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="main_address" :field_name="__('directory_firm.address')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.address')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_address}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.main_address != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'https://yandex.ru/maps/?ll=37.618174%2C55.754998&mode=search&text='+item.main_address" v-on="on" target="_blank"><v-icon>mdi-web</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.address_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.address'), val: 'main_address', type: 'text'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="main_phone" :field_name="__('directory_firm.phone')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.phone')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_phone}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.main_phone != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'callto:'+item.main_phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.phone'), val: 'main_phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="main_email" :field_name="__('directory_firm.email')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.email')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_email}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.main_email != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.main_email" v-on="on" target="_blank"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Email', val: 'main_email', type: 'text', rules: email_rules })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="main_requisites" :field_name="__('directory_firm.requisites')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.requisites')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.main_requisites}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_firm.requisites'), val: 'main_requisites', type: 'textarea' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_firm" field="user_id" :field_name="__('directory_firm.user')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.user')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.user != null">{{item.user.email}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem(__('directory_firm.user'), 'user', directory_firm_users, user_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <template v-if="$props.new != true">
                <FieldAccess model="directory_firm" field="archive" :field_name="item.deleted == 'on' ? __('buttons.archive_directory_firm_cancel') : __('buttons.archive_directory_firm') " v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item py-1" style="min-height: 0;">
                  </v-list-item>
                  <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' " >
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-btn :color="item.deleted == 'on' ? 'green lighten-1' : 'red lighten-1' " dark depressed class="rounded-btn" @click.stop="archiveDialog = !archiveDialog">
                          <v-icon left v-html="item.deleted == 'on' ? 'mdi-restore' : 'mdi-archive' "></v-icon> <span v-html="item.deleted == 'on' ? __('buttons.archive_directory_firm_cancel') : __('buttons.archive_directory_firm') "></span>
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
          <v-card flat color="transparent" class="mb-4">
            <directory_firm_people_list :firm="item" @refresh="getItem"/>
          </v-card>
          <DateLogger :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
      <v-layout v-if="item.id > 0">
        <v-flex xs12>
          <directory_firm_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="archiveDialog" max-width="420px">
        <v-card>
          <v-card-title primary-title>
            <span v-if="item.deleted != 'on'">Убрать помещение в архив</span>
            <span v-else>Восстановить помещение</span>
          </v-card-title>
          <v-card-text v-if="item.deleted != 'on'">
            Вы уверены что хотите убрать помещение в архив?
          </v-card-text>
          <v-card-text v-else>
            Вы уверены что хотите восстановить помещение из архива?
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
    <v-dialog v-model="tabledialog" max-width="90%"><tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="item"/></v-dialog>
    <snackbar />
  </v-app>
</template>
<script> 
import snackbar from '../../snackbar'
import editdialog from '../../editdialog'
import tabledialog from '../../tabledialog'
import directory_firm_people_list from './directory_firm_people_list'
import directory_firm_tabs from './directory_firm_tabs'
import Alert from '../../snippets/Alert'

import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../../fieldaccess/FieldAccessReloginButton';
import AdminPanel from '../../snippets/AdminPanel'
import DateLogger from '../../snippets/DateLogger'

export default {
  name: 'directory_firm_card',
  data () {
    return {
      item: {},
      dialog: false,
      tabledialog: false,
      user_headers: [
        { id: 1, text: __('user.id'), value: 'id' },
        { id: 2, text: __('user.full_name'), value: 'full_name' },
        { id: 2, text: __('user.email'), value: 'email' },
      ],
      new_flag: false,
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
      archiveDialog: false,
      types: [
        { id: 1, title: 'Для проведения занятий' },
        { id: 2, title: 'Торговый центр ' },
      ]
    }
  },
  components: { AdminPanel, FieldAccessButton, FieldAccessReloginButton, FieldAccess, snackbar, editdialog, directory_firm_people_list, directory_firm_tabs, tabledialog, DateLogger, Alert },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.getUsers()
    this.getCities()
    this.getSubdivisions()
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS')
    },
    getCities() {
      this.$store.dispatch('GET_CITIES')
    },
    archiveItem() {
      this.$store.dispatch('ARCHIVE_DIRECTORY_FIRM', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    restoreItem() {
      this.$store.dispatch('RESTORE_DIRECTORY_FIRM', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    editTableItem(text, val, items, headers) {
      let field = { text: text, val: val, items: items, headers: headers }
      this.item.field = field
      this.tabledialog = true
    },
    submitEdit() {
      if (this.new == true) { this.new_flag = true }
      if (this.checkFields()) {
        this.new_flag = false
        this.loading = true
        this.item._lang = this.locale
        if (this.item.field.type != 'file') {
          if (this.item.user_id > 0) {}
          else {
            this.item.user_id = this.user_id
            this.item.role_id = this.auth_user.role_id
          }
          this.$store.dispatch('EDIT_DIRECTORY_FIRM', this.item ).then(res => { 
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/directory/firms/'+res.firm.id }
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
        else {
          let form = new FormData();
          form.append('file', this.item.file)
          form.append('id', this.item.id)
          this.$store.dispatch('EDIT_DIRECTORY_FIRM_AVATAR', form).then(res => { this.getItem() })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
      }
      else {
        this.directory_firm = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.full_name == undefined) { flag = false }
        if (this.item.type == 2) {
          if (this.item.city_id == undefined) { flag = false }
        }
        else {
          if (this.item.subdivision_id == undefined) { flag = false }
        }
        if (this.item.main_metro == undefined) { flag = false }
        if (this.item.main_phone == undefined) { flag = false }
        if (this.item.main_email == undefined) { flag = false }
        return flag
      }
      else {
        return true
      }
    },
    getItem() {
      if (this.item_id > 0) {
        this.$store.dispatch('GET_DIRECTORY_FIRM', { user_id: this.user_id, id: this.item_id, '_lang': this.locale }).then(res => { this.loading = false; this.dialog = false; this.tabledialog = false; })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
      }
      else {
        this.loading = false
      }

    },
    getUsers() {
    	this.$store.dispatch('GET_DIRECTORY_FIRM_USERS', { user_id: this.user_id, _lang: this.locale })
    },
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
  watch: {
    directory_firm: function (val) {
      this.item = Object.assign({}, val)
      if (this.item.orderers != undefined) {
        this.item.orderers.map(orderer => {
          this.status_options.map(option => {
            if (option.title == option.text) {
              option.title = '<span class="no_translate">'+option.text+'</span>'
            }
            if (option.id == orderer.status) {
              orderer.order_status = option
            }
          })
        })
      }
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.directory_firm)
      }
    },
    auth_user: function(val) {
      this.getItem()
      if (this.new == true && val.role_id == 103) {
        this.item.main_email = val.email
        this.item.main_phone = val.phone
        this.item.full_name = val.full_name
      }
    },
    locale: function (val) {
    	this.loading = true
      	this.getItem()
    	this.getUsers()
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    cities: {
      get() { return this.$store.state.cities }
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    directory_firm: {
      get() { return this.$store.state.directory_firms.item },
      set(val) { this.$store.state.directory_firms.item = val }
    },
    profile_card_fields: {
      get() { return this.$store.state.directory_firms.profile_card_fields },
    },
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    status_options: {
      get() {
        return this.$store.state.orderers.status_options
      }
    },
    directory_firm_users: {
      get() { return this.$store.state.configer_users.directory_firm_users }
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
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
