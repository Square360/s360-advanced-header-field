// ProvidePlugin
// @see https://webpack.js.org/plugins/provide-plugin/

let providePluginConfig = {
  '$': 'jquery',
  'jQuery': 'jquery',
  'window.jQuery': 'jquery',
  'window.$': 'jquery'
};

export default providePluginConfig;