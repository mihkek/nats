<template>
<v-app id="vue_block">
  <v-container fluid grid-list-xl class="px-0 py-0">
    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex md6 xs12>
        <v-card color="transparent" flat>
          <ul class="list-group pl-0 ml-0">
            <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>
              <FieldAccess model="directory_person" field="full_name" :field_name="__('directory_person.full_name')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" >
				  <v-tooltip top v-if="item.confirm != null">
					<template v-slot:activator="{on}">
					  <v-btn color="success" v-on="on" icon x-small class="mx-1" _tyle="flex: none; justify-content: flex-end;"><v-icon color="success" size="18">mdi-check</v-icon></v-btn>
					</template>
					<span class="caption">Подтвержден</span>
				  </v-tooltip> 
				  <v-tooltip top v-if="item.id != null && item.confirm == null">
					<template v-slot:activator="{on}">
					  <v-btn color="orange" v-on="on" icon x-small class="mx-1" _tyle="flex: none; justify-content: flex-end;"><v-icon color="orange" size="18">mdi-bell-outline</v-icon></v-btn>
					</template>
				    <span class="caption">Новый</span>
				  </v-tooltip> 
                  <v-list-item-content class="inline-block" >
                    <h4 class="font-weight-bold my-0">Поставщик</h4>
                  </v-list-item-content>
                  <FieldAccessReloginButton :accessData="accessData" v-if="item.id > 0" :id="item.id" />
                </v-list-item>  
              </FieldAccess>
              <FieldAccess model="directory_person" field="profile_photo" :field_name="__('directory_person.photo')" v-slot="{ accessData }">
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
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.photo'), val: 'avatar', type: 'file' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')" ></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                  </template>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="first_name" :field_name="__('directory_person.first_name')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.first_name')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.first_name || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.first_name'), val: 'first_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="last_name" :field_name="__('directory_person.last_name')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.last_name')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.last_name || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.last_name'), val: 'last_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
              
              <FieldAccess model="directory_person" field="main_phone" :field_name="__('directory_person.phone')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.phone')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.phone || ''}}</span>
                  </v-list-item-content>
                  <template v-if="item.phone != null || accessData.canEdit">
                  <v-list-item-icon class="ml-2 text-right" >
                    <v-tooltip top v-if="item.phone != null">
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary" class="my-icon-btn mr-1" icon x-small :href="'callto:'+item.phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.phone_tooltip')" ></span> 
                    </v-tooltip>
                    <v-tooltip top v-if="accessData.canEdit">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.phone'), val: 'phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')" ></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                  </template>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="main_email" :field_name="__('directory_person.email')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.email')" ></span>  <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.email || ''}}</span>
                  </v-list-item-content>
                  <template v-if="item.email != null || accessData.canEdit">
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.email != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.email" v-on="on" target="_blank"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.email_tooltip')" ></span> 
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.email'), val: 'email', type: 'text', rules: email_rules })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')" ></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </template>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="subdivision_id" :field_name="__('directory_person.subdivision')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.subdivision')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span v-if="item.subdivision_id != null">{{subdivisions.find(el => el.id == item.subdivision_id).name || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.subdivision'), val: 'subdivision_id', type: 'select', options: subdivisions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
			    <template v-if="item.role_id == 102 && item.id > 0 && item.confirm != 'on' && item.deleted != 'on'">
                  <FieldAccess model="configer_user" field="confirm" :field_name="item.deleted == 'on' ? __('buttons.archive_configer_user_cancel') : __('buttons.archive_configer_user') " v-slot="{ accessData }">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item py-1" style="min-height: 5px;">
                    </v-list-item>
                    <v-list-item class="cardform-list-item" :class=" accessData.canAdmin  ? 'pr-0' : '' " >
                      <v-list-item-content class="body-2 inline-block">
                        <v-list-item-title>
                          <v-btn :color="'green lighten-1'" dark depressed class="rounded-btn" @click.stop="confirmDialog = !confirmDialog">
                            <v-icon left v-html="'mdi-check'"></v-icon> <span v-html="'Подтвердить'"></span>
                          </v-btn>
                        </v-list-item-title>
                      </v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">
                        <v-list-item-title>
                          <v-btn :color="'red lighten-1'" dark depressed class="rounded-btn" @click.stop="rejectDialog = !rejectDialog">
                            <v-icon left v-html="'mdi-delete'"></v-icon> <span v-html="'Отказать'"></span>
                          </v-btn>
                        </v-list-item-title>
                      </v-list-item-content>
                      <v-list-item-icon class="ml-2 my-auto">
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </v-list-item>
                  </FieldAccess>
<!--
				<div class="px-4 py-3" v-if="item.phone.match(/\((901|902|904|908|910|911|912|913|914|915|916|917|918|919|950|978|980|981|982|983|984|985|986|987|988|989)\)/g)"><b style="color:#c33;">Внимание, отправка сообщений на номера МТС может не работать.</b><br><span style="font-size:90%; color:#666; line-height:120%;">Пользователь указал номер, который возможно относится к МТС, через 10 минут после отправки сообщения с подтверждением или отказом, свяжитесь с пользователем по телефону и уточните, полчил ли он СМС. Если поставщик подтвержден, но СМС не получил, задайте пароль вручную в <a :href="'/admin/configer/users/card/'+item.id" target="_blank">карточке пользователя</a> (кнопка "сменить пароль") и сообщите новый пароль пользоватею любым доступным способом, кроме отправки СМС с сайта.</span></div>
-->
                </template>
            </v-list>
            <li class="list-group-item py-2" style="border-top: 0px;"></li>
          </ul>
        </v-card>
      </v-flex>
      <v-flex md6 xs12>
        <v-card color="transparent" flat class="mb-2">
          <ul class="list-group pl-0 ml-0">
            <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>

              <FieldAccess model="directory_person" field="organization" :field_name="__('directory_person.organization')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" >
                  <v-list-item-content class="inline-block" >
                    <h4 class="font-weight-bold my-0">Организация</h4>
                  </v-list-item-content>
                </v-list-item>  
              </FieldAccess>

              <FieldAccess model="directory_person" field="company_name" :field_name="__('directory_person.company_name')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.company_name')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.company_name || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_name'), val: 'company_name', type: 'title' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>  
              </FieldAccess>

              <FieldAccess model="directory_person" field="company_inn" :field_name="__('directory_person.company_inn')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.company_inn')"> </span> <span class="red--text">*</span>
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.company_inn || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_inn'), val: 'company_inn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="company_ogrn" :field_name="__('directory_person.company_ogrn')" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="body-2 inline-block">
                    <span v-html="__('directory_person.company_ogrn')"> </span> 
                  </v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <span>{{item.company_ogrn || ''}}</span>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_ogrn'), val: 'company_ogrn', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess model="directory_person" field="company_bank_account" :field_name="__('directory_person.company_bank_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_bank_account')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_bank_account || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_bank_account'), val: 'company_bank_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_person" field="company_correspondent_account" :field_name="__('directory_person.company_correspondent_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_correspondent_account')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_correspondent_account || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_correspondent_account'), val: 'company_correspondent_account', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_person" field="company_bank_bik" :field_name="__('directory_person.company_bank_bik')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_bank_bik')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_bank_bik || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_bank_bik'), val: 'company_bank_bik', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_person" field="company_warehouse_address" :field_name="__('directory_person.company_warehouse_address')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_warehouse_address')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_warehouse_address || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_warehouse_address'), val: 'company_warehouse_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_person" field="company_web_site" :field_name="__('directory_person.company_web_site')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_web_site')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_web_site || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_web_site'), val: 'company_web_site', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="directory_person" field="company_description" :field_name="__('directory_person.company_description')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('directory_person.company_description')"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{item.company_description || ''}}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('directory_person.company_description'), val: 'company_description', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
				
				<FieldAccess model="customer" field="company_check_file" :field_name="__('directory_person.company_check_results')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span :class="item.company_check_file ? '' : 'font-weight-bold red--text'" v-html="'Результаты проверки'"> </span> 
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.company_check_file"><a :href="'/storage/proofs/'+item.company_check_file" target="_blank">{{item.company_check_file}}</a></span>
                      <span v-else></span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Результаты проверки', val: 'company_check_file', type: 'pdf' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'" v-html="__('buttons.edit_tooltip')"></span> 
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

            </v-list>
            <li class="list-group-item py-2" style="border-top: 0px;"></li>
          </ul>
        </v-card>
        <template v-if="item.id > 0">
          <DateLogger :item="item" :auth_user="auth_user"/>
        </template>
      </v-flex>
    </v-layout>
    <v-layout v-if="item.id > 0">
      <v-flex xs12>
        <directory_person_tabs :item="item" :auth_user="auth_user"/>
      </v-flex>
      
    </v-layout>
    <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
    <v-dialog v-model="tabledialog" max-width="90%"><tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="item"/></v-dialog>
    <snackbar />
<!-- Chernyshkov 20210812 -->
  <v-dialog v-model="confirmDialog" max-width="420px">
    <v-card color="#f2f2f2">
      <v-card-title primary-title>
        <span>Подтвердить поставщика?</span>
      </v-card-title>
      <v-card-text>
        Подтвердить поставщика и отправить ему пароль для входа?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary darken-1" text @click.stop="confirmItem" v-html="'Подтвердить'"></v-btn>
        <v-btn color="grey" text @click.stop="confirmDialog = !confirmDialog" v-html="__('buttons.cancel')"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <v-dialog v-model="rejectDialog" max-width="420px">
    <v-card color="#f2f2f2">
      <v-card-title primary-title>
        <span>Отказать поставщику?</span>
      </v-card-title>
      <v-card-text>
        Поместить поставщика в архив и отправить ему сообщение с&nbsp;отказом?
      </v-card-text>
          <template>
            <v-textarea
			  rows="1"
			  label="Причина отказа, коротко"
              solo
              flat
              dense
              v-model="rejectReason"
              auto-grow
			  class="mx-5"
            ></v-textarea>
          </template>
      <v-card-text>
        3-5 слов. Заполнять не обязательно, но желательно
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red darken-1" text @click.stop="rejectItem" v-html="'Отказать'"></v-btn>
        <v-btn color="grey" text @click.stop="rejectDialog = !rejectDialog" v-html="__('buttons.cancel')"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  </v-container>
</v-app>
</template>
<script> 
import snackbar from '../../snackbar'
import tabledialog from '../../tabledialog'
import editdialog from '../../editdialog'
import directory_person_tabs from './directory_person_tabs'
import Alert from '../../snippets/Alert'

import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import AdminPanel from '../../snippets/AdminPanel'
import DateLogger from '../../snippets/DateLogger'
import FieldAccessReloginButton from '../../fieldaccess/FieldAccessReloginButton'


export default {
  name: 'directory_person_card',
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
/* Chernyshkov 20210812 */
	  confirmDialog: false,
	  rejectDialog: false,
	  rejectReason: '',
    }
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  components: {
    FieldAccessReloginButton,
    AdminPanel, directory_person_tabs, snackbar, editdialog, tabledialog, FieldAccess, FieldAccessButton, DateLogger, Alert },
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
      this.$store.dispatch('ARCHIVE_DIRECTORY_PERSON', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    restoreItem() {
      this.$store.dispatch('RESTORE_DIRECTORY_PERSON', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
/* Chernyshkov 20210812 */
    confirmItem() {
      this.$store.dispatch('CONFIRM_DIRECTORY_PERSON', this.item).then(res => {
        this.getItem()
        this.confirmDialog = false
      })
    },
    rejectItem() {
      this.$store.dispatch('REJECT_DIRECTORY_PERSON', {id: this.item.id, reason: this.rejectReason}).then(res => {
        this.getItem()
        this.rejectDialog = false
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
        if (this.item.field == undefined || (this.item.field.type != 'file' && this.item.field.type != 'pdf')) {
          if (this.item.user_id > 0) {}
          else {
            this.item.user_id = this.user_id
            this.item.role_id = this.auth_user.role_id
          }
          this.$store.dispatch('EDIT_DIRECTORY_PERSON', this.item ).then(res => { 
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/directory/people/'+res.person.id }
          })
          .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
        }
        else {
          let form = new FormData();
          form.append('file', this.item.file)
          form.append('id', this.item.id)
		  if (this.item.field.type == 'pdf') {
		    this.$store.dispatch('EDIT_DIRECTORY_PERSON_CHECK_FILE', form).then(res => { this.getItem() })
            .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
		  }
		  else {
		    this.$store.dispatch('EDIT_DIRECTORY_PERSON_AVATAR', form).then(res => { this.getItem() })
            .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
		  }
        }
      }
      else {
        this.directory_person = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.first_name == undefined) { flag = false }
        if (this.item.last_name == undefined) { flag = false }
        if (this.item.middle_name == undefined) { flag = false }
        if (this.item.position == undefined) { flag = false }
        if (this.item.phone == undefined) { flag = false }
        if (this.item.email == undefined) { flag = false }
        if (this.item.organization_full_name == undefined) { flag = false }
        if (this.item.organization_inn == undefined) { flag = false }
        if (this.item.subdivision_id == undefined) { flag = false }
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
        this.$store.dispatch('GET_DIRECTORY_PERSON', { id: this.item_id, '_lang': this.locale, user_id: this.user_id }).then(res => { this.loading = false; this.dialog = false; this.tabledialog = false; })
        .catch(error => { this.$store.commit('SET_SNACKBAR', error); this.loading = false })
      }
      else {
        this.loading = false
      }
    },
    getUsers() {
      this.$store.dispatch('GET_DIRECTORY_PERSON_USERS', { user_id: this.user_id, _lang: this.locale })
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
    directory_person: function (val) {
      this.item = Object.assign({}, val)
    }, 
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.directory_person)
      }
    },
    auth_user: function(val) {
      this.getItem()
      if (this.new == true && val.role_id == 102) {
        this.item.main_email = val.email
        this.item.main_phone = val.phone
        this.item.full_name = val.full_name
      }
    },
    'item.specialist_level' : function (val) {
      this.levels.map(option => {
        if (option.id == val) {
          this.item.specialist_level_text = option.title
        }
      })
    }
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    levels_options: {
      get() { return this.$store.state.directory_people.levels_options },
      set(val) { this.$store.state.directory_people.levels_options = val }
    },
    levels: {
      get() {
        let options = this.levels_options
        options.map(option => {
          if (option.title == option.text) {
            option.title = '<span class="no_translate">'+option.text+'</span>'
          }
        })
        return options
      },
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    directory_person: {
      get() { return this.$store.state.directory_people.item },
      set(val) { this.$store.state.directory_people.item = val }
    },
    profile_card_fields: {
      get() { return this.$store.state.directory_people.profile_card_fields },
    },
    snackbar: {
      get() { return this.$store.state.snackbar },
      set(val) { this.$store.state.snackbar = val }
    },
    status_options: {
      get() { return this.$store.state.orderers.status_options }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    directory_person_users: {
      get() { return this.$store.state.configer_users.directory_person_users }
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
