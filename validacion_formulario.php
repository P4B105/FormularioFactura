<?php
session_start();//Iniciamos le sesion del usuario
//Incluimos el vendor autoload de la carpeta vendor "autoload.php"
require_once 'vendor/autoload.php';
use setasign\Fpdi\Tcpdf\Fpdi;

//--------------------RECOLECCION DE LOS DATOS INGRESADOR POR EL USUARIO EN EL FORMULARIO--------------------
$tipo_cliente = $_POST['tipo_cliente'] ?? '';//El operador ?? evalua si el valos que se encuentra en $_POST['tipo_cliente'] es NULL, en caso de serlo el valor de $tipo_cliente sera = '' que son los ('') que estan al otro lado del operador ??
if($tipo_cliente === 'Persona'){
    $nombre_cliente = $_POST['nombre_persona'] ?? ''; // Nombre del cliente
    
}else{
    $nombre_cliente = $_POST['nombre_empresa'] ?? ''; // Nombre del cliente
}

$tipo_documento = $_POST['tipo_documento'] ?? '';
if($tipo_documento === 'Cedula'){
    $numero_documento = $_POST['numero_cedula'] ?? ''; 
}else{
    $numero_documento = $_POST['numero_rif'] ?? '';
}

$direccion = $_POST['direccion'] ?? ''; //Direccion
$prefijo_telefono = $_POST['telefono_prefijo'] ?? ''; //prefijo dle telefono
$telefono = $_POST['telefono_numero'] ?? ''; //Resto del numero telefonico
$numero_telefono = $prefijo_telefono ."-". $telefono; // Número de teléfono completo

//Datos del vehículo
$modelo_vehiculo = $_POST['modelo'] ?? '';//Modelo del vehiculo
$marca_vehiculo = $_POST['marca'] ?? ''; //Marca del vehiculo
$serial = $_POST['serial'] ?? ''; //Numero del serial

$nombre_item = $_POST['nombre_item'] ?? ''; // Nombre del item
$cantidad_item = (int)($_POST['cantidad_item'] ?? 0); // Asegurarse que sea entero
$precio_unitario = (float)($_POST['precio_unitario'] ?? 0.00); // Asegurarse que sea flotante

// Cálculo de Precios (considerando el 16% de IVA)
$subtotal_item = $cantidad_item * $precio_unitario;
$iva_porcentaje = 0.16;
$iva_monto_item = $subtotal_item * $iva_porcentaje; // Este es el monto del IVA, no el precio con IVA
$precio_con_iva_item = $subtotal_item + $iva_monto_item; // Total de ese único ítem con IVA

// Para la factura, tendremos un subtotal general, IVA general y total a pagar.
// Si solo tienes un ítem por factura:
$subtotal_general = $subtotal_item;
$iva_general = $iva_monto_item;
$total_a_pagar = $precio_con_iva_item;


// Información de la factura
$fecha_factura_str = $_POST['fecha_factura'] ?? ''; // Fecha en formato YYYY-MM-DD
$metodo_pago = $_POST['metodo_pago'] ?? ''; // Método de pago

// Extraer día, mes, año de la fecha para el PDF
$fecha_partes = explode('-', $fecha_factura_str);//La funcion explode() agarra una cadena larga de texto y la corta tomando como referencia el delimitador que se le especifica en este caso el (-)
$fecha_ano = $fecha_partes[0] ?? '';
$fecha_mes = $fecha_partes[1] ?? '';
$fecha_dia = $fecha_partes[2] ?? '';

// ALMACENAMOS TODOS LOS DATOS EN LA BASE DE DATOS
require("conexion_base.php");

//Comprueba que la conexion este abierta antes de intentar usarla
if (!$conexion){
    die("Error en la conexión a la base de datos en conexion_base.php");
}

//Usamos esta linea de codigo para enviar una consulta a la base de datos, en este caso estamos enviando los datos que el usuario ingreso
mysqli_query($conexion, "INSERT INTO formulario(nombre_cliente,numero_documento,direccion,telefono,modelo_vehiculo,marca_vehiculo,n_serial,nombre_producto,cantidad_producto,precio_unitario,precio_iva,fecha_factura,metodo_pago) VALUES ('$nombre_cliente','$numero_documento','$direccion','$numero_telefono','$modelo_vehiculo','$marca_vehiculo','$serial','$nombre_item','$cantidad_item','$precio_unitario','$iva_monto_item','$fecha_factura_str','$metodo_pago')");

//Obtiene el ultimo id_factura generado en la base de datos (Se utilizara para el N de factura)
$ultimo_id_insertado = mysqli_insert_id($conexion);

//Se cierra la conexion con la base de datos
mysqli_close($conexion);

//--------------------GENERACION DE LA FACTURA E INTEGACION DE LOS DATOS INGRESADOS POR EL USUARIO EN LA MISMA CON LIBRERIAS (FPDI/TCPDF)--------------------

//RUTA ABSOLUTA DE LA PLANTILLA PDF A USAR
$rutaDelPDF = __DIR__ . '/factura_vehiculo.pdf';

//CREACION DE INSTANCIA DE PDFI
$pdf = new Fpdi();

// Establecer algunas propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FACTURA SOBRE RUEDAS');//Nombre del autor

//Usa el ID insertado si está disponible, sino usa un '00000'
$numero_factura_para_pdf = ($ultimo_id_insertado > 0) ? str_pad($ultimo_id_insertado, 5, '0', STR_PAD_LEFT) : '00000';//Aca tenemos el operador ternario (?) que nos dice, si se cumple la condicion entre parentesis ($ultimo_id_insertado > 0) entonces se ejecutara la funcion str_pad() "Ejemplo de lo que hace el str_pad()",  str_pad(1(si el id es mayor a cero en este caso es (1)), 5, '0', STR_PAD_LEFT) -> "00001" va a rellenar el 1 con 4 (0) que son los digitos minimos que debe tener el numero de factura, lo que hace el STR_PAD_LEFT es posicionar los numeros del id a la derecha del numero y luego los '0' generados los coloca "atras" del numero. Ahora en caso de que la cndicion no se cumpla se ejecutara el codigo al otro lado de los dos puntos (:) que nos dice que la $numero_factura_para_pdf sera igual a '00000' cinco ceros. NOTA: si el numero es mas grande de 5 cifras se colocara de igual forma tal y como esta.
$pdf->SetTitle('Factura Automotriz N° ' . $numero_factura_para_pdf); 
$pdf->SetSubject('Factura de Servicio Automotriz');

//SE eliminan las cabeceras y pies de página por defecto de TCPDF
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//Se añado una pagina al pdf
$pdf->AddPage();

//Se asegura de que el archivo de la plantilla pdf a usar 'factura_vehiculo.pdf' exista y sea legible
if (!file_exists($rutaDelPDF)){
    die("Error: La plantilla PDF 'factura_vehiculo.pdf' no se encontró en " . $rutaDelPDF);
}

//Importar la primera página del PDF de plantilla
$numeroPaginas = $pdf->setSourceFile($rutaDelPDF);
$primeraPagina = $pdf->importPage(1); // Importar la primera página del PDF plantilla

//Usa la página importada como plantilla
$pdf->useTemplate($primeraPagina);

// --- Configuración para escribir texto ---
$pdf->SetFont('helvetica', '', 9); // Puedes cambiar la fuente y el tamaño
$pdf->SetTextColor(40,40,40);
//--------------------RELLENADO DE LOS DATOS POR MEDIO DE COORDENADAS--------------------

//DATOS DE LA FACTURA (ESQUINA SUPERIOR DERECHA):
//Numero de factura
$pdf->SetFont('helvetica', '', 12); // Puedes cambiar la fuente y el tamaño
$pdf->SetXY(173, 18);
$pdf->Write(0, '-'. $numero_factura_para_pdf);

// Fecha de Emisión (DIA, MES, AÑO)
//DIA
$pdf->SetFont('helvetica', '', 9); // Puedes cambiar la fuente y el tamaño
$pdf->SetXY(157, 34);
$pdf->Write(0, $fecha_dia);
//MES
$pdf->SetXY(167, 34);
$pdf->Write(0, $fecha_mes);
//AÑO
$pdf->SetXY(178, 34);
$pdf->Write(0, $fecha_ano);

//DATOS DEL CLIENTE (COLUMNA IZQUIERDA)
//NOMBRE O RAZON SOCIAL
$pdf->SetXY(38, 51.5);
$pdf->Write(0, $nombre_cliente);

//RIF O CEDULA
$pdf->SetXY(134.5, 51.5);
$pdf->Write(0, $numero_documento);

//DOMICILIO FISCAL
$pdf->SetXY(43, 61); 
$pdf->MultiCell(100, 5, $direccion, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', false);

//DATOS DEL VEHICULO (COLUMNA DERECHA)
//TELEFONO

$pdf->SetXY(15, 78);
$pdf->Write(0, $numero_telefono);

//MARCA
$pdf->SetXY(58, 78); 
$pdf->Write(0, $marca_vehiculo);

//MODELO
$pdf->SetXY(94, 78); 
$pdf->Write(0, $modelo_vehiculo);

//SERIAL
$pdf->SetXY(120, 78); 
$pdf->Write(0, $serial);

//CONDICIONES DE PAGO (Metodo de pago)
$pdf->SetXY(174, 78); 
$pdf->Write(0, $metodo_pago);


//PARTE DE LOS ITEMS (FILA)
$y_item_start = 100; // Posición Y inicial para la primera fila de ítems (Aprox. 147mm)

//PARTE DE  LOS ITEMS (COLUMNA1)
//Cantidad
$pdf->SetXY(9, $y_item_start); 
$pdf->Write(0, $cantidad_item);

//Nombre del item
$pdf->SetXY(21, $y_item_start); 
$pdf->Write(0, $nombre_item);

//Precio Unitario
$pdf->SetXY(146.5, $y_item_start); 
$pdf->Write(0, number_format($precio_unitario, 2, ',', '.')); //Aca se coloca formato de moneda

//AGREGACION DEL RECUADRO DE INFORMACION DE 16% en factura
$valor_iva = '16%';
$pdf->SetXY(167, $y_item_start);
$pdf->Write(0, $valor_iva); 

//TOTAL BS CON IVA
$pdf->SetXY(185, $y_item_start); 
$pdf->Cell(20, 0, number_format($precio_con_iva_item, 2, ',', '.'), 0, 0, 'R'); // Ancho de celda 20mm, alineado a la derecha


//RESUMEN DE LOS PRECIOS
// SUB-TOTAL Bs.
$pdf->SetXY(177, 240);
$pdf->Cell(20, 0, number_format($subtotal_general, 2, ',', '.'), 0, 0, 'R');

// IVA 16% Base Imponible Sobre Bs.
$pdf->SetXY(177, 251); 
$pdf->Cell(20, 0, number_format($iva_general, 2, ',', '.'), 0, 0, 'R');

// TOTAL A PAGAR Bs.
$pdf->SetFont('helvetica', 'B', 10); //Negrita y un poco más grande para el total
$pdf->SetXY(178, 260);
$pdf->Cell(20, 0, number_format($total_a_pagar, 2, ',', '.'), 0, 0, 'R');


//FORMA DE PAGO
$pdf->SetFont('helvetica', '', 9); // Volver a fuente normal
$pdf->SetXY(33, 251);
$pdf->Write(0, $metodo_pago);


//------------------------------RUTAS PARA EL GUARDADO DEL PDF QUE SE GENERA------------------------------
//RUTA ABSOLUTA PARA LA CARPETA DE DESTINO "facturas_generadas";
$pdfCarpeta = __DIR__ . '/facturas_generadas/';

//Verifica si la carpeta existe y si se puede escribir en ella (En caso de que no se pueda escribir en la carpeta lo mas probable es que le falten permisos de escritura)
if (!file_exists($pdfCarpeta)){
    if (!mkdir($pdfCarpeta, 0777, true)){ //Si la carpeta no existe la crea
        die("Ah ocurrido un error: No se pudo crear la carpeta de facturas: " . $pdfCarpeta);
    }
}

//NOMBRE DE LA FACTURA GENERADA
$nombrePdf = 'factura_generada_' . $numero_factura_para_pdf . '.pdf';

//ESTA ES LA RUTA COMPLETA DEL ARCHIVO PDF QUE SE GENERARA ADENTRO DE LA CARPETA "facturas_generadas"
$rutaCompletaPdfEnCarpeta = $pdfCarpeta . $nombrePdf;

//ESTA ES LA RUTA QUE DEFINE LA URL
$rutaDireccionProyectoUrl = '/clases/TAREAS/FORMULARIO/'; //Esta ruta se cambiara dependiendo de la ruta en la que se encuentre el proyecto despues de la carpeta htdocs correspondiente a xampp por ejemplo si despues de la carpeta htdocs se encuentra la siguiente ruta para llegar a la carpeta principal del proyecto seria la siguiente ruta a colocar /proyectos/proyecto_formulario

// URL web COMPLETA para acceder al PDF desde el navegador
$webUrlCompletaPdf = $rutaDireccionProyectoUrl . 'facturas_generadas/' . $nombrePdf;

//GUARDAR el PDF en el sistema de archivos
//El método Output usa la ruta del sistema de archivos: $rutaCompletaPdfEnCarpeta
$pdf->Output($rutaCompletaPdfEnCarpeta, 'F'); // 'F' para guardar el archivo en el servidor

//---------------Preparar datos para el enlace "Editar"---------------
// Recopila todos los datos que se envian de vuelta al formulario
$datos_para_editar = [
    'tipo_cliente' => $_POST['tipo_cliente'] ?? '',
    'nombre_persona' => $_POST['nombre_persona'] ?? '',
    'nombre_empresa' => $_POST['nombre_empresa'] ?? '',
    'tipo_documento' => $_POST['tipo_documento'] ?? '',
    'numero_cedula' => $_POST['numero_cedula'] ?? '',
    'numero_rif' => $_POST['numero_rif'] ?? '',
    'direccion' => $_POST['direccion'] ?? '',
    'telefono_prefijo' => $_POST['telefono_prefijo'] ?? '',
    'telefono_numero' => $_POST['telefono_numero'] ?? '',
    'modelo' => $_POST['modelo'] ?? '',
    'marca' => $_POST['marca'] ?? '',
    'serial' => $_POST['serial'] ?? '',
    'nombre_item' => $_POST['nombre_item'] ?? '',
    'cantidad_item' => $_POST['cantidad_item'] ?? '',
    'precio_unitario' => $_POST['precio_unitario'] ?? '',
    'fecha_factura' => $_POST['fecha_factura'] ?? '',
    'metodo_pago' => $_POST['metodo_pago'] ?? '',
];

// Construir la cadena de consulta URL de forma segura
$query_string_editar = http_build_query($datos_para_editar);

// Ruta al formulario principal
$ruta_formulario = 'formulario.php'; //Ruta al "formulario.php" adentro del codigo

// Construir el enlace completo para editar
$enlace_editar = $ruta_formulario . '?' . $query_string_editar;//El signo de interrogacion indica en donde inicia la cadena de consulta que es "$query_string_editar"

//MOSTRAMOS LA PAGINA HTML
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Datos recibidos y Factura Generada</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <header>
        <div class='div-header-division-imagen'>
            <img src='carro.png' alt='imagen de logo' class='img-logo'>
            <h2>FACTURA SOBRE RUEDAS</h2>
        </div>
        <div class='div-header-division-texto'>
            <p>Inicio</p>
            <p>Registrarse</p>
            <p>Formulario</p>
        </div>
    </header>
    <h3>$nombre_cliente. Ingreso los siguientes datos</h3>
    <div class='div-tabla'>
        <table border='1' class='mi-tabla'>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Tipo Cliente</td><td>$tipo_cliente</td></tr>
            <tr><td>Nombre Cliente</td><td>$nombre_cliente</td></tr>
            <tr><td>Tipo Documento</td><td>$tipo_documento</td></tr>
            <tr><td>Número Documento</td><td>$numero_documento</td></tr>
            <tr><td>Dirección</td><td>$direccion</td></tr>
            <tr><td>Número de teléfono</td><td>$numero_telefono</td></tr>
            <tr><td>Modelo del vehículo</td><td>$modelo_vehiculo</td></tr>
            <tr><td>Nombre de la marca</td><td>$marca_vehiculo</td></tr>
            <tr><td>N° de serial</td><td>$serial</td></tr>
            <tr><td>Nombre del ítem</td><td>$nombre_item</td></tr>
            <tr><td>Cantidad</td><td>$cantidad_item</td></tr>
            <tr><td>Precio unitario BS.</td><td>" . number_format($precio_unitario, 2, ',', '.') ." BS.". "</td></tr>
            <tr><td>IVA (Monto)</td><td>" . number_format($iva_monto_item, 2, ',', '.') ." BS.". "</td></tr>
            <tr><td>Fecha de la factura</td><td>$fecha_factura_str</td></tr>
            <tr><td>Método de pago</td><td>$metodo_pago</td></tr>
            <tr><td>PRECIO TOTAL BS.</td><td>" . number_format($precio_con_iva_item, 2, ',', '.') ." BS."."</td></tr>
        </tbody>
    </table>
    </div>
    
    <br>
    <p>¡La factura ha sido generada exitosamente!</p>
    <p>Puedes ver o <a href='" . htmlspecialchars($webUrlCompletaPdf) . "' target='_blank'>descargar la factura aquí</a>.</p>
    <p class='ultimo-p'>Si desea cambiar algún dato puede dar<a href='" . htmlspecialchars($enlace_editar) . "'> click aquí para modificar sus datos</a></p>
</body>
</html>";

/*
// Código de sesión, si lo usas, debería ir aquí o al principio
if (!isset($_SESSION['usuario'])) {
    session_unset();
    session_destroy();
    header('Location: index.html');
    exit;
}
*/
?>