<!----------------------Pod Casts---------------->
<div class="container summary-header">
	<h2>Medias Summary</h2>
	<a class="btn btn-primary btn-lg" onclick="onAddMedia();">Add Media</a>
</div> <!-- /container -->

<div class="container" id="client_row">
	<div id="client_row_div">
		<div id="content_2" class="container">
			<table data-toggle="table" data-height="299" class="main table tablesorter summary-table" id="sortTableExample">
				<thead>
					<tr>
						<th data-field="id">ID</th>
						<th data-field="type">Type</th>
						<th data-field="user_id">UserID</th>
						<th data-field="thumbnail">Thumbnail</th>
						<th data-field="url">Url</th>
						<th data-field="title">Title</th>
						<th data-field="description">Description</th>
						<th data-field="date">Date</th>
						<th data-field="ord">Ord</th>
						<th data-field="action">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0;$i<count($medias);$i++){
					?>
					<tr class="tr_height" id="<?php echo $medias[$i]['id'];?>">
						<td><?php echo ($i+1);?></td>
						<td><?php echo $medias[$i]['type']==0?"Photo":"Audio";?></td>
						<td><span class="word-wrap mediaid"><?php echo $medias[$i]['user_id'];?></span></td>
						<td><span class="word-wrap mediathumb">
							<?php echo "<a href='".$medias[$i]['thumbnail']."' target='_blank'>".$medias[$i]['thumbnail']."</a>";?>
							</span></td>
						<td><span class="word-wrap mediaurl">
							<?php echo "<a href='".$medias[$i]['url']."' target='_blank'>".$medias[$i]['url']."</a>";?>
							</span></td>
						<td><?php echo $medias[$i]['title'];?></td>
						<td><span class="word-wrap description"><?php echo $medias[$i]['description'];?></span></td>
						<td title="<?php echo $medias[$i]['date'];?>"><span class="word-wrap date-content"><?php echo substr($medias[$i]['date'],0,10);?></span></td>
						<td><?php echo $medias[$i]['ord'];?></td>
						<td>
							<div class="btn-group">
							  <a class="btn btn-primary btn-small" href="#"><i class="icon-th icon-white"></i> Action</a>
							  <a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							  <ul class="dropdown-menu">
								<!--<li><a href="javascript: onmediasDetails(<?php echo $medias[$i]['id'];?>);"><i class="icon-info-sign icon-white"></i> Details</a></li>-->
								<li><a href="javascript: onMediasEdit(<?php echo $medias[$i]['id'];?>);"><i class="icon-pencil icon-white"></i> Edit</a></li>
								<li><a href="javascript: onMediasDelete(<?php echo $medias[$i]['id'];?>);"><i class="icon-trash icon-white"></i> Delete</a></li>
							  </ul>
						</div></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>    