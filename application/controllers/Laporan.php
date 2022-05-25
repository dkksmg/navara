<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_level_pemakai();
		check_level_admin();
		check_session();
		$this->load->model('home_m');
	}
	public function rekap_kondisi()
	{
		$data = [];
		$data['title'] = "Rekap Kondisi Kendaraan Dinas";
		if ($this->input->get()) {
			$dari = date('Y-m-d', strtotime($this->input->get('dari')));
			$sampai = date('Y-m-d', strtotime($this->input->get('sampai')));
			$get_dari = date('d-m-Y', strtotime($dari));
			$get_sampai = date('d-m-Y', strtotime($sampai));
			$data['dari'] = $dari;
			$data['sampai'] = $sampai;
			$data['rekap'] = $this->home_m->data_rekap($dari, $sampai);
			$data['title'] = 'Rekap Kondisi Kendaraan Dinas Dari Tanggal ' . $get_dari . ' Sampai ' . $get_sampai . '';
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/laporan/datakondisi', $data);
		$this->load->view('admin/template/footer');
	}
	public function rekap_servis()
	{
		$data = [];
		$data['title'] = "Rekap Servis Kendaraan Dinas";
		if ($this->input->get()) {
			$tahun = ($this->input->get('tahun'));
			$data['tahun'] = $tahun;
			$data['rekap'] = $this->home_m->data_servis($tahun);
			print_r($this->db->last_query());
			$data['title'] = 'Rekap Servis Kendaraan Dinas Dari Tahun ' . $tahun . '';
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/laporan/dataservis', $data);
		$this->load->view('admin/template/footer');
	}
	public function export()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
			'font' => ['bold' => true], // Set font nya jadi bold
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		];
		$sheet->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B3', "NIS"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A3')->applyFromArray($style_col);
		$sheet->getStyle('B3')->applyFromArray($style_col);
		$sheet->getStyle('C3')->applyFromArray($style_col);
		$sheet->getStyle('D3')->applyFromArray($style_col);
		$sheet->getStyle('E3')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		// $siswa = $this->SiswaModel->view();
		// $no = 1; // Untuk penomoran tabel, di awal set dengan 1
		// $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		// foreach ($siswa as $data) { // Lakukan looping pada variabel siswa
		// 	$sheet->setCellValue('A' . $numrow, $no);
		// 	$sheet->setCellValue('B' . $numrow, $data->nis);
		// 	$sheet->setCellValue('C' . $numrow, $data->nama);
		// 	$sheet->setCellValue('D' . $numrow, $data->jenis_kelamin);
		// 	$sheet->setCellValue('E' . $numrow, $data->alamat);

		// 	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		// 	$sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
		// 	$sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
		// 	$sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
		// 	$sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
		// 	$sheet->getStyle('E' . $numrow)->applyFromArray($style_row);

		// 	$no++; // Tambah 1 setiap kali looping
		// 	$numrow++; // Tambah 1 setiap kali looping
		// }
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data Siswa");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}
}