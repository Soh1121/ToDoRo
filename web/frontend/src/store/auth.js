const state = {
  user: null
};

const getters = {
  check: state => !!state.user,
  username: state => (state.user ? state.user.name : "")
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  }
};

const actions = {
  async register(context, data) {
    const response = await window.axios.post("/api/register", data);
    context.commit("setUser", response.data);
  },

  async login(context, data) {
    const response = await window.axios.post("/api/login", data);
    context.commit("setUser", response.data);
  },

  async logout(context) {
    await window.axios.post("/api/logout");
    context.commit("setUser", null);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
