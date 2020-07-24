const state = {
  user: null
};

const getters = {};

const mutations = {
  setUser(state, user) {
    state.user = user;
  }
};

const actions = {};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
