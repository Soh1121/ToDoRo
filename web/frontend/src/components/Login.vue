<template>
  <v-card>
    <v-tabs color="orange">
      <v-tab @click="tab = 1">ログイン</v-tab>
      <v-tab @click="tab = 2">新規登録</v-tab>
    </v-tabs>
    <v-card-text v-show="tab === 1">
      <v-container>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="メールアドレス" required color="orange" v-model="loginForm.email" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field
              label="パスワード"
              required
              color="orange"
              v-model="loginForm.password"
              :append-icon="loginForm.show ? 'mdi-eye' : 'mdi-eye-off'"
              :type="loginForm.show ? 'text' : 'password'"
              @click:append="loginForm.show = !loginForm.show"
            />
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-text v-show="tab === 2">
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
            <v-text-field label="メールアドレス *" required color="orange" v-model="registerForm.email" />
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
              :append-icon="registerForm.show ? 'mdi-eye' : 'mdi-eye-off'"
              :type="registerForm.show ? 'text' : 'password'"
              @click:append="registerForm.show = !registerForm.show"
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
              :append-icon="registerForm.show_confirmation ? 'mdi-eye' : 'mdi-eye-off'"
              :type="registerForm.show_confirmation ? 'text' : 'password'"
              @click:append="registerForm.show_confirmation = !registerForm.show_confirmation"
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
      <v-btn color="orange" text @click="closeByEmit">キャンセル</v-btn>
      <v-btn color="orange" dark @click="closeByEmit" v-show="tab === 1">ログイン</v-btn>
      <v-btn color="orange" dark @click="closeByEmit" v-show="tab === 2">登録</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: ["dialog"],
  data() {
    return {
      tab: 1,
      loginForm: {
        email: "",
        password: "",
        show: false
      },
      registerForm: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        show: false,
        show_confirmation: false
      }
    };
  },
  methods: {
    closeByEmit() {
      this.$emit("close-click", (this.dialog = false));
    }
  }
};
</script>
