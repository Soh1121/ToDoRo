<template>
  <div>
    <Drawar v-bind:drawer="drawer" @drawerOpenAndClose="drawerOpenAndClose" />
    <v-app-bar
      color="orange darken-1"
      app
      dark
      :clipped-left="$vuetify.breakpoint.lgAndUp"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />

      <Router-link to="/" class="u-text__text-decoration-none">
        <h1>
          <v-toolbar-title class="u-text__color-white">ToDoRo</v-toolbar-title>
        </h1>
      </Router-link>

      <v-spacer />

      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="検索"
        class="hidden-sm-and-down"
        clearable
        v-model="keyword"
      />

      <v-spacer />

      <v-dialog
        v-model="taskDialog"
        @click:outside="taskClose"
        max-width="600px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-on="on" v-bind="attrs" class="ma-2" @click="taskOpen">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </template>
        <ControlTask />
      </v-dialog>

      <v-menu left bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item :to="'setting'">
            <v-list-item-title>
              設定
            </v-list-item-title>
          </v-list-item>
          <v-list-item @click="logout">
            <v-list-item-title>ログアウト</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <div class="my-2" v-else>
        <v-dialog v-model="loginDialog" persistent max-width="600px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn outlined large v-on="on" v-bind="attrs" @click="loginOpen"
              >登録／ログイン</v-btn
            >
          </template>
          <Login />
        </v-dialog>
      </div>
    </v-app-bar>
  </div>
</template>

<script>
import ControlTask from "./ControlTask.vue";
import Drawar from "./Drawer.vue";
import Login from "./Login.vue";
import { mapState, mapGetters } from "vuex";

export default {
  components: {
    ControlTask,
    Drawar,
    Login
  },
  data() {
    return {
      drawer: true,
      keyword: ""
    };
  },
  methods: {
    taskOpen() {
      this.$store.dispatch("task/open", {
        context_id: this.contexts.data[0].id,
        project_id: this.projects.data[0].id,
        term: 0,
        repeat_id: 1,
        priority_id: 1
      });
    },

    drawerOpenAndClose(e) {
      this.drawer = e;
    },

    taskClose() {
      this.$store.dispatch("task/close");
    },

    loginOpen() {
      this.$store.dispatch("auth/open");
    },

    async logout() {
      await this.$store.dispatch("auth/logout");
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus
    }),
    ...mapGetters({
      isLogin: "auth/check",
      username: "auth/username",
      contexts: "context/contexts",
      projects: "project/projects",
      loginDialog: "auth/display",
      taskDialog: "task/display"
    })
  },

  watch: {
    keyword: (value) => {
      console.log(value);
    }
  }
};
</script>
