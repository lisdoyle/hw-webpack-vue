//入口文件

//导入mui样式
import './lib/mui/css/mui.css'
import './lib/mui/fonts/mui.ttf'
import './lib/mui/js/mui.js'

//挂载vue、vue-router 组件
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//导入vue组件
import app from './app.vue'
import Orouter from './router.js'

var vm = new Vue({
  el:'#app',
  render:function (c){
    return c(app)
  },
  router:Orouter
})

//解决mui tab跳转问题
import mui from './lib/mui/js/mui.js'
mui('body').on('click','a',function(){document.location.href=this.href;});
