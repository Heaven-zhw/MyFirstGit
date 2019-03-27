<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客

$sno=$_GET['sno'];
require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
$link = connect3();


$query1 = "select sno,sname,dno,mno,sclass,ssex,sage,saddr from student where sno=".$sno;
$sturow = fetchOne($link, $query1);//取出学生具体信息

$mno=$sturow['mno'];
$dno=$sturow['dno'];
//查学生院系名
$query2= "select dname from dept where dno=".$dno;
$studept =fetchOne($link, $query2)['dname'];

//查学生专业名
$query3= "select mname from major where mno=".$mno;
$stumajor =fetchOne($link, $query3)['mname'];

//查所有院系名
$query4= "select dno,dname from dept";
$deptrows =fetchAll($link, $query4);

//查学生专业名
$query5= "select mno,mname from major";
$majorrows =fetchAll($link, $query5);

?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>form</title>
	<link rel="stylesheet" href="static/css/bootstrap.min.css">
	<style type="text/css">
		body{ font-family: 'Microsoft YaHei';}
		/*.panel-body{ padding: 0; }*/
	</style>

</head>
<body>
<div class="jumbotron">
	<div class="container">
		<h1>学生学籍管理系统 V1.0</h1>
  		<h3>——查看学生详细信息</h3>

	</div>
</div>
<div class="container">
    <div class="main">
        <div class="row">
            <!-- 左侧内容 -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="layout-index.php" class="list-group-item text-center active">查看学生</a>
                    <a href="sadd.php" class="list-group-item text-center">新增学生</a>
                    <a href="ginput.php" class="list-group-item text-center ">成绩录入与修改</a>
                    <a href="gsearch.php" class="list-group-item text-center ">单科成绩查询</a>
                    <a href="evaluate.php" class="list-group-item text-center ">学生评价</a>
                    <a href="graduate.php" class="list-group-item text-center  ">毕业管理</a>
                    <a href="toexcel.php" class="list-group-item text-center">生成报表</a>
                    <a href="backup.php" class="list-group-item text-center ">数据库备份与恢复</a>
                    <a href="pupdate.php" class="list-group-item text-center ">修改密码</a>
                    <a href="doAction.php?act=logout" class="list-group-item text-center ">退出登录</a>
                </div>
            </div>
            <!-- 右侧内容 -->
            <div class="col-md-9">

                <!-- 自定义内容 -->
                <div class="panel panel-default">
                    <div class="panel-heading">学生详细信息</div>
                    <div class="panel-body">
                        <form action="doAction.php?act=update" method="post" class="form-horizontal" role="form" >
                            <div class="form-group">
                                <label class="col-sm-2 control-label">学号</label>
                                <div class="col-sm-5">
                                    <input type="text" id="sno" name="sno" class="form-control" value="<?php echo $sturow['sno']?>" readonly>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-5">
                                    <input type="text" id="sname" name="sname" class="form-control" value="<?php echo $sturow['sname']?>">
                                </div>
                                <div class="col-sm-5">
                                    <p class="form-control-static text-danger">姓名不能为空</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">性别</label>
                                <div class="col-sm-5">
                                    <label class="radio-inline">
                                        <input type="radio" name="ssex" value="男" <?php if ($sturow['ssex']=='男')echo "checked";?> >男
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="ssex" value="女" <?php if ($sturow['ssex']=='女')echo "checked";?> >女
                                    </label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">年龄</label>
                                <div class="col-sm-2">
                                    <input type="text" name="sage" id="sage" class="form-control" value="<?php echo $sturow['sage']?>">
                                </div>
                                <div class="col-sm-5">
                                    <p class="form-control-static text-danger">年龄只能为整数</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">院系</label>
                                <div class="col-sm-5">
                                    <select class="form-control " name="dno" id="dno">
                                    <!--下拉列表中的参数,从数据库中获得-->
                                        <?php foreach ($deptrows as $deptinfo):?>
                                        <option value="<?php echo $deptinfo['dno'];?>"
                                                <?php if($deptinfo['dno']==$dno) echo"selected";?>><?php echo $deptinfo['dname']."(".$deptinfo['dno'].")";?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">专业</label>
                                <div class="col-sm-5">
                                    <select class="form-control " name="mno" id="mno">
                                        <!--下拉列表中的参数-->
                                        <?php foreach ($majorrows as $majorinfo):?>
                                            <option value="<?php echo $majorinfo['mno'];?>"
                                                <?php if($majorinfo['mno']==$mno) echo"selected";?>><?php echo $majorinfo['mname']."(".$majorinfo['mno'].")";?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">班级</label>
                                <div class="col-sm-2">
                                    <input type="text" name="sclass" id="sclass" class="form-control" value="<?php echo $sturow['sclass']?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">家庭住址</label>
                                <div class="col-sm-7">
                                    <input type="text" name="saddr" id="saddr" class="form-control" value="<?php echo $sturow['saddr']?>">
                                </div>
                                <div class="col-sm-3">
                                    <p class="form-control-static text-danger">不超过50个字符</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-3">
                                    <button type="submit" class="btn btn-primary btn-block">修改</button>


                                </div>

                            </div>
                        </form>
                        <div class="col-sm-offset-4 col-sm-3">
                            <button class="btn btn-primary btn-block" onclick="location=location">重置</button>
                        </div>
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