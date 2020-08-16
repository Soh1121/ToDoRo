<template>
  <v-card>
    <v-tabs color="orange">
      <v-tab @click="tab = 1">ログイン</v-tab>
      <v-tab @click="tab = 2">新規登録</v-tab>
    </v-tabs>
    <form v-show="tab === 1" @submit.prevent="login">
      <v-card-text>
        <v-container>
          <v-row
            v-if="loginErrors"
            class="font-weight-bold red--text text--darken-3"
          >
            <ul v-if="loginErrors.email">
              <li v-for="msg in loginErrors.email" :key="msg">
                {{ msg }}
              </li>
            </ul>
            <ul v-if="loginErrors.password">
              <li v-for="msg in loginErrors.password" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="メールアドレス"
                required
                color="orange"
                v-model="loginForm.email"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="パスワード"
                required
                color="orange"
                v-model="loginForm.password"
                :append-icon="login_show ? 'mdi-eye-off' : 'mdi-eye'"
                :type="login_show ? 'text' : 'password'"
                @click:append="login_show = !login_show"
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="orange" text @click="close">キャンセル</v-btn>
        <v-btn type="submit" color="orange" dark @click="clearError"
          >ログイン</v-btn
        >
      </v-card-actions>
    </form>
    <form v-show="tab === 2" @submit.prevent="register">
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="ユーザー名 *"
                hint="英数字・ハイフン・アンダーバーを利用可能"
                required
                color="orange"
                v-model="registerForm.name"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="メールアドレス *"
                required
                color="orange"
                v-model="registerForm.email"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="パスワード *"
                hint="英数字・記号を利用可能"
                required
                color="orange"
                v-model="registerForm.password"
                :append-icon="register_show ? 'mdi-eye-off' : 'mdi-eye'"
                :type="register_show ? 'text' : 'password'"
                @click:append="register_show = !register_show"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="パスワード確認 *"
                required
                color="orange"
                v-model="registerForm.password_confirmation"
                :append-icon="confirmation_show ? 'mdi-eye-off' : 'mdi-eye'"
                :type="confirmation_show ? 'text' : 'password'"
                @click:append="confirmation_show = !confirmation_show"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-spacer />
            <p>「*」は入力必須</p>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="orange" text @click="close">キャンセル</v-btn>
        <v-btn type="submit" color="orange" dark>登録</v-btn>
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      tab: 1,
      login_show: false,
      register_show: false,
      confirmation_show: false,
      loginForm: {
        email: "",
        password: ""
      },
      registerForm: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      }
    };
  },
  methods: {
    close() {
      this.$store.dispatch("auth/close");
      this.$store.commit("auth/setLoginErrorMessages", null);
    },
    async login() {
      // authストアのloginアクションの呼び出し
      await this.$store.dispatch("auth/login", this.loginForm);
    },
    async register() {
      // authストアのregisterアクションの呼び出し
      await this.$store.dispatch("auth/register", this.registerForm);
    },
    clearError() {
      this.$store.commit("auth/setLoginErrorMessages", null);
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      loginErrors: state => state.auth.loginErrorMessages
    })
  }
};
</script>
