export default {
  SET_LANG: async(context, payload) => {
    /*$cookies.set('lang', payload.lang, 60 * 60 * 24 * 365, '/');*/
    context.commit('SET_LANG', payload);
  },
  GET_LANG_ITEMS: async(context, payload) => {
    let {data} = await axios.post('/admin/settings/get_langs', payload)
	  context.commit('SET_LANG_ITEMS', data)
  },
  CHANGE_LANG: async(context, payload) => {
    let {data} = await axios.post('/admin/settings/change_lang', payload)
	   context.commit('SET_LANG_ITEMS', data)
  },
};
