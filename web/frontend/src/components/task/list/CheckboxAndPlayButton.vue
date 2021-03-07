<template>
  <v-list-item-action>
    <v-checkbox
      :input-value="checkboxState"
      @change="onChange(task)"
    ></v-checkbox>
    <v-icon @click="transition(task)">mdi-play-circle-outline</v-icon>
  </v-list-item-action>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    task: {
      type: Object
    }
  },

  data() {
    return {
      checkboxState: this.task.finished === 1 ? true : false
    };
  },

  computed: {
    ...mapGetters({
      userId: "auth/user_id"
    })
  },

  methods: {
    async onChange(item) {
      this.checkboxState = !this.checkboxState;
      if (this.checkboxState) {
        await this.$store.dispatch("task/finished", [this.userId, item]);
      } else {
        await this.$store.dispatch("task/unfinished", [this.userId, item]);
      }
    },

    transition(item) {
      this.$router.push({ name: "Timer", params: { task: item } });
    }
  }
};
</script>
