<!----------------------Pod Casts---------------->
<div class="container summary-header">
	<h2>Items Summary</h2>
</div> <!-- /container -->

        <div class="container" id="client_row">
            <div id="client_row_div">
                        <div id="content_2" class="container">
                                    <table class="main table tablesorter summary-table" id="sortTableExample">
                                        <thead>
                                            <tr class="tr_height">
                                              <th class="header" style="width:4%;font-size:12px;">Id</th>
											  <th class="header" style="font-size:12px;">barcode_id</th>
											  <th class="header" style="font-size:12px;">quantity</th>
                                              <th class="header" style="font-size:12px;">order_id</th>
											  <th class="header" style="font-size:12px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for ($i=0;$i<count($items);$i++){
                                            ?>
                                            <tr class="tr_height" id="<?php echo $items[$i]['id'];?>">
                                                <td><?php echo $items[$i]['id'];?></td>
												<td><?php echo $items[$i]['barcode_id'];?></td>
                                                <td><?php echo $items[$i]['quantity'];?></td>
                                                <td><?php echo $items[$i]['order_id'];?></td>
                                                <td><div class="btn-group">
							  <a class="btn btn-primary btn-small" href="#"><i class="icon-th icon-white"></i> Action</a>
							  <a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							  <ul class="dropdown-menu">
							    <li><a href="javascript: onItemsDetails(<?php echo $items[$i]['id'];?>);"><i class="icon-info-sign icon-white"></i> Details</a></li>
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