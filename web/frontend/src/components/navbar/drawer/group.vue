<template>
  <v-list dense width="100%" expand>
    <v-list-group :value="true" prepend-icon="mdi-clock-time-eight">
      <template v-slot:activator>
        <v-list-item-title>Context</v-list-item-title>
      </template>
      <v-list-item-group mandatory v-model="contextModel">
        <List
          v-for="(context, i) in contexts"
          :key="i"
          :id="context.id"
          :icon="context.icon"
          :name="context.name"
          :count="context.count"
          :category="'context'"
        />
      </v-list-item-group>
    </v-list-group>
    <v-list-group prepend-icon="mdi-group" :value="true">
      <template v-slot:activator>
        <v-list-item-title>Project</v-list-item-title>
      </template>
      <v-list-item-group mandatory v-model="projectModel">
        <List
          v-for="(project, i) in projects"
          :key="i"
          :id="project.id"
          :icon="project.icon"
          :name="project.name"
          :count="project.count"
          :category="'project'"
        />
      </v-list-item-group>
    </v-list-group>
  </v-list>
</template>

<script>
import List from "./list.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    List
  },

  data() {
    return {
      contexts: null,
      projects: null,
      contextModel: 0,
      projectModel: 0
    };
  },

  methods: {
    async fetch(target) {
      await this.$store.dispatch(target + "/index", [this.userId]);
    }
  },

  computed: {
    ...mapGetters({
      isLogin: "auth/check",
      userId: "auth/user_id",
      storeContexts: "context/contexts",
      storeProjects: "project/projects"
    })
  },

  watch: {
    storeContexts(values) {
      if (values) {
        let datas = [
          {
            id: 0,
            name: "すべて",
            icon: "mdi-moon-full"
          }
        ];
        values["data"].forEach(function(item) {
          datas.push({
            id: item.id,
            name: item.name,
            icon: "mdi-moon-full",
            count: 0
          });
        });
        this.contexts = datas;
      }
    },

    storeProjects(values) {
      if (values) {
        let datas = [
          {
            id: 0,
            name: "すべて",
            icon: "mdi-moon-full"
          }
        ];
        values["data"].forEach(function(item) {
          datas.push({
            id: item.id,
            name: item.name,
            icon: "mdi-moon-full",
            count: 0
          });
        });
        this.projects = datas;
      }
    }
  }
};
</script>
