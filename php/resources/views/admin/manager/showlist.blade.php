@extends("admin/buju/layout")
@section("tou")
@parent
@endsection




@section("title","管理员管理")
@section("content")
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员中心 <span class="c-gray en">&gt;</span> 管理员管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container" style="margin-right: 24px;">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
		<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜管理员</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加管理员','/admin/manager/tianjia','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>88</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort" style="margin-left: 0px">
			<thead>
			<tr class="text-c">
				<th width="8%"><input type="checkbox" name="" value=""></th>
				<th width="8%">ID</th>
				<th width="12%">管理员名</th>
				<th width="8%">性别</th>
				<th width="9%">手机</th>
				<th width="10%">邮箱</th>
				<th width="10%">角色</th>
				<th width="10%">加入时间</th>
				<th width="7%">状态</th>
				<th width="*">操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($info as $v)

				<tr class="text-c">
					<td><input type="checkbox" value="1" name=""></td>
					<td>{{$v->mg_id}}</td>
					<td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','360','400')">{{$v->username}}</u></td>
					<td>{{$v->mg_sex}}</td>
					<td>{{$v->mg_phone}}</td>
					<td>{{$v->mg_email}}</td>
					<td>{{$v->role->role_name}}</td>
					<td>{{$v->created_at}}</td>
					<td class="td-status"><span class="label label-success radius">已启用</span></td>
					<td class="td-manage">

						<a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
						<a title="编辑" href="javascript:;" onclick="member_edit('编辑','/admin/manager/xiugai/{{$v->mg_id}}','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','change-password.html','10001','600','270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a>
						<a title="删除" href="javascript:;" onclick="member_del(this,'{{$v->mg_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
	/*管理员-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
	/*管理员-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
	/*管理员-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

	/*管理员-启用*/
    function member_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!',{icon: 6,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
	/*管理员-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
	/*密码-修改*/
    function change_password(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
	/*管理员-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/manager/del/'+id,
                dataType: 'json',
                headers:{'X-CSRF-TOKEN':"{{csrf_token()}}"},
                success: function(data){
                    if(data.success==true){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }else{
                        layer.msg('删除有问题!',{icon:2,time:1000});
                    }

                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>
@endsection
</body>
</html>