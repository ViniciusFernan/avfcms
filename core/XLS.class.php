<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once 'plugins/PhpSpreadsheet/src/PhpSpreadsheet/';
require_once 'plugins/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
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

    public function gerarPDF() {

        try{
            $dompdf = new Dompdf();

            $dompdf->loadHtml('<h1>TESTE PDF</h1>');

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();

        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
