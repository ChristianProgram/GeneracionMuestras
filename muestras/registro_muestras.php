<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Muestras</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../templates/header.php'); ?>

    <h2>Registro de Muestras</h2>
    <form id="registroMuestraForm">
        Número de Muestra: <input type="text" name="numero_muestra" id="numeroMuestra" readonly><br>
        Origen:
        <select name="origen" required>
            <option value="Fabrica de alimento">Fabrica de alimento</option>
            <option value="Bodega Medicamento">Bodega Medicamento</option>
            <option value="Laboratorio">Laboratorio</option>
        </select><br>
        Nombre de la Muestra:
        <select name="nombre_muestra" id="nombreMuestra" required>
            <option value="">Seleccione una muestra</option>
            <!-- Muestras serán cargadas aquí mediante JavaScript -->
        </select><br>
        Fórmula: <input type="text" name="formula" id="formula" readonly><br>
        Ingredientes Activos: <input type="text" name="ingredientes_activos" id="ingredientesActivos" readonly><br>
        Proveedor: <input type="text" name="proveedor" id="proveedor" readonly><br>
        Fecha de Caducidad: <input type="date" name="fecha_caducidad" required><br>
        Lote: <input type="text" name="folio" required><br>
        <input type="submit" value="Registrar Muestra">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchUltimoNumeroMuestra();
            fetchMuestras();

            document.getElementById('nombreMuestra').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var ingredientes = selectedOption.getAttribute('data-ingredientes');
                var proveedor = selectedOption.getAttribute('data-proveedor');
                var formula = selectedOption.getAttribute('data-formula');
                document.getElementById('ingredientesActivos').value = ingredientes;
                document.getElementById('proveedor').value = proveedor;
                document.getElementById('formula').value = formula;
            });

            document.getElementById('registroMuestraForm').addEventListener('submit', function(event) {
                event.preventDefault();
                
                var form = this;
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../api/registro_muestras.php", true);

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            form.reset();
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alert(response.message);
                        }
                    } else {
                        alert("Error al registrar la muestra.");
                    }
                };

                xhr.onerror = function() {
                    alert("Error de conexión.");
                };

                xhr.send(formData);
            });
        });

        function fetchUltimoNumeroMuestra() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../api/obtener_ultimo_numero_muestra.php", true);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('numeroMuestra').value = response.numero_muestra + 1;
                    } else {
                        alert(response.message || "Error al obtener el último número de muestra.");
                    }
                } else {
                    alert("Error al conectar con la API.");
                }
            };
            
            xhr.onerror = function() {
                alert("Error de conexión.");
            };

            xhr.send();
        }

        function fetchMuestras() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../api/obtener_muestras.php", true);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var nombreMuestraSelect = document.getElementById('nombreMuestra');
                        response.muestras.forEach(function(muestra) {
                            var option = document.createElement('option');
                            option.value = muestra.nombre_muestra;
                            option.setAttribute('data-ingredientes', muestra.ingredientes_activos);
                            option.setAttribute('data-proveedor', muestra.proveedor_nombre);
                            option.setAttribute('data-formula', muestra.formula);
                            option.textContent = muestra.nombre_muestra;
                            nombreMuestraSelect.appendChild(option);
                        });
                    } else {
                        alert(response.message || "Error al obtener las muestras.");
                    }
                } else {
                    alert("Error al conectar con la API.");
                }
            };
            
            xhr.onerror = function() {
                alert("Error de conexión.");
            };

            xhr.send();
        }
    </script>

    <?php include('../templates/footer.php'); ?>
</body>
</html>
