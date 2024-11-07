
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
                <h1 class="fs-5 text-dark m-0">RECUPERAR CONTRASEÑA</h1>
            </div>
        </div>
        <div class="px-3">
            <a href="<?php echo APP_URL ?>" class="btn btn-primary me-2 clarity--home-line"></a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4" style="background-color: white;">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-key" style="font-size: 3rem; color: #2ABFBF;"></i>
                    </div>
                    <h3 class="text-center mb-3">Recuperar Contraseña</h3>
                    <form id="recuperar-form" method="POST" action="<?php echo APP_URL ?>app/ajax/usuarioAjax.php">
                        <div class="mb-4">
                            <label for="email" class="form-label text-secondary">CORREO ELECTRÓNICO</label>
                            <input type="hidden" name="modulo_usuario" value="recuperarContraseña">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control bg-light border-0 py-2"
                                placeholder="ejemplo@correo.com"
                                required />
                        </div>
                        <button type="submit" class="btn fw-bold rounded-pill py-2 w-100" style="background-color: #2ABFBF; color: white;">
                            Enviar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>