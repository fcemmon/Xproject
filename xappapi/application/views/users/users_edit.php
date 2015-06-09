<div class="container summary-header">
	<h2>Edit User</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditUsers_Back();"><i class="icon-white icon-chevron-left"></i> Back</a>
</div> <!-- /container -->

	<div class="container" id="client_row">
            <div id="client_row_div">
<form id="myForm">
						<div style="margin-top:20px;">
							<div class="edit_text1">Username :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="username" value="<?php echo $users['username'];?>" class="required"  style="width:350px;" maxlength=25></div>
						</div>
						<div>
							<div class="edit_text1">Password :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="password" value="<?php echo $users['password'];?>" class="required"  style="width:350px;"  maxlength=25></div>
						</div>
						<div>
							<div class="edit_text1">First Name :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="firstname" value="<?php echo $users['firstname'];?>" class="required"  size=15 maxlength=15></div>
						</div>
						<div>
							<div class="edit_text1">Last Name :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="lastname" value="<?php echo $users['lastname'];?>" class="required"  size=15 maxlength=15></div>
						</div>
						<div>
							<div class="edit_text1">Gender :&nbsp;</div>
							<div class="edit_input1" style="padding-bottom:20px;">
							<input type="radio" name="gender" id="gender" class="required" value="0" <?php if($users['gender']==0) echo "checked";?>>Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio"  name="gender" id="gender" class="required" value="1" <?php if($users['gender']==1) echo "checked";?>>Female</div>
						</div>
						<div>
							<div class="edit_text1">Email :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="email" value="<?php echo $users['email'];?>" class="required"  style="width:350px;" maxlength=40></div>
						</div>
						<div>
							<div class="edit_text1">Birthday :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="birthday" value="<?php echo $users['birthday'];?>" class="required" size=15 maxlength=10>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ex: 01-01-1985)</div>
						</div>
						<div>
							<div class="edit_text1">Country :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="country" value="<?php echo $users['country'];?>" class="required"  size=20 maxlength=20></div>
						</div>
						<div>
							<div class="edit_text1">Zipcode :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="zipcode" value="<?php echo $users['zipcode'];?>" class="required"  size=15 maxlength=10></div>
						</div>
						<div>
							<div class="edit_text1">Phone :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="phonenumber" value="<?php echo $users['phonenumber'];?>" class="required"  size=20 maxlength=20></div>
						</div>

                    <div>
						<div class="edit_text1">&nbsp;</div>
						<?php if ($users['usergrade']) { ?>
						<div class="edit_input1"><input type="checkbox" id="usergrade" class="required" style="" checked>&nbsp;Admin</div>
						<?php } else { ?>
						<div class="edit_input1"><input type="checkbox" id="usergrade" class="required" style="">&nbsp;Admin</div>
						<?php }?>
					</div>
                    <div style="margin-top:20px;text-align: right;width:81%;">
	                <button class="btn btn-primary btn-lg" onclick="onUsers_Edit_Submit(<?php echo $users['id'];?>);">Submit</button>
                    </div>
</form>
          </div>
 </div>    