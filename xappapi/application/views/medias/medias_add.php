<!----------------------Podcasts add---------------->
<div class="container summary-header">
	<h2>Add Media</h2>
	<a class="btn btn-primary btn-lg" onclick="onEditMedia_Back();"><i class="icon-white icon-chevron-left"></i> Back</a>
</div> <!-- /container -->

<div class="container" id="client_row">
	<div id="client_row_div">
		<form id="myForm" class="form-horizontal">
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="user_id">User ID :&nbsp;</label>
			  <div class="controls">
				<input id="user_id" name="user_id" type="text" placeholder="" class="input-medium" required="">				
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="thumbnail">Thumbnail :&nbsp;</label>
			  <div class="controls">
				<input id="thumbnail" name="thumbnail" type="text" placeholder="https://i.ytimg.com/vi/Fj35SmJpwn0/hqdefault.jpg" class="input-xlarge" required="">
				
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="url">Media Url :&nbsp;</label>
			  <div class="controls">
				<input id="url" name="url" type="text" placeholder="https://www.youtube.com/watch?v=Fj35SmJpwn0" class="input-xlarge">
				
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="title">Title :&nbsp;</label>
			  <div class="controls">
				<input id="title" name="title" type="text" placeholder="" class="input-xlarge" required="">			
			  </div>
			</div>
			<!-- Textarea -->
			<div class="control-group">
			  <label class="control-label" for="description">Description :&nbsp;</label>
			  <div class="controls">                     
				<textarea id="description" name="description"></textarea>
			  </div>
			</div>
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="date">Date :&nbsp;</label>
			  <div class="controls">
				<input id="date" name="date" type="text" placeholder="1985-01-01 12:00:00" class="input-medium">			
			  </div>
			</div>
			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="ord">Order :&nbsp;</label>
			  <div class="controls">
				<input id="ord" name="ord" type="text" placeholder="" class="input-mini" required="" value='0'>
			  </div>
			</div>
			
			<!-- Multiple Checkboxes (inline) -->
			<div class="control-group">
			  <label class="control-label" for="checkboxes"></label>
			  <div class="controls">
				<label class="checkbox inline" for="type">
				  <input type="checkbox" name="checkboxes" id="type" value="Is Member Media?">
				  Is Audio?
				</label>
			  </div>
			</div>
			
			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="addmedia"></label>
			  <div class="controls" style="padding-left:150px;">
				<label class="control-label" for="addmedia"></label>
				<button id="addmedia" name="addmedia" class="btn btn-primary btn-lg" type="submit" onclick="onMedia_Add_Submit();">Submit</button>
			  </div>
			</div>

			</fieldset>
		</form>

	</div>
</div>

<script>
	$("#user_id").focus();
</script>