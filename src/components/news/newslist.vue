<template>
  <div>

    <!-- 新闻列表 v-for循环渲染 -->
    <ul class="mui-table-view">
      <li class="mui-table-view-cell mui-media" v-for="item in newslist" :key="item.id">
        <!-- 拼接url地址 文章标题id 连接到每一篇文章内文 -->
        <router-link :to="'/home/newsinfo/'+item.id">
          <img class="mui-media-object mui-pull-left" :src="item.img_url">
          <div class="mui-media-body">
            <h1>{{ item.title }}</h1>
            <p class="mui-ellipsis">
              <span>发表时间：{{ item.add_time }}</span>
              <span>点击：{{ item.click }}次</span>
            </p>
          </div>
        </router-link>
      </li>
    </ul>
    

  </div>
</template>

<script>

import axios from 'axios'

export default {
  created(){
    // 载入新闻列表
    this.getnewslist();
  },

  data:function(){
    return {
      newslist:[]
    }
  },

  methods:{
    //axios发请求，获取数据返回给data中newslist[]
    getnewslist(){
      var $this = this;

      axios.get('caozuo.php',{
        params: { 
          act: "getnewslist" 
        },
      })
      .then(function(response){
        console.log(response.data);
        $this.newslist = response.data;//传给newslist
      })
      .catch(function(err){
        console.log("新闻列表获取失败："+err);
      })
    }

  }
}

</script>


<style scoped>
  /* 修改新闻列表样式 */
  .mui-table-view .mui-media-body h1{
    font-size: 14px;
  }
  .mui-table-view .mui-ellipsis{
    font-size: 12px;
    color: blue;
    display: flex;
    justify-content: space-between;
  }
</style>
