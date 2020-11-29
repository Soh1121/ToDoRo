import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  contexts: null,
  apiStatus: null
};

const getters = {
  contexts: state => state.contexts
};

const mutations = {
  setContexts(state, contexts) {
    state.contexts = contexts;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setStoreErrorMessages(state, messages) {
    state.stateErrorMessages = messages;
  }
};

const actions = {
  async create(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post(
      "/api/contexts/" + data[0],
      data[1]
    );

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setContexts", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setStoreErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async update(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch(
      "/api/contexts/" + data[0],
      data[1]
    );

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setContexts", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setStoreErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async index(context, data) {
    const route = "/api/contexts/" + data[0];
    const response = await window.axios.get(route);

    if (response.status !== OK) {
      context.commit("error/setCode", response.status, { root: true });
      return false;
    }

    context.commit("setApiStatus", true);
    context.commit("setContexts", response.data);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
