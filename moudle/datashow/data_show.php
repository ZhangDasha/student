<?php include "../../db/conn.php";?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../res/jquery.dataTables.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../res/bootstrap/css/bootstrap.min.css"/>
		<script type="text/javascript" src="../../res/jquery-3.1.1.min.js" ></script>
		<script type="text/javascript" src="../../res/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../../res/vue.js" ></script>
		<script type="text/javascript" src="../../res/jquery.dataTables.min.js"></script>		
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
					<li class="active"><a href="#">信息查询</a></li>
					<li><a href="../admin/admin.php">信息管理</a></li>
					<li><a href="http://www.sut.edu.cn">工大</a></li>
					<li><a href="http://library.sut.edu.cn/">图书馆</a></li>
				</ul>
			</div>
		  </div>
		</nav>
		<div class="container">	
			<div id="app">
				<div class="row">
				<div class="col-xs-2">
					<select name="academy" v-model="academy"  v-on:change="getTeacher" class="form-control">
							<option value="" disabled="disabled">选学院</option>	
							<?php 
						
								$sql="select * from academy";
								$res=mysqli_query($conn,$sql);
								while($row=mysqli_fetch_array($res)){										
							 ?>
							 <option value="<?php echo $row['id'];?>"><?php echo $row['name']?></option>										
							<?php		
								}	
							?>
					</select>			
				</div>			
				<div class="col-xs-2">				
					<select  name="teacher" v-model="teacher" id="teacher" class="form-control">
						<option value="" disabled="disabled">选辅导员</option>					
					</select>
				</div>
				<div class="col-xs-2">
					<button type="button" class="btn btn-block btn-primary" v-on:click="getStudent">确定</button>
				</div>
				<div class="col-xs-2">
					<button type="button" class="btn btn-block btn-primary" v-on:click="analyse" >数据分析</button>
				</div>
				</div>  <!--row 结束-->
			</div>
		<!--app 结束-->
		<!--设置一个容器来装table-->
	
		<div id="container" style="margin-top: 30px;">
			<table id="student" border="0" cellspacing="0" cellpadding="0" class="display">
				<thead>
					<tr>
						<td>学号</td>
						<th>姓名</th>
						<td>专业班级</td>
						<td>政治面貌</td>
						<td>家庭地址</td>
						<td>寝室</td>
						<td>困难生</td>
						<td>学业情况</td>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>	
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				var settings={				
						"pagingType":"full_numbers",
						"deferRender":true,
				        "stateSave":false,
				        "order":[[3,"asc"]],
				        "lengthMenu":[[5,8,10,20,50,-1],[5,8,10,20,50,'All']],
				        "pageLength":8,
				        "scrollY":400,
				        "scrollCollapse":true,
				        "language":{
				        	lengthMenu :"每页显示 _MENU_记录", 
					        zeroRecords : "没有匹配的数据", 
					        info : "第_PAGE_页/共 _PAGES_页", 
					        infoEmpty : "没有符合条件的记录", 
					        search : "查找", 
					        infoFiltered : "(从 _MAX_条记录中过滤)", 
					        paginate : { "first" : "首页 ", "last" : "末页", "next" : "下一页", "previous" : "上一页"}
				        }		
				};	
				var tb=$("#student").DataTable(settings);	//表格初始化		
				var vm=new Vue({
					el:'#app',
					data:{
						academy:'',
						teacher:''
					},
					methods:{
						getTeacher:function(){
							$("#teacher option").not(":first-child").remove();
							$.ajax({
								type:"post",
								url:"getTeacher.php",
								async:true,
								data:{
									"academy":this.academy
								},
								success:function(data){
									var teachers=JSON.parse(data);
									var addHtml="";
									teachers.forEach(function(row ,index){
										addHtml+='<option value="'+row['teacher_id']+'">'+row['name']+'</option>'
									});
									$("#teacher").append(addHtml);
								}
								
							});
						},
						getStudent:function(){								
							settings={
								"processing":true,
								"ajax":{
									 url:"deal_student.php",
									 "data":{
									 	academy:vm.academy,
									 	teacher:vm.teacher
									 }	
								},
								 "columnDefs":[
									{data:"F1",targets:0},
									{data:"F2",targets:1},
									{data:"F3",targets:2},
									{data:"F4",targets:3},
									{data:"F5",targets:4},
									{data:"F6",targets:5},
									{data:"F7",targets:6},
									{data:"F8",targets:7},
								]
								,
								"pagingType":"full_numbers",
								"deferRender":true,
						        "stateSave":false,
						        "order":[[3,"asc"]],
						        "lengthMenu":[[5,8,10,20,50,-1],[5,8,10,20,50,'All']],
						        "pageLength":8,
						        "language":{
						        	lengthMenu :"每页显示 _MENU_记录", 
							        zeroRecords : "没有匹配的数据", 
							        info : "第_PAGE_页/共 _PAGES_页", 
							        infoEmpty : "没有符合条件的记录", 
							        search : "查找", 
							        infoFiltered : "(从 _MAX_条记录中过滤)", 
							        paginate : { "first" : "首页 ", "last" : "末页", "next" : "下一页", "previous" : "上一页"}
						        }							
							}
							tb.destroy();
							tb=$("#student").DataTable(settings);
						},
						analyse:function(){							
							$.ajax({
								type:"post",
								url:"../data_analyse/deal.php",
								async:true,
								data:{
									academy:vm.academy,
									teacher:vm.teacher
								},
								success:function(data){
									location.href="../data_analyse/chart.php?data="+data;										
								},
								error:function(){
									alert("发生未知错误");
								}
							});
						}
								
					}
							
						
					
				});	
				
				
			});	
			</script>
	</body>
</html>
