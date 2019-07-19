<template>
  <div>
    <!-- 轮播图插件 mui-->
    <div class="mui-slider">
      <div class="mui-slider-group">
        <!-- <div class="mui-slider-item"><a href="#"><img src=pics[0].img /></a></div>
        <div class="mui-slider-item"><a href="#"><img src="../../images/2.jpg" /></a></div>
        <div class="mui-slider-item"><a href="#"><img src="../../images/3.jpg" /></a></div>
        <div class="mui-slider-item"><a href="#"><img src="../../images/4.jpg" /></a></div> -->
        <div class="mui-slider-item" v-for="item in pics" :key="item.uid">
          <a href="#"><img :src="item.img" /></a>
        </div>
      </div>

      <div class="mui-slider-indicator">
        <div class="mui-indicator mui-active"></div>
        <div class="mui-indicator"></div>
        <div class="mui-indicator"></div>
        <div class="mui-indicator"></div>
		  </div>
    </div>
    
    <!-- 九宫格栅格 -->
    <div>
      <ul class="mui-table-view mui-grid-view mui-grid-9">
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
          <router-link to="/home/newslist">
          <img src="../../images/menu1.png" alt="">
          <div class="mui-media-body">新闻资讯</div></router-link>
        </li>
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
          <router-link to="/home/photolist">
            <img src="../../images/menu2.png" alt="">
            <div class="mui-media-body">图片分享</div>
          </router-link>
        </li>
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
          <router-link to="/home/goodslist">
            <img src="../../images/menu3.png" alt="">
            <div class="mui-media-body">商品购买</div>
          </router-link>
        </li>
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
          <img src="../../images/menu4.png" alt="">
          <div class="mui-media-body">留言反馈</div></a></li>
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
          <img src="../../images/menu5.png" alt="">
          <div class="mui-media-body">视频专区</div></a></li>
        <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
          <img src="../../images/menu6.png" alt="">
          <div class="mui-media-body">联系我们</div></a></li>
      </ul>
    </div>


  </div>
</template>

<script>

import mui from '../../lib/mui/js/mui.js'// 解决轮播图 初始化轮 失效问题
import axios from 'axios'


export default {
  created(){
    //组件创建完成阶段获取图片url 传给pics[](此阶段未传达)
    this.getdata();//
    
  },
  updated(){
    //pics[]获取到了url（此阶段传达了）
    //重载mui-slider 解决图片轮播问题，（每当URL更新完都要重载slider才能生效）
    mui('.mui-slider').slider({
      interval:0//自动轮播周期，若为0则不自动播放，默认为0；
    });
  },

  data:function(){
    return {
      pics:[],
    }
  },

  methods:{
    //axios发请求，获取数据返回给data中pics[]
    getdata(){
      var $this = this;

      axios.get('caozuo.php', { 
        params: { 
          act: "getpic" 
        },
      }) 
      .then(function (response) {
        console.log(response);
        //转化json为js 对象
        var jsonStr = response.data;
        var jsonObj = eval('('+jsonStr+')');
        console.log(jsonObj);
        $this.pics = jsonObj;//传给data
      }) 
      .catch(function (error) { 
        console.log("轮播图获取失败："+error); 
      });
    }
  }

}
</script>



<style scoped>
  .mui-slider{
    height: 200px;
  }
  .mui-grid-view.mui-grid-9{
    background: #ffffff;
    border: 0;
  }
  .mui-grid-view.mui-grid-9 img{
    width: 60px;
  }
  .mui-grid-view.mui-grid-9 .mui-table-view-cell{
    border: 0;
  }
</style>