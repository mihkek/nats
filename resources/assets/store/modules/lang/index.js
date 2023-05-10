import actions from './actions';
import mutations from './mutations';

const state = {
  lang: document.querySelector('meta[property="lang"]').getAttribute('content'),
  items: {},
}

export default {
  state,
  actions,
  mutations,
}