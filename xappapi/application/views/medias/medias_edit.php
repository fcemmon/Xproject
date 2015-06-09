<!----------------------Podcasts add---------------->
<div class="container summary-header">
	<h2>Edit Media</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditMedia_Back();"><i class="icon-white icon-chevron-left"></i> Back</a>
</div> <!-- /container -->

<div class="container" id="client_row">
	<div id="client_row_div">
		<form id="myForm" class="form-horizontal">
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="userid">Media ID :&nbsp;</label>
			  <div class="controls">
				<input id="userid" name="userid" type="text" value="<?php echo $medias['user_id'];?>" placeholder="" class="input-medium" required="">				
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="thumbnail">Thumbnail :&nbsp;</label>
			  <div class="controls">
				<input id="thumbnail" name="thumbnail" type="text" value="<?php echo $medias['thumbnail'];?>" placeholder="https://i.ytimg.com/vi/Fj35SmJpwn0/hqdefault.jpg" class="input-xlarge" required="">
				
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="url">Media Url :&nbsp;</label>
			  <div class="controls">
				<input id="url" name="url" type="text" value="<?php echo $medias['url'];?>" placeholder="https://www.youtube.com/watch?v=Fj35SmJpwn0" class="input-xlarge">				
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="title">Title :&nbsp;</label>
			  <div class="controls">
				<input id="title" name="title" type="text" value="<?php echo $medias['title'];?>" placeholder="" class="input-xlarge" required="">			
			  </div>
			</div>
			<!-- Textarea -->
			<div class="control-group">
			  <label class="control-label" for="description">Description :&nbsp;</label>
			  <div class="controls">                     
				<textarea id="description" name="description" rows="5" class="input-xlarge"><?php echo $medias['description'];?></textarea>
			  </div>
			</div>
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="date">Date :&nbsp;</label>
			  <div class="controls">
				<input id="date" name="date" type="text" value="<?php echo $medias['date'];?>" placeholder="1985-01-01 12:00:00" class="input-medium" maxlength=19>			
			  </div>
			</div>
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="ord">Order :&nbsp;</label>
			  <div class="controls">
				<input id="ord" name="ord" type="text" value="<?php echo $medias['ord'];?>" placeholder="" class="input-mini" required="" value='0'>
			  </div>
			</div>
			
			<!-- Multiple Checkboxes (inline) -->
			<div class="control-group">
			  <label class="control-label" for="checkboxes"></label>
			  <div class="controls">
				<label class="checkbox inline" for="type">
				  <input type="checkbox" name="checkboxes" id="type" <?php if($medias['type']) echo "checked";?> value="Is Member Media?">
				  Is Audio?
				</label>
			  </div>
			</div>
			
			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="editmedia"></label>
			  <div class="controls" style="padding-left:150px;">
				<label class="control-label" for="editmedia"></label>
				<button id="editmedia" name="editmedia" class="btn btn-primary btn-lg" type="submit" onclick="onMedia_Edit_Submit(<?php echo $medias['id'];?>);">Submit</button>
			  </div>
			</div>

			</fieldset>
		</form>

	</div>
</div>

<script>
	$("#user_id").focus();
</script>