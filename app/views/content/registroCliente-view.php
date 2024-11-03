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
                <h1 class="fs-5 text-dark m-0">REGISTRO CLIENTE</h1>
            </div>
        </div>
        <div class="px-3">
            <a href="<?php echo APP_URL ?>" class="btn btn-primary me-2 clarity--home-line"></a>
        </div>
    </div>
</nav>
<form class="formulario" method="POST" action="<?php echo APP_URL ?>/app/ajax/usuarioAjax.php" autocomplete="off">
    <div class="row justify-content-center py-4">
        <div class="col-12 col-md-8">
            <div class="mx-auto border border-1 rounded-3 p-4">
                <input type="hidden" name="modulo_usuario" value="registrar">
                <div class="row">
                    <div class="col-12 col-md-6 pe-md-3">
                        <!-- Name -->
                        <div class="form-group form-floating mb-5">
                            <input type="text" class="form-control form-control-lg" name="nombre" placeholder="Nombre" style="background-color: #F2F2F2;">
                            <label for="nombre">Nombre</label>
                        </div>

                        <!-- Last name -->
                        <div class="form-group form-floating mb-5">
                            <input type="text" class="form-control form-control-lg" name="apellido" placeholder="Apellido" style="background-color: #F2F2F2;">
                            <label for="apellido">Apellidos</label>
                        </div>

                        <!-- Email -->
                        <div class="form-group form-floating mb-5">
                            <input type="email" class="form-control form-control-lg" name="email" placeholder="correo@ejemplo.com" style="background-color: #F2F2F2;">
                            <label for="email">Correo Electrónico</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 ps-md-3">
                        <!-- Username -->
                        <div class="form-group form-floating mb-5">
                            <input type="text" class="form-control form-control-lg" name="usuario" placeholder="usuario" style="background-color: #F2F2F2;">
                            <label for="usuario">Nombre de Usuario</label>
                        </div>

                        <!-- Password -->
                        <div class="form-group form-floating mb-5">
                            <input type="password" class="form-control form-control-lg" name="clave" placeholder="*****" style="background-color: #F2F2F2;">
                            <label for="clave">Contraseña</label>
                        </div>
                        <!-- Centered button below both columns -->
                        <div class="form-group form-floating mb-5">
                            <button type="submit" class="btn btn-info btn-lg text-white fs-4 px-5 py-3 w-100" style="background-color: #2ABFBF;">Crear Cuenta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
