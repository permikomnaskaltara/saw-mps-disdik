<?php 

class Siswa_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'siswa';
		$this->data['primary_key']	= 'id_siswa';

	}

}