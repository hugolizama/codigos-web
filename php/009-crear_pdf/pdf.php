<?php
//agregar libreria tcpdf
require_once './tcpdf_min/tcpdf.php';

//clase para crear header y footer personalizado
class mipdf extends TCPDF{  
  //Header personalizado
  public function Header() {
    //imagen en header
    $logo = 'img/php-logo.png';
    $this->Image($logo, 25, 10, 25, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        
    $this->SetFont('helvetica', 'B', 20);
    $this->Cell(0, 0, 'Titulo de página', 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
  
  //footer personalizado
  public function Footer() {
    // posicion
    $this->SetY(-15);
    // fuente
    $this->SetFont('helvetica', 'I', 8);
    // numero de pagina
    $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}

//iniciando un nuevo pdf
$pdf = new mipdf(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);

//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);

//informacion del pdf
$pdf->SetCreator('hug0');
$pdf->SetAuthor('hug0');
$pdf->SetTitle('Ejemplo de pdf con tcpdf');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//tipo de fuente y tamanio
$pdf->SetFont('helvetica', '', 12);

//agregar pag 1
$pdf->AddPage();
$html = '
<h1>Kiuvox</h1>
<p style="font-size: 16px;">Este es un ejemplo de texto html escrito con tcpdf desde <a target="_blank" href="http://blog.kiuvox.com">blog.kiuvox.com</a></p>
';
//escribe el texto en la hoja
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


//agregar pag 2
$pdf->AddPage();
//escrite el texto en la hoja
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//terminar el pdf
$pdf->Output('kiuvox.pdf', 'I');
