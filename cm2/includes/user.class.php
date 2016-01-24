<?php
class CM_User {
	/**
	 * User data container.
	 *
	 * This will be set as properties of the object.
	 *
	 * @since 1.0
	 * @access private
	 * @var array
	 */
	var $data;
	var $ID = 0;
	var $id = 0;
	/**
	 * Name of the facuty
	 */
	var $faculty;
	
	var $courses;

	
	function CM_User( $id, $name = '' ) {

		if ( empty( $id ) && empty( $name ) )
			return;

		if ( ! is_numeric( $id ) ) {
			$name = $id;
			$id = 0;
		}

		if ( ! empty( $id ) )
			$this->data = get_userdata( $id );
		else
			$this->data = get_userdatabyusername( $name );

		if ( empty( $this->data->ID ) )
			return;

		foreach ( get_object_vars( $this->data ) as $key => $value ) {
			$this->{$key} = $value;
		}

		$this->id = $this->ID;
		$this->init();
	}

	

}
?>