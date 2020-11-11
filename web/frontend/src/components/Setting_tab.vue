<template>
  <div>
    <v-tabs color="orange">
      <v-tab @click="tab = 1">Context</v-tab>
      <v-tab @click="tab = 2">Project</v-tab>
    </v-tabs>
    <div v-show="tab === 1">
      <ContextSetting />
    </div>
    <div v-show="tab === 2">
      <ProjectSetting />
    </div>
  </div>
</template>

<script>
import ContextSetting from "./Setting_context.vue";
import ProjectSetting from "./Setting_project.vue";

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
}
</script>
