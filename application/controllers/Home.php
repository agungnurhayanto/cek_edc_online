<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_data');
	}

	public function index()
	{
		$all_toko            = $this->M_data->total_rows();
		$bca_online          = $this->M_data->online_bca_rows();
		$bca_offline         = $this->M_data->offline_bca_rows();
		$bca_edc_rusak       = $this->M_data->offline_bca_rusak();
		$bca_offline_total   = $bca_offline - $bca_edc_rusak;  // Menghitung total

		$data['all_toko']         = $all_toko;
		$data['bca_online']       = $bca_online;
		$data['bca_offline']      = $bca_offline;
		$data['bca_edc_rusak']    = $bca_edc_rusak;
		$data['bca_offline_total'] = $bca_offline_total;  // Menyimpan hasil perhitungan
		$data['userdata']         = $this->userdata;
		$data['page']             = "Home";
		$data['judul']            = "Beranda";
		$data['deskripsi']        = "Report Edc Online";

		$this->template->views('home', $data);
	}
}