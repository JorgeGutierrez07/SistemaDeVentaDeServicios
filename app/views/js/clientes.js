const formulario = document.querySelector("#formularioCliente");

formulario.addEventListener("submit", (e) => {
  e.preventDefault();
  Swal.fire({
    title: "Los datos son correctos?",
    text: "Tus datos seran enviados!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "SI, realizar",
    cancelButtonText: "No, cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      let data = new FormData(formulario);
      let method = formulario.getAttribute("method");
      let action = formulario.getAttribute("action");
      let encabezados = new Headers();
      let config = {
        method: method,
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };

      fetch(action, config)
        .then((respuesta) => respuesta.json())
        .then((respuesta) => {
          return alertas_ajax(respuesta);
        })
        .catch((error) => {
          // Muestra una alerta si hay un error en la red o en la respuesta
          console.log(error.message);
        });
    }
  });
});
