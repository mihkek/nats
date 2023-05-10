export default {
	GET_USER_TODAY_ORDERERS: async(context, payload) => {
		let {data} = await axios.post('/admin/users/orderers/get_today_orderers', payload)
		context.commit('SET_USER_TODAY_ORDERERS', data)
  	},
  	GET_USER_NEXT_ORDERER: async(context, payload) => {
		let {data} = await axios.post('/admin/users/orderers/get_next_orderer', payload)
		context.commit('SET_USER_NEXT_ORDERER', data)
  	},
  	GET_USER_ORDERERS_PAID: async(context, payload) => {
		let {data} = await axios.post('/admin/users/orderers/get_next_orderer', payload)
		context.commit('SET_USER_NEXT_ORDERER', data)
  	},
  	GET_USER_ACCOUNT_STATEMENT: async(context, payload) => {
		let {data} = await axios.post('/admin/users/get_account_statement', payload)
		context.commit('SET_USER_ACCOUNT_STATEMENT', data)
  	},
};
