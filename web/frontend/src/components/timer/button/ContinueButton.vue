<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    :color="color"
    class="u-margin__margin--t50px u-margin__margin--r50px"
    @click="start"
  >
    続ける
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
      this.$store.dispatch("pomodoro/start", [
        this.userId,
        this.task
      ]);
    }
  }
};
</script>
