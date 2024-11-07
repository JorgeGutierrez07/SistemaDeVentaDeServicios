<?php

namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel
{

    /*----------  Controlador iniciar sesion  ----------*/
    public function iniciarSesionControlador()
    {

        $correo = $this->limpiarCadena($_POST['login_correo']);
        $clave = $this->limpiarCadena($_POST['login_clave']);

        # Verificando campos obligatorios #
        if ($correo == "" || $clave == "") {
            echo "<script>
			        Swal.fire({
					  icon: 'error',
					  title: 'Ocurrió un error inesperado',
					  text: 'No has llenado todos los campos que son obligatorios'
					});
				</script>";
        } else {

            # Verificando integridad de los datos #
            if ($this->verificarDatos("[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}", $correo)) {
                echo "<script>
				        Swal.fire({
						  icon: 'error',
						  title: 'Ocurrió un error inesperado',
						  text: 'El CORREO no coincide con el formato solicitado'
						});
					</script>";
            } else {

                # Verificando integridad de los datos #
                if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
                    echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La CLAVE no coincide con el formato solicitado'
							});
						</script>";
                } else {

                    # Verificando usuario #
                    $check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE Correo='$correo'");

                    if ($check_usuario->rowCount() == 1) {

                        $check_usuario = $check_usuario->fetch();

                        if ($check_usuario['Correo'] == $correo && password_verify($clave, $check_usuario['Contraseña'])) {

                            $id_usuario = $check_usuario['ID_Usuario'];
                            if ($check_usuario['Tipo_Usuario'] == "administrador") {
                                $_SESSION['id'] = $check_usuario['ID_Usuario'];
                                $_SESSION['nombre'] = $check_usuario['Nombre'];
                                $_SESSION['apellido'] = $check_usuario['Apellidos'];
                                $_SESSION['usuario'] = $check_usuario['Usuario'];
                                $_SESSION['usuario_tipo'] = $check_usuario['Tipo_Usuario'];
                                $_SESSION['correo'] = $check_usuario['Correo'];
                                if (headers_sent()) {
                                    echo "<script> window.location.href='" . APP_URL . "inicioAdmin/'; </script>";
                                } else {
                                    header("Location: " . APP_URL . "inicioAdmin/");
                                }
                            } else {
                                $check_solicitud = $this->ejecutarConsulta("SELECT * FROM estado_solicitud WHERE ID_Usuario='$id_usuario'");
                                $check_solicitud = $check_solicitud->fetch();

                                if ($check_solicitud['Estado'] == "aceptado") {

                                    $_SESSION['id'] = $check_usuario['ID_Usuario'];
                                    $_SESSION['nombre'] = $check_usuario['Nombre'];
                                    $_SESSION['apellido'] = $check_usuario['Apellidos'];
                                    $_SESSION['usuario'] = $check_usuario['Usuario'];
                                    $_SESSION['usuario_tipo'] = $check_usuario['Tipo_Usuario'];
                                    $_SESSION['correo'] = $check_usuario['Correo'];

                                    if ($_SESSION['usuario_tipo'] == "cliente") {
                                        if (headers_sent()) {
                                            echo "<script> window.location.href='" . APP_URL . "inicioCliente/'; </script>";
                                        } else {
                                            header("Location: " . APP_URL . "inicioCliente/");
                                        }
                                    } elseif ($_SESSION['usuario_tipo'] == "proveedor") {
                                        if (headers_sent()) {
                                            echo "<script> window.location.href='" . APP_URL . "cargarFactura/'; </script>";
                                        } else {
                                            header("Location: " . APP_URL . "cargarFactura/");
                                        }
                                    }
                                } else {
                                    echo "<script>
                                    Swal.fire({
                                      icon: 'error',
                                      title: 'Ocurrió un error inesperado',
                                      text: 'Tu solicitud de registro al sistema ha sido rechazada o esta pendiente'
                                    });
                                </script>";
                                }
                            }
                        } else {
                            echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Ocurrió un error inesperado',
									  text: 'Correo o clave incorrectos'
									});
								</script>";
                        }
                    } else {
                        echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Correo o clave incorrectos'
								});
							</script>";
                    }
                }
            }
        }
    }


    /*----------  Controlador cerrar sesion  ----------*/
    public function cerrarSesionControlador()
    {

        session_destroy();

        if (headers_sent()) {
            echo "<script> window.location.href='" . APP_URL . "inicio/'; </script>";
        } else {
            header("Location: " . APP_URL . "inicio/");
        }
    }
}
