<template>
  <v-card color="transparent" flat>
  	  	<v-flex xs12 v-if="user_id == customer.user.id && customer.subscriptions.length > 0" class="mt-4">
       		<v-subheader v-html="__('customer.subscription.title')" class="grey lighten-5"></v-subheader>
        	<v-list nav subheader color="rgba(255,255,255,0.5)">
        	  	<v-list-item v-for="(item, i) in customer.subscriptions" :key="i">
        	  		<v-list-item-icon>
                  <span class="subtitle-1">{{formatPrice(item.price)}}</span>
                </v-list-item-icon>
        	  		<v-list-item-content>
        	  			<v-list-item-subtitle>
        	  				<span v-html="__('customer.subscription.subtitle')"></span> 
        	  				<b>{{item.number_of_paid_orderers}}</b>
        	  				<span v-html="__('customer.subscription.orderers')"></span>
        	  			</v-list-item-subtitle>
        	  			<v-list-item-subtitle>
        	  				Тип - {{formatType(item.type)}}
        	  			</v-list-item-subtitle>
        	  			<v-list-item-subtitle>
        	  				Квалификация - {{formatLvl(item.specialist_lvl)}}
        	  			</v-list-item-subtitle>
        	  		</v-list-item-content>
        	  		<v-list-item-action >
        	  			<v-dialog v-model="pay_dialog" persistent max-width="290">
        	  				<template v-slot:activator="{ on }">
        	  					<v-btn color="success" class="rounded-btn" small v-if="item.is_active == 0" v-on="on" @click.stop="pay(item)">Оплатить</v-btn>
        	  				</template>
        	  				<v-card>
        						<v-card-title class="headline">К оплате {{formatPrice(selectedItem.price)}}</v-card-title>
        						<v-card-text>Оплата абонемента</v-card-text>
        						<v-card-actions>
          							<v-spacer></v-spacer>
          							<v-btn color="primary" text @click="pay_dialog = false" v-html="__('buttons.cancel')" small></v-btn>
          							<v-btn color="primary" text @click="submitPay" v-html="__('buttons.submit')" small></v-btn>
        						</v-card-actions>
      						</v-card>
        	  			</v-dialog>
        	  			<template v-if="item.is_active == 1">
        	  				<span class="caption green--text">Активен</span>
        	  				<span>Осталось {{item.number_of_paid_orderers - item.number_of_completed_classes}} занятий</span>
        	  			</template>
        	  		</v-list-item-action>
        	  	</v-list-item>
  	  	  	</v-list>
  	  	</v-flex>
        <v-flex xs12 class="text-center">
          <FieldAccess model="customer" field="offer_subscription" :field_name="__('buttons.offer_subscription')" v-slot="{ accessData }">
            <v-card color="transparent" flat class="text-center mt-8">
              <v-menu offset-y top>
                <template v-slot:activator="{ on }">
                  <v-btn color="primary"  class="rounded-btn mx-1" v-on="on">
                  	<v-icon small left>mdi-brightness-percent</v-icon> <span v-html="__('buttons.offer_subscription')"></span>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item v-for="(item, i) in options" :key="i" @click.stop="selectOption(item)">
                    <v-list-item-content><v-list-item-title v-html="item.title"></v-list-item-title></v-list-item-content>
                    <v-list-item-action><v-icon small>mdi-plus</v-icon></v-list-item-action>
                  </v-list-item>
                </v-list>
              </v-menu>
              <FieldAccessButton :accessData="accessData" />
            </v-card>
          </FieldAccess>
        </v-flex>
        <FieldAccess model="customer" field="offer_subscription" :field_name="__('buttons.offer_subscription')" v-slot="{ accessData }">
        	<v-flex xs12 v-if="customer.subscriptions.length > 0">
       		<v-subheader v-html="__('customer.subscription.title')" class="grey lighten-5"></v-subheader>
        	<v-list nav subheader color="rgba(255,255,255,0.5)">
				<v-divider class="my-0"></v-divider>
        	  <v-list-item v-for="(item, i) in customer.subscriptions" :key="i">
        	  	<v-list-item-icon>
        	  		<span class="subtitle-1">{{formatPrice(item.price)}}</span>
        	  	</v-list-item-icon>
        	  	<v-list-item-content>
        	  		<v-list-item-subtitle>
        	  			<span v-html="__('customer.subscription.subtitle')"></span> 
        	  			<b>{{item.number_of_paid_orderers}}</b>
        	  			<span v-html="__('customer.subscription.orderers')"></span>
        	  		</v-list-item-subtitle>
        	  		<v-list-item-subtitle>
        	  			Тип - {{formatType(item.type)}}
        	  		</v-list-item-subtitle>
        	  		<v-list-item-subtitle>
        	  			Квалификация - {{formatLvl(item.specialist_lvl)}}
        	  		</v-list-item-subtitle>
        	  	</v-list-item-content>
        	  	<v-list-item-action >
        	  		<span class="caption red--text" v-if="item.is_active == 0">Не активен</span>
        	  		<span class="caption green--text d-flex" v-else><span class="d-none d-md-flex mx-1">Осталось</span> {{item.number_of_paid_orderers - item.number_of_completed_classes}} <span class="d-none d-md-flex mx-1">занятий</span></span>
                <v-tooltip  top>
                  <template v-slot:activator="{on}">
                    <v-btn color="primary" icon x-small @click.stop="selectItem(item)" v-on="on">
                      <v-icon small>mdi-settings</v-icon>
                    </v-btn>
                  </template>
                  <span class="caption">Настройки абонемента</span>
                </v-tooltip>
        	  		<v-tooltip 	top>
        	  			<template v-slot:activator="{on}">
        	  				<v-btn v-if="item.is_active == 0" color="grey darken-2" icon x-small @click.stop="delSubscription(item)" v-on="on">
        	  					<v-icon small>mdi-delete</v-icon>
        	  				</v-btn>
        	  			</template>
        	  			<span class="caption">Убрать предложение</span>
        	  		</v-tooltip>
        	  	</v-list-item-action>
        	  </v-list-item>
        	</v-list>
  			</v-flex>
        </FieldAccess>
        <v-dialog v-model="settingsDialog" max-width="380px" transition="dialog-transition">
          <v-card>
            <v-card-title primary-title>
              Настройки абонемента
            </v-card-title>
            <v-card-text>
              <v-checkbox v-model="selectedItem.is_multiple" label="Возможность использоать другими клиентами пользователя" :value="selectedItem.is_multiple"></v-checkbox>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn text small v-html="__('buttons.cancel')" @click.stop="settingsDialog = !settingsDialog"></v-btn>
              <v-btn text small v-html="__('buttons.submit')" @click.stop="submit" :loading="loading"></v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialog" persistent max-width="380px" transition="dialog-transition">
			<v-card>
				<v-card-title class="px-4">
				  {{selectedOption.title}}
				</v-card-title>
				<v-divider class="my-0"></v-divider>
				<v-list subheader>
					<v-subheader class="grey lighten-5 primary--text font-weight-medium" v-html="__('directory_person.specialist_level.junior')"></v-subheader>
					<v-divider class="my-0"></v-divider>
					<v-list-item v-for="(item, i) in pricelist.junior" :key="i" v-if="item.key > 1" @click.stop="setSubscription(item, 'junior')">
						<v-list-item-content>
					  <v-list-item-subtitle>
					  	<span v-html="__('customer.subscription.subtitle')"></span><b>{{item.key}}</b>
					  	<span v-html="__('customer.subscription.orderers')"></span></v-list-item-subtitle>
					  <v-list-item-title>{{item.price}}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</v-list>
				<v-divider class="my-0"></v-divider>
				<v-list subheader>
					<v-subheader class="grey lighten-5 primary--text font-weight-medium" v-html="__('directory_person.specialist_level.senior')"></v-subheader>
					<v-divider class="my-0"></v-divider>
					<v-list-item v-for="(item, i) in pricelist.senior" :key="i" v-if="item.key > 1" @click.stop="setSubscription(item, 'senior')">
						<v-list-item-content>
					  <v-list-item-subtitle>
					  	<span v-html="__('customer.subscription.subtitle')"></span><b>{{item.key}}</b>
					  	<span v-html="__('customer.subscription.orderers')"></span></v-list-item-subtitle>
					  <v-list-item-title>{{item.price}}</v-list-item-title>
						</v-list-item-content>
					  
					</v-list-item>
				</v-list>
				<v-divider class="my-0"></v-divider>
				<v-list subheader>
					<v-subheader class="grey lighten-5 primary--text font-weight-medium" v-html="__('directory_person.specialist_level.lead')"></v-subheader>
					<v-divider class="my-0"></v-divider>
					<v-list-item v-for="(item, i) in pricelist.lead" :key="i" v-if="item.key > 1" @click.stop="setSubscription(item, 'lead')">
						<v-list-item-content>
					  <v-list-item-subtitle>
					  	<span v-html="__('customer.subscription.subtitle')"></span><b>{{item.key}}</b>
					  	<span v-html="__('customer.subscription.orderers')"></span></v-list-item-subtitle>
					  <v-list-item-title>{{item.price}}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</v-list>
				<v-divider class="my-0"></v-divider>
				<v-card-actions>
				 	<v-spacer></v-spacer>
				 	<v-btn color="primary" small v-html="__('buttons.cancel')" text @click.stop="dialog = !dialog"></v-btn>
				</v-card-actions>
			</v-card>          
    </v-dialog>
  </v-card>
</template>


<script> 
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  name: 'customer_subscrition',
  data () {
    return {
      selectedOption: {},
      selectedItem: {},
      dialog: false,
      pay_dialog: false,
      settingsDialog: false,
      loading: false
    }
  },
  props: {
    user_id: Number,
    customer: Object,
  },
  components: { FieldAccessButton, FieldAccess  },
  mounted() {
    this.options.map(option => {
      if (option.title == option.text) {
        option.title = '<span class="no_translate">'+option.text+'</span>'
      }
    })
  },
  methods: {
    submit() {
      this.loading = true
      this.$store.dispatch('EDIT_CUSTOMER_SUBSCRIPTION', this.selectedItem).then(res => {
        this.loading = false
        this.$emit('refresh')
        this.settingsDialog = false
      })
    },
    selectItem(item) {
      this.selectedItem = Object.assign({}, item)
      if (this.selectedItem.is_multiple == 0) { this.selectedItem.is_multiple = false }
      if (this.selectedItem.is_multiple == 1) { this.selectedItem.is_multiple = true }
      this.settingsDialog = true
    },
  	submitPay() {
  		this.selectedItem.user_id = this.user_id
  		this.selectedItem.customer = this.customer
  		this.$store.dispatch('PAY_CUSTOMER_SUBSCRIPTION', this.selectedItem).then(res => {
  			this.$emit('refresh')
  			this.pay_dialog = false
  		})
  	},
  	pay(item) {
  		this.selectedItem = Object.assign({}, item)
  	},
  	delSubscription(item) {
  		this.$store.dispatch('DEL_CUSTOMER_SUBSCRIPTION', item).then(res => {
  			this.$emit('refresh')
  		})
  	},
  	setSubscription(item, val) {
  		item.customer_id = this.customer.id
  		item.specialist_lvl = val
  		item.type = this.selectedOption.id
  		this.$store.dispatch('ADD_CUSTOMER_SUBSCRIPTION', item).then(res => {
  			this.$emit('refresh')
  			this.dialog = false
  		})
  	},
    selectOption(item) {
      this.selectedOption = Object.assign({}, item)
      this.$store.dispatch('GET_SUBSCRIPTION_PRICE', this.selectedOption).then(res => {
        this.dialog = true
      })
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
	formatLvl(val) {
		let lvl = ''
		this.levels_options.map(item => {
			if (item.id == val) {
				lvl = item.title
			}
		})
		return lvl
	},
	formatType(val) {
		let type = ''
		this.options.map(item => {
			if (item.id == val) {
				type = item.title
			}
		})
		return type
	},
  },
  watch: {

  },
  computed: {
  	levels_options: {
      get() { return this.$store.state.directory_people.levels_options }
    },
  	specialist_levels: {
      get() { return this.$store.state.customers.specialist_levels }
    },
    options: {
      get() { return this.$store.state.customers.subscription_options }
    },
    pricelist: {
      get() { return this.$store.state.customers.pricelist }
    },
  },
};
</script>
