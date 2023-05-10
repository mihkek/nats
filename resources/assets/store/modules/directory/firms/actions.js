export default {
	GET_DIRECTORY_FIRMS: async(context, payload) => {
		let {data} = await axios.post('/admin/directory/firms/get', payload)
		context.commit('SET_DIRECTORY_FIRMS', data)
  },
  GET_DIRECTORY_FIRM: async(context, payload) => {
		let {data} = await axios.post('/admin/directory/firms/get', payload)
		context.commit('SET_DIRECTORY_FIRM', data)
  },
  EDIT_DIRECTORY_FIRM: async(context, payload) => {
		let {data} = await axios.post('/admin/directory/firms/edit?_lang='+payload._lang, payload)
		context.commit('SET_SNACKBAR', data)
    return data
  },
  ARCHIVE_DIRECTORY_FIRM: async(context, payload) => {
    let {data} = await axios.post('/admin/directory/firms/delete', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  RESTORE_DIRECTORY_FIRM: async(context, payload) => {
    let {data} = await axios.post('/admin/directory/firms/restore', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },

  EDIT_DIRECTORY_FIRM_AVATAR: async(context, payload) => {
		let {data} = await axios.post('/admin/directory/firms/edit_img', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  EDIT_DIRECTORY_FIRM_PERSON: async(context, payload) => {
    let {data} = await axios.post('/admin/directory/firms/edit_firm_person?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
  },
  DEL_DIRECTORY_FIRM_PERSON: async(context, payload) => {
    let {data} = await axios.post('/admin/directory/firms/delete_firm_person', payload)
    context.commit('SET_SNACKBAR', data)
  },

  GET_DIRECTORY_FIRM_BUSY_TIMES: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/firms/get_busy_times', payload)
      context.commit('SET_DIRECTORY_FIRM_BUSY_TIMES', data)
    },

  GET_DIRECTORY_FIRM_BUSY_CALENDAR_TIMES: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/firms/get_busy_calendar_times', payload)
      context.commit('SET_DIRECTORY_FIRM_BUSY_CALENDAR_TIMES', data)
    },
    EDIT_DIRECTORY_FIRM_BUSY_TIME: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/firms/edit_busy_time', payload)
      context.commit('SET_SNACKBAR', data)
    },
    DELETE_DIRECTORY_FIRM_BUSY_TIME: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/firms/delete_busy_time', payload)
      context.commit('SET_SNACKBAR', data)
    },
};
