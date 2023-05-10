import actions from './actions'
import mutations from './mutations'

const state = {
  items: [],
  item: {},
  table_headers: [
    { id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, width: 40, align: 'center'  },
    { id: 1, text: __('directory_firm.full_name'), title: 'directory_firm.full_name',  value: 'full_name' },
    { id: 2, text: __('directory_firm.metro'), title: 'directory_firm.metro', value: 'main_metro', class: 'd-none d-lg-table-cell' },
    { id: 3, text: __('directory_firm.phone'), title: 'directory_firm.phone', value: 'main_phone', class: 'd-none d-md-table-cell' },
    { id: 4, text: __('directory_firm.email'), title: 'directory_firm.main_email', value: 'main_email', class: 'd-none d-md-table-cell' },
  ],  
  busy_times: [],
  busy_calendar_times: [],
};

export default {
  state,
  actions,
  mutations
};
