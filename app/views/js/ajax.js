const formularios_ajax = document.querySelectorAll(".FormularioProveedor");

formularios_ajax.forEach(formulario => {
        
        formulario.addEventListener("submit", function(e){
            e.preventDefault();

            Swal.fire({
                title: "¿Estás seguro?",
                text: "El fomulario se enviará",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, enviar",
                cancelButtonText: "No, cancelar"
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
                  .then(respuesta => respuesta.json())
                  .then(respuesta => {
                    return alerta_ajax(respuesta);
                  });
                }
              });
        });
});

function alerta_ajax(alerta){
        if(alerta.tipo == "simple"){
            Swal.fire({
                icon: alerta.icono,
                title: alerta.titulo,
                text: alerta.texto,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6"
              });
        } else if ( alerta.tipo == "fail"){
          Swal.fire({
            title: alerta.titulo,
            text: alerta.texto,
            icon: alerta.icono,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Aceptar"
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else if(alerta.tipo == "success"){
          Swal.fire({
            title: alerta.titulo,
            text: alerta.texto,
            icon: alerta.icono,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Aceptar"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = alerta.url;
            }
          });
        }
}