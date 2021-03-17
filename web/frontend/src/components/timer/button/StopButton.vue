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
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      color: "pomodoro/color"
    })
  },

  methods: {
    reset() {
      this.$store.dispatch("pomodoro/reset");
    }
  }
};
</script>
