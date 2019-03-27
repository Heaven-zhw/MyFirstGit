
create table if not exists `login`(
  `user` varchar (10),
  `pwd` varchar(32) default null ,
   primary key(`user`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists `student`(
  `sno` varchar (10),
  `sname` varchar(8) default null ,
  `ssex` varchar(2) default null,
  `sage` tinyint default null,
  `dno` varchar(5) default null,
  `mno` varchar (5) default null,
  `sclass` varchar (10)default null,
  `saddr` varchar (50) default null,
   primary key(`sno`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;




create table if not exists `course`(
  `cno` varchar (10),
  `cname` varchar(15) default null ,
  `credit` float(3,1) default null,
  primary key(`cno`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists `sc`(
  `sno` varchar(10),
  `cno` varchar (10),
  `grade` tinyint default null ,
  `semester` tinyint default null,
  primary key(`sno`,`cno`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists `dept`(
  `dno` varchar(5),
  `dname` varchar (15),
  primary key(`dno`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists `major`(
  `mno` varchar(5),
  `dno` varchar (5),
  `mname` varchar (15),
  primary key(`mno`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table if not exists `mc`(
  `mno` varchar(5),
  `cno` varchar (10),
  `semester` tinyint,
  primary key(`mno`,`cno`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*外键约束*/
alter table sc add constraint foreign key (`sno`) references student(`sno`);
alter table sc add constraint foreign key (`cno`) references course(`cno`);
alter table student add constraint foreign key (`dno`) references dept(`dno`);
alter table student add constraint foreign key (`mno`) references major(`mno`);
alter table mc add constraint foreign key (`mno`) references major(`mno`);
alter table mc add constraint foreign key (`cno`) references course(`cno`);
alter table major add constraint foreign key (`dno`) references dept(`dno`);


/*视图1 查学生时用*/
create view studmname as
select sno,sname,sclass,mname,dname from student s,major m,dept d
where s.mno=m.mno and s.dno=d.dno

/*视图2 查成绩时用*/
create view stugrade as
select s.sno,sname,sclass,mname,c.cno,cname,grade,semester from student s,major m,course c,sc
where s.mno=m.mno  and s.sno=sc.sno and c.cno=sc.cno

/*视图2' 最终使用*/
create view stugrade as
select s.sno,sname,sclass,s.mno,mname,c.cno,cname,grade,semester from student s,major m,course c,sc
where s.mno=m.mno  and s.sno=sc.sno and c.cno=sc.cno
/*
create trigger sc_insert1 after insert on student
for each row
begin
insert into sc(sno,cno,semester) select sno,cno,semester from mc where sno=new.sno and mc.mno=new.mno;
end

*/

/*视图3 用于建立查学分绩的视图和判断总的实际拿的学分*/
create view stucregra as
select sno,grade,credit,semester from sc,course
  where sc.cno=course.cno and grade is not null;

select sno,sum(grade*credit)/sum(credit) as wgrade,semester from stucregra group by sno,semester;

/*视图4 查每学期的学分绩*/
create view stuwgrade1 as
select sno,semester,sum(grade*credit)/sum(credit) as wgrade from stucregra group by sno,semester;

/*视图5 查总的学分绩*/
create view stuwgrade2 as
select sno,sum(grade*credit)/sum(credit) as wgrade from stucregra group by sno;

select sno,sum(credit)as earncredit from stucregra where grade>=60 group by sno;
/*视图6 查实际拿的学分  */
create view stucredit as
select sno,sum(credit)as earncredit from stucregra where grade>=60 group by sno;

select sno from  student where  LEFT(sno,2)='16'

mysqldump -uroot -proot -B stusystem >D:/data111.sql
mysqldump  -h 10.245.144.96 -uuser -p123456 -B stusystem >D:/data222.sql
mysqldump  -h 127.0.0.1 -uroot -proot -B stusystem >D:/data333.sql

mysql -uroot -proot -e "drop database stusystem;"
mysql -uroot -proot < F:/mysqlbackup/stusystem.sql

/*查各分数段人数*/
select count(case when grade between 90 and 100 then 1 end) as n1,
       count(case when grade between 80 and 89 then 1 end) as n2,count(case when grade between 70 and 79 then 1 end) as n3,
       count(case when grade between 60 and 69 then 1 end) as n4,count(case when grade<60 then 1 end) as n5
from  stugrade



insert into student(sno,sname,ssex,sage,dno,mno,sclass,saddr) values ('160110101','张三','男',20,'010','011','1601101','山东省威海市')
insert into student(sno,sname,ssex,sage,dno,mno,sclass,saddr) values ('160110102','李四','男',21,'010','011','1601101','广东省肇庆市')


insert into dept(dno,dname) values ('010','计算机科学与技术');
insert into dept(dno,dname) values ('020','经济管理');
insert into dept(dno,dname) values ('030','理学');
insert into dept(dno,dname) values ('040','海洋科学与技术');
insert into dept(dno,dname) values ('050','信息科学与工程');
insert into dept(dno,dname) values ('060','汽车工程');

insert into major(mno,dno,mname) values ('011','010','计算机科学与技术');
insert into major(mno,dno,mname) values ('012','010','信息安全');
insert into major(mno,dno,mname) values ('013','010','网络空间安全');
insert into major(mno,dno,mname) values ('014','010','软件工程');
insert into major(mno,dno,mname) values ('021','020','信息管理与信息系统');
insert into major(mno,dno,mname) values ('022','020','会计学');
insert into major(mno,dno,mname) values ('031','030','数学与应用数学');
insert into major(mno,dno,mname) values ('032','030','信息与计算科学');
insert into major(mno,dno,mname) values ('041','040','生物工程');
insert into major(mno,dno,mname) values ('051','050','通信工程');
insert into major(mno,dno,mname) values ('061','060','车辆工程');

insert into course(cno,cname,credit) values ('YY1001','大学英语','1.5');
insert into course(cno,cname,credit) values ('SX1001','工科数学分析','5');
insert into course(cno,cname,credit) values ('SC1001','C语言程序设计','3');
insert into course(cno,cname,credit) values ('SX1002','代数与几何','3.5');
insert into course(cno,cname,credit) values ('LX1001','大学物理A','4.5');
insert into course(cno,cname,credit) values ('CS1011','集合论与图论','2');
insert into course(cno,cname,credit) values ('CS1002','C++程序设计','2.5');
insert into course(cno,cname,credit) values ('CS1001','数据结构','3.5');
insert into course(cno,cname,credit) values ('CS2001','Java语言程序设计','2.5');
insert into course(cno,cname,credit) values ('CS2002','计算机网络','3');
insert into course(cno,cname,credit) values ('IS2001','数字逻辑设计','4');
insert into course(cno,cname,credit) values ('SX2004','数理逻辑','2');
insert into course(cno,cname,credit) values ('CS2005','计算机组成原理','1.5');
insert into course(cno,cname,credit) values ('CS3001','数据库系统概论','3.5');
insert into course(cno,cname,credit) values ('CS3002','操作系统','3.5');
insert into course(cno,cname,credit) values ('CS3003','计算机系统安全','2.5');
insert into course(cno,cname,credit) values ('CS3011','密码学基础','2');
insert into course(cno,cname,credit) values ('CS3021','软件开发与实践1','2');
insert into course(cno,cname,credit) values ('CS3022','软件开发与实践2','2');
insert into course(cno,cname,credit) values ('CS3006','计算机体系结构','3');
insert into course(cno,cname,credit) values ('CS3007','软件工程','3');
insert into course(cno,cname,credit) values ('CS3008','计算机图形学','3');
insert into course(cno,cname,credit) values ('CS3012','计算机系统安全','2.5');
insert into course(cno,cname,credit) values ('CS4001','人工智能导论','2.5');
insert into course(cno,cname,credit) values ('CS4002','计算机毕业设计','14');
insert into course(cno,cname,credit) values ('CS4003','信息安全毕业设计','14');
insert into course(cno,cname,credit) values ('CS4004','网络空间安全毕业设计','14');
insert into course(cno,cname,credit) values ('CS4005','软件工程毕业设计','14');

insert into mc(mno,cno,semester) values  ('011','YY1001',1);
insert into mc(mno,cno,semester) values  ('011','SX1001',1);
insert into mc(mno,cno,semester) values  ('011','SC1001',1);
insert into mc(mno,cno,semester) values  ('011','SX1002',1);
insert into mc(mno,cno,semester) values  ('011','LX1001',2);
insert into mc(mno,cno,semester) values  ('011','CS1011',2);
insert into mc(mno,cno,semester) values  ('011','CS1002',2);
insert into mc(mno,cno,semester) values  ('011','CS2001',3);
insert into mc(mno,cno,semester) values  ('011','IS2001',3);
insert into mc(mno,cno,semester) values  ('011','CS3021',3);
insert into mc(mno,cno,semester) values  ('011','CS2005',4);
insert into mc(mno,cno,semester) values  ('011','SX2004',4);
insert into mc(mno,cno,semester) values  ('011','CS3022',4);
insert into mc(mno,cno,semester) values  ('011','CS3001',5);
insert into mc(mno,cno,semester) values  ('011','CS3002',5);
insert into mc(mno,cno,semester) values  ('011','CS3008',5);
insert into mc(mno,cno,semester) values  ('011','CS3006',6);
insert into mc(mno,cno,semester) values  ('011','CS3007',6);
insert into mc(mno,cno,semester) values  ('011','CS4001',7);
insert into mc(mno,cno,semester) values  ('011','CS4002',8);


insert into mc(mno,cno,semester) values  ('012','YY1001',1);
insert into mc(mno,cno,semester) values  ('012','SX1001',1);
insert into mc(mno,cno,semester) values  ('012','SC1001',1);
insert into mc(mno,cno,semester) values  ('012','SX1002',1);
insert into mc(mno,cno,semester) values  ('012','LX1001',2);
insert into mc(mno,cno,semester) values  ('012','CS1011',2);
insert into mc(mno,cno,semester) values  ('012','CS1002',2);
insert into mc(mno,cno,semester) values  ('012','CS2001',3);
insert into mc(mno,cno,semester) values  ('012','IS2001',3);
insert into mc(mno,cno,semester) values  ('012','CS2002',3);
insert into mc(mno,cno,semester) values  ('012','CS2005',4);
insert into mc(mno,cno,semester) values  ('012','CS3001',5);
insert into mc(mno,cno,semester) values  ('012','CS3002',5);
insert into mc(mno,cno,semester) values  ('012','CS3011',5);
insert into mc(mno,cno,semester) values  ('012','CS3021',5);
insert into mc(mno,cno,semester) values  ('012','CS3012',6);
insert into mc(mno,cno,semester) values  ('012','CS3007',6);
insert into mc(mno,cno,semester) values  ('012','CS4001',7);
insert into mc(mno,cno,semester) values  ('012','CS4003',8);

insert into mc(mno,cno,semester) values  ('013','YY1001',1);
insert into mc(mno,cno,semester) values  ('014','YY1001',1);
insert into mc(mno,cno,semester) values  ('021','YY1001',1);
insert into mc(mno,cno,semester) values  ('022','YY1001',1);
insert into mc(mno,cno,semester) values  ('031','YY1001',1);
insert into mc(mno,cno,semester) values  ('032','YY1001',1);
insert into mc(mno,cno,semester) values  ('041','YY1001',1);
insert into mc(mno,cno,semester) values  ('051','YY1001',1);
insert into mc(mno,cno,semester) values  ('061','YY1001',1);

insert into mc(mno,cno,semester) values  ('021','SX1001',1);

