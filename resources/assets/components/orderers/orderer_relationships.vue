<template>
    <v-card color="transparent" flat v-if="auth_user.id > 0">


      <!-- КЛИЕНТ -->
<!--       <v-card color="transparent" flat class="mb-2" v-if="auth_user.role_id != 101">
        <ul class="list-group pl-0 ml-0">
        <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            <FieldAccess model="orderer" field="customer_change" :field_name="__('orderer.customer')" v-slot="{ accessData }">
              <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                <v-list-item-content class="inline-block" >
                  <h4 class="font-weight-bold my-0" v-html="__('orderer.customer')"> <span class="red--text">*</span></h4>
                </v-list-item-content>
                <FieldAccessReloginButton :accessData="accessData" :id="orderer.customer.user_id" v-if="orderer.customer" />

                <v-list-item-icon class="ml-2" v-if="accessData.canEdit">
                  <template v-if="item.customer != undefined">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem(__('orderer.customer'), 'customer', customers, customer_headers)">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"> </span>
                    </v-tooltip>
                  </template>
                  <FieldAccessButton :accessData="accessData" />
                </v-list-item-icon>
              </v-list-item>
            </FieldAccess>

            <v-divider class="my-0"></v-divider>
            <template v-if="item.customer != undefined">
              <v-list-item class="cardform-list-item">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.full_name')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">
                  <a :href="'/admin/customer/list/card/'+item.customer.id" target="_blank">{{item.customer.full_name}}</a>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item">
                <v-list-item-content> 
                  <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar" v-if="item.customer.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                  <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/150x150.'+item.customer.avatar"></v-img></v-avatar>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.age')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">{{item.customer.age}}</v-list-item-content>
              </v-list-item>
              <v-divider class="my-0"></v-divider>
              <v-list-item class="cardform-list-item">
                <v-list-item-content class="body-2 inline-block" v-html="__('customer.gender')"></v-list-item-content>
                <v-list-item-content class="body-2 inline-block text-right">
                  <template v-if="item.customer.gender == 'M'"> <span v-html="__('forms.gender_male')"></span></template>
                  <template v-if="item.customer.gender == 'F'"> <span v-html="__('forms.gender_female')"></span></template>
                </v-list-item-content>
              </v-list-item>
              <template v-if="item.customer.main_phone != null">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('customer.phone')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    {{item.customer.main_phone}}
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.customer.main_phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
                    </v-tooltip>
                  </v-list-item-content>
                </v-list-item>
              </template>
              <template v-if="item.customer.main_email != null">
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('customer.email')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    {{item.customer.main_email}}
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'mailto:'+item.customer.main_email" v-on="on"><v-icon>mdi-email-outline</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                    </v-tooltip>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </template>
            <template v-else>
              <v-list-item class="cardform-list-item pt-4 text-center">
                <v-list-item-title>
                  <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('orderer.customer'), 'customer', customers, customer_headers)">
                    <v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_client')"></span>
                  </v-btn>
                </v-list-item-title>
              </v-list-item>
            </template>
          </v-list>
        <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card> -->

      <!-- помещение -->
      <v-card color="transparent" flat class="mb-2" v-if="auth_user.role_id != 103">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>
              <FieldAccess model="orderer" field="directory_firm_change" :field_name="__('orderer.place')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('orderer.place')"> <span class="red--text">*</span></h4></v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <FieldAccessReloginButton :accessData="accessData" :id="orderer.directory_firm.user.id" v-if="orderer.directory_firm && item.directory_firm.option == false" />
                    <template v-if="item.directory_firm != undefined || item.additional_place != undefined">
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn 
                            color="red darken-1" 
                            icon 
                            x-small 
                            v-on="on" 
                            class="my-icon-btn" 
                            @click.stop="editItem(__('orderer.place'), 'directory_firm', directory_firms, directory_firm_headers, orderer_additional_places)"
                          >
                            <v-icon>mdi-sync</v-icon>
                          </v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
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
                    <v-list-item-content class="body-2 inline-block"  v-html="__('directory_firm.title')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">{{item.directory_firm.title}}</v-list-item-content>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item">
                    <v-list-item-content> 
                      <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.directory_firm.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                      <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/additional_places/'+item.directory_firm.avatar"></v-img></v-avatar>
                    </v-list-item-content>
                  </v-list-item>
                  <template v-if="item.customer != undefined && item.directory_firm.id != 2">
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
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.title')"></v-list-item-content>
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
                        <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
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
                        <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                </template>
              </template>
              <template v-else-if="item.additional_place != undefined">
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_firm.title')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">{{item.additional_place.title}}</v-list-item-content>
                </v-list-item>
                <v-divider class="my-0"></v-divider>
                <v-list-item class="cardform-list-item">
                  <v-list-item-content> 
                    <v-avatar size="150" color="#ddd" style="max-width: 150px; margin: auto;" class="avatar"  v-if="item.additional_place.avatar == null"><v-img src='/storage/avatars/150x150.nophoto.png'></v-img></v-avatar>
                    <v-avatar size="150" color="transparent" style="max-width: 150px; margin: auto;" class="avatar" v-else><v-img :src="'/storage/avatars/additional_places/'+item.additional_place.avatar"></v-img></v-avatar>
                  </v-list-item-content>
                </v-list-item>

                <!-- <template v-if="item.conferences.length">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item class="cardform-list-item" v-for="conference of item.conferences">
                    <v-list-item-content class="body-2 inline-block">Конференция</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      <a :href="conference.url_start">Создание урока</a><br>
                      <a :href="conference.url_join">Присоединиться к уроку</a><br>
                    </v-list-item-content>
                  </v-list-item>
                </template> -->


                <template v-if="item.additional_place.id != 2">
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
                <v-list-item class="cardform-list-item pt-4 text-center">
                  <v-list-item-title>
                    <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('orderer.directory_firm'), 'directory_firm', directory_firms, directory_firm_headers, orderer_additional_places)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_directory_firm')"></span></v-btn>
                  </v-list-item-title>
                </v-list-item>
              </template>
            </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>

      <!-- преподаватель -->
      <v-card color="transparent" flat class="mb-2" v-if="auth_user.role_id != 102">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
            <v-list class="py-0" dense>
              <FieldAccess model="orderer" field="directory_person_change" :field_name="__('orderer.directory_person')" v-slot="{ accessData }">
                <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                  <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0"  v-html="__('orderer.directory_person')"> <span class="red--text">*</span></h4></v-list-item-content>
                  <v-list-item-icon class="ml-2 my-auto">
                    <template v-if="item.directory_person != undefined">
                      <FieldAccessReloginButton :accessData="accessData" :id="orderer.directory_person.user_id" v-if="orderer.directory_person" />
                    <v-tooltip top v-if="accessData.canEdit">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn" @click.stop="editItem(__('orderer.directory_person'), 'directory_person', directory_people, directory_person_headers)">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    </template>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
              <v-divider class="my-0"></v-divider>
              <template v-if="item.directory_person != undefined">
                <v-list-item class="cardform-list-item">
                  <v-list-item-content class="body-2 inline-block" v-html="__('directory_person.full_name')"></v-list-item-content>
                  <v-list-item-content class="body-2 inline-block text-right">
                    <a :href="'/admin/directory/people/'+item.directory_person.id" target="_blank">{{item.directory_person.full_name}}</a>
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
                    <v-list-item-content class="body-2 inline-block"  v-html="__('directory_person.phone')"></v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">
                      {{item.directory_person.main_phone}}
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary lighten-3" class="my-icon-btn ml-1" icon x-small :href="'callto:'+item.directory_person.main_phone" v-on="on"><v-icon>mdi-phone-outgoing</v-icon></v-btn>
                        </template>
                        <span class="caption" v-html="__('buttons.phone_tooltip')"></span>
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
                        <span class="caption" v-html="__('buttons.email_tooltip')"></span>
                      </v-tooltip>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </template>
              <template v-else>
                  <v-list-item class="cardform-list-item pt-4 text-center">
                    <v-list-item-title>
                      <v-btn color="primary" dark depressed class="rounded-btn" @click.stop="editItem(__('orderer.directory_person'), 'directory_person', directory_people, directory_person_headers)"><v-icon left>mdi-shuffle-variant</v-icon> <span v-html="__('buttons.set_directory_person')"></span></v-btn>
                    </v-list-item-title>
                  </v-list-item>
              </template>
            </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>

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
      item: {}
    }
  },
  props: {
    user_id: Number,
  },
  components: { FieldAccess, FieldAccessButton, FieldAccessReloginButton, tabledialog },
  mounted() {
    this.item = Object.assign({}, this.orderer)
    this.getItems()
  },
  methods: {
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
      this.$store.dispatch('GET_CUSTOMERS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_FIRMS', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', { user_id: this.user_id, _lang: this.locale })
      this.$store.dispatch('GET_ORDERER_ADDITIONAL_PLACES', { user_id: this.user_id, _lang: this.locale })
    },
  },
  watch: {
    orderer: function (val) {
      this.item = Object.assign({}, val)
    },
    locale: function(val) {
      this.getItems()
    },
  },
  computed: {
    item_id: {
      get() { 
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id } 
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    customer_headers: {
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
    },
    orderer: {
      get() { return this.$store.state.orderers.item },
      set(val) { this.$store.state.orderers.item = val }
    },
    orderer_additional_places: {
      get() { return this.$store.state.orderers.additional_places },
    },
    locale: {
      get() { return this.$store.state.lang.lang }
    },
    auth_user: {
      get() { return this.$store.state.auth_user } 
    },
  },
};



</script>
