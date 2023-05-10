export default {
  GET_BILLING_HISTORY: async(context, payload) => {
    let {data} = await axios.post('/admin/billing/get_history', payload)
    context.commit('SET_BILLING_HISTORY', data)
  },
  CREATE_USER_BILLING_PAY: async(context, payload) => {
    let {data} = await axios.post('/admin/billing/create_pay', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CREATE_USER_BILLING_PAYOUT: async(context, payload) => {
    let {data} = await axios.post('/admin/billing/create_payout', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_SUBSCRIPTIONS_HISTORY: async(context, payload) => {
    let {data} = await axios.post('/admin/billing/get_subscriptions_history', payload)
    context.commit('SET_SUBSCRIPTION_HISTORY', data)
  },
};
