<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once "conversor.php";

$mysqli = new mysqli('localhost', 'root', '', 'mpacontract');
if ($mysqli->connect_errno) {
    echo 'Falló la conexión: ' . $mysqli->connect_errno . ' - ' . $mysqli->connect_error;
}
$valor = $_GET['value'];
$resultado = $mysqli->query('SELECT * FROM vencimientos WHERE CodContrato ='.$valor);
$num_fila = $resultado->num_rows - 1;
$resultado->data_seek($num_fila);
$fila = $resultado->fetch_assoc(); //substr(string $string, int $start, int $length = ?)
$dias = substr($fila['Fecha'],8,2);
$vmes = substr($fila['Fecha'],5,2);
$mes = ($vmes=='01'?'enero':($vmes=='02'?'febrero':($vmes=='03'?'marzo':($vmes=='04'?'abril':''))));
$mes = ($vmes=='05'?'mayo':($vmes=='06'?'junio':($vmes=='07'?'julio':($vmes=='08'?'agosto':$mes))));
$mes = ($vmes=='09'?'septiembre':($vmes=='10'?'octubre':($vmes=='11'?'noviembre':($vmes=='12'?'diciembre':$mes))));
$gestion = substr($fila['Fecha'],0,4);

$mpdf = new \Mpdf\Mpdf();
$html = "<!DOCTYPE html><html><head><title>Contrato RxS</title><style>p{font-family: 'Times New Roman';font-size: 12pt;}body{border-style: none; border-width: 2.5pt;}</style></head>";
$html = $html.'<body><br/><br/><br/><p style="font-weight: bold;text-align: right;">';
$html = $html.'&nbsp;'.$fila['CodigoInterno'].'</p>';
$html = $html."<p style='font-weight: bold;text-align: center;'>CONTRATO</p>";
$html = $html."<p>En la ciudad de". $fila['Lugar'] .", a los ". $dias." días del mes de ". $mes." de ". $gestion.", reunidos el se&ntilde;or. Ronald Cardozo, con C.I. No. 2445036 LP, en representaci&oacute;n de PRESCRIPTION DATA BOLIVIA LTDA., ubicada en la Av. Abd&oacute;n Saavedra No. 2180, y por otra parte el(la) se&ntilde;or(a)";
$html = $html. $fila['Propietario'] .", con C.I. No. ". $fila['Cedula'] .", en representaci&oacute;n de Farmacia ". $fila['RazonSocial'] .", firman el siguiente contrato bajo las clausulas que se mencionan a continuaci&oacute;n:</p>";
$html = $html."<p>1)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Que Prescription Data Bolivia es una empresa que se dedica a la auditoria de recetas para el mercado farmac&eacute;utico boliviano y que sus auditorias no incluyen ni identifican a las farmacias que nos dan fuentes de informaci&oacute;n.</p>";
$html = $html."<p>2)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Que el(la) se&ntilde;or(a) ". $fila['Propietario'] .", por su tarea comercial posee informaci&oacute;n de recetas m&eacute;dicas, &uacute;tiles para las auditorias que desarrolla Prescription Data Bolivia.</p>";
$html = $html."<p>3)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Que la informaci&oacute;n que recibe Prescription Data Bolivia, es utilizada &uacute;nicamente para sus auditorias del mercado farmac&eacute;utico, manteniendo la total confidencialidad sobre el origen y exclusividad de la misma.</p>";
$html = $html."<p>4)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Por el motivo, ambas partes y de com&uacute;n acuerdo convienen lo siguiente:</p>";
$html = $html."<p>a)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Prescription Data Bolivia, se compromete a pagar la suma de Bs. ".$fila['Monto']." (".convertir($fila['Monto']).") por receta escaneada, con un m&aacute;ximo de 500 fotocopias mensuales, y que no se encuentren dentro los par&aacute;metros de desechos (adjunto cuadro); y que contengan los siguientes datos:</p>";
$html = $html."<p>Apellidos y nombre del m&eacute;dico.</p>";
$html = $html."<p>Direcci&oacute;n del consultorio del medico</p>";
$html = $html."<p>Matr&iacute;cula del medico</p>";
$html = $html."<p>Nombre del producto&nbsp;</p>";
$html = $html."<p>Cantidad.</p>";
$html = $html."<p>D&iacute;a, mes y a&ntilde;o.</p>";
$html = $html."<p>b)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Farmacia ". $fila['RazonSocial']  ." deber&aacute; enviar v&iacute;a e-mail o en la forma que el proveedor disponga al funcionario de Prescription Data Bolivia las recetas escaneadas obtenidas una vez por semana conforme a un formulario de control.</p>";
$html = $html."<p>c)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Farmacia ". $fila['RazonSocial']  ." brindar&aacute; en forma exclusiva a Prescription Data Bolivia las informaciones correspondientes a las recetas m&eacute;dicas, entendi&eacute;ndose que la exclusividad se refiere a cualquier m&eacute;todo de captaci&oacute;n y es en relaci&oacute;n a toda empresa o persona f&iacute;sica que represente competencia de las actividades de Prescription Data Bolivia (informaciones y auditorias de prescripciones m&eacute;dicas del mercado farmac&eacute;utico)&nbsp;</p>";
$html = $html."<p>d)<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Que el presente convenio tendr&aacute; una duraci&oacute;n de 12 meses a partir de la fecha y ser&aacute; renovado autom&aacute;ticamente salvo que una de las partes decida lo contrario, lo que deber&aacute; ser informado por escrito a la otra con tres meses de anticipaci&oacute;n a su vencimiento.</p>";
$html = $html."<p>En se&ntilde;al de conformidad a las clausulas anteriormente expuestas se firman dos ejemplares, a los ".$dias." d&iacute;as del mes de ".$mes." de ".$gestion." en la ciudad de ".$fila['Lugar'].".</p>";

$html = $html."<br/><br/><br/><br/><br/>"; //<!--mpdf <center><table><tr><td>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por <b>PRESCRIPTION DATA BOLIVIA LTDA.</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por <b>FARMACIA ". $fila['RazonSocial'] ."</b></p>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RONALD CARDOZO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $fila['Propietario'] ."</p>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.I. N&ordm; 2445036 LP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.I. N&ordm; ". $fila['Cedula'] ."</p>";
$html = $html."</body></html>";
$mpdf->WriteHTML($html);
$mpdf->Output();
