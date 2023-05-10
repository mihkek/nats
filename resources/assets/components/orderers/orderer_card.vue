<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
      </FieldAccess>
      <Alert :user_id="user_id"/>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat class="mb-2">
            <ul class="list-group pl-0 ml-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <v-list-item class="cardform-list-item pb-2">
                  <v-list-item-content class="inline-block" >
                    <h4 class="font-weight-bold my-0" v-html="item.id > 0 ? __('orderer.card_title') : __('orderer.new_title')"></h4>
                  </v-list-item-content>
                </v-list-item>

                <!-- <template v-if="item.status == 3 && item.next_orderer_id > 0">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block" v-html="__('orderer.next_title')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <a :href="'/admin/orderer/now/card/'+item.next_orderer_id">{{formatDate(item.next_orderer.date)}} {{item.next_orderer.time}}</a>
                    </v-list-item-content>
                  </v-list-item>
                </template>
 -->
                

                <FieldAccess model="orderer" field="status" :field_name="__('orderer.status')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <!-- <v-list-item class="cardform-list-item" :class="accessData.canEdit && item.id > 0 ? 'pr-1' : ''"> -->
                    <v-list-item class="cardform-list-item">
                    <v-list-item-content class="body-2 inline-block" v-html="__('orderer.status')"></v-list-item-content>

                    <v-list-item-content class="body-2 inline-block text-right" v-html="orderer.orderer_status"></v-list-item-content>

                    <!-- <v-list-item-content class="body-2 inline-block text-right" v-else>Ожидается подтверждение от клиента</v-list-item-content> -->

                    <!-- <v-list-item-icon class="ml-2 text-right" v-if="item_id > 0">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Статус', val: 'status', type: 'select', status_options: status_options })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption">Редактировать</span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon> -->
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="orderer" field="date" :field_name="__('orderer.date')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('orderer.date')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{formatDate(item.date)}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top >
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('orderer.date'), val: 'date', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <FieldAccess model="orderer" field="time" :field_name="__('orderer.time')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('orderer.time')"> <span class="red--text">*</span></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.time}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('orderer.time'), val: 'time', type: 'time', rules: [], mask: '##:##' })"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>

                <template v-if="item.status == 2 || item.status == 4">
                  <template v-if="item.action_reason != null">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item">
                      <v-list-item-content class="body-2 inline-block" v-html="__('orderer.action_reason')"></v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">{{item.action_reason}}</v-list-item-content>
                    </v-list-item>
                  </template>
                  <template v-if="item.action_comment != null">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item">
                      <v-list-item-content class="body-2 inline-block" v-html="__('orderer.action_comment')"></v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">{{item.action_comment}}</v-list-item-content>
                    </v-list-item>
                  </template>
                </template>

               <!--  <template v-if="item.id > 0">
                	<FieldAccess model="orderer" field="price" :field_name="__('orderer.price')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canAdmin ? 'pr-0' : ''">
                    <v-list-item-content class="body-2 inline-block" v-html="__('orderer.price')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{formatPrice(item.price)}} </v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canAdmin"><FieldAccessButton :accessData="accessData" /></v-list-item-icon>
                  </v-list-item>
                	</FieldAccess>
	
                	<FieldAccess model="orderer" field="directory_person_amount" :field_name="__('orderer.directory_person_amount')" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" :class="accessData.canAdmin ? 'pr-0' : ''">
                    <v-list-item-content class="body-2 inline-block"  v-html="__('orderer.directory_person_amount')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.directory_person_amount > 0">{{formatPrice(item.directory_person_amount)}}</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right" v-if="item.directory_person_amount[item.directory_person.specialist_level] != undefined">{{formatPrice(item.directory_person_amount[item.directory_person.specialist_level][1])}}</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right" v-if="accessData.canAdmin">
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                	</FieldAccess>
	
                	<FieldAccess model="orderer" field="directory_firm_amount" :field_name="__('orderer.directory_firm_amount')" v-slot="{ accessData }">
                    <v-divider class="my-0"></v-divider>
                    <v-list-item class="cardform-list-item" :class="accessData.canAdmin ? 'pr-0' : ''">
                      <v-list-item-content class="body-2 inline-block"  v-html="__('orderer.directory_firm_amount')"></v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right">{{formatPrice(item.directory_firm_amount)}} </v-list-item-content>
                      <v-list-item-icon class="ml-2 text-right" v-if="accessData.canAdmin">
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </v-list-item>
                	</FieldAccess>
                </template> -->

                <template v-if="item.id > 0 && item.status != 3">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item py-1" style="min-height: 0;">
                  </v-list-item>
                  <template v-if="item.conferences.length && auth_user.role_id != 103">
                    <template v-for="(conference, index) of item.conferences">
                    <FieldAccess model="orderer" field="lessons_start" :field_name="__('order.lessons_start')" v-slot="{ accessData }" :key="index">
                      <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                        <v-list-item-content>
                          <v-list-item-title>
                          <v-btn color="cyan darken-1" dark depressed class="rounded-btn" :href="conference.url_start" target="_blank">
                            <v-icon left>mdi-alarm-plus</v-icon> <span v-html="__('buttons.lessons_start')"></span>
                          </v-btn>
                          </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-icon class="ml-2 my-auto">
                          <FieldAccessButton :accessData="accessData" />
                        </v-list-item-icon>
                      </v-list-item>
                    </FieldAccess>
                    <FieldAccess model="orderer" field="lessons_join" :field_name="__('order.lessons_join')" v-slot="{ accessData }">
                      <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                        <v-list-item-content>
                          <v-list-item-title>
                          <v-btn color="cyan darken-1" dark depressed class="rounded-btn" :href="conference.url_join" target="_blank">
                            <v-icon left>mdi-clipboard-plus</v-icon> <span v-html="__('buttons.join_lesson')"></span>
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
                <template>
                  <template v-if="item.not_complete == true">
                    <FieldAccess model="orderer" field="confirm" :field_name="__('orderer.confirm')" v-slot="{ accessData }" >
                      <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                      <v-list-item-content>
                        <v-list-item-title>
                          <v-btn color="green darken-1" dark depressed class="rounded-btn" @click.stop="actionItem('confirm')"><v-icon left>mdi-pin</v-icon> <span v-html="__('buttons.orderer_confirm')"></span></v-btn>
                        </v-list-item-title>
                      </v-list-item-content>
                      <v-list-item-icon class="ml-2 my-auto">
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                      </v-list-item>
                    </FieldAccess>
                  </template>

                <FieldAccess model="orderer" field="transfer" :field_name="__('orderer.transfer')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                  <v-list-item-content>
                    <v-list-item-title>
                      <v-btn color="primary lighten-1" dark depressed class="rounded-btn" @click.stop="actionItem('transfer')"><v-icon left>mdi-reply</v-icon> <span v-html="__('buttons.orderer_transfer')"></span></v-btn>
                    </v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 my-auto">
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                <FieldAccess model="orderer" field="cancel" :field_name="__('orderer.cancel')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                  <v-list-item-content>
                    <v-list-item-title>
                      <v-btn color="red lighten-1" dark depressed class="rounded-btn" @click.stop="actionItem('cancel')"><v-icon left>mdi-cancel</v-icon> <span v-html="__('buttons.orderer_cancel')"></span></v-btn>
                    </v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon class="ml-2 my-auto">
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
                </template>

                </template>
                <!-- <template v-if="item.is_complete == 1 && item.status != 3">
                  <FieldAccess model="orderer" field="close" :field_name="__('orderer.close')" v-slot="{ accessData }">
                    <v-divider></v-divider>
                    <v-list-item class="cardform-list-item text-center" :class=" accessData.canAdmin  ? 'pr-0' : '' ">
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-btn color="green lighten-1" dark depressed class="rounded-btn" @click.stop="actionItem('close')"><v-icon left>mdi-check</v-icon> <span v-html="__('buttons.orderer_close')"></span></v-btn>
                      </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2 my-auto">
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                    </v-list-item>
                  </FieldAccess>
                </template> -->
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
          <orderer_relationships @submit="submit" @refresh="getItem" :item="item" :user_id="user_id"/>
          <template v-if="item.id > 0">
              <v-card color="transparent" flat class="mb-2" >
                <ul class="list-group pl-0 ml-0">
                  <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
                  <v-list class="py-0" dense>
                    <v-list-item class="cardform-list-item pr-1 pb-2">
                      <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('orderer.comment')"></h4></v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                    <FieldAccess model="orderer" field="comment" :field_name="__('orderer.comment')" v-slot="{ accessData }">
                      <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                        <v-list-item-content class="body-2 inline-block">{{item.comment}}</v-list-item-content>
                        <v-list-item-icon class="ml-2" v-if="accessData.canEdit">
                          <v-tooltip top v-if="accessData.canEdit">
                            <template v-slot:activator="{ on }">
                              <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('orderer.comment'), val: 'comment', type: 'textarea', rules: [] })"><v-icon>mdi-sync</v-icon></v-btn>
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
            <!-- <v-card color="transparent" flat class="mb-2">
              <ul class="list-group pl-0 ml-0">
                <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
                <v-list class="py-0" dense>
                  <v-list-item class="cardform-list-item pr-1 pb-2">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('orderer.customer_review')"></h4></v-list-item-content>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <FieldAccess model="orderer" field="customer_review_rate" :field_name="__('orderer.customer_review_rate')" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" >
                      <v-rating
                        :value="item.customer_review_rate"
                        color="yellow darken-3"
                        background-color="grey darken-1"
                        empty-icon="$ratingFull"
                        readonly
                        small
                        dense
                      ></v-rating>
                    </v-list-item-content>
                    <v-list-item-icon class="ml-2" v-if="accessData.canEdit">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem( { text: __('orderer.customer_review_rate'), val: 'customer_review_rate', type: 'rating', rules: [] })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  </FieldAccess>

                  <FieldAccess model="orderer" field="customer_review" field_name="Отзыв" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">{{item.customer_review}}</v-list-item-content>
                    <v-list-item-icon class="ml-2">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: __('orderer.customer_review'), val: 'customer_review', type: 'textarea', rules: [] })">
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption"  v-html="__('buttons.edit_tooltip')"></span>
                      </v-tooltip>
                       <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                  </FieldAccess>
                </v-list>
                <li class="list-group-item py-2" style="border-top: 0px;"></li>
              </ul>
            </v-card> -->
            <DateLogger :item="item" :auth_user="auth_user"/>
          </template>
        </v-flex>
        <v-flex md6 xs12>
        	<group @refresh="getItem" :item="item" :user_id="user_id"/>
          	<!--  -->
        </v-flex>
      </v-layout>
      <v-divider class="d-flex d-md-none"></v-divider>
      <v-layout v-if="item.id > 0">
        <v-flex xs12>
          <orderer_tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
     <v-dialog v-model="dialog" max-width="420px"><editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/></v-dialog>
     <v-dialog v-model="action_dialog" max-width="420px"><orderer_dialog v-if="action_dialog" @refresh="getItem" @close="action_dialog = !action_dialog" :item="item"/></v-dialog>
     <snackbar />
  </v-app>
</template>
<script> 
import group from './group'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import orderer_dialog from './orderer_dialog'
import orderer_relationships from './orderer_relationships'
import orderer_tabs from './orderer_tabs'

import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import Alert from '../snippets/Alert'

export default {
  name: 'orderer_card',
  data () {
    return {
      dialog: false,
      action_dialog: false,
      comment_field: { text: __('orderer.comment'), val: 'comment', type: 'textarea', rules: [] },
      review_field: { text: __('orderer.customer_review'), val: 'customer_review', type: 'textarea', rules: [] },
      review_rate_field: { text: __('orderer.customer_review_rate'), val: 'customer_review_rate', type: 'rating', rules: [] },
      item: {},
      new_flag: false,
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
  		orderer_dialog, 
  		orderer_relationships, 
  		orderer_tabs, 
  		snackbar, 
  		DateLogger, 
  		AdminPanel, 
  		Alert,
  		group
  	},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id })
    this.getItem()
  },
  methods: {
    actionItem(val) {
      this.item.action_val = val
      this.action_dialog = true
    },
    editItem(field) {
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
        this.loading = true
        this.new_flag = false
        this.item._lang = this.locale
        this.item.user_id = this.user_id
        this.$store.dispatch('EDIT_ORDERER', this.item).then(res => {
          if (res.status == 0) {
            this.loading = false
            this.dialog = false
            if (this.new != true) {
              this.getItem()
            }
            else {
              if (res.error == 'directory_firm_busy') {
                this.item.directory_firm = null
                this.item.directory_firm_id = null
              }
              else if (res.error == 'directory_person_busy'){
                this.item.directory_person = null
                this.item.directory_person_id = null
              }
              this.orderer = this.item
              this.new_flag = true
            }
          }
          else {
            if (this.item_id > 0) { this.getItem() }
            else { location.href = '/admin/orderer/now/card/'+res.orderer.id }
          }
        })
      }
      else {
        this.orderer = Object.assign({}, this.item)
        this.dialog = false
      }
    },
  	getItem() {
      if (this.item_id > 0) {
        let params = {
          id: this.item_id,
          _lang: this.locale,
          user_id: this.user_id
        }
        this.$store.dispatch('GET_ORDERER', params).then(res => { this.loading = false; this.dialog = false; this.action_dialog = false; })
        .catch(error => { this.loading = false })
      }
      else {
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
        if (this.item.date == undefined || this.item.date == '') { flag = false }
        if (this.item.time == undefined || this.item.time == '') { flag = false }
        if (this.item.customer == undefined) { flag = false }
        if (this.item.directory_person == undefined) { flag = false }
        if (this.item.directory_firm == undefined) { flag = false }
        return flag
      }
      else {
        return true
      }
    },
    formatStatus(val){
      if (val == 1) { return __('orderer.planed_status') }
      else if (val == 2) { return __('orderer.transfer_status') }
      else if (val == 3) { return __('orderer.confirm_status') }
      else if (val == 4) { return __('orderer.cancel_status') }
      else { this.item.status = 1; return __('orderer.planed_status') }
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
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
                  var showstr = "qqq";
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
      if (val == false) { this.item = Object.assign({}, this.orderer) }
    },
    orderer: function (val) {
      this.item = Object.assign({}, val)
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
    },
  },
  computed: {
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
    profile_card_fields: {
      get() { return this.$store.state.orderers.profile_card_fields },
      set(val) { this.$store.state.orderers.profile_card_fields = val }
    },
    status_options: {
      get() { return this.$store.state.orderers.status_options },
      set(val) { this.$store.state.orderers.status_options = val }
    },
    orderer: {
      get() { return this.$store.state.orderers.item },
      set(val) { this.$store.state.orderers.item = val }
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
  },
};



</script>
