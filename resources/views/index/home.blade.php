<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="沐风跑步,运动,跑步打卡"/>
    <link rel="shortcut icon" href="{{asset('/img/login.png')}}">
    <meta name="copyright" content="版权所有A梦工作室">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>沐风跑步首页</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/index/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/index/css/style.css')}}">
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=9z58wzF2FPAxHG5tLN9lUZb7bGFb6tw7&s=1；"></script>
</head>
<body>

<p><a name="title_top" id="title_top"></a></p>
<header>
    <nav id="header_nav" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a href="#">
                    <img alt="login" src="{{asset('/index/img/login.png')}}">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="link" href="#index">小程序</a></li>
                    <li><a class="link" href="#service">服务项目</a></li>
                    <li><a class="link" href="#moving">最新动态</a></li>
                    <li><a class="link" href="#about">关于我们</a></li>
                    <li><a class="link" href="#contact">联系我们</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="content">
    <div class="index" id="index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-7">
                    <div class="introduce">
                        <div class="jumbotron">
                            <h1>沐风跑步小程序</h1>
                            <p>沐风跑步微信小程序可以在微信中通过“发现-小程序-沐风跑步”的方式打开，不用下载到手机中，因此并不占用手机的内存空间</p>
                            <p><a id="QRV_out" class="btn btn-success" >扫码下载</a></p>

                            <img id="QRV" src="{{asset('/index/img/QRV.jpg')}}" alt="沐风跑步二维码"/>
                        </div>
                </div>
                </div>
                <div class="col-md-5 img_phone">
                    <img class="hid" src="{{asset('/index/img/1.png')}}" alt="效果图">
                </div>
            </div>
        </div>
    </div>
    <div class="service" id="service">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 ser_title">
                    <h1>为什么使用 <span>沐风跑步</span></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 module">
                    <div class="out">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <h4>节省内存</h4>
                    <p>沐风跑步微信小程序可以在微信中通过“发现-小程序-沐风跑步”的方式打开，不用下载到手机中，因此并不占用手机的内存空间。</p>
                </div>
                <div class="col-xs-12 col-md-4 module">
                    <div class="out">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                    </div>
                    <h4>使用灵活</h4>
                    <p>通过微信可以快捷打开小程序，不需要下载。</p>
                </div>
                <div class="col-xs-12 col-md-4 module">
                    <div class="out">
                        <span class="glyphicon glyphicon-unchecked"></span>
                    </div>
                    <h4>活动多多</h4>
                    <p>沐风跑步微信小程通过跑量兑换积分，商城内物品可以凭积分兑换。</p>
                </div>
            </div>
        </div>
    </div>
    <div class="moving" id="moving">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 mov_title">
                    <h1>最新 <span>动态</span></h1>
                    <span class="pull-right"><a href="#"><h3>更多动态>></h3></a></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="news">
                        <img src="{{asset('/index/img/2.jpg')}}" alt="">
                        <div class="caption">
                            <h3>萌芽科技CEO在计算机科学与技术学院创业论坛演讲</h3>
                            <p>6月8号，萌芽科技CEO李思章在山东理工大学计算机科学与技术学院创业论坛发表演讲，李思章演讲的主题是“技能创新+持之以恒=必然成功”，分享了自己的个人创业经历，并通过实例给准备从事技术或开发的同学一些建议，告诉大家要积极尝试新技术、新平台，并注重网络安全。</p>
                        </div>
                        <div class="bottom">
                            <span>更新时间: 2017-10-25</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="news">
                        <img src="{{asset('/index/img/3.jpg')}}" alt="">
                        <div class="caption">
                            <h3>沐风跑团第一次正式约跑圆满结束</h3>
                            <p>萌芽科技负责人李思章，同时也是马拉松运动爱好者，从2016年参加马拉松运动以来，自己收获颇多，由此产生了带动更多的人一起跑步、爱上跑步的想法。沐风跑团和沐风跑团-kids由此诞生，带领大人和6岁以上的孩子们一起跑步。6月8号晚上约7点，沐风跑团第一次约跑在山东理工大学第二体育场进行。</p>
                        </div>
                        <div class="bottom">
                            <span>更新时间: 2017-10-25</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="news news_other">
                        <img src="{{asset('/index/img/1.jpg')}}" alt="">
                        <div class="caption">
                            <h3>沐风跑步商城系统上线的公告</h3>
                            <p>沐风跑步商城系统即将上线，敬请期待！</p>
                        </div>
                        <div class="bottom">
                            <span>更新时间: 2017-10-25</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about" id="about">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 col-md-offset-1">
                    <div class="about_our">
                        <h3>关于我们</h3>
                        <p>我们拥有完善的自主开发体系，秉承“艺术与技术的完美融合”的创作理念，从概念设计、品牌形象、用户体验等各个方面，我们都用心创造最为符合用户需求的产品。 面对未来，坚持专业品质，自主创新，精准的定制化服务是萌芽科技的长期发展规划。</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-md-offset-2 about_pic">
                    <img class="hid" src="{{asset('/index/img/about2.jpg')}}" alt="" >
                </div>
            </div>
        </div>
    </div>
    <div class="contact" id="contact">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-md-3 col-md-offset-1">
                    <div class="con_our">
                        <h3>联系我们</h3>
                        <p>地址：山东省淄博市张店区新村西路266号（山东理工大学西校区东门）大红炉众创空间二层</p>
                        <p>电话：0533-2888520</p>
                        <p>手机：13561669366</p>
                        <p>邮箱：mail@mengyakeji.com</p>
                    </div>
                </div>
                <div class="col-md-offset-1 col-md-7 col-sm-6">
                    <div id="container"></div>
                    <script type="text/javascript">
                        var map = new BMap.Map("container");
                        // 创建地图实例
                        var point = new BMap.Point(118.0162297842,36.8154671950);
                        // 创建点坐标
                        map.centerAndZoom(point, 17);
                        // 初始化地图，设置中心点坐标和地图级别
                        map.addControl(new BMap.NavigationControl()); //左上标尺
                        map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
                        map.addOverlay(new BMap.Marker(point)); // 创建标注到地图中
                        map.addControl(new BMap.MapTypeControl()); //地图类型
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<a id="top" href="#title_top">
    <img src="{{asset('/index/img/top.png')}}" alt="top">
</a>
<footer>
    Copyright © 2017 Company 萌芽科技.
</footer>
<script src="{{asset('/index/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('/index/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/index/js/script.js')}}"></script>
</body>
</html>