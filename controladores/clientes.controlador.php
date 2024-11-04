<?php

class ControladorClientes{
    public function create($datos){

        if(isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $datos["nombre"])){
           
            $json = array(
                "status"=>404,
                "detalle"=>"Error en el campo del nombre. Permitido solo letras"
            );
    
            echo json_encode($json, true);    
            return;
        }

        if(isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $datos["apellido"])){
           
            $json = array(
                "status"=>404,
                "detalle"=>"Error en el campo del apellido. Permitido solo letras"
            );
    
            echo json_encode($json, true);    
            return;
        }

        if(isset($datos["email"]) && !preg_match('/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/' , $datos["email"])){
           
            $json = array(
                "status"=>404,
                "detalle"=>"Error en el campo del email."
            );
    
            echo json_encode($json, true);    
            return;
        }

        //Validar email repetido
        $clientes = ModeloClientes::index("clientes");

        foreach ($clientes as $key => $value){
            if($value["email"] == $datos["email"]){
                $json = array(
                    "status"=>404,
                    "detalle"=>"El email esta repetido"
                );
                
                echo json_encode($json, true);    
                return;

            }
        }

        //Generar credenciales del cliente
        $id_cliente = str_replace("$","c", crypt($datos["nombre"].$datos["apellido"].$datos["email"] , '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        /* echo "<pre>"; print_r($id_cliente); echo "<pre>"; */

        $llave_secreta = str_replace("$","a", crypt($datos["email"].$datos["apellido"].$datos["nombre"] , '$2a$07$afartwetsdAD52356FEDGsfhsd$')); 
        /* echo "<pre>"; print_r($llave_secreta); echo "<pre>"; */

        $datos = array("nombre" => $datos["nombre"],
        "apellido" => $datos["apellido"],
        "email" => $datos["email"],
        "id_cliente" => $id_cliente,
        "llave_secreta" => $llave_secreta,
        "created_at" => date('Y-m-d h:i:s'),
        "updated_at" => date('Y-m-d h:i:s')

        
    );
        
        $create = ModeloClientes::create("clientes", $datos);

        if($create == "ok"){

            $json = array(
                "status"=>404,
                "detalle"=>"Se generaron las credenciales", 
                "id_cliente"=>$id_cliente, 
                "llave_secreta"=>$llave_secreta
            );
            
            echo json_encode($json, true);    
            return;
        }

        /* echo "<pre>"; print_r($datos); echo "<pre>";
         */
    }
}

?>