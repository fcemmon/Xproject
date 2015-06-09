<!----------------------Podcasts add---------------->
<div class="container summary-header">
	<h2>Add User</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditUsers_Back();"><i class="icon-white icon-chevron-left"></i> Back</a>
</div> <!-- /container -->

        <div class="container" id="client_row">
            <div id="client_row_div">
				<form id="myForm">
						<div style="margin-top:20px;">
							<div class="edit_text1">Username :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="username" class="required"  style="width:300px;" maxlength=25></div>
						</div>
						<div>
							<div class="edit_text1">Password :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="password" class="required"  style="width:300px;"  maxlength=25></div>
						</div>
						<div>
							<div class="edit_text1">First Name :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="firstname" class="required"  size=15 maxlength=15></div>
						</div>
						<div>
							<div class="edit_text1">Last Name :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="lastname" class="required"  size=15 maxlength=15></div>
						</div>
						<div>
							<div class="edit_text1">Gender :&nbsp;</div>
							<div class="edit_input1" style="padding-bottom:20px;"><input type="radio" name="gender" id="gender" class="required" value="0" checked>Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  name="gender" id="gender" class="required" value="1">Female</div>
						</div>
						<div>
							<div class="edit_text1">Email :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="email" class="required"  style="width:300px;" maxlength=40></div>
						</div>
						<div>
							<div class="edit_text1">Birthday :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="birthday" class="required" size=15 maxlength=10>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ex: 01-01-1985)</div>
						</div>
						<div>
							<div class="edit_text1">Country :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="country" class="required"  size=20 maxlength=20></div>
						</div>
						<div>
							<div class="edit_text1">Zipcode :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="zipcode" class="required"  size=15 maxlength=10></div>
						</div>
						<div>
							<div class="edit_text1">Phone :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="phonenumber" class="required"  size=20 maxlength=20></div>
						</div>
						<div>
							<div class="edit_text1">&nbsp;</div>
							<div class="edit_input1"><input type="checkbox" id="usergrade" class="required" style="" >&nbsp;Is Admin?</div>
						</div>
						<div style="margin-top:20px;text-align: right;width:81%;">
							<button class="btn btn-primary btn-lg"  type="submit" onclick="onUsers_Add_Submit();">Submit</button>
						</div>
				</form>
            </div>
        </div>

    <script>
        $("#username").focus();
    </script>