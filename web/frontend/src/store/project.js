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
  },

  async index(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/projects/" + data[0]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setProjects", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  localIndex(context) {
    context.commit("setProjects", {
      data: [
        {
          id: 1,
          user_id: null,
          name: "未設定"
        },
        {
          id: 2,
          user_id: null,
          name: "プライベート"
        },
        {
          id: 3,
          user_id: null,
          name: "仕事"
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
