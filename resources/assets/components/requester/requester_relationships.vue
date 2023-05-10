<template>
    <v-card color="transparent" flat>

      <v-card flat outlined class="mb-2" v-if="item.is_deal == 1 && item.status != 7">
        <v-alert text :color="item.status == 6 ? 'success' : 'info' " class="mb-0">
          <div><span v-html="item.status == 6 ? 'Клиент записался на ' : 'Следующий звонок назначен на ' "></span></div>
          <h3 class="headline my-0">
            {{formatDate(item.deal_date)}} в {{item.deal_time}}
          </h3>
          <template v-if="item.status == 6">
            <v-divider
              class="my-4 success"
              style="opacity: 0.22"
            ></v-divider>
            <v-row
              align="center"
              no-gutters
            >
              <v-col class="grow">
              </v-col>
              <v-spacer></v-spacer>
              <v-col class="shrink">
                <v-chip outlined color="success" v-if="item.status == 6 && item.confirmed == 1"><v-icon size="18" left>mdi-check</v-icon>Запись подтверждена</v-chip>
                <v-btn
                  v-if="item.status == 6 && item.confirmed == 0"
                  color="success"
                  depressed
                  @click.stop="confirm_dialog = !confirm_dialog"
                >
                  Подтвердить
                </v-btn>
              </v-col>
            </v-row>
          </template>
        </v-alert>
      </v-card>

      <v-card flat outlined class="mb-2" v-if="item.status == 7">
        <v-alert
          type="success"
          elevation="0"
          v-if="item.status == 7"
          class="mb-0"
        >
          <span>Клиент заключил сделку</span>
        </v-alert>
      </v-card>
      <!-- <v-card class="mb-2" flat v-if="item.is_deal == 1 && item.status != 7">
        <v-alert
          :type="item.status == 6 ? 'success' : 'info' "
          elevation="0"
          text
        >
          <v-row align="center">
            <v-col class="grow">
              <p class="my-0">
              
              
              
              </p>
            </v-col>
            <v-col class="shrink">
              <v-btn>Take action</v-btn>
            </v-col>
          </v-row>
        </v-alert>
      </v-card> -->

      <!-- <v-card class="mb-2" flat v-if="item.is_deal == 1 && item.status != 7">
        <v-alert
          type="success"
          elevation="0"
          v-if="item.status == 7"
          text
        >
          <span>Клиент заключил сделку</span>
        </v-alert>
      </v-card> -->
      

      <v-card color="transparent" flat class="mb-2" v-if="item.manager_id > 0 || item.status >= 6">
        <ul class="list-group pl-0 ml-0 mb-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            <FieldAccess model="requester" field="manager_change" :field_name="__('requester.manager')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('requester.manager')"></h4></v-list-item-content>
                <v-list-item-icon v-if="accessData.canEdit">
                  <template v-if="item.manager">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem(__('requester.manager'), 'manager', managers, company_user_headers)">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="deleteUser">
                          <v-icon>mdi-minus-circle-outline</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption"  v-html="__('buttons.delete_tooltip')"></span>
                    </v-tooltip>
                  </template>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>
            <v-divider class="my-0"></v-divider>
            <template v-if="item.manager != undefined">
              <v-list-item class="cardform-list-item">
                <v-list-item-content class="body-2 inline-block" v-html="__('requester.manager')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">
                  <a :href="'/admin/configer/users/card/'+item.manager.id" target="_blank">{{item.manager.full_name}}</a>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item">
                <v-list-item-content> 
                  <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.manager.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                  <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.manager.avatar"></v-img></v-avatar>
                </v-list-item-content>
              </v-list-item>
              <template v-if="item.manager.phone != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" v-if="item.manager.phone != null">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.manager.phone}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.manager.phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.phone_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                <template v-if="item.manager.email != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" >
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.manager.email}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'mailto:'+item.manager.email" v-on="on"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
            </template>
            <template v-else>
              <v-list-item class="cardform-list-item pt-4 text-center">
                <v-list-item-title>
                  <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('requester.user'), 'manager', managers, company_user_headers)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_manager')"></span></v-btn>
                </v-list-item-title>
              </v-list-item>
            </template>
          </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>

      <v-card color="transparent" flat class="mb-2">
        <ul class="list-group pl-0 ml-0 mb-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            <FieldAccess model="requester" field="user_change" :field_name="__('requester.user')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('requester.user')"></h4></v-list-item-content>
                <v-list-item-icon v-if="accessData.canEdit">
                  <template v-if="item.user">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem(__('requester.user'), 'user', company_users, company_user_headers)">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="deleteUser">
                          <v-icon>mdi-minus-circle-outline</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption"  v-html="__('buttons.delete_tooltip')"></span>
                    </v-tooltip>
                  </template>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>
            <v-divider class="my-0"></v-divider>
            <template v-if="item.user != undefined">
              <v-list-item class="cardform-list-item">
                <v-list-item-content class="body-2 inline-block" v-html="__('requester.user')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">
                  <a :href="'/admin/configer/users/card/'+item.user.id" target="_blank">{{item.user.full_name}}</a>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item">
                <v-list-item-content> 
                  <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.user.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                  <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.user.avatar"></v-img></v-avatar>
                </v-list-item-content>
              </v-list-item>
              <template v-if="item.user.phone != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" v-if="item.user.phone != null">
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.user.phone}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.user.phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.phone_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                <template v-if="item.user.email != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" >
                    <v-list-item-content class="body-2 inline-block" v-html="__('user.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.user.email}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'mailto:'+item.user.email" v-on="on"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
            </template>
            <template v-else>
              <v-list-item class="cardform-list-item pt-4 text-center">
                <v-list-item-title>
                  <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('requester.user'), 'user', company_users, company_user_headers)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_user')"></span></v-btn>
                </v-list-item-title>
              </v-list-item>
            </template>
          </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>


     <!--  <v-card color="transparent" flat class="mb-2">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>
              <FieldAccess model="requester" field="directory_firm_change" :field_name="__('requester.directory_firm')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('requester.directory_firm')"></h4></v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <template v-if="item.directory_firm != undefined || item.additional_place != undefined">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem(__('requester.directory_firm'), 'directory_firm', directory_firms, directory_firm_headers, orderer_additional_places)">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="deleteDirectoryFirm">
                            <v-icon>mdi-minus-circle-outline</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.delete_tooltip')"></span>
                      </v-tooltip>
                    </template>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
              <v-divider class="my-0"></v-divider>
              <template v-if="item.directory_firm != undefined">
                <template v-if="item.directory_firm.option == true">
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.directory_firm')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.directory_firm.title}}</v-list-item-content>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content> 
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.directory_firm.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/additional_places/'+item.directory_firm.avatar"></v-img></v-avatar>
                    </v-list-item-content>
                  </v-list-item>
                  <template v-if="item.customer != undefined">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item">
                      <v-list-item-content class="body-2 inline-block" v-html="__('customer.metro')"></v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">{{item.customer.main_metro}}</v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item">
                      <v-list-item-content class="body-2 inline-block" v-html="__('customer.address')"></v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">{{item.customer.main_address}}</v-list-item-content>
                    </v-list-item>
                  </template>
                </template>
                <template v-else>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('customer.directory_firm')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <a :href="'/admin/directory/firms/'+item.directory_firm.id" target="_blank">{{item.directory_firm.full_name}}</a>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content> 
                    <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.directory_firm.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                    <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.directory_firm.avatar"></v-img></v-avatar>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.city')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.directory_firm.main_city}}</v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.metro')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.directory_firm.main_metro}}</v-list-item-content>
                </v-list-item>
                <template v-if="item.directory_firm.main_phone != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" v-if="item.directory_firm.main_phone != null">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.directory_firm.main_phone}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.directory_firm.main_phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.phone_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                <template v-if="item.directory_firm.main_email != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" >
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.directory_firm.main_email}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'mailto:'+item.directory_firm.main_email" v-on="on"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                </template>
              </template>
              <template v-else-if="item.additional_place != undefined">
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('requester.directory_firm')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.additional_place.title}}</v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content> 
                    <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.additional_place.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                    <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/additional_places/'+item.additional_place.avatar"></v-img></v-avatar>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('customer.metro')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.customer.main_metro}}</v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('customer.address')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.customer.main_address}}</v-list-item-content>
                </v-list-item>
              </template>
              <template v-else>
                <v-list-item class="cardform-list-item pt-4 text-center">
                  <v-list-item-title>
                    <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('requester.directory_firm'), 'directory_firm', directory_firms, directory_firm_headers, orderer_additional_places)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_directory_firm')"></span></v-btn>
                  </v-list-item-title>
                </v-list-item>
              </template>
            </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>

      <v-card color="transparent" flat class="mb-2">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>
              <FieldAccess model="requester" field="directory_person_change" :field_name="__('requester.directory_person')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('requester.directory_person')"></h4></v-list-item-content>

                  <v-list-item-icon class="ml-2" v-if="accessData.canEdit">
                    <template v-if="item.directory_person != undefined">
                    <v-tooltip top >
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem(__('requester.directory_person'), 'directory_person', directory_people, directory_person_headers)">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption"  v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="deleteDirectoryPerson">
                            <v-icon>mdi-minus-circle-outline</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.delete_tooltip')"></span>
                      </v-tooltip>
                    </template>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
              <v-divider class="my-0"></v-divider>
              <template v-if="item.directory_person != undefined">
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('requester.directory_person')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <a :href="'/admin/directory/people/'+item.directory_person_id" target="_blank">{{item.directory_person.full_name}}</a>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content> 
                    <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.directory_person.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                    <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.directory_person.avatar"></v-img></v-avatar>
                  </v-list-item-content>
                </v-list-item>
                <template v-if="item.directory_person.main_phone != null">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item" >
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_person.phone')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    {{item.directory_person.main_phone}}
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.directory_person.main_phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                      </template>
                      <span class="caption"  v-html="__('buttons.phone_tooltip')"></span>
                    </v-tooltip>
                  </v-list-item-content>
                </v-list-item>
                </template>
                <template v-if="item.directory_person.main_email != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block" v-html="__('directory_person.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.directory_person.main_email}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'mailto:'+item.directory_person.main_email" v-on="on"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </template>
              <template v-else>
                  <v-list-item class="cardform-list-item pt-4 text-center">
                    <v-list-item-title>
                      <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('requester.directory_person'), 'directory_person', directory_people, directory_person_headers)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_directory_person')"></span></v-btn>
                    </v-list-item-title>
                  </v-list-item>
              </template>
            </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card> -->
    <v-dialog v-model="confirm_dialog" max-width="420">
      <v-card>
        <v-card-title primary-title>Подтвердить</v-card-title>
        <v-card-text>
          Вы действительно хотите подтвердить запись клиента
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="confirm_dialog = !confirm_dialog">Отменить</v-btn>
          <v-btn color="primary" text @click.stop="confirmRecord" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>     
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" width="95%"><tabledialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>

  </v-card>
</template>
<script> 
import tabledialog from '../tabledialog'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'

export default {
  name: 'orderer_relationships',
  data () {
    return {
      dialog: false,
      item: {},
      confirm_dialog: false,
      action_loading: false,
    }
  },
  props: {
    user_id: Number,
  },
  components: { FieldAccess, FieldAccessButton, FieldAccessReloginButton, tabledialog },
  mounted() {
    this.item = Object.assign({}, this.requester)
    this.getItems()
  },
  methods: {
    confirmRecord() {
      this.action_loading = true
      this.$store.dispatch('CONFIRM_REQUESTER_CUSTOMER_RECORD', this.item).then(res => {
        this.confirm_dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.action_loading = false))
    },
    deleteUser() {
      this.item.user = null
      this.item.user_id = null
      this.$emit('submit', this.item)
    },
    deleteDirectoryFirm() {
      this.item.directory_firm = null
      this.item.directory_firm_id = null
      this.item.additional_place = null
      this.item.additional_place_id = null
      this.$emit('submit', this.item)
    },
    deleteDirectoryPerson() {
      this.item.directory_person = null
      this.item.directory_person_id = null
      this.$emit('submit', this.item)
    },
    editItem (text, val, items, headers, options) {
      let field = { text: text, val: val, items: items, headers: headers, options: options }
      this.item.field = field
      this.dialog = true
    },
    submitEdit() {
      this.dialog = false
      this.$emit('submit', this.item)
      /*this.$store.dispatch('EDIT_ORDERER', this.item).then(res => {
        if (this.item_id > 0) { this.$emit('refresh'); this.dialog = false; }
        else { location.href = '/admin/orderer/now/card/'+res.orderer.id }
      })*/
    },
    getItems() {
      /*this.$store.dispatch('GET_CUSTOMERS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_FIRMS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', { user_id: this.user_id, _lang: this.locale })*/
      this.$store.dispatch('GET_COMPANY_USERS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_MANAGERS_USERS', { user_id: this.user_id, _lang: this.locale })
/*      this.$store.dispatch('GET_ORDERER_ADDITIONAL_PLACES', { user_id: this.user_id, _lang: this.locale })*/
    },
    formatDate (dateval, val) {
      if (!dateval) return null
      if (val == 'withTime') {
        const [date, time] = dateval.split(' ')
        const [year, month, day] = date.split('-')
        return `${day}.${month}.${year} ${time}`
      }
      else {
        const [year, month, day] = dateval.split('-')
        return `${day}.${month}.${year}`
      }
    },
  },
  watch: {
    requester: function (val) {
      this.item = Object.assign({}, val)
    },
    locale: function (val) {
      this.getItems()
    },
  },
  computed: {
    /*customer_headers: {
      get() { return this.$store.state.customers.table_headers }
    },
    customers: {
      get() { return this.$store.state.customers.items }
    },
    directory_firm_headers: {
      get() { return this.$store.state.directory_firms.table_headers }
    },
    directory_firms: {
      get() { return this.$store.state.directory_firms.items }
    },
    directory_person_headers: {
      get() { return this.$store.state.directory_people.table_headers }
    },
    directory_people: {
      get() { return this.$store.state.directory_people.items }
    },*/
    requester: {
      get() { return this.$store.state.requester.item },
      set(val) { this.$store.state.requester.item = val }
    },
    managers: {
      get() { return this.$store.state.configer_users.managers },
      set(val) { this.$store.state.configer_users.managers = val },
    },
    orderer_additional_places: {
      get() { return this.$store.state.orderers.additional_places },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val },
    },
    locale: {
      get() { return this.$store.state.lang.lang }
    },
    company_users: {
      get() { return this.$store.state.configer_users.company_users },
      set(val) { this.$store.state.configer_users.company_users = val },
    },
    company_user_headers: {
      get() { return this.$store.state.configer_users.company_user_headers },
      set(val) { this.$store.state.configer_users.company_user_headers = val },
    },

  },
};



</script>
