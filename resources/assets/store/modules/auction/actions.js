export default {
	GET_AUCTIONS: async(context, payload) => {
		let {data} = await axios.post('/admin/auction/get', payload)
		context.commit('SET_AUCTIONS', data)
  },
  GET_TENDERS: async(context, payload) => {
		let {data} = await axios.post('/admin/auction/get', payload)
		context.commit('SET_TENDERS', data)
  },
  GET_SALES: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/get', payload)
    context.commit('SET_SALES', data)
  },  
  GET_AUCTION: async(context, payload) => {
		let {data} = await axios.post('/admin/auction/get', payload)
		context.commit('SET_AUCTION', data)
  },
  EDIT_AUCTION: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/edit?_lang='+payload._lang, payload.form)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  CANCEL_AUCTION: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/cancel', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CLOSE_AUCTION: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/close', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_AUCTION_RATE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/add_rate', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_AUCTION_RATE_ANALOG: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/add_rate_analog', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CANCEL_AUCTION_RATE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/cancel_rate', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CONFIRM_AUCTION_RATE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/confirm_rate', payload)
    context.commit('SET_SNACKBAR', data)
  },
  CONFIRM_AUCTION_SALE_RATE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/confirm_sale_rate', payload)
    context.commit('SET_SNACKBAR', data)
  },
  DELETE_AUCTION_RATE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/delete_rate', payload)
    context.commit('SET_SNACKBAR', data)
  },
  EDIT_AUCTION_AVATAR: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/edit_photo', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_RATES: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/get_rates', payload)
    context.commit('SET_RATES', data)
  },
  CONFIRM_AUCTION_CONTRACT: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/confirm_contract', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_CONTRACT_FILE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/add_contract_file', payload)
    context.commit('SET_SNACKBAR', data)
	console.log(data)
  },
  DELETE_CONTRACT_FILE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/delete_contract_file', payload)
    context.commit('SET_SNACKBAR', data)
  },
  ADD_DOC_FILE: async(context, payload) => {
    let {data} = await axios.post('/admin/auction/add_doc_file', payload)
    context.commit('SET_SNACKBAR', data)
    console.log(data)
  },
};
