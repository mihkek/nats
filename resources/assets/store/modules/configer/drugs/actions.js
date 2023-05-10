export default {
  GET_DRUGS: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/drugs/get')
    context.commit('SET_DRUGS', data)
  },
  EDIT_DRUG: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/drugs/edit', payload)
    context.commit('SET_SNACKBAR', data)
  },
  DELETE_DRUG: async(context, payload) => {
    let {data} = await axios.post('/admin/configer/drugs/delete', payload)
    context.commit('SET_SNACKBAR', data)
  },
};
