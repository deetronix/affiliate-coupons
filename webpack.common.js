const Path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
  entry: {
    admin: Path.resolve(__dirname, 'assets/src/admin/index.js'),
    main: Path.resolve(__dirname, 'assets/src/public/index.js'),
    amp: Path.resolve(__dirname, 'assets/src/public/index-amp.js')
  },
  output: {
    path: Path.join(__dirname, 'assets/dist'),
    filename: '[name].js', // append ?[hash] to fix entry chunks not updated correctly
    chunkFilename: '[name].[chunkhash].js'
  },
  optimization: {
    /*splitChunks: {
      chunks: 'all',
      name: false
    }*/
  },
  plugins: [
    new CleanWebpackPlugin([
        'assets/dist'
    ], { root: Path.resolve(__dirname, '.') }),
  ],
  resolve: {
    alias: {
      '~': Path.resolve(__dirname, 'assets/dist')
    }
  },
  externals: {
    jquery: 'jQuery',
  },
  module: {
    rules: [
      {
        test: /\.mjs$/,
        include: /node_modules/,
        type: 'javascript/auto'
      },
      {
        test: /\.(ico|jpg|jpeg|png|gif|eot|otf|webp|svg|ttf|woff|woff2)(\?.*)?$/,
        use: {
          loader: 'file-loader',
          options: {
            name: '[name].[ext]'
          }
        }
      },
    ]
  }
};
