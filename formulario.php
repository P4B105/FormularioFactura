<?php 
//FUNCION PARA PODER PRECARGAR EL VALO DE LOS INPUTS
function get_prefilled_value($param_name){
    if (isset($_GET[$param_name])){
        // Usa htmlspecialchars para escapar el valor antes de insertarlo en el HTML
        return htmlspecialchars($_GET[$param_name]);
    }
    return '';
}

//FUNCION PARA PODER PRECARGAR EL VALOR DE LOS SELECT
function get_selected_option($param_name, $option_value) {
    if (isset($_GET[$param_name]) && $_GET[$param_name] === $option_value) {
        return 'selected';
    }
    return '';
}

$formulario = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body-formulario">

    <header>
        <div class="div-header-division-imagen">
            <img src="carro.png" alt="imagen de logo" class="img-logo"> 
            <h2>FACTURA SOBRE RUEDAS</h2>
        </div>
        <div class="div-header-division-texto">
            <p>Inicio</p>
            <p>Registrarse</p>
            <p>Formulario</p>
        </div>
    </header>

    <form action="validacion_formulario.php" method="post">

        <h2 class="titulo-formulario">FORMULARIO DE FACTURACION</h2>

        <fieldset class="fieldset-formulario"><!--INICIO FIELDSET-->
            <!--DATOS DEL CLIENTE-->
            <!--Nombre del cliente-->
            <label for="tipo_cliente" class="label-formulario">Nombre del cliente</label>
            <div class="nombre-razonSocial-flex">
                <select name="tipo_cliente" id="tipo_cliente" class="select-formulario select-nombre" onchange="mostrarCampoNombre()">
                    <option value="Persona" ' . get_selected_option('tipo_cliente', 'Persona') . ' class="option-formulario">Persona</option>
                    <option value="Empresa" ' . get_selected_option('tipo_cliente', 'Empresa') . ' class="option-formulario">Empresa</option>
                </select>
                <input placeholder="Ingrese su nombre" type="text" class="input-formulario input-nombreP" name="nombre_persona" id="nombre_persona" value="' . get_prefilled_value('nombre_persona') . '">
                <span class="select-mensaje-error" id="error_nombre_persona"></span>
                
                <input placeholder="Ingrese el nombre de la empresa" type="text" class="input-formulario input-nombreE" name="nombre_empresa" id="nombre_empresa" style="display: none;" value="' . get_prefilled_value('nombre_empresa') . '">
                <span class="select-mensaje-error" id="error_nombre_empresa"></span>
            </div>
            <!--Numero del codumento-->
            <label for="tipo_documento" class="label-formulario">Numero del documento</label>
            <div class="numero-documento-flex">
                <select name="tipo_documento" id="tipo_documento" class="select-formulario select-documento" onchange="mostrarCampoDocumento()">
                    <option value="Cedula" ' . get_selected_option('tipo_documento', 'Cedula') . ' class="option-formulario">Cédula</option>
                    <option value="Rif" ' . get_selected_option('tipo_documento', 'Rif') . ' class="option-formulario">Rif</option>
                </select>
                <input placeholder="Ingrese su cedula (Ej V-12345678)" type="text" class="input-formulario input-cedula" name="numero_cedula" id="cedula_cliente" value="' . get_prefilled_value('numero_cedula') . '">
                <span class="select-mensaje-error" id="error_cedula_cliente"></span>
                
                <input placeholder="Ingrese el rif (J-12345678-9)" type="text" class="input-formulario input-rif" name="numero_rif" id="rif_cliente" style="display: none;" value="' . get_prefilled_value('numero_rif') . '">
                <span class="select-mensaje-error" id="error_rif_cliente"></span>
            </div>
            <!--Direccion-->
            <label class="label-formulario">Dirección</label>
            <input placeholder="Ingrese su direccion completa (Pais, Codigo Postal, Estado o Provincia, Ciudad, etc...)" type="text" class="input-formulario" name="direccion" id="direccion" value="' . get_prefilled_value('direccion') . '">
            <span class="mensaje-error" id="error_direccion"></span>
            <!--Numero de telefono-->
            <label for="telefono" class="label-formulario">Número de teléfono</label>
            <div class="telefono-flex">
                <select name="telefono_prefijo" id="telefono" class="select-formulario select-telefono">
                    <option value="0412" ' . get_selected_option('telefono_prefijo', '0412') . ' class="option-formulario">0412</option>
                    <option value="0414" ' . get_selected_option('telefono_prefijo', '0414') . ' class="option-formulario">0414</option>
                    <option value="0416" ' . get_selected_option('telefono_prefijo', '0416') . ' class="option-formulario">0416</option>
                    <option value="0424" ' . get_selected_option('telefono_prefijo', '0424') . ' class="option-formulario">0424</option>
                    <option value="0426" ' . get_selected_option('telefono_prefijo', '0426') . ' class="option-formulario">0426</option>
                    <option value="0422" ' . get_selected_option('telefono_prefijo', '0422') . ' class="option-formulario">0422</option>
                    <option value="0212" ' . get_selected_option('telefono_prefijo', '0212') . ' class="option-formulario">0212</option>
                </select>
                <input placeholder="Ingrese el numero de telefono (1234567)" type="text" class="input-formulario input-telefono" name="telefono_numero" id="telefono_numero" value="' . get_prefilled_value('telefono_numero') . '">
                <span class="select-mensaje-error" id="error_telefono_numero"></span>
            </div>

            <!--DATOS DEL VEHICULO-->
            <!--Modelo del vehiculo-->
            <label class="label-formulario">Modelo</label>
            <input placeholder="Ingrese el modelo del vehículo" type="text" class="input-formulario" name="modelo" id="modelo" value="' . get_prefilled_value('modelo') . '">
            <span class="mensaje-error" id="error_modelo"></span>
            <!--Marca del vehiculo-->
            <label class="label-formulario">Marca</label>
            <input placeholder="Ingrese la marca del vehículo" type="text" class="input-formulario" name="marca" id="marca" value="' . get_prefilled_value('marca') . '">
            <span class="mensaje-error" id="error_marca"></span>
            <!--Serial-->
            <label class="label-formulario">Serial</label>
            <input placeholder="Ingrese el numero serial del vehículo" type="text" class="input-formulario" name="serial" id="serial" value="' . get_prefilled_value('serial') . '">
            <span class="mensaje-error" id="error_serial"></span>

            <!--ITEMS-->
            <!--Nombre del item-->
            <label class="label-formulario">Nombre item</label>
            <input placeholder="Ingrese el nombre del item" type="text" class="input-formulario" name="nombre_item" id="nombre_item" value="' . get_prefilled_value('nombre_item') . '">
            <span class="mensaje-error" id="error_nombre_item"></span>
                <!--Cantidad de items-->
            <label class="label-formulario">Cantidad</label>
            <input placeholder="Ingrese la cantidad del item" type="text" class="input-formulario" name="cantidad_item" id="cantidad_item" value="' . get_prefilled_value('cantidad_item') . '">
            <span class="mensaje-error" id="error_cantidad_item"></span>
            <!--Precio unitario-->
            <label class="label-formulario">Precio unitario</label>
            <input placeholder="Ingrese el precio unitario en (BS.) correspondiente al item (El 16% IVA se suma automaticamente en factura)" type="text" class="input-formulario" name="precio_unitario" id="precio_unitario" value="' . get_prefilled_value('precio_unitario') . '">
            <span class="mensaje-error" id="error_precio_unitario"></span>

            <!--INFORMACION DE LA FACTURA-->
            <!--Fecha fe la factura-->
            <label class="label-formulario">Fecha de factura</label>
            <input type="date" class="input-date-formulario" name="fecha_factura" id="fecha_factura" value="' . get_prefilled_value('fecha_factura') . '">
            <!--Metodo de pago-->
            <label class="label-formulario">Metodo de pago</label>
            <select class="select-formulario" name="metodo_pago" id="metodo_pago">
                <option value="Efectivo" ' . get_selected_option('metodo_pago', 'Efectivo') . ' class="option-formulario">Efectivo</option>
                <option value="Debito" ' . get_selected_option('metodo_pago', 'Debito') . ' class="option-formulario">Débito</option>
                <option value="Credito" ' . get_selected_option('metodo_pago', 'Credito') . ' class="option-formulario">Crédito</option>
                <option value="Transferencia" ' . get_selected_option('metodo_pago', 'Transferencia') . ' class="option-formulario">transferencia</option>
                <option value="Cheque" ' . get_selected_option('metodo_pago', 'Cheque') . ' class="option-formulario">Cheque</option>
                <option value="Pago movil" ' . get_selected_option('metodo_pago', 'Pago movil') . ' class="option-formulario">Pago movil</option>
                <option value="Paypal" ' . get_selected_option('metodo_pago', 'Paypal') . ' class="option-formulario">Paypal</option>
            </select>
        </fieldset><!--FIN FIELDSET-->

        <input type="submit" class="boton-formulario" id="boton">
    </form>

<!------------------------------------------------------POR ACA ESTA TODO EL CODIGO JAVASCRIPT------------------------------------------------------->
    <script>

        //VALIDACIONES
        //var validar_letras = /^[a-zA-Z ]+$/;
        //var validar_numeros = /^[0-9]+$/;
        //var validar_correo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //var validar_letras_numeros = /^[a-zA-Z0-9]+$/;

/*---------------------------------------FUNCION PARA VALIDAR LOS DATOS INGRESADOS EN EL FORMULARIO------------------------------------------------*/

/*----------VALIDAR LOS DIAS DEL CALENDARIO----------*/
document.addEventListener("DOMContentLoaded", (event) => {
    // (Permite elegir solo hasta la fecha actual (hoy))
    const today = new Date();
    const year = today.getFullYear();
    let month = today.getMonth() + 1; // Months start at 0!
    let day = today.getDate();

    if (day < 10) day = "0" + day;
    if (month < 10) month = "0" + month;

    const formattedToday = year + "-" + month + "-" + day;
    document.getElementById("fecha_factura").setAttribute("max", formattedToday);

    // Inicializa los estados de los campos al cargar la página (muestra el campo correcto)
    // Llama a las funciones sin forzar el borrado si ya hay valores por GET
    mostrarCampoNombre(true); // Pasar true para indicar que es la carga inicial
    mostrarCampoDocumento(true); // Pasar true para indicar que es la carga inicial

    // Función genérica para mostrar/ocultar errores
    function mostrarError(inputElement, errorSpanElement, mensaje) {
        if (mensaje) {
            errorSpanElement.textContent = mensaje;
            inputElement.classList.add("is-invalid");
            inputElement.classList.remove("is-valid");
        } else {
            errorSpanElement.textContent = "";
            inputElement.classList.remove("is-invalid");
            inputElement.classList.add("is-valid"); // Opcional: añadir clase de válido
        }
    }

    // --- Validación para Nombre/Razón Social (Persona/Empresa) ---
    const tipoClienteSelect = document.getElementById("tipo_cliente");
    const nombrePersonaInput = document.getElementById("nombre_persona");
    const nombreEmpresaInput = document.getElementById("nombre_empresa");
    // Selecciona por ID directo del span
    const errorNombrePersonaSpan = document.getElementById("error_nombre_persona");
    const errorNombreEmpresaSpan = document.getElementById("error_nombre_empresa");

    function validateNombreCliente() {
        let currentInput;
        let currentErrorSpan;
        let nombre;

        if (tipoClienteSelect.value === "Persona" && nombrePersonaInput.style.display !== "none") {
            currentInput = nombrePersonaInput;
            currentErrorSpan = errorNombrePersonaSpan;
            nombre = nombrePersonaInput.value.trim();
        } else if (tipoClienteSelect.value === "Empresa" && nombreEmpresaInput.style.display !== "none") {
            currentInput = nombreEmpresaInput;
            currentErrorSpan = errorNombreEmpresaSpan;
            nombre = nombreEmpresaInput.value.trim();
        } else {
            // Asegurarse de limpiar errores si los campos se ocultan
            if (nombrePersonaInput && errorNombrePersonaSpan) mostrarError(nombrePersonaInput, errorNombrePersonaSpan, "");
            if (nombreEmpresaInput && errorNombreEmpresaSpan) mostrarError(nombreEmpresaInput, errorNombreEmpresaSpan, "");
            return;
        }

        if (nombre.length === 0) {
            mostrarError(currentInput, currentErrorSpan, "Este campo no puede estar vacío.");
        } else if (!/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚüÜ]+$/.test(nombre)) { // Solo letras y espacios
            mostrarError(currentInput, currentErrorSpan, "Solo se permiten letras y espacios.");
        } else {
            mostrarError(currentInput, currentErrorSpan, "");
        }
    }

    nombrePersonaInput.addEventListener("input", validateNombreCliente);
    nombrePersonaInput.addEventListener("blur", validateNombreCliente);
    nombreEmpresaInput.addEventListener("input", validateNombreCliente);
    nombreEmpresaInput.addEventListener("blur", validateNombreCliente);
    tipoClienteSelect.addEventListener("change", () => {
        mostrarCampoNombre(false); // Pasar false para indicar que NO es la carga inicial
        validateNombreCliente();
    });

    // --- Validación para RIF/Cédula ---
    const tipoDocumentoSelect = document.getElementById("tipo_documento");
    const cedulaClienteInput = document.getElementById("cedula_cliente");
    const rifClienteInput = document.getElementById("rif_cliente");
    // Selecciona por ID directo del span
    const errorCedulaClienteSpan = document.getElementById("error_cedula_cliente");
    const errorRifClienteSpan = document.getElementById("error_rif_cliente");

    function validateDocumentoCliente() {
        let currentInput;
        let currentErrorSpan;
        let documento;
        let tipoDoc;

        // Corregidos los valores "cedula" y "rif" a "Cedula" y "Rif" para que coincidan con los options del select
        if (tipoDocumentoSelect.value === "Cedula" && cedulaClienteInput.style.display !== "none") { 
            currentInput = cedulaClienteInput;
            currentErrorSpan = errorCedulaClienteSpan;
            documento = cedulaClienteInput.value.trim().toUpperCase();
            tipoDoc = "cedula";
        } else if (tipoDocumentoSelect.value === "Rif" && rifClienteInput.style.display !== "none") { 
            currentInput = rifClienteInput;
            currentErrorSpan = errorRifClienteSpan;
            documento = rifClienteInput.value.trim().toUpperCase();
            tipoDoc = "rif";
        } else {
            // Asegurarse de limpiar errores si los campos se ocultan
            if (cedulaClienteInput && errorCedulaClienteSpan) mostrarError(cedulaClienteInput, errorCedulaClienteSpan, "");
            if (rifClienteInput && errorRifClienteSpan) mostrarError(rifClienteInput, errorRifClienteSpan, "");
            return;
        }

        if (documento.length === 0) {
            mostrarError(currentInput, currentErrorSpan, "Este campo no puede estar vacío.");
        } else {
            if (tipoDoc === "cedula") {
                const cedulaPattern = /^[VE]-\d{7,10}$/i; // V/E (case insensitive), guion, 7 a 10 dígitos
                if (!cedulaPattern.test(documento)) {
                    mostrarError(currentInput, currentErrorSpan, "Formato Cédula inválido (Ej: V-12345678).");
                } else {
                    mostrarError(currentInput, currentErrorSpan, "");
                }
            } else if (tipoDoc === "rif") {
                const rifPattern = /^[JCEGPV]-\d{7,10}(-\d)?$/i; // Letra, guion, 7-10 dígitos, opcional -dígito final
                if (!rifPattern.test(documento)) {
                    mostrarError(currentInput, currentErrorSpan, "Formato RIF inválido (Ej: J-123456789 o J-12345678-0).");
                } else {
                    mostrarError(currentInput, currentErrorSpan, "");
                }
            }
        }
    }

    cedulaClienteInput.addEventListener("input", validateDocumentoCliente);
    cedulaClienteInput.addEventListener("blur", validateDocumentoCliente);
    rifClienteInput.addEventListener("input", validateDocumentoCliente);
    rifClienteInput.addEventListener("blur", validateDocumentoCliente);
    tipoDocumentoSelect.addEventListener("change", () => {
        mostrarCampoDocumento(false); // Pasar false para indicar que NO es la carga inicial
        validateDocumentoCliente();
    });


    // --- Validación para Dirección ---
    const direccionInput = document.getElementById("direccion");
    // Selecciona por ID directo del span
    const errorDireccionSpan = document.getElementById("error_direccion");

    function validateDireccion() {
        const direccion = direccionInput.value.trim();
        if (direccion.length === 0) {
            mostrarError(direccionInput, errorDireccionSpan, "Este campo no puede estar vacío.");
        } else if (!/^[a-zA-Z0-9\s.,ñÑáéíóúÁÉÍÓÚüÜ]+$/.test(direccion)) { // Letras, números, espacios, punto y coma
            mostrarError(direccionInput, errorDireccionSpan, "Solo se permiten letras, números, espacios, puntos y comas.");
        } else if (direccion.length > 70) {
            mostrarError(direccionInput, errorDireccionSpan, "Máximo 70 caracteres.");
        } else {
            mostrarError(direccionInput, errorDireccionSpan, "");
        }
    }
    direccionInput.addEventListener("input", validateDireccion);
    direccionInput.addEventListener("blur", validateDireccion);

    // --- Validación para Teléfono ---
    const telefonoSelect = document.getElementById("telefono");
    const telefonoNumeroInput = document.getElementById("telefono_numero");
    // Selecciona por ID directo del span
    const errorTelefonoSpan = document.getElementById("error_telefono_numero");

    function validateTelefono() {
        const numero = telefonoNumeroInput.value.trim();

        let isValid = false;
        let errorMessage = "";

        if (numero.length === 0) {
            errorMessage = "Este campo no puede estar vacío.";
        } else if (!/^\d{7}$/.test(numero)) { // Solo acepta exactamente 7 dígitos.
            errorMessage = "El número de teléfono debe tener exactamente 7 dígitos y no debe contener guiones.";
        } else {
            isValid = true;
        }

        if (isValid) {
            mostrarError(telefonoNumeroInput, errorTelefonoSpan, "");
        } else {
            mostrarError(telefonoNumeroInput, errorTelefonoSpan, errorMessage);
        }
    }
    telefonoNumeroInput.addEventListener("input", validateTelefono);
    telefonoNumeroInput.addEventListener("blur", validateTelefono);
    telefonoSelect.addEventListener("change", validateTelefono); // Se mantiene el listener por si el prefijo afecta algo visual, aunque no valida el número en sí con el prefijo.


    // --- Validación para Modelo de Vehículo ---
    const modeloInput = document.getElementById("modelo");
    // Selecciona por ID directo del span
    const errorModeloSpan = document.getElementById("error_modelo");

    function validateModelo() {
        const modelo = modeloInput.value.trim();
        if (modelo.length === 0) {
            mostrarError(modeloInput, errorModeloSpan, "Este campo no puede estar vacío.");
        } else if (!/^[a-zA-Z0-9\sñÑáéíóúÁÉÍÓÚüÜ]+$/.test(modelo)) { // Letras y números
            mostrarError(modeloInput, errorModeloSpan, "Solo se permiten letras, números y espacios.");
        } else if (modelo.length > 20) {
            mostrarError(modeloInput, errorModeloSpan, "Máximo 20 caracteres.");
        } else {
            mostrarError(modeloInput, errorModeloSpan, "");
        }
    }
    modeloInput.addEventListener("input", validateModelo);
    modeloInput.addEventListener("blur", validateModelo);

    // --- Validación para Marca de Vehículo ---
    const marcaInput = document.getElementById("marca");
    // Selecciona por ID directo del span
    const errorMarcaSpan = document.getElementById("error_marca");

    function validateMarca() {
        const marca = marcaInput.value.trim();
        if (marca.length === 0) {
            mostrarError(marcaInput, errorMarcaSpan, "Este campo no puede estar vacío.");
        } else if (!/^[a-zA-Z0-9\sñÑáéíóúÁÉÍÓÚüÜ]+$/.test(marca)) { // Letras y números
            mostrarError(marcaInput, errorMarcaSpan, "Solo se permiten letras, números y espacios.");
        } else if (marca.length > 20) {
            mostrarError(marcaInput, errorMarcaSpan, "Máximo 20 caracteres.");
        } else {
            mostrarError(marcaInput, errorMarcaSpan, "");
        }
    }
    marcaInput.addEventListener("input", validateMarca);
    marcaInput.addEventListener("blur", validateMarca);

    // --- Validación para Serial de Vehículo ---
    const serialInput = document.getElementById("serial");
    // Selecciona por ID directo del span
    const errorSerialSpan = document.getElementById("error_serial");

    function validateSerial() {
        const serial = serialInput.value.trim();
        if (serial.length === 0) {
            mostrarError(serialInput, errorSerialSpan, "Este campo no puede estar vacío.");
        } else if (!/^\d{17}$/.test(serial)) { // Exactamente 17 dígitos
            mostrarError(serialInput, errorSerialSpan, "El serial debe tener exactamente 17 dígitos y ser solo números.");
        } else {
            mostrarError(serialInput, errorSerialSpan, "");
        }
    }
    serialInput.addEventListener("input", validateSerial);
    serialInput.addEventListener("blur", validateSerial);

    // --- Validación para Nombre de Ítem ---
    const nombreItemInput = document.getElementById("nombre_item");
    // Selecciona por ID directo del span
    const errorNombreItemSpan = document.getElementById("error_nombre_item");

    function validateNombreItem() {
        const nombreItem = nombreItemInput.value.trim();
        if (nombreItem.length === 0) {
            mostrarError(nombreItemInput, errorNombreItemSpan, "Este campo no puede estar vacío.");
        } else if (!/^[a-zA-Z0-9\s.ñÑáéíóúÁÉÍÓÚüÜ]+$/.test(nombreItem)) { // Letras, números, espacios y punto
            mostrarError(nombreItemInput, errorNombreItemSpan, "Solo se permiten letras, números, espacios y puntos.");
        } else if (nombreItem.length > 26) {
            mostrarError(nombreItemInput, errorNombreItemSpan, "Máximo 26 caracteres.");
        } else {
            mostrarError(nombreItemInput, errorNombreItemSpan, "");
        }
    }
    nombreItemInput.addEventListener("input", validateNombreItem);
    nombreItemInput.addEventListener("blur", validateNombreItem);

    // --- Validación para Cantidad de Ítem ---
    const cantidadItemInput = document.getElementById("cantidad_item");
    // Selecciona por ID directo del span
    const errorCantidadItemSpan = document.getElementById("error_cantidad_item");

    function validateCantidadItem() {
        const cantidad = cantidadItemInput.value.trim();
        if (cantidad.length === 0) {
            mostrarError(cantidadItemInput, errorCantidadItemSpan, "Este campo no puede estar vacío.");
        } else if (!/^\d+$/.test(cantidad)) { // Solo números
            mostrarError(cantidadItemInput, errorCantidadItemSpan, "Solo se permiten números enteros.");
        } else if (cantidad.length > 3) {
            mostrarError(cantidadItemInput, errorCantidadItemSpan, "Máximo 3 dígitos.");
        } else if (parseInt(cantidad, 10) <= 0) { // No permitir 0 o negativos
            mostrarError(cantidadItemInput, errorCantidadItemSpan, "La cantidad debe ser un número positivo.");
        }
        else {
            mostrarError(cantidadItemInput, errorCantidadItemSpan, "");
        }
    }
    cantidadItemInput.addEventListener("input", validateCantidadItem);
    cantidadItemInput.addEventListener("blur", validateCantidadItem);

    // --- Validación para Precio Unitario ---
    const precioUnitarioInput = document.getElementById("precio_unitario");
    // Selecciona por ID directo del span
    const errorPrecioUnitarioSpan = document.getElementById("error_precio_unitario");

    function validatePrecioUnitario() {
        const precio = precioUnitarioInput.value.trim();
        // Permite números (enteros o decimales con punto), con un máximo de 12 caracteres
        if (precio.length === 0) {
            mostrarError(precioUnitarioInput, errorPrecioUnitarioSpan, "Este campo no puede estar vacío.");
        } else if (!/^\d+(\.\d+)?$/.test(precio)) { // Números enteros o decimales con punto
            mostrarError(precioUnitarioInput, errorPrecioUnitarioSpan, "Solo se permiten números (ej. 100.50).");
        } else if (precio.length > 6) {
            mostrarError(precioUnitarioInput, errorPrecioUnitarioSpan, "Máximo 6 caracteres.");
        } else if (parseFloat(precio) <= 0) { // No permitir 0 o negativos
            mostrarError(precioUnitarioInput, errorPrecioUnitarioSpan, "El precio debe ser un número positivo.");
        }
        else {
            mostrarError(precioUnitarioInput, errorPrecioUnitarioSpan, "");
        }
    }
    precioUnitarioInput.addEventListener("input", validatePrecioUnitario);
    precioUnitarioInput.addEventListener("blur", validatePrecioUnitario);

        // --- Validación al enviar el formulario (final) ---
    const formulario = document.querySelector("form");
    formulario.addEventListener("submit", (event) => {
        // Disparar la validación para todos los campos antes de enviar
        validateNombreCliente();
        validateDocumentoCliente();
        validateDireccion();
        validateTelefono();
        validateModelo();
        validateMarca();
        validateSerial();
        validateNombreItem();
        validateCantidadItem();
        validatePrecioUnitario();

        // Verificar si hay algún campo inválido antes de permitir el envío
        const hayErrores = document.querySelectorAll(".is-invalid").length > 0;
        if (hayErrores) {
            event.preventDefault(); // Detener el envío del formulario
            // Opcional: enfocar el primer campo con error para mejor UX
            const primerError = document.querySelector(".is-invalid");
            if (primerError) {
                primerError.focus();
            }
            alert("Por favor, corrige los errores en el formulario antes de enviar.");
        }
        // Si no hay errores, el formulario se enviará de forma predeterminada
        // porque preventDefault() no fue llamado.
    });
}); // Cierre de DOMContentLoaded

//----------------------------------------FUNCIONES PARA OCULTAR INPUTS (Mantén estas funciones en tu script) ----------------------------------------
// Función para mostrar/ocultar campos de nombre (Persona/Empresa)
// El parámetro isInitialLoad permite que la función sepa si se está cargando la página (true) o si el usuario cambió el select (false)
function mostrarCampoNombre(isInitialLoad) {
    var tipoClienteSelect = document.getElementById("tipo_cliente");
    var nombrePersonaInput = document.getElementById("nombre_persona");
    var nombreEmpresaInput = document.getElementById("nombre_empresa");

    // Limpiar errores visibles y clases de validación al cambiar el tipo
    const errorNombrePersonaSpan = document.getElementById("error_nombre_persona");
    const errorNombreEmpresaSpan = document.getElementById("error_nombre_empresa");
    if (errorNombrePersonaSpan) errorNombrePersonaSpan.textContent = "";
    if (errorNombreEmpresaSpan) errorNombreEmpresaSpan.textContent = "";
    if (nombrePersonaInput) {
        nombrePersonaInput.classList.remove("is-invalid", "is-valid");
        // Solo limpiar el valor si no es la carga inicial O si el campo que se oculta no es el que debería estar precargado
        if (!isInitialLoad || tipoClienteSelect.value === "Empresa") {
            nombrePersonaInput.value = ""; 
        }
    }
    if (nombreEmpresaInput) {
        nombreEmpresaInput.classList.remove("is-invalid", "is-valid");
        // Solo limpiar el valor si no es la carga inicial O si el campo que se oculta no es el que debería estar precargado
        if (!isInitialLoad || tipoClienteSelect.value === "Persona") {
            nombreEmpresaInput.value = ""; 
        }
    }

    // Ocultar ambos por defecto para evitar conflictos si no se selecciona nada
    nombrePersonaInput.style.display = "none";
    nombreEmpresaInput.style.display = "none";
    nombrePersonaInput.required = false; // Hacerlos no requeridos si están ocultos
    nombreEmpresaInput.required = false;

    // Mostrar el campo seleccionado y hacerlo requerido
    if (tipoClienteSelect.value === "Persona") {
        nombrePersonaInput.style.display = "block";
        nombrePersonaInput.required = true;
        // Si es la carga inicial, el valor ya debería estar en el input por PHP.
        // Si no es la carga inicial y el input oculto tenía un valor, lo borramos.
    } else if (tipoClienteSelect.value === "Empresa") {
        nombreEmpresaInput.style.display = "block";
        nombreEmpresaInput.required = true;
        // Si es la carga inicial, el valor ya debería estar en el input por PHP.
        // Si no es la carga inicial y el input oculto tenía un valor, lo borramos.
    }
}


// Función para mostrar/ocultar campos de Cédula/Rif
// El parámetro isInitialLoad permite que la función sepa si se está cargando la página (true) o si el usuario cambió el select (false)
function mostrarCampoDocumento(isInitialLoad) {
    var tipoDocumentoSelect = document.getElementById("tipo_documento");
    var cedulaInput = document.getElementById("cedula_cliente");
    var rifInput = document.getElementById("rif_cliente");

    // Limpiar errores visibles y clases de validación al cambiar el tipo
    const errorCedulaClienteSpan = document.getElementById("error_cedula_cliente");
    const errorRifClienteSpan = document.getElementById("error_rif_cliente");
    if (errorCedulaClienteSpan) errorCedulaClienteSpan.textContent = "";
    if (errorRifClienteSpan) errorRifClienteSpan.textContent = "";
    if (cedulaInput) {
        cedulaInput.classList.remove("is-invalid", "is-valid");
        if (!isInitialLoad || tipoDocumentoSelect.value === "Rif") {
            cedulaInput.value = ""; 
        }
    }
    if (rifInput) {
        rifInput.classList.remove("is-invalid", "is-valid");
        if (!isInitialLoad || tipoDocumentoSelect.value === "Cedula") {
            rifInput.value = ""; 
        }
    }

    // Ocultar ambos por defecto
    cedulaInput.style.display = "none";
    rifInput.style.display = "none";
    cedulaInput.required = false; 
    rifInput.required = false;

    // Mostrar el campo seleccionado y hacerlo requerido
    if (tipoDocumentoSelect.value === "Cedula") {
        cedulaInput.style.display = "block";
        cedulaInput.required = true;
    } else if (tipoDocumentoSelect.value === "Rif") {
        rifInput.style.display = "block";
        rifInput.required = true;
    }
}
</script>
</body>
</html>';

echo $formulario;
?>