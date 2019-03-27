<?php
session_start();

header("Cache-control: private");

require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
$link = connect3();

if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客



if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
    if (isset($_POST)) {
        $condition = $_POST['condition'];
        switch ($condition) {
            case 'sno';
                $conditionname = "学号";
                break;
            case 'sname':
                $conditionname = "学生姓名";
                break;
            case  'sclass';
                $conditionname = "班级";
                break;
        }
        $keyword = trim($_POST['keyword']);
        if ($keyword == "") {
            $keyword = "任意值";
            $query = "select sno,sname,sclass,mname,dname from studmname";
        } else {
            //模糊查询
            $query = "select sno,sname,sclass,mname,dname from studmname where {$condition} like '{$keyword}%' ";
        }

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
                    <a href="layout-index.php" class="list-group-item text-center active">查看学生</a>
                    <a href="sadd.php" class="list-group-item text-center">新增学生</a>
                    <a href="ginput.php" class="list-group-item text-center ">成绩录入与修改</a>
                    <a href="gsearch.php" class="list-group-item text-center ">单科成绩查询</a>
                    <a href="evaluate.php" class="list-group-item text-center ">学生评价</a>
                    <a href="graduate.php" class="list-group-item text-center  ">毕业管理</a>
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
					<div class="panel-heading">学生查询</div>
					<div class="panel-body">
                        <form action="layout-index.php?act=search" method="post" class="form-horizontal" role="form" onsubmit="return checkNull()">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">按</label>
                                <div class="col-sm-3">
                                    <select id="condtion" name="condition" class="form-control">
                                        <option value="sno">学号</option>
                                        <option value="sname">学生姓名</option>
                                        <option value="sclass">班级</option>

                                    </select>
                                </div>
                                <label class="col-sm-1 control-label">查询</label>
                                <div class="col-sm-4">
                                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="查询关键词，为空表示任意值">
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

									<th width="120">操作</th>
								</tr>
							</thead>
                            <tbody>
                            <?php  if(isset($_REQUEST['act'])){

                                if($rows){echo "查找&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果如下<br>";

                                    foreach ($rows as $stuinfo):?>
                                <tr>
                                    <td><?php echo $stuinfo['sno'];?></td>
                                    <td><?php echo $stuinfo['sname'];?></td>
                                    <td><?php echo $stuinfo['sclass'];?></td>
                                    <td><?php echo $stuinfo['dname'];?></td>
                                    <td><?php echo $stuinfo['mname'];?></td>
                                    <td>
                                        <a href="supdate.php?sno=<?php echo $stuinfo['sno'];?>"  target="_Blank">详情</a>
                                        <a href="doAction.php?act=delete&sno=<?php echo $stuinfo['sno'];?>" onclick="return confirmd()">删除</a>
                                    </td>
                                </tr>
                            <?php endforeach;}
                                else{
                                    echo "没有查找到&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果<br>";

                                }
                            }?>
                            </tbody>
                            <!-- 删除字段-->

                            <script type="text/javascript">
                                    function confirmd() {
                                        var msg = "确定删除？";
                                        if (confirm(msg)==true){
                                            return true;
                                        }else{
                                            return false;
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