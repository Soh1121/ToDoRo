<template>
  <v-card>
    <v-card-title>
      ポモドーロタイマーが動いているタスクがあります
    </v-card-title>
    <v-card-text>
      現在「{{ task.name }}」のタスクでポモドーロタイマーが動いています。<br />
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
          @click="nowTask"
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
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      task: state => state.pomodoro.nowTask
    })
  },

  methods: {
    nowTask() {
      this.$store.dispatch("pomodoro/close");
      this.$router.push({ name: "Timer", params: { task: this.task } });
    },

    close() {
      this.$store.dispatch("pomodoro/close");
    }
  }
};
</script>
