let react = { 
  test: /\.(tsx|jsx)?$/,
  exclude: /node_modules/,
  use: {
    loader: 'babel-loader',
    options: {
      presets: [
        '@babel/preset-env',
        '@babel/preset-react',
        '@babel/preset-typescript',
      ]
    }
  }
};

export { react as RULE_REACT };