#<center>数据库课程设计——学习学籍管理系统</center>
###<p align="right">——By Heaven-zhw</p>
##功能阐述

本项目利用web开发、数据库系统应用等技术，实现一个本科生学籍管理系统，可以提供如下功能：

（1） 查看学生信息：按多种条件检索学生，并可以对检索结果进行进一步操作，如修改、删除等

（2）新增学生：输入基本信息，添加新学生

（3）成绩录入和修改：按多种条件查询课程，可以添加、修改成绩

（4）单科成绩查询：按年级、专业和课程名进行检索，输出课程信息、成绩和专业排名、并且可以查看分数段统计图

（5）学生评价：按多种条件检索学生，可以指定学期输出平均学分绩和评价

（6）毕业管理：输入年级、专业和应修学分，查询学生对应专业应届毕业生的毕业状态（是否能毕业）

（7）生成报表：可以按院系导出学生基本信息表、按照专业导出学生成绩表

（8）备份和恢复：点击按钮，实现对数据库的一键备份和恢复

（9）修改密码：修改当前登录用户的密码

##开发工具和开发环境

本系统开发环境：win10+php5.6+mysql5.5+Apache2.4

配置php、搭建服务器和数据库的工具：phpstudy

php开发工具：phpstorm

数据库管理工具：navaicat for mysql




##配置说明(安装好mysql、Apache，配置好php之后)

	1.将stusystem文件夹放在本机WWW文件夹下，我的位置是D:\phpStudy\PHPTutorial\WWW
	
	2.进入..\stusystem\config文件夹，打开config.php文件，修改以下宏定义：
		
	define('DB_HOST','127.0.0.1');   //改为自己的主机地址
	define('DB_USER','root');		//改为自己的数据库用户名
	define('DB_PWD','root');		//改为自己的数据库密码

	define('DB_CHARSET','utf8');	//数据库编码方式，不用改
	define('DB_DBNAME','stusystem');//数据库名，不用改

	define('MYSQL_EXE',"D:\phpStudy\PHPTutorial\MySQL\bin\mysql");  //改为自己的mysql.exe的位置，最后的扩展名去掉，注意斜线方向
	define('MYSQLDUMP_EXE',"D:\phpStudy\PHPTutorial\MySQL\bin\mysqldump");  //改为自己的mysqldump.exe的位置，最后的扩展名去掉，注意斜线方向
	define('BACKUP_PATH',"F:/mysqlbackup/"); //改为自己的备份文件路径，注意斜线方向
	
	
	
	3.登录mysql帐户，导入stusystem.sql
	
	4.确保数据库用户有使用mysqldump来备份和恢复的权限，最好用root账户，

	
	
##使用说明：

运行stusystem下的index.php，参照stusystem内用户名和密码.txt里的用户名和密码登录系统即可

最好使用Google浏览器运行

