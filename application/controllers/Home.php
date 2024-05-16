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
		$data['all_toko'] 	= $this->M_data->total_rows();
		$data['bca_online'] 	= $this->M_data->online_bca_rows();
		$data['bca_offline'] 	= $this->M_data->offline_bca_rows();
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Home";
		$data['judul'] 			= "Beranda";
		$data['deskripsi'] 		= "Report Edc Online";
		$this->template->views('home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */