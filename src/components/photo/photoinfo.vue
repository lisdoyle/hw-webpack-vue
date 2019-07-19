<template>
  <div>
    <!-- 标题区域 -->
    <h3 class="title">{{info.title}}</h3>
    <p class="subtitle">
      <span>发表时间：</span>
      <span>点击：0次</span>
    </p>
    <hr>


    <!-- 缩略图区域 -->

    <!-- 内容区域 -->
    <div class="content" v-html="info.content"></div>
    
    <!-- 评论框区域 -->
    <comment-box :id="indexid"></comment-box>

  </div>
</template>
<script>
import Axios from 'axios';
import comment from '../subcomponents/comment.vue'

export default {
  created(){
    this.getphotoinfo();
  },
  data(){
    return{
      indexid:this.$route.params.indexid,
      info:{}
    }
  },
  methods:{
    getphotoinfo(){
      var $this = this;
      Axios.get('caozuo.php',{
        params:{
          act:'getphotoinfo',
          indexid:$this.indexid,
        }
      })
      .then(function(response){
        console.log(response);
        $this.info=response.data[0]
      })
      .catch(function(response){
        console.log("获取图片信息失败："+response);
      });
    },
  },
  // 导入子组件
  components:{
    'comment-box':comment
  }
}
</script>

<style scoped>

</style>
