export default {
	GET_DIRECTORY_PEOPLE: async(context, payload) => {
		  let {data} = await axios.post('/admin/directory/people/get', payload)
		  context.commit('SET_DIRECTORY_PEOPLE', data)
    },
    GET_DIRECTORY_PERSON: async(context, payload) => {
		  let {data} = await axios.post('/admin/directory/people/get', payload)
      console.log(data)
		  context.commit('SET_DIRECTORY_PERSON', data)
    },
    EDIT_DIRECTORY_PERSON: async(context, payload) => {
		  let {data} = await axios.post('/admin/directory/people/edit?_lang='+payload._lang, payload)
		  context.commit('SET_SNACKBAR', data)
      return data
    },
    ARCHIVE_DIRECTORY_PERSON: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/delete', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
    RESTORE_DIRECTORY_PERSON: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/restore', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
    CONFIRM_DIRECTORY_PERSON: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/confirm', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
    REJECT_DIRECTORY_PERSON: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/reject', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
    EDIT_DIRECTORY_PERSON_AVATAR: async(context, payload) => {
		  let {data} = await axios.post('/admin/directory/people/edit_img', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
	EDIT_DIRECTORY_PERSON_CHECK_FILE: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/edit_check_file', payload)
      context.commit('SET_SNACKBAR', data)
      return data
    },
    GET_DIRECTORY_PERSON_BUSY_TIMES: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/get_busy_times', payload)
      context.commit('SET_DIRECTORY_PERSON_BUSY_TIMES', data)
    },
    GET_DIRECTORY_PERSON_BUSY_CALENDAR_TIMES: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/get_busy_calendar_times', payload)
      context.commit('SET_DIRECTORY_PERSON_BUSY_CALENDAR_TIMES', data)
    },
    EDIT_DIRECTORY_PERSON_BUSY_TIME: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/edit_busy_time', payload)
      context.commit('SET_SNACKBAR', data)
    },
    DELETE_DIRECTORY_PERSON_BUSY_TIME: async(context, payload) => {
      let {data} = await axios.post('/admin/directory/people/delete_busy_time', payload)
      context.commit('SET_SNACKBAR', data)
    },
};
