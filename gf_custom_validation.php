<?php

// Para os Hooks de validação, acesse https://gravitywiz.com/gravity-forms-hook-reference/#form-submission-validation-error

add_action( 'gform_pre_submission_1', 'gf_form_pre_submission' );

/**
 * Presubmission form handler
 * 
 * @hook gform_pre_submission
 */
function gf_form_pre_submission($form) {

	// iterate over the fields to obtain specific field's id
	foreach ( $form['fields'] as $field ) {

		// check if the date picker class has been added
		if ( $field['cssClass'] == 'gf-date-picker' ) {

			// get the field id
			$id = $field['id'];

			// do whatever you want with the values here (change the date format, etc.)
			$_POST['input_' . $id] = $_POST['input_' . $id];
		}
	}
}

add_filter( "gform_field_validation_1", 'gf_custom_validation', 10, 4 );

/**
 * Custom GF validation function used for pagination and required fields
 *
 * @return string
 */
function gf_custom_validation($result, $value, $form, $field) {

	// lets validate only our custom field
	if ( $field['cssClass'] === 'gf-date-picker' ) {

		// let's obtain separate strings for each part of the date
		$value = array_map( 'intval', explode( '/', $value ) );
		
		// if the field is not valid then return the user
		if ( !checkdate( $value[0], $value[1], $value[2] ) ) {
			
			// add error message to the end user
			$result["is_valid"] = false;
			$result["message"] = "Wrong date, please check the format and make sure it's a valid one. ";
			
		} else {
			$result["is_valid"] = true;
		}
	}

	return $result;
}

// Exemplo abaixo de validação de um campo de mensagem (textarea)(ID 39) do Form (ID 6) onde invalidamos o envio de URLs.
add_filter( 'gform_field_validation_6_39', 'm3_20210601_form_without_url', 10, 4 );

function m3_20210601_form_without_url( $result, $value, $form, $field ) {
    $nourl_pattern = '(http|https)';
    if ( preg_match( $nourl_pattern, $value ) ) {
      $result['is_valid'] = false;
      $result['message']  = 'A mensagem não pode conter endereços de sites.';
    }
    return $result;
}
