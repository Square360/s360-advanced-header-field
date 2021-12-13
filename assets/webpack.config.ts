import * as path from 'path';
import * as webpack from 'webpack';

import {
  WEBPACK_PLUGINS,
  WEBPACK_EXTERNALS,
  WEBPACK_STATS,
  WEBPACK_OPTIMIZATION_MINIMIZER,
  WEBPACK_RESOLVE_EXTENSIONS,
  WEBPACK_RESOLVE_ALIAS,
  WEBPACK_MODULE_RULES
} from './config/webpack';

import { PROJECT_CONFIG } from './config/project.config';

// --------------------------------------------------
// CONFIGURE WEBPACK

const WEBPACK_CONFIG: webpack.Configuration = {
  entry: PROJECT_CONFIG.entryPoints.reduce((ep, entryPoint: string) => ({ ...ep,
    [entryPoint.substring(0, entryPoint.lastIndexOf('.'))]: path.resolve(`src/js/${ entryPoint }`)
  }), {}),
  externals: WEBPACK_EXTERNALS,
  devtool: (process.env.NODE_ENV == 'production') ? false : 'source-map',
  module: {
    rules: WEBPACK_MODULE_RULES
  },
  optimization: {
    moduleIds: 'named',
    minimizer: WEBPACK_OPTIMIZATION_MINIMIZER
  },
  output: {
    path: path.join(`${ __dirname }/dist`),
    publicPath: '../',
    filename: `js/[name].min.js`
  },
  plugins: WEBPACK_PLUGINS,
  resolve: {
    modules: [
      path.resolve('src/js'),
      'node_modules'
    ],
    extensions: WEBPACK_RESOLVE_EXTENSIONS,
    alias: WEBPACK_RESOLVE_ALIAS
  },
  stats: WEBPACK_STATS
};

export default WEBPACK_CONFIG;
