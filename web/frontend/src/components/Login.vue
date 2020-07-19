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
            <v-text-field label="メールアドレス" required color="orange" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="パスワード" required color="orange" />
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-text v-show="tab === 2">
      <v-container>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="ユーザー名 *" hint="英数字・ハイフン・アンダーバーを利用可能" required color="orange" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="メールアドレス *" required color="orange" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="パスワード *" hint="英数字・記号を利用可能" required color="orange" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="パスワード確認 *" required color="orange" />
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
      <v-btn color="orange" text @click="dialog = false">キャンセル</v-btn>
      <v-btn color="orange" dark @click="dialog = false" v-show="tab === 1">ログイン</v-btn>
      <v-btn color="orange" dark @click="dialog = false" v-show="tab === 2">登録</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      tab: 1,
      dialog: true
    };
  }
};
</script>
