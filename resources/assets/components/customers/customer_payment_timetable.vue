<template>
  <v-card flat outlined class="mb-3">
    <v-card-title>
      График платежей
    </v-card-title>
    <v-divider class="my-0"></v-divider>
    <v-card color="#fdfdfd" tile flat>
      <v-list two-line class="py-0" color="#fdfdfd" v-if="item.pays.length > 0" dense>
       	<template v-for="(pay, i) in item.pays" > 
       	  <v-list-item :key="i">
       	    <v-list-item-avatar color="primary" class="my-auto" size="24" style="border-radius: 50% !important;">
       	      <span class="white--text">{{i+1}}</span>
       	    </v-list-item-avatar>
       	    <v-list-item-content>
       	      <v-list-item-title class="font-weight-bold">
       	      	{{formatPrice(pay.amount)}} <v-icon size="14" right color="grey darken-3">mdi-currency-rub</v-icon>
       	      </v-list-item-title>
       	      <v-list-item-subtitle>
                <template v-if="pay.is_paid == 0">
                  <span class="red--text caption" v-if="pay.income == 0">Не оплачено</span>
                  <span class="grey--text caption" v-else>Оплачено {{pay.income}}</span>
                </template>
       	      	<span class="green--text caption" v-if="pay.is_paid == 1">Оплачено</span>
       	      </v-list-item-subtitle>
       	      <v-list-item-subtitle>Оплатить до {{formatDate(pay.date)}} </v-list-item-subtitle>
       	    </v-list-item-content>
       	    <v-list-item-icon>
       	    	<v-tooltip top>
       	    	 	<template v-slot:activator="{ on }">
       	    	 		<v-btn 
       	     				color="red" 
       	     				v-if="pay.is_paid == 0 && pay.income == 0"
       	     				icon
       	     				small
       	     				v-on="on"
       	     				@click.stop="editPay(pay)"
       	     			>
       	     				<v-icon size="18">mdi-sync</v-icon>
       	     			</v-btn>
       	    	 	</template>
       	    	 	<span class="caption" v-html="__('buttons.edit')"></span>
       	    	</v-tooltip>
       	    </v-list-item-icon>
       	  </v-list-item>
       	  <v-divider class="my-0" v-if="i != item.pays.length - 1"></v-divider>
       	</template>
      </v-list>
      <v-card-text class="text-center font-weight-light grey--text" v-else>
        Не установлен
      </v-card-text>
      <v-divider class="my-0"></v-divider>
      <v-list color="transparent" subheader>
      	<template v-if="item.pays.length > 0">
          <FieldAccess model="customer_group" field="add_pay" field_name="Добавить платеж от клиента" v-slot="{ accessData }">
            <v-list-item dense class="text-center pt-2" style="min-height: 52px;">
              <v-list-item-content>
                <v-list-item-title>
                  <v-btn color="green lighten-1" dark depressed class="rounded-btn" @click.stop="add_dialog = !add_dialog">
                    <v-icon left>mdi-wallet-plus-outline</v-icon> 
                    <span>Добавить платеж от клиента </span>
                  </v-btn>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon class="ml-2 my-auto">
                <FieldAccessButton :accessData="accessData" />
              </v-list-item-icon>
            </v-list-item>
          </FieldAccess>
        	<FieldAccess model="customer_group" field="edit_payment_timetable" field_name="Назначить график платежей" v-slot="{ accessData }">
      			<v-list-item dense class="text-center" style="min-height: 52px;">
        	    	<v-list-item-content>
        	    	  <v-list-item-title>
        	    	    <v-btn color="red lighten-1" dark depressed class="rounded-btn" @click.stop="clear_dialog = !clear_dialog">
        	    	      <v-icon left>mdi-cancel</v-icon> 
        	    	      <span>Очистить</span>
        	    	    </v-btn>
        	    	  </v-list-item-title>
        	    	</v-list-item-content>
        	    	<v-list-item-icon class="ml-2 my-auto">
        	      		<FieldAccessButton :accessData="accessData" />
        	    	</v-list-item-icon>
        	  	</v-list-item>
        	</FieldAccess>
      	</template>
      	<template v-else>
        	<FieldAccess model="customer_group" field="edit_payment_timetable" field_name="Назначить график платежей" v-slot="{ accessData }">
        	  <v-list-item dense class="text-center pt-2" style="min-height: 52px;">
        	    <v-list-item-content>
        	      <v-list-item-title>
        	        <v-btn color="green lighten-1" dark depressed class="rounded-btn" @click.stop="dialog = !dialog">
        	          <v-icon left>mdi-wallet-plus-outline</v-icon> 
        	          <span>Назначить график</span>
        	        </v-btn>
        	      </v-list-item-title>
        	    </v-list-item-content>
        	    <v-list-item-icon class="ml-2 my-auto">
        	      <FieldAccessButton :accessData="accessData" />
        	    </v-list-item-icon>
        	  </v-list-item>
        	</FieldAccess>
      	</template>
        
      </v-list>
    </v-card>
    <v-dialog v-model="dialog" max-width="420" scrollable>
      <v-card flat tile>
        <v-divider class="my-0"></v-divider>
        <v-stepper v-model="pay_step" vertical>
          <v-card-title primary-title>
            График платежей
            <v-spacer></v-spacer>
            <v-btn color="grey darken-1" icon small @click.stop="dialog = false"><v-icon size="18">mdi-close</v-icon></v-btn>
          </v-card-title>   
          <v-stepper-step :complete="pay_step > 1" step="1">
            Введите полную стоимость
            <small>Сумма всех платежей</small>
          </v-stepper-step>
          <v-stepper-content step="1">
            <v-card flat color="transparent" class="mb-3">
              <v-text-field
                solo
                flat
                label="Общая сумма"
                v-model="dogovor.price"
                type="number"
                backgroundColor="#fdfdfd"
                class="mb-4"
                hide-details
              ></v-text-field>
            </v-card>
            <v-btn
              color="success"
              @click="pay_step = 2"
            >
              Далее
            </v-btn>
          </v-stepper-content>


          <v-stepper-step :complete="pay_step > 2" step="2">
            Выберите сценарий
            <small>Сценарии платежей</small>
          </v-stepper-step>
          <v-stepper-content step="2" class="py-2">
            <v-card flat color="transparent" class="mb-3">
              <v-list flat dense nav >
                <v-list-item v-for="(item, i) in payment_types" @click.stop="selectPayment(item)" :key="i">
                  <v-list-item-icon class="mr-4">
                    <v-icon v-html="dogovor.payment.id == item.id ? 'mdi-check-box-outline' : 'mdi-checkbox-blank-outline'"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>{{item.text}}</v-list-item-title>
                    <v-list-item-subtitle>{{item.description}}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
              <v-text-field
                label="Первый платеж"
                v-model="dogovor.first_price"
                type="number"
                solo
                flat
                v-if="dogovor.payment.id == 3"
                class="mb-4"
                backgroundColor="#fdfdfd"
                hide-details
              ></v-text-field>
            </v-card>
            <v-btn
              v-if="dogovor.payment.id > 2"
              color="success"
              @click="thirdStep"
              class="mr-2"
            >
              Далее
            </v-btn>
            <v-btn
              color="primary"
              @click="pay_step = 1"
              text
            >
              Назад
            </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="pay_step > 3" step="3">
            График платежей
            <small>Итоговый график</small>
          </v-stepper-step>
          <v-stepper-content step="3" class="py-2">
            <v-card flat color="#fdfdfd" outlined class="mb-3">
              <v-list dense style="border-radius: 4px !important;">
                <v-list-item v-for="(item, i) in dogovor.pays" two-line :key="i">
                  <v-list-item-avatar size="24" color="grey lighten-5">
                    <span v-html="i+1"></span>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>До {{formatDate(item.date_to)}}</v-list-item-subtitle>
                    <v-list-item-title>{{formatPrice(item.price)}} <v-icon size="14">mdi-currency-rub</v-icon></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card>
            <v-btn
              color="primary"
              @click="pay_step = 2"
              text
            >
              Назад
            </v-btn>
          </v-stepper-content>
        </v-stepper>


        <!-- <v-card-text class="pt-4" style="max-height: 70vh; background: #fdfdfd;">
          <v-text-field
            solo
            flat
            label="Общая сумма"
            v-model="dogovor.price"
            append-icon="mdi-check"
            @click:append="selectPayment(dogovor.payment)"
            type="number"
            v-if="dogovor.payment.id != 4"
          ></v-text-field>
          <v-text-field
            label="Первый платеж"
            v-model="dogovor.first_price"
            type="number"
            append-icon="mdi-check"
            @click:append="selectPayment(dogovor.payment)"
            solo
            flat
            v-if="dogovor.payment.id == 3"
          ></v-text-field>
          <template v-if="dogovor.payment != undefined && !(dogovor.payment.id > 0)">
          	<v-card flat outlined style="border-radius: 4px !important;">
            	<v-list dense nav style="border-radius: 4px !important;">
            	  <v-list-item v-for="(item, i) in payment_types" @click.stop="selectPayment(item)" :key="i">
            	    <v-list-item-content>
            	      <v-list-item-title>{{item.text}}</v-list-item-title>
            	      <v-list-item-subtitle>{{item.description}}</v-list-item-subtitle>
            	    </v-list-item-content>
            	  </v-list-item>
            	</v-list>
          	</v-card>
          </template>
          <template v-if="dogovor.payment != undefined && dogovor.payment.id > 0">
          	<v-card flat outlined style="border-radius: 4px !important;" v-if="dogovor.payment.id != 4">
            	<v-list dense style="border-radius: 4px !important;">
            	  <v-list-item v-for="(item, i) in dogovor.pays" two-line :key="i">
            	    <v-list-item-avatar size="24" color="grey lighten-5">
            	      <span v-html="i+1"></span>
            	    </v-list-item-avatar>
            	    <v-list-item-content>
            	      <v-list-item-subtitle>До {{formatDate(item.date_to)}}</v-list-item-subtitle>
            	      <v-list-item-title>{{formatPrice(item.price)}} <v-icon size="14">mdi-currency-rub</v-icon></v-list-item-title>
            	    </v-list-item-content>
            	  </v-list-item>
            	</v-list>
          	</v-card>
          	<v-card flat outlined style="border-radius: 4px !important;" v-else>
          	 
          	</v-card>
          	<v-btn color="grey lighten-4" depressed class="mt-3" @click.stop="unsetDogovor">Назад</v-btn>
          </template>
          <template v-if="dogovor.payment != undefined && dogovor.payment.id == 4">

          </template>
        </v-card-text> 
        <v-divider class="my-0"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="dialog = false">Отмена</v-btn>
          <v-btn color="primary" text @click.stop="submit" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>     -->
      </v-card>      
    </v-dialog>
    <v-dialog v-model="clear_dialog" max-width="420" >
    	<v-card>
    		<v-card-title>Очистить</v-card-title>
    	 	<v-card-text>
    	 		Вы действительно хотите очистить график платежей клиента?
    	 	</v-card-text>
    	 	<v-card-actions>
    	 	 	<v-spacer></v-spacer>
    	 	 	<v-btn color="primary" text @click.stop="clear_dialog = false">Отменить</v-btn>
    	 	 	<v-btn color="primary" text @click.stop="submitClear" :loading="loading">Подтвердить</v-btn>
    	 	</v-card-actions>
    	</v-card>
    </v-dialog>
    <v-dialog v-model="edit_dialog" max-width="420">
		  <v-card color="#fafafa">
		  	<v-card-title class="py-4">
		  	  Изменить информацию о платеже
		  	</v-card-title>
		      <v-card-text>
		       	<v-text-field
		       	  solo
              flat
              dense
              type="date"
              v-model="selectedPay.date"
		       	></v-text-field>
		       	<v-text-field
		       	  solo
              flat
              dense
              type="number"
              v-model="selectedPay.amount"
		       	>
		       		<template v-slot:append>
		       			<v-icon size="18" color="black">mdi-currency-rub</v-icon>
		       		</template>
		       	</v-text-field>
		      </v-card-text>
		      <v-card-actions>
		      	<v-spacer></v-spacer>
		      	<v-btn color="primary" text @click.stop="edit_dialog = false">Отменить</v-btn>
      	 	 	<v-btn color="primary" text @click.stop="submitEdit" :loading="loading">Подтвердить</v-btn>
		      </v-card-actions>
		  </v-card>      
    </v-dialog>
    <v-dialog v-model="add_dialog" max-width="420">
      <v-card color="#fafafa">
        <v-card-title class="py-4">Добавить платеж от клиента</v-card-title>
        <v-card-text>
          <v-select
              solo
              flat
              dense
              :items="pay_types"
              item-text="text"
              item-value="id"
              label="Вариант оплаты"
              v-model="pay.payment_option"
            ></v-select>
            <v-text-field
              solo
              flat
              dense
              type="number"
              label="Сумма платежа"
              v-model="pay.amount"
            >
              <template v-slot:append>
                <v-icon size="18" color="black">mdi-currency-rub</v-icon>
              </template>
            </v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="add_dialog = false">Отмена</v-btn>
          <v-btn color="primary" text @click.stop="submitAdd" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  props: {
    item: Object,
  },
  data: () => ({
    dialog: false,
    loading: false,
    payment_types: [
      { id: 1, text: 'Сценарий 1', description: 'Равные платежи' },
      { id: 2, text: 'Сценарий 2', description: 'Первый платеж - 50%, вторая половина делится на равные платежи' },
      { id: 3, text: 'Сценарий 3', description: 'Равные платежи, первый платеж делится на два' },
      { id: 4, text: 'Сценарий 4', description: 'Задать вручную' },
    ],
    dogovor: {
      price: 0,
      payment: {},
      pays: [],
    },
    clear_dialog: false,
    selectedPay: {
    	date_to: '',
    	amount: 0,
    },
    edit_dialog: false,
    add_dialog: false,
    pay_types: [
      { id: 1, text: 'Наличные' },
      { id: 2, text: 'Перевод на карту' },
      { id: 3, text: 'Перевод на расчетный счет' },
    ],
    pay: {
      type: 0,
    },
    pay_step: 1,
  }),
  components: { FieldAccess, FieldAccessButton },
  methods: {
    thirdStep() {
      if (this.dogovor.first_price > 0) {
        this.pay_step = 3
      }
      else {

      }
    },
    submitAdd() {
      this.loading = true
      this.pay.customer_id = this.item.id
      this.$store.dispatch('ADD_CUSTOMER_PAY', this.pay).then(res => {
        this.add_dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.loading = false))
    },
  	submitEdit() {
  		this.loading = true
  		this.$store.dispatch('EDIT_CUSTOMER_PAYTABLE', this.selectedPay).then(res => {
  			this.edit_dialog = false
  			this.$emit('refresh')
  		})
    	.finally(() => (this.loading = false))
  	},
  	editPay(pay) {
  		this.selectedPay = Object.assign({}, pay)
  		this.edit_dialog = true
  	},
  	submitClear() {
  		this.loading = true
  		let params = {}
  		params.customer_id = this.item.id
  		this.$store.dispatch('CLEAR_CUSTOMER_PAYTABLE', params).then(res => {
  			this.clear_dialog = false
  			this.$emit('refresh')
  		})
    	.finally(() => (this.loading = false))
  	},
    unsetDogovor() {
      this.dogovor.first_price = ''
      this.dogovor.pays = []
      this.dogovor.payment = {}
    },
    formatDate(date) {
      if (!date) { return }
      else {
        const [ year, month, day ] = date.split('-')
        return day+'/'+month+'/'+year
      }
    },
    formatPrice(value) {
      let val = (value/1).toFixed(2)
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
    selectPayment(item) {
      	this.dogovor.pays = []
      	this.dogovor.payment = Object.assign({}, item)
      	// Если сценарий 1
     	  if (item.id == 1) {
     	    let piece = this.dogovor.price/7
     	    this.item.group.orderers.map((order, i) => {
     	      if (i % 4 == 0) {
     	        let pay = {}
     	        pay.date_to = order.date
     	        pay.price = piece
     	        this.dogovor.pays.push(pay)
     	      }
     	    })
          this.pay_step = 3
     	  }
      	// Если сценарий 2
      	if (item.id == 2) {
      	  	let first_price = this.dogovor.price/2
      	  	let price = first_price/6
      	  	this.item.group.orderers.map((order, i) => {
      	  	  if (i % 4 == 0) {
      	  	    let pay = {}
      	  	    if (i == 0) pay.price = first_price
      	  	    else pay.price = price
      	  	    pay.date_to = order.date
      	  	    this.dogovor.pays.push(pay)
      	  	  }
      	  	})
          this.pay_step = 3
      	}
      	// Если сценарий 3
      	if (item.id == 3) {
      	  	/*if (this.dogovor.first_price > 0) {
      	  		let piece = this.dogovor.price/7
      	  		let second_price = piece - this.dogovor.first_price
      	  		this.item.group.orderers.map((order, i) => {
      	  		  if (i % 4 == 0) {
      	  		    if (i == 0) {
      	  		      let pay = {}
      	  		      pay.price = this.dogovor.first_price
      	  		      pay.date_to = order.date
      	  		      let pay2 = {}
      	  		      pay2.price = second_price
      	  		      pay2.date_to = order.date
      	  		      this.dogovor.pays.push(pay)
      	  		      this.dogovor.pays.push(pay2)
      	  		    } 
      	  		    else {
      	  		      let pay = {}
      	  		      pay.price = piece
      	  		      pay.date_to = order.date
      	  		      this.dogovor.pays.push(pay)
      	  		    }
      	  		  }
      	  		})
      	  	}*/
      	}
      	// Если сценарий 4
      	if (item.id == 4) {
			
      	}
    },
    submit() {
    	this.loading = true
    	let params = {}
    	params.price = this.dogovor.price
    	params.pays = this.dogovor.pays
    	params.customer_id = this.item.id
    	this.$store.dispatch('ADD_CUSTOMER_PAYTABLE', params).then(res => {
    		this.$emit('refresh')
    		this.dialog = false
    	})
    	.finally(() => (this.loading = false))
    },
  },
  computed: {

  }
};
</script>
