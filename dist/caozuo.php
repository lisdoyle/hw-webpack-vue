<?php
/* api使用方法 

  1：获取轮播图
    请求：get 
    传参：act=getpic
    api: caozuo.php?act=getpic
    返回：字符串
    "[
    {'img':'sliderimgs/1.jpg','url':'https://baijiahao.baidu.com/s?id=1632173468564844388&wfr=spider&for=pc','num':'1','uid':'1'},
    {'img':'sliderimgs/2.jpg','url':'https://baijiahao.baidu.com/s?id=1631854499889298178&wfr=spider&for=pc','num':'2','uid':'2'},
    ...]"
  
  2：获取新闻列表
    请求：get 
    传参：act=getnewslist
    api: caozuo.php?act=getnewslist
    返回：字符串 id ;add_time;click;content;img_url;title;zhaiyao
    "[
    {'id':'0',add_time': '2019-06-19 17:35:17','click':'0','content':'<p>广告里飞舞的...</p>','img_url':'https://s3.ifanr.com/sd.jpg','title':'再过 30 年，世界人口将逼近百亿','zhaiyao':'再过不到 10 年，中国的'},
    {'id':'1''add_time': '2019-06-19 17:35:17','click':'0','content':'<p>广告里飞舞的...</p>','img_url':'https://s3.ifanr.com/sd.jpg','title':'再过 30 年，世界人口将逼近百亿','zhaiyao':'再过不到 10 年，中国的'},
    ...]"

  3：获取文章内容
    请求：get 
    传参：act=getnewsinfo ； id=文章的id
    api: caozuo.php?act=getnewsinfo&id=1
    返回：新闻列表中的 对应id 的单条新闻
    [
    {'id':'1',add_time': '2019-06-19 17:35:17','click':'0','content':'<p>广告里飞舞的...</p>','img_url':'https://s3.ifanr.com/sd.jpg','title':'再过 30 年，世界人口将逼近百亿','zhaiyao':'再过不到 10 年，中国的'}
    ]
  
  4:评论数据
    请求：get 
    传参：act=getcomment ； id=文章的id； page=评论页；每页3条评论
    api: caozuo.php?act=getcomment&id=1&page=1
    返回：获取对应id 的单条新闻，去找comment_id表  的评论；page对应评论第几页内容。
          uid;user_name;add_time;content
    [
      {'uid':'1','user_name':'小明','add_time':'2019-06-05 04:09:18','content':'小明小'},
      {'uid':'1','user_name':'小明','add_time':'2019-06-05 04:09:18','content':'小明小'},
    ]

  5:发送评论
    请求：post
    传参：act=addcmt; id=文章的id；content=评论内容
    返回：把评论内容传入服务器，返回添加的数量，理论每次传入一条评论，成功添加后返回数字1
  
  6:获取图片分类
    请求：get
    传参：act=getcategory
    返回：cateid=分类编号； cate=分类的名称
    "[
      {cateid:1, cate:'风景'},
      {cateid:2, cate:'人物'}
      ...
    ]"
    获取全部分类，需手动添加{cateid:0, cate:'全部'} unshift到上面返回的数组。

  6:根据图片分类获取图片
    请求：get
    传参：act=getphotolist; cateid=图片分类的id 0是全部分类 1是“人物” 2“风景” 3“居家生活” 4“摄影设计” 5"帅哥美女" 6"香车美人"
    返回：cate:分类的名称； cateid:分类id； content:文章内容；indexid:图片全站唯一编号；title:图片标题；uid:图片表内索引；url:图片地址；zhaiyao:文章摘要
    "[
      {cate:"人物", cateid:"1", content:"6月..",indexid:"photo_1",title:"这是一张人物照片",uid:"1",url:"https:..", zhaiyao:"这是一张.."},
      ...
    ]"
    
*/
  
  //第一步： php创建数据库
  //1.连接服务器数据库
  $link = mysqli_connect('localhost','root','');
  //2.判断连接成功
  if(!$link){
  exit('connect error');
  }
  //3.设置字符集
  mysqli_set_charset($link, 'utf8');
  //4.选择数据库
  $res_select = mysqli_select_db($link, 'VUECMS');


  //5.判断是否成功选择数据库
  if(!$res_select){
    //6.不成功：创建新数据库
    $sql_db = 'create database VUECMS';//创建库语句
    if(!mysqli_query($link, $sql_db)){
      //创建失败，输出提示
      exit('databases created error');
    }
    $res_select = mysqli_select_db($link, 'VUECMS');
  }

  //第二步： 判断get取的act值
  $get=@$_GET['act'];
  
  // 获取payload json数据，转换成数组形式(post形式获取数据必须)
  $postData = file_get_contents('php://input');
  $requests = !empty($postData) ? json_decode($postData, true) : array();

  $pos=@$requests['act'];
 
  // 如果有$get则赋值，否则赋值$pos
  $act=$get ? $get : $pos;
  

  switch($act)
  {
    case 'getpic':
      //1.发送sql语句
      $sql = "select * from slider";
      $res = mysqli_query($link,$sql);
      //2.创建接收数组,用于合并
      $Result = array();
      //2.一行一行循环取出
      while($rows = mysqli_fetch_assoc($res)){
        $list = array();//创建接收数组
        $list[]="'img':'".$rows['img']."'";
        $list[]="'url':'".$rows['url']."'";
        $list[]="'num':'".$rows['num']."'";
        $list[]="'uid':'".$rows['uid']."'";
        //["'id':1'", "'name':'bmw'", "'ctime':'2018'"]
        $aResult[] = implode(',', $list);//["'id':1', 'name':'bmw', 'ctime':'2018'"]
      }

      /*
      $row = mysqli_fetch_assoc($res)拿到的数据是：
      [{"ID"=>1,"name"=>bmw,"ctime"=>"2018"},{"ID"=>1,"name"=>bmw,"ctime"=>"2018"}]
      通过处理变成：
      ["'id':1', 'name':'bmw', 'ctime':'2018'" ,"'id':1', 'name':'bmw', 'ctime':'2018'"]
      */
      //接着要处理成eval()可用的字符串格式
      //[{'id':1', 'name':'bmw', 'ctime':'2018'},{'id':1', 'name':'bmw', 'ctime':'2018'}]

      if(count($aResult)>0)
      {
        echo '[{'.implode('},{', $aResult).'}]';
      }
      else
      {
        echo '[]';
      }

      
    break;

    case 'getnewslist':
      //1.发送sql语句
      $sql = "SELECT * From newslist Order By add_time Desc";
      $res = mysqli_query($link,$sql);
      //2.一行一行循环取出
      $list = array();//创建接收数组
      while($rows = mysqli_fetch_assoc($res)){
        $list[] = $rows; 
        /*
        取出一行数据，php中的数组格式如下：
        array('id'=>'1','name'=>'jj','age'=>'30')
        
        当取完所有数据时，格式如下(这里应该时php的箭头数组形式，但为了观看方便我写成了js的数组形式)：
        $list：[ ['id':'1','name':'jj','age':'30'],['id':'2','name':'hh','age':'28'] ]
        */
      }
      $jsonStr = json_encode($list,JSON_UNESCAPED_UNICODE);
      /*
      json_encode 可把php对象转为json字符串形式，utf-8编码
      JSON_UNESCAPED_UNICODE: 可以不把数据中中文转为utf-8

      $jsonStr： "[{"id":"1","name":"jj","age":"30"},{"id":"2","name":"hh","age":"28"}]"

      前端axios拿到$jsonStr会自动转化成json对象：
      [{"id":"1","name":"jj","age":"30"},{"id":"2","name":"hh","age":"28"}]
      */ 
      echo $jsonStr;
      
    break;

    case 'getnewsinfo':
      $id=$_GET['id'];//获取id号
      $sql = "SELECT * From newslist Where id = $id";
      $res = mysqli_query($link,$sql);
      //2.一行一行循环取出
      $list = array();//创建接收数组
      while($rows = mysqli_fetch_assoc($res)){
        $list[] = $rows; 
      }
      $jsonStr = json_encode($list,JSON_UNESCAPED_UNICODE);
      echo $jsonStr;
    break;

    case 'getcomment':
      $id=$_GET['id'];//获取id号
      $page=$_GET['page'];//获取评论页数page
      $index=($page-1)*3;//每页偏移量
      $comment_id = 'comment_'.$id;//拼接 评论表单 comment_id

      // 判断是否存在 comment_id 表

      $sql = "SHOW TABLES LIKE '".$comment_id."'";//查询表名
      //mysqli_num_rows() 函数返回结果集中行的数量。
      if(mysqli_num_rows(mysqli_query($link,$sql))==1) {
        //存在表
        //按页查询，每页3条数据
        $sql = "SELECT * FROM {$comment_id} ORDER BY uid DESC LIMIT {$index},3 ";
        $res = mysqli_query($link,$sql);
        //2.一行一行循环取出
        $list = array();//创建接收数组
        while($rows = mysqli_fetch_assoc($res)){
          $list[] = $rows; 
        }
        $jsonStr = json_encode($list,JSON_UNESCAPED_UNICODE);
        echo $jsonStr;
      } else {
        //不存在表
        //创建表
        $sql = "CREATE TABLE {$comment_id} 
        (
          uid INT NOT NULL AUTO_INCREMENT , 
          user_name VARCHAR(200) NOT NULL, 
          add_time TIMESTAMP NOT NULL , 
          content TEXT NOT NULL , 
          PRIMARY KEY (uid)
        )";
        $res = mysqli_query($link,$sql);
        echo '[]';//返回空数组
      }

      
    break;

    case 'addcmt':
      $id=$requests['id'];
      $content=$requests['content'];
      $comment_id = 'comment_'.$id;//新闻对应的评论表名称
      
      //创建当前时间 2019-12-15 12:54:66 形式
      $time=time();
      $add_time=date('Y-m-d H:i:s',$time);
      

      $sql="INSERT INTO {$comment_id} (user_name, add_time, content) VALUE ('匿名', '{$add_time}', '{$content}')";


      $res = mysqli_query($link,$sql);
      $row = mysqli_affected_rows($link);//返回你修改、删除、添加时受影响的行数；成功添加1行返回：1
      echo $row;
    break;
    
    case 'getcategory':
      $sql="SELECT cateid, cate
        FROM photolist
        GROUP BY cateid
      ";
      $res=mysqli_query($link,$sql);
      while($row=mysqli_fetch_assoc($res)){
        $list[]=$row;
      }
      $jsonStr=json_encode($list,JSON_UNESCAPED_UNICODE);
      echo $jsonStr;
    break;

    case 'getphotolist':
      $cateid=$_GET['cateid'];//获取分类id号
      if($cateid==0){
        // cateid=0时,获取全部图片
        $sql="SELECT * FROM photolist";
        $res=mysqli_query($link,$sql);
        while($row=mysqli_fetch_assoc($res)){
          $list[]=$row;
        }
        $jsonStr=json_encode($list,JSON_UNESCAPED_UNICODE);
        echo $jsonStr;
      }else{
        //获取指定cateid的图片
        $sql="SELECT * FROM photolist WHERE cateid={$cateid}";
        $res=mysqli_query($link,$sql);
        while($row=mysqli_fetch_assoc($res)){
          $list[]=$row;
        }
        $jsonStr=json_encode($list,JSON_UNESCAPED_UNICODE);
        echo $jsonStr;
      }
    break;

    case 'getphotoinfo':
      $indexid=$_GET['indexid'];//获取图片索引编号
      $sql="SELECT * FROM photolist WHERE indexid='{$indexid}'";
      $res=mysqli_query($link,$sql);
      while($row=mysqli_fetch_assoc($res)){
        $list[]=$row;
      }
      $jsonStr=json_encode($list,JSON_UNESCAPED_UNICODE);
      echo $jsonStr;
    break;

  }

 


  // 关闭数据库，退出switch
  mysqli_close($link);
?>

