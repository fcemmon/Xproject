<div class="container summary-header">
	<h2>Users Details</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditUsers_Back();">Back</a>
</div> <!-- /container -->

	<div class="container" id="client_row">
            <div id="client_row_div">
<form id="myForm">
                    <div style="margin-top:20px;">
                        <div class="edit_text1">Id :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="name" value="<?php echo $users['id'];?>" class="required" style="width:100%;"></div>
                    </div>
					<div>
                        <div class="edit_text1">Name :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="address" value="<?php echo $users['username'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Password :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="address" value="<?php echo $users['password'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Company :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="lat" value="<?php echo $users['company'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Email :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="lon" value="<?php echo $users['email'];?>" class="required" style="width:100%;"></div>
                    </div>
                    <div>
                        <div class="edit_text1">Phone :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="desc" value="<?php echo $users['phone'];?>" class="required" style="width:100%;"></div>
                    </div>
                    <div>
						<div class="edit_text1">&nbsp;</div>
						<?php if ($users['usergrade']) { ?>
						<div class="edit_input1"><input type="checkbox" id="usergrade" class="required" style="" checked>&nbsp;Admin</div>
						<?php } else { ?>
						<div class="edit_input1"><input type="checkbox" id="usergrade" class="required" style="">&nbsp;Admin</div>
						<?php }?>
					</div>                    
</form>
          </div>
 </div>