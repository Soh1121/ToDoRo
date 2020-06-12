module.exports = {
  outputDir: "../public/app",
  publicPath: "/app",
  pages: {
    todo: {
      entry: "src/todo/main.js",
      template: "templates/base.html",
      filename: "../../resources/views/spa/todo.blade.php"
    },
    timer: {
      entry: "src/timer/main.js",
      template: "templates/base.html",
      filename: "../../resources/views/spa/timer.blade.php"
    }
  },
  transpileDependencies: ["vuetify"]
};
