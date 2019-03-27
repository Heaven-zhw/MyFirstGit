<?php
session_start();
require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
header("Cache-control: private");
$link = connect3();

if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客

if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
    if (isset($_POST)) {
        $semester=$_POST['semester'];
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
            case 'cname':
                $conditionname="课程名";
        }
        $keyword = trim($_POST['keyword']);

        if($semester)//学期数非0，按学期查询
        {
            $query = "select sno,sname,sclass,cname,mname,grade,cno from stugrade where semester={$semester} and {$condition} like '{$keyword}%' ";
            $tipinfoyes="查找第&nbsp<b>".$semester."</b>&nbsp学期&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果如下<br>";
            $tipinfono="没有查找到第&nbsp<b>".$semester."</b>&nbsp学期&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果<br>";

        }
        else{//所有学期的课程,加上学期字段
            $query = "select sno,sname,sclass,cname,mname,grade,cno,semester from stugrade where {$condition} like '{$keyword}%' ";
            $tipinfoyes="查找&nbsp<b>全部</b>&nbsp学期&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果如下<br>";
            $tipinfono="没有查找到&nbsp<b>全部</b>&nbsp学期&nbsp<b>".$conditionname."</b>&nbsp为&nbsp<b>".$keyword."</b>&nbsp的结果<br>";
        }
        //模糊查询
        //select s.sno,sname,sclass,mname,dname,grade from studmname s,sc where sc.sno=s.sno and semester=1
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
                    <a href="ginput.php" class="list-group-item text-center  active">成绩录入与修改</a>
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
                    <div class="panel-heading">成绩录入与修改</div>
                    <div class="panel-body">
                        <form action="ginput.php?act=search" method="post" class="form-horizontal" role="form" onsubmit="return check1()">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">第</label>
                                <div class="col-sm-2">
                                    <select name="semester" id="semester"  class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="0">全部</option>
                                    </select>
                                </div>
                                <label class="col-sm-1 control-label">学期</label>
                                <label class="col-sm-1 control-label">  按</label>
                                <div class="col-sm-2">
                                    <select name="condition" id="condtion" class="form-control">
                                        <option value="sno">学号</option>
                                        <option value="sname">学生姓名</option>
                                        <option value="sclass">班级</option>
                                        <option value="cname">课程名</option>
                                    </select>
                                </div>
                                <label class="col-sm-1 control-label">查询</label>
                                <div class="col-sm-3">
                                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="查询关键词">
                                </div>
                                <div class="col-sm--2">
                                    <button type="submit" class="btn btn-primary">查询</button>
                                </div>
                            </div>

                        </form>

                        <!-- 成绩一栏input-->
                        <table class="table table-striped table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                                <th>班级</th>
                                <th>专业</th>
                                <th>开课学期</th>
                                <th>课程名</th>
                                <th>成绩</th>
                                <th>修改</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
                                if($rows){
                                    echo $tipinfoyes;
                                    $id=0;
                                foreach ($rows as $stuinfo):
                                    $id=$id+1?>

                            <tr>
                                <td><?php echo $stuinfo['sno']; ?></td>
                                <td><?php echo $stuinfo['sname']; ?></td>
                                <td><?php echo $stuinfo['sclass']; ?></td>
                                <td><?php echo $stuinfo['mname']; ?></td>
                                <td><?php if($semester) echo $semester;
                                                else echo $stuinfo['semester'];?></td>
                                <td><?php echo $stuinfo['cname']; ?></td>
                                <td><?php
                                    if ($stuinfo['grade'] == NULL) {
                                //href=doAction.php?sno={$stuinfo['sno']}&cno={$stuinfo['cno']}
                                        echo "<input type=text name=grade{$id} id=grade{$id} size=5 value='暂无'> ";
                                        //跳转的链接
                                        /*href="doAction.php?act=gupdate?sno=<?php echo $stuinfo['sno'];?>&cno=<?php echo $stuinfo['cno'];?>&semester=<?php echo $semester;?>"*/
                                    }

                                else echo "<input type=text name=grade{$id} id=grade{$id} size=5 value={$stuinfo['grade']}> "; ?></td>
                                <td><button onclick="update(<?php echo $id;?>,'<?php echo $stuinfo['sno'];?>','<?php echo $stuinfo['cno'];?>')" >提交</button></td>
                            </tr>
                            <?php endforeach;}
                            else {
                                echo $tipinfono;
                            }
                            }

                            ?>

                            </tbody>

                        </table>
                        <script>
                            function getvalue(id) {
                                var gid="grade"+id.toString();
                                //alert(gid);
                                return document.getElementById(gid).value;
                            }
                            //更新
                            function update(id,sno,cno) {
                                var grade=getvalue(id);
                                var reg=/^(?:[1-9]?\d|100)$/;  //正则匹配0-100，非获取匹配
                                if(!reg.test(grade)) {
                                    alert("请输入0-100的整数！");
                                    return;
                                }
                                else {//符合规范跳转
                                    var url="doAction.php?act=gupdate&sno="+sno+"&cno="+cno+"&grade="+grade;
                                    //alert(url);
                                    window.location=url;

                                }


                            }

                            //判断输入框是否为空
                            function check1() {
                                var word=document.getElementById("keyword");
                                var reg=/^(?:\S+)$/;
                                if(!reg.test(word.value)) {
                                    alert("请输入查询条件，不能带空格");
                                    word.focus();
                                    return false;
                                }
                                else {
                                    return true;
                                }

                            }

                        </script>

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