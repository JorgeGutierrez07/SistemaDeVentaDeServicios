<?php
echo '
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
';
?>

<nav class="navbar navbar-expand-lg" style="background-color: #2ABFBF;">
    <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
        <span class="navbar-brand text-white fw-bold fs-1">LOGO</span>
        <div>
            <h1 class="fs-5 text-dark">PANEL PROVEEDOR</h1>
        </div>
        <div class="d-flex align-items-center">            
            <!-- Icono de notificación -->
            <a href="#" class="text-white me-3 fs-4">
                <i class="fas fa-bell"></i>
            </a>
            
            <!-- Icono de usuario -->
            <a href="#" class="text-white fs-4">
                <i class="fas fa-user"></i>
            </a>

            <a href='#' class="text-white fs-4">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-4 mb-3">
            <button class="btn btn-info w-100 py-4 text-white">
                <i class="fas fa-check-circle" style="color: green;"></i> Facturas Pagadas
            </button>
        </div>
        <div class="col-md-4 mb-3">
            <button class="btn btn-danger w-100 py-4 text-white">
                <i class="fas fa-clock" style="color: white;"></i> Facturas Vencidas
            </button>
        </div>
        <div class="col-md-4 mb-3">
            <button class="btn btn-primary w-100 py-4 text-white">
                <i class="fas fa-file-alt" style="color: black;"></i> Facturas Pendientes
            </button>
        </div>
    </div>

    <h3 class="text-center mb-4">Historial de Facturas</h3>

    <!-- Contenedor de la tabla con scroll y margen negro -->
    <div class="table-responsive" style="max-height: 300px; overflow-y: auto; margin: 20px auto; border: 2px solid black; width: 70%; border-radius: 10px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No. Factura</th>
                    <th>Estado</th>
                    <th>Razón de Factura</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12345</td>
                    <td>Pagada</td>
                    <td>Servicios</td>
                    <td>Proveedor XYZ</td>
                </tr>
                <tr>
                    <td>67890</td>
                    <td>Vencida</td>
                    <td>Productos</td>
                    <td>Proveedor ABC</td>
                </tr>
                <tr>
                    <td>11223</td>
                    <td>Pagada</td>
                    <td>Servicios</td>
                    <td>Proveedor DEF</td>
                </tr>
                <tr>
                    <td>44556</td>
                    <td>Vencida</td>
                    <td>Productos</td>
                    <td>Proveedor GHI</td>
                </tr>
                <tr>
                    <td>77889</td>
                    <td>Pendiente</td>
                    <td>Consultoría</td>
                    <td>Proveedor JKL</td>
                </tr>
                <tr>
                    <td>22334</td>
                    <td>Pagada</td>
                    <td>Servicios</td>
                    <td>Proveedor MNO</td>
                </tr>
                <tr>
                    <td>55667</td>
                    <td>Vencida</td>
                    <td>Productos</td>
                    <td>Proveedor PQR</td>
                </tr>
                <tr>
                    <td>88990</td>
                    <td>Pendiente</td>
                    <td>Consultoría</td>
                    <td>Proveedor STU</td>
                </tr>
                <tr>
                    <td>33445</td>
                    <td>Pagada</td>
                    <td>Servicios</td>
                    <td>Proveedor VWX</td>
                </tr>
                <tr>
                    <td>66778</td>
                    <td>Vencida</td>
                    <td>Productos</td>
                    <td>Proveedor YZA</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
echo '
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
';
?>
