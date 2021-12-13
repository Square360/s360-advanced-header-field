// Stats
// @see https://webpack.js.org/configuration/stats/#stats-options

let stats = {
  assetsSort: '!size',
  children: false,
  usedExports: false,
  modules: false,
  entrypoints: false,
  excludeAssets: [/\.*\.map/],
  assetsSpace: Infinity,
  modulesSpace: Infinity,
};

export { stats as WEBPACK_STATS };