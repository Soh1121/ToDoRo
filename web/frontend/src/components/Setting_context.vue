<template>
  <div class="u-margin__padding--10px0">
    <div class="u-size__width--94per u-align__block--center">
      <template>
        <v-btn
          depressed
          color="primary"
          class="u-margin__margin--10px0"
          v-bind="attrs"
          @click="add"
        >
          追加
        </v-btn>
      </template>

      <v-data-table
        :headers="headers"
        :items="contexts"
        sort-by="context_id"
        disable-pagination="true"
        hide-default-footer="true"
      >
        <template v-slot:top>
          <v-dialog v-model="dialog" max-width="600px">
            <v-card>
              <v-card-text>
                <v-container>
                  <!-- エラーメッセージ表示部分 -->
                  <v-row
                    v-if="contextNameErrors"
                    class="font-weight-bold red--text text--darken-3"
                  >
                    <ul v-if="contextNameErrors.name">
                      <li v-for="msg in contextNameErrors.name" :key="msg">
                        {{ msg }}
                      </li>
                    </ul>
                  </v-row>
                  <!-- フォーム表示部分 -->
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        label="コンテキスト名"
                        hint="30文字以内"
                        required
                        color="orange"
                        v-model="contextAddForm.name"
                      />
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="orange" text @click="close">
                  キャンセル
                </v-btn>
                <v-btn
                  v-if="isPersistedItem"
                  color="orange"
                  dark
                  @click="update"
                >
                  変更
                </v-btn>
                <v-btn v-else color="orange" dark @click="create">
                  追加
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
        <template v-slot:item.actions="{ item }">
          <div v-if="item.name !== '未設定'">
            <v-icon @click="edit(item)">
              mdi-pencil
            </v-icon>
            <v-icon @click="remove(item)">
              mdi-delete
            </v-icon>
          </div>
        </template>
      </v-data-table>
    </div>
  </div>
</template>

<script>
import { OK } from "../util";
import { mapState, mapGetters } from "vuex";

export default {
  data() {
    return {
      dialog: false,
      // 設定画面に表示するコンテキストデータ
      contexts: [
        {
          context_id: 0,
          name: ""
        }
      ],
      // 設定データ表示用のヘッダー
      headers: [
        {
          text: "コンテキスト名",
          value: "name"
        },
        {
          text: "操作",
          value: "actions",
          align: "center",
          width: "100px"
        }
      ],
      // 設定用のダイアログのフォームデータ
      contextAddForm: {}
    };
  },

  computed: {
    ...mapState({
      apiStatus: state => state.context.apiStatus,
      contextNameErrors: state => state.context.contextNameErrorMessages
    }),

    ...mapGetters({
      userId: "auth/user_id",
      storeContexts: "context/contexts"
    }),

    isPersistedItem() {
      return !!this.contextAddForm.context_id;
    }
  },

  methods: {
    async fetch() {
      const route = "/api/contexts/" + this.userId;
      const response = await window.axios.get(route);

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      let datas = [];
      response.data.data.forEach(function(item) {
        datas.push({
          context_id: item.id,
          name: item.name
        });
      });

      this.contexts = datas;
    },

    add() {
      this.contextAddForm = {};
      this.clearError();
      this.dialog = true;
    },

    async create() {
      await this.$store.dispatch("context/create", [
        this.userId,
        this.contextAddForm
      ]);
      if (this.apiStatus) {
        this.close();
      }
    },

    edit(item) {
      this.contextAddForm = item;
      this.clearError();
      this.dialog = true;
    },

    async update() {
      await this.$store.dispatch("context/update", [
        this.userId,
        this.contextAddForm
      ]);
      if (this.apiStatus) {
        this.close();
      }
    },

    async remove(item) {
      this.contextAddForm = item;
      await this.$store.dispatch("context/remove", [
        this.userId,
        { data: this.contextAddForm }
      ]);
    },

    close() {
      this.dialog = false;
    },

    clearError() {
      this.$store.commit("context/setContextNameErrorMessages", null);
    }
  },

  watch: {
    $route: {
      async handler() {
        const functions = [this.fetch()];
        await Promise.all(functions);
      },
      immediate: true
    },
    storeContexts(values) {
      if (values) {
        let datas = [];
        values["data"].forEach(function(item) {
          datas.push({
            context_id: item.id,
            name: item.name
          });
        });
        this.contexts = datas;
      }
    }
  }
};
</script>
