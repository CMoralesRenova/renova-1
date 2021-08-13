// JavaScript Document

// calendario en español
/*$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};

$.datepicker.setDefaults($.datepicker.regional['es']);*/

function MessageBox(msg) {
    /*
     var sCad = "\n<script> alert('"+ msg +"'); </script>\n";
     $("#divMensaje").html(sCad);
     */

    $("#divMensaje").html(msg);
    $("#divMensaje").dialog({
        title: "Sistema",
        modal: true,

        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    });
}

function ImagenCargando() {
    var sHTML = "<center class='precarga'></center>";
    return sHTML;
}

function Redireccion(pagina) {
    window.location = pagina;
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function Alert(tit,msg,iconn){
  swal({
  title:tit,
  text: msg,
  icon: iconn
  });
}
function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }
 }
 function solonumeros(e)
{
   var keynum = window.event ? window.event.keyCode : e.which;
   if ((keynum == 8) || (keynum == 46))
        return true;
    return /\d/.test(String.fromCharCode(keynum));
}
function DatosVacios(obj, input) {
    var datosVacios = false;
    $(obj).find(input).each(function () {
        var $this = $(this);
        if ($this.val().length <= 0) {
            datosVacios = true;
            $this.css("background-color", "red");
        }
    });
    return datosVacios;
}