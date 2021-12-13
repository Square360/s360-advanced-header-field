import { CleanWebpackPlugin } from 'clean-webpack-plugin';
import { ProvidePlugin, BannerPlugin } from 'webpack';
import CopyWebpackPlugin from 'copy-webpack-plugin';
import SVGSpritemapPlugin from 'svg-spritemap-webpack-plugin';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';

// --------------------------------------------------
// IMPORT PLUGIN CONFIGURATIONS

import bannerPluginConfig from './banner-plugin.config';
import cleanWebpackPluginConfig from './clean-webpack-plugin.config';
import copyWebpackPluginConfig from './copy-webpack-plugin.config';
import miniCssExtractPluginConfig from './mini-css-extract-plugin.config';
import providePluginConfig from './provide-plugin.config';
import svgSpritemapWebpackPluginConfig from './svg-spritemap-webpack-plugin.config';

// --------------------------------------------------
// DEFINE PLUGINS

let plugins: any[] = [];

plugins.push(new BannerPlugin(bannerPluginConfig));

plugins.push(new CleanWebpackPlugin(cleanWebpackPluginConfig));

if (copyWebpackPluginConfig.length) {
  plugins.push(new CopyWebpackPlugin({
    patterns: copyWebpackPluginConfig
  }));
}

plugins.push(new MiniCssExtractPlugin(miniCssExtractPluginConfig));

plugins.push(new ProvidePlugin(providePluginConfig));

if (svgSpritemapWebpackPluginConfig.length) {
  svgSpritemapWebpackPluginConfig.forEach(svgSpritmap => {
    plugins.push(new SVGSpritemapPlugin(svgSpritmap.patterns, svgSpritmap.options));
  });
}

export { plugins as WEBPACK_PLUGINS };
