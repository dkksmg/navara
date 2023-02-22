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
			$bulan = ($this->input->get('bulan'));

			if ($bulan == "all") {
				$data['tahun'] = $tahun;
				$data['bulan'] = $bulan;
				$data['rekap'] = $this->home_m->data_servis($tahun);
				// print_r($data['rekap']);
				// die();
				$data['januari'] = $this->home_m->servis_bbm_jan($tahun);
				// print_r($data['januari']);
				// // print_r($this->db->last_query());
				// die();
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

			} else {
				$data['tahun'] = $tahun;
				$data['bulan'] = $bulan;
				if ($bulan == 1) {
					$data['bln_v'] = 'Januari';
				} else if ($bulan == 2) {
					$data['bln_v'] = 'Februari';
				} else if ($bulan == 3) {
					$data['bln_v'] = 'Maret';
				} else if ($bulan == 4) {
					$data['bln_v'] = 'April';
				} else if ($bulan == 5) {
					$data['bln_v'] = 'Mei';
				} else if ($bulan == 6) {
					$data['bln_v'] = 'Juni';
				} else if ($bulan == 7) {
					$data['bln_v'] = 'Juli';
				} else if ($bulan == 8) {
					$data['bln_v'] = 'Agustus';
				} else if ($bulan == 9) {
					$data['bln_v'] = 'September';
				} else if ($bulan == 10) {
					$data['bln_v'] = 'Oktober';
				} else if ($bulan == 11) {
					$data['bln_v'] = 'November';
				} else if ($bulan == 12) {
					$data['bln_v'] = 'Desember';
				}
				$data['rekap'] = $this->home_m->data_servis($tahun);
				// $data['rekap'] = $this->home_m->data_servis_bulan($tahun, $bulan);
				$data['bulanan'] = $this->home_m->servis_bbm_bulanan($tahun, $bulan);
				// print_r($data['rekap']);
				// print_r($data['bulanan']);
				// die();
				$data['title'] = 'Rekap Servis Kendaraan Dinas Dari Tahun ' . $tahun . ' Bulan ' . $data['bln_v'];
				// print_r($data['bulanan']);
				// die();
			}
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/laporan/dataservis', $data);
		$this->load->view('admin/template/footer');
	}

	public function export_excel()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$tahun = $this->input->get('tahun');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('Ardian FM')
			->setLastModifiedBy('Ardian FM')
			->setTitle("Rincian Service Bengkel NAVARA")
			->setSubject("NAVARA")
			->setDescription("Laporan Semua Data Kendaraan di Navara");
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "KENDARAAN");
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "RINCIAN SERVICE BENGKEL TAHUN " . $tahun);
		$excel->getActiveSheet()->mergeCells('A1:G1');
		$excel->getActiveSheet()->mergeCells('H1:BP1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->freezePane('H5');

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->getActiveSheet()->mergeCells('A3:A4');
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "JENIS KENDARAAN");
		$excel->getActiveSheet()->mergeCells('B3:B4');
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "MERK");
		$excel->getActiveSheet()->mergeCells('C3:C4');
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "TIPE");
		$excel->getActiveSheet()->mergeCells('D3:D4');
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "NO POLISI");
		$excel->getActiveSheet()->mergeCells('E3:E4');
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "PEMAKAI");
		$excel->getActiveSheet()->mergeCells('F3:F4');
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "PAGU");
		$excel->getActiveSheet()->mergeCells('G3:G4');
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "JANUARI");
		$excel->getActiveSheet()->mergeCells('H3:L3');
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "FEBRUARI");
		$excel->getActiveSheet()->mergeCells('M3:Q3');
		$excel->setActiveSheetIndex(0)->setCellValue('R3', "MARET");
		$excel->getActiveSheet()->mergeCells('R3:V3');
		$excel->setActiveSheetIndex(0)->setCellValue('W3', "APRIL");
		$excel->getActiveSheet()->mergeCells('W3:AA3');
		$excel->setActiveSheetIndex(0)->setCellValue('AB3', "MEI");
		$excel->getActiveSheet()->mergeCells('AB3:AF3');
		$excel->setActiveSheetIndex(0)->setCellValue('AG3', "JUNI");
		$excel->getActiveSheet()->mergeCells('AG3:AK3');
		$excel->setActiveSheetIndex(0)->setCellValue('AL3', "JULI");
		$excel->getActiveSheet()->mergeCells('AL3:AP3');
		$excel->setActiveSheetIndex(0)->setCellValue('AQ3', "AGUSTUS");
		$excel->getActiveSheet()->mergeCells('AQ3:AU3');
		$excel->setActiveSheetIndex(0)->setCellValue('AV3', "SEPTEMBER");
		$excel->getActiveSheet()->mergeCells('AV3:AZ3');
		$excel->setActiveSheetIndex(0)->setCellValue('BA3', "OKTOBER");
		$excel->getActiveSheet()->mergeCells('BA3:BE3');
		$excel->setActiveSheetIndex(0)->setCellValue('BF3', "NOVEMBER");
		$excel->getActiveSheet()->mergeCells('BF3:BJ3');
		$excel->setActiveSheetIndex(0)->setCellValue('BK3', "DESEMBER");
		$excel->getActiveSheet()->mergeCells('BK3:BO3');
		// $excel->setActiveSheetIndex(0)->setCellValue('BP3', "TOTAL");
		// $excel->getActiveSheet()->mergeCells('BP3:BP4');
		// $excel->setActiveSheetIndex(0)->setCellValue('BQ3', "SISA");
		// $excel->getActiveSheet()->mergeCells('BQ3:BQ4');
		
		$excel->setActiveSheetIndex(0)->setCellValue('BQ3', "TOTAL");
		$excel->getActiveSheet()->mergeCells('BQ3:BQ4');
		$excel->setActiveSheetIndex(0)->setCellValue('BP3', "SISA");
		$excel->getActiveSheet()->mergeCells('BP3:BP4');


		$excel->getActiveSheet()->setCellValue('H4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('I4', "OLI");
		$excel->getActiveSheet()->setCellValue('J4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('K4', "BBM");
		$excel->getActiveSheet()->setCellValue('L4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('M4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('N4', "OLI");
		$excel->getActiveSheet()->setCellValue('O4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('P4', "BBM");
		$excel->getActiveSheet()->setCellValue('Q4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('R4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('S4', "OLI");
		$excel->getActiveSheet()->setCellValue('T4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('U4', "BBM");
		$excel->getActiveSheet()->setCellValue('V4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('W4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('X4', "OLI");
		$excel->getActiveSheet()->setCellValue('Y4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('Z4', "BBM");
		$excel->getActiveSheet()->setCellValue('AA4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('AB4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('AC4', "OLI");
		$excel->getActiveSheet()->setCellValue('AD4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('AE4', "BBM");
		$excel->getActiveSheet()->setCellValue('AF4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('AG4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('AH4', "OLI");
		$excel->getActiveSheet()->setCellValue('AI4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('AJ4', "BBM");
		$excel->getActiveSheet()->setCellValue('AK4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('AL4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('AM4', "OLI");
		$excel->getActiveSheet()->setCellValue('AN4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('AO4', "BBM");
		$excel->getActiveSheet()->setCellValue('AP4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('AQ4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('AR4', "OLI");
		$excel->getActiveSheet()->setCellValue('AS4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('AT4', "BBM");
		$excel->getActiveSheet()->setCellValue('AU4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('AV4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('AW4', "OLI");
		$excel->getActiveSheet()->setCellValue('AX4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('AY4', "BBM");
		$excel->getActiveSheet()->setCellValue('AZ4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('BA4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('BB4', "OLI");
		$excel->getActiveSheet()->setCellValue('BC4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('BD4', "BBM");
		$excel->getActiveSheet()->setCellValue('BE4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('BF4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('BG4', "OLI");
		$excel->getActiveSheet()->setCellValue('BH4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('BI4', "BBM");
		$excel->getActiveSheet()->setCellValue('BJ4', "PAJAK");

		$excel->getActiveSheet()->setCellValue('BK4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('BL4', "OLI");
		$excel->getActiveSheet()->setCellValue('BM4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('BN4', "BBM");
		$excel->getActiveSheet()->setCellValue('BO4', "PAJAK");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AK3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AL3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AM3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AN3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AO3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AP3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AQ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AR3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AS3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AT3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AU3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AV3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AW3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AX3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AY3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AZ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ3')->applyFromArray($style_col);


		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AK4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AL4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AM4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AN4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AO4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AP4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AQ4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AR4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AS4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AT4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AU4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AV4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AW4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AX4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AY4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AZ4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ4')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('A3:A1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('B3:B1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('C3:C1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('D3:D1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('E3:E1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('F3:F4')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('F5:F1000')->getAlignment()->setHorizontal('left');
		$excel->getActiveSheet()->getStyle('G3:G1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('H3:H1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('I3:I1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('J3:J1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('K3:K1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('L3:L1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('M3:M1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('N3:N1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('O3:O1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('P3:P1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('Q3:Q1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('R3:R1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('S3:S1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('T3:T1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('U3:U1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('V3:V1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('W3:W1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('X3:X1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('Y3:Y1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('Z3:Z1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AA3:AA1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AB3:AB1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AC3:AC1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AD3:AD1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AE3:AE1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AF3:AF1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AG3:AG1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AH3:AH1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AI3:AI1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AJ3:AJ1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AK3:AK1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AL3:AL1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AM3:AM1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AN3:AN1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AO3:AO1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AP3:AP1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AQ3:AQ1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AR3:AR1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AS3:AS1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AT3:AT1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AU3:AU1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AV3:AV1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AW3:AW1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AX3:AX1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AY3:AY1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('AZ3:AZ1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BA3:BA1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BB3:BB1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BC3:BC1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BD3:BD1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BE3:BE1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BF3:BF1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BG3:BG1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BH3:BH1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BI3:BI1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BJ3:BJ1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BK3:BK1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BL3:BL1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BM3:BM1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BN3:BN1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BO3:BO1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BP3:BP1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('BQ3:BQ1000')->getAlignment()->setHorizontal('center');

		$excel->getActiveSheet()->getStyle('G3:G1000')
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('H3:H1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('I3:I1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('J3:J1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('K3:K1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('L3:L1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('M3:M1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('N3:N1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('O3:O1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('P3:P1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('Q3:Q1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('R3:R1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('S3:S1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('T3:T1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('U3:U1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('V3:V1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('W3:W1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('X3:X1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('Y3:Y1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('Z3:Z1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AA3:AA1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AB3:AB1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AC3:AC1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AD3:AD1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AE3:AE1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AF3:AF1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AG3:AG1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AH3:AH1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AI3:AI1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AJ3:AJ1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AK3:AK1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AL3:AL1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AM3:AM1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AN3:AN1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AO3:AO1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AP3:AP1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AQ3:AQ1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AR3:AR1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AS3:AS1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AT3:AT1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AU3:AU1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AV3:AV1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AW3:AW1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AX3:AX1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AY3:AY1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('AZ3:AZ1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BA3:BA1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BB3:BB1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BC3:BC1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BD3:BD1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BE3:BE1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BF3:BF1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BG3:BG1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BH3:BH1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BI3:BI1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BJ3:BJ1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BK3:BK1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BL3:BL1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BM3:BM1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BN3:BN1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BO3:BO1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BP3:BP1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('BQ3:BQ1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);

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

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, strtoupper($result[$key]['jenis']));
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, strtoupper($result[$key]['merk']));
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, strtoupper($result[$key]['tipe']));
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, strtoupper($result[$key]['no_polisi']));
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, ($result[$key]['name']));
			if ($result[$key]['pagu_awal'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, ($result[$key]['pagu_awal']));
			}
			//januari
			if ($result[$key]['total_sp_jan'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, ($result[$key]['total_sp_jan']));
			}
			if ($result[$key]['total_ol_jan'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, ($result[$key]['total_ol_jan']));
			}
			if ($result[$key]['total_sv_jan'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, ($result[$key]['total_sv_jan']));
			}
			if ($result[$key]['total_bm_jan'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, ($result[$key]['total_bm_jan']));
			}
			if ($result[$key]['total_pj_jan'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, ($result[$key]['total_pj_jan']));
			}
			//februari
			if ($result[$key]['total_sp_feb'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, ($result[$key]['total_sp_feb']));
			}
			if ($result[$key]['total_ol_feb'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, ($result[$key]['total_ol_feb']));
			}
			if ($result[$key]['total_sv_feb'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, ($result[$key]['total_sv_feb']));
			}
			if ($result[$key]['total_bm_feb'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, ($result[$key]['total_bm_feb']));
			}
			if ($result[$key]['total_pj_feb'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, ($result[$key]['total_pj_feb']));
			}
			//maret
			if ($result[$key]['total_sp_mar'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, ($result[$key]['total_sp_mar']));
			}
			if ($result[$key]['total_ol_mar'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, ($result[$key]['total_ol_mar']));
			}
			if ($result[$key]['total_sv_mar'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, ($result[$key]['total_sv_mar']));
			}
			if ($result[$key]['total_bm_mar'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, ($result[$key]['total_bm_mar']));
			}
			if ($result[$key]['total_pj_mar'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, ($result[$key]['total_pj_mar']));
			}
			//april
			if ($result[$key]['total_sp_apr'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, ($result[$key]['total_sp_apr']));
			}
			if ($result[$key]['total_ol_apr'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, ($result[$key]['total_ol_apr']));
			}
			if ($result[$key]['total_sv_apr'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, ($result[$key]['total_sv_apr']));
			}
			if ($result[$key]['total_bm_apr'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, ($result[$key]['total_bm_apr']));
			}
			if ($result[$key]['total_pj_apr'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, ($result[$key]['total_pj_apr']));
			}
			//mei
			if ($result[$key]['total_sp_mei'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, ($result[$key]['total_sp_mei']));
			}
			if ($result[$key]['total_ol_mei'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, ($result[$key]['total_ol_mei']));
			}
			if ($result[$key]['total_sv_mei'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow, ($result[$key]['total_sv_mei']));
			}
			if ($result[$key]['total_bm_mei'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, ($result[$key]['total_bm_mei']));
			}
			if ($result[$key]['total_pj_mei'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow, ($result[$key]['total_pj_mei']));
			}
			//juni
			if ($result[$key]['total_sp_jun'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow, ($result[$key]['total_sp_jun']));
			}
			if ($result[$key]['total_ol_jun'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow, ($result[$key]['total_ol_jun']));
			}
			if ($result[$key]['total_sv_jun'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, ($result[$key]['total_sv_jun']));
			}
			if ($result[$key]['total_bm_jun'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AJ' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AJ' . $numrow, ($result[$key]['total_bm_jun']));
			}
			if ($result[$key]['total_pj_jun'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AK' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AK' . $numrow, ($result[$key]['total_pj_jun']));
			}
			//juli
			if ($result[$key]['total_sp_jul'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AL' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AL' . $numrow, ($result[$key]['total_sp_jul']));
			}
			if ($result[$key]['total_ol_jul'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AM' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AM' . $numrow, ($result[$key]['total_ol_jul']));
			}
			if ($result[$key]['total_sv_jul'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AN' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AM' . $numrow, ($result[$key]['total_sv_jul']));
			}
			if ($result[$key]['total_bm_jul'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AO' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AO' . $numrow, ($result[$key]['total_bm_jul']));
			}
			if ($result[$key]['total_pj_jul'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AP' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AP' . $numrow, ($result[$key]['total_pj_jul']));
			}
			//agustus
			if ($result[$key]['total_sp_ags'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AQ' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AQ' . $numrow, ($result[$key]['total_sp_ags']));
			}
			if ($result[$key]['total_ol_ags'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AR' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AR' . $numrow, ($result[$key]['total_ol_ags']));
			}
			if ($result[$key]['total_sv_ags'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AS' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AS' . $numrow, ($result[$key]['total_sv_ags']));
			}
			if ($result[$key]['total_bm_ags'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AT' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AT' . $numrow, ($result[$key]['total_bm_ags']));
			}
			if ($result[$key]['total_pj_ags'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AU' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AU' . $numrow, ($result[$key]['total_pj_ags']));
			}
			//september
			if ($result[$key]['total_sp_sept'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AV' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AV' . $numrow, ($result[$key]['total_sp_sept']));
			}
			if ($result[$key]['total_ol_sept'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AW' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AW' . $numrow, ($result[$key]['total_ol_sept']));
			}
			if ($result[$key]['total_sv_sept'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AX' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AX' . $numrow, ($result[$key]['total_sv_sept']));
			}
			if ($result[$key]['total_bm_sept'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AY' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AY' . $numrow, ($result[$key]['total_bm_sept']));
			}
			if ($result[$key]['total_pj_sept'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('AZ' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('AZ' . $numrow, ($result[$key]['total_pj_sept']));
			}
			//oktober
			if ($result[$key]['total_sp_okt'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BA' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BA' . $numrow, ($result[$key]['total_sp_okt']));
			}
			if ($result[$key]['total_ol_okt'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BB' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BB' . $numrow, ($result[$key]['total_ol_okt']));
			}
			if ($result[$key]['total_sv_okt'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BC' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BC' . $numrow, ($result[$key]['total_sv_okt']));
			}
			if ($result[$key]['total_bm_okt'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BD' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BD' . $numrow, ($result[$key]['total_bm_okt']));
			}
			if ($result[$key]['total_pj_okt'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BE' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BE' . $numrow, ($result[$key]['total_pj_okt']));
			}
			//november
			if ($result[$key]['total_sp_nov'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BF' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BF' . $numrow, ($result[$key]['total_sp_nov']));
			}
			if ($result[$key]['total_ol_nov'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BG' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BG' . $numrow, ($result[$key]['total_ol_nov']));
			}
			if ($result[$key]['total_sv_nov'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BH' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BH' . $numrow, ($result[$key]['total_sv_nov']));
			}
			if ($result[$key]['total_bm_nov'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BI' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BI' . $numrow, ($result[$key]['total_bm_nov']));
			}
			if ($result[$key]['total_pj_nov'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BJ' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BJ' . $numrow, ($result[$key]['total_pj_nov']));
			}
			///desember
			if ($result[$key]['total_sp_des'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BK' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BK' . $numrow, ($result[$key]['total_sp_des']));
			}
			if ($result[$key]['total_ol_des'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BL' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BL' . $numrow, ($result[$key]['total_ol_des']));
			}
			if ($result[$key]['total_sv_des'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BM' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BM' . $numrow, ($result[$key]['total_sv_des']));
			}
			if ($result[$key]['total_bm_des'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BN' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BN' . $numrow, ($result[$key]['total_bm_des']));
			}
			if ($result[$key]['total_pj_des'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BO' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BO' . $numrow, ($result[$key]['total_pj_des']));
			}
			// //TOTAL
			// if ($totalpengeluaran == '') {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('BP' . $numrow, '0');
			// } else {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('BP' . $numrow, $totalpengeluaran);
			// }
			// //sisa
			// if ($pagusisa == '') {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('BQ' . $numrow, '0');
			// } else {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('BQ' . $numrow, $pagusisa);
			// }

			//SISA
			if ($pagusisa== '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BP' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BP' . $numrow, $pagusisa);
			}
			//TOTAL
			if ($totalpengeluaran  == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('BQ' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('BQ' . $numrow, $totalpengeluaran );
			}


			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AI' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AJ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AK' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AL' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AM' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AN' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AO' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AP' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AQ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AR' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AS' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AT' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AU' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AV' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AW' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AX' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AY' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AZ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BA' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BB' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BC' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BD' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BE' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BF' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BG' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BH' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BI' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BJ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BK' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BL' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BM' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BN' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BO' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BP' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BQ' . $numrow)->applyFromArray($style_row);
			$no++;
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true); // Set width kolom E		
		$excel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true);

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("TA " . $tahun);
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rincian Service Bengkel Tahun ' . $tahun . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		exit();
	}

	public function export_excel_bulan()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		// if ($this->input->get()) {
		// 	$tahun = ($this->input->get('tahun'));
		// 	$bulan = ($this->input->get('bulan'));
		// }
		$tahun = $this->input->get('tahun');
		$bulan = $this->input->get('bulan');
		// $bulan = $this->input->get('bulan');
		if ($bulan == 1) {
			$bulanteks = 'Januari';
		} else if ($bulan == 2) {
			$bulanteks = 'Februari';
		} else if ($bulan == 3) {
			$bulanteks = 'Maret';
		} else if ($bulan == 4) {
			$bulanteks = 'April';
		} else if ($bulan == 5) {
			$bulanteks = 'Mei';
		} else if ($bulan == 6) {
			$bulanteks = 'Juni';
		} else if ($bulan == 7) {
			$bulanteks = 'Juli';
		} else if ($bulan == 8) {
			$bulanteks = 'Agustus';
		} else if ($bulan == 9) {
			$bulanteks = 'September';
		} else if ($bulan == 10) {
			$bulanteks = 'Oktober';
		} else if ($bulan == 11) {
			$bulanteks = 'November';
		} else if ($bulan == 12) {
			$bulanteks = 'Desember';
		}
		
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('Ardian FM')
			->setLastModifiedBy('Ardian FM')
			->setTitle("Rincian Service Bengkel NAVARA")
			->setSubject("NAVARA")
			->setDescription("Laporan Semua Data Kendaraan di Navara");
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "KENDARAAN");
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "RINCIAN SERVICE BENGKEL TAHUN " . $tahun);
		$excel->getActiveSheet()->mergeCells('A1:G1');
		$excel->getActiveSheet()->mergeCells('H1:N1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->freezePane('H5');

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->getActiveSheet()->mergeCells('A3:A4');
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "JENIS KENDARAAN");
		$excel->getActiveSheet()->mergeCells('B3:B4');
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "MERK");
		$excel->getActiveSheet()->mergeCells('C3:C4');
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "TIPE");
		$excel->getActiveSheet()->mergeCells('D3:D4');
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "NO POLISI");
		$excel->getActiveSheet()->mergeCells('E3:E4');
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "PEMAKAI");
		$excel->getActiveSheet()->mergeCells('F3:F4');
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "PAGU");
		$excel->getActiveSheet()->mergeCells('G3:G4');
		$excel->setActiveSheetIndex(0)->setCellValue('H3', $bulanteks);
		$excel->getActiveSheet()->mergeCells('H3:L3');
		// $excel->setActiveSheetIndex(0)->setCellValue('M3', "TOTAL");
		// $excel->getActiveSheet()->mergeCells('M3:M4');
		// $excel->getActiveSheet()->getColumnDimension('M')->setWidth(6);


		// $excel->setActiveSheetIndex(0)->setCellValue('N3', "SISA");
		// $excel->getActiveSheet()->mergeCells('N3:N4');
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "SISA");
		$excel->getActiveSheet()->mergeCells('M3:M4');

		$excel->setActiveSheetIndex(0)->setCellValue('N3', "TOTAL");
		$excel->getActiveSheet()->mergeCells('N3:N4');
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(6);


		$excel->getActiveSheet()->setCellValue('H4', "SPAREPART");
		$excel->getActiveSheet()->setCellValue('I4', "OLI");
		$excel->getActiveSheet()->setCellValue('J4', "SERVICE");
		$excel->getActiveSheet()->setCellValue('K4', "BBM");
		$excel->getActiveSheet()->setCellValue('L4', "PAJAK");


		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3:M4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3:N4')->applyFromArray($style_col);
		
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);
		
		$excel->getActiveSheet()->getStyle('A3:A1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('B3:B1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('C3:C1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('D3:D1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('E3:E1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('F3:F4')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('F5:F1000')->getAlignment()->setHorizontal('left');
		$excel->getActiveSheet()->getStyle('G3:G1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('H3:H1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('I3:I1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('J3:J1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('K3:K1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('L3:L1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('M3:M1000')->getAlignment()->setHorizontal('center');
		$excel->getActiveSheet()->getStyle('N3:N1000')->getAlignment()->setHorizontal('center');

		$excel->getActiveSheet()->getStyle('G3:G1000')
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('H3:H1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('I5:I1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('J3:J1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('K3:K1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('L5:L1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		$excel->getActiveSheet()->getStyle('M5:M1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);
		// $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$excel->getActiveSheet()->getStyle('N5:N1000')->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);

		$data_rincian = $this->home_m->data_servis($tahun);

		
		$laporan = $this->home_m->laporan_kendaraan_bulan($tahun, $bulan);
		// print_r($data_rincian);
		// print_r($laporan);
		// die();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		$result = array();
		foreach ($data_rincian as $key => $val) {
			$val2 = $laporan[$key];
			
			$result[$key] = $val + $val2;
			// print_r($result[$key]);
			// die();
			$totalsparepart = $result[$key]['total_sp'];
			$totaloli = $result[$key]['total_ol'];
			$totalservis = $result[$key]['total_sv'];
			$totalbbm = $result[$key]['total_bm'];
			$totalpajak = $result[$key]['total_pj'];


			$totalpengeluaran = $totalsparepart + $totaloli + $totalservis + $totalbbm + $totalpajak;
			$pagusisa = $result[$key]['pagu_awal'] - $totalpengeluaran;

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, strtoupper($result[$key]['jenis']));
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, strtoupper($result[$key]['merk']));
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, strtoupper($result[$key]['tipe']));
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, strtoupper($result[$key]['no_polisi']));
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, ($result[$key]['name']));
			if ($result[$key]['pagu_awal'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, ($result[$key]['pagu_awal']));
			}
			//bulan
			if ($result[$key]['total_sp'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, ($result[$key]['total_sp']));
			}
			if ($result[$key]['total_ol'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, ($result[$key]['total_ol']));
			}
			if ($result[$key]['total_sv'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, ($result[$key]['total_sv']));
			}
			if ($result[$key]['total_bm'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, ($result[$key]['total_bm']));
			}
			if ($result[$key]['total_pj'] == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, ($result[$key]['total_pj']));
			}
			
			// //TOTAL
			// if ($totalpengeluaran == '') {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '0');
			// } else {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $totalpengeluaran);
			// }
			// //sisa
			// if ($pagusisa == '') {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '0');
			// } else {
			// 	$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $pagusisa);
			// }

			//SISA
			if ($pagusisa == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $pagusisa);
			}
			//TOTAL
			if ($totalpengeluaran == '') {
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '0');
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $totalpengeluaran);
			}


			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
			
			$no++;
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); // Set width kolom E
		// $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		// // print_r($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('M'));
		// // die();
		// if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('M')->getWidth()<=6){
		// 	$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
		// 	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
		// }

		// $excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


		$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

		$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('N')->getWidth()<=6){
			$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
		}
		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("TA " . $tahun);
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rincian Service Bengkel Tahun ' . $tahun . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		exit();
	}

	public function rekap_peralatan()
	{
		$data = [];
		$data['title'] = "Rekap Servis Peralatan Dinas";
		if ($this->input->get()) {

			$tahun = ($this->input->get('tahun'));
			$bulan = ($this->input->get('bulan'));

			// print_r($tahun);
			// die();

			if ($bulan == "all") {
				$data['tahun'] = $tahun;
				$data['bulan'] = $bulan;
				$data['rekap'] = $this->home_m->data_servis_peralatan($tahun);
				// $data['rekap'] = $this->home_m->data_servis_peralatan_filter($tahun);
				// print_r($data['rekap']);
				// die();
				$data['januari'] = $this->home_m->servis_peralatan_all_bulan($tahun, '1');
				
				$data['februari'] = $this->home_m->servis_peralatan_all_bulan($tahun, '2');
				// print_r($data['februari']);
				// die();
				$data['maret'] = $this->home_m->servis_peralatan_all_bulan($tahun, '3');
				$data['april'] = $this->home_m->servis_peralatan_all_bulan($tahun, '4');
				$data['mei'] = $this->home_m->servis_peralatan_all_bulan($tahun, '5');
				$data['juni'] = $this->home_m->servis_peralatan_all_bulan($tahun, '6');
				$data['juli'] = $this->home_m->servis_peralatan_all_bulan($tahun, '7');
				$data['agustus'] = $this->home_m->servis_peralatan_all_bulan($tahun, '8');
				$data['september'] = $this->home_m->servis_peralatan_all_bulan($tahun, '9');
				$data['oktober'] = $this->home_m->servis_peralatan_all_bulan($tahun, '10');
				$data['november'] = $this->home_m->servis_peralatan_all_bulan($tahun, '11');
				$data['desember'] = $this->home_m->servis_peralatan_all_bulan($tahun, '12');
				$data['title'] = 'Rekap Servis Peralatan Dinas Dari Tahun ' . $tahun . '';
				// print_r($data);
				// die();
				
			} else {
				$data['tahun'] = $tahun;
				$data['bulan'] = $bulan;
				if ($bulan == 1) {
					$data['bln_v'] = 'Januari';
				} else if ($bulan == 2) {
					$data['bln_v'] = 'Februari';
				} else if ($bulan == 3) {
					$data['bln_v'] = 'Maret';
				} else if ($bulan == 4) {
					$data['bln_v'] = 'April';
				} else if ($bulan == 5) {
					$data['bln_v'] = 'Mei';
				} else if ($bulan == 6) {
					$data['bln_v'] = 'Juni';
				} else if ($bulan == 7) {
					$data['bln_v'] = 'Juli';
				} else if ($bulan == 8) {
					$data['bln_v'] = 'Agustus';
				} else if ($bulan == 9) {
					$data['bln_v'] = 'September';
				} else if ($bulan == 10) {
					$data['bln_v'] = 'Oktober';
				} else if ($bulan == 11) {
					$data['bln_v'] = 'November';
				} else if ($bulan == 12) {
					$data['bln_v'] = 'Desember';
				}
				// print_r($bulan);
				$data['rekap'] = $this->home_m->data_servis_peralatan_bulan($tahun, $bulan);
				// print_r($data['rekap']);
				// die();
				$data['bulanan'] = $this->home_m->servis_peralatan_bulan($tahun, $bulan);
				// print_r($data['rekap']);
				// print_r($data['bulanan']);
				// die();

				$data['title'] = 'Rekap Servis Peralatan Dinas Dari Tahun ' . $tahun . ' Bulan ' . $data['bln_v'];
				// print_r($data);
				// die();
			}
			// print_r($data);
			// 	die();
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/laporan/dataperalatan', $data);
		$this->load->view('admin/template/footer');
	}

	public function export_excel_peralatan()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$tahun = $this->input->get('tahun');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('Ardian FM')
			->setLastModifiedBy('Ardian FM')
			->setTitle("Rincian Service Peralatan NAVARA")
			->setSubject("NAVARA")
			->setDescription("Laporan Semua Data Peralatan di Navara");
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$data_rincian = $this->home_m->data_servis_peralatan_iduser($tahun);
		// print_r($data_rincian);
		// die();
		$result=array();
		// $result[]=$data_rincian;
		$no=0;
		// $data_rincian[0]['servis']=$data_rincian;
		foreach($data_rincian as $key=>$dr){
			// $result = $this->home_m->data_servis_peralatan($tahun);
			$id_user = $data_rincian[$key]['id'];
			$data_rincian[$key]['januari'] = $this->home_m->lap_alat($tahun, '1', $id_user);
			$data_rincian[$key]['februari'] = $this->home_m->lap_alat($tahun, '2', $id_user);
			$data_rincian[$key]['maret'] = $this->home_m->lap_alat($tahun, '3', $id_user);
			$data_rincian[$key]['april'] = $this->home_m->lap_alat($tahun, '4', $id_user);
			$data_rincian[$key]['mei'] = $this->home_m->lap_alat($tahun, '5', $id_user);
			$data_rincian[$key]['juni'] = $this->home_m->lap_alat($tahun, '6', $id_user);
			$data_rincian[$key]['juli'] = $this->home_m->lap_alat($tahun, '7', $id_user);
			$data_rincian[$key]['agustus'] = $this->home_m->lap_alat($tahun, '8', $id_user);
			$data_rincian[$key]['september'] = $this->home_m->lap_alat($tahun, '9', $id_user);
			$data_rincian[$key]['oktober'] = $this->home_m->lap_alat($tahun, '10', $id_user);
			$data_rincian[$key]['november'] = $this->home_m->lap_alat($tahun, '11', $id_user);
			$data_rincian[$key]['desember'] = $this->home_m->lap_alat($tahun, '12', $id_user);

			// $result = $this->home_m->data_riwayatservisperalatan($key, '2023');
			// $dr['id'];
			// $no++;
			// $result[$key]="aaaa";
			// $result[$key][$key]="aaa";
		}
		// print_r($data_rincian);
		// die();
		// print_r($result);
		// die();
		// print_r($lap_jan);
		// print_r($no);
		// die();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 1; // Set baris pertama untuk isi tabel adalah baris ke 4
		$numrow2 = 2;
		$numrow4 = 4;
		$numrow5 = 5;
		$numrow7 = 7;
		$numrow8 = 8;
		$numrow9 = 9;
		$result = array();
		// $colid_b = 'B';
		// $colid_i = 'I';
		foreach ($data_rincian as $key => $val) {
			// $val2 = $januari[$key];
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow,"KARTU PEMELIHARAAN BARANG INVENTARIS");
			$excel->getActiveSheet()->mergeCells('B'.$numrow.':'.'I'.$numrow);

			// $excel->getActiveSheet()->mergeCells('B'.$numrow':I'.$numrow);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setSize(12);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow2, "DINAS KESEHATAN KOTA SEMARANG TAHUN ANGGARAN ".$tahun);
			$excel->getActiveSheet()->mergeCells('B'.$numrow2.':I'.$numrow2);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getFont()->setSize(12);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow4, "NAMA UNIT");
			$excel->getActiveSheet()->mergeCells('B'.$numrow4.':C'.$numrow4);
			$excel->getActiveSheet()->getStyle('B'.$numrow4)->getFont()->setSize(12);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow4, ": DKK");
			$excel->getActiveSheet()->getStyle('D'.$numrow4)->getFont()->setSize(12);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow5, "PEMEGANG/LOKASI");
			$excel->getActiveSheet()->mergeCells('B'.$numrow5.':C'.$numrow5);
			$excel->getActiveSheet()->getStyle('B'.$numrow5)->getFont()->setSize(12);

			$result[$key] = $val;

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow5, ": ".$result[$key]['name'].'/'.$result[$key]['bidang']);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow7, "NO");
			$excel->getActiveSheet()->mergeCells('B'.$numrow7.':B'.$numrow8);
			$excel->getActiveSheet()->getStyle('B'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow7, "NAMA BARANG/MERK");
			$excel->getActiveSheet()->mergeCells('C'.$numrow7.':C'.$numrow8);
			$excel->getActiveSheet()->getStyle('C'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('C'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow7, "TANGGAL PERBAIKAN");
			$excel->getActiveSheet()->mergeCells('D'.$numrow7.':F'.$numrow7);
			$excel->getActiveSheet()->getStyle('D'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow8, "Tanggal");
			$excel->getActiveSheet()->getStyle('D'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow8, "Bulan");
			$excel->getActiveSheet()->getStyle('E'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow8, "Tahun");
			$excel->getActiveSheet()->getStyle('F'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow7, "Nama Rekanan");
			$excel->getActiveSheet()->mergeCells('G'.$numrow7.':G'.$numrow8);
			$excel->getActiveSheet()->getStyle('G'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('G'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow7, "JUMLAH (Rp)");
			$excel->getActiveSheet()->mergeCells('H'.$numrow7.':H'.$numrow8);
			$excel->getActiveSheet()->getStyle('H'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('H'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow7, "KETERANGAN\n(Jenis Service)");
			$excel->getActiveSheet()->mergeCells('I'.$numrow7.':I'.$numrow8);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setWrapText(true);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
			
			$nod=0;
			if($result[$key]['januari']!=null){
				if($key==0){
					$numrow91=9;	
				}
				else{
					$numrow91=$numrow9;
				}
				foreach ($result[$key]['januari'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow91, $ky+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow91, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow91, 
						$result[$key]['januari'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow91, 
						$result[$key]['januari'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow91, 
						$result[$key]['januari'][$ky]['ket_servis']);

					$ky++;
					$numrow91++;
					$nod++;
				}
			}

			if($result[$key]['februari']!=null){
				if($key==0){
					if($result[$key]['januari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['februari'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['februari'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['februari'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['februari'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['maret']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['maret'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['maret'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['maret'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['maret'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['april']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['april'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['april'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['april'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['april'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['mei']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['mei'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['mei'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['mei'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['mei'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['juni']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['juni'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['juni'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['juni'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['juni'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['juli']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['juli'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['juli'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['juli'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['juli'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['agustus']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['agustus'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['agustus'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['agustus'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['agustus'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['september']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['september'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['september'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['september'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['september'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['oktober']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['oktober'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['oktober'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['oktober'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['oktober'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['november']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['november'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['november'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['november'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['november'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['desember']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null
						||$result[$key]['november']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null
						||$result[$key]['november']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['desember'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['desember'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['desember'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['desember'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}

			}

			$num9n=$numrow9+$nod;
			
			//no center
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			//nama center
			// $excel->getActiveSheet()->getStyle('C'.$numrow9.':C'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('C'.$numrow9.':C'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//tanngal
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//bulan
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//tahun
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			// $excel->getActiveSheet()->getStyle('G'.$numrow9.':G'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('G'.$numrow9.':G'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			// $excel->getActiveSheet()->getStyle('I'.$numrow9.':I'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('I'.$numrow9.':I'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


			
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);

			// $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow7)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('B' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow8)->applyFromArray($style_row);

			$num9n1=$num9n-1;
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow9.':C' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow9.':G' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow9.':I' . $num9n1)->applyFromArray($style_row);

			$no++;
			$nob++;
			$numrow=$numrow+11+$nod;
			$numrow2=$numrow2+11+$nod;
			$numrow4=$numrow4+11+$nod;
			$numrow5=$numrow5+11+$nod;
			$numrow7=$numrow7+11+$nod;
			$numrow8=$numrow8+11+$nod;
			$numrow9=$numrow9+11+$nod;
			$numrow91=$numrow91+11+$nod;
			$numrow92=$numrow92+11+$nod;
			// $numrow93=$numrow93+15;
		}

		// $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
		// $sheet = $excel->getActiveSheet();
		// foreach ($sheet->getColumnIterator() as $cols) {
		// 	$sheet->getColumnDimension($cols->getColumnIndex())->setAutoSize(true);
		// }
		// foreach (range('B', 'I') as $colidbi) {
		// 	$excel->getActiveSheet()->getColumnDimension($colidbi)->setAutoSize(true);
		// }

		// foreach (range('B', 'I') as $colidbi) {
		// 	$excel->getActiveSheet()->getColumnDimension($colidbi)->setAutoSize(false);
		// }		

		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('C')->getWidth()<21){
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
		}
		 // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		// if($excel->getActiveSheet()->getColumnDimension('G')-)
		
		// $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		// print_r($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('C'));
		// die();
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('G')->getWidth()<=14){
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		}
		// print_r($excel->getActiveSheet()->getColumnDimension('G')->getwid;
		// die();
		 // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		// print_r($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('I'));
		// die();
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('I')->getWidth()<16){
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		}


		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("TA " . $tahun);
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rincian Service Peralatan Tahun ' . $tahun . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		exit();
	}

	public function export_excel_peralatan_bulan()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$tahun = $this->input->get('tahun');
		$bulan = $this->input->get('bulan');

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('Ardian FM')
			->setLastModifiedBy('Ardian FM')
			->setTitle("Rincian Service Peralatan NAVARA")
			->setSubject("NAVARA")
			->setDescription("Laporan Semua Data Peralatan di Navara");
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$data_rincian = $this->home_m->data_servis_peralatan_iduser_bulan($tahun, $bulan);
		// $data_rincian = $this->home_m->data_servis_peralatan_iduser($tahun);

		// print_r($data_rincian);
		// die();
		
		if ($bulan == 1) {
			$bulanteks = 'januari';
		} else if ($bulan == 2) {
			$bulanteks = 'februari';
		} else if ($bulan == 3) {
			$bulanteks = 'maret';
		} else if ($bulan == 4) {
			$bulanteks = 'april';
		} else if ($bulan == 5) {
			$bulanteks = 'mei';
		} else if ($bulan == 6) {
			$bulanteks = 'juni';
		} else if ($bulan == 7) {
			$bulanteks = 'juli';
		} else if ($bulan == 8) {
			$bulanteks = 'agustus';
		} else if ($bulan == 9) {
			$bulanteks = 'september';
		} else if ($bulan == 10) {
			$bulanteks = 'oktober';
		} else if ($bulan == 11) {
			$bulanteks = 'november';
		} else if ($bulan == 12) {
			$bulanteks = 'desember';
		}
		// print_r($bulanteks);
		// die();

		$result=array();
		$no=0;
		foreach($data_rincian as $key=>$dr){
			$id_user = $data_rincian[$key]['id'];
			$data_rincian[$key][$bulanteks] = $this->home_m->lap_alat($tahun, $bulan, $id_user);
			
			// print_r($data_rincian);
			// die();
		}
		// print_r($data_rincian);
		// die();
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 1; // Set baris pertama untuk isi tabel adalah baris ke 4
		$numrow2 = 2;
		$numrow4 = 4;
		$numrow5 = 5;
		$numrow7 = 7;
		$numrow8 = 8;
		$numrow9 = 9;
		$result = array();
		// $colid_b = 'B';
		// $colid_i = 'I';
		foreach ($data_rincian as $key => $val) {
			// $val2 = $januari[$key];
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow,"KARTU PEMELIHARAAN BARANG INVENTARIS");
			$excel->getActiveSheet()->mergeCells('B'.$numrow.':'.'I'.$numrow);

			// $excel->getActiveSheet()->mergeCells('B'.$numrow':I'.$numrow);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setSize(12);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow2, "DINAS KESEHATAN KOTA SEMARANG TAHUN ANGGARAN ".$tahun." BULAN ".strtoupper($bulanteks));
			$excel->getActiveSheet()->mergeCells('B'.$numrow2.':I'.$numrow2);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getFont()->setSize(12);
			$excel->getActiveSheet()->getStyle('B'.$numrow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow4, "NAMA UNIT");
			$excel->getActiveSheet()->mergeCells('B'.$numrow4.':C'.$numrow4);
			$excel->getActiveSheet()->getStyle('B'.$numrow4)->getFont()->setSize(12);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow4, ": DKK");
			$excel->getActiveSheet()->getStyle('D'.$numrow4)->getFont()->setSize(12);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow5, "PEMEGANG/LOKASI");
			$excel->getActiveSheet()->mergeCells('B'.$numrow5.':C'.$numrow5);
			$excel->getActiveSheet()->getStyle('B'.$numrow5)->getFont()->setSize(12);

			$result[$key] = $val;

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow5, ": ".$result[$key]['name'].'/'.$result[$key]['bidang']);

			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow7, "NO");
			$excel->getActiveSheet()->mergeCells('B'.$numrow7.':B'.$numrow8);
			$excel->getActiveSheet()->getStyle('B'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow7, "NAMA BARANG/MERK");
			$excel->getActiveSheet()->mergeCells('C'.$numrow7.':C'.$numrow8);
			$excel->getActiveSheet()->getStyle('C'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('C'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow7, "TANGGAL PERBAIKAN");
			$excel->getActiveSheet()->mergeCells('D'.$numrow7.':F'.$numrow7);
			$excel->getActiveSheet()->getStyle('D'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow8, "Tanggal");
			$excel->getActiveSheet()->getStyle('D'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow8, "Bulan");
			$excel->getActiveSheet()->getStyle('E'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow8, "Tahun");
			$excel->getActiveSheet()->getStyle('F'.$numrow8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow7, "Nama Rekanan");
			$excel->getActiveSheet()->mergeCells('G'.$numrow7.':G'.$numrow8);
			$excel->getActiveSheet()->getStyle('G'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('G'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow7, "JUMLAH (Rp)");
			$excel->getActiveSheet()->mergeCells('H'.$numrow7.':H'.$numrow8);
			$excel->getActiveSheet()->getStyle('H'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('H'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow7, "KETERANGAN\n(Jenis Service)");
			$excel->getActiveSheet()->mergeCells('I'.$numrow7.':I'.$numrow8);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('I'.$numrow7)->getAlignment()->setWrapText(true);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
			
			$nod=0;
			if($result[$key]['januari']!=null){
				if($key==0){
					$numrow91=9;	
				}
				else{
					$numrow91=$numrow9;
				}
				foreach ($result[$key]['januari'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow91, $ky+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow91, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow91, 
						substr($result[$key]['januari'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow91, 
						$result[$key]['januari'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow91, 
						$result[$key]['januari'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow91, 
						$result[$key]['januari'][$ky]['ket_servis']);

					$ky++;
					$numrow91++;
					$nod++;
				}
			}

			if($result[$key]['februari']!=null){
				if($key==0){
					if($result[$key]['januari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['februari'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['februari'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['februari'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['februari'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['februari'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['maret']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['maret'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['maret'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['maret'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['maret'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['maret'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['april']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['april'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['april'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['april'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['april'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['april'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['mei']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['mei'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['mei'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['mei'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['mei'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['mei'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['juni']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['juni'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['juni'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['juni'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['juni'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['juni'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['juli']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['juli'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['juli'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['juli'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['juli'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['juli'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['agustus']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['agustus'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['agustus'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['agustus'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['agustus'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['agustus'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['september']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['september'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['september'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['september'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['september'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['september'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['oktober']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['oktober'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['oktober'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['oktober'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['oktober'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['oktober'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['november']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['november'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['november'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['november'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['november'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['november'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}
			}

			if($result[$key]['desember']!=null){
				if($key==0){
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null
						||$result[$key]['november']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				else{
					if($result[$key]['januari']!=null
						||$result[$key]['februari']!=null
						||$result[$key]['maret']!=null
						||$result[$key]['april']!=null
						||$result[$key]['mei']!=null
						||$result[$key]['juni']!=null
						||$result[$key]['juli']!=null
						||$result[$key]['agustus']!=null
						||$result[$key]['september']!=null
						||$result[$key]['oktober']!=null
						||$result[$key]['november']!=null){
						// $ky;
						$numrow92=$numrow9+$nod;
					}
					else{
						$numrow92=$numrow9;
					}
				}
				foreach ($result[$key]['desember'] as $ky => $value) {
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow92, $nod+1);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow92, $result[$key]['merk']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 8, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 5, 2));
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow92, 
						substr($result[$key]['desember'][$ky]['tgl_servis'], 0, 4));
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow92, 
						$result[$key]['desember'][$ky]['tempat_servis']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow92, 
						$result[$key]['desember'][$ky]['biaya']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow92, 
						$result[$key]['desember'][$ky]['ket_servis']);

					// $ky++;
					$numrow92++;
					$nod++;
				}

			}

			$num9n=$numrow9+$nod;
			
			//no center
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			//nama center
			// $excel->getActiveSheet()->getStyle('C'.$numrow9.':C'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('C'.$numrow9.':C'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//tanngal
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//bulan
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//tahun
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			// $excel->getActiveSheet()->getStyle('G'.$numrow9.':G'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('G'.$numrow9.':G'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			// $excel->getActiveSheet()->getStyle('I'.$numrow9.':I'.$num9n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $excel->getActiveSheet()->getStyle('I'.$numrow9.':I'.$num9n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


			
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H'.$num9n)->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_ACCOUNTING_IDR);

			// $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow7)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow7)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('B' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow8)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow8)->applyFromArray($style_row);

			$num9n1=$num9n-1;
			$excel->getActiveSheet()->getStyle('B'.$numrow9.':B'.$num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow9.':C' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow9.':D' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow9.':E' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow9.':F' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow9.':G' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow9.':H' . $num9n1)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow9.':I' . $num9n1)->applyFromArray($style_row);

			$no++;
			$nob++;
			$numrow=$numrow+11+$nod;
			$numrow2=$numrow2+11+$nod;
			$numrow4=$numrow4+11+$nod;
			$numrow5=$numrow5+11+$nod;
			$numrow7=$numrow7+11+$nod;
			$numrow8=$numrow8+11+$nod;
			$numrow9=$numrow9+11+$nod;
			$numrow91=$numrow91+11+$nod;
			$numrow92=$numrow92+11+$nod;
			// $numrow93=$numrow93+15;
		}

		// $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
		// $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
		// $sheet = $excel->getActiveSheet();
		// foreach ($sheet->getColumnIterator() as $cols) {
		// 	$sheet->getColumnDimension($cols->getColumnIndex())->setAutoSize(true);
		// }
		// foreach (range('B', 'I') as $colidbi) {
		// 	$excel->getActiveSheet()->getColumnDimension($colidbi)->setAutoSize(true);
		// }

		// foreach (range('B', 'I') as $colidbi) {
		// 	$excel->getActiveSheet()->getColumnDimension($colidbi)->setAutoSize(false);
		// }		

		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('C')->getWidth()<21){
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
		}
		 // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		// if($excel->getActiveSheet()->getColumnDimension('G')-)
		
		// $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		// print_r($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('C'));
		// die();
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('G')->getWidth()<=14){
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		}
		// print_r($excel->getActiveSheet()->getColumnDimension('G')->getwid;
		// die();
		 // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		// print_r($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('I'));
		// die();
		if($excel->getActiveSheet()->calculateColumnWidths()->getColumnDimension('I')->getWidth()<16){
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		}


		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("TA " . $tahun);
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rincian Service Peralatan Tahun ' . $tahun . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		exit();
	}
}