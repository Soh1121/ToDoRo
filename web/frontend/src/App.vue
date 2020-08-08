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
      <footer>
        <Footer />
      </footer>
    </v-app>
  </div>
</template>

<script>
import Navbar from "./components/Navbar.vue";
import Footer from "./components/Footer.vue";

export default {
  components: {
    Navbar,
    Footer
  }
};
</script>
