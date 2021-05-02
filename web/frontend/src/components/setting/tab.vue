<template>
  <v-card>
    <v-tabs color="orange">
      <v-tab @click="tab = 1">Context</v-tab>
      <v-tab @click="tab = 2">Project</v-tab>
    </v-tabs>
    <div v-if="tab === 1">
      <ContextSetting />
    </div>
    <div v-if="tab === 2">
      <ProjectSetting />
    </div>
  </v-card>
</template>

<script>
import ContextSetting from "./context.vue";
import ProjectSetting from "./project.vue";

export default {
  components: {
    ContextSetting,
    ProjectSetting
  },
  data() {
    return {
      tab: 1
    };
  }
};
</script>
