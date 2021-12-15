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
$html = "<!DOCTYPE html><html><head><title>Contratos ProyVTA</title><style>p{font-family: 'Times New Roman';font-size: 12pt;}body{border-style: none; border-width: 2.5pt;}</style></head>";
$html = $html.'<body><br/><br/><br/><p style="font-weight: bold;text-align: right;">';
$html = $html.'&nbsp;'.$fila['CodigoInterno'].'</p>';
$html = $html."<p style='font-weight: bold;text-align: center;'>CONTRATO</p>";
$html = $html."<p>En la ciudad de ".$fila['Lugar'].", a los ".$dias." d&iacute;as del mes de ".$mes." del a&ntilde;o ".$gestion.", reunidos el (la) &nbsp;se&ntilde;or(a) ".$fila['Propietario']."C.I. No ".$fila['Cedula']." en representaci&oacute;n de Farmacia ".$fila['RazonSocial']." NIT ".$fila['NIT']." &nbsp;con domicilio legal en ".$fila['Direccion'];
$html = $html.", por una parte y el se&ntilde;or Ronald Cardozo M&aacute;rquez, C.I. 2445036 L.P. en su car&aacute;cter de representante de Prescription Data Bolivia Ltda., con domicilio legal en Av. Abd&oacute;n Saavedra No. 2180, (en adelante &ldquo;Close-Up&rdquo; y conjuntamente con el proveedor, las Partes), exponen lo siguiente:</p>";
$html = $html."<p><b>Primera. Objeto y Obligaciones</b></p>";
$html = $html."<p>1.<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>El presente Contrato tiene por objeto la provisi&oacute;n de informaci&oacute;n por Farmacia ". $fila['RazonSocial']." a Close-Up de los datos de Venta\demanda (compras realizadas a los laboratorios), productos farmac&eacute;uticos, nutricionales, conveniencia y afines. Lo que de ahora en adelante denominaremos la &quot;Informaci&oacute;n&quot;.&nbsp;</p>";
$html = $html."<p>Farmacia ".$fila['RazonSocial']." brindar&aacute; la Informaci&oacute;n en forma exclusiva a Close-Up, entendi&eacute;ndose que esta exclusividad es s&oacute;lo en relaci&oacute;n a terceros que representen competencia con los productos y servicios desarrollados y comercializados por Close-Up.</p>";
$html = $html."<p>2.<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>La Informaci&oacute;n de venta/demanda se entregar&aacute; a partir del mes de ". $mes ." de ". $gestion ." mensualmente en unidades bajo un formato est&aacute;ndar convenido mutuamente, y ser&aacute; utilizada por Close-Up, para la realizaci&oacute;n de auditor&iacute;as de datos y publicaciones de datos de ventas.</p>";
$html = $html."3.<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>Sin perjuicio de otras disposiciones contenidas en el presente Contrato, especialmente lo establecido en la presente cl&aacute;usula, las Partes se comprometen a mantener confidencialidad de toda la informaci&oacute;n proporcionada por la otra Parte, oblig&aacute;ndose a no revelar, divulgar o proporcionar dicha informaci&oacute;n confidencial de forma individual,";
$html = $html." en su totalidad o en parte a terceros, ya sea natural o  jur&iacute;dica, a excepci&oacute;n de aquellas personas que tengan necesidad de conocerlos durante el procesamiento de la informaci&oacute;n.&nbsp;</p>";
$html = $html."<p><b>Segunda. Duraci&oacute;n del Contrato</b></p>";
$html = $html."<p>1.<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>El presente contrato tendr&aacute; una duraci&oacute;n de dos (2) a&ntilde;os contados a partir de la fecha de su firma, t&eacute;rmino &eacute;ste que se entender&aacute; autom&aacute;ticamente prorrogado por igual per&iacute;odo salvo que una de las partes, mediante aviso escrito enviado con no menos de tres (3) meses de anterioridad al vencimiento del plazo ";
$html = $html."inicial del contrato o al de sus pr&oacute;rrogas, manifieste a la otra parte su intenci&oacute;n de darlo por terminado.</p>";
$html = $html."<p>2.<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>El presente Contrato podr&aacute; ser rescindido en caso de:</p>";
$html = $html."<p>-<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>el incumplimiento de cualquiera de las obligaciones estipuladas en el presente contrato dar&aacute; derecho cumplido para darlo por previa intimaci&oacute;n al cumplimiento de 15&nbsp;</p>";
$html = $html."<p>-<span style='white-space:pre;'>&nbsp; &nbsp;&nbsp;</span>(quince) d&iacute;as de aviso para que la parte incumplida lo haya subsanado. No subsanado el incumplimiento el presente Contrato terminar&aacute; en forma inmediata.</p>";
$html = $html."<p><b>Tercera. De la forma de pago</b></p>";
$html = $html."<p>Close Up pagar&aacute; en contraprestaci&oacute;n de la informaci&oacute;n que env&iacute;e el proveedor; la suma de Bs. ".$fila['Monto']." (".convertir($fila['Monto']).") mensuales.&nbsp;</p>";
$html = $html."<p>El pago se efectuar&aacute; despu&eacute;s de recibida la informaci&oacute;n, es decir el pago por la informaci&oacute;n de la edición mensual recogida se pagará en el mes siguiente.</p>";
$html = $html."<p><b>Cuarta. Cesi&oacute;n y Modificaci&oacute;n</b></p>";
$html = $html."<p>El presente contrato no podr&aacute; ser cedido ni total ni parcialmente, salvo que exista acuerdo expreso entre las partes. &nbsp;Lo mismo sucede con toda modificaci&oacute;n o adici&oacute;n a este contrato, la cual deber&aacute; hacerse por escrito y de com&uacute;n acuerdo entre ellas.</p>";
$html = $html."<p>Como constancia de lo anterior las partes suscriben el presente documento en la Ciudad de ".$fila['Lugar'].", a los ".$dias." d&iacute;as del mes de ".$mes." de ".$gestion." en dos ejemplares del mismo tenor, uno para cada una de las partes.</p>";
$html = $html."<br/><br/><br/><br/><br/>"; //<!--mpdf <center><table><tr><td>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por <b>PRESCRIPTION DATA BOLIVIA LTDA.</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por FARMACIA <b>". $fila['RazonSocial'] ."</b></p>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RONALD CARDOZO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $fila['Propietario'] ."</p>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.I. N&ordm; 2445036 LP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.I. N&ordm; ". $fila['Cedula'] ."</p>";
$html = $html."<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SELLO FARMACIA</p>";
$mpdf->WriteHTML($html);
$mpdf->Output();
