import actions from './actions'
import mutations from './mutations'

const state = {
  lang: __('directory_person.full_name'),
  items: [],
  item: {},
  table_headers: [
      { id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, width: 40, align: 'center'  },
      { id: 1, text: __('directory_person.full_name'), title: 'directory_person.full_name', value: 'full_name' },
      { id: 2, text: __('directory_person.latest_lesson'), title: 'directory_person.latest_lesson', value: 'last_orderer.format_date_time', class: 'd-none d-lg-table-cell'},
      { id: 3, text: __('directory_person.phone'), title: 'directory_person.phone', value: 'main_phone', class: 'd-none d-md-table-cell'},
      { id: 4, text: __('directory_person.email'), title: 'directory_person.email', value: 'main_email', class: 'd-none d-md-table-cell'},
  ],  
  profile_card_fields: [
    { text: 'Полное имя', val: 'full_name', type: 'title' },
    { text: 'Фотография', val: 'profile_photo', type: 'file' },
    { text: 'Город', val: 'main_city', type: 'text' },
    { text: 'Метро', val: 'main_metro', type: 'text' },
    { text: 'Адрес', val: 'main_address', type: 'text', href: 'https://yandex.ru/maps/?ll=37.618174%2C55.754998&mode=search&text=', href_icon: 'mdi-web' },
    { text: 'Телефон', val: 'main_phone', type: 'text', rules: [], mask: '+7 (###) ###-##-##', href: 'callto:', href_icon: 'mdi-phone-outgoing' },
    { text: 'Email', val: 'main_email', type: 'text', rules: [], href: 'mailto:', href_icon: 'mdi-email-outline' },
    { text: 'Район работы', val: 'work_location', type: 'text', rules: [] },
  ],
  levels_options: [
    { id: 'junior', text: 'directory_person.specialist_level.junior', title: __('directory_person.specialist_level.junior') },
    { id: 'senior', text: 'directory_person.specialist_level.senior', title: __('directory_person.specialist_level.senior') },
    { id: 'lead', text: 'directory_person.specialist_level.lead', title: __('directory_person.specialist_level.lead') },
  ],
  busy_times: [],
  busy_calendar_times: [],
};

export default {
  state,
  actions,
  mutations
};
