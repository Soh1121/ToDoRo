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

      <div class="my-2">
        <v-btn outlined large>登録／ログイン</v-btn>
      </div>

      <v-menu left bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item>
            <v-list-item-title>設定</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title>ログアウト</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>

<script>
export default {};
</script>
