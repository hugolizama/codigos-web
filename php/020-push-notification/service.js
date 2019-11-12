console.log('Service Worker cargado.');

url = null;

self.addEventListener('install', function(event){
  self.skipWaiting();
//  console.log('Installed', event);
});

self.addEventListener('activate', function(event){
//  console.log('Activated', event);
});

self.addEventListener('push', function(event) {
  if (event.data) {
    let info = JSON.parse(event.data.text());
    let mensaje = info.mensaje;
    url = info.url;
    
    mostrarNotificacion('Notificación', mensaje, self.registration);
    
  } else {
    console.log('Push event but no data');
  }
});


/* Mostrar notificacion push */
function mostrarNotificacion(titulo, mensaje, registroSW){
  opciones = {
    body: mensaje
  };
  
  registroSW.showNotification(titulo, opciones);
}


/* funcion al hacer clic en la notificacion */
self.addEventListener('notificationclick', function(event){
//  console.log(JSON.stringify(event.notification.body));
    event.notification.close();


  //var url = 'https://www.youtube.com/watch?v=dw_T9pJ728U';
  
  event.waitUntil(
    clients.matchAll({
      type: 'window'
    }).then(function(windowClients){
      for(var i=0; i<windowClients.length; i++){
        var client = windowClients[i];
        if(client.url === url && 'focus' in client){
//          return client.focus();
          client.focus();          
          return client.postMessage();
        }
      }
      
      if(clients.openWindow){
        return clients.openWindow(url);
      }
    })
  );
  
});