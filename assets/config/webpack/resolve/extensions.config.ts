// Resolve.extensions
// @see https://webpack.js.org/configuration/resolve/#resolveextensions

// Define a base set of extensions.
// DO NOT EDIT THIS!
const BASE_EXTENSIONS: string[] = [
  '.js',
  '.ts',
  '.css',
  '.scss',
];

let additionalExtensions: string[] = [
  // Add any additional extensions needed for the project, e.g. '.jsx'
];

// Concat the BASE_EXTENSIONS and additionalExtensions.
// DO NOT EDIT THIS!
const EXTENSIONS: string[] = BASE_EXTENSIONS.concat(additionalExtensions);

export { EXTENSIONS as WEBPACK_RESOLVE_EXTENSIONS };