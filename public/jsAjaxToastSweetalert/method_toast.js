export const notificaciontoast = (tipo, mensaje, title, positionyx="bottom-right", delay = "1500") => {
    if (tipo === "warning") {
        toastr.warning(mensaje, title, {
            positionClass: "toast-" + positionyx,
            timeOut: delay, closeButton: !0, debug: !1, newestOnTop: !0, progressBar: !0, preventDuplicates: !0, onclick: null, showDuration: "300",
            hideDuration: "1000", extendedTimeOut: "1000", showEasing: "swing", hideEasing: "linear", showMethod: "fadeIn", hideMethod: "fadeOut", tapToDismiss: !1
        });
    } else if (tipo === "error") {
        toastr.error(mensaje, title, {
            positionClass: "toast-" + positionyx,
            timeOut: delay, closeButton: !0, debug: !1, newestOnTop: !0, progressBar: !0, preventDuplicates: !0, onclick: null, showDuration: "300",
            hideDuration: "1000", extendedTimeOut: "1000", showEasing: "swing", hideEasing: "linear", showMethod: "fadeIn", hideMethod: "fadeOut", tapToDismiss: !1
        
        });
    } else if (tipo === "info") {
        toastr.info(mensaje, title, {
            positionClass: "toast-" + positionyx,
            timeOut: delay, closeButton: !0, debug: !1, newestOnTop: !0, progressBar: !0, preventDuplicates: !0, onclick: null, showDuration: "300",
            hideDuration: "1000", extendedTimeOut: "1000", showEasing: "swing", hideEasing: "linear", showMethod: "fadeIn", hideMethod: "fadeOut", tapToDismiss: !1
        });
    }

};