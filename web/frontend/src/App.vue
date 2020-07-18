<template>
  <div id="app">
    <v-app>
      <header>
        <Navbar />
      </header>
      <main>
        <div class="container">
          <RouterView />
        </div>
      </main>
    </v-app>
  </div>
</template>

<script>
import Navbar from "./components/Navbar.vue";

export default {
  components: {
    Navbar
  }
};
</script>
