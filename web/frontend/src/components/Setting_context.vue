<template>
  <div class="u-margin__padding--10px0">
    <div class="u-size__width--94per u-align__block--center">
      <v-dialog v-model="dialog" max-width="600px">
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            depressed
            color="primary"
            class="u-margin__margin--10px0"
            v-on="on"
            v-bind="attrs"
            @click="open"
          >
            追加
          </v-btn>
        </template>
        <ContextAdd />
      </v-dialog>

      <CardList
        v-for="context in contexts"
        v-bind:key="context.id"
        v-bind:id="context.id"
        v-bind:title="context.title"
      />
    </div>
  </div>
</template>

<script>
import { OK } from "../util";
import CardList from "./Setting_cardList";
import ContextAdd from "./Setting_contextAdd";
// import { mapGetters } from "vuex";

export default {
  components: {
    CardList,
    ContextAdd
  },
  data() {
    return {
      contexts: [
        {
          id: 0,
          title: ""
        }
      ]
    };
  },
  computed: {
    userId: function() {
      return this.$store.getters["auth/user_id"];
    },
    storeContexts: function() {
      return this.$store.getters["context/contexts"];
    },
    dialog: function() {
      return this.$store.getters["context/display"];
    }
    // ...mapGetters({
    //   userId: "auth/user_id",
    //   dialog: "context/display"
    // })
  },
  methods: {
    open() {
      this.$store.dispatch("context/open");
    },

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
          title: item.name
        });
      });

      this.contexts = datas;
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
        values.forEach(function(item) {
          datas.push({
            id: item.id,
            title: item.name
          });
        });
        this.contexts = datas;
      }
    }
  }
};
</script>
