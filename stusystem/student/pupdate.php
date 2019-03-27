<?php
session_start();
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
                    <a href="backup.php" class="list-group-item text-center ">数据库备份与恢复</a>
                    <a href="pupdate.php" class="list-group-item text-center  active">修改密码</a>
                    <a href="doAction.php?act=logout" class="list-group-item text-center ">退出登录</a>



                </div>
            </div>
            <!-- 右侧内容 -->
            <div class="col-md-9">

                <!-- 自定义内容 -->
                <div class="panel panel-default">
                    <div class="panel-heading">修改密码</div>
                    <div class="panel-body">
                        <?php
                        if($_SESSION['user']=="guest")
                            echo "<b>您尚未登录，请先登录！</b>";
                        else{
                            echo "<form action='doAction.php?act=pupdate' method='post' class='form-horizontal' role='form' onsubmit='return check1()'>
                            <div class='form-group ' >
                                <label class='col-sm-2 control-label'>请输入旧密码</label>
                                <div class='col-sm-3'>
                                    <input type='password' name='oldpass' id='oldpass' class='form-control'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 control-label'>请输入新密码</label>
                                <div class='col-sm-3'>
                                    <input type='password' name='newpass' id='newpass' class='form-control'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 control-label'>请确认新密码</label>
                                <div class='col-sm-3'>
                                    <input type='password' name='newpassagain' id='newpassagain' class='form-control'>
                                </div>
                                <label class='col-sm-2 control-label'></label>
                                <div class='col-sm--2'>
                                    <button type='submit' class='btn btn-primary'>提交</button>
                                </div>
                            </div>

                        </form>";
                        }
                        ?>
                    </div>
                </div>
                <script>

                    function check1() {
                        var old=document.getElementById("oldpass");
                        var new1=document.getElementById("newpass");
                        var new2=document.getElementById("newpassagain");
                        var reg=/^(?:\S+)$/;
                        if(!reg.test(old.value)){
                            alert("请输入旧密码，不能带空格");
                            old.focus();
                            return false;
                        }
                        else if(!reg.test(new1.value)){
                            alert("请输入新密码，不能带空格");
                            new1.focus();
                            return false;
                        }
                        else if(!reg.test(new2.value)){
                            alert("请确认新密码，不能带空格");
                            new2.focus();
                            return false;
                        }
                        else if(new1.value!=new2.value){
                            alert("确认时密码错误，请重新确认新密码");
                            new2.focus();
                            return false;
                        }
                        else{
                            return true;
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