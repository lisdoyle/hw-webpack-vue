import VueRouter from 'vue-router'//第1步：引入vue-router


//第2步：引入路由的组件
import homeCom from "./components/tabbar/home_com.vue"
import memberCom from "./components/tabbar/member_com.vue"
import cartCom from "./components/tabbar/cart_com.vue"
import searchCom from "./components/tabbar/search_com.vue"

//第3步：创建路由对象
var Orouter = new VueRouter({
  routes:[
    {path:'/', redirect: '/home'},
    {path:'/home', component: homeCom},
    {path:'/member', component: memberCom},
    {path:'/cart', component: cartCom},
    {path:'/search', component: searchCom}
  ],
  linkActiveClass:'mui-active'
  //修改默认router-link-active样式
})

export default Orouter
//第4步：暴露出 路由对象