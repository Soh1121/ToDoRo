<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    :color="color"
    class="u-margin__margin--t50px"
    @click="reset"
  >
    停止
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
    async reset() {
      if (this.userId) {
        this.$store.dispatch("pomodoro/reset", this.userId);
        await this.$store.dispatch("pomodoro/resetTimer", [
          this.userId,
          this.task
        ]);
      } else {
        this.$store.dispatch("pomodoro/localReset");
        this.$store.dispatch("pomodoro/localResetTimer", this.task);
      }
    }
  }
};
</script>
