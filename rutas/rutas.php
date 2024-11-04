<?php 

$arrayRutas = explode("/", $_SERVER['REQUEST_URI']);

//echo "<pre>"; print_r($arrayRutas); echo "<pre>";

if(isset($_GET["pagina"]) && is_numeric($_GET["pagina"])){

    $cursos = new ControladorCursos();
    $cursos->index($_GET["pagina"]);
    
}else{

    if (count(array_filter($arrayRutas))==2){
        $json = array(
            "detalle"=>"No encontrado"
        );

        echo json_encode($json,true);

        return;
    }

    if (count(array_filter($arrayRutas))==3 && $arrayRutas[3]=="cursos"){

        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){

            $cursos = new ControladorCursos();
            $cursos->index(null);

        }

        
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="POST"){

            //Capturar datos
            $datos = array(
                "titulo"=>$_POST["titulo"],
                "descripcion"=>$_POST["descripcion"],
                "instructor"=>$_POST["instructor"],
                "imagen"=>$_POST["imagen"],
                "precio"=>$_POST["precio"]
            );

            //echo "<pre>"; print_r($datos); echo "<pre>";
            

            $cursos = new ControladorCursos();
            $cursos->create($datos);
        }    
    }
}



//if (array_filter($arrayRutas)[3]=="cursos" && is_numeric(array_filter($arrayRutas)[4])){
if ($arrayRutas[3]=="cursos" && is_numeric($arrayRutas[4])){
    
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){

        $cursos = new ControladorCursos();
        $cursos->show($arrayRutas[4]);

    }  

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="PUT"){

        //Capturar datos

        $datos = array();

        parse_str(file_get_contents('php://input'), $datos);

        $editarCursos = new ControladorCursos();
        $editarCursos->update($arrayRutas[4], $datos);

    }  

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="DELETE"){

        $eliminarCursos = new ControladorCursos();
        $eliminarCursos->delete($arrayRutas[4]); 

    }  

   
}

if (count(array_filter($arrayRutas))==3 && $arrayRutas[3]=="registro"){
    
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="POST"){

        $datos = array(
            "nombre"   => $_POST["nombre"],
            "apellido" => $_POST["apellido"],
            "email"    => $_POST["email"]);
 
        /* echo "<pre>"; print_r($datos); echo "<pre>"; */   

        $registro = new ControladorClientes();
        $registro->create($datos);

    }
}

?>