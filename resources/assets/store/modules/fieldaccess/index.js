import actions from './actions';
import mutations from './mutations';

const state = {
  roles: null,
  access: null,
  fields: null,
  canAdmin: false,
  canSuper: false,
  modelFields: {},
  loading: {},
  whoami: 0,
}

export default {
  state,
  actions,
  mutations,
}