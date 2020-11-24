<template>
  <v-card>
    <form @submit.prevent="">
      <v-card-text>
        <v-container>
          <v-row
            v-if="contextAddErrors"
            class="font-weight-bold red--text text--darken-3"
          >
            <ul v-if="contextAddErrors.email">
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
                label="コンテキスト名"
                required
                color="orange"
                v-model="contextAddForm.name"
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="orange" text @click="close">キャンセル</v-btn>
        <v-btn type="submit" color="orange" dark @click="clearError"
          >追加</v-btn
        >
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      contextAddForm: {
        name: ""
      },
      display: true
    }
  },
  methods: {
    close() {
      this.$store.dispatch("context/close");
    }
  },
  computed: {
    ...mapState({

    })
  }
}
</script>
