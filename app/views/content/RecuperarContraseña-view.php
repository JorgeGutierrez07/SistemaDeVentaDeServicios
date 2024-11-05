<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <header class="d-flex justify-content-between align-items-center" style="background-color: #2ABFBF; height: 100px; padding: 1.5rem 3rem;">
        <div class="text-white fs-1 fw-bold">LOGO</div>
        <div class="text-center bg-white py-2 px-4 rounded" style="max-width: 400px;">
            <h1 class="fs-5 text-dark m-0">RECUPERAR CONTRASEÑA</h1>
        </div>
        <a href="#" class="text-white text-decoration-none fs-1">⌂</a>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4" style="background-color: white;">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <i class="fas fa-key" style="font-size: 3rem; color: #2ABFBF;"></i>
                        </div>
                        <h3 class="text-center mb-3">Recuperar Contraseña</h3>
                        <form id="recuperar-form"> 
                            <div class="mb-4">
                                <label for="email" class="form-label text-secondary">CORREO ELECTRÓNICO</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    class="form-control bg-light border-0 py-2" 
                                    placeholder="ejemplo@correo.com"
                                    required 
                                />
                            </div>
                            <button type="submit" class="btn fw-bold rounded-pill py-2 w-100" style="background-color: #2ABFBF; color: white;">
                                Enviar Contraseña
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="#" class="text-secondary text-decoration-underline">
                                Volver al inicio de sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script>
        document.getElementById("recuperar-form").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("procesarRecuperacion.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("CORREO ENVIADO", "Revisa tu correo para ver tu contraseña", "success");
                } else {
                    Swal.fire("Error", "No se pudo enviar el correo", "error");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    </script> -->
</body>
</html>
