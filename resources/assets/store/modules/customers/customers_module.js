import actions from './actions'
import mutations from './mutations'

const state = {
  items: [],
  item: {},
  table_headers: [
    { id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, width: 40, align: 'center'  },
    { id: 1, text: __('customer.full_name'), title: 'customer.full_name', value: 'full_name' },
    { id: 2, text: __('customer.city'), title: 'customer.city', value: 'main_city', class: "d-none d-lg-table-cell" },
    { id: 3, text: __('customer.metro'), title: 'customer.metro', value: 'main_metro', class: "d-none d-lg-table-cell" },
    { id: 4, text: __('customer.phone'), title: 'customer.phone', value: 'main_phone', class: "d-none d-md-table-cell" },
    { id: 5, text: __('customer.email'), title: 'customer.email', value: 'main_email', class: "d-none d-md-table-cell" },
  ],  
  profile_card_fields: [
    { text: __('customer.full_name'), val: 'full_name', type: 'title' },
    { text: __('customer.photo'), val: 'profile_photo', type: 'file' },
    { text: __('customer.age'), val: 'age', type: 'text', rules: [], mask: '###', },
    { text: __('customer.gender'), val: 'gender', type: 'select', options: [ { id: 'M', title: 'Мужской' }, { id: 'F', title: 'Женский' } ] },
    { text: __('customer.city'), val: 'main_city', type: 'text' },
    { text: __('customer.metro'), val: 'main_metro', type: 'text' },
    { text: __('customer.address'), val: 'main_address', type: 'text', href: 'https://yandex.ru/maps/?ll=37.618174%2C55.754998&mode=search&text=', href_icon: 'mdi-web', href_caption: 'Посмотреть на карте'  },
    { text: __('customer.phone'), val: 'main_phone', type: 'text', rules: [], mask: '+7 (###) ###-##-##', href: 'callto:', href_icon: 'mdi-phone-outgoing', href_caption: 'Позвонить прямо сейчас' },
    { text: __('customer.email'), val: 'main_email', type: 'text', rules: [], href: 'mailto:', href_icon: 'mdi-email-outline', href_caption: 'Письмо прямо сейчас' },
  ],
  subscription_options: [
    { id: 'standart', text: 'customer.subscription.standart', title: __('customer.subscription.standart') },
    { id: 'home', text: 'customer.subscription.home', title: __('customer.subscription.home') },
    { id: 'skype', text: 'customer.subscription.skype', title: __('customer.subscription.skype') },
  ],
  pricelist: [],
  groups: [],
  group: {},
/*  person_profile_card_fields: [
    { text: __('customer.person_full_name'), val: 'full_name', type: 'title' },
    { text: __('customer.person_position'), val: 'position', type: 'text' },
    { text: __('customer.person_position'), val: 'main_phone', type: 'text', rules: [], mask: '+7 (###) ###-##-##', href: 'callto:', href_icon: 'mdi-phone-outgoing', href_caption: 'Позвонить прямо сейчас' },
    { text: 'Email', val: 'main_email', type: 'text', rules: [], href: 'mailto:', href_icon: 'mdi-email-outline', href_caption: 'Письмо прямо сейчас' },
  ],*/
  types: [],
  subscription: {},
  subscriptions: [],
  notifications: {},
};

export default {
  state,
  actions,
  mutations
};
