// Resolve.alias
// @see https://webpack.js.org/configuration/resolve/#resolvealias

import * as path from 'path';

// Define a base set of aliases.
// DO NOT EDIT THIS!
const BASE_ALIASES = {
  SRC_STYLES: path.resolve('src/scss'),
  SRC_IMAGES$: path.resolve('src/images'),
  SRC_VENDORS: path.resolve('src/vendors')
};

let additionalAliases = {
  // Add any additional aliases needed for the project.
};

// Merge the BASE_ALIASES and additionalAliases using the spread operator.
// DO NOT EDIT THIS!
const ALIASES = {
  ...BASE_ALIASES,
  ...additionalAliases
};

export { ALIASES as WEBPACK_RESOLVE_ALIAS };
