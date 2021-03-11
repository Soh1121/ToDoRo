<template>
  <v-btn
    rounded
    width="100px"
    height="50px"
    color="primary"
    class="u-margin__margin--t50px"
    @click="start"
  >
    開始
  </v-btn>
</template>

<script>
export default {
  methods: {
    start() {
      this.$emit("start");
    }
  }
};
</script>
