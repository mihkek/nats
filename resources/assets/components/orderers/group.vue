<template>
	<v-card flat outlined v-if="item.group != undefined">
	    <v-card-title>
	    	Группа
	    	<v-spacer></v-spacer>
      		<span v-if="item.customers != undefined">({{item.group.customers.length}})</span>
	    </v-card-title>
	    <v-card-text>
	    	<v-text-field
	    	  	label="Поиск"
	    	  	v-model="search"
	    	  	solo
	    	  	flat
	    	  	backgroundColor="#fdfdfd"
	    	  	hide-details
	    	></v-text-field>
	    	<v-data-table
      			:headers="headers"
      			:items="item.group.customers"
      			:search="search"
      			hide-default-footer
      			hide-default-header
    		>
    			<template v-slot:body="{items}">
    				<v-list two-line>
	    				<template v-for="(customer, index) in items">
        					<v-list-item
        					  	:key="customer.id"
        					  	three-line
        					  	:href="'/admin/customer/list/card/'+customer.id"
        					  	target="_blank"
        					  	style="text-decoration: none !important;"
        					>
          						<v-list-item-avatar>
          						  <v-img :src="'/storage/avatars/50x50.'+customer.avatar" v-if="customer.avatar != null"></v-img>
          						  <v-img src="/storage/avatars/50x50.nophoto.png" v-else></v-img>
          						</v-list-item-avatar>
        						<v-list-item-content>
        						  <v-list-item-title v-html="customer.child_full_name"></v-list-item-title>
        						  <v-list-item-subtitle>
        						    <span v-html="customer.main_phone"></span> &mdash; <span class="caption" v-html="'Родственник - '+customer.full_name"></span>.
        						  </v-list-item-subtitle>
        						</v-list-item-content>
       							<v-list-item-action >
       							  <v-btn 
       							  	:color="customer.orderer_mark ? 'green' : 'grey'" 
       							  	icon 
       							  	:loading="load == customer.id"
       							  	small 
       							  	@click.prevent="load > 0 ? '' : markCustomer(customer)"
       							  >
       							  	<v-icon size="18" v-html="customer.orderer_mark ? 'mdi-checkbox-marked-outline' : 'mdi-checkbox-blank-outline'">
       							  		
       							  	</v-icon>
       							  </v-btn>
       							</v-list-item-action>
        					</v-list-item>
        					<v-divider class="my-0" v-if="index != item.group.customers.length-1"></v-divider>
      					</template>
	    			</v-list>
    			</template>
    		</v-data-table>
	    	
	    </v-card-text>
	</v-card>      
</template>

<script> 
import { mask } from 'vue-the-mask'
import tabledialog from '../tabledialog'


export default {
  name: 'orderer_group',
  data () {
    return {
      search: '',
      load: 0,
      headers: [
      	{ value: 'child_full_name', text: 'Имя' }
      ]
    }
  },
  components: {
    tabledialog
  },
  props: {
    item: Object,
  },
  methods: {
  	markCustomer(customer) {
  		this.load = customer.id
  		customer.order_id = this.item.id
  		this.$store.dispatch('MARK_ORDER_CUSTOMER', customer).then(res => {
  			this.$emit('refresh')
  		})
  		.finally(() => (this.load = 0))
  	},
    formatTime(val) {
      if (val != undefined) { return val.slice(0,2) + ':' + val.slice(-2) }
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
  },
  mounted() {
  },
  watch: {
  },
  computed: {
    locale: {
      get() { return this.$store.state.lang.lang }
    },
  },
  directives: {  mask },
};
</script>
