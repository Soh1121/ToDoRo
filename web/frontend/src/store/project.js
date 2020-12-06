import { CREATED } from "../util";

const state = {
  apiStatus: null
};

const getters = {};

const mutations = {
  setProjects(state, projects) {
    state.projects = projects;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  }
};

const actions = {
  async create(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post(
      "/api/projects/" + data[0],
      data[1]
    );

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setProjects", response.data);
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