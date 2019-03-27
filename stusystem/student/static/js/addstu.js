

//验证输入信息
function checkNull(){

    var sno=document.getElementById("sno");

    var sname=document.getElementById("sname");
    var sexs=document.getElementsByName("ssex");
    var ssex=null;
    var sage=document.getElementById("sage");
    var sclass=document.getElementById("sclass");
    var saddr=document.getElementById("saddr");

    if(trim(sno.value)==null || trim(sno.value)==""){
        alert("学号不能为空");
        sno.focus();
        return false;
    }
    if(trim(sname.value)==null || trim(sname.value)==""){
        alert("学生姓名不能为空");
        sname.focus();
        return false;
    }
    for(var i=0;i<sexs.length;i++)
    {
        if(sexs[i].checked==true)
        {
            ssex=sexs[i].value;
            break;
        }
    }
    if(ssex==null){
        alert("请选择学生性别");
        sexs[0].focus();
        return false;
    }


    if(trim(sage.value)==null || trim(sage.value)==""){
        alert("年龄不能为空");
        sage.focus();
        return false;
    }


    if(trim(sclass.value)==null || trim(sclass.value)==""){
        alert("班级不能为空");
        sclass.focus();
        return false;
    }


    if(trim(saddr.value)==null || trim(saddr.value)==""){
        alert("家庭住址不能为空");
        saddr.focus();
        return false;
    }

}

function trim(str){ //删除左右两端的空格
    　return str.replace(/(^\s*)|(\s*$)/g, "");
}
