    <script> $(document).ready( function () { update_quadrat_list(); }); </script>
    <div class="container padding-top">
		<div class="nice_margins">
			<div class="row-fluid">
				<div class="span1">
					<img src="/assets/images/blue-eyed.jpg" width="70" height="105" class="img-rounded">
					<br><br>
				</div>
				<div class="span11">
					<br>
					<h1>Edit Transect Assessment</h1>
					<button class="btn btn-info" onclick="javascript:update_transect();return false;">Save Changes and View Results</button> 
					<button class="btn btn-info" onclick="javascript:window.location = '/view_assessments';return false;">Cancel</button><br>
				</div>
			</div>
			<br>
			<div class="row-fluid">
				<div class="span6">
					<p>
					<label class="small-text">Month: </label>
					<select id="month">
<?php 	$sql_date = $assessment->date;  // 0000-00-00
		$year = substr($sql_date, 0, 4);
		$month = substr($sql_date, 5, 2);
		$day = substr($sql_date, 8, 2);
		$i = 1;
		while($i < 13) {
			if ($i == $month)
 				echo '<option selected>'.$i.'</option>';
 			else
 				echo '<option>'.$i.'</option>';
 			$i++;
 		}
?>
					</select>
					<label class="small-text">Day: </label>
					<select id="day">
<?php 	
		$i = 1;
		while($i < 32) {
			if ($i == $day)
 				echo '<option selected>'.$i.'</option>';
 			else
 				echo '<option>'.$i.'</option>';
 			$i++;
 		}
?>
					</select>
					<label class="small-text">Year: </label>
					<select id="year">
<?php 	$current_year = date("Y");
		$i = $current_year;
		while($i > 1979) {
			if ($i == $year)
 				echo '<option selected>'.$i.'</option>';
 			else
 				echo '<option>'.$i.'</option>';
 			$i--;
 		}
?>
					</select>
				</div>	
				<?php require('../views/site_selector_editing_assessments.php'); ?>		
			</div>
			<br>
			<div class="row-fluid">
				<div class="span6">
					<label class="small-text">Assessment Name: <font class="red">*</font></label>
					<input class="input-large" type="text" id="name" value="<?php echo $assessment->name; ?>" maxlength="256" /><br>
					<label class="small-text">Practitioner: <font class="red">*</font></label>
					<input class="input-large" type="text" id="practitioner" value="<?php echo $assessment->practitioner; ?>" maxlength="256" /><br>
 					<label class="small-text">Latitude:</label>
					<input class="input-medium" type="text" id="latitude" value="<?php echo $assessment->latitude; ?>" maxlength="256" /><br>
 					<label class="small-text">Longitude:</label>
					<input class="input-medium" type="text" id="longitude" value="<?php echo $assessment->longitude; ?>" maxlength="256" /><br>
					<br>
					<form id="public_inventory">
					<?php if ($assessment->private == 'private') { ?>
					<label class="radio">
  						<input type="radio" name="publicOrPrivate" value="public">
  						Public (viewable by all users of this site)
					</label>
					<label class="radio">
  						<input type="radio" name="publicOrPrivate" value="private" checked>
  						Private (viewable only by you)
					</label>
					<?php } else { ?>
					<label class="radio">
  						<input type="radio" name="publicOrPrivate" value="public" checked>
  						Public (viewable by all users of this site)
					</label>
					<label class="radio">
  						<input type="radio" name="publicOrPrivate" value="private">
  						Private (viewable only by you)
					</label>
					<?php } ?>
					</form>
 				</div>
 				<div class="span6">
 					<label class="small-text">Weather Notes:</label>
					<textarea rows="3" id="weather_notes"><?php echo $assessment->weather_notes; ?></textarea><br>
 					<label class="small-text">Duration Notes:</label>
					<textarea rows="3" id="duration_notes"><?php echo $assessment->duration_notes; ?></textarea><br>
 					<label class="small-text">Community Type Notes:</label>
					<textarea rows="3" id="community_notes"><?php echo $assessment->community_type_notes; ?></textarea><br>
 					<label class="small-text">Other Notes:</label>
					<textarea rows="3" id="other_notes"><?php echo $assessment->other_notes; ?></textarea><br>
 				</div>
 			</div>
			<br>
			<div class="row-fluid">
				<div class="span12">
					<br>
					<h3>FQA Database:</h3>
					<form class="form-inline">
						<select id="fqa_select">
						<?php
						if (mysqli_num_rows($fqa_databases) !== 0) {
							while ($fqa_database = mysqli_fetch_assoc($fqa_databases)) {
								$fqa_id = $fqa_database['id'];
								$region = $fqa_database['region_name'];
								$year = $fqa_database['publication_year'];
								if (!$assessment->custom_fqa && $assessment->fqa_id == $fqa_id)
									echo '<option selected value="' . $fqa_id . '">' . $region . ', ' . $year . '</option>';
								else 
									echo '<option value="' . $fqa_id . '">' . $region . ', ' . $year . '</option>';
							}
						}
						if (mysqli_num_rows($custom_fqa_databases) !== 0) {
							while ($fqa_database = mysqli_fetch_assoc($custom_fqa_databases)) {
								$fqa_id = $fqa_database['id'];
								$name = $fqa_database['customized_name'];
								$year = $fqa_database['publication_year'];
								if ($assessment->custom_fqa && $assessment->fqa_id == $fqa_id)
									echo '<option selected value="custom' . $fqa_id . '">' . $name . ', ' . $year . '</option>';
								else 
									echo '<option value="custom' . $fqa_id . '">' . $name . ', ' . $year . '</option>';
							}
						}
						?>
						</select>
						<button class="btn btn-info" onclick="javascript:change_transect_fqa_db();return false;">Change FQA Database</button>
					</form>
					<div id="species_error" class="red"></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">	
					<h3>Quadrats:</h3>
					<button class="btn btn-info" onclick="javascript:window.location = '/new_quadrat';return false;">Add New Quadrat</button><br><br>
					Select which quadrats you want actively included in the FQA calculations. The unselected quadrats will remain saved here if you wish to include them in the future.<br><br>
					<div id="quadrat_list">
					</div>
					<br><br>
					<form id="upload_quadrat_string_form" action="/ajax/upload_quadrat_string" method="post" enctype="multipart/form-data" target="upload_target">
						<input type="file" id="upload_file" name="upload_file"><br>
					</form>
					<button onclick="javascript:start_upload_quadrat_string();" class="btn btn-info">Upload Quadrat String</button>
					<br><br>
					<div id="upload_error"></div>
				</div>
			</div>
			<br><br>
			<div class="row-fluid">
				<div class="span12">				
					<h4>Finished making changes?</h4>
					<button class="btn btn-info" onclick="javascript:update_transect();return false;">Save Changes and View Results</button> 
					<button class="btn btn-info" onclick="javascript:window.location = '/view_assessments';return false;">Cancel</button><br>
				</div>
			</div>
		</div>
    </div> 
    <br><br>
    <iframe id="upload_target" name="upload_target" src="#"></iframe>
