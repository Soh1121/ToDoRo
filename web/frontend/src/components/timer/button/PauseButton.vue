<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    :color="color"
    class="u-margin__margin--t50px"
    @click="pause"
  >
    一時停止
  </v-btn>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    task: {
      type: Object
    }
  },

  computed: {
    ...mapGetters({
      userId: "auth/user_id",
      color: "pomodoro/color"
    })
  },

  methods: {
    async pause() {
      this.$store.dispatch("pomodoro/pause");
      if (this.userId) {
        await this.$store.dispatch("pomodoro/updateTimer", [
          this.userId,
          this.task
        ]);
      }
    }
  }
};
</script>
