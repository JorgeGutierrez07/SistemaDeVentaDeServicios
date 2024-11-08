<style>
    .clarity--home-line {
        display: inline-block;
        width: 3em;
        height: 3em;
        --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 36 36'%3E%3Cpath fill='%23000' d='m33.71 17.29l-15-15a1 1 0 0 0-1.41 0l-15 15a1 1 0 0 0 1.41 1.41L18 4.41l14.29 14.3a1 1 0 0 0 1.41-1.41Z' class='clr-i-outline clr-i-outline-path-1'/%3E%3Cpath fill='%23000' d='M28 32h-5V22H13v10H8V18l-2 2v12a2 2 0 0 0 2 2h7V24h6v10h7a2 2 0 0 0 2-2V19.76l-2-2Z' class='clr-i-outline clr-i-outline-path-2'/%3E%3Cpath fill='none' d='M0 0h36v36H0z'/%3E%3C/svg%3E");
        background-color: currentColor;
        -webkit-mask-image: var(--svg);
        mask-image: var(--svg);
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-size: 100% 100%; 
        mask-size: 100% 100%;
    }
</style>
<nav class="navbar navbar-expand-lg" style="background-color: #2ABFBF;">
    <div class="container-fluid py-3 position-relative d-flex justify-content-between align-items-center">
        <span class="navbar-brand text-white fw-bold ms-4 fs-1">LOGO</span>
        <div class="position-absolute start-50 translate-middle-x">
            <div class="bg-white py-2 px-4 rounded">
                <h1 class="fs-5 text-dark m-0">REGISTRO PROVEEDOR</h1>
            </div>
        </div>
        <div class="px-3">
            <a href="<?php echo APP_URL ?>" class="btn btn-primary me-2 clarity--home-line"></a>
        </div>
    </div>
</nav>
<form class = "FormularioProveedor" action = "<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method = "POST" enctype="multipart/form-data">
    <input type = "hidden" name = "modulo_proveedor" value = "registrar">
    <div class="row justify-content-center py-2">
        <!-- Primera columna de campos de texto -->
        <div class="col-12 col-md-6 mb-4 mb-md-0">
            <div class="mx-auto" style="max-width: 500px;">
                <div class="border border-1 rounded-3 p-3">
                    <div class="form-group form-floating py-2 mb-3">
                        <input type="text" class="form-control form-control-lg" name = "nombre" id="nombre" placeholder="Nombre" style="background-color: #F2F2F2;">
                        <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-group form-floating py-3 mb-3">
                        <input type="text" class="form-control form-control-lg" name = "apellidos" id="apellido" placeholder="Apellido" style="background-color: #F2F2F2;" >
                        <label for="floatingInput">Apellidos</label>
                    </div>
                    <div class="form-group form-floating py-3 mb-3">
                        <input type="email" class="form-control form-control-lg" name = "email" id="email" placeholder="hola@sitioincreible.com" style="background-color: #F2F2F2;" >
                        <label for="floatingInput">Correo Electrónico</label>
                    </div>
                    <div class="form-group form-floating py-3 mb-3">
                        <input type="text" class="form-control form-control-lg" name = "nombre_empresa" id="empresa" placeholder="Empresa" style="background-color: #F2F2F2;" >
                        <label for="floatingInput">Nombre de la Empresa</label>
                    </div>
                    <div class="form-group form-floating py-3 mb-3">
                        <input type="text" class="form-control form-control-lg" name = "nombre_usuario" id="usuario" placeholder="usuario" style="background-color: #F2F2F2;" >
                        <label for="floatingInput">Nombre de Usuario</label>
                    </div>
                    <div class="form-group form-floating py-2 mb-3">
                        <input type="password" class="form-control form-control-lg" name = "clave" id="clave" placeholder="*****" style="background-color: #F2F2F2;" >
                        <label for="floatingInput">Clave</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda columna de archivos a cargar -->
        <div class="col-12 col-md-6">
            <div class="mx-auto" style="max-width: 500px;">
                <div class="border border-1 rounded-3 p-3">
                    <div class="py-2 mb-4">
                        <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;" >
                            <label for="curp" class="form-label">CURP</label>
                            <input type="file" accept="application/pdf" name = "curp" class="form-control" id="curp">
                        </div>
                    </div>
                    <div class="py-3 mb-4">
                        <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;" >
                            <label for="rfc" class="form-label">RFC</label>
                            <input type="file" accept="application/pdf" name = "rfc" class="form-control" id="rfc">
                        </div>
                    </div>
                    <div class="py-2 mb-4">
                        <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;" >
                            <label for="acta" class="form-label">Acta Constitutiva</label>
                            <input type="file" accept="application/pdf" name = "acta" class="form-control" id="acta">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-info btn-lg text-white fs-4 px-5 py-3" style="background-color: #2ABFBF;">Crear Cuenta</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo APP_URL; ?>app/views/js/ajaxProveedor.js" ></script>