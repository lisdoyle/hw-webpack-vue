//入口文件

//导入mui样式
import './lib/mui/css/mui.css'
import './lib/mui/fonts/mui.ttf'
import './lib/mui/js/mui.js'

//导入vue模块
import Vue from 'vue'
import app from './app.vue'

var vm = new Vue({
  el:'#app',
  render:function (c){
    return c(app)
  }
})