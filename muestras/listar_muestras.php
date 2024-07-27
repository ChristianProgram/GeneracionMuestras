<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Muestras</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <?php include('../templates/header.php'); ?>

    <h2>Listado de Muestras</h2>
    <table border="1" id="tablaMuestras">
        <tr>
            <th>Número de Muestra</th>
            <th>Origen</th>
            <th>Nombre de la Muestra</th>
            <th>Ingredientes Activos</th>
            <th>Proveedor</th>
            <th>Fórmula</th>
            <th>Fecha de Caducidad</th>
            <th>Folio</th>
            <th>Resultado</th>
            <th>Generar Etiqueta con Nombre</th>
            <th>Generar Etiqueta</th>
            <th>Actualizar Resultado</th>
        </tr>
        <!-- Las filas serán cargadas aquí mediante JavaScript -->
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchMuestras();
        });

        function fetchMuestras() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../api/obtener_muestras_lista.php", true);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var tablaMuestras = document.getElementById('tablaMuestras');
                        response.muestras.forEach(function(muestra) {
                            var row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${muestra.numero_muestra}</td>
                                <td>${muestra.origen}</td>
                                <td>${muestra.nombre_muestra}</td>
                                <td class='ingredientes_activos' style='background-color: ${muestra.resultado === 'PASO' ? 'lightgreen' : (muestra.resultado === 'NO PASO' ? 'lightcoral' : '')};'>${muestra.ingredientes_activos}</td>
                                <td>${muestra.proveedor}</td>
                                <td>${muestra.formula}</td>
                                <td>${muestra.fecha_caducidad}</td>
                                <td>${muestra.folio}</td>
                                <td>${muestra.resultado_detalles}</td>
                                <td><a href='generar_etiqueta_nombre.php?id=${muestra.id}' target='_blank'>Generar Etiqueta con Nombre</a></td>
                                <td><a href='generar_etiqueta.php?id=${muestra.id}' target='_blank'>Generar Etiqueta</a></td>
                                <td>
                                    <form action='actualizar_resultado.php' method='post'>
                                        <input type='hidden' name='id' value='${muestra.id}'>
                                        <textarea name='resultado_detalles' placeholder='Escriba detalles aquí...'>${muestra.resultado_detalles}</textarea>
                                        <button type='submit' name='resultado' value='PASO' style='background-color: lightgreen;'>PASO</button>
                                        <button type='submit' name='resultado' value='NO PASO' style='background-color: lightcoral;'>NO PASO</button>
                                    </form>
                                </td>
                            `;
                            tablaMuestras.appendChild(row);
                        });
                    } else {
                        alert("Error al obtener las muestras.");
                    }
                } else {
                    alert("Error al conectar con la API.");
                }
            };
            
            xhr.send();
        }
    </script>

    <?php include('../templates/footer.php'); ?>
</body>
</html>
