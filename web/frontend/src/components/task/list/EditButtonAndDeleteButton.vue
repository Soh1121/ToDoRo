<template>
  <v-list-item-action>
    <v-icon>mdi-pencil</v-icon>
    <v-icon>mdi-delete</v-icon>
  </v-list-item-action>
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
