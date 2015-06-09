<!----------------------Pod Casts---------------->
<div class="container summary-header">
	<h2>Users Summary</h2>
	<a class="btn btn-primary btn-lg" onclick="onAddUser();">Add Recorded User</a>
</div> <!-- /container -->

        <div class="container" id="client_row">
            <div id="client_row_div">
                        <div id="content_2" class="container">
                                    <table class="main table tablesorter summary-table" id="sortTableExample">
                                        <thead>
                                            <tr class="tr_height">
                                              <th class="header" style="width:4%;font-size:12px;">Id</th>
                                              <th class="header" style="font-size:12px;">username</th>
											  <th class="header" style="font-size:12px;">password</th>
                                              <th class="header" style="font-size:12px;">Name</th>
                                              <th class="header" style="font-size:12px;">Gender</th>
                                              <th class="header" style="font-size:12px;">Birthdate</th>
                                              <th class="header" style="font-size:12px;">Country</th>											  
                                              <th class="header" style="font-size:12px;">email</th>
                                              <th class="header" style="font-size:12px;">phone</th>
											  <th class="header" style="font-size:12px;">Admin</th>
											  <th class="header" style="font-size:12px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for ($i=0;$i<count($users);$i++){
                                            ?>
                                            <tr class="tr_height" id="<?php echo $users[$i]['id'];?>">
                                                <td><?php echo $users[$i]['id'];?></td>
                                                <td><span class="word-wrap username"><?php echo $users[$i]['username'];?></span></td>
                                                <td><?php echo $users[$i]['password'];?></td>
                                                <td><?php echo $users[$i]['firstname'].' '.$users[$i]['lastname'];?></td>
                                                <td><?php echo $users[$i]['gender'];?></td>
                                                <td><?php echo $users[$i]['birthday'];?></td>
                                                <td><?php echo $users[$i]['country'];?></td>
                                                <td><span class="word-wrap email"><?php echo $users[$i]['email'];?></span></td>
                                                <td><?php echo $users[$i]['phonenumber'];?></td>
												<td><?php echo $users[$i]['usergrade']?"yes":"no";?></td>
                                                <td><div class="btn-group">
							  <a class="btn btn-primary btn-small" href="#"><i class="icon-th icon-white"></i> Action</a>
							  <a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							  <ul class="dropdown-menu">
							    <!--<li><a href="javascript: onUsersDetails(<?php echo $users[$i]['id'];?>);"><i class="icon-info-sign icon-white"></i> Details</a></li>-->
							    <li><a href="javascript: onUsersEdit(<?php echo $users[$i]['id'];?>);"><i class="icon-pencil icon-white"></i> Edit</a></li>
							    <li><a href="javascript: onUsersDelete(<?php echo $users[$i]['id'];?>);"><i class="icon-trash icon-white"></i> Delete</a></li>
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