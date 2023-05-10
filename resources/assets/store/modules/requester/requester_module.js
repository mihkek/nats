import actions from './actions'
import mutations from './mutations'

const state = {
	items: [],
	item: {},
    notifications: {},
	table_headers: [
        { id: 0, text: '', value: 'expanded', class: 'px-2', sortable: false, align: 'center', width: 40 },
        { id: 1, text: __('requester.created_at'), title: 'requester.created_at', value: 'created_at', class: 'px-2', width: 120 },
        { id: 3, text: __('requester.opc'), title: 'requester.opc', value: 'promoter.full_name', class: 'px-2', align: 'center', width: 80 },
        { id: 4, text: __('requester.customer'), title: 'requester.customer', value: 'customer_full_name', class: 'px-2', width: 140 },
        { id: 5, text: __('requester.customer_child'), title: 'requester.customer_child', value: 'customer_child_full_name', class: 'px-2', width: 120 },
        { id: 6, text: __('requester.age'), title: 'requester.age', value: 'customer_age', class: 'px-2', width: 100 },
        { id: 7, text: __('requester.status'), title: 'requester.status', value: 'status', class: 'px-2', width: 130 },
        { id: 8, text: __('requester.deal'), title: 'requester.deal', value: 'deal_date', class: 'px-2', width: 130 },
        { id: 9, text: __('requester.contacts'), title: 'requester.contacts', value: 'customer_main_phone_formated', class: 'px-2', width: 140 },
        { id: 9, text: __('requester.user'), title: 'requester.user', value: 'user.full_name', class: 'px-2', width: 140 },
        
        /*{ id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, align: 'center'  },
	   	{ id: 1, text: __('requester.date'), title: 'requester.date', value: 'created' },
        { id: 2, text: __('requester.status'), title: 'requester.status', value: 'status' },
        { id: 3, text: __('requester.customer'), title: 'requester.customer', value: 'customer.first_name', class: 'd-none d-md-table-cell' },
        { id: 3, text: __('requester.customer_child'), title: 'requester.customer_child', value: 'customer.child_first_name', class: 'd-none d-md-table-cell' },
        { id: 4, text: __('requester.contacts'), title: 'requester.contacts', value: 'customer.main_phone', class: 'd-none d-md-table-cell' },
        { id: 4, text: __('requester.comment'), title: 'requester.comment', value: 'main_comment', class: 'd-none d-md-table-cell' },*/
	],	
    status_options: [
        { id: '1', title: __('requester.new_status'), text: 'requester.new_status', color_calendar: 'cyan', icon: 'mdi-plus-circle-outline',  }, // Новый
        { id: '2', title: __('requester.call_status'), text: 'requester.call_status', color_calendar: 'pink', icon: 'mdi-phone-outgoing', type: 'deal' }, // Перезвонить
        { id: '3', title: __('requester.not_available'), text: 'requester.not_available', color_calendar: 'amber', icon: 'mdi-phone-missed', type: 'deal' }, //Недоступен
        { id: '4', title: __('requester.not_answer'), text: 'requester.not_answer', color_calendar: 'blue-grey', icon: 'mdi-phone-hangup', type: 'deal' }, //Не отвечает
        { id: '5', title: __('requester.cancel_status'), text: 'requester.cancel_status', color_calendar: 'red', icon: 'mdi-cancel' }, //Отказ
        { id: '6', title: __('requester.complete_status'), text: 'requester.complete_status', color_calendar: 'success', icon: 'mdi-file-document-box-check', type: 'order' }, // Запись
        { id: '7', title: __('requester.deal_status'), text: 'requester.deal_status', color_calendar: 'purple', icon: 'mdi-check-circle-outline', type: 'order', show: false }, // Запись
        { id: '-1', title: __('requester.false_status'), text: 'requester.false_status', color_calendar: 'grey', icon: 'mdi-close-circle' }, // Ложная
        /*{ id: '3', title: __('requester.cancel_status'), text: 'requester.call_status', color_calendar: '#03A9F4' },
        { id: '4', title: __('requester.put_status'), text: 'requester.put_status', color_calendar: '#FF9800' },
        { id: '5', title: __('requester.cancel_status'), text: 'requester.cancel_status', color_calendar: '#8BC34A' },
        { id: '6', title: __('requester.complete_status'), text: 'requester.complete_status', color_calendar: '#009688' },*/
  ],
  report: {}
};

export default {
  state,
  actions,
  mutations
};
