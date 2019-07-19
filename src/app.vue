<template>
  <div id='app-container'>
    <!-- top bar区域 mui支持-->
    <header id="header" class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">导航栏</h1>
		</header>

    <!-- 控制组件过渡 -->
		<transition>
			<!-- router-view区域 -->
			<router-view></router-view>
		</transition>
		

    <!-- tab bar区域 mui支持-->
    <nav class="mui-bar mui-bar-tab">
			<router-link class="mui-tab-item" to="/home">
				<span class="mui-icon mui-icon-home"></span>
				<span class="mui-tab-label">首页</span>
			</router-link>
			<router-link class="mui-tab-item" to="/member">
				<span class="mui-icon mui-icon-contact"></span>
				<span class="mui-tab-label">会员</span>
			</router-link>
			<router-link class="mui-tab-item" to="/cart">
				<span class="mui-icon mui-icon-email"><span class="mui-badge">9</span></span>
				<span class="mui-tab-label">购物车</span>
			</router-link>
			<router-link class="mui-tab-item" to="search">
				<span class="mui-icon mui-icon-search"></span>
				<span class="mui-tab-label">搜索</span>
			</router-link>
		</nav>


    
  </div>
</template>

<script>
	// miu点击报错修正,mui禁用了a标签的href ，修复tab栏 a 标签的href问题
	import mui from './lib/mui/js/mui.js'
	export default{
		mounted(){
			mui('body').on('tap','a',function(){document.location.href=this.href;});
		}
	}
</script>

<style scoped>
/* 调整导航栏空隙 */
  #app-container{
		background: #ffffff;
    padding-top: 44px;/* 导航栏不遮住内容 */
		padding-bottom: 50px;/* tab栏不遮住内容 */
		overflow-x: hidden;/* x轴方向超出界面的隐藏，解决组件过渡时页面被扩大 */
  }

/* 消除tabbar跳转警告 */
	*{touch-action: none}

/* 控制组件过渡 */
	.v-enter{
		opacity: 0;
		transform: translateX(100%);
		/* 进入前状态：不透明度为0；x轴偏移到页面右侧外 */
	}
	.v-leave-to{
		opacity: 0;
		transform: translateX(-100%);
		position: absolute;
		/* 离开后状态：绝对定位可以把要离开的组件从瀑布流中脱离，解决进入组件的位移问题。 */
	}
	.v-enter-active,
	.v-leave-active{
		opacity: 1;
		transition: all 0.5s ease;
		/* 进入到、离开前状态： */
	}


</style>
