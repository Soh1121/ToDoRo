<template>
  <v-list-item-action>
    <v-icon @click="edit(task)">mdi-pencil</v-icon>
    <v-icon>mdi-delete</v-icon>
  </v-list-item-action>
</template>

<script>
export default {

  props: {
    task: {
      type: Object
    }
  },

  computed: {

  },

  methods: {
    taskOpen(item) {
      this.$store.dispatch("task/open", item);
    },

    edit(item) {
      this.taskOpen(item);
    }
  }
};
</script>
