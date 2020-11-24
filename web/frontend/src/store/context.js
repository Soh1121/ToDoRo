const state = {
  display: false
};

const getters = {
  display: state => !!state.display
};

const mutations = {
  reverseDisplay(state, property) {
    state.display = property;
  }
};

const actions = {
  open(context) {
    context.commit("reverseDisplay", true);
  },

  close(context) {
    context.commit("reverseDisplay", false);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
