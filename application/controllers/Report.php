<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_data');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['page'] = "EDC ONLINE";
		$data['judul'] = "Data Edc Online";
		$data['deskripsi'] = "Report Dashboard Edc Online";
		$data['dataReport'] = $this->M_data->bca_online();

		//$data['modal_tambah_report'] = show_my_modal('modals/modal_tambah_report', 'tambah-report', $data);

		$this->template->views('report/home', $data);
	}



	public function tampil()
	{
		$data['BcaOnline'] = $this->M_data->bca_online();

		foreach ($data['BcaOnline'] as $row) {

			if ($row['status'] != 'Offline') {
				$row['status'] = 'Online';
			}
		}

		$this->load->view('report/list_data', $data);
	}




	public function detail()
	{
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataReport'] = $this->M_data->select_by_id($id);


		echo show_my_modal('modals/modal_detail_report', 'detail-report', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_data->bca_online();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "kdtk");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Nama Toko");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Status");

		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value['kdtk']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['nama_toko']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['status']);

			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Data Edc Online.xlsx');

		$this->load->helper('download');
		force_download('./assets/excel/Data Edc Online.xlsx', NULL);
	}
}