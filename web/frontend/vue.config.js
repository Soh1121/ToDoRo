module.exports = {
  outputDir: "../public/app",
  publicPath: "/app",
  pages: {
    todo: {
      entry: "src/main.js",
      template: "templates/base.html",
      filename: "../../resources/views/spa/todo.blade.php"
    }
  },
  transpileDependencies: ["vuetify"]
};
