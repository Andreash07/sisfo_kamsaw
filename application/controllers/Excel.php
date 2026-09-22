<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Excel extends CI_Controller {



	/**

	 * Index Page for this controller.

	 *

	 * Maps to the following URL

	 * 		http://example.com/index.php/welcome

	 *	- or -

	 * 		http://example.com/index.php/welcome/index

	 *	- or -

	 * Since this controller is set as the default controller in

	 * config/routes.php, it's displayed at http://example.com/

	 *

	 * So any other public methods not prefixed with an underscore will

	 * map to /index.php/welcome/<method_name>

	 * @see https://codeigniter.com/user_guide/general/urls.html

	 */
	public function  __construct()
    {
        parent::__construct();
        #print_r($this->session->userdata());die();
        if(!$this->session->userdata('userdata') ){
        	redirect(base_url().'login');
        }
    }

    public function index(){
    	require_once FCPATH . 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TEST EXCEL');
        $sheet->setCellValue('A2', 'PHP Version');
        $sheet->setCellValue('B2', PHP_VERSION);

        $sheet->setCellValue('A3', 'Library');
        $sheet->setCellValue('B3', 'PhpSpreadsheet 1.30.7');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $filename = 'test_excel.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        exit;
    }
}