const formularios_ajax = document.querySelectorAll('.formulario');

formularios_ajax.forEach( formulario =>{
	formulario.addEventListener('submit', (e) =>{
		e.preventDefault();
		Swal.fire({
			title: 'Los datos son correctos?',
			text: "Tus datos seran enviados!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'SI, realizar',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				let data = new FormData(this);
				let method = this.getAttribute("method");
				let action = this.getAttribute("action");

				let encabezados = new Headers();
				let config = {
					method: method,
					headers: encabezados,
					mode: 'cors',
					cache: 'no-cache',
					body: data
				};

				fetch(action, config)
				.then(respuesta =>{ respuesta.json() })
				.then( respuesta =>{
					return alertas_ajax(respuesta);
				});
			}
		})
	})
})

function alertas_ajax(alerta){
	if(alerta.tipo == 'simple'){
		Swal.fire({
			icon: alerta.icono,
			title: alerta.titulo,
			text: alerta.text,
			confirmButtonText: 'Aceptar'
		});
	} else if(alerta.tipo == 'recargar'){
		Swal.fire({
			icon: alerta.icono,
			title: alerta.titulo,
			text: alerta.text,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if(result.isConfirmed){
				location.reload();
			}
		});
	} else if(alerta.tipo =='limpiar'){
		Swal.fire({
			icon: alerta.icono,
			title: alerta.titulo,
			text: alerta.text,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if(result.isConfirmed){
				document.querySelectorAll('.formulario').reset();
			}
		});
	} else if(alerta.tipo =='redireccionar'){
		window.location.href=alerta.url;
	}
}