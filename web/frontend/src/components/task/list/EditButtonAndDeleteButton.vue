<template>
  <v-list-item-action>
    <v-icon @click="edit(task)">mdi-pencil</v-icon>
    <v-icon @click="remove(task)">mdi-delete</v-icon>
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

  computed: {
    ...mapGetters({
      userId: "auth/user_id"
    })
  },

  methods: {
    taskOpen(item) {
      this.$store.dispatch("task/open", item);
    },

    edit(item) {
      this.taskOpen(item);
    },

    async remove(item) {
      if (this.userId) {
        await this.$store.dispatch("task/remove", [
          this.userId,
          { data: item }
        ]);
      } else {
        this.$store.dispatch("task/localRemove", item);
      }
    }
  }
};
</script>
