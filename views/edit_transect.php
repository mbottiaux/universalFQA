    <script> 
      $(window).bind("pageshow", function(event) {
        if (event.originalEvent.persisted)
          // catch back-forward cache in safari
          update_quadrat_list();
        }
      );
      $(document).ready( function () { 
      	$( document ).tooltip();
      	update_quadrat_list();
      	$('#fqa_select').searchableOptionList({
      		maxHeight: '250px'
      	});
      }); 
    </script>
    <div class="container padding-top">
		<div class="nice_margins">
			<div class="row-fluid">
				<div class="span1">
					<img src="/assets/images/blue-eyed.jpg" width="70" height="105" class="img-rounded">
					<br><br>
				</div>
				<div class="span11">
					<br>
					<h1>Edit Transect/Plot Assessment</h1>
					<button class="btn btn-info" onclick="javascript:update_transect();return false;">Save Changes and View Results</button> 
					<button class="btn btn-info" onclick="javascript:window.location = '/view_assessments';return false;">Cancel</button><br>
				</div>
			</div>
			<br>
			<h3>Date & Location:</h3>
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
			<hr style="height:1pt;"/>
			<h3>Details:</h3>
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
 					<label class="small-text">Community Code:</label>
					<input class="input-medium" type="text" id="community_code" value="<?php echo $assessment->community_code; ?>" maxlength="256" /><br>
 					<label class="small-text">Community Name:</label>
					<input class="input-xlarge" type="text" id="community_name" value="<?php echo $assessment->community_name; ?>" maxlength="256" /><br>
 					<label class="small-text">Community Type Notes:</label>
					<textarea rows="3" id="community_notes"><?php echo $assessment->community_type_notes; ?></textarea><br>
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
 					<label class="small-text">Environmental Description:</label>
					<textarea rows="3" id="environment_description"><?php echo $assessment->environment_description; ?></textarea><br>
 					<label class="small-text">Other Notes:</label>
					<textarea rows="3" id="other_notes"><?php echo $assessment->other_notes; ?></textarea><br>
 				</div>
 			</div>
			<hr style="height:1pt;"/>
			<h3>Transect/Plot Design:</h3>
			<div class="row-fluid">
				<div class="span6">
					<form id="transect_type">
						<?php 
							if (empty($assessment->transect_type) OR ($assessment->transect_type === 'Transect')) { ?>
								<label class="radio"><input type="radio" name="transectType" value="Transect" checked>Transect</label>
								<label class="radio"><input type="radio" name="transectType" value="Plot">Plot</label>
						<?php } else { ?>
								<label class="radio"><input type="radio" name="transectType" value="Transect">Transect</label>
								<label class="radio"><input type="radio" name="transectType" value="Plot" checked>Plot</label>
						<?php } ?>
					</form>
					<label class="small-text">Plot Size (m<sup>2</sup>):</label>
					<input class="input-medium" type="text" id="plot_size" value="<?php echo $assessment->plot_size; ?>" maxlength="256" /><br>
					<label class="small-text">Quadrat/Subplot Size (m<sup>2</sup>):</label>
					<input class="input-medium" type="text" id="subplot_size" value="<?php echo $assessment->subplot_size; ?>" maxlength="256" /><br>
					<label class="small-text">Transect Length (m):</label>
					<input class="input-medium" type="text" id="transect_length" value="<?php echo $assessment->transect_length; ?>" maxlength="256" /><br>
					<label class="small-text">Sampling Design Description:</label>
					<textarea rows="3" id="transect_description"><?php echo $assessment->transect_description; ?></textarea><br>
					<label class="small-text">Cover Method:</label>
					<select disabled name="cover_method" id="cover_method">
					<?php
						$cover_methods = CoverMethod::get_cover_methods();
						foreach ($cover_methods as $cover_method_name => $cover_method) {
							if ($assessment->cover_method_id === $cover_method->id) {
								echo '<option value="' . $cover_method->id . '" selected>' . $cover_method_name . '</option>';
							} else {
								echo '<option value="' . $cover_method->id . '">' . $cover_method_name . '</option>';
							}
						}
					?>
					</select><br/>
	 				</div>
			</div>
			<br/>
			<hr style="height:1pt;"/>
			<div class="row-fluid">
				<div class="span12">
				<h3>FQA Database:</h3>
					<form class="form-inline">
						<select id="fqa_select" name="fqa_select" style="width:auto;">
						<?php
						if (!empty($fqa_databases)) {
							foreach ($fqa_databases as $fqa_id => $fqa_database) {
								if (!$assessment->custom_fqa && $assessment->fqa_id == $fqa_id)
									echo '<option selected value="' . $fqa_id . '">' . $fqa_database->selection_display_name . '</option>';
								else 
									echo '<option value="' . $fqa_id . '">' . $fqa_database->selection_display_name . '</option>';
							}
						}
						if (!empty($custom_fqa_databases)) {
							foreach ($custom_fqa_databases as $fqa_id => $fqa_database) {
								$name = $fqa_database->customized_name;
								$year = $fqa_database->publication_year;
								if ($assessment->custom_fqa && $assessment->fqa_id == $fqa_id)
									echo '<option selected value="custom' . $fqa_id . '">' . $fqa_database->selection_display_name . '</option>';
								else 
									echo '<option value="custom' . $fqa_id . '">' . $fqa_database->selection_display_name . '</option>';
							}
						}
						?>
						</select>
						<button class="btn btn-info" onclick="javascript:change_transect_fqa_db();return false;">Change FQA Database</button>
					</form>
					<div id="species_error" class="red"></div>
				</div>
			</div>
			<hr style="height:1pt;"/>
			<div class="row-fluid">
				<div class="span12">	
					<h3>Quadrats/Subplots:</h3>
					<button class="btn btn-info" onclick="javascript:window.location = '/new_quadrat';return false;">Add New Quadrat/Subplot</button>&nbsp;&nbsp;<span style="display:inline-block;width:700px;vertical-align:middle;">Add a standard quadrat/subplot or a pseudo quadrat/subplot for adding species to the Full Transect/Plot, Outside the Transect/Plot, or Rest of Transect/Plot.</span>
					<br><br>
					Select which quadrats/subplots you want actively included in the FQA calculations. The unselected quadrats/subplots will remain saved here if you wish to include them in the future.<br><br>
					<div id="quadrat_list">
					</div>
					<br><br>
					<form id="upload_quadrat_string_form" action="/ajax/upload_quadrat_string" method="post" enctype="multipart/form-data" target="upload_target">
						<input type="file" id="upload_file" name="upload_file"><br>
					</form>
					<button onclick="javascript:start_upload_quadrat_string();" class="btn btn-info">Upload Quadrat/Subplot String</button> (optional)
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
