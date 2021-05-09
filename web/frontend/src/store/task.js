import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const PROJECT = ["未設定", "プライベート", "仕事"];

const CONTEXT = [
  "未設定",
  "0時〜6時",
  "6時〜12時",
  "12時〜18時",
  "18時〜24時"
];

const state = {
  tasks: null,
  taskControlForm: null,
  apiStatus: null,
  taskAddErrorMessages: null,
  isPersistedItem: false,
  keywords: [],
  contextId: 0,
  projectId: 0,
  display: false
};

const getters = {
  tasks: state => {
    let tasks = state.tasks;
    let filterTasks;
    // キーワードによる絞り込み
    if (0 < state.keywords.length) {
      filterTasks = tasks["data"].filter(task => {
        const filterResult = state.keywords.filter(keyword => {
          return -1 < task["name"].indexOf(keyword);
        });
        return filterResult.length === state.keywords.length;
      });
      tasks = { data: filterTasks };
    } else {
      tasks = state.tasks;
    }
    // コンテキストidによる絞り込み
    if (state.contextId !== 0) {
      filterTasks = tasks["data"].filter(task => {
        return task["context_id"] === state.contextId;
      });
      tasks = { data: filterTasks };
    }
    // プロジェクトidによる絞り込み
    if (state.projectId !== 0) {
      filterTasks = tasks["data"].filter(task => {
        return task["project_id"] === state.projectId;
      });
      tasks = { data: filterTasks };
    }
    return tasks;
  },
  taskControlForm: state => state.taskControlForm,
  isPersistedItem: state => !!state.isPersistedItem,
  display: state => !!state.display
};

const mutations = {
  setTasks(state, tasks) {
    state.tasks = tasks;
  },

  setTaskControlForm(state, task) {
    state.taskControlForm = task;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setAddTaskErrorMessages(state, messages) {
    state.taskAddErrorMessages = messages;
  },

  setIsPersistedItem(state, status) {
    state.isPersistedItem = status;
  },

  setDisplay(state, status) {
    state.display = status;
  },

  setKeywords(state, keywords) {
    state.keywords = keywords;
  },

  setContextId(state, id) {
    state.contextId = id;
  },

  setProjectId(state, id) {
    state.projectId = id;
  }
};

const actions = {
  async create(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post("/api/tasks/" + data[0], data[1]);

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setAddTaskErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  localCreate(context, data) {
    let new_task = data;
    const repeats = context.rootState.repeat.repeats.data;
    const priorities = context.rootState.priority.priorities.data;
    let tasks = state.tasks.data;
    new_task.user_id = null;
    new_task.context = CONTEXT[data.context_id - 1];
    new_task.project = PROJECT[data.project_id - 1];
    new_task.repeat = repeats[data.repeat_id - 1].name;
    new_task.priority = priorities[data.priority_id - 1].name;
    new_task.timer = 1500;
    new_task.finished = 0;
    new_task.done = 0;
    new_task.id = 1 + Math.max.apply(null, tasks.map(task => task.id));
    tasks.push(new_task);
    context.commit("setTasks", {"data": tasks});
  },

  async update(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch("/api/tasks/" + data[0], data[1]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      context.commit("setTaskControlForm", {});
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setAddTaskErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async remove(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.delete(
      "/api/tasks/" + data[0],
      data[1]
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async index(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/tasks/" + data[0]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      context.commit("setTaskControlForm", {});
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  localIndex(context) {
    console.log("in");
    const name = [
      "ToDoRoはタスク管理アプリです",
      "ポモドーロタイマーをあわせ持っています",
      "再生ボタンを押してポモドーロ開始です",
      "＋ボタンでタスクを追加できます",
      "タスクはログインすると保存できます",
      "ぜひタスクに集中して取り組みましょう！"
    ];
    const user_id = null;
    const project_id = [...Array(3)].map((_, i) => i + 1);
    const context_id = [...Array(5)].map((_, i) => i + 1);
    const date = new Date();
    const date_str =
      date.getFullYear() +
      "-" +
      ("0" + (date.getMonth() + 1)).slice(-2) +
      "-" +
      ("0" + date.getDate()).slice(-2);
    const start_date = date_str + " 00:00:00";
    const due_date = date_str + " 00:00:00";
    let tasks = {
      data: []
    };
    for (let i = 0; i < name.length; i++) {
      let data = {};
      (data["id"] = i + 1),
        (data["name"] = name[i]),
        (data["user_id"] = user_id),
        (data["project_id"] = project_id[i % 3]),
        (data["project"] = PROJECT[i % 3]),
        (data["context_id"] = context_id[i % 5]),
        (data["context"] = CONTEXT[i % 5]),
        (data["start_date"] = start_date),
        (data["due_date"] = due_date),
        (data["term"] = 0),
        (data["finished"] = 0),
        (data["done"] = 0),
        (data["timer"] = 1500),
        (data["repeat_id"] = 1),
        (data["repeat"] = "未設定"),
        (data["priority_id"] = 1),
        (data["priority"] = "未設定");
      tasks["data"].push(data);
    }
    console.log(tasks);
    context.commit("setTasks", tasks);
  },

  async finished(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch(
      "/api/tasks/" + data[0] + "/finished",
      data[1]
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async unfinished(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch(
      "/api/tasks/" + data[0] + "/unfinished",
      data[1]
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  open(context, item) {
    context.commit("setAddTaskErrorMessages", null);
    if (Object.keys(item).length != 5) {
      context.commit("setIsPersistedItem", true);
    } else {
      context.commit("setIsPersistedItem", false);
    }
    context.commit("setTaskControlForm", item);
    context.commit("setDisplay", true);
  },

  close(context) {
    if (state.isPersistedItem) {
      context.commit("setTaskControlForm", {});
    }
    context.commit("setDisplay", false);
  },

  inputKeywords(context, keywords) {
    const keywordList = keywords.replaceAll("　", " ").split(" ");
    context.commit("setKeywords", keywordList);
  },

  inputContextId(context, id) {
    context.commit("setContextId", id);
  },

  inputProjectId(context, id) {
    context.commit("setProjectId", id);
  },

  localValidation(context, data) {
    let errors = {};
    if (data.name) {
      if (140 < data.name.length) {
        errors.name = ["タスク名には140文字以下の文字列を指定してください"];
      }
    } else {
      errors.name = ["タスク名を入力してください"]
    }
    if (!data.start_date) {
      errors.start_date = ["開始日を入力してください"]
    }
    if (!data.due_date) {
      errors.due_date = ["終了日を入力してください"]
    }
    if (data.start_date && data.due_date){
      const start = new Date(data.start_date);
      const due = new Date(data.due_date);
      if (due < start) {
        errors.start_date = ["開始日は終了日以前を選択してください"];
        errors.due_date = ["終了日は開始日以後を選択してください"];
      }
    }
    if (Object.keys(errors).length) {
      context.commit("setAddTaskErrorMessages", errors);
      return false;
    } else {
      context.commit("setAddTaskErrorMessages", null);
      return true;
    }
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
