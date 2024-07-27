<?php include('../templates/header3.php'); ?>

<div class="form-container">
    <h2>Alta de Proveedor</h2>

    <form id="formAltaProveedor">
        Nombre del Proveedor: <input type="text" name="nombre_proveedor" required><br>
        <input type="hidden" id="token" name="token" value="<?php echo bin2hex(random_bytes(32)); ?>">
        <input type="submit" value="Registrar Proveedor">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formAltaProveedor').addEventListener('submit', function(event) {
        event.preventDefault(); 

        let formData = new FormData(this);

        fetch('http://localhost/GeneracionMuestras/api/registrar_proveedor.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Proveedor registrado exitosamente');
                location.reload();
            } else {
                alert('Error al registrar el proveedor: ' + data.message);
            }
        })
        .catch(error => console.error('Error al registrar proveedor:', error));
    });
});
</script>

<?php include('../templates/footer.php'); ?>
