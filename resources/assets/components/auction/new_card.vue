<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">
      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" class="mb-3" :loading="loading"/>
      </FieldAccess>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card flat outlined class="mb-4">
            <v-card-title>             
              <span>Новый аукцион</span>
            </v-card-title>

            <v-list subheader>



			  <FieldAccess :model="prefix+'auction'" field="title" field_name="Наименование препарата" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Наименование препарата *</v-list-item-subtitle>
                    <p class="my-0">{{ item.title || '-' }}</p>
                  </v-list-item-content>

                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Наименование средства', val: 'title', type: 'v-select', options: v_select_title_options })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content style="padding-top:0;">
                    <v-list-item-subtitle>Действующее вещество</v-list-item-subtitle>
                    <p class="my-0">{{ item.active_material || '-' }}</p>
                  </v-list-item-content>
                </v-list-item>
              </FieldAccess>



        <FieldAccess :model="prefix+'auction'" field="start_price" field_name="Стартовая цена" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Стартовая цена (₽) *</v-list-item-subtitle>
                    <p class="my-0">{{ item.start_price || '0' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Стартовая цена', val: 'start_price', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>


              <FieldAccess :model="prefix+'auction'" field="size" field_name="Объем" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Объем *</v-list-item-subtitle>
                    <p class="my-0">{{ item.size || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Объем', val: 'size', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="unit" field_name="Единица измерения" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Единица измерения *</v-list-item-subtitle>
                    <p class="my-0">{{ item.unit || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Единица измерения', val: 'unit', type: 'select', options: units })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>


              <FieldAccess :model="prefix+'auction'" field="over_date" field_name="Дата окончания аукциона" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата окончания аукциона *</v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.over_date) || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Дата окончания', val: 'over_date', type: 'date' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="delivery_date" field_name="Дата поставки" v-slot="{ accessData }" >
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата поставки *</v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.delivery_date) || '-' }}
					  <v-tooltip top v-if="auction.id > 0 && item.deliv_interval < 4">
					    <template v-slot:activator="{ on }">
						  <v-icon size="18" color="orange" v-on="on">mdi-truck-fast</v-icon>
					    </template>
					    <span class="caption">Менее 3-х дней на доставку</span>
					  </v-tooltip>
					</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn :disabled="item.over_date == undefined" color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Дата поставки', val: 'delivery_date', type: 'date', min_date: addDateInterval(item.over_date) })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="delivery_condition" field_name="Условия поставки" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия поставки *</v-list-item-subtitle>
                    <p class="my-0" v-if="delivery_conditions.find(el => el.id == auction.delivery_condition) != undefined">{{ delivery_conditions.find(el => el.id == auction.delivery_condition).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Условия поставки', val: 'delivery_condition', type: 'select', options: delivery_conditions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

			  <FieldAccess :model="prefix+'auction'" field="delivery_region" field_name="Регион отгрузки" v-slot="{ accessData }" :style="auction.delivery_condition == 1 || auction.delivery_condition == 3? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Регион отгрузки *</v-list-item-subtitle>
                    <p class="my-0" v-if="delivery_regions.find(el => el.id == auction.delivery_region) != undefined">{{ delivery_regions.find(el => el.id == auction.delivery_region).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Регион отгрузки', val: 'delivery_region', type: 'select', options: delivery_regions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>



              <FieldAccess :model="prefix+'auction'" field="customer_warehouse_address" field_name="Адрес склада" v-slot="{ accessData }" :style="auction.delivery_condition == 1? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Адрес склада *</v-list-item-subtitle>
                    <p class="my-0">{{ item.customer_warehouse_address || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Адрес склада', val: 'customer_warehouse_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="payment_condition" field_name="Условия оплаты" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия оплаты *</v-list-item-subtitle>
                    <p class="my-0" v-if="payment_conditions.find(el => el.id == auction.payment_condition) != undefined">{{ payment_conditions.find(el => el.id == auction.payment_condition).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Условия оплаты', val: 'payment_condition', type: 'select', options: payment_conditions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="special_terms" field_name="Особые условия" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Особые условия</v-list-item-subtitle>
                    <p class="my-0">{{ item.special_terms || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Особые условия', val: 'special_terms', type: 'textarea' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <template v-if="!(auction.id > 0)">
                <FieldAccess :model="'auction'"  field="create" field_name="Создать" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                          depressed
                          color="success"
                          @click.stop="submitNew"
                          text
                          class="rounded-btn"
                          :loading="loading"
                        >
                          <v-icon left size="20">mdi-plus</v-icon>Добавить аукцион
                        </v-btn>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>

       
            </v-list>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>
      

        

       
        </v-flex>
      </v-layout>

   
    </v-container>  



    <v-dialog v-model="dialog" max-width="420px">
      <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
    </v-dialog>


    <v-dialog scrollable v-model="confirm_dialog" max-width="1185px">
      <confirmdialog v-if="confirm_dialog" :item="item" :type="confirm_type" @refresh="getItem" @close="confirm_dialog = false" />
    </v-dialog>

   
	<snackbar />
  </v-app>
</template>


<script>
import lang_menu from '../lang_menu'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import tabledialog from '../tabledialog'
import confirmdialog from '../confirmdialog'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton';

import rates from './rates'
import tabs from '../tabs'
import winner from '../winner'
import delivery_regions_data from '../constants/delivery_regions_data.js'
import payment_conditions_data from '../constants/payment_conditions_data.js'


export default {
	name: 'new_auction_card',

	data() {
		return {
      dialog: false,
      item: {
	  	  user: false,
        rate_type: 'free',
    		customer_inn: '',
    		customer_ogrn: '',
    		customer_bank_account: '',
    		customer_correspondent_account: '',
    		customer_bank_bik: '',
    		customer_warehouse_address: '',
    		supplier_inn: '',
    		supplier_ogrn: '',
    		supplier_bank_account: '',
    		supplier_correspondent_account: '',
    		supplier_bank_bik: '',
    		supplier_warehouse_address: '',
        cancel_reason: '',
        is_analog: 0,
        start_price: 0,
        user: {
          avatar: null,
        }
      },



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
      ogrn_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{13}([0-9]{2})?$/.test(v) || 'ОГРН/ОГРНИП введен неверно',
      ],
      account_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{20}$/.test(v) || 'Счет введен неверно',
      ],
      bik_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{9}$/.test(v) || 'БИК введен неверно',
      ],
      action_loading: false,
      rate_step_option: null,
      rate_type_options: [
        { id: 'free', title: 'Участники устанавливают цену произвольно' },
        { id: 'step', title: 'Участники устанавливают цену с фиксированным шагом' },
      ],
      cancel_dialog: false,
	  cancel_options: [
	  /*	'Нашел дешевле',
		'Не нравится / не удобно пользоваться ресурсом',
		'Нашел другой продукт',
		'Отпала потребность в препарате',*/
		'Другое'
	  ],
	  cancel_reason: false,
	  cancel_reason_other: '',
      close_dialog: false,
      prefix: '',
      file_loading: false,
      file: '',
      units: [
        { id: 'л.', title: 'Литр' },
        { id: 'кг.', title: 'Килограмм' },
      ],
      delivery_conditions: [
        { id: 1, title: 'Со склада поставщика' },
       /* { id: 2, title: 'Поставка на мой склад' },*/
        { id: 3, title: 'Транспортной компанией до терминала' },
      ],
      payment_conditions: payment_conditions_data.payment_conditions_data,

	  delivery_regions: delivery_regions_data.delivery_regions_data,

      download_loading: false,
      confirm_type: null,
      confirm_dialog: false,
	  title: false,
	  title_options: [], // this.getTitleOptions()
	  v_select_title_options: [],
    title_options2: [], // this.getTitleOptions2()
	  v_select_title_options2: [],
	  requisits_dialog: false,
	  valid: false,
	  requisits_of: false,
	  confirmation: false,
	  upload_dialog: false,
	  delete_contract_dialog: false,
	  delete_contract_file: '',
	  contractType: false,
      contractFiles: [],
      readers: [],

		}
	},

	props: {
 user_id: Number,
    new: Boolean,
    type: String,
	},	
	components: {
 FieldAccess,
    FieldAccessButton,
    FieldAccessReloginButton,
    editdialog,
    confirmdialog,
    snackbar,
    lang_menu,
    AdminPanel,
    DateLogger,
    tabledialog,
    tabs,
    rates,
    winner
	},

	mounted() {

		 this.getTitleOptions();
     this.getTitleOptions2();

      this.loading = true;
       this.$store.dispatch('GET_AUTH_USER', { id: this.user_id }).then(res => {
       this.getItem() ;
      });

      this.getUserInfo();       
	},
	created() {
   
	},
	methods: {

    //new 170522
    getUserInfo() {
      axios.post('/admin/users/get_info', { id: this.user_id }).then(res => {
        if (res.data.user.company_warehouse_address !== undefined) {
          this.item.customer_warehouse_address = res.data.user.company_warehouse_address 
        }
       })
    },

		
	confirm(val) {
      this.confirm_type = val
      this.confirm_dialog = true
  	  this.requisits_dialog = false
  	  this.confirmation = false
    },
	getTitleOptions() {
	  axios
	    .get("/admin/auction/get_title_options")
		.then(response => this.title_options = response.data)
	},
  getTitleOptions2() {
    let url = window.location.href;
    let id = url.split("/");
    id = id.pop();
    axios
	    .get("/admin/auction/get_title_options2/" + id)
		.then(response => this.title_options2 = response.data)
	},
    submitNew() {
      if (this.checkFields()) {
        this.new = false
        this.submitEdit()
      }
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


       submitEdit(confirmation) {
      var vm = this
      if (this.new == true) {
        this.auction = this.item
        this.dialog = false
        this.tabledialog = false
      }
      else {
        if (this.checkFields()) {
          this.new_flag = false
          this.loading = true
          this.item._lang = this.locale
          this.item.auction_user_id = this.user_id
          this.item.type = this.type
          if (this.item.field == undefined || this.item.field.type != 'file') {
            this.$store.dispatch('EDIT_AUCTION', { form: this.item, _lang: this.locale }).then(res => {
              this.deal_date = ''
              this.deal_time = ''
              this.dialog = false
              if (this.item_id > 0) {
				if (this.confirmation) {
            	  this.loading = true
            	  let params = {}
            	  params.id = this.item.id
            	  params.type = this.requisits_of
            	  params.user_id = this.auth_user.id
            	  this.$store.dispatch('CONFIRM_AUCTION_CONTRACT', params).then(res => {
            		this.$emit('refresh')
            		this.$emit('close')
            	  })
				  .finally(() => {
				  	this.loading = false
					this.requisits_dialog = false
					this.requisits_of = false
					this.confirmation = false
					this.getItem()
				  })
				}
				else { this.getItem() }
			  }
              else {
                if (res.auction.type == 'rise') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/auction/now/card/'+result.data.auction.id
                    })
                  }
                  else {
                    location.href = '/admin/auction/now/card/'+res.auction.id
                  }
                }
                else if (res.auction.type == 'drop') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/tender/now/card/'+result.data.auction.id
                    })
                  }
                  else {
                    location.href = '/admin/tender/now/card/'+res.auction.id
                  }
                }
              }
            })
            .finally(() => {
				this.loading = false
				this.requisits_dialog = false
				this.requisits_of = false
				this.confirmation = false
			})
          }
          else {
            let form = new FormData();
            form.append('file', this.item.file)
            form.append('id', this.item.id)
            this.$store.dispatch('EDIT_AUCTION_AVATAR', form).then(res => { this.getItem() })
            .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
          }
        }
        else {
          this.auction = this.item
          this.dialog = false
          this.tabledialog = false
		  this.requisits_dialog = false
		  this.requisits_of = false
        }
      }
    },
    

    getItem() {
      this.loading = true
      if (this.item_id > 0) {
        let params = {}
        params.id = this.item_id
        params._lang = this.locale
        params.user_id = this.user_id
        this.$store.dispatch('GET_AUCTION', params).then(res => {
          this.dialog = false
          this.action_dialog = false
          this.customerDialog = false
		  this.setMissedRequisits()
        })
        .finally(() => (this.loading = false))
      }
      else {
        this.auction.type = this.type
        this.prefix = 'new_'
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
	addDateInterval (dateval) {
      if (!dateval) return null
	  var date = new Date(dateval);
      date.setDate(date.getDate());
	  return (date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2))
	},
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.title == null) flag = false
        if (this.item.active_material == undefined) flag = false
        if (this.item.is_analog == undefined) flag = false
        if (this.item.start_price == 0) flag = false
        if (this.item.size == undefined) flag = false
        if (this.item.unit == undefined) flag = false
        if (this.item.over_date == undefined) flag = false
        if (this.item.delivery_date == undefined) flag = false
        if (this.item.delivery_condition == undefined) flag = false
        if ((this.item.delivery_condition == 2 || this.item.delivery_condition == 3) && this.item.delivery_region == undefined) flag = false
        if (this.item.payment_condition == undefined) flag = false
        if (this.item.delivery_condition == 2 && this.item.customer_warehouse_address == undefined) flag = false
        if (flag === false) {
          this.$store.commit('SET_SNACKBAR', { status: 1, text: "Заполните все обязательные поля"})
        }
        return flag
      }
      else {
        return true
      }
    },
    formatPrice(value) {
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '-' }
    },

	},
	watch: {
    dialog: function (val) {
      if (val == false) { this.item = Object.assign({}, this.auction) }
    },
    auction: function (val) {
      this.item = Object.assign({}, val)
      if (this.item.rate_step == null) this.rate_step_option = 'free'
      else if (this.item.rate_step == null) this.rate_step_option = 'step'
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
    },
	item: function (obj) {
	    this.item.active_material = false;
		if (obj.title === undefined) return
		for (var option of this.title_options) {
			if (option.title == obj.title) {
				this.item.active_material = option.active_material
				break
			}
		}
	},
	title_options: function (obj) {
		for (var option of obj) {
			this.v_select_title_options.push(option.title)
		}
	},
  title_options2: function (obj) {
		for (var option of obj) {
			this.v_select_title_options2.push(option.title)
		}
	},
	},
	computed: {
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
    auction: {
      get() { return this.$store.state.auction.item },
      set(val) { this.$store.state.auction.item = val }
    },
    locale: {
      get() { return this.$store.state.lang.lang },
    },
	}

}
</script>
<style>

</style>
