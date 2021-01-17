import { OK } from "../util";

const state = {
  priorities: null,
  apiStatus: null
};

const getters = {};

const mutations = {
  setPriorities(state, priorities) {
    state.priorities = priorities;
  },

  setApiStatus(state, status) {
    state.setApiStatus = status;
  }
};

const actions = {
  async index(context) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/priority");

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setPriorities", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
