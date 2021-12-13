// BannerPlugin
// @see https://webpack.js.org/plugins/banner-plugin/#options

import { format } from 'date-fns';
import { PROJECT_CONFIG } from '../../project.config';

let bannerPluginConfig = {
  banner: [
    `@client: ${ PROJECT_CONFIG.pkg.client }`,
    (PROJECT_CONFIG.pkg.description !== '') 
      ? `@description: ${ PROJECT_CONFIG.pkg.description }` 
      : undefined,
    `@version: ${ PROJECT_CONFIG.pkg.version }`,
    `@build: ${ format(new Date(), 'yyyy-MM-dd | HHmmss') }`
  ].filter((element) => { return element !== undefined }).join('\n')
};

export default bannerPluginConfig;