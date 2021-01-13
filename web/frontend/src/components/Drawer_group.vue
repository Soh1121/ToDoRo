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
        v-bind:name="context.name"
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
        v-bind:name="project.name"
        v-bind:count="project.count"
      />
    </v-list-group>
  </v-list>
</template>

<script>
// import { OK } from "../util";
import List from "./Drawer_list.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    List
  },

  data() {
    return {
      contexts: [],
      // contexts: [
      //   {
      //     id: 1,
      //     name: "A_早朝（4:00-6:00）",
      //     icon: "mdi-moon-full",
      //     count: 1
      //   },
      //   {
      //     id: 2,
      //     name: "B_出勤時間帯（6:00-8:00）",
      //     icon: "mdi-moon-full",
      //     count: 2
      //   },
      //   { id: 3, name: "C_朝（8:00-10:00）", icon: "mdi-moon-full", count: 3 },
      //   {
      //     id: 4,
      //     name: "D_午前中（10:00-12:00）",
      //     icon: "mdi-moon-full",
      //     count: 4
      //   },
      //   {
      //     id: 5,
      //     name: "E_昼（12:00-14:00）",
      //     icon: "mdi-moon-full",
      //     count: 5
      //   },
      //   {
      //     id: 6,
      //     name: "F_午後（14:00-16:00）",
      //     icon: "mdi-moon-full",
      //     count: 6
      //   },
      //   {
      //     id: 7,
      //     name: "G_夕方（16:00-18:00）",
      //     icon: "mdi-moon-full",
      //     count: 7
      //   },
      //   {
      //     id: 8,
      //     name: "H_帰宅中（18:00-20:00）",
      //     icon: "mdi-moon-full",
      //     count: 8
      //   },
      //   {
      //     id: 9,
      //     name: "I_夜（20:00-22:00）",
      //     icon: "mdi-moon-full",
      //     count: 9
      //   },
      //   {
      //     id: 10,
      //     name: "J_深夜（22:00-24:00）",
      //     icon: "mdi-moon-full",
      //     count: 10
      //   },
      //   {
      //     id: 11,
      //     name: "A_早朝（4:00-6:00）",
      //     icon: "mdi-moon-full",
      //     count: 1
      //   },
      //   {
      //     id: 12,
      //     name: "A_早朝（4:00-6:00）",
      //     icon: "mdi-moon-full",
      //     count: 1
      //   },
      //   {
      //     id: 13,
      //     name: "A_早朝（4:00-6:00）",
      //     icon: "mdi-moon-full",
      //     count: 1
      //   }
      // ],
      projects: [
        { id: 1, name: "今　日", icon: "mdi-moon-full", count: 100 },
        { id: 2, name: "明　日", icon: "mdi-moon-full", count: 212 },
        { id: 3, name: "近日中", icon: "mdi-moon-full", count: 334 },
        { id: 4, name: "いつか", icon: "mdi-moon-full", count: 101 }
      ]
    };
  },

  methods: {
    async fetch(target) {
      await this.$store.dispatch(target + "/index", [this.userId]);
    }
    // async fetch(target) {
    //   let route = "";
    //   if (target === "projects") {
    //     route = "/api/projects/" + this.userId;
    //   } else if (target === "contexts") {
    //     route = "/api/contexts/" + this.userId;
    //   }
    //   const response = await window.axios.get(route);

    //   if (response.status !== OK) {
    //     this.$store.commit("error/setCode", response.status);
    //     return false;
    //   }

    //   let datas = [];
    //   response.data.data.forEach(function(item) {
    //     datas.push({
    //       id: item.id,
    //       name: item.name,
    //       icon: "mdi-moon-full",
    //       count: 0
    //     });
    //   });

    //   if (target === "projects") {
    //     this.projects = datas;
    //   } else if (target === "contexts") {
    //     this.contexts = datas;
    //   }
    // }
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
    $route: {
      async handler() {
        // const functions = [this.fetch("projects"), this.fetch("contexts")];
        const functions = [this.fetch("context")];
        await Promise.all(functions);
      },
      immediate: true
    },

    storeContexts(values) {
      if (values) {
        let datas = [];
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
        let datas = [];
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
