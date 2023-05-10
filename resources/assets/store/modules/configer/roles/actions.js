export default {
  GET_USER_ROLES: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/roles/get')
    context.commit('SET_USER_ROLES', data)
  },
  EDIT_USER_ROLE: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/roles/edit?_lang='+payload._lang, payload)
    context.commit('SET_SNACKBAR', data)
  },
};
