import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  projects: null,
  apiStatus: null,
  projectNameErrorMessages: null
};

const getters = {
  projects: state => state.projects
};

const mutations = {
  setProjects(state, projects) {
    state.projects = projects;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setProjectNameErrorMessages(state, messages) {
    state.projectNameErrorMessages = messages;
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
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setProjectNameErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async update(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch(
      "/api/projects/" + data[0],
      data[1]
    );

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setProjects", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setProjectNameErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async remove(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.delete(
      "/api/projects/" + data[0],
      data[1]
    );

    if (response.status === OK) {
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
