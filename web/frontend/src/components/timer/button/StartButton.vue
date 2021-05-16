<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    :color="color"
    class="u-margin__margin--t50px"
    @click="start"
  >
    開始
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
    start() {
      if (this.userId) {
        this.$store.dispatch("pomodoro/start", [this.userId, this.task]);
      } else {
        this.$store.dispatch("pomodoro/localStart", this.task);
      }
    }
  }
};
</script>
