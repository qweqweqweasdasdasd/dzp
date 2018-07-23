@extends('admin/common/master')
@section('title','修改密码')
@section('content')
<div class="pd-20">
  <form class="Huiform" id="setpwd">
  	<input type="hidden" name="manager_id" value="{{$info->manager_id}}">
    <table class="table">
      <tbody>
        <tr>
          <th width="100" class="text-r">旧密码：</th>
          <td><input type="password" style="width:200px" class="input-text" value="" placeholder="输入旧密码" id="old_pwd" name="old_pwd"></td>
        </tr>
        <tr>
          <th class="text-r"> 新密码：</th>
          <td><input type="text" style="width:200px" class="input-text" value="" placeholder="输入新密码" id="new_pwd" name="new_pwd"></td>
        </tr>
        <tr>
          <th></th>
          <td><button class="btn btn-success radius" type="submit"><i class="icon-ok"></i> 确认提交</button></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#setpwd').submit(function(evt){
		evt.preventDefault();
		var shuju = $(this).serialize();
		var id = $('input[name="manager_id"]').val();
		//ajax
		$.ajax({
			url:'{{url("/manager/change_pwd")}}',
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('密码修改成功,请重新登录!',function(){
						parent.window.location.href = "{{url('/logout')}}";
						layer_close();
					});
				}else if(msg.code == 0){
					layer.alert(msg.error);
				}
			}
		});
	})
</script>
@endsection