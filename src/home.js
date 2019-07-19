//入口文件

//导入mui样式
import './lib/mui/css/mui.css'
import './lib/mui/fonts/mui.ttf'
import './lib/mui/js/mui.js'



//挂载vue、vue-router 组件
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
//挂载axios组件 设置全局php文件根路径
import axios from 'axios'
axios.defaults.baseURL = 'http://127.0.0.1/hw-webpack/03.webpack-cms/dist/'


//导入vue组件
import app from './app.vue'
import Orouter from './router.js'

//vm实例
var vm = new Vue({
  el:'#app',
  render:function (c){
    return c(app)
  },
  router:Orouter,
  
})

// //解决mui tab跳转问题
// import mui from './lib/mui/js/mui.js'
// mui('body').on('tap','a',function(){document.location.href=this.href;});
