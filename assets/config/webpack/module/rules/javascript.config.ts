let javascript = {
  test: /\.(js)$/,
  use: [
    {
      loader: 'babel-loader',
      options: {
        presets: [
          '@babel/preset-env'
        ]
      }
    },
    {
      loader: 'imports-loader',
      options: {
        additionalCode: 'var define = false;',
      }
    }
  ],
  exclude: /node_modules/,
};

export { javascript as RULE_JAVASCRIPT_FILES };