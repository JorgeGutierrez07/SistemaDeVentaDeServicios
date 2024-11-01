<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-8">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
						<h2 class="fw-bold mb-2 text-uppercase">Registro usuario</h2>
						<p class="text-white-50 mb-2">Por favor ingresa tus datos para crear tu perfil</p>
						<form  action="" method="POST">
							<div class="d-flex gap-3">
								<div data-mdb-input-init class="form-outline form-white w-100 mb-2">
									<input type="text" name="nombre" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required class="form-control form-control-lg" />
									<label class="form-label" for="nombre">Nombre</label>
								</div>
								
								<div data-mdb-input-init class="form-outline form-white w-100 mb-2">
									<input type="password" name="apellido" pattern="^[a-zA-Z0-9]{6,}$" maxlength="100" required class="form-control form-control-lg" />
									<label class="form-label" for="apellido">Apellido</label>
								</div>
	
							</div>
							<div class="d-flex gap-3">
								<div data-mdb-input-init class="form-outline w-100 form-white mb-2">
									<input type="email" name="correo" pattern="^[a-zA-Z0-9]{6,}$" maxlength="100" required class="form-control form-control-lg" />
									<label class="form-label" for="correo">Correo electrónico</label>
								</div>
								<div data-mdb-input-init class="form-outline w-100 form-white mb-2">
									<input type="text" name="usuario" pattern="^[a-zA-Z0-9]{6,}$" maxlength="100" required class="form-control form-control-lg" />
									<label class="form-label" for="usuario">Usuario</label>
								</div>
							</div>

							<div class="d-flex justify-content-center">
								<div data-mdb-input-init class="form-outline  form-white mb-2">
									<input type="password" name="clave" pattern="^[a-zA-Z0-9]{6,}$" maxlength="100" required class="form-control form-control-lg" />
									<label class="form-label" for="clave">Clave</label>
								</div>
							</div>
								
							<div>
								<button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 mb-4" type="submit">Registrar</button>
							</div>

							<div>
								<p class="mb-0">¿Ya tienes cuenta? <a href="/SistemaDeVentaDeServicios/login" class="text-white fw-bold"> Inicia sésion</a></p>
							</div>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>