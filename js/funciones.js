function agregarDatos(nombre_producto,precio_producto,descripcion_producto,existencia,imagen)
{
    cadena = "nombre_producto"+nombre_producto+
    "&precio_producto="+precio_producto+
    "descripcion_producto"+descripcion_producto+
    "&existencia="+existencia+
    "&imagen"+imagen;
    $.ajax({
        type:"POST",
        url:"services/serviciosProductosAgregar.php",
        data: cadena,
        success:function(r)
        {
            if(r==1)
            {
                alertify.success("Agregado con Éxito");
            }
            else
            {
                alertify.error("Error de ingreso");
            }
        }
    });
}
