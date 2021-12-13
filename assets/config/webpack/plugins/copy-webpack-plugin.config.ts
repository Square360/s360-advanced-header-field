// CopyWebpackPlugin
// @see https://webpack.js.org/plugins/copy-webpack-plugin/#options

import * as path from 'path';

let copyWebpackPluginConfig: any[] = [];

let foldersToCopy: string[] = [
  // Add folders that should be copied.
];

let foldersToIgnore: string[] = [
  // Add folders that are nested inside any "foldersToCopy" folders that should be skipped.
];

// DO NOT EDIT THIS!
foldersToCopy.forEach((folder) => {
  copyWebpackPluginConfig.push({
    context: path.resolve('src', folder),
    from: '**/*',
    to: folder,
    globOptions: {
      ignore: foldersToIgnore
    }
  });
});

export default copyWebpackPluginConfig;
