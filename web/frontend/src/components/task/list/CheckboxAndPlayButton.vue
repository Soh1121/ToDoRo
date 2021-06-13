<template>
  <v-list-item-action>
    <v-checkbox
      :input-value="checkboxState"
      @change="onChange(task)"
    ></v-checkbox>
    <v-dialog v-model="confirmationDialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          icon
          v-on="on"
          v-bind="attrs"
          @click="transition(task)"
          class="u-margin__margin---6px"
          ><v-icon>mdi-play-circle-outline</v-icon></v-btn
        >
      </template>
      <TaskConfirmation />
    </v-dialog>
  </v-list-item-action>
</template>

<script>
import TaskConfirmation from "../TaskConfirmation.vue";
import { mapState, mapGetters } from "vuex";
export default {
  components: {
    TaskConfirmation
  },

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
      mode: state => state.pomodoro.mode,
      taskId: state => state.pomodoro.taskId
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
      if (this.taskId) {
        if (this.taskId === item.task_id) {
          this.$router.push({ name: "Timer", params: { task: item } });
        } else {
          this.$store.dispatch("pomodoro/open");
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
