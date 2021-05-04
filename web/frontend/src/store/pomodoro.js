import { OK } from "../util";

const alarmPath = require("@/assets/alarm.mp3");

const state = {
  // FULLTIME: 1500,
  FULLTIME: 15,
  // SHORT_BREAK: 300,
  SHORT_BREAK: 5,
  // LONG_BREAK: 900,
  LONG_BREAK: 10,
  LONG_BREAK_COUNT: 4,
  pomodoroCount: 0,
  mode: "concentration",
  playMode: "stop",
  time: 0,
  timerId: null,
  excutionDate: ""
};

const getters = {
  playMode: state => state.playMode,

  minutes: function(state) {
    return ("00" + Math.trunc(state.time / 60)).slice(-2);
  },

  seconds: function(state) {
    return ("00" + (state.time % 60)).slice(-2);
  },

  timerCircular: function(state) {
    if (state.mode === "concentration") {
      return ((state.FULLTIME - state.time) * 100) / state.FULLTIME;
    } else if (state.mode === "break") {
      if (state.pomodoroCount % state.LONG_BREAK_COUNT !== 0) {
        return ((state.SHORT_BREAK - state.time) * 100) / state.SHORT_BREAK;
      } else {
        return ((state.LONG_BREAK - state.time) * 100) / state.LONG_BREAK;
      }
    }
  },

  color: function(state) {
    if (state.mode === "concentration") {
      return "error";
    } else if (state.mode === "break") {
      return "primary";
    }
  }
};

const mutations = {
  setTime(state, time) {
    state.time = time;
  },

  setPlayMode(state, mode) {
    state.playMode = mode;
  },

  setTimerId(state, timerId) {
    state.timerId = timerId;
  },

  decrementTime(state) {
    state.time -= 1;
  },

  setMode(state, mode) {
    state.mode = mode;
  },

  incrementPomodoroCount(state) {
    state.pomodoroCount += 1;
  },

  setPomodoroCount(state, count) {
    state.pomodoroCount = count;
  },

  setExcutionDate(state, excutionDate) {
    state.excutionDate = excutionDate;
  }
};

const actions = {
  setStateTime(context, time) {
    context.commit("setTime", time);
  },

  async initPomodoroCount(context, userId) {
    const excutionDate = await context.dispatch("createExcutionDate");
    context.commit("setExcutionDate", excutionDate);
    const response = await window.axios.get(
      "/api/pomodoros/" + userId + "/" + excutionDate
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setPomodoroCount", response.data.data.count);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  start(context, data) {
    const userId = data[0];
    const task = data[1];
    context.commit("setPlayMode", "play");
    const timerId = setInterval(async () => {
      if (state.time === 0) {
        // アラームを鳴動
        const alarm = new Audio(alarmPath);
        alarm.play();
        // カウントダウンを停止
        clearInterval(state.timerId);
        // タイマーのプレイモードを変更
        context.commit("setPlayMode", "stop");
        if (state.mode === "concentration") {
          // ローカルのポモドーロ数を更新
          const excutionDate = await context.dispatch("createExcutionDate");
          if (excutionDate !== state.excutionDate) {
            context.commit("setPomodoroCount", 0);
            context.commit("setExcutionDate", excutionDate);
          }
          context.commit("incrementPomodoroCount");
          // DBのポモドーロ数を更新
          context.dispatch("incrementPomodoroCount", userId);
          // タスクごとのポモドーロ数を更新
          context.dispatch("incrementDone", [userId, task]);
          // タイマーを再セット
          if (state.pomodoroCount % state.LONG_BREAK_COUNT === 0) {
            context.commit("setTime", state.LONG_BREAK);
          } else {
            context.commit("setTime", state.SHORT_BREAK);
          }
          context.commit("setMode", "break");
        } else if (state.mode === "break") {
          context.commit("setTime", state.FULLTIME);
          context.commit("setMode", "concentration");
        }
        // タイマーの値をDBに保存
        context.dispatch("updateTimer", [userId, task]);
        return null;
      }
      context.commit("decrementTime");
    }, 1000);
    context.commit("setTimerId", timerId);
  },

  pause(context) {
    context.commit("setPlayMode", "pause");
    clearInterval(state.timerId);
  },

  reset(context, userId) {
    context.commit("setPlayMode", "stop");
    if (state.mode === "concentration") {
      context.dispatch("incrementPomodoroCount", userId);
      if (state.pomodoroCount % state.LONG_BREAK_COUNT === 0) {
        context.commit("setTime", state.LONG_BREAK);
      } else {
        context.commit("setTime", state.SHORT_BREAK);
      }
      context.commit("setMode", "break");
    } else if (state.mode === "break") {
      context.commit("setTime", state.FULLTIME);
      context.commit("setMode", "concentration");
    }
  },

  async updateTimer(context, data) {
    const userId = data[0];
    const task = data[1];
    context.commit("setApiStatus", null);
    const requestTarget = ["task_id", "name", "start_date", "due_date"];
    let request = {};
    for (let key of Object.keys(task)) {
      if (0 <= requestTarget.indexOf(key)) {
        request[key] = task[key];
      }
    }
    if (state.mode === "break") {
      request["timer"] = state.FULLTIME;
    } else {
      request["timer"] = state.time;
    }
    const response = await window.axios.patch(
      "/api/tasks/" + userId + "/set_timer",
      request
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async resetTimer(context, data) {
    const userId = data[0];
    const task = data[1];
    if (state.mode === "concentration") {
      return null;
    }
    context.commit("setApiStatus", null);
    const requestTarget = ["task_id", "name", "start_date", "due_date"];
    let request = {};
    for (let key of Object.keys(task)) {
      if (0 <= requestTarget.indexOf(key)) {
        request[key] = task[key];
      }
    }
    request["timer"] = state.FULLTIME;
    const response = await window.axios.patch(
      "/api/tasks/" + userId + "/set_timer",
      request
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async incrementDone(context, data) {
    const userId = data[0];
    const task = data[1];
    context.commit("setApiStatus", null);
    const requestTarget = ["task_id", "name", "start_date", "due_date"];
    let request = {};
    for (let key of Object.keys(task)) {
      if (0 <= requestTarget.indexOf(key)) {
        request[key] = task[key];
      }
    }
    const response = await window.axios.patch(
      "/api/tasks/" + userId + "/increment_done",
      request
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("task/setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async incrementPomodoroCount(context, userId) {
    const excutionDate = await context.dispatch("createExcutionDate");
    if (excutionDate !== state.excutionDate) {
      context.commit("setExcutionDate", excutionDate);
    }
    window.axios.patch("/api/pomodoros/" + userId, {
      date: excutionDate
    });
  },

  createExcutionDate() {
    const date = new Date();
    const year = date.getFullYear();
    const month = ("0" + (date.getMonth() + 1)).slice(-2);
    const day = ("0" + date.getDate()).slice(-2);
    const excutionDate = year + "-" + month + "-" + day + " 00:00:00";
    return excutionDate;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
