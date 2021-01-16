const state = {
  display: false
};

const getters = {
  display: state => !!state.display
};

const mutations = {};

const actions = {};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
