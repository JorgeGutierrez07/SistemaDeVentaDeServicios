// Selecciona el formulario
const formularioEstado = document.querySelector("#formulario-estado");
const baseURL = '/SistemaDeVentaDeServicios/app/controllers/';

// Asocia la función de actualización a cada botón "Actualizar Datos"
document.querySelectorAll(".btn-success").forEach(button => {
    button.addEventListener("click", (e) => {
        const idUsuario = e.target.getAttribute("data-id");
        actualizarUsuario(idUsuario);
    });
});

function actualizarUsuario(id) {
  // Obtener los valores
  const nombre = document.getElementById('nombre_usuario_' + id).value.trim();
  const correo = document.getElementById('correo_usuario_' + id).value.trim();
  
  // Validaciones básicas
  if (!nombre || !correo) {
      Swal.fire({
          icon: 'error',
          title: 'Error de validación',
          text: 'Por favor, complete todos los campos',
      });
      return;
  }
  
  // Validar formato de correo
  if (!correo.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
      Swal.fire({
          icon: 'error',
          title: 'Error de validación',
          text: 'Por favor, ingrese un correo electrónico válido',
      });
      return;
  }
  
  const data = { id, nombre, correo };
  
  // Mostrar loader
  Swal.fire({
      title: 'Actualizando...',
      text: 'Por favor espere',
      allowOutsideClick: false,
      showConfirmButton: false,
      willOpen: () => {
          Swal.showLoading();
      }
  });

// Realizar la petición
fetch(baseURL + 'actualizarUsuariosController.php', {
  method: 'POST',
  headers: {
      'Content-Type': 'application/json',
  },
  body: JSON.stringify(data)
})
.then(async response => {
  const contentType = response.headers.get('content-type');
  
  // Verificar que la respuesta sea JSON
  if (!contentType || !contentType.includes('application/json')) {
      const text = await response.text();
      throw new Error(`Respuesta no válida del servidor: ${text}`);
  }
  
  // Convertir la respuesta a JSON
  const jsonData = await response.json();

  // Verificar si el estado de la respuesta es exitoso
  if (!response.ok || jsonData.success === false) {
      throw new Error(jsonData.message || 'Error al actualizar usuario');
  }
  
  return jsonData;
})
.then(data => {
  // Llamar a alertas_ajax en caso de éxito    
  alertas_ajax({
      tipo: "recargar",
      icono: "success",
      titulo: "Datos Actualizados",
      text: data.message
  });
})
.catch(error => {
  // Llamar a alertas_ajax en caso de error
  console.error('Error completo:', error);
  alertas_ajax({
      tipo: "recargar",
      icono: "success",
      titulo: "Éxito",
      text: data.message
  });
});

}
