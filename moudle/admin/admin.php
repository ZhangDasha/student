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
		<script type="text/javascript" src="../../res/jquery.table2excel.min.js"></script>
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
					<li><a href="../datashow/data_show.php">信息查询</a></li>
					<li class="active"><a href="#">信息管理</a></li>
					<li><a href="http://www.sut.edu.cn">工大</a></li>
					<li><a href="http://library.sut.edu.cn/">图书馆</a></li>
				</ul>
			</div>
		  </div>
		</nav>
		<div id="app">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#aca_tea">学院/辅导员</a></li>
				<li><a data-toggle="tab" href="#record_content">答题记录</a></li>
				<li><a data-toggle="tab" href="#database_content">数据库表</a></li>
			</ul>
			<div style="padding: 10px 30px;" class="tab-content">
				<div id="aca_tea" class="tab-pane fade in active">
					<div class="col-xs-5" id="academy_content">
						<table id="academy" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
							<caption>学院信息</caption>	
							<thead>
								<tr>
									<th>ID</th>
									<th>学院</th>
									<th>操作</th>
								</tr>
								<?php
									$res=mysqli_query($conn,'select * from academy');				
									while($row=mysqli_fetch_array($res)){
								?>
								<tr>
									<td><?php echo $row['id'];?></td>
									<td><?php echo $row['name'];?></td>
									<td>
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acaModal" @click="currentRow=[]">添加</button>
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acaModal" @click="editshow($event)">编辑</button>
										<button class="btn btn-danger btn-sm"  @click="remove('academy',$event)">删除</button>
									</td>
								</tr>			
								<?php	
									}
								?>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot></tfoot>
						</table>
					</div>	
					<div class="col-xs-7" id="teacher_content">
						<table id="teacher" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
							<caption>辅导员信息</caption>
							<thead>
								<tr>
									<th>学院ID</th>
									<th>辅导员ID</th>
									<th>辅导员姓名</th>
									<th>数据库表名</th>
									<th>操作</th>
								</tr>
								<?php
									$res=mysqli_query($conn,'select * from teacher');				
									while($row=mysqli_fetch_array($res)){
								?>
								<tr>
									<td><?php echo $row['academy_id'];?></td>
									<td><?php echo $row['teacher_id'];?></td>
									<td><?php echo $row['name'];?></td>
									<td><?php echo $row['table_name'];?></td>
									<td>
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#teaModal" @click="currentRow=[];op=''">添加</button>
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#teaModal" @click="editshow($event)">编辑</button>
										<button class="btn btn-danger btn-sm"  @click="remove('teacher',$event)">删除</button>
									</td>
								</tr>			
								<?php	
									}
								?>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot></tfoot>
						</table>
					</div>
				</div>
				<div id="record_content" class="tab-pane fade">
					<button class="btn btn-primary pull-right" @click="exp">导出</button>
					<button class="btn btn-danger pull-right" @click="delRecords">全部删除</button>
					<table id="record" data-tableName="record" class="table table-striped table-bordered"  cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>学院</th>
								<th>辅导员</th>
								<th>记录</th>
								<th>当前总分</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql="SELECT academy.name as Aname,teacher.name as tName,record.record,record.score FROM record,academy,teacher WHERE record.academy_id=academy.id and record.teacher_id=teacher.teacher_id";
								$res=mysqli_query($conn,$sql);		
								while($row=mysqli_fetch_assoc($res)){
							?>
							<tr>
								<td><?php echo $row['Aname'];?></td>
								<td><?php echo $row['tName'];?></td>
								<td><?php echo $row['record'];?></td>
								<td><?php echo $row['score'];?></td>
							</tr>
							
							<?php		
								}
							?>
						</tbody>
						<tfoot></tfoot>
					</table>
				</div>
				<div id="database_content" class="tab-pane fade">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<td>数据库表名</td>
								<td>操作</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$r=mysqli_query($conn,"select table_name from teacher");
								while($row2=mysqli_fetch_array($r)){
							?>
							<tr>
								<td><?php echo $row2['table_name'] ?></td>
								<td>
									<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tbModal">添加</button>
									<button class="btn btn-danger btn-sm"  @click="tb_remove($event)">删除</button>
								</td>
							</tr>
							<?php		
								}
							?>
						</tbody>
					</table>
				</div>
			</div>			
			<div class="modal" id="acaModal">
				<div class="modal-dialog">				
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
								数据添加
							</h4>
						</div>
						<div class="modal-body">
							<form role='form'>
								<div class="form-group">
									<label for="id">ID</label>
									<input type="text" name="id" class="form-control" placeholder="ID" :disabled="op=='edit'" v-model="currentRow[0]">
									<label for="teacher">学院</label>
									<input type="text" name="teacher" class="form-control" placeholder="学院"  v-model="currentRow[1]">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss='modal' >取消</button>
							<button class="btn btn-primary" v-if="op==='edit'" @click="edit('academy')" >更新</button>
							<button class="btn btn-primary" v-else data-dismiss='modal' @click="add('academy')">添加</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal" id="teaModal">
				<div class="modal-dialog">	
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
								数据添加
							</h4>
						</div>
						<div class="modal-body">
							<form role='form'>
								<div class="form-group">
									<label for="academy_id">学院ID</label>
									<input type="text" id="academy_id" class="form-control"  :disabled="op=='edit'" v-model="currentRow[0]">
									<label for="teacher_id">辅导员ID</label>
									<input type="text" id="teacher_id" class="form-control"  :disabled="op=='edit'" v-model="currentRow[1]">
									<label for="name">辅导员姓名</label>
									<input type="text" id="name" class="form-control"   v-model="currentRow[2]">
									<label for="table_name">数据库表名</label>
									<input type="text" id="table_name" class="form-control"  v-model="currentRow[3]">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss='modal' >取消</button>
							<button class="btn btn-primary" v-if="op==='edit'" @click="edit('teacher')">更新</button>
							<button class="btn btn-primary" v-else data-dismiss='modal' @click="add('teacher')">添加</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal" id="tbModal">
				<div class="modal-dialog">				
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
								数据添加
							</h4>
						</div>
						<div class="modal-body">
							<form role='form'>
								<div class="form-group">
									<label for="databae">数据库表名</label>
									<input type="text" id="databae" class="form-control"  v-model="database">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss='modal' >取消</button>
							<button class="btn btn-primary"  @click="tb_add">确定</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			var vm=new Vue({
				el:'#app',
				data:{
					currentRow:[],
					op:'',
					tb:null,
					database:''
				},
				methods:{
					getRow (item) {
						this.currentRow=[]
						var tds=$(item).parents('tr').children('td')
						for(var i=0;i<tds.length-1;i++){
							this.currentRow.push(tds[i].innerHTML)
						}
					},
					add (name) {
						var sql=''
						if(name==='teacher'){
							sql="insert into teacher(academy_id,teacher_id,name,table_name) values('"+this.currentRow[0]+"','"+this.currentRow[1]+"','"+this.currentRow[2]+"','"+this.currentRow[3]+"')";	
						} else if(name==='academy') {
							sql="insert into academy(id,name) values('"+this.currentRow[0]+"','"+this.currentRow[1]+"')";	
						}
						$.ajax({
							type:'post',
							url:'add.php',
							data:{'sql':sql},
							success:function(data) {
								alert(data)
								document.location.reload();
							},
							error:function(){
								alert('添加失败')
							}
						})
						
					},
					editshow (event) {
						var item=event.target;
						this.getRow(item)
						this.op='edit'
					},
					edit (name) {
						var sql=''
						if(name==='teacher'){
							sql="update teacher set name='"+this.currentRow[2]+"',table_name='"+this.currentRow[3]+"' where academy_id='"+this.currentRow[0]+"' and teacher_id='"+this.currentRow[1]+"'";
						} else if(name='academy') {
							sql="update academy set name='"+this.currentRow[1]+"' where id='"+this.currentRow[0]+"'";
						}
						$.ajax({
							type:'post',
							url:'edit.php',
							data:{'sql':sql},
							success:function(data) {
								alert(data)
								document.location.reload();
							},
							error:function(){
								alert('删除失败')
							}
						})
					},
					remove (name,event){
						var item=event.target
						var curr=this.getRow(item)
						var sql=''
						if(name==='teacher'){
							sql="delete from teacher where academy_id ='"+this.currentRow[0]+"' and teacher_id='"+this.currentRow[1]+"'";	
						} else if(name==='academy') {
							sql="delete from academy where id ='"+this.currentRow[0]+"'"	
						}
						$.ajax({
							type:'post',
							url:'del.php',
							data:{'sql':sql},
							success:function(data) {
								alert(data)
								document.location.reload();
							},
							error:function(){
								alert('删除失败')
							}
						})
					},
					exp () {
						$("#record").table2excel({
							exclude: ".noExl",
							name: "Excel Document Name",
							filename: "record",
							exclude_img: true,
							exclude_links: true,
							exclude_inputs: true
						});
					},
					delRecords(){
						var sql="delete from record"
						$.ajax({
							type:'post',
							url:'delRecord.php',
							data:{
								'sql':sql
							},
							success:function(data){
								alert(data);
								document.location.reload();
							},
							error:function () {
								alert('删除失败');
							}
						})
					},
					tb_add () {
						
					}
					
				}
			})
		})
		</script>
	</body>
</html>
