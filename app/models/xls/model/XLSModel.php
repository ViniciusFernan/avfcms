<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once BASEPATH . '/lib/PhpSpreadsheet/src/PhpSpreadsheet/';
require_once BASEPATH . '/lib/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
class XLS {

    function __construct() {

    }

    /**
     * Caso Result = false, retorna a mensagem do erro
     * @return Boolean
     */
    function getError() {
        return $this->error;
    }

    private function gerarXLS($getdata)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('miraimedia.co.th')
            ->setLastModifiedBy('Cholcool')
            ->setTitle('NEW PDF GENERATOR')
            ->setSubject('Generate Excel use PhpSpreadsheet')
            ->setDescription('Export data to Excel Work for me!');

        // add style to the header
        $styleArray = array(
            'font' => array( 'bold' => true, ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
                'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array('rgb' => '0d0d0d'),
                'endColor'   => array('rgb' => 'f2f2f2'),
            ),
        );
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
        // auto fit column to content
        foreach(range('A', 'E') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        // set the names of header cells
        $sheet->setCellValue('A1', 'cep');
        $sheet->setCellValue('B1', 'logradouro');
        $sheet->setCellValue('C1', 'bairro');
        $sheet->setCellValue('D1', 'localidade');
        $sheet->setCellValue('E1', 'uf');

        // Add some data
        $x = 2;

        foreach($getdata as $get){
            $sheet->setCellValue('A'.$x, $get->cep);
            $sheet->setCellValue('B'.$x, $get->logradouro );
            $sheet->setCellValue('C'.$x, $get->bairro );
            $sheet->setCellValue('D'.$x, $get->localidade );
            $sheet->setCellValue('E'.$x, $get->uf );
            $x++;
        }


        //Create file excel.xlsx
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path().'/relatorios/cadastro.xlsx');
    }

}
