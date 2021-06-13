<template>
  <v-list-item-action>
    <v-checkbox
      :input-value="checkboxState"
      @change="onChange(task)"
    ></v-checkbox>
    <v-btn
      icon
      @click="transition(task)"
      class="u-margin__margin---6px"
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
      if (this.pomodoroMode === "break") {
        this.$store.dispatch("pomodoro/initConcentration");
      }
      if (this.userId) {
        this.$store.dispatch("pomodoro/initPomodoroCount", this.userId);
      }
      if (this.nowTask) {
        if (this.nowTask.task_id === item.task_id) {
          this.$router.push({ name: "Timer", params: { task: item } });
        } else {
          if (this.playMode === "play") {
            this.$store.dispatch("pomodoro/open");
          } else {
            // this.$store.dispatch("pomodoro/setStateTime", item.timer);
            this.$store.dispatch("pomodoro/setStateTime", 15);
            this.$router.push({ name: "Timer", params: { task: item } });
          }
        }
      } else {
        // this.$store.dispatch("pomodoro/setStateTime", item.timer);
        this.$store.dispatch("pomodoro/setStateTime", 15);
        this.$router.push({ name: "Timer", params: { task: item } });
      }
    }
  }
};
</script>
