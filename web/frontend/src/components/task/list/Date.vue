<template>
  <v-list-item-content class="hidden-sm-and-down">
    <v-list-subtitle>
      <v-icon>mdi-calendar-arrow-right</v-icon>
      {{ task.start_date }}
    </v-list-subtitle>
    <v-list-subtitle>
      <v-icon>mdi-calendar-arrow-left</v-icon>
      {{ task.due_date }}
    </v-list-subtitle>
  </v-list-item-content>
</template>

<script>
export default {
  props: {
    task: {
      type: Object
    }
  }
};
</script>
