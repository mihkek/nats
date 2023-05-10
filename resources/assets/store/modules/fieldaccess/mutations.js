export default {
  SET_ACCESS_ROLES: (state, payload) => {
    state.roles = payload;
  },
  SET_ACCESS_DATA: (state, payload) => {
    Object.keys(payload.data).forEach(key => state[key] = payload.data[key]);
    if (payload.key) delete state.loading[payload.key];
  },
  SET_ACCESS_MODEL_FIELDS: (state, payload) => {
    // state.modelFields[payload.model] = payload.data;
    state.modelFields = { ...state.modelFields, [payload.model]: payload.data };
    if (payload.key) delete state.loading[payload.key];
  },
  SET_ACCESS_LOADING: (state, payload) => {
    state.loading[payload.key] = payload.request;
  },
  DELETE_ACCESS_LOADING: (state, payload) => {
    delete state.loading[payload.key];
  },
};
