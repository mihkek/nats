export default {
	GET_ORDERERS: async(context, payload) => {
		let {data} = await axios.post('/admin/orderers/get', payload)
    console.log(data)
		context.commit('SET_ORDERERS', data)
  },
  GET_ORDERER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/get', payload)
    context.commit('SET_ORDERER', data)
  },
  EDIT_ORDERER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/edit?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  CONFIRM_ORDERER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/confirm', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  CLOSE_ORDERER: async(context, payload) => {
    console.log(payload)
    let {data} = await axios.post('/admin/orderers/close', payload)
    context.commit('SET_SNACKBAR', data)
  },
  TRANSFER_ORDERER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/transfer', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CANCEL_ORDERER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/cancel', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_ORDERER_ADDITIONAL_PLACES: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/get_additional_places', payload)
    context.commit('SET_ORDERER_ADDITIONAL_PLACES', data)
  },
  GET_ORDERER_STATUSES: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/get_statuses', payload)
    context.commit('SET_ORDERER_STATUSES', data)
  },
  MARK_ORDER_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/orderers/mark_customer', payload)
    context.commit('SET_SNACKBAR', data)
  },
};
