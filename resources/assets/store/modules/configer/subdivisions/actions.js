export default {
  GET_CONFIGER_SUBDIVISIONS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/subdivisions/get', payload)
    context.commit('SET_CONFIGER_SUBDIVISIONS', data)
  },
  GET_CONFIGER_SUBDIVISION: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/subdivisions/get', payload)
    context.commit('SET_CONFIGER_SUBDIVISION', data)
  },
  EDIT_CONFIGER_SUBDIVISION: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/subdivisions/edit', payload)
    context.commit('SET_SNACKBAR', data)
    return data
  },
  DELETE_CONFIGER_SUBDIVISION: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/subdivisions/delete', payload)
    context.commit('SET_SNACKBAR', data)
  },
};
