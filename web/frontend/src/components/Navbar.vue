<template>
  <div>
    <v-app-bar color="orange darken-1" app fixed dark>
      <v-app-bar-nav-icon />

      <h1>
        <v-toolbar-title>ToDoRo</v-toolbar-title>
      </h1>

      <v-spacer />

      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="検索"
        class="hidden-sm-and-down"
        clearable
      />

      <v-spacer />

      <v-btn icon class="ma-2">
        <v-icon>mdi-plus</v-icon>
      </v-btn>

      <v-menu left bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item>
            <v-list-item-title>設定</v-list-item-title>
          </v-list-item>
          <v-list-item @click="logout">
            <v-list-item-title>ログアウト</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <div class="my-2" v-else>
        <v-dialog v-model="dialog" persistent max-width="600px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn outlined large v-on="on" v-bind="attrs" @click="open"
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
import Login from "./Login.vue";
import { mapState, mapGetters } from "vuex";

export default {
  components: {
    Login
  },
  methods: {
    open() {
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
      dialog: "auth/display"
    })
  }
};
</script>
