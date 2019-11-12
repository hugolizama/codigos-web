var registroSW;
var subscripcion;
var subscrito = false;
/* var pagActual; */ /* Esta variable se establece en cada archivo html */
var btnSubscribirse = document.getElementById('btnSubscribirse');
var navegador;
var url_base = 'http://webpush.local';
//var url_base = 'http://192.168.23.1:8081';



/* funcion para detectar el navegador */
function detectarNavegador() {  
  if (navigator.userAgent.indexOf("Opera") !== -1 || navigator.userAgent.indexOf("OPR") !== -1)
  {
    navegador = 'Opera';  
  }
  else if (navigator.userAgent.indexOf("Chrome") !== -1)
  {
    navegador = 'Chrome';
  } else if (navigator.userAgent.indexOf("Firefox") !== -1)
  {
    navegador = 'Firefox';
  } else if (navigator.userAgent.indexOf("Safari") !== -1)
  {
    navegador = 'Safari';
  } else if ((navigator.userAgent.indexOf("MSIE") !== -1) || (!!document.documentMode === true)) //IF IE > 10
  {
    navegador = 'Internet Explorer';
  } else
  {
    navegador = 'Desconocido';
  }
}


/* urlB64ToUint8Array is a magic function that will encode the base64 public key to Array buffer which is needed by the subscription option */
const urlB64ToUint8Array = base64String => {
  const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
  const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
  const rawData = atob(base64);
  const outputArray = new Uint8Array(rawData.length);
  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
};


/* fnucion para eliminar la subscripcion de la base de datos */
function eliminarSubscripcion(){
  let id = JSON.parse(localStorage.getItem('pushtest-' + pagActual)).bdId;
  
  $.ajax({
    url: url_base + "/subscripcion_eliminar.php", /*url de host virtual*/
    type: 'get',
    dataType: 'json',
    data: {id: id}    
    
  }).done(function(resp){
    if(resp.error === true){
      console.error('ERROR: ' + resp.mensaje);
      alert('ERROR: ' + resp.mensaje);
      
    }else{
      localStorage.removeItem('pushtest-' + pagActual);
      
      subscrito = false;
      textoBoton();
      
      console.log('Subscripción eliminada');
    }
    
  }).fail();
}


/* funcion para desubscribirse de notificaciones */
function desubscribirse(){
//  console.log('desubscribirse()', subscripcion);
  
  $.ajax({
    url: url_base + "/subscripcion_verificar.php", /*url de host virtual*/
    type: 'get',
    dataType: 'json',
    data: {subscripcion: JSON.stringify(subscripcion)}  
    
  }).done(function(resp){
    
    if(resp.error === false){ /* verificar por errores en la verificacion */   
      
      console.info('desubscribirse(): ', resp.mensaje);
      
      
      if(resp.permiso === true){ /*Eliminar subscripcion y registro de la base de datos*/
        subscripcion.unsubscribe()
          .then(() => {
            eliminarSubscripcion();

          }).catch((error) => {
            console.error('Error desubscribiendo! ERROR: ', error);
          });
      }else{ /* Solo eliminar el registro de la base de datos */
        eliminarSubscripcion();
      }
      
    }else{
      alert('ERROR: ' + resp.mensaje);
      console.error('ERROR: ' + resp.mensaje);   
    }
  });  
}


/* funcion para guardar la subscripcion enviandola a una API*/
function guardarSubscripcion() {  
//  alert('iniciando guardarSubscripcion() ');
  $.ajax({
    url: url_base + "/subscripcion_guardar.php", /*url de host virtual*/
    type: 'get',
    dataType: 'json',
    data: {subscripcion: JSON.stringify(subscripcion), pag: pagActual, navegador: navegador}    
    
  }).done(function(resp){
    
    if(resp.error === true){
      console.error('ERROR: ' + resp.mensaje);
      alert('ERROR: ' + resp.mensaje);
    }else{
//      alert('Subscripcion guardada!! ');
      console.info('Subscripcion guardada!! ');
      
      /* guardar id de la base de datos y endpoint en local storage*/
      if(!localStorage.getItem('pushtest-' + pagActual)){
        localStorage.setItem('pushtest-' + pagActual, JSON.stringify({bdId: parseInt(resp.id), subscripcion: subscripcion, pag: pagActual}));
      }
        
      subscrito = true;
      textoBoton();
    }
    
    console.log(resp);
  }).fail(function(xhr, status, error){
    alert(xhr.status + ' - ' + error);
    console.error(xhr.status + ' - ' + error);
  });
};


/* funcion para subscribirse a las notificaciones */
function subscribirse(guardarSub = true){
  try{
    /* Convertir identificador del servidor de base64 a un array */
    const applicationServerKey = urlB64ToUint8Array('BJ-RnDbqhXzPxLWp1aEZk43hL4kreRg9XYrSsBzWS0OZ5qzEhI3GbGrjcr0AE2YJbKOUW_7ry2rhfA8vRGh1jVg');    
        
    const options = { applicationServerKey, userVisibleOnly: true };
    
    /* Comando para subscribirse a las notificaciones */
    registroSW.pushManager.subscribe(options)
      .then((pushSubscription)=>{
        subscripcion = pushSubscription;
//        alert('subscribirse(): ' + JSON.stringify(subscripcion));
        console.log('subscribirse()', JSON.stringify(subscripcion));
        
        if(guardarSub === true){
          /* Guardar suscripcion a traves de una api */
          guardarSubscripcion();     
        }           

        //mostrarNotificacion('notificacion local de prueba', 'hola hugo', registroSW);
      });
  }catch(error){
    console.error(error);
  }
}


/* Solicitar permisos para las notificaciones */
function solicitarPermisoNotificacion(){
  window.Notification.requestPermission().then((permission) => {
    // value of permission can be 'granted', 'default', 'denied'
    // granted: user has accepted the request
    // default: user has dismissed the notification permission popup by clicking on x
    // denied: user has denied the request.
  
    console.info('solicitarPermisoNotificacion: ', permission);
  
    if(permission === 'granted'){      
      subscribirse();           
      
    }else{
      alert('Permission not granted for Notification');
      console.error('Permission not granted for Notification');      
    } 
  });
}


/* funcion llamada desde el boton de subscripcion */
function principal(){   
  /* Verificar si esta subscrito a notificaciones */
  if(!subscrito){    
    /* primero verificar permiso para recibir notificaciones */
    solicitarPermisoNotificacion();
  }else{    
    /* Proceso para desubscribirse */
    desubscribirse();
  }  
}


/* funcion para cambiar el texto del boton */
function textoBoton(){
  if(subscrito){
    btnSubscribirse.textContent = 'Desubscribirse';
  }else{
    btnSubscribirse.textContent = 'Subscribirse';
  }
}


/* function para verificar las capacidades del navegador */
function verificar(){   
  detectarNavegador();
  
  //verificar que el navegador soporte el Service Worker
  if(('serviceWorker' in navigator)){
    
    /* Registrar el service worker */
    navigator.serviceWorker.register('service.js')
      .then(()=>{
        return navigator.serviceWorker.ready;
      })
      .then((serviceWorkerRegistration) => {
        registroSW = serviceWorkerRegistration;
//        alert('Service Worker esta listo! :' + registroSW);
        console.info('Service Worker esta listo! ', registroSW);
        
        /*verificar si ya se encuentra guardada la subscripcion */
        if(localStorage.getItem('pushtest-' + pagActual)){
          subscribirse(false);  
          subscrito = true;
          textoBoton();
        }
        
        /* funcion que escucha mensajes por parte del service worker */
        navigator.serviceWorker.addEventListener('message', (event) => {
          window.location.reload();       
        });
        
      })
      .catch((error)=>{
        console.error('Service Worker ERROR: ', error);
      });
      
  }else{ /* service worker no soportado */
    console.error('No Service Worker support');
    alert('Error: No Service Worker support');    
  }
  
  /*Verificar que el navegador soporta las notificaciones Push */
  if(!('PushManager' in window)){
    console.error('No Push API support');
    alert('Error: No Push API support');
  }
}


verificar();