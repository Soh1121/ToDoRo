<template>
  <v-card>
    <v-card-title>
      ポモドーロタイマーが動いているタスクがあります
    </v-card-title>
    <v-card-text>
      現在「{{
        nowTask.name
      }}」のタスクでポモドーロタイマーが動いています。<br />
      新しくタスクをセットしてタイマー画面に移りますか？
    </v-card-text>
    <div class="u-margin__padding--b28px">
      <v-card-actions>
        <v-btn
          width="100%"
          max-width="300px"
          large
          color="primary"
          class="u-margin__margin--lrauto"
          @click="nowTaskPlay"
          >現在のタスクを進める</v-btn
        >
      </v-card-actions>
      <v-card-actions>
        <v-btn
          width="100%"
          max-width="300px"
          large
          color="primary"
          class="u-margin__margin--lrauto"
          @click="newTaskPlay"
          >新しいタスクを行う</v-btn
        >
      </v-card-actions>
      <v-card-actions>
        <v-btn
          width="100%"
          max-width="300px"
          large
          color="primary"
          class="u-margin__margin--lrauto"
          outlined
          @click="close"
          >キャンセル</v-btn
        >
      </v-card-actions>
    </div>
  </v-card>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  props: {
    newTask: {
      type: Object
    }
  },

  computed: {
    ...mapState({
      nowTask: state => state.pomodoro.nowTask,
      newTask: state => state.pomodoro.newTask
    }),

    ...mapGetters({
      userId: "auth/user_id"
    })
  },

  methods: {
    nowTaskPlay() {
      this.$store.dispatch("pomodoro/close");
      this.$router.push({ name: "Timer", params: { task: this.nowTask } });
    },

    async newTaskPlay() {
      this.$store.dispatch("pomodoro/close");
      this.$store.dispatch("pomodoro/pause");
      if (this.userId) {
        await this.$store.dispatch("pomodoro/updateTimer", [
          this.userId,
          this.nowTask
        ]);
      } else {
        this.$store.dispatch("pomodoro/localUpdateTimer", this.nowTask);
      }
      this.$store.dispatch("pomodoro/setStateTime", this.newTask.timer);
      this.$router.push({ name: "Timer", params: { task: this.newTask } });
    },

    close() {
      this.$store.dispatch("pomodoro/close");
    }
  }
};
</script>
