<?php include('../templates/header2.php'); ?>
<div class="form-container">
    <h2>Alta de Muestras</h2>

    <!-- Formulario de alta de muestras -->
    <form id="formAltaMuestra">
        Nombre de la Muestra: <input type="text" name="nombre_muestra" required><br>
        Ingredientes Activos (separados por comas, ejemplo: H2O, NaCl): <input type="text" name="ingredientes_activos" required><br>
        Fórmula: <input type="text" name="formula" required><br>
        Proveedor:
        <select id="proveedorSelect" name="proveedor" required>
            <option value="">Seleccione un proveedor</option>
        </select><br>
        <input type="hidden" id="token" name="token" value="<?php echo bin2hex(random_bytes(32)); ?>">
        <input type="submit" value="Registrar Muestra">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function cargarProveedores() {
        fetch('http://localhost/GeneracionMuestras/api/proveedores.php')
            .then(response => response.json())
            .then(data => {
                let proveedorSelect = document.getElementById('proveedorSelect');
                data.forEach(proveedor => {
                    let option = document.createElement('option');
                    option.value = proveedor.id;
                    option.textContent = proveedor.nombre;
                    proveedorSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar proveedores:', error));
    }

    document.getElementById('formAltaMuestra').addEventListener('submit', function(event) {

        let formData = new FormData(this);

        fetch('http://localhost/GeneracionMuestras/api/registrar_muestra.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Muestra registrada exitosamente');
                location.reload();
            } else {
                alert('Error al registrar la muestra: ' + data.message);
            }
        })
        .catch(error => console.error('Error al registrar muestra:', error));
    });

    cargarProveedores();
});
</script>

<?php include('../templates/footer.php'); ?>
