import { OK } from "../util";

const state = {
  repeats: null,
  apiStatus: null
};

const getters = {};

const mutations = {
  setRepeats(state, repeats) {
    state.repeats = repeats;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  }
};

const actions = {
  async index(context) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/repeat");

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setRepeats", response.data);
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
