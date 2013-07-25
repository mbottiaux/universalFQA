/**
 * ---------------------------------------------------------
 *
 * login / register / change account functions
 *
 * ---------------------------------------------------------
 */
function register() {
	$.ajax({
		url: "/ajax/register_user",
		type: "POST",
		data: {
			email: $("#register_email").val(),
			first_name: $("#register_first_name").val(),
			last_name: $("#register_last_name").val(),
			password1: $("#register_password1").val(),
			password2: $("#register_password2").val()
		},
		success: function( response ) {
			if (response.indexOf("success") !== -1) 
				window.location='/view_assessments';
			else 
				alert(response);
		}
	});
}

function login() {
	$.ajax({
		url: "/ajax/login_user",
		type: "POST",
		data: {
			email: $("#login_email").val(),
			password: $("#login_password").val(),
		},
		success: function( response ) {
			if (response.indexOf("success") !== -1) {
				window.location = '/view_assessments';
			} else 
				alert(response);
		}
	});
}

function save_account_changes() {
	$.ajax({
		url: "/ajax/change_user_info",
		type: "POST",
		data: {
			email: $("#change_email").val(),
			first_name: $("#change_first_name").val(),
			last_name: $("#change_last_name").val(),
			password1: $("#change_password1").val(),
			password2: $("#change_password2").val()
		},
		success: function( response ) {
			if (response.indexOf("success") !== -1) 
				alert("Changes saved!");
			else 
				alert(response);
		}
	});
}

function forgot_password() {
	$.ajax({
		url: "/ajax/forgot_password",
		type: "POST",
		data: {
			email: $("#login_email").val(),
		},
		success: function( response ) {
			if (response.indexOf("success") !== -1) 
				alert("A new temporary password has been emailed to you. Please check your spam filter if you don't see the email.");
			else 
				alert(response);
		}
	});
}
/**
 * ---------------------------------------------------------
 *
 * upload/download FQA databases functions
 *
 * ---------------------------------------------------------
 */
 
function start_database_upload() {
	$( "#upload_error" ).html( "Uploading..." );
}
function stop_database_upload( msg ){	
	if (msg.indexOf("Error") == -1)
		window.location='/view_database/' + msg;
	else
		$( "#upload_error" ).html( msg );
}
 
function download_database() {
}

/**
 * ---------------------------------------------------------
 *
 * custom FQA databases functions
 *
 * ---------------------------------------------------------
 */
 
function delete_custom_database( id ) {
 	if (confirm("Are you sure you want to delete this custom FQA database?")) {
		$.ajax({
			url: "/ajax/delete_custom_database",
			type: "POST",
			data: {
				id: id,
			},
			success: function( response ) {
				window.location='/view_databases';
			}
		});
 	}
}

function delete_custom_taxa( id ) {
 	if (confirm("Are you sure you want to delete this taxa?")) {
		$.ajax({
			url: "/ajax/delete_custom_taxa",
			type: "POST",
			data: {
				id: id,
			},
			success: function( response ) {
				location.reload(true);
			}
		});
 	}
}
 
function done_creating_custom_db() {
	if ( $("#customized_fqa_name").val() == "" )
		alert("Please enter a name for the customized FQA database.");
	else if ( $("#customized_fqa_description").val() == "" ) 
		alert("Please enter a description for the customized FQA database.");
	else
		window.location='/view_databases';
}

function custom_fqa_update( custom_fqa_id ) {
	$.ajax({
		url: "/ajax/custom_fqa_update",
		type: "POST",
		data: {
			id: custom_fqa_id,
			name: $("#customized_fqa_name").val(),
			description: $("#customized_fqa_description").val()
		},
		success: function( response ) {
		}
	});
}

function custom_taxa_update( element_id, col_name, custom_taxa_id ) {
	$.ajax({
		url: "/ajax/custom_taxa_update",
		type: "POST",
		data: {
			id: custom_taxa_id,
			col_name: col_name,
			value: $("#" + element_id).val(),
		},
		success: function( response ) {
			if (response.indexOf("success") == -1)
				alert(response);
		}
	});
}

function new_custom_taxa( original_fqa_id, custom_fqa_id ) {
	$.ajax({
		url: "/ajax/new_custom_taxa",
		type: "POST",
		data: {
			custom_fqa_id: custom_fqa_id,
			original_fqa_id: original_fqa_id,
			scientific_name: $("#new_scientific_name").val(),
			family: $("#new_family").val(),
			acronym: $("#new_acronym").val(),
			native: $("#new_native").val(),
			c_o_c: $("#new_c").val(),
			c_o_w: $("#new_w").val(),
			physiognomy: $("#new_physiognomy").val(),
			duration: $("#new_duration").val(),
			common_name: $("#new_common_name").val(),
		},
		success: function( response ) {
			if (response.indexOf("success") == -1)
				alert(response);
			else
				location.reload(true);
		}
	});
}

function check_form( url ) {
	if ( $("#customized_fqa_name").val() == "" )
		alert("Please enter a name for the customized FQA database.");
	else if ( $("#customized_fqa_description").val() == "" ) 
		alert("Please enter a description for the customized FQA database.");
	else
		window.location = url;
}

/**
 * ---------------------------------------------------------
 *
 * site functions
 *
 * ---------------------------------------------------------
 */

function save_site_changes( site_id ) {
	if ($("#site_name").val().trim() == '') {
		alert("Please enter a site name.");
	} else {
		$.ajax({
			url: "/ajax/save_site_changes",
			type: "POST",
			data: {
				id: site_id,
				name: $("#site_name").val().trim(),
				notes: $("#site_notes").val().trim(),
				city: $("#site_city").val().trim(),
				county: $("#site_county").val().trim(),
				state: $("#site_state").val().trim(),
				country: $("#site_country").val().trim()
			},
			success: function( response ) { 
					alert("Changes saved!");
			}
		});
	}
}

function save_new_site() {
	if ($("#site_name").val().trim() == '') {
		alert("Please enter a site name.");
	} else {
		$.ajax({
			url: "/ajax/save_new_site",
			type: "POST",
			data: {
				name: $("#site_name").val().trim(),
				notes: $("#site_notes").val().trim(),
				city: $("#site_city").val().trim(),
				county: $("#site_county").val().trim(),
				state: $("#site_state").val().trim(),
				country: $("#site_country").val().trim()
			},
			success: function( response ) { 
				if (response.indexOf("Error") !== -1) 
					alert( response );
				else
					alert("New site saved!");
			}
		});
	}
}

/**
 * ---------------------------------------------------------
 *
 * new assessment functions
 *
 * ---------------------------------------------------------
 */
 
 function add_taxa_by_scientific_name() {
 	$.ajax({
		url: "/ajax/add_taxa_by_scientific_name",
		type: "POST",
		data: {
			species: $("#scientific_name").val()
		},
		success: function( response ) {
			if (response.indexOf("success") == -1) {
				alert("That scientific name is not found in this database.");
			} else {
				clear_add_fields();
				update_species_list();
			}
		}
	});
 }
 
function add_taxa_by_acronym() {
 	$.ajax({
		url: "/ajax/add_taxa_by_acronym",
		type: "POST",
		data: {
			species: $("#acronym").val()
		},
		success: function( response ) {
			if (response.indexOf("success") == -1) {
				alert("That acronym is not found in this database.");
			} else {
				clear_add_fields();
				update_species_list();
			}
		}
	});
}
 
function add_taxa_by_common_name() {
 	$.ajax({
		url: "/ajax/add_taxa_by_common_name",
		type: "POST",
		data: {
			species: $("#common_name").val()
		},
		success: function( response ) {
			if (response.indexOf("success") == -1) {
				alert("That common name is not found in this database.");
			} else {
				clear_add_fields();
				update_species_list();
			}
		}
	});
}

function add_taxa_by_list() {
 	$.ajax({
		url: "/ajax/add_taxa_by_list",
		type: "POST",
		data: {
			taxa: $("#taxa_to_add_list").val()
		},
		success: function( response ) {
				$( "#species_error" ).html( response );
				$("#taxa_to_add_list").val('');
				update_species_list();
		}
	});
}

function clear_add_fields() {
	$("#scientific_name").val('');
	$("#acronym").val('');
	$("#common_name").val('');
	$("#taxa_to_add_list").val('');
	$("#species_error").html('');
}

function update_species_list() {
	$.ajax({
		url: "/ajax/get_assessment_species_list",
		type: "POST",
		success: function( response ) {
			$( "#species_list" ).html( response );
		}
	});
	
}

function remove_taxa() {
	if (confirm("Are you sure you want to remove the selected taxa?")) {
		var taxa_to_remove = new Array();
		$("input:checkbox[name=taxa]:checked").each( function() {
			taxa_to_remove.push($(this).val());
		});
	
		$.ajax({
			url: "/ajax/remove_taxa",
			type: "POST",
			data: {
				taxa: taxa_to_remove
			},
			success: function( response ) {
				clear_add_fields();
				update_species_list();
			}
		});
	}
}

function save_new_inventory() {

	var public_inv = $('input[name=publicOrPrivate]:checked', '#public_inventory').val();
	if ($("#site_select").length) {
		// user has selected an existing site
		$.ajax({
			url: "/ajax/save_new_inventory",
			type: "POST",
			data: {
				site_id: $("#site_select").val().trim(),
				month: $("#month").val().trim(),
				day: $("#day").val().trim(),
				year: $("#year").val().trim(),
				practitioner: $("#practitioner").val().trim(),
				latitude: $("#latitude").val().trim(),
				longitude: $("#longitude").val().trim(),
				public_inventory: public_inv,
				weather_notes: $("#weather_notes").val().trim(),
				duration_notes: $("#duration_notes").val().trim(),
				community_notes: $("#community_notes").val().trim(),
				other_notes: $("#other_notes").val().trim()
			},
			success: function( response ) { 
					window.location = '/view_inventory/' + response;
			}
		});
	} else {
		// user is creating a new site
		if ($("#site_name").val().trim() == '') {
			alert("Please enter a site name.");
		} else {
			$.ajax({
				url: "/ajax/save_new_inventory",
				type: "POST",
				data: {
					site_name: $("#site_name").val().trim(),
					site_city: $("#site_city").val().trim(),
					site_county: $("#site_county").val().trim(),
					site_state: $("#site_state").val().trim(),
					site_country: $("#site_country").val().trim(),
					
					month: $("#month").val().trim(),
					day: $("#day").val().trim(),
					year: $("#year").val().trim(),
					practitioner: $("#practitioner").val().trim(),
					latitude: $("#latitude").val().trim(),
					longitude: $("#longitude").val().trim(),
					public_inventory: public_inv,
					weather_notes: $("#weather_notes").val().trim(),
					duration_notes: $("#duration_notes").val().trim(),
					community_notes: $("#community_notes").val().trim(),
					other_notes: $("#other_notes").val().trim()
				},
				success: function( response ) { 
						window.location = '/view_inventory/' + response;
				}
			});
		}
	}

}
