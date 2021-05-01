<template>
  <v-list dense width="100%" expand>
    <v-list-group :value="true" prepend-icon="mdi-clock-time-eight">
      <template v-slot:activator>
        <v-list-item-title>Context</v-list-item-title>
      </template>
      <v-list-item-group mandatory v-model="model">
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
    <v-list-group prepend-icon="mdi-group">
      <template v-slot:activator>
        <v-list-item-title>Project</v-list-item-title>
      </template>
      <List
        v-for="project in projects"
        :key="project.id"
        :icon="project.icon"
        :name="project.name"
        :count="project.count"
      />
    </v-list-group>
  </v-list>
</template>

<script>
import List from "./Drawer_list.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    List
  },

  data() {
    return {
      contexts: [
        { id: 1, name: "今　日", icon: "mdi-moon-full", count: 100 },
        { id: 2, name: "明　日", icon: "mdi-moon-full", count: 212 },
        { id: 3, name: "近日中", icon: "mdi-moon-full", count: 334 }
      ],
      projects: [
        { id: 1, name: "今　日", icon: "mdi-moon-full", count: 100 },
        { id: 2, name: "明　日", icon: "mdi-moon-full", count: 212 },
        { id: 3, name: "近日中", icon: "mdi-moon-full", count: 334 },
        { id: 4, name: "いつか", icon: "mdi-moon-full", count: 101 }
      ],
      model: 0
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
