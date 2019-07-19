<template>
  <div>
    <!-- mui tab top滑块导航 -->
    <div id="slider" class="mui-slider">
      <div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
        <div class="mui-scroll">
          <!-- 图片分类 -->
          <!-- 绑定calss一个active方法来显示高亮 -->
          <a v-for="item in category" :key="item.cateid" :class="active(item.cateid)" href="javascript:;" @tap="getphotolist(item.cateid)">{{ item.cate }}</a>
          
        </div>
      </div>

    </div>

    <!-- 图片显示区域 -->
   
    <ul class="photo_container">
      <router-link :to="'/home/photoinfo/'+item.indexid" v-for="item in photolist" :key="item.indexid" tag="li">

        <img :data-src="item.url" src="../../images/loader.gif" class="img">

        <!-- 封面信息 -->
        <div class="info">
          <h1 class="info_title">{{ item.title }}</h1>
          <p class="info_zhaiyao">{{ item.zhaiyao }}</p>
        </div>

      </router-link>
    </ul>
    


  </div>
</template>

<script>

import mui from '../../lib/mui/js/mui.js';
import Axios from 'axios';
import { setTimeout } from 'timers';


export default {
  updated(){
    
  },
  created(){
    this.getcategory();  //获取图片分类
    this.getphotolist(0);  //获取全部分类的图片list
  },
  mounted(){
    // mui滑块功能初始化 才可以使用
    mui('.mui-scroll-wrapper').scroll({
      deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
    });

    
    
  },
  data(){
    return{
      category:[],
      photolist:[],
    }
  },
  watch:{
    photolist:{
      handler: function() {
        var $this = this;
        $this.$nextTick(function(){
          // $nextTick会在DOM渲染完后执行
          setTimeout($this.lazyload,500);
        });
      },
    　immediate: false
    }
  },
  methods:{
    // 给cateid=0的‘全部’分类添加上 高亮样式
    active(cateid){
      if(cateid==0){
        return ['mui-control-item','mui-active'];
      }else{
        return ['mui-control-item'];
      }
    },
    // 获取分类
    getcategory(){
      var $this=this;
      Axios.get('caozuo.php',{
        params: { 
          act: "getcategory" 
        }
      })
      .then(function(response){
        console.log(response);
        response.data.unshift({cateid:0, cate:'全部'});//手动添加‘全部’分类
        $this.category=response.data;
      })
      .catch(function(response){
        console.log("获取照片分类失败："+response);
      });
    },
    // 获取图片
    getphotolist(cateid){
      console.log("cateid:"+cateid);
      var $this=this;
      Axios.get('caozuo.php',{
        params:{
          act:"getphotolist",
          cateid:cateid
        }
      })
      .then(function(response){
        console.log(response);
        $this.photolist=response.data;
        
      })
      .catch(function(response){
        console.log("获取照片list失败："+response);
      });
    },
    //懒加载
    lazyload(){
      console.log("执行了lazyload");

      // 1.获取观测对象节点数组
      var imglist = document.querySelectorAll(".img");
      console.log(imglist);
      
      // 2.创建观测器
      var io = new IntersectionObserver(callback);

      // 3.设置callback
      function callback (entries){
        console.log(entries);
        entries.forEach(function(entry){
          console.log(entry.isIntersecting);
          if(entry.isIntersecting){
            entry.target.src = entry.target.dataset.src;
            io.unobserve(entry.target); 
          }
        });
      }

      // 4.开始观测 传入对象
      imglist.forEach(function(item){ 
        // io.observe接受一个DOM元素，添加多个监听 使用forEach 
        io.observe(item);
        console.log("传入img");
      });
      
    },

  
  }
};
</script>

<style scoped>
.photo_container{
  padding: 0;
  margin: 0 10px;
}
.photo_container li{
  list-style: none;
  margin-bottom: 5px; 
  position: relative;
}
.photo_container li img{
  width: 100%;
  vertical-align:middle;
  /* 修复img 3像素bug */
}
.photo_container .info{
  background: black;
  opacity: 0.7;
  width: 100%;
  padding: 2px 2px 0 2px;
  max-height: 95px;
  /* 调整文字 */
  text-align: left;
  color: white;
  /* 调整位置 */
  position: absolute;
  bottom: 0;
}
.photo_container .info_title{
  font-size: 14px;
  margin: 0;
  padding: 0;
}
.photo_container .info_zhaiyao{
  font-size: 12px;
  margin: 0;
  padding: 0;
}

</style>
