<template>
  <v-card>
    <form @submit.prevent="">
      <v-card-text>
        <v-container>
          <!-- TODO: error処理の実装 -->
          <!-- <v-row
            v-if="contextEditErrors"
            class="font-weight-bold red--text text--darken-3"
          >
            <ul v-if="contextEditErrors.email">
              <li v-for="msg in loginErrors.email" :key="msg">
                {{ msg }}
              </li>
            </ul>
            <ul v-if="loginErrors.password">
              <li v-for="msg in loginErrors.password" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </v-row> -->
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="コンテキスト名"
                hint="30文字以内"
                required
                color="orange"
                v-model="contextEditForm.name"
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="orange" text @click="close">キャンセル</v-btn>
        <v-btn type="submit" color="orange" dark @click="clearError"
          >変更</v-btn
        >
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["id"],

  data() {
    return {
      contextEditForm: {
        name: ""
      },
      display: true
    };
  },

  methods: {
    close() {
      this.$store.dispatch("context/closeEdit");
    },

    async store() {
      // contextストアのstoreアクションの呼び出し
      await this.$store.dispatch("context/store", [
        this.userId,
        this.contextAddForm
      ]);
    }
  },
  computed: {
    ...mapGetters({
      userId: "auth/user_id"
    })
  }
};
</script>
