import * as path from 'path';

const PROJECT_CONFIG = {
  projectName: 's360-advanced-header-field',
  pkg: require(path.resolve('package.json')),
  entryPoints: ['s360-advanced-header-field.js']
};

export { PROJECT_CONFIG };
