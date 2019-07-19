<template>
  <div class="goodslist">
    <div class="goodsitem">
      <img src="https://img10.360buyimg.com/n7/jfs/t1/63571/15/2499/138020/5d0d9882E4b7717f6/763a8e616d8e7295.jpg" alt="">
      <h1 class="title">
        美的（Midea）FS40-13ER 旗舰款电风扇/五叶遥控落地扇/家用静音风扇
      </h1>
      <div class="info">
        <p class="price">
          <span class="new">1999</span>
          <span class="old">2999</span>
        </p>
        <p class="sell">
          <span>热卖中</span>
          <span>剩余60件</span>
        </p>
      </div>
    </div>

    <div class="goodsitem">
      <img src="https://img14.360buyimg.com/n7/jfs/t1/2450/10/9134/121914/5bab3d0aEc84d8682/9abd1e370aa52a75.jpg" alt="">
      <h1 class="title">
        中柏 Jumper 10.1英寸4G+64G全金属轻薄二合一笔记本win10平板电脑Z8350四
      </h1>
      <div class="info">
        <p class="price">
          <span class="new">1999</span>
          <span class="old">2999</span>
        </p>
        <p class="sell">
          <span>热卖中</span>
          <span>剩余60件</span>
        </p>
      </div>
    </div>

    <div class="goodsitem">
      <img src="https://img10.360buyimg.com/n7/jfs/t1/63571/15/2499/138020/5d0d9882E4b7717f6/763a8e616d8e7295.jpg" alt="">
      <h1 class="title">
        美的（Midea）FS40-13ER 旗舰款电风扇/五叶遥控落地扇/家用静音风扇
      </h1>
      <div class="info">
        <p class="price">
          <span class="new">1999</span>
          <span class="old">2999</span>
        </p>
        <p class="sell">
          <span>热卖中</span>
          <span>剩余60件</span>
        </p>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  
}
</script>

<style scoped>

.goodslist{
  padding:7px;
  padding-bottom:0;
  display:flex;
  flex-wrap:wrap;
  justify-content:space-between;
}
.goodsitem{
  box-sizing:border-box;
  margin-bottom:7px;
  padding:5px;
  width:49%;
  border-radius:3px;
  box-shadow:0 0 8px #ccc;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}
.goodsitem img{
  width:100%;
}
.goodsitem .title{
  font-size:14px;
}
.goodsitem .info{
  background:#eee;
}
.goodsitem .info p{
  margin:0;
  padding:10px;
}
.goodsitem .price .new{
  color:red;
  font-weight:bold;
  font-size:16px;
}
.goodsitem .price .old{
  color:gray;
  text-decoration:line-through;
  font-size:12px;
  margin-left:10px;
}
.goodsitem .sell{
  display:flex;
  justify-content:space-between;
  font-size:14px;
  color:gray;
}

</style>
