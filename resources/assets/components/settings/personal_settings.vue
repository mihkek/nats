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
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('user.personal_settings')"></h4></v-list-item-content>
                </v-list-item>  
                
                <FieldAccess model="personal_settings" field="avatar" :field_name="__('user.photo')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content>
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.avatar"></v-img></v-avatar>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.photo'), val: 'avatar', type: 'file' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="personal_settings" field="name" :field_name="__('user.first_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.first_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.name'), val: 'first_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="personal_settings" field="name_family" field_name="Фамилия" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.surname')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.last_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.surname'), val: 'last_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="personal_settings" field="middle_name" field_name="Отчество" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Отчество</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.middle_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Отчество', val: 'middle_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>


                <FieldAccess model="personal_settings" field="phone" :field_name="__('user.phone')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.phone}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.phone'), val: 'phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="personal_settings" field="email" :field_name="__('user.email')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.email')"></v-list-item-content>
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

                <FieldAccess model="personal_settings" field="lang" :field_name="__('user.lang')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.lang')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.lang}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.lang'), val: 'lang', type: 'select', options: langs })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>



              <FieldAccess model="personal_settings" field="ga" :field_name="'Площадь хозяйства в Гектарах'" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Площадь хозяйства в Гектарах</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">                              
                    {{item.ga }}
                  </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Площадь хозяйства в Гектарах', val: 'ga', type: 'text',  })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>


              <FieldAccess model="personal_settings" field="notification_off" :field_name="'Уведомления'" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Уведомления</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">                              
                    {{item.notification_off === 'on' ? 'Финальные уведомления' : 'Все уведомления'}}
                  </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Уведомления', val: 'notification_off', type: 'select', options: [ { id: 'on', title: 'Финальные уведомления' }, { id: null, title: 'Все уведомления' } ]  })"><v-icon>mdi-sync</v-icon></v-btn>
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


          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('user.change_pass')"></h4></v-list-item-content>
                </v-list-item>  
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item pt-2">
                  <v-list-item-content class="inline-block text-center" >
                    <v-dialog v-model="pass_dialog" max-width="420">
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary" class="rounded-btn" v-on="on" > <v-icon left>mdi-pencil</v-icon> <span v-html="__('buttons.change_label')"></span></v-btn>
                      </template>
                      <v-card color="#fafafa">
                        <v-form v-model="valid" ref="changePass">
                          <v-card-title primary-title v-html="__('user.change_pass')"></v-card-title>
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
                            >
                            	
                            </v-text-field>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" small text @click.stop="pass_dialog = !pass_dialog" v-html="__('buttons.cancel')"></v-btn>
                            <v-btn color="primary" small text @click.stop="changePassword" v-html="__('buttons.submit')"></v-btn>                   
                          </v-card-actions>
                        </v-form>
                      </v-card>
                    </v-dialog>
                  </v-list-item-content>
                </v-list-item>  
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>




        <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0">
            <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0">Удаление аккаунта</h4>
                  </v-list-item-content>
                </v-list-item>  
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item pt-2">
                  <v-list-item-content class="inline-block text-center" >
                    <v-dialog v-model="delete_dialog" max-width="420">
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary" class="rounded-btn" v-on="on" > <v-icon left>mdi-pencil</v-icon> <span>удалить аккаунт</span></v-btn>
                      </template>
                      <v-card color="#fafafa">
                        <v-form v-model="valid" ref="changePass">
                          <v-card-title primary-title></v-card-title>
                          <v-card-text>
                          Вы действительно хотите удалить аккаунт?
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>                          
                            <v-btn color="primary" small text @click.stop="deleteAccount"> удалить аккаунт</v-btn>                   
                          </v-card-actions>
                        </v-form>
                      </v-card>
                    </v-dialog>
                  </v-list-item-content>
                </v-list-item>  
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>             
            </ul>
            </v-card>


        </v-flex>
        <v-flex md6 xs12>
          <v-card color="transparent" flat class="mb-3">
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0">Компания</h4></v-list-item-content>
                </v-list-item>  
                <FieldAccess model="personal_settings" field="organization_full_name" :field_name="__('user.organization_full_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.organization_full_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.organization_full_name'), val: 'company_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="organization_inn" :field_name="__('user.organization_inn')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.organization_inn')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_inn}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.organization_inn'), val: 'company_inn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_ogrn" :field_name="__('user.company_ogrn')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_ogrn')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_ogrn}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_ogrn'), val: 'company_ogrn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_bank_account" :field_name="__('user.company_bank_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_bank_account')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_bank_account}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_bank_account'), val: 'company_bank_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_correspondent_account" :field_name="__('user.company_correspondent_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_correspondent_account')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_correspondent_account}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_correspondent_account'), val: 'company_correspondent_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_bank_bik" :field_name="__('user.company_bank_bik')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_bank_bik')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_bank_bik}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_bank_bik'), val: 'company_bank_bik', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_warehouse_address" :field_name="__('user.company_warehouse_address')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_warehouse_address')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_warehouse_address}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_warehouse_address'), val: 'company_warehouse_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_web_site" :field_name="__('user.company_web_site')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_web_site')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_web_site}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_web_site'), val: 'company_web_site', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="personal_settings" field="company_description" :field_name="__('user.company_description')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.company_description')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.company_description}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('user.company_description'), val: 'company_description', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
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

          
          <template v-if="item.id > 0"><DateLogger :item="item" :auth_user="auth_user"/></template>
        </v-flex>
      </v-layout>
      <template v-if="item.id > 0">
      <v-divider class="d-flex d-md-none"></v-divider>
      <v-layout v-if="auth_user.role_id == 1000">
        <v-flex xs12>
          <personal_settings_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
      </template>
    </v-container>
    <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
    <snackbar />
  </v-app>
</template>
<script> 

import lang_menu from '../lang_menu'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import personal_settings_tabs from './personal_settings_tabs'
import Alert from '../snippets/Alert'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'

export default {
  name: 'personal_settings',
  data () {
    return {
      item: {},
      dialog: false,
      genders: [ { id: 'M', title: __('forms.gender_male') }, { id: 'F', title: __('forms.gender_female') } ],
      pass_dialog: false,
      delete_dialog: false,
      pass: null,
      confirm_pass: null,
      show_pass: false,
      show_confirm_pass: false,
      valid: false,
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      flag: false,
      lang: null,
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
  components: { snackbar, editdialog, personal_settings_tabs, FieldAccess, FieldAccessButton, lang_menu, AdminPanel, DateLogger, Alert },
  props: {
    user_id: Number,
  },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.$store.dispatch('GET_LANG_ITEMS').then(res => { this.loading = false })
    this.getItem()
    this.lang = this.locale

    console.log('item',this.item)

    console.log('item notification_off',this.item.notification_off)
  },
  methods: {
    checkPassConfirm() {
      if (this.confirm_pass != null) {
        if (this.pass != this.confirm_pass) { this.flag = true }
        else { this.flag = false }
      }
    },
    changePassword() {
      if (this.valid == true) {
        this.$store.dispatch('CHANGE_PERSONAL_SETTINGS_USER_PASSWORD', { password: this.pass, id: this.user_id } ).then(res => {
          this.$refs.changePass.reset()
          this.confirm_pass = null
          this.flag = false
          this.pass_dialog = false
        })
      }
    },
    //181122
    deleteAccount() {
      this.$store.dispatch('DELETE_USER_ACCOUNT', { id: this.user_id }).then(res => {
      //alert(res.text);
      location.href = '/';
      
      })
    },
    submitEdit() {
      this.loading = true
      if (this.item.field.type != 'file') {
        this.item._lang = this.locale
        this.$store.dispatch('EDIT_PERSONAL_SETTINGS', this.item ).then(res => { this.getItem() })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
      }
      else {
        let form = new FormData();
        form.append('file', this.item.file)
        form.append('id', this.item.id)
        this.$store.dispatch('EDIT_PERSONAL_SETTINGS_USER_AVATAR', form).then(res => { this.getItem() })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
      }
      this.loading = true

      this.$store.dispatch('EDIT_PERSONAL_SETTINGS', this.item).then(res => {
        this.getItem();
      })
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    getItem() {
      this.$store.dispatch('GET_PERSONAL_SETTINGS', { id: this.user_id, _lang: this.locale }).then(res => { this.loading = false; this.dialog = false; })
      .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
    },
  },
  watch: {
    'personal_settings_user.lang': function (val) {
      if (val != this.lang) { location.reload() }
      console.log(this.lang)
      console.log(val)
      this.locale = val
    },
    personal_settings_user: function (val) {
      this.item = Object.assign({}, val)
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.personal_settings_user)
      }
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
    }
  },
  computed: {
    personal_settings_user: {
      get() { return this.$store.state.personal_settings.item },
      set(val) { this.$store.state.personal_settings.item = val }
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
    langs: {
      get() { return this.$store.state.lang.items }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
      set(lang) {
        this.$store.dispatch('SET_LANG', { lang });
      }
    },
  },
};
</script>
