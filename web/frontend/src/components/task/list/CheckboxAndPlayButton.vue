<template>
  <v-list-item-action>
    <v-checkbox
      :input-value="checkboxState"
      @change="onChange(task)"
    ></v-checkbox>
    <v-btn icon @click="transition(task)" class="u-margin__margin---6px"
      ><v-icon>mdi-play-circle-outline</v-icon></v-btn
    >
  </v-list-item-action>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  props: {
    task: {
      type: Object
    }
  },

  data() {
    return {
      checkboxState: this.task.finished === 1 ? true : false
    };
  },

  computed: {
    ...mapState({
      pomodoroMode: state => state.pomodoro.mode,
      nowTask: state => state.pomodoro.nowTask
    }),

    ...mapGetters({
      userId: "auth/user_id",
      playMode: "pomodoro/playMode"
    })
  },

  methods: {
    async onChange(item) {
      this.checkboxState = !this.checkboxState;
      if (this.userId) {
        if (this.checkboxState) {
          await this.$store.dispatch("task/finished", [this.userId, item]);
        } else {
          await this.$store.dispatch("task/unfinished", [this.userId, item]);
        }
      } else {
        if (this.checkboxState) {
          this.$store.dispatch("task/localFinished", item);
        } else {
          this.$store.dispatch("task/localUnfinished", item);
        }
      }
    },

    transition(item) {
      // 休憩モードだったら集中モードで初期スタート
      if (this.pomodoroMode === "break") {
        this.$store.dispatch("pomodoro/initConcentration");
      }
      // ログインしていれば、ポモドーロ数を初期化
      if (this.userId) {
        this.$store.dispatch("pomodoro/initPomodoroCount", this.userId);
      }
      // すでにポモドーロタイマーをスタートしたことがあれば
      if (this.nowTask) {
        // 選択したタスクがスタートしているポモドーロタイマーと一緒だったら
        if (this.nowTask.task_id === item.task_id) {
          // モードがプレイでなければ、保存されているタイマー値をセット
          if (this.playMode !== "play") {
            this.$store.dispatch("pomodoro/setStateTime", item.timer);
          }
          // タイマー画面に遷移
          this.$router.push({ name: "Timer", params: { task: item } });
        } else {
          // 選択したタスクがスタートしているポモドーロタイマーと異なってプレイ中なら
          if (this.playMode === "play") {
            // 確認画面を表示
            this.$store.dispatch("pomodoro/setNewTask", item);
            this.$store.dispatch("pomodoro/open");
          } else {
            // その他の状態であれば新しいタイマー値をセット
            this.$store.dispatch("pomodoro/setStateTime", item.timer);
            this.$router.push({ name: "Timer", params: { task: item } });
          }
        }
      } else {
        this.$store.dispatch("pomodoro/setStateTime", item.timer);
        // this.$store.dispatch("pomodoro/setStateTime", 15);
        this.$router.push({ name: "Timer", params: { task: item } });
      }
    }
  }
};
</script>
