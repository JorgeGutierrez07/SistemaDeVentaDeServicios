<style>
    .bg-medium-gray {
        background-color: #e0e0e0;
        /* Gris intermedio personalizado */
    }

    .bg-azul {
        background-color: #2ABFBF;
    }

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

    .iconamoon--profile-circle-light {
        display: inline-block;
        width: 3em;
        height: 3em;
        --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5'%3E%3Cpath d='M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2'/%3E%3Cpath d='M4.271 18.346S6.5 15.5 12 15.5s7.73 2.846 7.73 2.846M12 12a3 3 0 1 0 0-6a3 3 0 0 0 0 6'/%3E%3C/g%3E%3C/svg%3E");
        background-color: currentColor;
        -webkit-mask-image: var(--svg);
        mask-image: var(--svg);
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-size: 100% 100%;
        mask-size: 100% 100%;
    }

    .custom-btn {
        color: white;
        border-radius: 50px;
        padding: 130px 100px;
        font-size: 1.5rem;
        width: 350px;
        text-align: center;
        display: inline-block;
    }
</style>
<nav class="navbar navbar-expand-lg" style="background-color: #2ABFBF;">
    <div class="container-fluid py-3 position-relative d-flex justify-content-between align-items-center">
        <span class="navbar-brand text-white fw-bold ms-4 fs-1">LOGO</span>
        <div class="position-absolute start-50 translate-middle-x">
            <div class="bg-white py-2 px-4 rounded">
                <h1 class="fs-5 text-dark m-0">INICIO ADMIN</h1>
            </div>
        </div>
        <div class="d-flex">
            <div class="px-3">
                <a href="#" class="btn btn-secondary iconamoon--profile-circle-light"></a>
            </div>
            <div class="px-3">
                <a href="<?php echo APP_URL."inicioAdmin/"; ?>" class="btn btn-primary me-2 clarity--home-line"></a>
            </div>
            <div class="px-3">
                <a href="<?php echo APP_URL."logOut/"; ?>" class="me-2 text-white fs-3">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center my-4 py-5">
    <div class="d-flex justify-content-center gap-3 py-5">
        <a href="<?php echo APP_URL."validacionRegistros/"; ?>" class="btn custom-btn text-dark fw-bold" style="background-color: #ff914d">Validación de Registros</a>
        <a href="<?php echo APP_URL."gestionFacturas/"; ?>" class="btn custom-btn text-dark fw-bold" style="background-color: #d9d9d9">Gestión de Facturas</a>
        <a href="<?php echo APP_URL."listarUsuario/"; ?>" class="btn custom-btn text-dark fw-bold" style="background-color: #ffbd59">Gestión de Usuarios</a>
    </div>
</div>