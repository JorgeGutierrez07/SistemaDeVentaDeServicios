<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <header class="py-3" style="background-color: #2ABFBF !important; opacity: 1;">
        <!-- Encabezado con logo y botón de inicio -->
        <div class="container d-flex justify-content-between align-items-center">
            <img src="logo.png" alt="Logo" class="logo"> <!-- Asegúrate de tener la imagen del logo -->
            <a href="http://localhost/Proyecto/SistemaDeVentaDeServicios/"><i class="bi bi-house" style="color: White;"></i></a>
        </div>
    </header>
    
    <main class="container my-5">
        <div class="text-center mb-4">
            <h1>Registro Proveedor</h1>
        </div>
        
        <form>
            <div class="row py-2">
                <!-- Primera columna de campos de texto -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="col-md-6 border border-1 rounded-3 p-3">
                        <div class="form-group form-floating py-2">
                            <input type="text" class="form-control form-control-lg" id="nombre" placeholder="Nombre" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Nombre</label>
                        </div>
                        <div class="form-group form-floating py-3">
                            <input type="text" class="form-control form-control-lg" id="apellido" placeholder="Apellido" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Apellidos</label>
                        </div>
                        <div class="form-group form-floating py-3">
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="hola@sitioincreible.com" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Correo Electrónico</label>
                        </div>
                        <div class="form-group form-floating py-3">
                            <input type="text" class="form-control form-control-lg" id="empresa" placeholder="Empresa" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Nombre de la Empresa</label>
                        </div>
                        <div class="form-group form-floating py-3">
                            <input type="text" class="form-control form-control-lg" id="usuario" placeholder="usuario" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Nombre de Usuario</label>
                        </div>
                        <div class="form-group form-floating py-2">
                            <input type="password" class="form-control form-control-lg" id="clave" placeholder="*****" style="background-color: #F2F2F2;">
                            <label for="floatingInput">Clave</label>
                        </div>
                    </div>
                </div>
                
                <!-- Segunda columna de archivos a cargar -->
                <div class="row col-md-6 d-flex justify-content-center px-2" style="margin-left: 0">
                    <div class="col-md-8 border border-1 rounded-3 p-3">
                        <div class="py-2">
                            <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;">
                                <label for="curp" class="form-label">CURP</label>
                                <input type="file" class="form-control" id="curp">
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;">
                                <label for="rfc" class="form-label">RFC</label>
                                <input type="file" class="form-control" id="rfc">
                            </div>
                            </div>
                        <div class="py-2">
                            <div class="form-group border border-1 rounded-3 p-3" style="background-color: #F2F2F2;">
                                <label for="acta" class="form-label">Acta Constitutiva</label>
                                <input type="file" class="form-control" id="acta">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info btn-lg text-white fs-6 py-2 px-4" style="background-color: #2ABFBF;">Crear Cuenta</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>