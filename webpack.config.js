const path = require("path");
const webpack = require("webpack");

module.exports = {
  entry: "./js/Base.js",
  mode: "development",
  output: {
    filename: "Bundle.js",
    path: path.resolve(__dirname, "js")
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery"
    })
  ]
};
