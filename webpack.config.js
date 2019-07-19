const path = require('path');
const htmlWebpackPlugin = require('html-webpack-plugin');
//引入html-webpack-plugin 
const VueLoaderPlugin = require('vue-loader/lib/plugin')
//15.x之后版本的vue-loader还需要配置插件


//这是 webpack.config.js 配置表
module.exports = {
  mode: 'development',  
  entry: './src/home.js',   //指定入口文件
  output: {      //指定出口文件
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist'),
    // publicPath:'/hw-webpack/03.webpack-cms/dist/' //服务器跟路径
  },

 //----------增加devServer属性-开始------

  devServer: {
    port:3000,  //端口号
    
    //contentBase: path.join(__dirname, "src"),      //服务器从哪里提取内容
    overlay: true //在页面显示错误信息
   },

 //----------增加devServer属性-结束 ------
  plugins:[
    new htmlWebpackPlugin({
      //创建一个 在内存中 生成HTML页面的插件
      template: path.join(__dirname, './src/index.html'), 
      //指定模版页面 之后会根据这个模版页面去生成内存中的页面 
      filename: 'index.html' //指定内存中生成的html页面名字
    }),
    
    new VueLoaderPlugin()
  ],

  module:{
    rules:[
      {
        test: /\.css$/,
        use:['style-loader','css-loader']
      },
      {
        test:/\.(jpg|png|gif|bmp|jpeg)$/,
        use :'url-loader?limit=1024&name=[path][name]-[hash:8].[ext]'
      },
      {
        test:/\.(ttf|eot|svg|woff|woff2)$/,
        use :'url-loader'
      },
      
      {
        test:/\.js$/,
        use :'babel-loader',
        exclude:/node_modules/
      },
      {
        test:/\.vue$/,
        use :'vue-loader'
      }
    ]
  },

  

}