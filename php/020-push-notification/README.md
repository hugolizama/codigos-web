# INSTRUCCIONES

### COMO GENERAR LAS LLAVES VAPID 

Se debe tener instalado nodejs en el sistema operativo y ejecutar los siguientes comandos:

`>npm install -g web-push`

`>web-push generate-vapid-keys`

<br/>

Public Key:<br/>
BJ-RnDbqhXzPxLWp1aEZk43hL4kreRg9XYrSsBzWS0OZ5qzEhI3GbGrjcr0AE2YJbKOUW_7ry2rhfA8vRGh1j
<br/>

Private Key:<br/>
YO9CUkXpIPCA1OdKwMDiEjC26OW5Y6oUkRNcLw-s0

<br/><br/>

### DESCARGAR LIBRERÍA PARA ENVIAR LAS NOTIFICACIONES PUSH

https://github.com/web-push-libs/web-push-php

**NOTA:** Para descargar la última versión de la librería es necesario PHP 7+, de lo contrario composer descargara una versión anterior.


Crear una carpeta "backend", navegar por consola hasta esta carpeta y ejecutar el siguiente comando:

`>composer require minishlink/web-push`

<br/><br/>

### ERROR "SSL certificate problem: unable to get local issuer certificate" 

Las notificaciones push necesitan de un certificado de seguridad en el servidor, para efectos de PRUEBAS y DESARROLLO en el proyecto se incluye un certificado. Se debe editar el archivo php.ini y buscar la opción "curl.cainfo" y agregar la ruta hasta el archivo "cacert.pem".

Ej:

> curl.cainfo = C:\www\apache\htdocs\push-notification\backend\cacert.pem 

<br/><br/>

### CREAR UN HOST VIRTUAL PARA LAS NOTIFICACIONES

```
#------------- PRUEBAS PARA HACER WEB PUSH EN PHP -------------
listen 8081
<VirtualHost 127.0.0.103:80 192.168.23.1:8081 >
    DocumentRoot "C:\www\apache\htdocs\pruebas\push-notification\backend"
    ServerName 127.0.0.103
    ServerAlias webpush.local
    ErrorLog "logs/webpush-error.log"
    CustomLog "logs/webpush-access.log" combined	
	
    #php 7.2
    FcgidWrapper "c:/www/php72/php-cgi.exe" .php 
    AddHandler fcgid-script .php	
		
    <Directory "C:\www\apache\htdocs\pruebas\push-notification\backend"> 
	<FilesMatch "\.php$">
		SetHandler fcgid-script 
	</FilesMatch> 
	Options Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
	AllowOverride All
	Require all granted	
    </Directory>
	
    <Directory "c:/www/php72/">
      <Files "php-cgi.exe">		
        Require all granted		
      </Files>
    </Directory>
</VirtualHost>
```

<br/><br/>

### HABILITAR GOOGLE CHROME PARA SITIOS INSEGUROS 

Las notificaciones push solo funcionan obligatoriamente con sitios con certificados de seguridad SSL (https) por lo que si ocupamos un dominio que no sea "localhost" o "127.0.0.1" para nuestras pruebas, por ejemplo armando una red local donde podamos incluir dispositivos móviles, no funcionará. 

Google Chrome permite anular esta restricción, primero en la barra de navegación de chrome digitar esta url:
> chrome://flags/#unsafely-treat-insecure-origin-as-secure

En la caja de texto digitar la ip o dominio que deseamos permitir. Ej: http://192.168.23.1, luego a la par de la caja de texto seleccionar la opción "Enable" y abajo del navegador hacer click en el botón "Relaunch" que hará reiniciar el navegador, de esta forma ya podremos utilizar del dominio o ip para pruebas.

**NOTA:** Esta misma instrucción habría que ser introducida en el navegador chrome de teléfonos si deseamos hacer pruebas con dispositivos móviles.

<br/><br/>

### PRUEBAS DE FUNCIONAMIENTO 
Navegadores:
- Chrome desktop - Funciona
- Chrome mobile - Funciona
- Firefox desktop - Funciona
- Firefox mobile - **PENDIENTE**
- Opera desktop - Funciona
- navegador samsung - **PENDIENTE**
