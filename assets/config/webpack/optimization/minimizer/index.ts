import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
const TerserPlugin = require('terser-webpack-plugin');

import { CSS_MINIMIZER_PLUGIN_CONFIG } from './css-minimizer-webpack-plugin.config';
import { TERSER_PLUGIN_CONFIG } from './terser-webpack-plugin.config';

let minimizer: any[] = [];

minimizer.push(new TerserPlugin(TERSER_PLUGIN_CONFIG));
minimizer.push(new CssMinimizerPlugin(CSS_MINIMIZER_PLUGIN_CONFIG));

export { minimizer as WEBPACK_OPTIMIZATION_MINIMIZER };
