<!----------------------Podcasts add---------------->
<div class="container" style="margin-top:40px">
	<h1>Add Recorded User</h1>
	<a class="btn btn-primary btn-large" style="margin-top:24px;"  onclick="onEditUsers_Back();">Back</a>
</div> <!-- /container -->

        <div class="container" id="client_row">
            <div id="client_row_div">
				<form id="myForm">
						<div style="margin-top:20px;">
							<div class="edit_text1">Username :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="username" class="required" style="width:100%;"></div>
						</div>
						<div>
							<div class="edit_text1">Password :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="password" class="required" style="width:100%;" ></div>
						</div>
						<div>
							<div class="edit_text1">Company :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="company" class="required" style="width:100%;" ></div>
						</div>
						<div>
							<div class="edit_text1">Email :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="email" class="required" style="width:100%;"></div>
						</div>
						<div>
							<div class="edit_text1">Phone :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="phone" class="required" style="width:100%;"></div>
						</div>
						<div>
							<div class="edit_text1">Customer_id :&nbsp;</div>
							<div class="edit_input1"><input type="text" id="customer_id" class="required" style="width:100%;" ></div>
						</div>
						<div style="margin-top:20px;text-align: right;width:81%;">
							<button class="btn btn-large btn-primary"  type="submit" onclick="onUsers_Add_Submit();">Submit</button>
						</div>
				</form>
            </div>
        </div>

    <script>
        $("#name").focus();
    </script>