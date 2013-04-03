		<a id="video_autostart" style="display:none" class="iframe" href=""></a>   

							<table class="table table-hover">
								<thead>
									
										<th>#</th>
										<th>标题</th>
										<th>课程时长</th>
										<th></th>

									
								</thead>
								<tbody>
									<?php

										$conn = MakeConn();
										$sql_video="SELECT * FROM video_list ORDER BY id";
										$result_video=DataGet($sql_video);
										if(!IsDataEmpty($result_video))
										{

											$arr = array();
											while($row_video=mysql_fetch_array($result_video))
											{
												$arr[$row_video['id']] = array('name' => $row_video['name'], 'all'=>$row_video['minute'], 'minute' => 0);
											}

											$userid=$_SESSION['userid'];
											$sql_IsFinished="SELECT * FROM watch_log where user_id=$userid";
											$result_IsFinished=DataGet($sql_IsFinished);												
											while ($row=mysql_fetch_array($result_IsFinished))
											{
												$arr[$row['video_id']]['minute'] = $row['minute'];
											}

											$finish = true;
											$i=0;
											foreach ($arr as $vid => $row) {
												
												$finish = false;
												if($row['minute']>0)
												{
													$row_IsFinished=mysql_fetch_array($result_IsFinished);
													if($row['minute']!=99999)
													{
														$i++;
									?>
													<tr class="warning">
														<td><?php echo ($i); ?></td>
														<td><a href="#video<?php echo ($vid); ?>" class="videoj"><?php echo ($row['name']); ?></a></td>
														<td><?php echo ($row['all']); ?> min</td>												
														<td>已观看 <?php echo ($row['minute']); ?> min</td>
													</tr>

									<?php
													}
												}
												else
												{
													$i++;
									?>
													<tr class="error">
														<td><?php echo ($i); ?></td>
														<td><a href="#video<?php echo ($vid); ?>" class="videoj"><?php echo ($row['name']); ?></a></td>
														<td><?php echo ($row['all']); ?> min</td>										
														<td>未观看</td>
													</tr>

									<?php
												}

											}
											if($finish) {
												?>
												<div class="para">恭喜，您已完成所有课程！</div>
												<?php
											}
											
										}
										

									?>

								</tbody>
							</table>