function alertas_ajax(alerta) {
	if (alerta.tipo == "simple") {
	  Swal.fire({
		icon: alerta.icono,
		title: alerta.titulo,
		text: alerta.text,
		confirmButtonText: "Aceptar",
	  });
	} else if (alerta.tipo == "recargar") {
	  Swal.fire({
		icon: alerta.icono,
		title: alerta.titulo,
		text: alerta.text,
		confirmButtonText: "Aceptar",
	  }).then((result) => {
		if (result.isConfirmed) {
		  location.reload();
		}
	  });
	} else if (alerta.tipo == "limpiar") {
	  Swal.fire({
		icon: alerta.icono,
		title: alerta.titulo,
		text: alerta.text,
		confirmButtonText: "Aceptar",
	  }).then((result) => {
		if (result.isConfirmed) {
		  formulario.reset();
		}
	  });
	} else if (alerta.tipo == "redireccionar") {
	  Swal.fire({
		title: alerta.titulo,
		text: alerta.text,
		icon: alerta.icono,
		confirmButtonColor: "#3085d6",
		confirmButtonText: "Aceptar",
	  }).then((result) => {
		if (result.isConfirmed) {
		  window.location.href = alerta.url;
		}
	  });
	}
  }