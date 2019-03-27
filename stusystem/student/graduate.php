<?php
session_start();
require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
$link = connect3();

if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客

$query = "select sno,sname,dno,mno,sclass from student";
$rows = fetchAll($link, $query);


if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
    if (isset($_POST)) {
        $gyear = $_POST['gyear'];
        $gyearlast = substr($gyear, 2, 2);//截取后两位，与学号前两位代表入学年份
        $mname = $_POST['mname'];
        $mincredit = $_POST['mincredit'];
        //left是SQL语言从左边开始截取字符串的函数
        $query = "select s1.sno,sname,sclass,mname,dname,earncredit from stucredit s1,studmname s2 
                where s1.sno=s2.sno and left(s1.sno,2)<='{$gyearlast}' and mname like '{$mname}%'";
        $tipinfoyes = "查找&nbsp<b>{$gyear}</b>&nbsp年及之前入学&nbsp<b>{$mname}</b>&nbsp专业的学生结果如下<br>";
        $tipinfono = "没有找到&nbsp<b>{$gyear}</b>&nbsp年及之前入学&nbsp<b>{$mname}</b>&nbsp专业的学生<br>";

        $rows = fetchAll($link, $query);
    }
}
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
                    <a href="graduate.php" class="list-group-item text-center  active">毕业管理</a>
                    <a href="toexcel.php" class="list-group-item text-center">生成报表</a>
                    <a href="backup.php" class="list-group-item text-center ">数据库备份与恢复</a>
                    <a href="pupdate.php" class="list-group-item text-center  ">修改密码</a>
                    <a href="doAction.php?act=logout" class="list-group-item text-center ">退出登录</a>


                </div>
            </div>
            <!-- 右侧内容 -->
            <div class="col-md-9">

                <!-- 自定义内容 -->
                <div class="panel panel-default">
                    <div class="panel-heading">毕业管理</div>
                    <div class="panel-body">
                        <form action="graduate.php?act=search" method="post" class="form-horizontal" role="form" onsubmit="return check1()">
                            <div class="form-group">

                                <label class="col-sm-2 control-label">输入毕业生入学年份</label>
                                <div class="col-sm-2">
                                    <input type="text" name="gyear" id="gyear" class="form-control" placeholder="如：2019">
                                </div>
                                <label class="col-sm-2 control-label">输入专业名称</label>
                                <div class="col-sm-3">
                                    <input type="text" name="mname" id="mname" class="form-control" placeholder="如：软件工程">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">输入应修学分</label>
                                <div class="col-sm-3">
                                    <input type="text" name="mincredit" id="mincredit" class="form-control" placeholder="如：100">
                                </div>
                                <div class="col-sm--2">
                                    <button type="submit" class="btn btn-primary">查询</button>
                                </div>
                            </div>

                        </form>
                        <!-- 等待拼接查询语句-->
                        <?php

                        ?>

                        <table class="table table-striped table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                                <th>班级</th>
                                <th>院系</th>
                                <th>专业</th>
                                <th>应修学分</th>
                                <th>实修学分</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
                                if ($rows) {
                                    echo $tipinfoyes;
                                    foreach ($rows as $stuinfo):?>
                                        <tr>
                                            <td><?php echo $stuinfo['sno']; ?></td>
                                            <td><?php echo $stuinfo['sname']; ?></td>
                                            <td><?php echo $stuinfo['sclass']; ?></td>
                                            <td><?php echo $stuinfo['dname']; ?></td>
                                            <td><?php echo $stuinfo['mname']; ?></td>
                                            <td><?php echo $mincredit; ?></td>
                                            <td><?php echo $stuinfo['earncredit']; ?></td>
                                            <td><?php if ($stuinfo['earncredit'] >= $mincredit) echo "可以毕业";
                                                else echo "不能毕业"; ?></td>
                                        </tr>
                                    <?php endforeach;
                                } else {
                                    echo  $tipinfono;
                                    echo $query;
                                }
                            }?>
                            </tbody>
                            <script>

                                function check1() {
                                    var year=document.getElementById("gyear");
                                    var major=document.getElementById("mname");
                                    var credit=document.getElementById("mincredit");
                                    var reg1=/^(?:20[1-8]\d)$/;  //正则匹配0-100，非获取匹配
                                    var reg2=/^(?:\S+)$/;
                                    var reg3=/^(?:\d+)$/;
                                    if(!reg1.test(year.value)) {
                                        alert("年份请输入2010-2089之间的的整数！");
                                        year.focus();
                                        return false;
                                    }
                                    else if (!reg2.test(major.value)) {
                                        alert("请输入专业名，不能带空格");
                                        major.focus();
                                        return false;
                                    }
                                    else if (!reg3.test(credit.value)) {
                                        alert("请输入合法的应修学分");
                                        credit.focus();
                                        return false;
                                    }
                                    else {
                                        return true;
                                    }

                                }
                            </script>

                        </table>
                    </div>
                </div>


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