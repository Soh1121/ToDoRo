<template>
  <v-list dense width="100%">
    <v-list-group :value="true" prepend-icon="mdi-clock-time-eight">
      <template v-slot:activator>
        <v-list-item-title>Context</v-list-item-title>
      </template>
      <List
        v-for="context in contexts"
        v-bind:key="context.id"
        v-bind:icon="context.icon"
        v-bind:title="context.title"
        v-bind:count="context.count"
      />
    </v-list-group>
    <v-list-group prepend-icon="mdi-group">
      <template v-slot:activator>
        <v-list-item-title>Project</v-list-item-title>
      </template>
      <List
        v-for="project in projects"
        v-bind:key="project.id"
        v-bind:icon="project.icon"
        v-bind:title="project.title"
        v-bind:count="project.count"
      />
    </v-list-group>
  </v-list>
</template>

<script>
import { OK } from '../util';
import List from "./Drawer_list.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    List
  },
  data() {
    return {
      contexts: [
        {
          id: 1,
          title: "A_早朝（4:00-6:00）",
          icon: "mdi-moon-full",
          count: 1
        },
        {
          id: 2,
          title: "B_出勤時間帯（6:00-8:00）",
          icon: "mdi-moon-full",
          count: 2
        },
        { id: 3, title: "C_朝（8:00-10:00）", icon: "mdi-moon-full", count: 3 },
        {
          id: 4,
          title: "D_午前中（10:00-12:00）",
          icon: "mdi-moon-full",
          count: 4
        },
        {
          id: 5,
          title: "E_昼（12:00-14:00）",
          icon: "mdi-moon-full",
          count: 5
        },
        {
          id: 6,
          title: "F_午後（14:00-16:00）",
          icon: "mdi-moon-full",
          count: 6
        },
        {
          id: 7,
          title: "G_夕方（16:00-18:00）",
          icon: "mdi-moon-full",
          count: 7
        },
        {
          id: 8,
          title: "H_帰宅中（18:00-20:00）",
          icon: "mdi-moon-full",
          count: 8
        },
        {
          id: 9,
          title: "I_夜（20:00-22:00）",
          icon: "mdi-moon-full",
          count: 9
        },
        {
          id: 10,
          title: "J_深夜（22:00-24:00）",
          icon: "mdi-moon-full",
          count: 10
        },
        {
          id: 11,
          title: "A_早朝（4:00-6:00）",
          icon: "mdi-moon-full",
          count: 1
        },
        {
          id: 12,
          title: "A_早朝（4:00-6:00）",
          icon: "mdi-moon-full",
          count: 1
        },
        {
          id: 13,
          title: "A_早朝（4:00-6:00）",
          icon: "mdi-moon-full",
          count: 1
        }
      ],
      projects: [
        { id: 1, title: "今　日", icon: "mdi-moon-full", count: 100 },
        { id: 2, title: "明　日", icon: "mdi-moon-full", count: 212 },
        { id: 3, title: "近日中", icon: "mdi-moon-full", count: 334 },
        { id: 4, title: "いつか", icon: "mdi-moon-full", count: 101 }
      ]
    };
  },
  methods: {
    async fetchProjects () {
      const route = '/api/projects/' + this.userId;
      const response = await window.axios.get(route);

      if (response.status !== OK) {
        this.$store.commit('erro/setCode', response.status);
        return false;
      }

      let projects = [];
      response.data.data.forEach( function(item) {
        projects.push({id: item.id, title: item.name, icon: "mdi-moon-full", count: 0})
      });
      this.projects = projects;
    }
  },
  computed: {
    ...mapGetters({
      isLogin: "auth/check",
      userId: "auth/user_id",
    })
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchProjects();
      },
      immediate: true
    }
  }
};
</script>
