<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />	
	<link rel="stylesheet" href="../../res/bootstrap/css/bootstrap.min.css" />
	<script type="text/javascript" src="../../res/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../../res/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../../res/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../res/vue.js"></script>
	<script src="res/highcharts.js"></script>
	<title>数据分析并图形化显示</title>
</head>
<body>
	<nav class="navbar navbar-default navbar-static-top">
		  <div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#example">
					<span class="sr-only">toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="" class="navbar-brand">沈阳工业大学</a>
			</div>
			<div class="collapse navbar-collapse" id="example">
				<ul class="nav navbar-nav">
					<li><a href="../../index.php">首页</a></li>
					<li><a href="../check/check.php">考核</a></li>
					<li><a href="../datashow/data_show.php">信息查询</a></li>
					<li><a href="../admin/admin.php">信息管理</a></li>
					<li><a href="http://www.sut.edu.cn">工大</a></li>
					<li><a href="http://library.sut.edu.cn/">图书馆</a></li>
				</ul>
			</div>
		  </div>
		</nav>
	<!--<button type="button" onclick="history.go(-1);" style="position: absolute;right: 30px;top: 50px;" class="btn btn-primary">Back</button>-->
	<div id="container1" style="width: 550px; height: 400px; margin: 0 auto"></div>
	
<script language="JavaScript">
$(document).ready(function() {  
   var chart = {
   		plotBackgroundColor: null,//图表背景色
       plotBorderWidth: 1,//图表边框
       plotShadow: false,
       plotBorderWidthRadius:5,
       marginLeft:30
   };
   var title = {
      text: '学生成绩分布'   
   };      
   var tooltip = {//注意饼状图的提示（鼠标放上去）有些特别
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' //数据格式化
   };
   var legend={
   	 layout:"vertical",
   	 align:"right",
   	 verticalAlign:"top",
   	 x:5,
   	 y:50,
   	 rtl:false//标志在文字的右边
   }
   var plotOptions = {
      pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {//一直显示出来的提示
            enabled: true,
            format: '<b>{point.name}%</b>: {point.percentage:.1f} %',
            style: {
               color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
         },
          showInLegend: true//控制是否显示图例，default：false
      }
   };
    //定义一个函数，专门取出url中的参数值
    function getParam(name){
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     	var r = window.location.search.substr(1).match(reg);
        if(r!=null)return JSON.parse(unescape(r[2])); return null;	
    }
    
   var series= [{
      type: 'pie',
      name: '所占百分比',//当前数据的name
      data: getParam("data")
   }];     

    
   var json = {};   
   json.chart = chart; 
   json.title = title;     
   json.tooltip = tooltip;  
   json.plotOptions = plotOptions;
   json.legend=legend;
   json.series = series;
   json.colors=['red','yellow','green'];
   json.credits={   	
   	 enabled:true,
   	 text:"www.sut.edu.cn",
   	 href:"http://www.sut.edu.cn",
   	 position: {
	    align: 'right',
	    x: -100,
	    verticalAlign: 'bottom',
	    y: -25
}
   	 }
   $('#container1').highcharts(json);  
});
</script>
</body>
</html>
