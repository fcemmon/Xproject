<div class="container" style="margin-top:40px">
	<h1>Edit Item</h1>
	<a class="btn btn-primary btn-large" style="margin-top:24px;"  onclick="onEditItems_Back();">Back</a>
</div> <!-- /container -->

	<div class="container" id="client_row">
            <div id="client_row_div">
<form id="myForm">
                    <div style="margin-top:20px;">
                        <div class="edit_text1">Id :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="id" value="<?php echo $items['id'];?>" class="required" style="width:100%;" disabled></div>
                    </div>
					<div>
                        <div class="edit_text1">Barcode_id :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="barcode" value="<?php echo $items['barcode_id'];?>" class="required" style="width:100%;" disabled></div>
                    </div>
                    <div>
                        <div class="edit_text1">Quantity :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="quantity" value="<?php echo $items['quantity'];?>" class="required" style="width:100%;" disabled></div>
                    </div>
                    <div>
                        <div class="edit_text1">Order_id :&nbsp;</div>
                        <div class="edit_input1"><input type="text" id="order_id" value="<?php echo $items['order_id'];?>" class="required" style="width:100%;" disabled></div>
                    </div>
                    <div style="margin-top:20px;text-align: right;width:81%;">
	                <button class="btn btn-large btn-primary" onclick="onItems_Edit_Submit(<?php echo $items['id'];?>);">Submit</button>
                    </div>
</form>
          </div>
 </div>    