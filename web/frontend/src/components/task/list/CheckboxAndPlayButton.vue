<template>
  <v-list-item-action>
    <v-checkbox :input-value="checkboxState" @change="onChange(checkboxState)"></v-checkbox>
    <v-icon>mdi-play-circle-outline</v-icon>
  </v-list-item-action>
</template>

<script>
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

  methods: {
    onChange() {
      this.checkboxState = !this.checkboxState;
      console.log(this.checkboxState);
    }
  }
};
</script>
