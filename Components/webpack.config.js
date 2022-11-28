var path = require('path');

module.exports = {
  
 
  entry: './App.js',
  output: {
    path: path.resolve(__dirname, './../Scripts/'),
    filename: 'components.js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-react']
          }
        }
      },
      
      {
        test: /\.css$/i,
        use: ["style-loader", "css-loader"],
      },
      {
        test: /\.(png|jpe?g|gif)$/i,
        use: 
          {
            loader: 'file-loader',
          }
      }
    ]
  }
}