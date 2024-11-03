<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .button-container {
        margin-top: 220px; 
        margin-left: 120px; 
    }
    </style>
    <title>Página de Inicio Administrador</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom" style="background-color: #2ABFBF;">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="#">LOGO</a>
            <div class="ml-auto">
                <img src="https://th.bing.com/th/id/OIP.iPvPGJG166ivZnAII4ZS8gHaHa?w=193&h=193&c=7&r=0&o=5&dpr=1.3&pid=1.7" alt="Usuario" class="img-fluid" style="width: 30px; height: 30px; margin-right: 15px;">
                <img src="https://th.bing.com/th/id/OIP.IF7_E6dRI0nPOaT7KRxttgHaHa?w=211&h=210&c=7&r=0&o=5&dpr=1.3&pid=1.7" alt="Notificaciones" class="img-fluid" style="width: 30px; height: 30px; margin-right: 15px;">
                <button class="btn btn-danger">Cerrar Sesión</button>
            </div>
        </div>
    </nav>

    <div class="container text-start button-container">
        <div class="d-flex flex-row align-items-start">
            <a href="pagina1.html" class="btn btn-danger mb-2 me-4" style="padding: 120px 130px;">Validación de registros</a>
            <a href="pagina2.html" class="btn btn-secondary mb-2 me-4" style="padding: 120px 130px;">Gestión de facturas</a>
            <a href="pagina3.html" class="btn btn-warning mb-2 me-4" style="padding: 120px 130px;">Gestión de usuarios</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>