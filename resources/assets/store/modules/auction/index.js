import actions from './actions'
import mutations from './mutations'

const state = {
	auctions: [],
  tenders: [],
  sales: [],
  items: [],
	item: {},
  rates: [],
  status_options: [
    { id: 1, title: 'Активный', color_calendar: 'success' },
    { id: 2, title: 'Завершен', color_calendar: 'teal' },
    { id: 0, title: 'Отменен', color_calendar: 'red' },
  ]
};

export default {
  state,
  actions,
  mutations
};
