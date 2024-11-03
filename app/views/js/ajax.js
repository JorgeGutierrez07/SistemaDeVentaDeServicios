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
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: '<a href="#">Why do I have this issue?</a>'
              });
        }
}