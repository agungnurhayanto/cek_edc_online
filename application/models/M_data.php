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

	// public function online_bca_rows()
	// {
	// 	$bulan_tahun = date('mY');
	// 	$trxEdc = 'EDC' . $bulan_tahun;

	// 	$second_db = $this->load->database('server_2', TRUE);
	// 	$subquery = $second_db->query("SELECT DISTINCT toko
	//      FROM $trxEdc 
	//      WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
	//      AND TID != ' '
	//      AND kode_bank = 'B01'");

	// 	$toko_data = $subquery->result_array();
	// 	$kd_toko_array = array();

	// 	foreach ($toko_data as $toko) {
	// 		$kd_toko_array[] = $toko['toko'];
	// 	}

	// 	$kd_toko_string = implode("','", $kd_toko_array);

	// 	$query = $this->db->query("SELECT * FROM master_toko");
	// 	$master_toko_data = $query->result_array();

	// 	$online_count = 0;

	// 	foreach ($master_toko_data as $toko) {
	// 		if (in_array($toko['kdtk'], $kd_toko_array)) {
	// 			$online_count++;
	// 		}
	// 	}

	// 	return $online_count;
	// }

	public function online_bca_rows()
	{
		$bulan_tahun = date('mY');
		$trxEdc = 'EDC' . $bulan_tahun;

		$second_db = $this->load->database('server_2', TRUE);
		$subquery = $second_db->query("SELECT DISTINCT toko
           FROM $trxEdc 
          --  WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
           WHERE tanggal_sales >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
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

		// Query untuk mendapatkan toko yang rusak fisik dari tabel edc_rusak
		$edc_rusak_query = $this->db->query("SELECT DISTINCT kdtk FROM edc_rusak");
		$edc_rusak_data = $edc_rusak_query->result_array();
		$edc_rusak_array = array();

		foreach ($edc_rusak_data as $rusak) {
			$edc_rusak_array[] = $rusak['kdtk'];
		}

		$online_count = 0;

		foreach ($master_toko_data as $toko) {
			if (in_array($toko['kdtk'], $kd_toko_array) && !in_array($toko['kdtk'], $edc_rusak_array)) {
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
          --      WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
               WHERE tanggal_sales >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
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
			$offline_count = 0;
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
          --  WHERE tanggal_sales IN (CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 3 DAY))
          WHERE tanggal_sales >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
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

		// Query untuk mendapatkan toko yang rusak fisik dari tabel edc_rusak
		$edc_rusak_query = $this->db->query("SELECT DISTINCT kdtk FROM edc_rusak");
		$edc_rusak_data = $edc_rusak_query->result_array();
		$edc_rusak_array = array();

		foreach ($edc_rusak_data as $rusak) {
			$edc_rusak_array[] = $rusak['kdtk'];
		}

		$result = array();

		foreach ($master_toko_data as $toko) {
			$status = 'Offline'; // Default status offline

			if (in_array($toko['kdtk'], $edc_rusak_array)) {
				$status = 'Rusak Fisik Edc';
			} elseif (in_array($toko['kdtk'], $kd_toko_array)) {
				$status = 'Online';
			}

			$result[] = array(
				'kdtk' => $toko['kdtk'],
				'nama_toko' => $toko['nama_toko'],
				'am' => $toko['am'],
				'as' => $toko['as'],
				'status' => $status
			);
		}

		// sortir keterangan 
		usort($result, function ($a, $b) {
			if ($a['status'] == $b['status']) {
				return 0;
			}
			return ($a['status'] == 'Rusak Fisik Edc') ? -1 : 1;
		});

		return $result;
	}


	public function trackingTrx()
	{
		$bulan_tahun = date('mY');
		$trxEdc = 'EDC' . $bulan_tahun;

		$second_db = $this->load->database('server_2', TRUE);

		// Inisialisasi array untuk menyimpan hasil per tanggal
		$result = [];

		// Loop melalui semua hari dalam sebulan
		$total_days = date('t');
		$current_date = date('Y-m-'); // Prefix untuk tahun dan bulan saat ini

		// Ambil data master toko
		$query = $this->db->query("SELECT * FROM master_toko");
		$master_toko_data = $query->result_array();

		// Inisialisasi array toko
		foreach ($master_toko_data as $toko) {
			$result[$toko['kdtk']] = [
				'kdtk' => $toko['kdtk'],
				'nama_toko' => $toko['nama_toko'],
				'status' => array_fill(1, $total_days, 'Off')
			];
		}

		for ($day = 1; $day <= $total_days; $day++) {
			$date = $current_date . str_pad($day, 2, '0', STR_PAD_LEFT);
			$subquery = $second_db->query("
        			SELECT DISTINCT toko
                              FROM $trxEdc 
                              WHERE tanggal_sales = '$date'
                              AND TID != ' '
                              AND kode_bank = 'B01'
                              ");

			$toko_data = $subquery->result_array();
			$kd_toko_array = array_column($toko_data, 'toko');

			foreach ($master_toko_data as $toko) {
				$kdtk = $toko['kdtk'];

				// Tentukan status untuk hari ini
				if (in_array($kdtk, $kd_toko_array)) {
					$result[$kdtk]['status'][$day] = 'On'; // Jika ada transaksi, status = 'On'
				} else {
					$result[$kdtk]['status'][$day] = 'Off'; // Jika tidak ada transaksi, status = 'Off'
				}
			}
		}

		return $result;
	}


	public function bca_rusak($table)
	{
		return $this->db->get($table);
	}

	public function offline_bca_rusak()
	{
		$data =  $this->db->get('edc_rusak');

		return $data->num_rows();
	}

	public function insert_data_excel($data)
	{
		$this->db->insert_batch('edc_rusak', $data);

		return $this->db->affected_rows();
	}
}