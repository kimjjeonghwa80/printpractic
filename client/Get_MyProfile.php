<?php
	require("../lock.php");
	require("../library/config.php");
?>
<form action="javascript:void(0);" name="myprofile" id="myprofile" method="post">
	<?php 
	$res = mysql_query("SELECT * FROM customers WHERE user_login='".$login_session."'");
	if (mysql_num_rows($res))
	{
		while ($user = mysql_fetch_assoc($res))
		{
	?>						
			<div class="modal-body">
				<input type="hidden" id="id" value="<?php echo $user["id"]; ?>" value="" />
				<div class="row">
					<div class="col-md-5">
						<img src="<?php echo $user["img_path"]; ?>" id="edit_previewImage" class="img-responsive img-brd center-block"  alt="Your image" name="edit_img-brd" alt="" style="width:200px;height:200px;border-radius: 100px;">
						<div class="clearfix"></div>
						<div class="element-upload">
							<label class="btn btn-primary center-block" data-toggle="tooltip" data-placement="left" title="Add Image" for="userimages" style="width:135px;background-color:#87cac1;border-color:#87cac1;"><i class="fa fa-upload"></i>&nbsp;&nbsp;Upload Image</label>
							<input id="userimages" type="file" onchange="edit_readIMG(this);" name="userimages" style="display:none;" />
						</div>
					</div>
					<div class="col-md-7">
						<div class="form-inline row">
							<div class="form-group">
								<label for="" class="col-md-5">User Name</label>
								<div class="col-md-7">
									<input type="text" name="" class="form-control" id="username" placeholder="" value="">
								</div>
							</div>
						</div></br>
						<div class="form-inline row">
							<div class="form-group">
								<label for="" class="col-md-5">First Name</label>
								<div class="col-md-7">
									<input type="text" name="" class="form-control" id="firstname" placeholder="" value="<?php echo $user["first_name"]; ?>">
								</div>
							</div>
						</div></br>
						<div class="form-inline row">
							<div class="form-group">
								<label for="" class="col-md-5">Last Name</label>
								<div class="col-md-7">
									<input type="text" name="" class="form-control" id="lastname" placeholder="" value="<?php echo $user["last_name"]; ?>">
								</div>
							</div>
						</div></br>
						<div class="form-inline row">
							<div class="form-group">
								<label for="" class="col-md-5">Email Address</label>
								<div class="col-md-7">
									<input type="text" name="" class="form-control" id="eaddress" placeholder=""  value="" style="margin-left: -6px;">
								</div>
							</div>
						</div></br>
						<div class="form-inline row">
							<div class="form-group">
								<label for="" class="col-md-12" style="margin-left: 60px;"><a href="javascript:void(0);" style="color:#87cac1;" id="changepass">Change Password</a></label>
							</div>
						</div></br>
						<div id="displaypassword" style="display:none;">
							<div class="form-inline row">
								<div class="form-group">
									<label for="" class="col-md-5">Old Password</label>
									<div class="col-md-7">
										<input type="text" name="" class="form-control" id="oldpassword" placeholder="" value="" style="margin-left: -6px;">
									</div>
								</div>
							</div></br>
							<div class="form-inline row">
								<div class="form-group">
									<label for="" class="col-md-5">New Password</label>
									<div class="col-md-7">
										<input type="text" name="" class="form-control" id="newpassword" placeholder=""  value="" style="margin-left: -9px;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color:#87cac1;border-color:#87cac1;">Cancel</button>
				<button type="submit" class="btn btn-primary" style="background-color:#87cac1;border-color:#87cac1;" onclick="myFunction()">Update</button>
			</div>
	<?php
		}
	} 
	?>
</form>
<script>
	 $('#changepass').on('click', function (event) {
		  $('#displaypassword').slideToggle("slow");
	 });
	 
	function edit_readIMG(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#edit_previewImage').show();
				$('#edit_previewImage').attr('src', e.target.result).width(150).height(150);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	var files;
	$('#userimages').on('change', userimages_uploads);

	function userimages_uploads(event) {
		files = event.target.files;
	}

	function useruploads() {
		var data = new FormData();
		$.each(files, function(key, value) {
			data.append("userimages", value);
		});
		$.ajax({
			url: 'user_upload.php?files',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(data) {
			 alert(data);
			 Mypro();
			},
			error:function() {  	 
				Mypro();
			}
		});
	}
</script>