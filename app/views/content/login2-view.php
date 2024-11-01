<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        .header {
            background-color: #27BEC2;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100px;
        }
        .logo {
            color: white;
            font-size: 3rem;
            font-weight: bold;
            letter-spacing: 2px;
            flex: 1;
        }
        .home-icon {
            color: white;
            text-decoration: none;
            font-size: 3.5rem;
            line-height: 1;
            flex: 1;
            text-align: right;
        }
        .title-section {
            background-color: #27BEC2;
            padding: 0 1rem 2rem 1rem;
            text-align: center;
        }
        .title-container {
            background-color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            flex: 2;
            text-align: center;
            max-width: 400px;
            margin: 0 2rem;
        }
        .title-container h1 {
            font-size: 1.2rem;
            font-weight: 500;
            color: #333;
            margin: 0;
        }
        .login-card {
            background-color: white !important;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            color: #666;
            text-align: left;
            display: block;
            margin-bottom: 0.5rem;
        }
        .login-button {
            background-color: #27BEC2;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: bold;
            width: 100%;
            margin-top: 2rem;
        }
        .login-button:hover {
            background-color: #00a693;
        }
        .forgot-password {
            color: #666;
            text-decoration: underline;
            margin-top: 1rem;
            display: block;
        }
        .form-control {
            background-color: #f5f5f5;
            border: none;
            padding: 0.75rem;
        }
        body {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">LOGO</div>
        <div class="title-container">
            <h1>INICIO DE SESIÓN</h1>
        </div>
        <a href="#" class="home-icon">⌂</a>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card login-card">
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label class="form-label">CORREO ELECTRÓNICO</label>
                                <input 
                                    type="email" 
                                    name="login_usuario" 
                                    class="form-control" 
                                    placeholder="hola@sitioincreible.co"
                                    required 
                                />
                            </div>

                            <div class="mb-4">
                                <label class="form-label">CLAVE</label>
                                <input 
                                    type="password" 
                                    name="login_clave" 
                                    class="form-control" 
                                    placeholder="******"
                                    required 
                                />
                            </div>

                            <button class="btn login-button" type="submit">
                                Iniciar Sesión
                            </button>
                            
                            <a href="#" class="forgot-password text-center">
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
