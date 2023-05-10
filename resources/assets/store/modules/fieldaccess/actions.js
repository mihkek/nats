const get = (p, o) => p.reduce((xs, x) => (xs && xs[x]) ? xs[x] : null, o);

const singleLoader = (dataKey, loader) => (context, payload) => {
  const data = get(dataKey, context.state);
  if (data) {
    return data;
  } else {
    const key = dataKey.join('-');
    if (context.state.loading[key]) {
      return context.state.loading[key];

    } else {
      const request = new Promise(async (resolve, reject) => {
        try {
          const data = await loader(context, payload);
          context.commit('DELETE_ACCESS_LOADING', { key });
          resolve(data);

        } catch (e) {
          context.commit('DELETE_ACCESS_LOADING', { key });
          reject(e);
        }
      });

      context.commit('SET_ACCESS_LOADING', { key, request });
      return request;
    }
  }
};

export default {
  GET_ACCESS_ROLES: (context, payload) => {
    if (context.state.roles === null) {
      const request = new Promise(async (resolve, reject) => {
        const { data } = await axios.get('/api/field-access/roles');
        context.commit('SET_ACCESS_ROLES', data.roles);
      });
      context.commit('SET_ACCESS_ROLES', request);
      return request;

    } else {
      return context.state.roles; // Может вернуться и promise, и готовый объект с данными
    }
  },

  GET_ACCESS_DATA: singleLoader([ 'access' ], async (context) => {
    const { data } = await axios.get('/api/field-access/access-data');
    context.commit('SET_ACCESS_DATA', { data });
    return data;
  }),

  /*
    GET_ACCESS_MODEL_FIELDS: singleLoader(['modelFields', payload.model], async (context, payload) => {
      const { data } = await axios.get(`/api/field-access/${payload.model}/fields`);
      context.commit('SET_ACCESS_MODEL_FIELDS', { model: payload.model, data, key });
      return data;
    }),
  */
  GET_ACCESS_MODEL_FIELDS: async (context, payload) => {
    if (typeof context.state.modelFields[payload.model] === 'undefined') {
      const key = `modelFields_${payload.model}`;
      if (context.state.loading[key]) {
        return context.state.loading[key];
      } else {
        const request = new Promise(async (resolve, reject) => {
          const { data } = await axios.get(`/api/field-access/${payload.model}/fields`);
          context.commit('SET_ACCESS_MODEL_FIELDS', { model: payload.model, data, key });
        });

        context.commit('SET_ACCESS_LOADING', { key, request });
        return request;
      }

    } else {
      context.state.modelFields[payload.model]
    }
  },
  SET_ACCESS_MODEL_FIELDS: async (context, payload) => {
    const { data } = await axios.post(`/api/field-access/${payload.model}/fields`, payload);
    context.commit('SET_ACCESS_MODEL_FIELDS', { model: payload.model, data });
  }
};
