<?php

require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
$link = connect3();

if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>学籍管理</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <script text="text/javascript" src="static/js/jquery-3.1.0.min.js"></script>
    <style type="text/css">
        body{ font-family: 'Microsoft YaHei';}
        /*.panel-body{ padding: 0; }*/
        span{
            color: blue;
        }
    </style>
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <h1>学生学籍管理系统 V1.0</h1>
        <h2><?php echo '欢迎您，'.$_SESSION['user']?></h2>

    </div>
</div>
<div class="container">
    <div class="main">
        <div class="row">
            <!-- 左侧内容 -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="layout-index.php" class="list-group-item text-center">查看学生</a>
                    <a href="sadd.php" class="list-group-item text-center">新增学生</a>
                    <a href="ginput.php" class="list-group-item text-center ">成绩录入与修改</a>
                    <a href="gsearch.php" class="list-group-item text-center ">单科成绩查询</a>
                    <a href="evaluate.php" class="list-group-item text-center ">学生评价</a>
                    <a href="graduate.php" class="list-group-item text-center  ">毕业管理</a>
                    <a href="toexcel.php" class="list-group-item text-center">生成报表</a>
                    <a href="backup.php" class="list-group-item text-center active">数据库备份与恢复</a>
                    <a href="pupdate.php" class="list-group-item text-center ">修改密码</a>
                    <a href="doAction.php?act=logout" class="list-group-item text-center ">退出登录</a>



                </div>
            </div>
            <!-- 右侧内容 -->
            <div class="col-md-9">

                <!-- 自定义内容 -->
                <div class="panel panel-default">
                    <div class="panel-heading">数据库备份与恢复</div>
                    <div class="panel-body">
                        <label class="col-sm-2 control-label">备份数据库：</label>
                        <button class="col-sm-2 btn btn-primary" onclick="backup()">备份</button>
                        <label class="col-sm-2 control-label"></label>
                        <label class="col-sm-2 control-label">恢复数据库：</label>
                        <button class="col-sm-2 btn btn-primary" onclick="restore()">恢复</button>




                    </div>
                </div>
                <script>
                    function backup() {
                        var msg = "确定备份？";
                        if (confirm(msg)==true){
                            var url="doAction.php?act=backup";
                            //alert(url);
                            window.location=url;
                        }else{
                            return ;
                        }
                    }
                    function restore() {
                        var msg = "确定恢复？";
                        if (confirm(msg)==true){
                            var url="doAction.php?act=restore";
                            //alert(url);
                            window.location=url;
                        }else{
                            return ;
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</div>
<!-- 尾部 -->
<div class="jumbotron" style=" margin-bottom:0;margin-top:105px;">
    <div class="container">
        <span>&copy; 2018 Heaven Zhang</span>
    </div>
</div>


<script src="static/js/jquery-3.1.0.min.js"></script>
<script src="static/js/bootstrap.min.js"></script>
</body>
</html>