<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    color="primary"
    class="u-margin__margin--t50px u-margin__margin--r50px"
    @click="timerContinue"
  >
    続ける
  </v-btn>
</template>

<script>
export default {
  methods: {
    timerContinue() {
      this.$emit("timerContinue");
    }
  }
};
</script>
