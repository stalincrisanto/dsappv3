<?php
    session_start();
    require('./fpdf.php');
    class PDF extends FPDF
    {
      function Header()
      {
          // Arial bold 15
          $this->SetFont('Arial','B',15);
          // Movernos a la derecha
          $this->Cell(60);
          // Título
          $this->Cell(70,10,'Detalle de Venta',1,0,'C');
          // Salto de línea
          $this->Ln(20);
          $this->Cell(10,10,'ID',1,0,'C',0);
          $this->Cell(70,10,'Nombre Prod',1,0,'C',0);
          $this->Cell(30,10,'Precio',1,0,'C',0);
          $this->Cell(30,10,'Cantidad',1,0,'C',0);
          $this->Cell(30,10,'Total',1,1,'C',0);
      }
      
      // Pie de página
      function Footer()
      {
          // Posición: a 1,5 cm del final
          $this->SetY(-15);
          // Arial italic 8
          $this->SetFont('Arial','I',8);
          // Número de página
          $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
      }
    }

    require 'config.php';

    $query = "SELECT * FROM carro_compra WHERE id_local='".$_SESSION['id_local']."' AND estado_vendedor='activo'";
    $resultado = mysqli_query($conexion,$query);
    $row=mysqli_fetch_assoc($resultado);

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    while($row=$resultado->fetch_assoc())
    {
        $pdf->Cell(10,10,$row['id_producto'],1,0,'C',0);
        $pdf->Cell(70,10,utf8_decode($row['nombre_producto']),1,0,'C',0);
        $pdf->Cell(30,10,$row['precio_producto'],1,0,'C',0);
        $pdf->Cell(30,10,$row['cantidad'],1,0,'C',0);
        $pdf->Cell(30,10,$row['precio_total'],1,1,'C',0); 
    }

    $pdf->Output();
  ?>