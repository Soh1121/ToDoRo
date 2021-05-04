const state = {
  loading: false
};

const getters = {
  loading: state => state.loading
};

const mutations = {
  setLoading(state, payload) {
    state.loading = payload;
  }
};

const actions = {
  changeLoading(context, payload) {
    context.commit("setLoading", payload);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
