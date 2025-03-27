<?php


require_once '../../config/db.php';

class UserModel {
   

    public function login($numdoc, $clave)
    {
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql = "SELECT * FROM personas a, tipo_persona b WHERE
        a.id_tipo_persona_fk=b.id and  numero_documento=:numdoc and pass=:clave";
        $statement = $conexion->prepare($sql);
        



        //rows=filas
        //$rows=null;
        $statement->bindParam(':numdoc',$numdoc);
        $statement->bindParam(':clave',$clave);
        $statement->execute();
        if ($statement->rowCount()==1) 
        {
            $result= $statement->fetch();
            $_SESSION['ID']=$result['id_persona'];
            $_SESSION['NOMBRE']=$result['nombres'];
            $_SESSION['PERFIL']=$result['nombreTipopersona'];
            //$_SESSION['DATOS_COMPLETOS']=$result['datos_completos'];
            return true;
        }
        return false;
    }


    public function createUser($id_tipo_persona_fk, $id_tipo_proponente_fk, $id_tipo_Documento_fk, $numero_documento, $nombres, $apellidos, $genero_fk, $vereda_centro_poblado, $direccion, $celular, $correo, $pass, $nombre_representante, $tiempo_residencia, $anexo1_persona_natural, $anexo2_grupos_constituidos, $anexo3_persona_juridica, $copia_documento_identidad, $certificado_residencia, $copia_rut, $certificado_sicut, $estado_anexo1, $estado_anexo2, $estado_anexo3, $estado_copia_documento, $estado_certificado_residencia, $estado_certificado_sicut,$estado_copia_rut
    ) {

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
    
        $sql = "INSERT INTO personas(id_tipo_persona_fk, id_tipo_Documento_fk, id_tipo_proponente_fk,numero_documento, nombres, apellidos, genero_fk, vereda_centro_poblado, direccion, celular, correo, pass, nombre_representante, tiempo_residencia, anexo1_persona_natural, estado_anexo1, anexo2_grupos_constituidos, estado_anexo2, anexo3_persona_juridica, estado_anexo3, copia_documento_identidad, estado_copia_documento, certificado_residencia, estado_certificado_residencia, copia_rut, estado_copia_rut, certificado_sicut, estado_certificado_sicut) 
        VALUES
        (:id_tipo_persona_fk,:id_tipo_Documento_fk,:id_tipo_proponente_fk,:numero_documento,:nombres,:apellidos,:genero_fk,:vereda_centro_poblado,:direccion,:celular,:correo,:pass,:nombre_representante,:tiempo_residencia,:anexo1_persona_natural,:estado_anexo1,:anexo2_grupos_constituidos,:estado_anexo2,:anexo3_persona_juridica,
        :estado_anexo3,:copia_documento_identidad,:estado_copia_documento,:certificado_residencia,
        :estado_certificado_residencia,:copia_rut,:estado_copia_rut,:certificado_sicut,:estado_certificado_sicut)";
        $statement = $conexion->prepare($sql);
        // Usar bindValue con los nombres correctos
        $statement->bindParam(':id_tipo_persona_fk', $id_tipo_persona_fk);
        
        $statement->bindParam(':id_tipo_Documento_fk', $id_tipo_Documento_fk);
        $statement->bindParam(':id_tipo_proponente_fk', $id_tipo_proponente_fk);
        $statement->bindParam(':numero_documento', $numero_documento);
        $statement->bindParam(':nombres', $nombres);
        $statement->bindParam(':apellidos', $apellidos);
        $statement->bindParam(':genero_fk', $genero_fk);
        $statement->bindParam(':vereda_centro_poblado', $vereda_centro_poblado);
        $statement->bindParam(':direccion', $direccion);
        $statement->bindParam(':celular', $celular);
        $statement->bindParam(':correo', $correo);
        $statement->bindParam(':pass', $pass); // Hashear la pass
        $statement->bindParam(':nombre_representante',$nombre_representante);
        $statement->bindParam(':tiempo_residencia',$tiempo_residencia);
        $statement->bindParam(':anexo1_persona_natural',$anexo1_persona_natural);
        $statement->bindParam(':estado_anexo1',$estado_anexo1);
        $statement->bindParam(':anexo2_grupos_constituidos',$anexo2_grupos_constituidos);
        $statement->bindParam(':estado_anexo2',$estado_anexo2);
        $statement->bindParam(':anexo3_persona_juridica',$anexo3_persona_juridica);
        $statement->bindParam(':estado_anexo3',$estado_anexo3);//revisado
        $statement->bindParam(':copia_documento_identidad',$copia_documento);     
        $statement->bindParam(':estado_copia_documento',$estado_copia_documento);   
        $statement->bindParam(':certificado_residencia',$certificado_residencia);
        $statement->bindParam(':estado_certificado_residencia',$estado_certificado_residencia);
        $statement->bindParam(':copia_rut',$copia_rut);
        $statement->bindParam(':estado_copia_rut',$estado_copia_rut);
        $statement->bindParam(':certificado_sicut',$certificado_sicut);       
        $statement->bindParam(':estado_certificado_sicut',$estado_certificado_sicut);
       

        if (!$statement) {
            return "Error al preparar la consulta.";
        } else {
           $statement->execute();
           echo  '
            <script type="text/javascript">
                    alert("se creo correctamente");
                    window.location.href="../../index.php";
            </script>';
        }
    }

// ---------------------cargar--------------------------------------------------------------
    public function CargarUsuario() {
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql = "SELECT * FROM personas";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }
    // -----------------elimnar--------------------------------------------------------------
    public function Eliminiar($id){
        $modelo=new Conexion ();
        $conexion =$modelo->get_conexion();
        $sql="delete from personas where id=:id";
        $statement=$conexion->prepare($sql);
        $statement->bindparam(':id',$id);
        if(!$statement){
            return"Error al eliminar registro";
        }else{
            $statement->execute();
            return"se elimino correctamente";
        }
    }


    // -----------------buscar persona-----------------------------------------------------------
    public function BuscarPersona($nombres){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $nombres="%".$nombres."%";
        $sql = "SELECT * FROM personas where nombres like :nombres";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(":nombres",$nombres);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;

    }
    // -------------------------cargar usuario para editar---------------------------------------------------------
    public function cargarusuaro1($id) {
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql = "SELECT * FROM personas WHERE id = :id";
        $statement = $conexion->prepare($sql); // Preparar la consulta
        $statement->bindParam(":id", $id); // Vincular el parámetro
        $statement->execute(); // Ejecutar la consulta
    
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    // -------------------------------editar usuario 1-------------------------------------------------------
    public function modificarUsuario($id,$numero_documento,$nombres,$apellidos,$vereda_centro_poblado,
    $direccion,$celular,$correo){
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql ="UPDATE personas SET
         numero_documento=:numero_documento,nombres=:nombres,apellidos=:apellidos,
         vereda_centro_poblado=:vereda_centro_poblado,direccion=:direccion,celular=:celular,correo=:correo WHERE id=:id";

        $statement = $conexion->prepare($sql); // Preparar la consulta

        //$statement->bindParam(':id_tipo_persona_fk', $id_tipo_persona_fk);
        //$statement->bindParam(':id_tipo_Documento_fk', $id_tipo_Documento_fk);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':numero_documento', $numero_documento);
        $statement->bindParam(':nombres', $nombres);
        $statement->bindParam(':apellidos', $apellidos);
        //$statement->bindParam(':genero_fk', $genero_fk);
        $statement->bindParam(':vereda_centro_poblado', $vereda_centro_poblado);
        $statement->bindParam(':direccion', $direccion);
        $statement->bindParam(':celular', $celular);
        $statement->bindParam(':correo', $correo);
        //$statement->bindParam(':contrasena', $pass); // Hashear la pass

        if (!$statement) {
            return "Error al modificar el usuario.";
        } else {
           $statement->execute();
            return "se modifico correctamete correctamente.";
        }
    }

    public function cambiarClave($id){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql="UPDATE personas SET pass=:pass WHERE id=:id";

        $statement = $conexion->prepare($sql); // Preparar la consulta

        $statement->bindParam(':pass',$pass);
        if (!$statement) {
            return "Error al modificar el usuario.";
        } else {
           $statement->execute();
            return "se modifico correctamete correctamente.";
        }

    }
}
?>