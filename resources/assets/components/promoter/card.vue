<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
       <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>

                <FieldAccess model="promoter" field="full_name" :field_name="__('promoter.full_name')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0">
                      <span v-html="item.full_name || __('promoter.full_name')"></span> <span class="red--text">*</span></h4>
                    </v-list-item-content>
                    <FieldAccessReloginButton :accessData="accessData" v-if="item.user != undefined" :id="item.user.id" />
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.full_name'), val: 'full_name', type: 'title' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>  
                </FieldAccess>

                <FieldAccess model="promoter" field="avatar" :field_name="__('promoter.avatar')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content>
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.avatar"></v-img></v-avatar>
                    </v-list-item-content>
                    <template v-if="item.id > 0">
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.avatar'), val: 'avatar', type: 'file' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')" ></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="subdivision_id" :field_name="__('promoter.subdivision')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.subdivision')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.subdivision_id != null">{{subdivisions.find(el => el.id == item.subdivision_id).name || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.subdivision'), val: 'subdivision_id', type: 'select', options: subdivisions })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="code_opc" :field_name="__('promoter.code_opc')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.code_opc')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.code_opc || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.code_opc'), val: 'code_opc', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="birthday" :field_name="__('promoter.birthday')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.birthday')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{formatDate(item.birthday) || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.birthday'), val: 'birthday', type: 'date' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="main_phone" :field_name="__('promoter.phone')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.phone')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.main_phone || ''}}</span>
                    </v-list-item-content>
                    <template v-if="item.main_phone != null || accessData.canEdit">
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.main_phone != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'callto:'+item.main_phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.phone_tooltip')" ></span> 
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.phone'), val: 'main_phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')" ></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="scripts_rate" :field_name="__('promoter.scripts_rate')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.scripts_rate')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.scripts_rate != null">{{item.scripts_rate || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.scripts_rate'), val: 'scripts_rate', type: 'select', options: scripts_rates })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>


                <FieldAccess model="promoter" field="hired_date" :field_name="__('promoter.hired_date')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.hired_date')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{formatDate(item.hired_date) || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.hired_date'), val: 'hired_date', type: 'date' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="fired_date" :field_name="__('promoter.fired_date')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.fired_date')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{formatDate(item.fired_date) || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.fired_date'), val: 'fired_date', type: 'date' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="vk_link" :field_name="__('promoter.vk_link')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.vk_link')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <a :href="item.vk_link" target="_blank" v-html="item.vk_link"></a>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.vk_link'), val: 'vk_link', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="promoter" field="comment" :field_name="__('promoter.comment')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('promoter.comment')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.comment}}
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('promoter.comment'), val: 'comment', type: 'textarea' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                

                <template v-if="$props.new != true">
                	<FieldAccess model="promoter" field="user_id" :field_name="__('promoter.user')" v-slot="{ accessData }">
                		<v-divider class="my-0"></v-divider>
                		<v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                		  <v-list-item-content class="body-2 inline-block">
                		    <span v-html="__('promoter.user')"></span> 
                		  </v-list-item-content>
                		  <v-list-item-content class="text-right d-block" v-if="item.user != undefined">{{item.user.full_name || ''}}</v-list-item-content>
                		  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                		    <v-tooltip top >
                		      <template v-slot:activator="{ on }">
                		        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem(__('promoter.user'), 'user', promoter_users, user_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                		      </template>
                		      <span class="caption"  v-html="__('buttons.edit_tooltip')" ></span> 
                		    </v-tooltip>
                		    <FieldAccessButton :accessData="accessData" />
                		  </v-list-item-icon>
                  		</v-list-item>
                	</FieldAccess>
                	<template v-if="item.fired_date != null">
                 		<FieldAccess model="promoter" field="archive" :field_name="item.deleted == 'on' ? __('buttons.archive_promoter_cancel') : __('buttons.archive_promoter') " v-slot="{ accessData }">
                    		<v-divider class="my-0"></v-divider>
                    		<v-list-item class="cardform-list-item py-1" style="min-height: 0;">
                    		</v-list-item>
                			<v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' " >
                			  <v-list-item-content>
                			    <v-list-item-title>
                			      <v-btn :color="item.deleted == 'on' ? 'green lighten-1' : 'red lighten-1' " dark depressed class="rounded-btn" @click.stop="archiveDialog = !archiveDialog">
                			        <v-icon left v-html="item.deleted == 'on' ? 'mdi-restore' : 'mdi-archive' "></v-icon> <span v-html="item.deleted == 'on' ? __('buttons.archive_promoter_cancel') : __('buttons.archive_promoter') "></span>
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
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
        </v-flex>
        <v-flex md6 xs12 v-if="item.id > 0">
          <DateLogger :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
      <v-layout v-if="item.id > 0">
        <v-flex xs12>
          <directory_person_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="archiveDialog" max-width="420px">
        <v-card>
          <v-card-title primary-title>
            <span v-if="item.deleted != 'on'">Убрать промоутера в архив</span>
            <span v-else>Восстановить промоутера</span>
          </v-card-title>
          <v-card-text v-if="item.deleted != 'on'">
            Вы уверены что хотите убрать промоутера в архив?
          </v-card-text>
          <v-card-text v-else>
            Вы уверены что хотите восстановить промоутера из архива?
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
import snackbar from '../snackbar'
import tabledialog from '../tabledialog'
import editdialog from '../editdialog'
import Alert from '../snippets/Alert'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'


export default {
  name: 'promoter_card',
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
      scripts_rates: [ 
      	{ id: 0, title: '0' },
      	{ id: 1, title: '1' },
      	{ id: 2, title: '2' },
      	{ id: 3, title: '3' },
      	{ id: 4, title: '4' },
      	{ id: 5, title: '5' },
      	{ id: 6, title: '6' },
      	{ id: 7, title: '7' },
      	{ id: 8, title: '8' },
      	{ id: 9, title: '9' },
      	{ id: 10, title: '10' },
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
    }
  },
  props: {
    item_id: Number,
    user_id: Number,
    new: Boolean,
  },
  components: {
    FieldAccessReloginButton,
    AdminPanel,
    snackbar, 
    editdialog, 
    tabledialog, 
    FieldAccess, 
    FieldAccessButton, 
    DateLogger, 
    Alert 
  },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
    this.getUsers()
    this.getSubdivisions()
  },
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS')
    },
    archiveItem() {
      this.$store.dispatch('DELETE_PROMOTER', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    restoreItem() {
      this.$store.dispatch('RESTORE_PROMOTER', this.item).then(res => {
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
      if (this.checkFields(this.item)) {
        this.new_flag = false
        this.loading = true
        this.item._lang = this.locale
        if (this.item.field.type != 'file') {
          this.$store.dispatch('EDIT_PROMOTER', this.item ).then(res => { 
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/promoters/list/'+res.promoter.id }
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
          .finally(() => (this.loading = false))
        }
        else {
          let form = new FormData();
          form.append('file', this.item.file)
          form.append('id', this.item.id)
          this.$store.dispatch('EDIT_PROMOTER_IMG', form).then(res => { 
            this.getItem()
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
          .finally(() => (this.loading = false))
        }
      }
      else {
        this.promoter = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.code_opc == undefined) { flag = false }
        if (this.item.subdivision_id == undefined) { flag = false }
        if (this.item.full_name == undefined) { flag = false }
        if (this.item.main_phone == undefined) { flag = false }
        if (this.item.birthday == undefined) { flag = false }
        if (this.item.hired_date == undefined) { flag = false }
        return flag
      }
      else {
        return true
      }
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    getItem() {
      if (this.item_id > 0) {
        let params = {
          id: this.item_id,
          _lang: this.locale,
          user_id: this.user_id,
        }
        this.$store.dispatch('GET_PROMOTER', params).then(res => { 
          this.loading = false
          this.dialog = false
          this.tabledialog = false
        })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
        .finally(() => (this.loading = false))
      }
      else {
        this.loading = false
      }
    },
    getUsers() {
      this.$store.dispatch('GET_PROMOTER_USERS', { user_id: this.user_id, _lang: this.locale })
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
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
    lang: function (val) {
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
      this.getUsers()
    },
    promoter: function (val) {
      this.item = Object.assign({}, val)
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.promoter)
      }
    },
    auth_user: function(val) {
      this.getItem()
    },
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    promoter: {
      get() { return this.$store.state.promoters.item },
      set(val) { this.$store.state.promoters.item = val }
    },
    promoter_users: {
      get() { return this.$store.state.promoters.users }
    },
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
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
