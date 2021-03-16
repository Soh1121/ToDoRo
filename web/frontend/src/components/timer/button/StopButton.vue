<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    color="primary"
    class="u-margin__margin--t50px"
    @click="reset"
  >
    停止
  </v-btn>
</template>

<script>
export default {
  methods: {
    reset() {
      this.$store.dispatch("pomodoro/reset");
    }
  }
};
</script>
