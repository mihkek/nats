import actions from './actions'
import mutations from './mutations'

const state = {
	items: [],
	item: {},
	directory_person_users: [],
	directory_firm_users: [],
	customer_users: [],
  company_users: [],
  directory_users: [],
  managers: [],
  company_user_headers: [
  	{ id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, width: 40, align: 'center'  },
  	{ id: 1, text: __('user.full_name') || 'user.full_name', value: 'full_name' },
  	{ id: 2, text: __('user.phone') || 'user.phone', value: 'phone', class: 'd-none d-md-table-cell'},
  	{ id: 3, text: __('user.email') || 'user.email', value: 'email', class: 'd-none d-md-table-cell'},
  ],
};

export default {
  state,
  actions,
  mutations
};
