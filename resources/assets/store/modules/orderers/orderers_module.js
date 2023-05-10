import actions from './actions'
import mutations from './mutations'

const state = {
	items: [],
	item: {
    customer: null,
    directory_person: null,
    directory_firm: null,
    additional_place: null
  },
	table_headers: [
    { id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, align: 'center'  },
    { id: 1, text: __('orderer.date_time'), title: 'orderer.date_time', value: 'date_time' },
		{ id: 1, text: __('orderer.status'), title: 'orderer.status', value: 'status' },
    { id: 2, text: __('orderer.customer'), title: 'orderer.customer', value: 'customer.full_name', class: 'd-none d-md-table-cell'  },
    { id: 3, text: __('orderer.directory_person'), title: 'orderer.directory_person', value: 'directory_person.full_name', class: 'd-none d-md-table-cell' },
    { id: 4, text: __('orderer.directory_firm'), title: 'orderer.directory_firm', value: 'directory_firm.full_name', class: 'd-none d-md-table-cell' },
    { id: 5, text: __('orderer.price'), title: 'orderer.price', value: 'price', class: 'd-none d-md-table-cell' },
    { id: 6, text: __('orderer.directory_person_amount'), title: 'orderer.directory_person_amount', value: 'directory_person_amount', class: 'd-none d-md-table-cell' },
    { id: 7, text: __('orderer.directory_firm_amount'), title: 'orderer.directory_firm_amount', value: 'directory_firm_amount', class: 'd-none d-md-table-cell' },
	],	
	profile_card_fields: [
		{ text: 'Статус', val: 'status', type: 'select', options: [ { id: '1', title: 'Запланировано' }, { id: '2', title: 'Перенесено' }, { id: '3', title: 'Завершено' }, { id: '4', title: 'Отменено' } ] },
    { text: 'Дата', val: 'date', type: 'text' },
    { text: 'Время', val: 'time', type: 'text', mask: '##:##' },
    { text: 'Сумма', val: 'price', type: 'text' },
    { text: 'Преподавателю', val: 'directory_person_amount', type: 'text' },
    { text: 'Помещению', val: 'directory_firm_amount', type: 'text' },
	],
  status_options: [
    { id: '1', name: __('orderer.planed_status'), color_calendar: '#ff9800', title: __('orderer.planed_status'), text: 'orderer.planed_status' },
    { id: '2', name: __('orderer.transfer_status'), color_calendar: '#00ff99', title: __('orderer.transfer_status'), text: 'orderer.transfer_status' },
    { id: '3', name: __('orderer.complete_status'), color_calendar: '#008800', title: __('orderer.complete_status'), text: 'orderer.complete_status' },
    { id: '4', name: __('orderer.cancel_status'), color_calendar: '#dddddd', title: __('orderer.cancel_status'), text: 'orderer.cancel_status' },
  ],
  additional_places: [],
  statuses: [],
};

export default {
  state,
  actions,
  mutations
};
