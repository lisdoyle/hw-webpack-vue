<template>
  <div class="newsinfo-container">
    <!-- 标题区域 -->
    <h3 class="title">{{ newsInfo.title }}</h3>
    <!-- 副标题 -->
    <p class="subtitle">
      <span>发表时间：{{ newsInfo.add_time }}</span>
      <span>点击：{{ newsInfo.click }}次</span>
    </p>
    <hr>
    <!-- 内容区域 -->
    <div class="content" v-html="newsInfo.content"></div>
    <!-- 评论框区域 -->
    <comment-box :id="id"></comment-box>
  </div>
</template>

<script>
import Axios from 'axios';
import comment from '../subcomponents/comment.vue' //导入子组件

export default {
  created(){
    this.getNewsInfo();
  },
  data(){
    return{
      id:this.$route.params.id, //url中传入的id号
      newsInfo:[]
    };
  },
  methods:{
    getNewsInfo(){
      var $this = this;
      Axios.get('caozuo.php', {
        params:{
          act:"getnewsinfo",
          id: $this.id
        }
      })
      .then(function(response){
        console.log(response);
        $this.newsInfo = response.data[0];//传给newsInfo
      })
      .catch(function(){
        console.log('获取newsINFO失败：'+response);
      });
    }
  },
  // 导入子组件
  components:{
    'comment-box':comment
  }
}
</script>


<style>
/* 取消scope，改用全局样式 */
  .newsinfo-container{
    padding: 0 4px;
  }
  .newsinfo-container .title{
    font-size: 16px;
    text-align: center;
    margin: 15px 0;
    color: red;
  }
  .newsinfo-container .subtitle{
    font-size: 13px;
    color: blue;
    display: flex;
    justify-content: space-between;
  }
  /* 修改v-html渲染出来的img，因为scope属性会给样式加上编号到达私有化样式，但我们这里的文章图片是通过php获取的，所以，scope并不能在打包阶段为img加上私有编号，所以这里的样式只能取消scope，改用全局样式 */
  .newsinfo-container img{
    width: 100%;
  }
  .newsinfo-container iframe{
    width: 100%;
    height: 100%;
  }
</style>
