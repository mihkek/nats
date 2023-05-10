export default {
	GET_REQUESTERS: async(context, payload) => {
		let {data} = await axios.post('/admin/requester/get', payload)
		context.commit('SET_REQUESTERS', data)
  },
  GET_REQUESTER: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/get', payload)
    console.log(data)
    context.commit('SET_REQUESTER', data)
  },
  EDIT_REQUESTER: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/edit?_lang='+payload._lang, payload.form)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  EDIT_REQUESTERS: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/edit_items', payload)
    context.commit('SET_SNACKBAR', data)
  },
  DELETE_REQUESTERS: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/delete_items', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_REQUESTER_CUSTOMER: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/add_customer', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  DELETE_REQUESTER_PHOTO: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/del_photo', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_REQUESTER_PHOTO: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/add_photo', payload)
    context.commit('SET_SNACKBAR', data)
  },
  REQUESTER_IS_FALSE: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/is_false', payload)
    context.commit('SET_SNACKBAR', data)
  },
  REQUESTER_IS_CLAIM: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/is_claim', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_REQUESTER_REPORT: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/get_report', payload)
    context.commit('SET_REQUESTER_REPORT', data)
  },
  GET_REQUESTER_NOTIFICATIONS: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/get_notifications', payload)
    context.commit('SET_REQUESTER_NOTIFICATIONS', data)
  },
  CONFIRM_REQUESTER_CUSTOMER_RECORD: async(context, payload) => {
    let {data} = await axios.post('/admin/requester/confirm_record', payload)
    context.commit('SET_SNACKBAR', data)
  },
};
