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
			$data['januari'] = $this->home_m->servis_bbm_jan($tahun);
			$data['februari'] = $this->home_m->servis_bbm_feb($tahun);
			$data['maret'] = $this->home_m->servis_bbm_mar($tahun);
			$data['april'] = $this->home_m->servis_bbm_apr($tahun);
			$data['mei'] = $this->home_m->servis_bbm_mei($tahun);
			$data['juni'] = $this->home_m->servis_bbm_jun($tahun);
			$data['juli'] = $this->home_m->servis_bbm_jul($tahun);
			$data['agustus'] = $this->home_m->servis_bbm_ags($tahun);
			$data['september'] = $this->home_m->servis_bbm_sept($tahun);
			$data['oktober'] = $this->home_m->servis_bbm_okt($tahun);
			$data['november'] = $this->home_m->servis_bbm_nov($tahun);
			$data['desember'] = $this->home_m->servis_bbm_des($tahun);
			$data['title'] = 'Rekap Servis Kendaraan Dinas Dari Tahun ' . $tahun . '';
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/laporan/dataservis', $data);
		$this->load->view('admin/template/footer');
	}
	public function export_pdf()
	{
		$tahun = $this->input->get('tahun');
	}
	public function export_excel()
	{
		$tahun = $this->input->get('tahun');
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
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
			],
			'numberFormat' => [
				'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR
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
		$sheet->setCellValue('H1', "RINCIAN SERVICE BENGKEL TAHUN " . $tahun);
		$sheet->mergeCells('H1:BP1');
		$sheet->setCellValue('A1', "KENDARAAN");
		$sheet->mergeCells('A1:G1');
		$sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('H1')->getFont()->setSize(14)->setBold(true); // Set bold kolom A1
		$sheet->getStyle('H1')->getAlignment()->setHorizontal('center');
		$sheet->freezePane('H5');
		// Buat header tabel nya pada baris ke 3
		$sheet->mergeCells('A3:A4')->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->mergeCells('B3:B4')->setCellValue('B3', "JENIS KENDARAAN"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->mergeCells('C3:C4')->setCellValue('C3', "MERK"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->mergeCells('D3:D4')->setCellValue('D3', "TIPE");
		$sheet->mergeCells('E3:E4')->setCellValue('E3', "NO POLISI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->mergeCells('F3:F4')->setCellValue('F3', "PEMAKAI"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->mergeCells('G3:G4')->setCellValue('G3', "PAGU");
		$sheet->mergeCells('H3:L3')->setCellValue('H3', "JANUARI");
		$sheet->mergeCells('M3:Q3')->setCellValue('M3', "FEBRUARI");
		$sheet->mergeCells('R3:V3')->setCellValue('R3', "MARET");
		$sheet->mergeCells('W3:AA3')->setCellValue('W3', "APRIL");
		$sheet->mergeCells('AB3:AF3')->setCellValue('AB3', "MEI");
		$sheet->mergeCells('AG3:AK3')->setCellValue('AG3', "JUNI");
		$sheet->mergeCells('AL3:AP3')->setCellValue('AL3', "JULI");
		$sheet->mergeCells('AQ3:AU3')->setCellValue('AQ3', "AGUSTUS");
		$sheet->mergeCells('AV3:AZ3')->setCellValue('AV3', "SEPTEMBER");
		$sheet->mergeCells('BA3:BE3')->setCellValue('BA3', "OKTOBER");
		$sheet->mergeCells('BF3:BJ3')->setCellValue('BF3', "NOVEMBER");
		$sheet->mergeCells('BK3:BO3')->setCellValue('BK3', "DESEMBER");
		$sheet->mergeCells('BP3:BP4')->setCellValue('BP3', "TOTAL");
		$sheet->mergeCells('BQ3:BQ4')->setCellValue('BQ3', "SISA");
		$sheet->setCellValue('H4', "SPAREPART");
		$sheet->setCellValue('I4', "OLI");
		$sheet->setCellValue('J4', "SERVICE");
		$sheet->setCellValue('K4', "BBM");
		$sheet->setCellValue('L4', "PAJAK");

		$sheet->setCellValue('M4', "SPAREPART");
		$sheet->setCellValue('N4', "OLI");
		$sheet->setCellValue('O4', "SERVICE");
		$sheet->setCellValue('P4', "BBM");
		$sheet->setCellValue('Q4', "PAJAK");

		$sheet->setCellValue('R4', "SPAREPART");
		$sheet->setCellValue('S4', "OLI");
		$sheet->setCellValue('T4', "SERVICE");
		$sheet->setCellValue('U4', "BBM");
		$sheet->setCellValue('V4', "PAJAK");

		$sheet->setCellValue('W4', "SPAREPART");
		$sheet->setCellValue('X4', "OLI");
		$sheet->setCellValue('Y4', "SERVICE");
		$sheet->setCellValue('Z4', "BBM");
		$sheet->setCellValue('AA4', "PAJAK");

		$sheet->setCellValue('AB4', "SPAREPART");
		$sheet->setCellValue('AC4', "OLI");
		$sheet->setCellValue('AD4', "SERVICE");
		$sheet->setCellValue('AE4', "BBM");
		$sheet->setCellValue('AF4', "PAJAK");

		$sheet->setCellValue('AG4', "SPAREPART");
		$sheet->setCellValue('AH4', "OLI");
		$sheet->setCellValue('AI4', "SERVICE");
		$sheet->setCellValue('AJ4', "BBM");
		$sheet->setCellValue('AK4', "PAJAK");

		$sheet->setCellValue('AL4', "SPAREPART");
		$sheet->setCellValue('AM4', "OLI");
		$sheet->setCellValue('AN4', "SERVICE");
		$sheet->setCellValue('AO4', "BBM");
		$sheet->setCellValue('AP4', "PAJAK");

		$sheet->setCellValue('AQ4', "SPAREPART");
		$sheet->setCellValue('AR4', "OLI");
		$sheet->setCellValue('AS4', "SERVICE");
		$sheet->setCellValue('AT4', "BBM");
		$sheet->setCellValue('AU4', "PAJAK");

		$sheet->setCellValue('AV4', "SPAREPART");
		$sheet->setCellValue('AW4', "OLI");
		$sheet->setCellValue('AX4', "SERVICE");
		$sheet->setCellValue('AY4', "BBM");
		$sheet->setCellValue('AZ4', "PAJAK");

		$sheet->setCellValue('BA4', "SPAREPART");
		$sheet->setCellValue('BB4', "OLI");
		$sheet->setCellValue('BC4', "SERVICE");
		$sheet->setCellValue('BD4', "BBM");
		$sheet->setCellValue('BE4', "PAJAK");

		$sheet->setCellValue('BF4', "SPAREPART");
		$sheet->setCellValue('BG4', "OLI");
		$sheet->setCellValue('BH4', "SERVICE");
		$sheet->setCellValue('BI4', "BBM");
		$sheet->setCellValue('BJ4', "PAJAK");

		$sheet->setCellValue('BK4', "SPAREPART");
		$sheet->setCellValue('BL4', "OLI");
		$sheet->setCellValue('BM4', "SERVICE");
		$sheet->setCellValue('BN4', "BBM");
		$sheet->setCellValue('BO4', "PAJAK");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A3')->applyFromArray($style_col);
		$sheet->getStyle('B3')->applyFromArray($style_col);
		$sheet->getStyle('C3')->applyFromArray($style_col);
		$sheet->getStyle('D3')->applyFromArray($style_col);
		$sheet->getStyle('E3')->applyFromArray($style_col);
		$sheet->getStyle('F3')->applyFromArray($style_col);
		$sheet->getStyle('G3')->applyFromArray($style_col);
		$sheet->getStyle('H3')->applyFromArray($style_col);
		$sheet->getStyle('I3')->applyFromArray($style_col);
		$sheet->getStyle('J3')->applyFromArray($style_col);
		$sheet->getStyle('K3')->applyFromArray($style_col);
		$sheet->getStyle('L3')->applyFromArray($style_col);
		$sheet->getStyle('M3')->applyFromArray($style_col);
		$sheet->getStyle('N3')->applyFromArray($style_col);
		$sheet->getStyle('O3')->applyFromArray($style_col);
		$sheet->getStyle('P3')->applyFromArray($style_col);
		$sheet->getStyle('Q3')->applyFromArray($style_col);
		$sheet->getStyle('R3')->applyFromArray($style_col);
		$sheet->getStyle('S3')->applyFromArray($style_col);
		$sheet->getStyle('T3')->applyFromArray($style_col);
		$sheet->getStyle('U3')->applyFromArray($style_col);
		$sheet->getStyle('V3')->applyFromArray($style_col);
		$sheet->getStyle('W3')->applyFromArray($style_col);
		$sheet->getStyle('X3')->applyFromArray($style_col);
		$sheet->getStyle('Y3')->applyFromArray($style_col);
		$sheet->getStyle('Z3')->applyFromArray($style_col);
		$sheet->getStyle('AA3')->applyFromArray($style_col);
		$sheet->getStyle('AB3')->applyFromArray($style_col);
		$sheet->getStyle('AC3')->applyFromArray($style_col);
		$sheet->getStyle('AD3')->applyFromArray($style_col);
		$sheet->getStyle('AE3')->applyFromArray($style_col);
		$sheet->getStyle('AF3')->applyFromArray($style_col);
		$sheet->getStyle('AG3')->applyFromArray($style_col);
		$sheet->getStyle('AH3')->applyFromArray($style_col);
		$sheet->getStyle('AI3')->applyFromArray($style_col);
		$sheet->getStyle('AJ3')->applyFromArray($style_col);
		$sheet->getStyle('AK3')->applyFromArray($style_col);
		$sheet->getStyle('AL3')->applyFromArray($style_col);
		$sheet->getStyle('AM3')->applyFromArray($style_col);
		$sheet->getStyle('AN3')->applyFromArray($style_col);
		$sheet->getStyle('AO3')->applyFromArray($style_col);
		$sheet->getStyle('AP3')->applyFromArray($style_col);
		$sheet->getStyle('AQ3')->applyFromArray($style_col);
		$sheet->getStyle('AR3')->applyFromArray($style_col);
		$sheet->getStyle('AS3')->applyFromArray($style_col);
		$sheet->getStyle('AT3')->applyFromArray($style_col);
		$sheet->getStyle('AU3')->applyFromArray($style_col);
		$sheet->getStyle('AV3')->applyFromArray($style_col);
		$sheet->getStyle('AW3')->applyFromArray($style_col);
		$sheet->getStyle('AX3')->applyFromArray($style_col);
		$sheet->getStyle('AY3')->applyFromArray($style_col);
		$sheet->getStyle('AZ3')->applyFromArray($style_col);
		$sheet->getStyle('BA3')->applyFromArray($style_col);
		$sheet->getStyle('BB3')->applyFromArray($style_col);
		$sheet->getStyle('BC3')->applyFromArray($style_col);
		$sheet->getStyle('BD3')->applyFromArray($style_col);
		$sheet->getStyle('BE3')->applyFromArray($style_col);
		$sheet->getStyle('BF3')->applyFromArray($style_col);
		$sheet->getStyle('BG3')->applyFromArray($style_col);
		$sheet->getStyle('BH3')->applyFromArray($style_col);
		$sheet->getStyle('BI3')->applyFromArray($style_col);
		$sheet->getStyle('BJ3')->applyFromArray($style_col);
		$sheet->getStyle('BK3')->applyFromArray($style_col);
		$sheet->getStyle('BL3')->applyFromArray($style_col);
		$sheet->getStyle('BM3')->applyFromArray($style_col);
		$sheet->getStyle('BN3')->applyFromArray($style_col);
		$sheet->getStyle('BO3')->applyFromArray($style_col);
		$sheet->getStyle('BP3')->applyFromArray($style_col);
		$sheet->getStyle('BQ3')->applyFromArray($style_col);


		$sheet->getStyle('A4')->applyFromArray($style_col);
		$sheet->getStyle('B4')->applyFromArray($style_col);
		$sheet->getStyle('C4')->applyFromArray($style_col);
		$sheet->getStyle('D4')->applyFromArray($style_col);
		$sheet->getStyle('E4')->applyFromArray($style_col);
		$sheet->getStyle('F4')->applyFromArray($style_col);
		$sheet->getStyle('G4')->applyFromArray($style_col);
		$sheet->getStyle('H4')->applyFromArray($style_col);
		$sheet->getStyle('I4')->applyFromArray($style_col);
		$sheet->getStyle('J4')->applyFromArray($style_col);
		$sheet->getStyle('K4')->applyFromArray($style_col);
		$sheet->getStyle('L4')->applyFromArray($style_col);
		$sheet->getStyle('M4')->applyFromArray($style_col);
		$sheet->getStyle('N4')->applyFromArray($style_col);
		$sheet->getStyle('O4')->applyFromArray($style_col);
		$sheet->getStyle('P4')->applyFromArray($style_col);
		$sheet->getStyle('Q4')->applyFromArray($style_col);
		$sheet->getStyle('R4')->applyFromArray($style_col);
		$sheet->getStyle('S4')->applyFromArray($style_col);
		$sheet->getStyle('T4')->applyFromArray($style_col);
		$sheet->getStyle('U4')->applyFromArray($style_col);
		$sheet->getStyle('V4')->applyFromArray($style_col);
		$sheet->getStyle('W4')->applyFromArray($style_col);
		$sheet->getStyle('X4')->applyFromArray($style_col);
		$sheet->getStyle('Y4')->applyFromArray($style_col);
		$sheet->getStyle('Z4')->applyFromArray($style_col);
		$sheet->getStyle('AA4')->applyFromArray($style_col);
		$sheet->getStyle('AB4')->applyFromArray($style_col);
		$sheet->getStyle('AC4')->applyFromArray($style_col);
		$sheet->getStyle('AD4')->applyFromArray($style_col);
		$sheet->getStyle('AE4')->applyFromArray($style_col);
		$sheet->getStyle('AF4')->applyFromArray($style_col);
		$sheet->getStyle('AG4')->applyFromArray($style_col);
		$sheet->getStyle('AH4')->applyFromArray($style_col);
		$sheet->getStyle('AI4')->applyFromArray($style_col);
		$sheet->getStyle('AJ4')->applyFromArray($style_col);
		$sheet->getStyle('AK4')->applyFromArray($style_col);
		$sheet->getStyle('AL4')->applyFromArray($style_col);
		$sheet->getStyle('AM4')->applyFromArray($style_col);
		$sheet->getStyle('AN4')->applyFromArray($style_col);
		$sheet->getStyle('AO4')->applyFromArray($style_col);
		$sheet->getStyle('AP4')->applyFromArray($style_col);
		$sheet->getStyle('AQ4')->applyFromArray($style_col);
		$sheet->getStyle('AR4')->applyFromArray($style_col);
		$sheet->getStyle('AS4')->applyFromArray($style_col);
		$sheet->getStyle('AT4')->applyFromArray($style_col);
		$sheet->getStyle('AU4')->applyFromArray($style_col);
		$sheet->getStyle('AV4')->applyFromArray($style_col);
		$sheet->getStyle('AW4')->applyFromArray($style_col);
		$sheet->getStyle('AX4')->applyFromArray($style_col);
		$sheet->getStyle('AY4')->applyFromArray($style_col);
		$sheet->getStyle('AZ4')->applyFromArray($style_col);
		$sheet->getStyle('BA4')->applyFromArray($style_col);
		$sheet->getStyle('BB4')->applyFromArray($style_col);
		$sheet->getStyle('BC4')->applyFromArray($style_col);
		$sheet->getStyle('BD4')->applyFromArray($style_col);
		$sheet->getStyle('BE4')->applyFromArray($style_col);
		$sheet->getStyle('BF4')->applyFromArray($style_col);
		$sheet->getStyle('BG4')->applyFromArray($style_col);
		$sheet->getStyle('BH4')->applyFromArray($style_col);
		$sheet->getStyle('BI4')->applyFromArray($style_col);
		$sheet->getStyle('BJ4')->applyFromArray($style_col);
		$sheet->getStyle('BK4')->applyFromArray($style_col);
		$sheet->getStyle('BL4')->applyFromArray($style_col);
		$sheet->getStyle('BM4')->applyFromArray($style_col);
		$sheet->getStyle('BN4')->applyFromArray($style_col);
		$sheet->getStyle('BO4')->applyFromArray($style_col);
		$sheet->getStyle('BP4')->applyFromArray($style_col);
		$sheet->getStyle('BQ4')->applyFromArray($style_col);

		$sheet->getStyle('A3:A1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('B3:B1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('C3:C1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('D3:D1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('E3:E1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('F3:F4')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('F5:F1000')->getAlignment()->setHorizontal('left');
		$sheet->getStyle('G3:G1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('H3:H1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('I3:I1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('J3:J1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('K3:K1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('L3:L1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('M3:M1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('N3:N1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('O3:O1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('P3:P1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('Q3:Q1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('R3:R1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('S3:S1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('T3:T1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('U3:U1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('V3:V1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('W3:W1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('X3:X1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('Y3:Y1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('Z3:Z1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AA3:AA1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AB3:AB1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AC3:AC1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AD3:AD1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AE3:AE1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AF3:AF1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AG3:AG1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AH3:AH1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AI3:AI1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AJ3:AJ1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AK3:AK1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AL3:AL1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AM3:AM1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AN3:AN1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AO3:AO1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AP3:AP1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AQ3:AQ1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AR3:AR1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AS3:AS1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AT3:AT1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AU3:AU1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AV3:AV1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AW3:AW1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AX3:AX1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AY3:AY1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('AZ3:AZ1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BA3:BA1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BB3:BB1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BC3:BC1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BD3:BD1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BE3:BE1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BF3:BF1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BG3:BG1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BH3:BH1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BI3:BI1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BJ3:BJ1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BK3:BK1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BL3:BL1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BM3:BM1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BN3:BN1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BO3:BO1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BP3:BP1000')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('BQ3:BQ1000')->getAlignment()->setHorizontal('center');

		$sheet->getStyle('G3:G1000')
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('H3:H1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('I3:I1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('J3:J1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('K3:K1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('L3:L1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('M3:M1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('N3:N1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('O3:O1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('P3:P1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('Q3:Q1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('R3:R1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('S3:S1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('T3:T1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('U3:U1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('V3:V1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('W3:W1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('X3:X1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('Y3:Y1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('Z3:Z1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AA3:AA1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AB3:AB1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AC3:AC1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AD3:AD1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AE3:AE1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AF3:AF1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AG3:AG1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AH3:AH1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AI3:AI1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AJ3:AJ1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AK3:AK1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AL3:AL1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AM3:AM1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AN3:AN1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AO3:AO1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AP3:AP1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AQ3:AQ1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AR3:AR1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AS3:AS1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AT3:AT1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AU3:AU1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AV3:AV1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AW3:AW1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AX3:AX1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AY3:AY1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('AZ3:AZ1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BA3:BA1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BB3:BB1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BC3:BC1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BD3:BD1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BE3:BE1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BF3:BF1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BG3:BG1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BH3:BH1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BI3:BI1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BJ3:BJ1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BK3:BK1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BL3:BL1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BM3:BM1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BN3:BN1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BO3:BO1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BP3:BP1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
		$sheet->getStyle('BQ3:BQ1000')->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);

		$data_rincian = $this->home_m->data_servis($tahun);
		$januari = $this->home_m->laporan_jan($tahun);
		$februari = $this->home_m->laporan_feb($tahun);
		$maret = $this->home_m->laporan_mar($tahun);
		$april = $this->home_m->laporan_apr($tahun);
		$mei = $this->home_m->laporan_mei($tahun);
		$juni = $this->home_m->laporan_jun($tahun);
		$juli = $this->home_m->laporan_jul($tahun);
		$agustus = $this->home_m->laporan_ags($tahun);
		$september = $this->home_m->laporan_sept($tahun);
		$oktober = $this->home_m->laporan_okt($tahun);
		$november = $this->home_m->laporan_nov($tahun);
		$desember = $this->home_m->laporan_des($tahun);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		$result = array();
		foreach ($data_rincian as $key => $val) {
			$val2 = $januari[$key];
			$val3 = $februari[$key];
			$val4 = $maret[$key];
			$val5 = $april[$key];
			$val6 = $mei[$key];
			$val7 = $juni[$key];
			$val8 = $juli[$key];
			$val9 = $agustus[$key];
			$val10 = $september[$key];
			$val11 = $oktober[$key];
			$val12 = $november[$key];
			$val13 = $desember[$key];
			$result[$key] = $val + $val2 + $val3 + $val4 + $val5 + $val6 + $val7 + $val8 + $val9 + $val10 + $val11 + $val12 + $val13;

			$totalsparepart = $result[$key]['total_sp_jan'] + $result[$key]['total_sp_feb'] + $result[$key]['total_sp_mar'] + $result[$key]['total_sp_apr'] + $result[$key]['total_sp_mei'] + $result[$key]['total_sp_jun'] + $result[$key]['total_sp_jul'] + $result[$key]['total_sp_ags'] + $result[$key]['total_sp_sept'] + $result[$key]['total_sp_okt'] + $result[$key]['total_sp_nov'] + $result[$key]['total_sp_des'];
			$totaloli = $result[$key]['total_ol_jan'] + $result[$key]['total_ol_feb'] + $result[$key]['total_ol_mar'] + $result[$key]['total_ol_apr'] + $result[$key]['total_ol_mei'] + $result[$key]['total_ol_jun'] + $result[$key]['total_ol_jul'] + $result[$key]['total_ol_ags'] + $result[$key]['total_ol_sept'] + $result[$key]['total_ol_okt'] + $result[$key]['total_ol_nov'] + $result[$key]['total_ol_des'];
			$totalservis = $result[$key]['total_sv_jan'] + $result[$key]['total_sv_feb'] + $result[$key]['total_sv_mar'] + $result[$key]['total_sv_apr'] + $result[$key]['total_sv_mei'] + $result[$key]['total_sv_jun'] + $result[$key]['total_sv_jul'] + $result[$key]['total_sv_ags'] + $result[$key]['total_sv_sept'] + $result[$key]['total_sv_okt'] + $result[$key]['total_sv_nov'] + $result[$key]['total_sv_des'];
			$totalbbm = $result[$key]['total_bm_jan'] + $result[$key]['total_bm_feb'] + $result[$key]['total_bm_mar'] + $result[$key]['total_bm_apr'] + $result[$key]['total_bm_mei'] + $result[$key]['total_bm_jun'] + $result[$key]['total_bm_jul'] + $result[$key]['total_bm_ags'] + $result[$key]['total_bm_sept'] + $result[$key]['total_bm_okt'] + $result[$key]['total_bm_nov'] + $result[$key]['total_bm_des'];
			$totalpajak = $result[$key]['total_pj_jan'] + $result[$key]['total_pj_feb'] + $result[$key]['total_pj_mar'] + $result[$key]['total_pj_apr'] + $result[$key]['total_pj_mei'] + $result[$key]['total_pj_jun'] + $result[$key]['total_pj_jul'] + $result[$key]['total_pj_ags'] + $result[$key]['total_pj_sept'] + $result[$key]['total_pj_okt'] + $result[$key]['total_pj_nov'] + $result[$key]['total_pj_des'];


			$totalpengeluaran = $totalsparepart + $totaloli + $totalservis + $totalbbm + $totalpajak;
			$pagusisa = $result[$key]['pagu_awal'] - $totalpengeluaran;

			$sheet->setCellValue('A' . $numrow, $no);
			$sheet->setCellValue('B' . $numrow, strtoupper($result[$key]['jenis']));
			$sheet->setCellValue('C' . $numrow, strtoupper($result[$key]['merk']));
			$sheet->setCellValue('D' . $numrow, strtoupper($result[$key]['tipe']));
			$sheet->setCellValue('E' . $numrow, strtoupper($result[$key]['no_polisi']));
			$sheet->setCellValue('F' . $numrow, ($result[$key]['name']));
			if ($result[$key]['pagu_awal'] == '') {
				$sheet->setCellValue('G' . $numrow, '0');
			} else {
				$sheet->setCellValue('G' . $numrow, ($result[$key]['pagu_awal']));
			}
			//januari
			if ($result[$key]['total_sp_jan'] == '') {
				$sheet->setCellValue('H' . $numrow, '0');
			} else {
				$sheet->setCellValue('H' . $numrow, ($result[$key]['total_sp_jan']));
			}
			if ($result[$key]['total_ol_jan'] == '') {
				$sheet->setCellValue('I' . $numrow, '0');
			} else {
				$sheet->setCellValue('I' . $numrow, ($result[$key]['total_ol_jan']));
			}
			if ($result[$key]['total_sv_jan'] == '') {
				$sheet->setCellValue('J' . $numrow, '0');
			} else {
				$sheet->setCellValue('J' . $numrow, ($result[$key]['total_sv_jan']));
			}
			if ($result[$key]['total_bm_jan'] == '') {
				$sheet->setCellValue('K' . $numrow, '0');
			} else {
				$sheet->setCellValue('K' . $numrow, ($result[$key]['total_bm_jan']));
			}
			if ($result[$key]['total_pj_jan'] == '') {
				$sheet->setCellValue('L' . $numrow, '0');
			} else {
				$sheet->setCellValue('L' . $numrow, ($result[$key]['total_pj_jan']));
			}
			//februari
			if ($result[$key]['total_sp_feb'] == '') {
				$sheet->setCellValue('M' . $numrow, '0');
			} else {
				$sheet->setCellValue('M' . $numrow, ($result[$key]['total_sp_feb']));
			}
			if ($result[$key]['total_ol_feb'] == '') {
				$sheet->setCellValue('N' . $numrow, '0');
			} else {
				$sheet->setCellValue('N' . $numrow, ($result[$key]['total_ol_feb']));
			}
			if ($result[$key]['total_sv_feb'] == '') {
				$sheet->setCellValue('O' . $numrow, '0');
			} else {
				$sheet->setCellValue('O' . $numrow, ($result[$key]['total_sv_feb']));
			}
			if ($result[$key]['total_bm_feb'] == '') {
				$sheet->setCellValue('P' . $numrow, '0');
			} else {
				$sheet->setCellValue('P' . $numrow, ($result[$key]['total_bm_feb']));
			}
			if ($result[$key]['total_pj_feb'] == '') {
				$sheet->setCellValue('Q' . $numrow, '0');
			} else {
				$sheet->setCellValue('Q' . $numrow, ($result[$key]['total_pj_feb']));
			}
			//maret
			if ($result[$key]['total_sp_mar'] == '') {
				$sheet->setCellValue('R' . $numrow, '0');
			} else {
				$sheet->setCellValue('R' . $numrow, ($result[$key]['total_sp_mar']));
			}
			if ($result[$key]['total_ol_mar'] == '') {
				$sheet->setCellValue('S' . $numrow, '0');
			} else {
				$sheet->setCellValue('S' . $numrow, ($result[$key]['total_ol_mar']));
			}
			if ($result[$key]['total_sv_mar'] == '') {
				$sheet->setCellValue('T' . $numrow, '0');
			} else {
				$sheet->setCellValue('T' . $numrow, ($result[$key]['total_sv_mar']));
			}
			if ($result[$key]['total_bm_mar'] == '') {
				$sheet->setCellValue('U' . $numrow, '0');
			} else {
				$sheet->setCellValue('U' . $numrow, ($result[$key]['total_bm_mar']));
			}
			if ($result[$key]['total_pj_mar'] == '') {
				$sheet->setCellValue('V' . $numrow, '0');
			} else {
				$sheet->setCellValue('V' . $numrow, ($result[$key]['total_pj_mar']));
			}
			//april
			if ($result[$key]['total_sp_apr'] == '') {
				$sheet->setCellValue('W' . $numrow, '0');
			} else {
				$sheet->setCellValue('W' . $numrow, ($result[$key]['total_sp_apr']));
			}
			if ($result[$key]['total_ol_apr'] == '') {
				$sheet->setCellValue('X' . $numrow, '0');
			} else {
				$sheet->setCellValue('X' . $numrow, ($result[$key]['total_ol_apr']));
			}
			if ($result[$key]['total_sv_apr'] == '') {
				$sheet->setCellValue('Y' . $numrow, '0');
			} else {
				$sheet->setCellValue('Y' . $numrow, ($result[$key]['total_sv_apr']));
			}
			if ($result[$key]['total_bm_apr'] == '') {
				$sheet->setCellValue('Z' . $numrow, '0');
			} else {
				$sheet->setCellValue('Z' . $numrow, ($result[$key]['total_bm_apr']));
			}
			if ($result[$key]['total_pj_apr'] == '') {
				$sheet->setCellValue('AA' . $numrow, '0');
			} else {
				$sheet->setCellValue('AA' . $numrow, ($result[$key]['total_pj_apr']));
			}
			//mei
			if ($result[$key]['total_sp_mei'] == '') {
				$sheet->setCellValue('AB' . $numrow, '0');
			} else {
				$sheet->setCellValue('AB' . $numrow, ($result[$key]['total_sp_mei']));
			}
			if ($result[$key]['total_ol_mei'] == '') {
				$sheet->setCellValue('AC' . $numrow, '0');
			} else {
				$sheet->setCellValue('AC' . $numrow, ($result[$key]['total_ol_mei']));
			}
			if ($result[$key]['total_sv_mei'] == '') {
				$sheet->setCellValue('AD' . $numrow, '0');
			} else {
				$sheet->setCellValue('AD' . $numrow, ($result[$key]['total_sv_mei']));
			}
			if ($result[$key]['total_bm_mei'] == '') {
				$sheet->setCellValue('AE' . $numrow, '0');
			} else {
				$sheet->setCellValue('AE' . $numrow, ($result[$key]['total_bm_mei']));
			}
			if ($result[$key]['total_pj_mei'] == '') {
				$sheet->setCellValue('AF' . $numrow, '0');
			} else {
				$sheet->setCellValue('AF' . $numrow, ($result[$key]['total_pj_mei']));
			}
			//juni
			if ($result[$key]['total_sp_jun'] == '') {
				$sheet->setCellValue('AG' . $numrow, '0');
			} else {
				$sheet->setCellValue('AG' . $numrow, ($result[$key]['total_sp_jun']));
			}
			if ($result[$key]['total_ol_jun'] == '') {
				$sheet->setCellValue('AH' . $numrow, '0');
			} else {
				$sheet->setCellValue('AH' . $numrow, ($result[$key]['total_ol_jun']));
			}
			if ($result[$key]['total_sv_jun'] == '') {
				$sheet->setCellValue('AI' . $numrow, '0');
			} else {
				$sheet->setCellValue('AI' . $numrow, ($result[$key]['total_sv_jun']));
			}
			if ($result[$key]['total_bm_jun'] == '') {
				$sheet->setCellValue('AJ' . $numrow, '0');
			} else {
				$sheet->setCellValue('AJ' . $numrow, ($result[$key]['total_bm_jun']));
			}
			if ($result[$key]['total_pj_jun'] == '') {
				$sheet->setCellValue('AK' . $numrow, '0');
			} else {
				$sheet->setCellValue('AK' . $numrow, ($result[$key]['total_pj_jun']));
			}
			//juli
			if ($result[$key]['total_sp_jul'] == '') {
				$sheet->setCellValue('AL' . $numrow, '0');
			} else {
				$sheet->setCellValue('AL' . $numrow, ($result[$key]['total_sp_jul']));
			}
			if ($result[$key]['total_ol_jul'] == '') {
				$sheet->setCellValue('AM' . $numrow, '0');
			} else {
				$sheet->setCellValue('AM' . $numrow, ($result[$key]['total_ol_jul']));
			}
			if ($result[$key]['total_sv_jul'] == '') {
				$sheet->setCellValue('AN' . $numrow, '0');
			} else {
				$sheet->setCellValue('AM' . $numrow, ($result[$key]['total_sv_jul']));
			}
			if ($result[$key]['total_bm_jul'] == '') {
				$sheet->setCellValue('AO' . $numrow, '0');
			} else {
				$sheet->setCellValue('AO' . $numrow, ($result[$key]['total_bm_jul']));
			}
			if ($result[$key]['total_pj_jul'] == '') {
				$sheet->setCellValue('AP' . $numrow, '0');
			} else {
				$sheet->setCellValue('AP' . $numrow, ($result[$key]['total_pj_jul']));
			}
			//agustus
			if ($result[$key]['total_sp_ags'] == '') {
				$sheet->setCellValue('AQ' . $numrow, '0');
			} else {
				$sheet->setCellValue('AQ' . $numrow, ($result[$key]['total_sp_ags']));
			}
			if ($result[$key]['total_ol_ags'] == '') {
				$sheet->setCellValue('AR' . $numrow, '0');
			} else {
				$sheet->setCellValue('AR' . $numrow, ($result[$key]['total_ol_ags']));
			}
			if ($result[$key]['total_sv_ags'] == '') {
				$sheet->setCellValue('AS' . $numrow, '0');
			} else {
				$sheet->setCellValue('AS' . $numrow, ($result[$key]['total_sv_ags']));
			}
			if ($result[$key]['total_bm_ags'] == '') {
				$sheet->setCellValue('AT' . $numrow, '0');
			} else {
				$sheet->setCellValue('AT' . $numrow, ($result[$key]['total_bm_ags']));
			}
			if ($result[$key]['total_pj_ags'] == '') {
				$sheet->setCellValue('AU' . $numrow, '0');
			} else {
				$sheet->setCellValue('AU' . $numrow, ($result[$key]['total_pj_ags']));
			}
			//september
			if ($result[$key]['total_sp_sept'] == '') {
				$sheet->setCellValue('AV' . $numrow, '0');
			} else {
				$sheet->setCellValue('AV' . $numrow, ($result[$key]['total_sp_sept']));
			}
			if ($result[$key]['total_ol_sept'] == '') {
				$sheet->setCellValue('AW' . $numrow, '0');
			} else {
				$sheet->setCellValue('AW' . $numrow, ($result[$key]['total_ol_sept']));
			}
			if ($result[$key]['total_sv_sept'] == '') {
				$sheet->setCellValue('AX' . $numrow, '0');
			} else {
				$sheet->setCellValue('AX' . $numrow, ($result[$key]['total_sv_sept']));
			}
			if ($result[$key]['total_bm_sept'] == '') {
				$sheet->setCellValue('AY' . $numrow, '0');
			} else {
				$sheet->setCellValue('AY' . $numrow, ($result[$key]['total_bm_sept']));
			}
			if ($result[$key]['total_pj_sept'] == '') {
				$sheet->setCellValue('AZ' . $numrow, '0');
			} else {
				$sheet->setCellValue('AZ' . $numrow, ($result[$key]['total_pj_sept']));
			}
			//oktober
			if ($result[$key]['total_sp_okt'] == '') {
				$sheet->setCellValue('BA' . $numrow, '0');
			} else {
				$sheet->setCellValue('BA' . $numrow, ($result[$key]['total_sp_okt']));
			}
			if ($result[$key]['total_ol_okt'] == '') {
				$sheet->setCellValue('BB' . $numrow, '0');
			} else {
				$sheet->setCellValue('BB' . $numrow, ($result[$key]['total_ol_okt']));
			}
			if ($result[$key]['total_sv_okt'] == '') {
				$sheet->setCellValue('BC' . $numrow, '0');
			} else {
				$sheet->setCellValue('BC' . $numrow, ($result[$key]['total_sv_okt']));
			}
			if ($result[$key]['total_bm_okt'] == '') {
				$sheet->setCellValue('BD' . $numrow, '0');
			} else {
				$sheet->setCellValue('BD' . $numrow, ($result[$key]['total_bm_okt']));
			}
			if ($result[$key]['total_pj_okt'] == '') {
				$sheet->setCellValue('BE' . $numrow, '0');
			} else {
				$sheet->setCellValue('BE' . $numrow, ($result[$key]['total_pj_okt']));
			}
			//november
			if ($result[$key]['total_sp_nov'] == '') {
				$sheet->setCellValue('BF' . $numrow, '0');
			} else {
				$sheet->setCellValue('BF' . $numrow, ($result[$key]['total_sp_nov']));
			}
			if ($result[$key]['total_ol_nov'] == '') {
				$sheet->setCellValue('BG' . $numrow, '0');
			} else {
				$sheet->setCellValue('BG' . $numrow, ($result[$key]['total_ol_nov']));
			}
			if ($result[$key]['total_sv_nov'] == '') {
				$sheet->setCellValue('BH' . $numrow, '0');
			} else {
				$sheet->setCellValue('BH' . $numrow, ($result[$key]['total_sv_nov']));
			}
			if ($result[$key]['total_bm_nov'] == '') {
				$sheet->setCellValue('BI' . $numrow, '0');
			} else {
				$sheet->setCellValue('BI' . $numrow, ($result[$key]['total_bm_nov']));
			}
			if ($result[$key]['total_pj_nov'] == '') {
				$sheet->setCellValue('BJ' . $numrow, '0');
			} else {
				$sheet->setCellValue('BJ' . $numrow, ($result[$key]['total_pj_nov']));
			}
			///desember
			if ($result[$key]['total_sp_des'] == '') {
				$sheet->setCellValue('BK' . $numrow, '0');
			} else {
				$sheet->setCellValue('BK' . $numrow, ($result[$key]['total_sp_des']));
			}
			if ($result[$key]['total_ol_des'] == '') {
				$sheet->setCellValue('BL' . $numrow, '0');
			} else {
				$sheet->setCellValue('BL' . $numrow, ($result[$key]['total_ol_des']));
			}
			if ($result[$key]['total_sv_des'] == '') {
				$sheet->setCellValue('BM' . $numrow, '0');
			} else {
				$sheet->setCellValue('BM' . $numrow, ($result[$key]['total_sv_des']));
			}
			if ($result[$key]['total_bm_des'] == '') {
				$sheet->setCellValue('BN' . $numrow, '0');
			} else {
				$sheet->setCellValue('BN' . $numrow, ($result[$key]['total_bm_des']));
			}
			if ($result[$key]['total_pj_des'] == '') {
				$sheet->setCellValue('BO' . $numrow, '0');
			} else {
				$sheet->setCellValue('BO' . $numrow, ($result[$key]['total_pj_des']));
			}
			//TOTAL
			if ($totalpengeluaran == '') {
				$sheet->setCellValue('BP' . $numrow, '0');
			} else {
				$sheet->setCellValue('BP' . $numrow, $totalpengeluaran);
			}
			//sisa
			if ($pagusisa == '') {
				$sheet->setCellValue('BQ' . $numrow, '0');
			} else {
				$sheet->setCellValue('BQ' . $numrow, $pagusisa);
			}




			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('Q' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('R' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('S' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('T' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('U' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('W' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('Y' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('Z' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AA' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AB' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AC' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AD' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AE' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AF' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AG' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AH' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AI' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AJ' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AK' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AL' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AM' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AN' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AO' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AP' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AQ' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AR' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AS' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AT' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AU' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AV' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AW' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AX' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AY' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('AZ' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BA' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BB' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BC' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BD' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BE' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BF' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BG' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BH' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BI' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BJ' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BK' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BL' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BM' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BN' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BO' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BP' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('BQ' . $numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
		$sheet->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
		$sheet->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('J')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('K')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('L')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('M')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('N')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('O')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('P')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('Q')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('R')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('S')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('T')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('U')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('V')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('W')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('X')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('Y')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('Z')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AA')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AB')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AC')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AD')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AE')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AF')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AG')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AH')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AI')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AJ')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AK')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AL')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AM')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AN')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AO')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AP')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AQ')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AR')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AS')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AT')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AU')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AV')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AW')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AX')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AY')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('AZ')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BA')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BB')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BC')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BD')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BE')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BF')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BG')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BH')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BI')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BJ')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BK')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BL')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BM')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BN')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BO')->setAutoSize(true); // Set width kolom E
		$sheet->getColumnDimension('BP')->setAutoSize(true); // Set width kolom E		
		$sheet->getColumnDimension('BQ')->setAutoSize(true); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("TA " . $tahun);
		$tahun = '2022';
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Rincian Service Bengkel Tahun ' . $tahun . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}
}