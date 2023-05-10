export default {
  GET_USER_LIST: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/get', payload)
    context.commit('SET_USER_LIST', data)
  },
  GET_CONFIGER_USER: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/get', payload)
    context.commit('SET_CONFIGER_USER', data)
  },
  EDIT_CONFIGER_USER: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/edit?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  DELETE_CONFIGER_USER: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/delete', payload)
    context.commit('SET_SNACKBAR', data)
  },
  RESTORE_CONFIGER_USER: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/restore', payload)
    context.commit('SET_SNACKBAR', data)
  },
  EDIT_CONFIGER_USER_AVATAR: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/edit_img', payload)
    context.commit('SET_SNACKBAR', data)
  },
  EDIT_USER_PASS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/edit_pass', payload)
    context.commit('SET_SNACKBAR', data)
  },
  GET_DIRECTORY_PERSON_USERS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/get_directory_person_users', payload)
    context.commit('SET_DIRECTORY_PERSON_USERS', data)
  },
  GET_DIRECTORY_FIRM_USERS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/get_directory_firm_users', payload)
    context.commit('SET_DIRECTORY_FIRM_USERS', data)
  },
  GET_CUSTOMER_USERS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/users/get_customer_users', payload)
    context.commit('SET_CUSTOMER_USERS', data)
  },
  GET_COMPANY_USERS: async(context, payload) => {
      let {data} = await axios.post('/admin/configer/users/get_company_users', payload)
      context.commit('SET_COMPANY_USERS', data)
  },
  GET_MANAGERS_USERS: async(context, payload) => {
      let {data} = await axios.post('/admin/configer/users/get_managers_users', payload)
      context.commit('SET_MANAGERS_USERS', data)
  },
  GET_DIRECTORY_USERS: async(context, payload) => {
      let {data} = await axios.post('/admin/configer/users/get_directory_users', payload)
      context.commit('SET_DIRECTORY_USERS', data)
  },

};
