import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  contexts: null,
  apiStatus: null,
  contextNameErrorMessages: null
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

  setContextNameErrorMessages(state, messages) {
    state.contextNameErrorMessages = messages;
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
      context.commit("setContextNameErrorMessages", response.data.errors);
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
      context.commit("setContextNameErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async remove(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.delete(
      "/api/contexts/" + data[0],
      data[1]
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setContexts", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async index(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/contexts/" + data[0]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setContexts", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  localIndex(context) {
    context.commit("setContexts", {
      data: [
        {
          id: 1,
          user_id: null,
          name: "未設定"
        },
        {
          id: 2,
          user_id: null,
          name: "0時〜6時"
        },
        {
          id: 3,
          user_id: null,
          name: "6時〜12時"
        },
        {
          id: 4,
          user_id: null,
          name: "12時〜18時"
        },
        {
          id: 5,
          user_id: null,
          name: "18時〜24時"
        }
      ]
    });
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
