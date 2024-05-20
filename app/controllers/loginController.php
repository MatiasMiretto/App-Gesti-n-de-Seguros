<?php

	namespace app\controllers;
	use app\models\mainModel;

	class loginController extends mainModel{
       #Controlador iniciar sesion#
        public function iniciarSesionControlador(){

            # Almacenando datos#
		    $usuario=$this->limpiarCadena($_POST['login_usuario']);
		    $clave=$this->limpiarCadena($_POST['login_clave']);

            # Verificando campos obligatorios #
		    if($usuario=="" || $clave==""){
                echo "
                <script>
	        Swal.fire({
                icon: 'error',
                title: 'Ocurrio un error inesperado',
                text: 'Ingrese todos los datos solicitados',
                confirmButtonText: 'Aceptar'
            });
                </script>
            ";
            }else{
                # VERIFICANDO INTEGRIDAD DE LOS DATOS #
                if ($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)) {
                    echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrio un error inesperado',
                    text: 'El USUARIO no coincide con el formato solicitado',
                    confirmButtonText: 'Aceptar'
                });
                    </script>
                ";
                } else {
                    if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)) {
                        echo "
                        <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error inesperado',
                            text: 'La CLAVE no coincide con el formato solicitado',
                            confirmButtonText: 'Aceptar'
                        });
                            </script>
                        ";
                    } else {
                        # Verificando usuario #
		                $check_usuario=$this->ejecutarConsulta("SELECT * FROM usuario WHERE Nombre_Usuario='$usuario'");
                        if ($check_usuario->rowCount()==1) {
                            $check_usuario=$check_usuario->fetch();

                            if ($check_usuario['Nombre_Usuario']==$usuario && password_verify($clave,$check_usuario['Clave'])) {
                                $_SESSION['id']=$check_usuario['ID_Usuario'];
                                $_SESSION['nombre']=$check_usuario['Nombre'];
                                $_SESSION['apellido']=$check_usuario['Apellido'];
                                $_SESSION['usuario']=$check_usuario['Nombre_Usuario'];
                                $_SESSION['foto']=$check_usuario['Foto'];

                                if(headers_sent()){
					                echo "<script> window.location.href='".APP_URL."dashboard/'; </script>";
					            }else{
					                header("Location: ".APP_URL."dashboard/");
					            }
                                
                                
                            } else {
                                echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrio un error inesperado',
                                text: 'Usuario o clave incorrectos',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                        ";
                            }
                            
                        } else {
                            echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrio un error inesperado',
                                text: 'Usuario o clave incorrectos',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                        ";
                        }
                        
                    }
                    
                }
                
            }
        }

        #Controlador cerrar sesion#
        public function cerrarSesionControlador(){
            
            session_destroy();

            if(headers_sent()){
                echo "<script> window.location.href='".APP_URL."login/'; </script>";
            }else{
                header("Location: ".APP_URL."login/");
            }
        }

    }