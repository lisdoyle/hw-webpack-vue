<template>
  <div class="cmt-container">
    <h3>发表评论</h3>
    <hr>
    <textarea v-model="msg" placeholder="请输入内容（120）" maxlength="120"></textarea>
    <!-- mui按钮 -->
    <button @click="sendcmt" type="button" class="mui-btn mui-btn-primary mui-btn-block">发送</button>
    
    <!-- 评论内容 -->
    <div class="cmt-list" v-for="(item,index) in list" :key="item.uid" >
      <div class="cmt-item">
        <div class="comt-title">
          第{{ index+1 }}楼&nbsp;&nbsp;用户：{{ item.user_name }}&nbsp;&nbsp;发布时间：{{ item.add_time }}
        </div>
        <div class="cmt-body">
          {{ item.content }}
        </div>
      </div>
    </div>
    

    <button type="button" @click="loadmore"  class="mui-btn mui-btn-danger mui-btn-block mui-btn-outlined">更多</button>
  </div>
</template>

<script>
import Axios from 'axios';
import mui from '../../lib/mui/js/mui.js';//调用mui toast

export default {
  created(){
    this.getcomment();
  },
  data(){
    return {
      list:[],
      page:1,
      msg:'',
      num:0
    };
  },
  props:['id'],//继承自来自新闻的id号，父传子给comment.vue的
  methods:{
    getcomment(){
      var $this = this;
      Axios.get('caozuo.php', {
        params:{
          act:"getcomment",
          id: $this.id,
          page:$this.page
        }
      })
      .then(function(response){
        console.log(response);
        // concat把新数组合并到旧数组的后面，这里把获取到的response.data合并到已有的留言数组list后面
        $this.list = $this.list.concat( response.data )
      })
      .catch(function(){
        console.log('获取评论失败：'+response);
      });
    },
    loadmore(){
      // 加载更多按钮
      this.page +=1;
      this.getcomment();
    },
    sendcmt(){//填写的评论发送到服务器
      var $this=this;

      //判断评论是否为空，如为空，return跳出函数
      if($this.msg.trim().length==0){
        return mui.toast('评论不能为空');
      }

      Axios({
        method:"post",
        url:"caozuo.php",
        data:{
          act:'addcmt',
          id:$this.id,
          content:$this.msg
        }
      })
      .then(function(response){
        //response.data返回1 证明成功增加一条评论
        console.log(response);
        if(!response.data == 1){
          mui.toast('评论发送失败');
        }
        mui.toast('评论发送成功');
        //调用插入评论
        $this.addtocmt();
        //清空评论框
        $this.msg='';
      })
      .catch(function(response){
        console.log('发送评论失败：'+response);
      });
    },
    addtocmt(){//编辑填写的评论，手动插入到评论区
      var $this=this;
      
      // 编辑时间
      var date = new Date();
      var Y = date.getFullYear() + '-';
      var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
      var D = date.getDate() + ' ';
      var h = date.getHours() + ':';
      var m = date.getMinutes() + ':';
      var s = date.getSeconds(); 
      var time= Y+M+D+h+m+s;
      
      
      $this.num++;//临时数字作为 v-for的key
      var cmt = {
        add_time: time,
        content: $this.msg.trim(),
        uid: "temp_"+ $this.num,
        user_name: "匿名"
      };

      $this.list.unshift(cmt);
    }


  }
}
</script>

<style scoped>
.cmt-container h3{
  font-size:18px;
}
.cmt-container textarea{
  font-size:16px;
  height:85px;
  margin:0;
}
.cmt-container button{
  height:40px;
  line-height:40px;
  padding:0;
}
.cmt-list{
  font-size:13px;
}
.cmt-list .comt-title{
  background-color:#ccc;
  text-indent:0.5em;
  line-height:30px;
}
.cmt-list .cmt-body{
  text-indent:2em;
  line-height:35px;
}
</style>
