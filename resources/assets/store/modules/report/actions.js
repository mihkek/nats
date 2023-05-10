export default {
	GET_PROMOTERS_REPORT: async(context, payload) => {
		let {data} = await axios.post('/admin/reports/get_promoters', payload)
		context.commit('SET_REPORT', data)
  	},
  	GET_OPERATORS_REPORT: async(context, payload) => {
		let {data} = await axios.post('/admin/reports/get_operators', payload)
		context.commit('SET_REPORT', data)
  	},
  	GET_MANAGERS_REPORT: async(context, payload) => {
		let {data} = await axios.post('/admin/reports/get_managers', payload)
		context.commit('SET_REPORT', data)
  	},
};
