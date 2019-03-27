<?php
session_start();
header("content-type:text/html;charset=utf-8");
$n1=$_GET['n1'];//90-100
$n2=$_GET['n2'];//80-89
$n3=$_GET['n3'];//70-79
$n4=$_GET['n4'];//60-69
$n5=$_GET['n5'];//<60

$sum=$n1+$n2+$n3+$n4+$n5;
//百分比
/*
$rate1=round($n1/$sum*100,2);
$rate2=round($n2/$sum*100,2);
$rate3=round($n3/$sum*100,2);
$rate4=round($n4/$sum*100,2);
$rate5=round($n5/$sum*100,2);
//echo $rate1;
*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- 引入 ECharts 文件 -->
    <script src="static/js/echarts.common.min.js"></script>
    <div id="pie1" style="width: 900px;height:600px;"></div>
    <script type="text/javascript">
        var myChart1 = echarts.init(document.getElementById('pie1'));
        option1 = {
            title:{
                text:'统计各分数段人数',
                top:'bottom',
                left:'center',
                textStyle:{
                    fontSize: 14,
                    fontWeight: '',
                    color: '#333'
                },
            },//标题
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                /*formatter:function(val){   //让series 中的文字进行换行
                     console.log(val);//查看val属性，可根据里边属性自定义内容
                     var content = var['name'];
                     return content;//返回可以含有html中标签
                 },*/ //自定义鼠标悬浮交互信息提示，鼠标放在饼状图上时触发事件
            },//提示框，鼠标悬浮交互时的信息提示
            legend: {
                //show: true,
                orient: 'vertical',
                x: 'right',
                y: 'top',
                itemWidth: 24,   // 设置图例图形的宽
                itemHeight: 18,  // 设置图例图形的高
                textStyle: {
                    color: '#666'  // 图例文字颜色
                },
                //后台提供的数据中legend对应的名称和series的data数据内的名称一致，才能显示图例
                data: ['90到100分', '80到89分', '70到79分','60到69分','60分以下']
            },//图例属性，以饼状图为例，用来说明饼状图每个扇区，data与下边series中data相匹配
            graphic:{
                type:'text',
                left:'center',
                top:'center',
                style:{
                    text:'分数段人数统计\n'+'共<?php echo $sum;?>人', //使用“+”可以使每行文字居中
                    textAlign:'center',
                    font:'italic bolder 16px cursive',
                    fill:'#000',
                    width:30,
                    height:30
                }
            },//此例饼状图为圆环中心文字显示属性，这是一个原生图形元素组件，功能很多
            series: [
                {
                    name:'分数段统计',//tooltip提示框中显示内容
                    type: 'pie',//图形类型，如饼状图，柱状图等
                    radius: ['30%', '70%'],//饼图的半径，数组的第一项是内半径，第二项是外半径。支持百分比，本例设置成环形图。具体可以看文档或改变其值试一试
                    //roseType:'area',是否显示成南丁格尔图，默认false
                    itemStyle: {
                        normal:{
                            label:{
                                show:true,
                                textStyle:{color:'#3c4858',fontSize:"18"},
                                formatter:function(val){   //让series 中的文字进行换行
                                    return val.name.split("-").join("\n");}
                            },//饼图图形上的文本标签，可用于说明图形的一些数据信息，比如值，名称等。可以与itemStyle属性同级，具体看文档
                            labelLine:{
                                show:true,
                                lineStyle:{color:'#3c4858'}
                            }//线条颜色
                        },//基本样式
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)',//鼠标放在区域边框颜色
                            textColor:'#000'
                        }//鼠标放在各个区域的样式
                    },
                    data: [
                        {value: <?php echo $n1;?>, name: '90到100分'},
                        {value: <?php echo $n2;?>, name: '80到89分'},
                        {value: <?php echo $n3;?>, name: '70到79分'},
                        {value: <?php echo $n4;?>, name: '60到69分'},
                        {value: <?php echo $n5;?>, name: '60分以下'},
                    ],//数据，数据中其他属性，查阅文档
                    color: ['#f7f20e','#f75a02','#de01a1','#0321f8','#08e79e'],//各个区域颜色
                },//数组中一个{}元素，一个图，以此可以做出环形图
            ],//系列列表
        };
        myChart1.setOption(option1);
    </script>
</head>
</html>
