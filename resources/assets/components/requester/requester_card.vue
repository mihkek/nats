<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" class="mb-3" :loading="loading"/>
      </FieldAccess>
      <v-layout row wrap v-if="item.id > 0 && item.status != 7">
        <v-flex xs12 class="py-0">
          <v-card flat color="transparent">
            <v-chip-group center-active v-model="item.status-1">
              <v-chip
                v-for="status in status_options"
                :key="status.id"
                :color="status.color_calendar"
                :outlined="item.status != status.id ? true : false"
                :dark="item.status == status.id ? true : false"
                label
                :style="item.status != status.id ? 'background: #fff !important;' : ''"
                :class="item.status == status.id ? 'elevation-4 white--text' : '' "
                @click.stop="changeStatus(status)"
                :disabled="status.id != item.status && status.disabled"
                tag
                v-if="status.show != false"
              >
                <v-icon left size="18">{{status.icon}}</v-icon>
                <span v-html="status.title"></span>
              </v-chip>
            </v-chip-group>
          </v-card>
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat class="mb-2">
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2" min-height="48">
                  <v-list-item-content class="inline-block" >
                    <h4 class="font-weight-bold my-0" v-if="item.id > 0" v-html="__('requester.card_title')"></h4>
                    <h4 class="font-weight-bold my-0" v-else v-html="__('requester.new_card_title')"></h4>
                  </v-list-item-content>
                </v-list-item>
                 <!-- <v-divider class="my-0"></v-divider>
                <FieldAccess model="requester" field="status" :field_name="__('requester.status')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.status')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-html="item.requester_status"></v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.status'), val: 'status', type: 'select', options: status_options })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess> -->

                <FieldAccess model="requester" field="promoter_id" :field_name="__('requester.promoter')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block"  v-html="__('requester.promoter')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.promoter != null"><b>{{item.promoter.code_opc}}</b> </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem('OPC', 'promoter', promoters, user_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="directory_firm" :field_name="__('requester.directory_firm')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block"  v-html="__('requester.directory_firm')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.directory_firm != null">{{item.directory_firm.full_name}} </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editTableItem('Торговый центр', 'directory_firm', directory_firms, directory_firms_headers)"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="customer_last_name" :field_name="__('requester.customer_last_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.customer_last_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_last_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.customer_last_name'), val: 'customer_last_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="customer_first_name" :field_name="__('requester.customer_first_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.customer_first_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_first_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.customer_first_name'), val: 'customer_first_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="customer_middle_name" :field_name="__('requester.customer_middle_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.customer_middle_name')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_middle_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.customer_middle_name'), val: 'customer_middle_name', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester_customer" field="main_phone" :field_name="__('customer.phone')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item pr-1">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_main_phone}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.customer_main_phone != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'callto:'+item.customer_main_phone" v-on="on" target="_blank"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.phone'), val: 'customer_main_phone', type: 'text', rules: phone_rules, mask: '+7 (###) ###-##-##'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester_customer" field="main_email" :field_name="__('customer.email')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item pr-1">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.email')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_main_email}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" >
                      <v-tooltip top v-if="item.customer_main_email != null">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn mr-1" icon x-small :href="'mailto:'+item.customer_main_email" v-on="on" target="_blank"><v-icon>mdi-email-outline</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.email'), val: 'customer_main_email', type: 'text', rules: email_rules })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                
                <template v-if="item.is_false > 0">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block">
                      {{false_options.find(el => el.value == item.is_false).text}} 
                    </v-list-item-content>
                    <v-list-item-action class="ml-2 text-right" >
                      <span class="red px-1 white--text">Ложная</span> 
                    </v-list-item-action>
                  </v-list-item>
                </template>
                <template v-if="item.claim != null">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block">
                      <p class="ma-0" v-html="item.claim"></p>
                    </v-list-item-content>
                    <v-list-item-action class="ml-2 text-right" >
                      <span class="amber px-1 white--text">Жалоба</span> 
                    </v-list-item-action>
                  </v-list-item>
                </template>
                <template v-if="item.id > 0 && item.status != 7">
                	<template v-if="item.is_false == null || item.claim == null">
                	  <v-divider class="my-0"></v-divider>
                	  <li class="list-group-item py-1" style="border-top: 0px; border-bottom: 0px;"></li>
                	</template>
                	<template v-if="item.is_false == null">
                	  <FieldAccess model="requester" field="false" :field_name="__('requester.false')" v-slot="{ accessData }" >
                	    <v-list-item class="cardform-list-item pr-1">
                	      <v-list-item-content>
                	        <v-list-item-title class="text-center">
                	          <v-btn color="red darken-1" dark depressed class="rounded-btn" @click.stop="false_dialog = true">
                	            <v-icon left>mdi-file-document-box-remove-outline</v-icon> <span v-html="__('requester.false')"></span>
                	          </v-btn>
                	        </v-list-item-title>
                	      </v-list-item-content>
                	      <v-list-item-icon class="ml-2 my-auto">
                	        <FieldAccessButton :accessData="accessData" />
                	      </v-list-item-icon>
                	    </v-list-item>
                	  </FieldAccess>
                	</template>

                	<template v-if="item.claim == null">
                	  <FieldAccess model="claim" field="false" :field_name="__('requester.claim')" v-slot="{ accessData }" >
                	    <v-list-item class="cardform-list-item pr-1">
                	      <v-list-item-content>
                	        <v-list-item-title class="text-center">
                	          <v-btn color="amber darken-1" dark depressed class="rounded-btn" @click.stop="claim_dialog = true">
                	            <v-icon left>mdi-comment-alert-outline</v-icon> <span v-html="__('requester.claim')"></span>
                	          </v-btn>
                	        </v-list-item-title>
                	      </v-list-item-content>
                	      <v-list-item-icon class="ml-2 my-auto">
                	        <FieldAccessButton :accessData="accessData" />
                	      </v-list-item-icon>
                	    </v-list-item>
                	  </FieldAccess>
                	</template>

                	<template v-if="item.status == 6 && item.confirmed == 1">
                	  <FieldAccess model="sign_client" field="false" :field_name="__('requester.sign_client')" v-slot="{ accessData }" >
                	    <v-list-item class="cardform-list-item pr-1">
                	      <v-list-item-content>
                	        <v-list-item-title class="text-center">
                	          <v-btn color="green darken-1" dark depressed class="rounded-btn" @click.stop="sign_dialog = true">
                	            <v-icon left>mdi-check-decagram</v-icon> <span v-html="__('requester.sign_client')"></span>
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

          <v-card color="transparent" flat class="mb-2">
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2" min-height="48">
                  <v-list-item-content class="inline-block" >
                    <h4 class="font-weight-bold my-0" v-if="item.id > 0" v-html="__('requester.customer_child')"></h4>
                    <h4 class="font-weight-bold my-0" v-else v-html="__('requester.customer_child')"></h4>
                  </v-list-item-content>
                </v-list-item>

                <FieldAccess model="requester_customer" field="customer_child_last_name" :field_name="__('customer.customer_child_last_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.customer_child_last_name')"> </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_child_last_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.customer_child_last_name'), val: 'customer_child_last_name', type: 'text'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester_customer" field="customer_child_first_name" :field_name="__('customer.customer_child_first_name')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.customer_child_first_name')"> </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_child_first_name}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.customer_child_first_name'), val: 'customer_child_first_name', type: 'text'})"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>


                <FieldAccess model="requester_customer" field="age" :field_name="__('customer.age')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.age')"> </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.customer_age}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.age'), val: 'customer_age', type: 'text', rules: [], mask: '###' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester_customer" field="gender" :field_name="__('customer.gender')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('customer.gender')"> </v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <template v-if="item.customer_gender == 'M'">
                        <span v-html="__('customer.gender_male')"></span>
                      </template>
                      <template v-else-if="item.customer_gender == 'F'">
                        <span v-html="__('customer.gender_female')"></span>
                      </template>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('customer.gender'), val: 'customer_gender', type: 'select', options: genders })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="first_test" :field_name="__('requester.first_test')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.first_test')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-show="item.first_test">{{item.first_test}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.first_test'), val: 'first_test', type: 'select', options: first_test_options })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="second_test" :field_name="__('requester.second_test')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.second_test')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.second_test}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.second_test'), val: 'second_test', type: 'select', options: second_test_options })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="requester" field="third_test" :field_name="__('requester.third_test')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('requester.third_test')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                    	<template  v-for="(val, i) in item.third_test" >
                    		<span :key="i">{{val}}</span><template v-if="i != item.third_test.length-1">, </template>
                    	</template>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.third_test'), val: 'third_test', type: 'multiselect', options: third_test_options })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                

                <!-- <template v-if="item.id > 0">
                  <template v-if="item.customer.is_customer == 0">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item pt-4 text-center" >
                      <v-list-item-title>
                        <v-dialog v-model="customerDialog" width="420">
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark depressed class="rounded-btn" v-on="on"><v-icon left>mdi-account-plus</v-icon> <span v-html="__('buttons.customer_transform')"></span></v-btn>
                          </template>
                          <v-card>
                            <v-card-title primary-title v-html="__('requester.customer_transform')"></v-card-title>
                            <v-card-text v-html="__('requester.customer_transform_desc')"></v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="primary" text @click="customerDialog = false" small v-html="__('buttons.cancel')"></v-btn>
                              <v-btn color="primary" text @click="addCustomer" small :loading="loading" v-html="__('buttons.submit')"></v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                      </v-list-item-title>
                    </v-list-item>
                  </template>
                </template> -->
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
          <template v-if="item.id > 0">
            <child_photo @refresh="getItem" :item="item" :user_id="user_id" />
            <DateLogger :item="item" :auth_user="auth_user"/>
          </template>
        </v-flex>
        <v-flex md6 xs12>

          <requester_relationships @submit="submit" @refresh="getItem" :item="item" :user_id="user_id"/>

          <v-card color="transparent" flat class="mb-2">
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <FieldAccess model="requester" field="main_comment" :field_name="__('requester.comment')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="inline-block"><h4 class="font-weight-bold my-0" v-html="__('requester.comment')"></h4></v-list-item-content>
                  <v-list-item-icon class="ml-2" >
                    <v-tooltip top v-if="accessData.canEdit">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('requester.comment'), val: 'main_comment', type: 'textarea'})"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block">{{item.main_comment || 'Пусто'}}</v-list-item-content>
                </v-list-item>
                </FieldAccess>
            </v-list>
           <li class="list-group-item py-2" style="border-top: 0px !important;"></li>
          </ul>
        </v-card> 
          <!-- <requester_deal @submit="submit" @refresh="getItem" :item="item" :user_id="user_id"/> -->
        </v-flex>
      </v-layout>
      <v-divider class="d-flex d-md-none"></v-divider>
      <v-layout v-if="item.id > 0">
        <v-flex xs12>
          <requester_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="false_dialog" max-width="500px">
      <v-card color="rgba(250, 250, 250)">
        <v-card-title>Ложная заявка</v-card-title>
        <v-card-text>
          <v-card flat>
            <v-radio-group solo flat dense hide-details v-model="false_value" class="py-0">
              <v-radio
                v-for="option in false_options"
                :key="option.value"
                :label="option.text"
                :value="option.value"
                solo
                flat
                dense
              ></v-radio>
            </v-radio-group>
          </v-card>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text small @click.stop="false_dialog = false">Отмена</v-btn>
          <v-btn color="primary" text small @click.stop="falseRequester" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="claim_dialog" max-width="500px">
      <v-card color="rgba(250, 250, 250)">
        <v-card-title class="py-4">Жалоба</v-card-title>
        <v-card-text>
          <v-textarea
            placeholder="Комментарий по жалобе"
            v-model="claim_comment"
            solo
            flat
            dense
          ></v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text small @click.stop="claim_dialog = false">Отмена</v-btn>
          <v-btn color="primary" text small @click.stop="claimRequester" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="sign_dialog" max-width="500px">
      <v-card color="rgba(250, 250, 250)">
        <v-card-title class="py-4">Заключить сделку</v-card-title>
        <v-card-text>
          Вы действительно хотите заключить сделку и создать новый профиль клиента
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text small @click.stop="sign_dialog = false">Отмена</v-btn>
          <v-btn color="primary" text small @click.stop="signClient" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="status_dialog" max-width="380">
      <v-card color="rgba(250, 250, 250)">
      	<v-form v-model="status_valid" ref="status_form" @submit.prevent="submitChangeStatus">
        <v-card-title class="py-4">
        	Сменить статус на
        	<v-spacer></v-spacer>
        	<v-chip label :color="selected_status.color_calendar" dark>{{selected_status.title}}</v-chip>
        </v-card-title>
        <v-card-text v-if="selected_status.type == 'deal'">
        	<v-card flat>
        		<v-alert
      				outlined
      				type="warning"
      				prominent
      				border="right"
    			>
     				<p class="my-0 mx-4">Перед сменой статуса, укажите дату и время следующего звонка</p>
    			</v-alert>
        	</v-card>
          	<v-text-field
              	label="Дата"
              	v-model="deal_date"
              	type="date"
              	solo
              	flat
              	dense
              	:rules="rules"
              	required
            ></v-text-field>
            <v-text-field
             	label="Время"
             	v-model="deal_time"
             	type="time"
             	solo
             	flat
             	dense
              	:rules="rules"
              	required
            ></v-text-field>
        </v-card-text>
        <v-card-text v-else-if="selected_status.type == 'order'">
        	<v-card flat>
        		<v-alert
      				outlined
      				type="success"
      				prominent
      				border="right"
    			>
     				<p class="my-0 mx-4">Укажите дату и время на которое клиент записался</p>
    			</v-alert>
        	</v-card>
          	<v-text-field
              	label="Дата"
              	v-model="deal_date"
              	type="date"
              	solo
              	flat
              	dense
              	:rules="rules"
              	required
            ></v-text-field>
            <v-text-field
             	label="Время"
             	v-model="deal_time"
             	type="time"
             	solo
             	flat
             	dense
              	:rules="rules"
              	required
            ></v-text-field>
        </v-card-text>
        <v-card-text v-else>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text small @click.stop="status_dialog = false">Отмена</v-btn>
          <v-btn color="primary" text small type="submit" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      	</v-form>
      </v-card>
    </v-dialog>
     <v-dialog v-model="tabledialog" max-width="90%"><tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="item"/></v-dialog>
    <v-dialog v-model="dialog" max-width="420px">
      <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
    </v-dialog>
    <snackbar />
  </v-app>
</template>
<script> 
import lang_menu from '../lang_menu'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import tabledialog from '../tabledialog'
import child_photo from './child_photo'
import requester_deal from './requester_deal'
import requester_relationships from './requester_relationships'
import requester_tabs from './requester_tabs'

import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton';

export default {
  name: 'orderer_card',
  data () {
    return {
      dialog: false,
      action_dialog: false,
      item: {},
      new_flag: false,
      check_time: false,
      customerDialog: false,
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
      claim_comment: '',
      claim_dialog: false,
      false_dialog: false,
      false_options: [
        { text: 'Живут далее 50 км.', value: 1 },
        { text: 'Не тот клиент', value: 2 },
        { text: 'Ребенок инвалид', value: 3 },
        { text: 'Анкету заполнили без родителя', value: 4 },
        { text: 'Клиента заставили оставить данные', value: 5 },
        { text: 'Клиенту ничего не рассказывали про школу', value: 6 },
        { text: 'Лид заполнен не на родителя', value: 7 },
      ],
      false_value: '',
      status_dialog: false,
      selected_status: {},
      action_loading: false,
      status_valid: false,
      deal_date: '',
      deal_time: '',
      sign_dialog: false,
      first_test_options: [
      	{  id: 1, title: 'Изображение 1' },
      	{  id: 2, title: 'Изображение 2' },
      	{  id: 3, title: 'Изображение 3' },
      	{  id: 4, title: 'Изображение 4' },
      	{  id: 5, title: 'Изображение 5' },
      ],
      second_test_options: [
      	{  id: 1, title: 'Изображение 1' },
      	{  id: 2, title: 'Изображение 2' },
      	{  id: 3, title: 'Изображение 3' },
      	{  id: 4, title: 'Изображение 4' },
      	{  id: 5, title: 'Изображение 5' },
      	{  id: 6, title: 'Изображение 6' },
      ],
      third_test_options: [
      	{  id: 1, title: 'Вариант 1' },
      	{  id: 2, title: 'Вариант 2' },
      	{  id: 3, title: 'Вариант 3' },
      	{  id: 4, title: 'Вариант 4' },
      	{  id: 5, title: 'Вариант 5' },
        {  id: 6, title: 'Вариант 6' },
        {  id: 7, title: 'Вариант 7' },
        {  id: 8, title: 'Вариант 8' },
        {  id: 9, title: 'Вариант 9' },
        {  id: 10, title: 'Вариант 10' },
        {  id: 11, title: 'Вариант 11' },
        {  id: 12, title: 'Вариант 12' },
        {  id: 13, title: 'Вариант 13' },
        {  id: 14, title: 'Вариант 14' },
        {  id: 15, title: 'Вариант 15' },
        {  id: 16, title: 'Вариант 16' },
        {  id: 17, title: 'Вариант 17' },
        {  id: 18, title: 'Вариант 19' },
        {  id: 19, title: 'Вариант 19' },
        {  id: 20, title: 'Вариант 20' },
      	{  id: 21, title: 'Вариант 21' },
      ],
      user_headers: [
        { id: 1, text: 'ОРС', value: 'code_opc' },
        { id: 2, text: __('user.full_name'), value: 'full_name' },
        { id: 3, text: __('user.email'), value: 'main_email' },
      ],
      tabledialog: false,
      directory_firms_headers: [
        { value: 'full_name', text: 'Наименование' },
      ]
    }
  },
  props: {
    user_id: Number,
    new: Boolean,
  },
  components: { 
    FieldAccess, 
    FieldAccessButton, 
    FieldAccessReloginButton, 
    editdialog, 
    requester_relationships, 
    snackbar, 
    requester_tabs, 
    lang_menu, 
    AdminPanel, 
    DateLogger, 
    child_photo,
    requester_deal,
    tabledialog,
  },
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id }).then(res => {
      this.getItem()
      this.getPromoters()
      this.getDirectoryFirms()
    })
  },
  methods: {
    getDirectoryFirms() {
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        subdivision_id: this.auth_user.subdivision_id,
        type: 2,
      }
      this.$store.dispatch('GET_DIRECTORY_FIRMS', params).then(res => {
        console.log(this.directory_firms)
      })
    },
  	editTableItem(text, val, items, headers) {
      let field = { text: text, val: val, items: items, headers: headers }
      this.item.field = field
      this.tabledialog = true
    },
    signClient() {
      this.action_loading = true
      this.$store.dispatch('ADD_REQUESTER_CUSTOMER', this.item).then(res => {
        if (res.customer != undefined) location.href = '/admin/customer/list/card/'+res.customer.id
      })
      .finally(() => (this.action_loading = false))
    },
    submitChangeStatus() {
    	if (!this.status_valid) return
    	else {
      		this.item.status = this.selected_status.id
      		if (this.selected_status.type == 'deal') {
      			this.item.is_deal = 1
      			this.item.deal_date = this.deal_date
      			this.item.deal_time = this.deal_time
      		}
      		if (this.selected_status.type == 'order') {
      			this.item.is_deal = 1
      			this.item.deal_date = this.deal_date
      			this.item.deal_time = this.deal_time
      		}
      		this.submitEdit()
    	}
    },
    changeStatus(status) {
    	this.selected_status = Object.assign({}, status)
    	this.status_dialog = true
      	/*this.selected_status = Object.assign({}, status)
      	this.status_dialog = true*/
    },
    falseRequester() {
      this.action_loading = true
      let params = {
        id: this.item.id,
        is_false: this.false_value
      }
      this.$store.dispatch('REQUESTER_IS_FALSE', params).then(res => {
        this.false_dialog = false
        this.getItem()
      })
      .finally(() => (this.action_loading = false))
    },
    claimRequester() {
      this.action_loading = true
      let params = {
        id: this.item.id,
        claim: this.claim_comment
      }
      this.$store.dispatch('REQUESTER_IS_CLAIM', params).then(res => {
        this.claim_dialog = false
        this.getItem()
      })
      .finally(() => (this.action_loading = false))
    },
    addCustomer() {
      this.customerDialog = false
      this.loading = true
      this.item._lang = this.locale
      this.$store.dispatch('ADD_REQUESTER_CUSTOMER', this.item).then(res => { this.getItem() })
    },
    actionItem(val) {
      this.item.action_val = val
      this.action_dialog = true
    },
    editItem(field) {
      if (this.new == true) { this.new_flag = true }
      this.item.field = field
      this.dialog = true
    },
    submit(val) {
      this.item = val
      this.submitEdit()
    },
    submitEdit() {
      if (this.new == true) { this.new_flag = true }
      if (this.checkFields()) {
        this.new_flag = false
        this.loading = true
        this.item._lang = this.locale
        this.item.promoter_id = this.item.promoter.id
        this.item.user_id = this.user_id
        this.$store.dispatch('EDIT_REQUESTER', { form: this.item, _lang: this.locale }).then(res => {
        	this.deal_date = ''
        	this.deal_time = ''
          	if (this.item_id > 0) { this.getItem(); this.dialog = false; this.status_dialog = false; this.tabledialog = false }
          	else { location.href = '/admin/requester/now/card/'+res.requester.id }
        })
      }
      else {
        this.requester = this.item
        this.dialog = false
        this.tabledialog = false
      }
    },
    getItem() {
      if (this.item_id > 0) {
        let params = {}
        params.id = this.item_id
        params._lang = this.locale
        params.user_id = this.user_id
        this.$store.dispatch('GET_REQUESTER', params).then(res => { 
          this.loading = false
          this.dialog = false
          this.action_dialog = false
          this.customerDialog = false
        })
        .catch(error => { this.loading = false })
      }
      else {
        this.dialog = false
        this.loading = false
      }
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
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.promoter == null) flag = false
        if (this.item.customer_last_name == undefined) flag = false
        if (this.item.customer_first_name == undefined) flag = false
        if (this.item.customer_middle_name == undefined) flag = false
        if (this.item.customer_main_phone == undefined) flag = false
        if (this.item.customer_child_first_name == undefined) flag = false
        if (this.item.customer_age == undefined) flag = false
        /*if (this.item.projected_amount == undefined) { flag = false }
        if (this.item.date == undefined) { flag = false }
        if (this.item.time == undefined) { flag = false }*/
        /*if (this.item.customer_main_phone == undefined) { flag = false }
        if (this.item.customer_main_email == undefined) { flag = false }
        if (this.item.customer_age == undefined) { flag = false }
        if (this.item.customer_gender == undefined) { flag = false }
        if (this.item.customer_main_city == undefined) { flag = false }
        if (this.item.customer_main_address == undefined) { flag = false }
        if (this.item.customer_main_metro == undefined) { flag = false }*/
        return flag
      }
      else {
        return true
      }
    },
    formatStatus(val){
      /*if (val == 1) { return  __('requester.new_status') }
      else if (val == 2) { return __('requester.hot_status') }
      else if (val == 3) { return __('requester.call_status') }
      else if (val == 4) { return __('requester.put_status') }
      else if (val == 5) { return __('requester.cancel_status') }
      else if (val == 6) { return __('requester.complete_status') }*/
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '' }
    },
	  getPromoters() {
      let params = {
        user_id: this.user_id,
        _lang: this.locale,
        subdivision_id: this.auth_user.subdivision_id,
        is_delete: 0,
      }
      console.log(params)
      this.$store.dispatch('GET_PROMOTERS', params).then(res => { this.loading = false }).then(res => {
      })
      .catch(error => { this.loading = false })
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
                  var showstr = "";
                  if (e) { //for ie and firefox
                      e.returnValue = showstr;
                  }
                  return showstr; //for safari and chrome
              }
            }
        };
  },
  watch: {
    dialog: function (val) {
      if (val == false) { this.item = Object.assign({}, this.requester) }
    },
    requester: function (val) {
      this.item = Object.assign({}, val)
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
    },
    'item.status': function (val) {
      this.status_options.map(option => {
        if (option.id == val) {
          this.item.requester_status = option.title
        }
      })
    },
  },
  computed: {
    directory_firms: {
      get() { return this.$store.state.directory_firms.items }
    },
    genders: {
      get() {
       let options = [ { id: 'M', title: __('customer.gender_male'), text: 'customer.gender_male' }, { id: 'F', title: __('customer.gender_female'), text: 'customer.gender_female' } ]
       options.map(item => {
        if (item.title == item.text) {
          item.title = '<span class="no_translate">'+item.text+'</span>'
        }
       })
       return options
      },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user } 
    },
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id } 
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    status_options: {
      get() { 
        let options = this.$store.state.requester.status_options 
           options.map(status => {
           if (status.title == status.text) {
             status.title = '<span class="no_translate">'+status.text+'</span>'
           }
        })
        return options
      },
      set(val) { this.$store.state.requester.status_options = val }
    },
    requester: {
      get() { return this.$store.state.requester.item },
      set(val) { this.$store.state.requester.item = val }
    },
    locale: {
      get() { return this.$store.state.lang.lang },
    },
    promoters: {
      get() { return this.$store.state.promoters.items },
      set(val) { this.$store.state.promoters.items = val }
    },
  },
};



</script>
