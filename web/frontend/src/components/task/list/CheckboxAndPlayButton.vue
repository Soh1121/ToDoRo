<template>
  <v-list-item-action>
    <v-checkbox
      :input-value="checkboxState"
      @change="onChange(task)"
    ></v-checkbox>
    <v-icon @click="transition(task)">mdi-play-circle-outline</v-icon>
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
      mode: state => state.pomodoro.mode
    }),

    ...mapGetters({
      userId: "auth/user_id"
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
      if (this.mode === "break") {
        this.$store.dispatch("pomodoro/initConcentration");
      }
      if (this.userId) {
        this.$store.dispatch("pomodoro/initPomodoroCount", this.userId);
      }
      // this.$store.dispatch("pomodoro/setStateTime", item.timer);
      this.$store.dispatch("pomodoro/setStateTime", 15);
      this.$router.push({ name: "Timer", params: { task: item } });
    }
  }
};
</script>
