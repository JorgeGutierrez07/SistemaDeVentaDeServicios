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
                  
                }
              });
        });
});

function alerta_ajax(alerta){
        if(alerta.tipo == "simple"){
            Swal.fire({
                icon: alerta.icono,
                title: alerta.tituto,
                text: alerta.texto,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6"
              });
        } else if ( alerta.tipo == "fail"){
          Swal.fire({
            title: alerta.tituto,
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
            title: alerta.tituto,
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