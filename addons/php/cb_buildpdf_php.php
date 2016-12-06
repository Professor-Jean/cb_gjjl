<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
									 João Santucci;
									 João Spieker;
									 Lucas Janning;
 *Data de Criação: 21/09/2016
 *Data de Modificação: 23/10/2016
 *Descrição: Esta página é responsável por realizar a construção do PDF.
 ***********************************************************************************************************************************************/

include_once("../plugins/mpdf/mpdf.php");
	
	$pdfheader = '
  <table class="header">
    <tr>
      <td><img src="../../layout/images/logo.png" width="170px"></td>
      <td align="right">Cris Blau</td>
    </tr>
  </table>
  ';
	$pdffooter = '
    <table class="footer">
      <tr>
        <td width="33%">{DATE j/m/y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" align="right">Cris Blau</td>
      </tr>
    </table>
  ';
	$pdfbody = "<div id='content'>";
	$pdfbody .= $_POST['dadospdf'];
	$pdfbody .= '</div>';
	$mpdf = new mPDF('c', 'A4', '', '', 20, 15, 48, 25, 10, 10);
	$mpdf->SetHTMLHeader($pdfheader);
	$mpdf->SetHTMLFooter($pdffooter);
	$stylesheet = file_get_contents('../../layout/css/cb_buildpdf_css.css');
	$mpdf->WriteHTML($stylesheet, 1);
	$mpdf->WriteHTML($pdfbody, 2);
	$mpdf->output();

?>