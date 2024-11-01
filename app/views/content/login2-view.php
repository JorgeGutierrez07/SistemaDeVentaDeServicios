<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body class="bg-light">
    <header class="d-flex justify-content-between align-items-center" style="background-color: #27BEC2; height: 100px; padding: 1.5rem 3rem;">
        <div class="text-white fs-1 fw-bold">LOGO</div>
        <div class="text-center bg-white py-2 px-4 rounded" style="max-width: 400px;">
            <h1 class="fs-5 text-dark m-0">INICIO DE SESIÓN</h1>
        </div>
        <a href="#" class="text-white text-decoration-none fs-1">⌂</a>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4" style="background-color: white;">
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label class="form-label text-secondary">CORREO ELECTRÓNICO</label>
                                <input 
                                    type="email" 
                                    name="login_usuario" 
                                    class="form-control bg-light border-0 py-2" 
                                    placeholder="hola@sitioincreible.co"
                                    required 
                                />
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-secondary">CLAVE</label>
                                <input 
                                    type="password" 
                                    name="login_clave" 
                                    class="form-control bg-light border-0 py-2" 
                                    placeholder="******"
                                    required 
                                />
                            </div>

                            <button class="btn fw-bold rounded-pill py-2 w-100" type="submit" style="background-color: #27BEC2; color: white;">
                                Iniciar Sesión
                            </button>
                            
                            <a href="#" class="d-block text-secondary text-center mt-3 text-decoration-underline">
                                ¿Has olvidado la contraseña?
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
