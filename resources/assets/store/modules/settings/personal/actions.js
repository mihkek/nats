export default {
	GET_PERSONAL_SETTINGS: async(context, payload) => {
		let {data} = await axios.post('/admin/settings/personal/get', payload)
		context.commit('SET_PERSONAL_SETTINGS_USER', data)
  	},
  	EDIT_PERSONAL_SETTINGS: async(context, payload) => {
		let {data} = await axios.post('/admin/settings/personal/edit?_lang='+payload._lang, payload)
		context.commit('SET_SNACKBAR', data)
  	},
  	EDIT_PERSONAL_SETTINGS_USER_AVATAR: async(context, payload) => {
		let {data} = await axios.post('/admin/settings/personal/edit_img', payload)
		context.commit('SET_SNACKBAR', data)
  	},
  	CHANGE_PERSONAL_SETTINGS_USER_PASSWORD: async(context, payload) => {
		let {data} = await axios.post('/admin/settings/personal/change_pass', payload)
		context.commit('SET_SNACKBAR', data)
  	},
  	DELETE_USER_ACCOUNT: async(context, payload) => {
		let {data} = await axios.post('/admin/settings/personal/delete_account', payload)
		context.commit('SET_SNACKBAR', data)
  	},
};
