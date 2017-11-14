<?php
include('session.php');
if (!empty($_POST['nombreCliente'])) {
    $query = mysqli_query($link, "SELECT * FROM Cliente WHERE nombre LIKE '%{$_POST['nombreCliente']}%'");
    while ($row = mysqli_fetch_array($query)) {
        $query1 = mysqli_query($link,"SELECT * FROM Contacto WHERE idCliente = '{$row['idCliente']}'");
        $numrows = mysqli_num_rows($query1);
        if ($numrows>0){
            echo "
                <div class='form-group row'>
                    <label for='contactoCliente' class='col-2 col-form-label'>Nombre de Contacto:</label>
                    <div class='col-10'>
                        <input type='text' id='contactoCliente' name='contactoCliente' class='form-control'>
                    </div>
                </div>
            ";
        }else{
            echo "
                <div class='form-group row'>
                    <label class='col-2 col-form-label'>Datos:</label>
                    <div class='col-10'>
                        <label for='dni' class='sr-only'>Documento de Identidad</label>
                        <input type='text' id='dni' name='dni' class='form-control col-4 mb-2 mr-2' placeholder='Documento de Identidad'>
                        <label for='nombres' class='sr-only'>Nombres</label>
                        <input type='text' id='nombres' name='nombres' class='form-control col-7 mb-2' placeholder='Nombres'>
                        <label for='apellidos' class='sr-only'>Apellidos</label>
                        <input type='text' id='apellidos' name='apellidos' class='form-control col-7 mb-2' placeholder='Apellidos'>
                        <label for='mail' class='sr-only'>Email</label>
                        <input type='email' id='mail' name='email' class='form-control col-5 mb-2 mt-2' placeholder='Email'>
                        <label for='telf' class='sr-only'>Teléfono</label>
                        <input type='text' id='telf' name='telefono' class='form-control col-5 mb-2 mt-2' placeholder='Teléfono'>
                        <label for='direccion' class='sr-only'>Direccion</label>
                        <input type='text' id='direccion' name='direccion' class='form-control col-8 mt-2' placeholder='Dirección'>
                        <label for='ciudad' class='sr-only'>Ciudad</label>
                        <select type='text' id='ciudad' name='ciudad' class='form-control col-5 mt-2'>
                            <option>Ciudad</option>";
            $ciudad=mysqli_query($link,"SELECT * FROM Ciudad");
            while ($fila=mysqli_fetch_array($ciudad)){
                echo "
                                    <option value='{$fila['idCiudad']}'>{$fila['nombre']}</option>
                                ";
            }
            echo "
                        </select>
                    </div>
                </div>
            ";
        }
    }
}