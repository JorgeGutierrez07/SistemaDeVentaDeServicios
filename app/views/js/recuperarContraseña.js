const formularioContraseña = document.querySelector("#recuperar-form");
const spinner = document.getElementById("spinner");

formularioContraseña.addEventListener("submit", (e) => {
  e.preventDefault(); // Evita que se recargue la página
  // Mostrar el spinner
  spinner.style.display = "block";

  let data = new FormData(formularioContraseña);
  let method = formularioContraseña.getAttribute("method");
  let action = formularioContraseña.getAttribute("action");
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
           // Ocultar el spinner al recibir la respuesta
      spinner.style.display = "none";
      // Llama a alertas_ajax con la respuesta procesada
      alertas_ajax(respuesta);
    })
    .catch((error) => {
      console.log("Error en la solicitud:", error.message);
    });
});
