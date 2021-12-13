// css-loader
// @see https://webpack.js.org/loaders/css-loader/#options
//
// postcss-loader
// @see https://webpack.js.org/loaders/postcss-loader/#options

import MiniCssExtractPlugin from 'mini-css-extract-plugin';

let styles = {
  test: /\.(css|scss)$/,
  use: [
    { loader: MiniCssExtractPlugin.loader,
    },
    { loader: 'css-loader',
      options: {
        url: (url: string): boolean => {
          if (url.includes('images')) {
            return false;
          }
          else {
            return true;
          }
        }
      }
    },
    { loader: 'postcss-loader',
      options: {
        postcssOptions: {
          parser: 'postcss-scss',
          plugins: [
            require('autoprefixer')({
              grid: true
            })
          ]
        }
      }
    },
    { loader: 'sass-loader',
      options: {
        implementation: require('sass')
      }
    }
  ]
};

export { styles as RULE_STYLES };
