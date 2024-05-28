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

		$this->template->views('report/home', $data);
	}

	public function index2()
	{
		$data['userdata'] = $this->userdata;
		$data['page'] = "EDC BCA RUSAK";
		$data['judul'] = "Data Edc Bca Rusak";
		$data['deskripsi'] = "Report Dashboard Edc Online";
		$data['bcaRusak'] = $this->M_data->bca_rusak('edc_rusak')->result();

		$this->template->views('report/home2', $data);
	}

	public function index3()
	{
		$data['userdata'] = $this->userdata;
		$data['page'] = "EDC TRACKING TRX";
		$data['judul'] = "Data Trx Harian Edc";
		$data['deskripsi'] = "Report Dashboard Edc Online";
		$data['dataReportTrx'] = $this->M_data->bca_online();

		$this->template->views('report/home3', $data);
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

	public function tampil2()
	{
		$data['BcaRusak'] = $this->M_data->bca_rusak('edc_rusak')->result();

		$this->load->view('report/list_data2', $data);
	}

	public function tampil3()
	{
		$data['trackingTrx'] = $this->M_data->trackingTrx();

		foreach ($data['trackingTrx'] as &$row) {
			foreach ($row['status'] as &$status) {
				if ($status != 'Off') {
					$status = 'On';
				}
			}
		}

		$this->load->view('report/list_data3', $data);
	}




	// public function detail()
	// {
	// 	$data['userdata'] 	= $this->userdata;

	// 	$id 				= trim($_POST['id']);
	// 	$data['dataReport'] = $this->M_data->select_by_id($id);


	// 	echo show_my_modal('modals/modal_detail_report', 'detail-report', $data, 'lg');
	// }

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
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Am");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "As");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Status");

		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value['kdtk']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['nama_toko']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['am']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['as']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['status']);

			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Data Edc Online.xlsx');

		$this->load->helper('download');
		force_download('./assets/excel/Data Edc Online.xlsx', NULL);
	}

	public function export_tracking()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		// Panggil fungsi trackingTrx untuk mendapatkan data
		$tracking_data = $this->M_data->trackingTrx();

		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, "No");
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, "Kdtk");
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, "Nama Toko");

		// Menambahkan tanggal sebagai header kolom
		$first_day = 1;
		$current_day = date('j', strtotime('-1 day'));




		for ($day = $first_day; $day <= $current_day; $day++) {
			$columnIndex = $day + 2; // 2 kolom sebelumnya adalah untuk "No", "Kdtk", dan "Nama Toko"
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $rowCount, $day);
		}

		$rowCount++;

		// Loop melalui data yang dihasilkan oleh trackingTrx
		$no = 1;
		foreach ($tracking_data as $data) {
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $no++);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $data['kdtk']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $data['nama_toko']);

			$col = 3;

			for ($day = $first_day; $day <= $current_day; $day++) {
				// Mengisi status sesuai dengan kolom tanggal
				$status = isset($data['status'][$day]) ? $data['status'][$day] : '';
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $rowCount, $status);
			}

			$rowCount++;
		}

		// Menyimpan file Excel
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Data Edc PerDays.xlsx');

		// Mendownload file Excel yang telah dibuat
		$this->load->helper('download');
		force_download('./assets/excel/Data Edc PerDays.xlsx', NULL);
	}



	public function export_rusak()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		//$data = $this->M_data->offline_bca_rusak();
		$data = $this->M_data->bca_rusak('edc_rusak')->result();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "id");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "kdtk");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "nama toko");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Am");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "As");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Tgl Cek");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "Keterangan");

		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->kdtk);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->nama_toko);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->am);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->as);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->tgl_cek);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->ket);


			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Data Edc Rusak.xlsx');

		$this->load->helper('download');
		force_download('./assets/excel/Data Edc Rusak.xlsx', NULL);
	}

	public function import()
	{
		$this->form_validation->set_rules('excel', 'File', 'trim|required');

		if ($_FILES['excel']['name'] != '') {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['overwrite'] = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('excel')) {
				$this->session->set_flashdata('gagal', 'Upload file gagal: ' . $this->upload->display_errors());
				redirect('Report/index2');
			} else {
				$data = $this->upload->data();
				$this->db->empty_table('edc_rusak');

				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');
				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';
				$inputFileName = './assets/excel/' . $data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$index = 0;
				$resultData = array(); // Pastikan $resultData didefinisikan
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$resultData[$index]['id'] = $value['A'];
						$resultData[$index]['nik'] = $value['B'];
						$resultData[$index]['edp'] = $value['C'];
						$resultData[$index]['am'] = $value['D'];
						$resultData[$index]['as'] = $value['E'];
						$resultData[$index]['kdtk'] = $value['F'];
						$resultData[$index]['nama_toko'] = $value['G'];
						$resultData[$index]['status'] = $value['H'];
						$resultData[$index]['tgl_cek'] = $value['I'];
						$resultData[$index]['ket'] = $value['J'];
						$resultData[$index]['k_edc'] = $value['K'];
						$index++;
					}
				}

				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_data->insert_data_excel($resultData);

					if ($result > 0) {
						$this->session->set_flashdata('berhasil', 'Data Edc Rusak Berhasil diimport ke database');
					} else {
						$this->session->set_flashdata('gagal', 'Data Edc Rusak Gagal diimport ke database');
					}
				} else {
					$this->session->set_flashdata('gagal', 'Tidak ada data yang diimport');
				}
				redirect('Report/index2');
			}
		} else {
			$this->session->set_flashdata('gagal', 'File tidak boleh kosong');
			redirect('Report/index2');
		}
	}

	public function download_template()
	{
		$this->load->helper('download');
		$file_path = 'assets/templates/template_bca.xlsx';

		if (file_exists($file_path)) {
			force_download($file_path, NULL);
		} else {
			show_404();
		}
	}
}