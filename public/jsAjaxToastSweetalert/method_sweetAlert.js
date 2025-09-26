export const message_sweetAlert = (estado, title, text) => {
    if (estado === 0) {
      Swal.fire(
        {
          title: title,
          text: text,
          icon: 'error',
          confirmButtonColor: '#0A58CA',
          confirmButtonText: 'De acuerdo',
        }
      );
    } if (estado === 1) {
      Swal.fire(
        {
          title: 'ERROR!',
          text: "Ingresar credenciales",
          icon: 'error',
          confirmButtonColor: '#0A58CA',
          confirmButtonText: 'De acuerdo',
        }
      );
    }
  };
  
  export const confirmation_sweetAlert = async (title, message, type) => {
    const response = await Swal.fire({
      title: title,
      text: message,
      type: type,
      showCancelButton: true,
      confirmButtonColor: "#0A58CA",
      cancelButtonColor: "#6C757D",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    })
    return response;
  };
  
  
  
  
  
  
  // export const confirmation_sweetAlert = () => {
  //   var result=false;
  //   Swal.fire({
  //     title: "Deseas continuar?",
  //     text: "Se procederá a eliminar el registro de la base de datos",
  //     type: "warning",
  //     showCancelButton: true,
  //     confirmButtonColor: "#0A58CA",
  //     cancelButtonColor: "#6C757D",
  //     confirmButtonText: "Confirmar",
  //     cancelButtonText: "Cancelar",
  //   }).then(function (isConfirm) {
  //     if (isConfirm.value) {
  //       result = true;
  //       // $.ajax({
  //       //   type: "POST",
  //       //   url: "../../Controller/adminController.php",
  //       //   data: {
  //       //     idadministrador: idadministrador,
  //       //     op: "4",
  //       //   },
  //       //   beforeSend: function () { },
  //       //   success: function (info) {
  //       //     let mi_json = JSON.parse(info);
  //       //     if (mi_json.estado == "1") {
  //       //       // recargar tabla ajax
  //       //       table.ajax.reload();
  //       //       // enviar mensaje de exito
  //       //       notificaciontoast("info", mi_json.mensaje, "¡Éxito!");
  //       //     } else {
  //       //       notificaciontoast("error", mi_json.mensaje, "Error");
  //       //     }
  //       //   },
  //       //   error: function (error) {
  //       //     console.log("Error", error);
  //       //   },
  //       // });
  //     } else {
  //       result = false;
  //     }
  //     return result;
  //   });
  // };