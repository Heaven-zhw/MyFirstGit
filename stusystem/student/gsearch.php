<?php
session_start();
require_once '../functions/mysql.func.php';
require_once '../config/config.php';
header("content-type:text/html;charset=utf-8");
header("Cache-control: private");
$link = connect3();
if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客

//查学生专业名
$mquery= "select mno,mname from major";
$majorrows =fetchAll($link, $mquery);

//查询年级
$yquery="select distinct(left(sno,2)) as year from student";
$yearrows=fetchAll($link,$yquery);


if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
    if (isset($_POST)) {
        $year=$_POST['year'];
        $mno=$_POST['mno'];
        $cname = trim($_POST['cname']);
        $query1="select mname from major where mno='{$mno}'";
        $mrow=fetchOne($link,$query1);
        $mname=$mrow['mname'];
        //精确查询,只显示非空的课程
        $query2 = "select sno,sname,sclass,cname,mname,grade,cno,semester from stugrade where sno like '{$year}%' and mno='{$mno}' 
                    and cname='{$cname}' and grade is not null order by grade desc ";

        $rows = fetchAll($link, $query2);
        //查询每个分数段人数
        $query3="select count(case when grade between 90 and 100 then 1 end) as n1,
                count(case when grade between 80 and 89 then 1 end) as n2,count(case when grade between 70 and 79 then 1 end) as n3,
                count(case when grade between 60 and 69 then 1 end) as n4,count(case when grade<60 then 1 end) as n5
                from  stugrade where sno like '{$year}%' and mno='{$mno}' and cname='{$cname}' and grade is not null";
        $nn=fetchOne($link,$query3);
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
                    <a href="gsearch.php" class="list-group-item text-center active">单科成绩查询</a>
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
                    <div class="panel-heading">单科成绩查询</div>
                    <div class="panel-body">
                        <form action="gsearch.php?act=search" method="post" class="form-horizontal" role="form" onsubmit="return check1()">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">年级</label>
                                <div class="col-sm-3">
                                    <select name="year" id="year"  class="form-control">
                                        <?php foreach ($yearrows as $yearinfo):?>
                                            <option value="<?php echo $yearinfo['year'];?>"><?php echo $yearinfo['year'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <label class="col-sm-2 control-label">专业名称</label>
                                <div class="col-sm-4">
                                    <select name="mno" id="mno" class="form-control">
                                        <?php foreach ($majorrows as $majorinfo):?>
                                            <option value="<?php echo $majorinfo['mno'];?>"><?php echo $majorinfo['mname']."(".$majorinfo['mno'].")"; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>


                                <label class="col-sm-2 control-label">课程名称</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cname" id="cname" class="form-control" placeholder="课程全称，如C语言程序设计">
                                </div>
                                <div class="col-sm-1">
                                    <label></label>
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary" size="10" style="min-width: 120px;">查询 </button>
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
                                <th>专业排名</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($_REQUEST['act']) and $_REQUEST['act']=="search") {
                                if($rows){
                                    echo "查找&nbsp<b>{$year}</b>&nbsp级&nbsp<b>{$mname}({$mno})</b>&nbsp专业&nbsp<b>{$cname}</b>&nbsp课程的结果如下&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<button id=chartbtn class='btn btn-primary' style='min-width: 120px;' onclick='skipchart({$nn['n1']},{$nn['n2']},{$nn['n3']},{$nn['n4']},{$nn['n5']})'>查看饼状图 </button>";
                                    ?> <!--饼图显示-->
                                    <div id="pie1" style="width: 600px;height:400px;display:none"></div>
                                    <?php $rank=0;
                                    $temp=-1;//考虑同分并列的情况
                                    foreach ($rows as $stuinfo):
                                        ?>
                                        <tr>
                                            <td><?php echo $stuinfo['sno']; ?></td>
                                            <td><?php echo $stuinfo['sname']; ?></td>
                                            <td><?php echo $stuinfo['sclass']; ?></td>
                                            <td><?php echo $stuinfo['mname']; ?></td>
                                            <td><?php echo $stuinfo['semester']; ?></td>
                                            <td><?php echo $stuinfo['cname']; ?></td>
                                            <td><?php
                                                if ($stuinfo['grade'] == NULL) {
                                                    echo "暂无 ";
                                                }

                                                else echo $stuinfo['grade']; ?></td>
                                            <td><?php if($temp!=$stuinfo['grade']) {//控制并列的情况，如果上一个成绩与这个成绩不相等，排名+1
                                                    $rank=$rank+1;
                                                    $temp=$stuinfo['grade'];
                                                }
                                                echo $rank;
                                                ?></td>
                                        </tr>
                                    <?php endforeach;

                                        }
                                else {
                                    echo "没有查找到&nbsp<b>{$year}</b>&nbsp级&nbsp<b>{$mname}({$mno})</b>&nbsp专业&nbsp<b>{$cname}</b>&nbsp课程的结果<br>";

                                }
                            }

                            ?>

                            </tbody>

                        </table>
                        <script>
                            //判断课程名是否为空
                            function check1() {
                                var cname=document.getElementById("cname");
                                var reg=/^(?:\S+)$/;
                                if(!reg.test(cname.value)){
                                    alert("请输入课程名称全称，不能带空格");
                                    cname.focus();
                                    return false
                                }
                            }

                            function getvalue(id) {
                                var gid="grade"+id.toString();
                                //alert(gid);
                                return document.getElementById(gid).value;
                            }
                            //更新
                            function update(id,sno,cno) {
                                var grade=getvalue(id);
                                var reg=/^(?:[1-9]?\d|100)$/;  //正则匹配0-100
                                if(!reg.test(grade)) {
                                    alert("请输入0-100的整数")
                                    return;
                                }
                                else {//符合规范跳转
                                    var url="doAction.php?act=gupdate&sno="+sno+"&cno="+cno+"&grade="+grade;
                                    //alert(url);
                                    window.location=url;

                                }
                            }
                            //跳转到图表页面
                            function skipchart(n1,n2,n3,n4,n5) {
                                var url="gchart.php?n1="+n1+"&n2="+n2+"&n3="+n3+"&n4="+n4+"&n5="+n5;
                                //alert(url);
                                window.open(url);
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