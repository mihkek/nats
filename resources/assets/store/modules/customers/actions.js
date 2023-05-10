export default {
  GET_CUSTOMER_TYPES: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_types')
    context.commit('SET_CUSTOMERS_TYPES', data)
  },
  GET_CUSTOMERS: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get', payload)
    context.commit('SET_CUSTOMERS', data)
  },
  GET_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get', payload)
    console.log(data)
    context.commit('SET_CUSTOMER', data)
  },
  EDIT_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  ARCHIVE_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/delete', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  RESTORE_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/restore', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  EDIT_CUSTOMER_AVATAR: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_img', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  EDIT_CUSTOMER_CHECK_FILE: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_check_file', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  EDIT_CUSTOMER_PERSON: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_customer_person?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
  },
  DEL_CUSTOMER_PERSON: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/delete_customer_person', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_SUBSCRIPTION_PRICE: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_subscription_price', payload)
    context.commit('SET_SUBSCRIPTION_PRICE', data)
  },
  ADD_CUSTOMER_SUBSCRIPTION: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/add_subscription', payload)
    context.commit('SET_SNACKBAR', data)
  },
  DEL_CUSTOMER_SUBSCRIPTION: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/del_subscription', payload)
    context.commit('SET_SNACKBAR', data)
  },
  PAY_CUSTOMER_SUBSCRIPTION: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/pay_subscription', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_CUSTOMER_SUBSCRIPTIONS: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_customer_subscriptios', payload)
    context.commit('SET_CUSTOMER_SUBSCRIPTIONS', data)
  },
  EDIT_CUSTOMER_SUBSCRIPTION: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_subscription', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_CUSTOMERS_GROUPS: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_groups', payload)
    context.commit('SET_CUSTOMERS_GROUPS', data)
  },
  GET_CUSTOMERS_GROUP: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_groups', payload)
    context.commit('SET_CUSTOMERS_GROUP', data)
  },
  EDIT_CUSTOMERS_GROUP: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_group', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  DELETE_CUSTOMERS_GROUP: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/delete_group', payload)
    context.commit('SET_SNACKBAR', data)
  },
  SIGN_CUSTOMERS_GROUP: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/sign_group', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_CUSTOMER_GROUP_ORDERS: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/add_group_orders', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_CUSTOMER_PAYTABLE: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/add_customer_paytable', payload)
    context.commit('SET_SNACKBAR', data)
  },
  EDIT_CUSTOMER_PAYTABLE: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/edit_customer_paytable', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CLEAR_CUSTOMER_PAYTABLE: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/clear_customer_paytable', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_CUSTOMER_PAY: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/add_pay', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_CUSTOMERS_NOTIFICATIONS: async(context, payload) => {
    let {data} = await axios.post('/admin/customers/get_notifications', payload)
    context.commit('SET_CUSTOMERS_NOTIFICATIONS', data)
  },
};
