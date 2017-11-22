<?php include "../../db/conn.php";?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>考核</title>
		<link href="../../res/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<script src="../../res/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../res/vue.js"></script>
		<style type="text/css">
			label{
				font-size: 20px;
				font-weight: bold;
			}
			*{
				font-family: 'STKaiti';
			}
			body{
				font-family: 'STKaiti';
				font-size:18px;
			}
			.colockbox{width:283px;height:76px;margin:20px auto;background:url(img/colockbg.png) no-repeat;float: right;}
			.colockbox span{float:left;display:block;width:58px;height:48px;line-height:48px;font-size:26px;text-align:center;color:#ffffff;margin:0 17px 0 0;}
			.colockbox span.second{margin:0;}
			#demo02{width:208px;background-position:-75px 0;}
		</style>
	</head>
	<body>
		<h2 align="center" style="font-weight: bold;">沈阳工业大学辅导员考核系统</h2>		
		<div class="container" id="app">
			<a class="btn btn-primary" href="../admin/admin.php" style="position:absolute;right:20px;top:30px;">后台</a>
			<div class="col-xs-5">			
					<table border="1" cellspacing="20" cellpadding="20" style="padding: 100px 100px 150px;">
						<tbody>
							<tr >
								<td colspan="4">
									<img src="img/123.jpg" alt="" width="100%" height="490px" id="stu_pic"/>
								</td>
							</tr>
							<tr>
								<td>
										<select name="academy" v-model="academy" id="academy" v-on:change="getTeacher" class="form-control">
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
								</td>
								<td>
									<select  name="teacher" v-model="teacher" id="teacher" class="form-control">
										<option value="" disabled="disabled">选辅导员</option>					
									</select>
								</td>
								<td>
									<button type="button" class="form-control btn btn-primary" v-on:click="getStudent">确定</button>
								</td>								
							</tr>
							<tr>
								<td colspan="4"><input type="button" class="btn btn-primary btn-block" value="start" id="switch" v-on:click="swit($event)" /></td>
							</tr>
						</tbody>
					</table>
			</div>	
			<div class="col-xs-7" >
				<div class="colockbox" id="demo02">
					<span class="hour">-</span>
					<span class="minute">-</span>
					<span class="second">-</span>
				</div>
				<table class="table table-bordered">
					<tr>
						<td>姓名</td>
						<td style="width: 200px;"></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F2"/></td>		
						<td><label><input type="checkbox" value="2" name="1"  class="radio-inline" />对</label></td>
					</tr>
					<tr>
						<td>专业班级</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F3"/></td>
						<td><label><input type="checkbox" value="2" name="3" class="radio-inline"/>对</label></td>
					</tr>
					<tr>
						<td>政治面貌</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F4"/></td>
						<td><label><input type="checkbox" value="2" name="2" class="radio-inline"/>对</label></td>
					</tr>
					<tr>
						<td>家庭住址</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F5"/></td>
						<td><label><input type="checkbox" value="2" name="5"  class="radio-inline"/>对</label></td>
					</tr>
					<tr>
						<td>宿舍</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F6"/></td>
						<td><label><input type="checkbox" value="2" name="4"  class="radio-inline"/>对</label></td>
					</tr>			
					<tr>
						<td>困难生</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F7"/></td>
						<td><label><input type="checkbox" value="2" name="6"  class="radio-inline"/>对</label></td>
					<tr>
						<td>学业情况</td>
						<td></td>
						<td><input type="button" class="query btn btn-block btn-primary" value="查询" title="F8"/></td>
						<td><label><input type="checkbox" value="2" name="7"  class="radio-inline"/>对</label></td>
					</tr>
					<tr>
						<td colspan="1"> <input type="button" name="" id="cal" value="计算累计得分"  class="btn btn-block btn-primary"/> </td>
						<td colspan="3"><input type="text" id="score" v-model="score" class="form-control" readonly="readonly" /></td>
						<td style="line-height: 100%;text-align: center;">{{count}}次</td>
					</tr>
				</table>
			</div>	
		</div>	
			<script type="text/javascript">
				function change(){
					var len=vm.student_data.length;		
				    vm.rand=parseInt(Math.random()*len);
					if($("#switch").val()=='stop'){
						
						$("#stu_pic").attr("src","imgs/"+vm.academy+"/"+vm.teacher+"/"+vm.student_data[vm.rand].F1+".jpg");							
					}else{

						clearInterval(vm.timer);
					}
				}
						
				var vm=new Vue({
					el:'#app',
					data:{
						academy:'',
						teacher:'',
						grade:[],
						studentID:[],
						student_data:[],
						score:0,
						record:[],
						count:0,
						rand:0,
						timer:null
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
							if(vm.count==0){
								countDown(null,"#demo02 .hour","#demo02 .minute","#demo02 .second")	
							}
							vm.count=0
							vm.score=0		
							$.ajax({
								type:"post",
								url:"getStudent.php",
								async:true,
								data:{
									academy:vm.academy,
									teacher:vm.teacher
								},
								success:function(data){	
									vm.student_data=JSON.parse(data);
									console.log(vm.student_data)
								}
							});
						},
						analyse:function(){		//发送给数据分析的请求					
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
						},
						op:function($event){//没有用上，本来作用是扩大radio的选择范围，最后通过label包裹就搞定了						
							var ele=$event.target;						
							var a=$(ele).children("label").children("input").prop("checked");							
							$(ele).children("label").children("input").prop("checked",!a);
						},
						swit:function($event){//播放的开关
							var ele=$event.target;//获取触发事件的元素
							$(ele).val(($(ele).val()=='start')?'stop':'start');					
							vm.timer=setInterval('change()',100);
						}				
					}
					});
				$(".query").click(function(){
					var index=$(this).attr("title");
					console.log(index)
					console.log(vm.student_data[vm.rand][index])
					$(this).parent().prev().text(vm.student_data[vm.rand][index]);
				});
				$("#cal").click(function(){	
					if(vm.count>=10){
						alert("考核结束");
						return false;
					}else {
						vm.count++;
						$(".query").parent().prev().text("");
						$("input[type=checkbox]").each(function(index){	
							var t;
							if(this.checked){
								t= $(this).val()
							}else {
								t=0;
							}
							vm.record.push(t)					
							vm.score+=parseInt(t);
						});	
						//将答题记录存到数据库中
						$.ajax({
							type:'post',
							url:'store_record.php',
							data:{
								record:vm.record.join(''),
								academy:vm.academy,
								teacher:vm.teacher,
								score:vm.score
							},
							success:function(data){
								vm.record=[]
							},
							error:function() {
								alert(data);
							}
						})
						$("input[type=checkbox]").each(function(index){
							this.checked=false;
						});
					}
				});
				function countDown(day_elem,hour_elem,minute_elem,second_elem){
					var end_time = new Date().getTime()+5*60*1000,//月份是实际月份-1
					sys_second = (end_time-new Date().getTime())/1000;
					var timer = setInterval(function(){
						if (sys_second > 0) {
							sys_second -= 1;
							var day = Math.floor((sys_second / 3600) / 24);
							var hour = Math.floor((sys_second / 3600) % 24);
							var minute = Math.floor((sys_second / 60) % 60);
							var second = Math.floor(sys_second % 60);
							day_elem && $(day_elem).text(day);//计算天
							$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
							$(minute_elem).text(minute<10?"0"+minute:minute);//计算分
							$(second_elem).text(second<10?"0"+second:second);// 计算秒
						} else { 
							clearInterval(timer);
							alert("结束")
						}
					}, 1000);
				}
			</script>		
		<script src="../../res/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>