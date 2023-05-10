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

                <FieldAccess model="customer" field="full_name" :field_name="__('customer.full_name')"
                             v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2">
                    <v-list-item-content class="inline-block">
                      <h4 class="font-weight-bold my-0">Покупатель</h4>
                    </v-list-item-content>
                    <FieldAccessReloginButton :accessData="accessData" v-if="item.id > 0" :id="item.id"/>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="profile_photo" :field_name="__('customer.photo')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content>
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"
                                v-if="item.avatar == null">
                        <v-img src='/storage/avatars/150x150.nophoto.png'></v-img>
                      </v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar"
                                v-else>
                        <v-img :src="'/storage/avatars/150x150.'+item.avatar"></v-img>
                      </v-avatar>
                    </v-list-item-content>
                    <template v-if="item.id > 0">
                      <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                   @click.stop="editItem({ text: __('customer.photo'), val: 'avatar', type: 'file' })">
                              <v-icon>mdi-sync</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData"/>
                      </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="last_name" :field_name="__('customer.last_name')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.last_name')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.last_name || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.last_name'), val: 'last_name', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="first_name" :field_name="__('customer.first_name')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.first_name')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.first_name || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.first_name'), val: 'first_name', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="main_phone" :field_name="__('customer.phone')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.phone')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.phone || '' }}</span>
                    </v-list-item-content>
                    <template v-if="item.phone != null || accessData.canEdit">
                      <v-list-item-icon class="ml-2 text-right">
                        <v-tooltip top v-if="item.phone != null">
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" class="my-icon-btn mr-1" icon x-small :href="'callto:'+item.phone"
                                   v-on="on" target="_blank">
                              <v-icon>mdi-phone-outgoing</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
                        </v-tooltip>
                        <v-tooltip top v-if="accessData.canEdit">
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                   @click.stop="editItem({ text: __('customer.phone'), val: 'phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})">
                              <v-icon>mdi-sync</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData"/>
                      </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="main_email" :field_name="__('customer.email')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.email')"></span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.email || '' }}</span>
                    </v-list-item-content>
                    <template v-if="item.email != null || accessData.canEdit">
                      <v-list-item-icon class="ml-2 text-right">
                        <v-tooltip top v-if="item.email != null">
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.email"
                                   v-on="on" target="_blank">
                              <v-icon>mdi-email-outline</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                        </v-tooltip>
                        <v-tooltip top v-if="accessData.canEdit">
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                   @click.stop="editItem({ text: __('customer.email'), val: 'email', type: 'text', rules: email_rules })">
                              <v-icon>mdi-sync</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData"/>
                      </v-list-item-icon>
                    </template>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="subdivision_id" :field_name="__('customer.subdivision')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.subdivision')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span
                          v-if="item.subdivision_id != null">{{
                          subdivisions.find(el => el.id == item.subdivision_id).name || ''
                        }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.subdivision'), val: 'subdivision_id', type: 'select', options: subdivisions })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
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

                <FieldAccess model="customer" field="organization" :field_name="__('customer.organization')"
                             v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2">
                    <v-list-item-content class="inline-block">
                      <h4 class="font-weight-bold my-0">Организация</h4>
                    </v-list-item-content>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_name" :field_name="__('customer.company_name')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_name')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ customer.company_name || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_name'), val: 'company_name', type: 'title' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_inn" :field_name="__('customer.company_inn')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_inn')"> </span> <span class="red--text">*</span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_inn || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_inn'), val: 'company_inn', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_ogrn" :field_name="__('customer.company_ogrn')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_ogrn')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_ogrn || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_ogrn'), val: 'company_ogrn', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_bank_account"
                             :field_name="__('customer.company_bank_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_bank_account')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_bank_account || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_bank_account'), val: 'company_bank_account', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_correspondent_account"
                             :field_name="__('customer.company_correspondent_account')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_correspondent_account')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_correspondent_account || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_correspondent_account'), val: 'company_correspondent_account', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_bank_bik" :field_name="__('customer.company_bank_bik')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_bank_bik')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_bank_bik || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_bank_bik'), val: 'company_bank_bik', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_web_site" :field_name="__('customer.company_web_site')"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_web_site')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_web_site || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_web_site'), val: 'company_web_site', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_description"
                             :field_name="__('customer.company_description')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span v-html="__('customer.company_description')"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span>{{ item.company_description || '' }}</span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: __('customer.company_description'), val: 'company_description', type: 'text' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="customer" field="company_check_file"
                             :field_name="__('customer.company_check_results')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">
                      <span :class="item.company_check_file ? '' : 'font-weight-bold red--text'"
                            v-html="'Результаты проверки'"> </span>
                    </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <span v-if="item.company_check_file"><a :href="'/storage/proofs/'+item.company_check_file"
                                                              target="_blank">{{ item.company_check_file }}</a></span>
                      <span v-else></span>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                 @click.stop="editItem({ text: 'Результаты проверки', val: 'company_check_file', type: 'pdf' })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"
                              :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                              v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <template>
                  <FieldAccess model="customer" field="ga" :field_name="'Площадь хозяйства в Гектарах'"
                               v-slot="{ accessData }">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                      <v-list-item-content class="body-2 inline-block">
                        <span v-html="'Площадь хозяйства в Гектарах'"> </span> <span class="red--text">*</span>
                      </v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">
                        <span>{{ item.ga || '' }}</span>
                      </v-list-item-content>
                      <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                                   @click.stop="editItem({ text: 'Площадь хозяйства в Гектарах', val: 'ga', type: 'text' })">
                              <v-icon>mdi-sync</v-icon>
                            </v-btn>
                          </template>
                          <span class="caption"
                                :class="__('buttons.edit_tooltip') != 'buttons.edit_tooltip' ? '' : 'yellow red--text font-weight-medium text-uppercase'"
                                v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData"/>
                      </v-list-item-icon>
                    </v-list-item>
                  </FieldAccess>
                </template>


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
          <customer_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="archiveDialog" max-width="420px">
      <v-card>
        <v-card-title primary-title>
          <span v-if="item.deleted != 'on'">Убрать преподавателя в архив</span>
          <span v-else>Восстановить преподавателя</span>
        </v-card-title>
        <v-card-text v-if="item.deleted != 'on'">
          Вы уверены что хотите убрать преподавателя в архив?
        </v-card-text>
        <v-card-text v-else>
          Вы уверены что хотите восстановить преподавателя из архива?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" small text @click.stop="archiveDialog = !archiveDialog"
                 v-html="__('buttons.cancel')"></v-btn>
          <v-btn color="primary" small text @click.stop="archiveItem" v-html="__('buttons.submit')"
                 v-if="item.deleted != 'on'"></v-btn>
          <v-btn color="primary" small text @click.stop="restoreItem" v-html="__('buttons.submit')" v-else></v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="420px">
      <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
    </v-dialog>
    <v-dialog v-model="tabledialog" max-width="90%">
      <tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="item"/>
    </v-dialog>
    <snackbar/>
  </v-app>
</template>
<script>
import {mask} from 'vue-the-mask'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import customer_tabs from './customer_tabs'
import Alert from '../snippets/Alert'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'

export default {
  name: 'customer_card',
  data() {
    return {

      item: {},
      dialog: false,
      tabledialog: false,
      user_headers: [
        {id: 1, text: __('user.id'), value: 'id'},
        {id: 2, text: __('user.full_name'), value: 'full_name'},
        {id: 2, text: __('user.email'), value: 'email'},
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
      group_headers: [
        {value: 'title', text: 'Номер'},
        {value: 'customers_qnt', text: 'Количество учеников'},
        {value: 'first_date', text: 'Начало обучения'},
      ],
      status_options: [
        {id: 1, title: 'В процессе обучения', color: 'green', icon: 'mdi-play-circle-outline'},
        {id: 2, title: 'Приостановил обучение', color: 'amber', icon: 'mdi-pause-circle-outline'},
        {id: 3, title: 'Окончил обучение', color: 'blue', icon: 'mdi-check-circle-outline'},
        {
          id: 4,
          title: 'Расторг договор',
          color: 'red',
          icon: 'mdi-cancel',
          items: [
            {id: 1, title: 'Не понравилось обучение'},
            {id: 2, title: 'Дорого'},
            {id: 3, title: 'Уехали в другой город'},
            {id: 4, title: 'У ребенка хроническая болезнь'},
            {id: 5, title: 'Без объяснения причины'},
          ]
        },
      ],
      contract_loading: false,
      pasport_dialog: false,
      pasport_valid: false,
    }
  },
  components: {
    FieldAccess,
    FieldAccessButton,
    FieldAccessReloginButton,
    snackbar,
    editdialog,
    customer_tabs,
    AdminPanel,
    DateLogger,
    Alert,
  },
  props: {
    user_id: Number,
    new: Boolean,
    user: Object,
  },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', {id: this.user_id})
    this.getSubdivisions()
  },
  directives: {mask},
  methods: {
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS')
    },
    downloadContract() {
      this.contract_loading = true
      let params = {}
      params.id = this.item.id
      axios.post('/admin/customers/get_contract_pdf', params, {responseType: 'arraybuffer'}).then(res => {
        let blob = new Blob([res.data], {type: 'application/pdf'})
        let link = document.createElement('a')
        link.target = '_blank'
        link.href = window.URL.createObjectURL(blob)
        link.open = 'Договор.pdf'
        link.click()
      })
          .finally(() => (this.contract_loading = false))
    },
    editTableItem(text, val, items, headers) {
      let field = {text: text, val: val, items: items, headers: headers}
      this.item.field = field
      this.tabledialog = true
    },
    archiveItem() {
      this.$store.dispatch('ARCHIVE_CUSTOMER', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    restoreItem() {
      this.$store.dispatch('RESTORE_CUSTOMER', this.item).then(res => {
        this.getItem()
        this.archiveDialog = false
      })
    },
    submitEdit() {
      if (this.new == true) {
        this.new_flag = true
      }
      if (this.checkFields()) {
        this.new_flag = false
        this.loading = true
        this.item._lang = this.locale
        this.item.user_id = this.user_id
        if (this.item.field == undefined || (this.item.field.type != 'file' && this.item.field.type != 'pdf')) {
          if (this.item.user_id > 0) {
          } else {
            this.item.user_id = this.user_id
            this.item.role_id = this.auth_user.role_id
          }
          this.$store.dispatch('EDIT_CUSTOMER', this.item).then(res => {
            if (this.item_id > 0) {
              this.getItem()
            } else {
              location.href = '/admin/customer/list/card/' + res.customer.id
            }
          })
              .catch(error => {
                this.$store.commit('SET_SNACKBAR', error)
              })
        } else {
          let form = new FormData();
          form.append('file', this.item.file)
          form.append('id', this.item.id)
          if (this.item.field.type == 'pdf') {
            this.$store.dispatch('EDIT_CUSTOMER_CHECK_FILE', form).then(res => {
              this.getItem()
            })
                .catch(error => {
                  this.$store.commit('SET_SNACKBAR', error)
                })
          } else {
            this.$store.dispatch('EDIT_CUSTOMER_AVATAR', form).then(res => {
              this.getItem()
            })
                .catch(error => {
                  this.$store.commit('SET_SNACKBAR', error)
                })
          }
        }
      } else {
        this.customer = this.item
        this.dialog = false
        this.tabledialog = false
        this.pasport_dialog = false
      }
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.first_name == undefined) {
          flag = false
        }
        if (this.item.last_name == undefined) {
          flag = false
        }
        if (this.item.middle_name == undefined) {
          flag = false
        }
        if (this.item.position == undefined) {
          flag = false
        }
        if (this.item.phone == undefined) {
          flag = false
        }
        if (this.item.email == undefined) {
          flag = false
        }
        if (this.item.organization_full_name == undefined) {
          flag = false
        }
        if (this.item.organization_inn == undefined) {
          flag = false
        }
        if (this.item.subdivision_id == undefined) {
          flag = false
        }
        return flag
      } else {
        return true
      }
    },
    getItem() {
      if (this.item_id > 0) {
        let params = {
          id: this.item_id,
          _lang: this.locale,
          user_id: this.user_id,
        }
        this.$store.dispatch('GET_CUSTOMER', params).then(res => {
          this.loading = false;
          this.dialog = false;
          this.tabledialog = false;
          this.pasport_dialog = false;
        })
            .catch(error => {
              this.$store.commit('SET_SNACKBAR', error);
              this.loading = false
            })
            .finally(() => (this.loading = false))
      } else {
        this.loading = false
      }
      this.$store.dispatch('GET_CUSTOMER_USERS', {user_id: this.user_id, _lang: this.locale})
    },
    editItem(field, person) {
      this.item.field = field
      this.dialog = true
    },
    getGroups() {
      let params = {
        user_id: this.user_id,
        subdivision_id: this.item.subdivision_id,
        _lang: this.locale,
      }
//      console.log(params)
      this.$store.dispatch('GET_CUSTOMERS_GROUPS', params).then(res => {
        this.loading = false;
      })
          .catch(error => {
            this.loading = false
          })
    },
    formatDate(date) {
      if (!date) {
        return
      } else {
        const [year, month, day] = date.split('-')
        return day + '/' + month + '/' + year
      }
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
    locale: function (val) {
      this.loading = true
      this.$store.dispatch('GET_CUSTOMER_USERS', {user_id: this.user_id, '_lang': val})
      this.getItem()
    },
    customer: function (val) {
      this.item = Object.assign({}, val)
    },
    dialog: function (val) {
      if (val == false) {
        this.item = Object.assign({}, this.customer)
      }
    },
    auth_user: function (val) {
      this.getItem()
    },
  },
  computed: {
    subdivisions: {
      get() {
        return this.$store.state.configer_subdivisions.items
      }
    },
    item_id: {
      get() {
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length - 1]
        if (item_id > 0) {
          return item_id
        } else if (item_id[item_id.length - 1] == '#') {
          return item_id.slice(0, -1)
        }
      }
    },
    customer: {
      get() {
        return this.$store.state.customers.item
      },
      set(val) {
        this.$store.state.customers.item = val
      }
    },
    profile_card_fields: {
      get() {
        return this.$store.state.customers.profile_card_fields
      },
    },
    snackbar: {
      get() {
        return this.$store.state.snackbar
      },
      set(val) {
        this.$store.state.snackbar = val
      }
    },
    auth_user: {
      get() {
        return this.$store.state.auth_user
      },
    },
    status_options: {
      get() {
        return this.$store.state.orderers.status_options
      }
    },
    customer_users: {
      get() {
        return this.$store.state.configer_users.customer_users
      }
    },
    loading: {
      get() {
        return this.$store.state.loading
      },
      set(val) {
        this.$store.state.loading = val
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
