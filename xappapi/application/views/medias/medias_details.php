<div class="container summary-header">
	<h2>Media Details</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditMedias_Back();">Back</a>
</div> <!-- /container -->

	<div class="container" id="client_row">
            <div id="client_row_div">
<form id="myForm">
                    <div style="margin-top:20px;">
                        <div class="edit_text1">Id :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="name" value="<?php echo $medias['id'];?>" class="required" style="width:100%;"></div>
                    </div>
					<div>
                        <div class="edit_text1">Name :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="address" value="<?php echo $medias['medianame'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Password :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="address" value="<?php echo $medias['password'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Company :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="lat" value="<?php echo $medias['company'];?>" class="required" style="width:100%;" ></div>
                    </div>
                    <div>
                        <div class="edit_text1">Email :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="lon" value="<?php echo $medias['email'];?>" class="required" style="width:100%;"></div>
                    </div>
                    <div>
                        <div class="edit_text1">Phone :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="desc" value="<?php echo $medias['phone'];?>" class="required" style="width:100%;"></div>
                    </div>
                    <div>
						<div class="edit_text1">&nbsp;</div>
						<?php if ($medias['mediagrade']) { ?>
						<div class="edit_input1"><input type="checkbox" id="mediagrade" class="required" style="" checked>&nbsp;Admin</div>
						<?php } else { ?>
						<div class="edit_input1"><input type="checkbox" id="mediagrade" class="required" style="">&nbsp;Admin</div>
						<?php }?>
					</div>                    
</form>
          </div>
 </div>