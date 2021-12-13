// url-loader
// @see https://webpack.js.org/loaders/url-loader/#options

let fonts = {
  test: /\.(woff|woff2|eot|ttf|svg)(\?.*$|$)/,
  include: [/fonts/],
  use: [
    {
      loader: 'url-loader',
      options: {
        limit: 1000,
        name: `fonts/[name].[ext]`
      }
    }
  ]
};

export { fonts as RULE_FONT_FILES };
