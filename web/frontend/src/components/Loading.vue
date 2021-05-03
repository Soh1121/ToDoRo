<template>
  <v-overlay
    :absolute="absolute"
    :opacity="opacity"
    :value="loading"
    color="#fff"
  >
    <v-progress-circular
      indeterminate
      color="#1976D2"
    ></v-progress-circular>
  </v-overlay>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      absolute: true,
      opacity: 1
    };
  },

  computed: {
    ...mapGetters({
      loading: "load/loading"
    })
  }
};
</script>

