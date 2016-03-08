<?php

class WP_Test_WC_Connect_Services_Validator extends WC_Unit_Test_Case {

	private static function get_golden_services() {

		return (object) array(
			'shipping' => array(
				(object) array(
					'id' => 'usps',
					'method_description' => 'Obtains rates dynamically from the USPS API during cart/checkout.',
					'method_title' => 'USPS (WooCommerce Connect)',
					'service_settings' => (object) array(
						'type' => 'object',
						'required' => array(),
						'properties' => (object) array(
							'enabled' => (object) array(
								'type' => 'boolean',
								'title' => 'Enable/Disable',
								'description' => 'Enable this shipping method',
								'default' => false
							),
							'title' => (object) array(
								'type' => 'string',
								'title' => 'Method Title',
								'description' => 'This controls the title which the user sees during checkout.',
								'default' => 'USPS'
							)
						)
					)
				)
			)
		);

	}

	public function setUp() {

		parent::setUp();

		$loader = new WC_Connect_Loader();
		$loader->load_dependencies();

	}

	public function tearDown() {
	}

	public function test_class_exists() {

		$this->assertTrue( class_exists( 'WC_Connect_Services_Validator' ) );

	}

	public function test_requires_services_to_be_an_object() {

		$validator = new WC_Connect_Services_Validator();
		$validation_result = $validator->validate_services( array() );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'outermost_container_not_object' === $validation_result->get_error_code() );
	}

	public function test_requires_service_type_to_reference_an_array() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping = new stdClass();
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_type_not_ref_array' === $validation_result->get_error_code() );

	}

	public function test_requires_service_to_reference_an_object() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0] = array();
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_not_ref_object' === $validation_result->get_error_code() );

	}

	public function test_requires_service_to_have_an_id() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->id );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_missing' === $validation_result->get_error_code() );

	}

	public function test_requires_service_id_to_be_string() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->id = 99;
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_to_have_a_method_description() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->method_description );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_missing' === $validation_result->get_error_code() );

	}

	public function test_requires_service_method_description_to_be_string() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->method_description = 99;
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_to_have_a_method_title() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->method_title );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_missing' === $validation_result->get_error_code() );

	}

	public function test_requires_service_title_to_be_string() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->method_title = 99;
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_to_have_service_settings() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'required_service_property_missing' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_to_include_type() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings->type );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_missing_required_property' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_type_to_be_string() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->service_settings->type = 99;
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_to_include_required() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings->required );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_missing_required_property' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_required_to_be_array() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->service_settings->required = 99;
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_to_include_properties() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings->properties );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_missing_required_property' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_properties_to_be_object() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		$services->shipping[0]->service_settings->properties = array();
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_settings_property_wrong_type' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_to_include_enabled_property() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings->properties->enabled );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_properties_missing_required_property' === $validation_result->get_error_code() );

	}

	public function test_requires_service_settings_to_include_title_property() {

		$validator = new WC_Connect_Services_Validator();
		$services = self::get_golden_services();
		unset( $services->shipping[0]->service_settings->properties->title );
		$validation_result = $validator->validate_services( $services );
		$this->assertIsWPError( $validation_result );
		$this->assertNotFalse( 'service_properties_missing_required_property' === $validation_result->get_error_code() );

	}

}
