<template>
  <v-data-table
    :headers="headers"
    :items="contexts"
    sort-by="id"
    disable-pagination="true"
    hide-default-footer="true"
  >
    <template v-slot:item.actions="{ item }">
      <v-icon
        @click="edit(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        @click="remove(item)"
      >
        mdi-delete
      </v-icon>
    </template>
  </v-data-table>
  <!-- <v-card>
    <v-list
      class="u-margin__padding--r16l16 u-position__relative u-size__line-height--36px
      u-margin__margin--10px0"
    >
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>
              {{ title }}
            </v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-btn
              v-if="title === '未設定'"
              disabled
              depressed
              absolute
              class="u-position__absolute--right96px"
            >
              編集
            </v-btn>
            <v-btn
              v-else-if="title !== '未設定' && !isEditMode"
              depressed
              absolute
              class="u-position__absolute--right96px"
              @click="changeToEditMode"
            >
              編集
            </v-btn>
            <v-btn
              v-else
              depressed
              absolute
              class="u-position__absolute--right96px"
            >
              変更
            </v-btn>
          </v-list-tile-action>
          <v-list-tile-action>
            <v-btn
              v-if="title === '未設定'"
              disabled
              depressed
              absolute
              class="u-position__absolute--right16px"
              color="error"
            >
              削除
            </v-btn>
            <v-btn
              v-else
              depressed
              absolute
              class="u-position__absolute--right16px"
              color="error"
            >
              削除
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>
    </v-list>
  </v-card> -->
</template>

<script>
import { OK } from "../util";
import { mapGetters } from "vuex";

export default {
  components: {
  },

  data() {
    return {
      contexts: [
        {
          id: 0,
          name: ""
        }
      ],
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
      ]
    }
  },

  computed: {
    ...mapGetters({
      userId: "auth/user_id",
      storeContexts: "context/contexts"
    })
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
          id: item.id,
          name: item.name
        });
      });

      this.contexts = datas;
    },

    edit(context) {
      console.log(context);
    },

    remove(context) {
      console.log(context);
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
            id: item.id,
            name: item.name
          });
        });
        this.contexts = datas;
      }
    }
  }
};
</script>
