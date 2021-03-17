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
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      color: "pomodoro/color"
    })
  },

  methods: {
    pause() {
      this.$store.dispatch("pomodoro/pause");
    }
  }
};
</script>
