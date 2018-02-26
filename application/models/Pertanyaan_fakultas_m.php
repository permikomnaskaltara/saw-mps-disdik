<?php 

class Pertanyaan_fakultas_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'pertanyaan_fakultas';
		$this->data['primary_key']	= 'id_pertanyaan';

	}

	public function get_list_pertanyaan( $id_fakultas, $cond = '' ) {

		$this->db->select( '*, pertanyaan.created_at AS time_created' );
		$this->db->from( $this->data['table_name'] );
		$this->db->join( 'pertanyaan', 'pertanyaan.id_pertanyaan = ' . $this->data['table_name'] . '.id_pertanyaan' );
		$this->db->join( 'kategori_pertanyaan', 'kategori_pertanyaan.id_kategori = ' . 'pertanyaan.id_kategori' );
		$this->db->where( [ 'id_fakultas' => $id_fakultas ] );
		if ( (is_array( $cond ) && count( $cond ) > 0) OR (is_string( $cond ) && strlen( $cond ) >= 3 ) ) {
			$this->db->where($cond);
		}
		$query = $this->db->get();
		return $query->result();

	}

	public function get_faculty_score( $id_fakultas, $id_kategori ) {

		$this->db
			->select( '*, AVG(pilihan_jawaban.skor) AS overall_score' )
			->from( $this->data['table_name'] )
			->join( 'jawaban_pengguna', $this->data['table_name'] . '.id_pertanyaan = jawaban_pengguna.id_pertanyaan' )
			->join( 'pertanyaan', $this->data['table_name'] . '.id_pertanyaan = pertanyaan.id_pertanyaan' )
			->join( 'pilihan_jawaban', 'pilihan_jawaban.id_jawaban = jawaban_pengguna.id_jawaban' )
			->where([
				'id_fakultas'	=> $id_fakultas,
				'id_kategori'	=> $id_kategori
			]);
		$query = $this->db->get();
		return $query->row();

	}

}