// CssMinimizerWebpackPlugin
// @see https://webpack.js.org/plugins/css-minimizer-webpack-plugin/#options
//
// minimizerOptions
// @see https://cssnano.co/docs/optimisations/

import cssMinimizerPlugin from 'css-minimizer-webpack-plugin';

let cssMinimizerWebpackPluginConfig: cssMinimizerPlugin.Options = {
  minimizerOptions: {
    preset: [
      'default',
      {
        discardComments: { removeAll: true },
      },
    ],
  },
};

export { cssMinimizerWebpackPluginConfig as CSS_MINIMIZER_PLUGIN_CONFIG };