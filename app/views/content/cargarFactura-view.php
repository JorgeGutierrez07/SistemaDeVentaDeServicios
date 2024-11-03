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
</style>
<nav class="navbar navbar-expand-lg" style="background-color: #2ABFBF;">
    <div class="container-fluid py-3 position-relative d-flex justify-content-between align-items-center">
        <span class="navbar-brand text-white fw-bold ms-4 fs-1">LOGO</span>
        <div class="position-absolute start-50 translate-middle-x">
            <div class="bg-white py-2 px-4 rounded">
                <h1 class="fs-5 text-dark m-0">FORMUALRIO CARGA DE FACTURAS</h1>
            </div>
        </div>
        <div class="d-flex">
            <div class="px-3">
                <a href="#" class="btn btn-secondary iconamoon--profile-circle-light"></a>
            </div>
            <div class="px-3">
                <a href="#" class="btn btn-primary me-2 clarity--home-line"></a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5 h-100"> <!-- Cambié de py-5 a py-3 para reducir el espaciado -->
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-light text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-left">
                    <div class="mb-md-4 mt-md-4">
                        <form action="" method="POST">
                            <div data-mdb-input-init class="form-outline form-white mb-4 text-dark">
                                <label class="form-label" for="identificador_factura">IDENTIFICADOR DE LA FACTURA</label>
                                <input type="text" name="identificador_factura" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" class="form-control form-control-lg bg-medium-gray fs-6" placeholder="Identificador de la factura" required />
                            </div>
                            <div data-mdb-input-init class="form-outline form-white mb-4 text-dark">
                                <label class="form-label" for="identificador_factura">RAZÓN DE LA FACTURA</label>
                                <input type="text" name="razon_factura" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" class="form-control form-control-lg bg-medium-gray fs-6" placeholder="Razón" required />
                            </div>
                            <div data-mdb-input-init class="form-outline form-white mb-4 text-dark">
                                <label class="form-label" for="identificador_factura">FECHA LIMITE DE PAGO</label>
                                <input type="date" name="fecha_limite_factura" required class="form-control form-control-lg bg-medium-gray fs-6" />
                            </div>
                            <div data-mdb-input-init class="form-outline form-white mb-4 text-dark">
                                <label class="form-label" for="identificador_factura">SUBIR FACTURA PDF</label>
                                <input type="file" accept=".pdf" name="archivo_factura" required class="form-control form-control-lg bg-medium-gray fs-6" />
                            </div>
                            <div class="text-center">
                                <button class="btn btn-outline-light btn-lg px-5 bg-azul" type="submit">Subir Factura</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>