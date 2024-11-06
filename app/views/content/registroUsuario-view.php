<body class="d-flex flex-column vh-100">
	<header class=" text-white p-3" style="background-color: #2ABFBF">
        <div class="d-flex justify-content-between align-items-center">
        
				<svg class=" text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
				<path d="M21.972 11.517a.527.527 0 0 0-1.034-.105 1.377 1.377 0 0 1-1.324 1.01 1.467 1.467 0 0 1-1.4-1.009.526.526 0 0 0-1.015 0 1.467 1.467 0 0 1-2.737.143l-.049-.204.021-.146V9.369h2.304a2.632 2.632 0 0 0 2.631-2.632 2.678 2.678 0 0 0-2.654-2.632l-.526.022-.13-.369A2.632 2.632 0 0 0 13.579 2c-.461 0-.915.124-1.313.358L12 2.513l-.266-.155A2.603 2.603 0 0 0 10.422 2a2.632 2.632 0 0 0-2.483 1.759l-.13.37-.518-.024a2.681 2.681 0 0 0-2.66 2.632A2.632 2.632 0 0 0 7.264 9.37H9.61v1.887l-.007.09-.028.08a1.328 1.328 0 0 1-1.301.996 1.632 1.632 0 0 1-1.502-1.024.526.526 0 0 0-1.01.013 1.474 1.474 0 0 1-1.404 1.01 1.381 1.381 0 0 1-1.325-1.01.547.547 0 0 0-.569-.382h-.008a.526.526 0 0 0-.456.526v.446a10.012 10.012 0 0 0 10 10 9.904 9.904 0 0 0 7.067-2.94A10.019 10.019 0 0 0 22 11.966l-.028-.449ZM8.316 15.685a1.053 1.053 0 1 1 2.105 0 1.053 1.053 0 0 1-2.105 0Zm1.58 3.684a2.105 2.105 0 0 1 4.21 0h-4.21Zm4.736-2.631a1.052 1.052 0 1 1 0-2.105 1.052 1.052 0 0 1 0 2.105Z"/>
				</svg>
			
            <button class="btn btn-outline-light">Inicio</button>
        </div>
    </header>	
	<div class="container d-flex justify-content-center align-items-center vh-100">
		<div class="col-xl-8 " >
			<div class="card text-black" style="border-radius: 1rem; background-color: #2ABFBF ">
				<div class="card-body p-5 text-center">
					<h2 class=" text-white fw-bold mb-2 text-uppercase">Registro usuario</h2>
					<p class="text-white mb-2">Por favor ingresa tus datos para crear tu perfil</p>
					<form  action="" method="POST">
						<div class="d-flex gap-3">
							<div class="w-100 form-floating mb-3">
								<input type="text" class="form-control" id="floatingInput" placeholder="Nombre">
								<label for="floatingInput">Nombre</label>
							</div>
							
							<div class="w-100 form-floating mb-3">
								<input type="text" class="form-control" id="floatingInput" placeholder="Nombre">
								<label for="floatingInput">Apellido</label>
							</div>

						</div>
						<div class="d-flex gap-3">
							<div class="w-100 form-floating mb-3">
								<input type="email" class="form-control" id="floatingInput" placeholder="Nombre">
								<label for="floatingInput">Corre</label>
							</div>
							<div class="w-100 form-floating mb-3">
								<input type="text" class="form-control" id="floatingInput" placeholder="Nombre">
								<label for="floatingInput">Usuario</label>
							</div>
						</div>

						<div class="d-flex justify-content-center">
							<div class="pb-3 form-floating mb-3">
								<input type="password" class="form-control" id="floatingInput" placeholder="Nombre">
								<label for="floatingInput">Clave</label>
							</div>
						</div>
							
						<div>
							<button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 mb-4" type="submit">Registrar</button>
						</div>

						<div>
							<p class="text-white mb-0">¿Ya tienes cuenta? <a href="/SistemaDeVentaDeServicios/login" class="text-white fw-bold"> Inicia sésion</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>