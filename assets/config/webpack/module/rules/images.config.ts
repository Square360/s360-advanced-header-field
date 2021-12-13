// file-loader
// @see https://webpack.js.org/loaders/file-loader/#options
//
// image-webpack-loader
// @see https://github.com/tcoopman/image-webpack-loader#usage

import * as path from 'path';

let images = { test: /\.(gif|png|jpe?g|svg)$/,
  include: path.resolve('src/images'),
  use: [
    {
      loader: 'file-loader',
      options: {
        outputPath: (url: string, resourcePath: string, context: string): string => {
          let relativePath = path.relative(context, resourcePath);

          // Remove "src" from the path.
          relativePath = relativePath.split('/').slice(1).join('/');

          return `${ relativePath }`;
        },
        name: `images/[name].[ext]`
      }
    },
    {
      loader: 'image-webpack-loader',
      options: {
        mozjpeg: {
          quality: 75
        },
        pngquant: {
          quality: [0.65, 0.90],
          speed: 4
        },
        svgo: {
          plugins: [
            {
              removeViewBox: false
            },
            {
              removeEmptyAttrs: false
            }
          ]
        },
        gifsicle: {
          optimizationLevel: 7,
          interlaced: false
        },
        optipng: {
          optimizationLevel: 7,
          interlaced: false
        }
      }
    }
  ]
};

export { images as RULE_IMAGES };
