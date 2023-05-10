export default {
	GET_PROMOTER: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/get', payload)
		context.commit('SET_PROMOTER', data)
  	},
	GET_PROMOTERS: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/get', payload)
		context.commit('SET_PROMOTERS', data)
  	},
  	GET_PROMOTER_USERS: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/get_users', payload)
		context.commit('SET_PROMOTER_USERS', data)
  	},
  	EDIT_PROMOTER: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/edit', payload)
		context.commit('SET_SNACKBAR', data)
		return data
  	},
  	EDIT_PROMOTER_IMG: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/edit_img', payload)
		context.commit('SET_SNACKBAR', data)
  	},
  	DELETE_PROMOTER: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/delete', payload)
		context.commit('SET_SNACKBAR', data)
  	},
  	RESTORE_PROMOTER: async(context, payload) => {
		let {data} = await axios.post('/admin/promoters/restore', payload)
		context.commit('SET_SNACKBAR', data)
  	},
};
