export default {
	GET_REVIEWS: async(context, payload) => {
		let {data} = await axios.post('/admin/personal/review/getlist', payload)
		context.commit('SET_REVIEWS', data)
	},
	UPDATE_REVIEW: async(context, payload) => {
		let {data} = await axios.post('/admin/personal/review/update', payload)
		context.commit('SET_REVIEW', data)
	},
	DELETE_REVIEW: async(context, payload) => {
		let {data} = await axios.post('/admin/personal/review/delete', payload)
	},
};
