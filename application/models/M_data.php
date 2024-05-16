<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->db = $this->load->database('default', TRUE);
	}


	public function total_rows()
	{
		$data = $this->db->get('master_toko');


		return $data->num_rows();
	}

	public function online_bca_rows()
	{
		$bulan_tahun = date('mY');
		$trxEdc = 'EDC' . $bulan_tahun;

		$second_db = $this->load->database('server_2', TRUE);
		$subquery = $second_db->query("SELECT DISTINCT toko
               FROM $trxEdc 
               WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
               AND TID != ' '
               AND kode_bank = 'B01'");

		$toko_data = $subquery->result_array();
		$kd_toko_array = array();

		foreach ($toko_data as $toko) {
			$kd_toko_array[] = $toko['toko'];
		}

		$kd_toko_string = implode("','", $kd_toko_array);

		$query = $this->db->query("SELECT * FROM master_toko");
		$master_toko_data = $query->result_array();

		$online_count = 0;

		foreach ($master_toko_data as $toko) {
			if (in_array($toko['kdtk'], $kd_toko_array)) {
				$online_count++;
			}
		}

		return $online_count;
	}

	public function offline_bca_rows()
	{
		$bulan_tahun = date('mY');
		$trxEdc = 'EDC' . $bulan_tahun;

		$second_db = $this->load->database('server_2', TRUE);
		$subquery = $second_db->query("SELECT DISTINCT toko
               FROM $trxEdc 
               WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
               AND TID != ' '
               AND kode_bank = 'B01'");

		$toko_data = $subquery->result_array();
		$kd_toko_array = array();

		foreach ($toko_data as $toko) {
			$kd_toko_array[] = $toko['toko'];
		}

		if (!empty($kd_toko_array)) {
			$kd_toko_string = implode("','", $kd_toko_array);
			$query = $this->db->query("SELECT * FROM master_toko WHERE kdtk NOT IN ('$kd_toko_string')");
			$offline_count = $query->num_rows();
		} else {
			$offline_count = 0; // Jika tidak ada toko online, maka semua toko dianggap offline
		}

		return $offline_count;
	}


	public function bca_online()
	{
		$bulan_tahun = date('mY');
		$trxEdc = 'EDC' . $bulan_tahun;

		$second_db = $this->load->database('server_2', TRUE);
		$subquery = $second_db->query("SELECT DISTINCT toko
               FROM $trxEdc 
               WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
               AND TID != ' '
               AND kode_bank = 'B01'");

		$toko_data = $subquery->result_array();
		$kd_toko_array = array();

		foreach ($toko_data as $toko) {
			$kd_toko_array[] = $toko['toko'];
		}

		$kd_toko_string = implode("','", $kd_toko_array);

		$query = $this->db->query("SELECT * FROM master_toko");
		$master_toko_data = $query->result_array();

		$result = array();

		foreach ($master_toko_data as $toko) {
			$status = 'Offline'; // Default status offline

			if (in_array($toko['kdtk'], $kd_toko_array)) {
				$status = 'Online';
			}

			$result[] = array(
				'kdtk' => $toko['kdtk'],
				'nama_toko' => $toko['nama_toko'],
				'status' => $status
			);
		}

		return $result;
	}
}

/* End of file M_pegawai.php */
/* Location: ./application/models/M_pegawai.php */