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
  computed: {
    ...mapGetters({
      color: "pomodoro/color"
    })
  },

  methods: {
    start() {
      this.$store.dispatch("pomodoro/start");
    }
  }
};
</script>
