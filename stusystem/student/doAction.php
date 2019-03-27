<?php
session_start();
header("content-type:text/html;charset=utf-8");

require_once '../config/config.php';
require_once '../functions/common.func.php';
require_once '../functions/mysql.func.php';

if (!isset($_SESSION['user']))
    $_SESSION['user']="guest";//访客
$act=$_REQUEST['act'];
echo $act;

if ($act!='restore')//restore在数据库删除了之后都能恢复，不需要连接
    $link = connect3();

switch($act) {
    //添加学生信息
    case 'add':

        $sno = $_POST["sno"];
        $sname = $_POST["sname"];
        $sage = $_POST["sage"];
        $ssex = $_POST["ssex"];
        $dno = $_POST["dno"];
        $mno=$_POST["mno"];
        $saddr = $_POST["saddr"];
        $sclass=$_POST["sclass"];

        $query1="select sno from student where sno='{$sno}'";
        $result1=fetchOne($link,$query1);

        if($result1)
        {
            alertBackRefresh("学号为{$sno}的记录已经存在");
            break;
        }
        //插入学生信息
        $insertsql1="insert into student(sno,sname,sage,ssex,dno,mno,saddr,sclass) 
          values ('{$sno}','{$sname}',{$sage},'{$ssex}','{$dno}','{$mno}','{$saddr}','{$sclass}')";
        $resultflag1=$link->query($insertsql1);
        $insertsql2="insert into sc(sno,cno,semester) select sno,cno,semester from student,mc where sno='{$sno}' and mc.mno='{$mno}'";
        $resultflag2=insert($link,$insertsql2);
        //echo $insertsql1;
        echo $resultflag2;
        if($resultflag1 )
            alertBackRefresh("添加数据成功");
        else
            alertBackRefresh("添加失败");
        break;

        //修改学生信息
    case 'update':

        $sno = $_POST["sno"];
        $sname = $_POST["sname"];
        $sage = $_POST["sage"];
        $ssex = $_POST["ssex"];
        $dno = $_POST["dno"];
        $mno=$_POST["mno"];
        $saddr = $_POST["saddr"];
        $sclass=$_POST["sclass"];
        $updatesql1="update student set sname='{$sname}',sage={$sage},ssex='{$ssex}',dno='{$dno}',mno='{$mno}',saddr='{$saddr}',sclass='{$sclass}' where sno='{$sno}'";
        $resultflag1=$link->query($updatesql1);
        if($resultflag1)
            alertBackRefresh("修改数据成功");
        else
            alertBackRefresh("修改失败");
        break;

        //删除学生信息
    case 'delete':
        $sno=$_GET["sno"];
        $deletesql1="delete from sc where sno='{$sno}'";
        $deletesql2="delete from student where sno='{$sno}'";
        $result1=delete($link,$deletesql1);
        $result2=delete($link,$deletesql2);
        //全等于false，删除失败
        if($result1===false or $result2===false){
            alertBack("删除失败");
        }
        else{
            alertBack("删除成功");
        }
        break;

        //成绩更新
    case 'gupdate':
        $sno=$_GET["sno"];
        $cno=$_GET["cno"];
        $grade=$_GET["grade"];

        $updatesql1="update sc set grade={$grade} where sno='{$sno}' and cno='{$cno}'";
        $resultflag1=update($link,$updatesql1);
        if($resultflag1)
            alertBack("成绩更新成功");
        else
            alertBack("成绩更新失败");
        break;
    //备份
    case 'backup':
        //$mysqldumppath="D:\phpStudy\PHPTutorial\MySQL\bin\mysqldump";
        //$filepath="F:/mysqlbackup/";
        //备份路径不存在则创建
        if(!is_dir(BACKUP_PATH)){
            mkdir(BACKUP_PATH);
        }

        $command=MYSQLDUMP_EXE." -h ".DB_HOST." -u".DB_USER." -p".DB_PWD." -B ".DB_DBNAME."> ".BACKUP_PATH.DB_DBNAME.".sql";
        //echo "<script>alert('{$command}');</script>";//输出时没有斜线
        system($command,$i);
        if(!$i)//i=0 表示成功
            //echo "<script>alert('备份成功');</script>";
            alertBack("备份成功");
        else
            //echo "<script>alert('备份失败');</script>";
            alertBack("备份失败");
        //var_dump($i);//$i

        break;
    case  'restore':
        //$mysqldumppath="D:\phpStudy\PHPTutorial\MySQL\bin\mysqldump";
        //$filepath="F:/mysqlbackup/";
        //备份文件存在时
        if(file_exists(BACKUP_PATH.DB_DBNAME.".sql"))
        {
            //mysql -uroot -proot -e "drop database stusystem;"   删除原数据库
            /*
            $command1=MYSQL_EXE." -h ".DB_HOST." -u".DB_USER." -p".DB_PWD." -e \"drop database ".DB_DBNAME.";\"";//."> ".BACKUP_PATH.DB_DBNAME.".sql";
            system($command1,$i1);
            echo $i1;
            */

            //mysql -uroot -proot < F:/mysqlbackup/stusystem.sql   恢复数据库
            $command2=MYSQL_EXE." -h ".DB_HOST." -u".DB_USER." -p".DB_PWD." < ".BACKUP_PATH.DB_DBNAME.".sql";
            echo $command2;
            //echo "<script>alert({$command2});</script>";
            system($command2,$i2);
            //echo $i2;
            if (!$i2) //i2为0时恢复成功
                alertBack("恢复成功");

            //alertBack("数据库恢复成功");
        }
        else
        {
            alertBack("备份文件不存在");
        }
        break;

        //按院系导出学生信息表
    case 'excelsinfo':
        require_once 'Classes/PHPExcel.php'; //引入PHPExcel
        //查询
        $query1="select distinct(dno) as dno from student";

        try{
            $dnorow=fetchAll($link,$query1);
            $dnum=count($dnorow);
            echo $dnum;
            $objPHPExcel = new PHPExcel(); //实例化PHPExcel类，等同于在桌面上新建一个excel
            for($i=0;$i<$dnum;$i++) {
                //echo $mnumrow['mnum'][$i];

                //默认创建1个0号表，如果不是0号表需要再创建

                if ($i > 0) {
                    $objPHPExcel->createSheet();
                }
                $objPHPExcel->setActiveSheetIndex($i);//设为活动表
                $objSheet = $objPHPExcel->getActiveSheet();//获得活动表
                $objSheet->setTitle($dnorow[$i]['dno']);//设置表名称

                $query2="select sno,sname,dname,mname,sclass,ssex,sage,saddr
                      from student s,major m,dept d
                      where s.mno=m.mno and s.dno='{$dnorow[$i]['dno']}' and s.dno=d.dno order by sclass,sno";
                $sinforows=fetchAll($link,$query2);
                $objSheet-> setCellValue('A1','院系名')->setCellValue('B1','专业名')
                    -> setCellValue('C1','班级')->setCellValue('D1','学号')
                    ->setCellValue('E1','姓名')->setCellValue('F1','性别')
                    ->setCellValue('G1','年龄')->setCellValue('H1','家庭住址');
                $j=2;//从第2行开始
                foreach ($sinforows as $info){
                    $objSheet->setCellValue('A'.$j,$info['dname'])
                        ->setCellValue('B'.$j,$info['mname'])
                        ->setCellValue('C'.$j,(string)$info['sclass'])
                        ->setCellValue('D'.$j,(string)$info['sno'])
                        ->setCellValue('E'.$j,$info['sname'])
                        ->setCellValue('F'.$j,$info['ssex'])
                        ->setCellValue('G'.$j,$info['sage'])
                        ->setCellValue('H'.$j,$info['saddr']);
                    $j++;
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
            $objWriter->save(BACKUP_PATH.'/sinfo.xls'); //保存文件
            alertBack("导出成功");
        }catch(Exception $e){//异常处理
            alertBack("导出失败\n".$e->getMessage()) ;
        }

        break;

    //按专业导出学生成绩表
    case 'excelsgrade':
        require_once 'Classes/PHPExcel.php'; //引入PHPExcel
        //查询
        $query1="select distinct(mno) as mno from student";

        try{
            $mnorow=fetchAll($link,$query1);
            $mnum=count($mnorow);
            echo $mnum;
            $objPHPExcel = new PHPExcel(); //实例化PHPExcel类，等同于在桌面上新建一个excel
            for($i=0;$i<$mnum;$i++) {
                //echo $mnumrow['mnum'][$i];
                //默认创建1个0号表，如果不是0号表需要再创建
                if ($i > 0) {
                    $objPHPExcel->createSheet();
                }
                $objPHPExcel->setActiveSheetIndex($i);//设为活动表
                $objSheet = $objPHPExcel->getActiveSheet();//获得活动表
                $objSheet->setTitle($mnorow[$i]['mno']);//设置表名称
                //按班级、姓名、学期排序
                $query2="select sno,sclass,sname,mname,cname,grade,semester
                  from stugrade
                  where mno='{$mnorow[$i]['mno']}' order by sclass,sno,semester";
                $sinforows=fetchAll($link,$query2);
                $objSheet-> setCellValue('A1','专业名')->setCellValue('B1','班级')
                    -> setCellValue('C1','学号')->setCellValue('D1','姓名')
                    ->setCellValue('E1','课程名')->setCellValue('F1','成绩')
                    ->setCellValue('G1','开课学期');
                $j=2;//从第2行开始
                foreach ($sinforows as $info){
                    $objSheet->setCellValue('A'.$j,$info['mname'])
                        ->setCellValue('B'.$j,$info['sclass'])
                        ->setCellValue('C'.$j,(string)$info['sno'])
                        ->setCellValue('D'.$j,(string)$info['sname'])
                        ->setCellValue('E'.$j,$info['cname'])
                        ->setCellValue('F'.$j,$info['grade'])
                        ->setCellValue('G'.$j,$info['semester']);
                    $j++;
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
            $objWriter->save(BACKUP_PATH.'/sgrade.xls'); //保存文件
            alertBack("导出成功");
        }catch(Exception $e){//异常处理
            alertBack("导出失败 ".$e->getMessage()) ;
        }

        break;
        //修改密码
    case 'pupdate':
        $oldpass=md5($_POST['oldpass']);
        $newpass=md5($_POST['newpass']);
        $user=$_SESSION['user'];
        if($user=='guest'){
            alertBack("您未登录不能修改密码");
        }
        else{
            $query1="select * from login where user='{$user}' and pwd='{$oldpass}'";
            $row=fetchOne($link,$query1);
            if($row){//取出的结果非空
                $query2="update login set pwd='{$newpass}' where user='{$user}'";
                $resultflag1=update($link,$query2);
                if($resultflag1){//更新成功
                    session_destroy();
                    alertMes("更新成功，请重新登陆",'../index.php');
                }
                else
                {
                    alertBack("更新失败");
                }
            }
            else{
                alertBack("旧密码错误，修改密码失败");
            }
        }
        break;
        //退出登录
    case 'logout':
        session_destroy();
        alertMes("退出成功，感谢您的使用",'../index.php');
        break;

}



