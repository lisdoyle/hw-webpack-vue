import VueRouter from 'vue-router'//第1步：引入vue-router


//第2步：引入路由的组件
import homeCom from "./components/tabbar/home_com.vue"
import memberCom from "./components/tabbar/member_com.vue"
import cartCom from "./components/tabbar/cart_com.vue"
import searchCom from "./components/tabbar/search_com.vue"
import newslist from "./components/news/newslist.vue"
import newsinfo from "./components/news/newsinfo.vue"
import photolist from "./components/photo/photolist.vue"
import photoinfo from "./components/photo/photoinfo.vue"
import goodslist from "./components/goodslist/goodslist.vue"

//第3步：创建路由对象
var Orouter = new VueRouter({
  routes:[
    {path:'/', redirect: '/home'},
    {path:'/home', component: homeCom},
    {path:'/member', component: memberCom},
    {path:'/cart', component: cartCom},
    {path:'/search', component: searchCom},
    {path:'/home/newslist', component: newslist},
    {path:'/home/newsinfo/:id', component: newsinfo},
    {path:'/home/photolist', component: photolist},
    {path:'/home/photoinfo/:indexid', component: photoinfo},
    {path:'/home/goodslist', component: goodslist},
    
  ],
  linkActiveClass:'mui-active'
  //修改默认router-link-active样式
})

export default Orouter
//第4步：暴露出 路由对象