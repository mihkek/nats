export default {
  SET_LANG: (state, payload) => {
    state.lang = payload.lang;
  },
  SET_LANG_ITEMS: (state, payload) => {
    state.items = payload.langs;
  },
};
