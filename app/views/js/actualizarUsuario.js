const formulario_User = document.querySelectorAll(".usuarioActualizar-form");

//Alerta para confirmar el envio del fomulario para proveedor
formulario_User.forEach((formulario_User) => {
  formulario_User.addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "¿Estás seguro?",
      text: "El fomulario se enviará",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, enviar",
      cancelButtonText: "No, cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezados = new Headers();
        let config = {
          method: method,
          headers: encabezados,
          mode: "cors",
          cache: "no-cache",
          body: data,
        };
        fetch(action, config)
          .then((respuesta) => {
            // Imprime la respuesta completa en la consola
            console.log("Respuesta del servidor:", respuesta);
            // Intentamos leer la respuesta como texto
            return respuesta.text().then((text) => {
              try {
                // Intentamos parsear como JSON
                const jsonResponse = JSON.parse(text);
                console.log("Respuesta como JSON:", jsonResponse);
                return jsonResponse; // Devuelve el JSON si es válido
              } catch (error) {
                // Si no es un JSON válido, mostramos el texto sin parsear
                console.log("Respuesta no es JSON:", text);
                return text; // Devuelve el texto sin modificaciones
              }
            });
          })
          .then((respuesta) => {
            // Llama a alertas_ajax con la respuesta procesada
            alertas_ajax(respuesta);
          })
          .catch((error) => {
            console.log("Error en la solicitud:", error.message);
          });
      }
    });
  });
});
