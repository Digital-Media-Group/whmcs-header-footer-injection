# Header & Footer Code Injection para WHMCS

**Versión:** 0.2 | **Autor:** MyPanelHost LLC | **Licencia:** GPL

Un módulo addon ligero para WHMCS que permite inyectar código JavaScript, CSS, HTML, meta tags y cualquier otro código estático en el **head**, **header** (después de `<body>`) y **footer** (antes de `</body>`) del área de clientes — sin modificar archivos de la plantilla.

---

## Características

- **Tres zonas de inyección** — Inyecta código en `<head>`, después de `<body>` y antes de `</body>`.
- **Activación/desactivación individual** — Cada zona se puede encender o apagar de forma independiente desde el panel de administración.
- **Sin editar plantillas** — Funciona mediante hooks de WHMCS; no es necesario modificar archivos `.tpl`.
- **Una sola consulta a la base de datos** — Toda la configuración se almacena en caché en memoria con una única lectura de `tbladdonmodules`.
- **Soporte multi-idioma** — Incluye traducciones al inglés, español y portugués. Fácilmente extensible.
- **Huella mínima** — Solo dos archivos PHP más archivos de idioma. Sin cambios en el esquema de la base de datos.
- **Actualización segura** — La configuración se conserva al actualizar el módulo.

---

## Requisitos

- WHMCS 7.x, 8.x o superior
- PHP 7.3 o superior

---

## Instalación

### 1. Subir el módulo

Copia la carpeta `kn_header_footer_injection` al directorio `modules/addons/` de tu WHMCS:

```bash
cp -r kn_header_footer_injection /ruta/a/whmcs/modules/addons/
```

Estructura esperada después de copiar:

```
modules/addons/kn_header_footer_injection/
├── kn_header_footer_injection.php
├── hooks.php
└── lang/
    ├── english.php
    ├── spanish.php
    └── portuguese.php
```

### 2. Activar el módulo

1. Inicia sesión en el **Panel de Administración** de WHMCS.
2. Ve a **Configuración del Sistema → Módulos Addon** (o *Setup → Addon Modules*).
3. Busca **"Header & Footer Code Injection"** en la lista.
4. Haz clic en el botón **Activar**.

### 3. Configurar el módulo

1. Tras la activación, haz clic en **Configurar** junto al módulo.
2. Pega tu código en el campo de texto correspondiente:
   - **Código en Head** — para inyección en `<head>` (analíticas, meta tags, fuentes, etc.).
   - **Código en Header** — para contenido justo después de `<body>` (barras superiores, banners, avisos).
   - **Código en Footer** — para contenido justo antes de `</body>` (widgets de chat, analíticas, scripts).
3. Asegúrate de que el interruptor **Activar** correspondiente esté en **Sí**.
4. Haz clic en **Guardar Cambios**.

> 💡 **Consejo:** Puedes dejar campos vacíos y activar/desactivar zonas según sea necesario.

---

## Ejemplos de uso

### Google Analytics 4 (footer)

```html
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

→ Pega en el campo **Footer**.

### Facebook Pixel (head)

```html
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', 'YOUR_PIXEL_ID');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1"
/></noscript>
```

→ Pega en el campo **Head**.

### Barra de promociones (header)

```html
<div style="background: #ff6b35; color: #fff; text-align: center; padding: 10px; font-weight: bold;">
  🎉 ¡Oferta por tiempo limitado! 30% DE DESCUENTO en tu primer pedido. Usa el código <strong>BIENVENIDO30</strong>
</div>
```

→ Pega en el campo **Header**.

### Widget de chat en vivo (footer)

```html
<script>
  window.__lc = window.__lc || {};
  window.__lc.license = TU_NUMERO_DE_LICENCIA;
  (function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}
  var e={_q:[],_h:null,_v:'2.0',on:function(){i(['on',c.call(arguments)])},
  once:function(){i(['once',c.call(arguments)])},off:function(){i(['off',c.call(arguments)])},
  get:function(e){if(!e.__t){e.__t={};return e}return e},send:function(){i(['send',c.call(arguments)])}};
  n.__lc=n.__lc||{};n.__lc.license=t;n.__lc.init=function(){e._h=e};n[t]=e;
  var s=c.createElement('script');s.async=true;
  s.src='https://cdn.livechatinc.com/tracking.js';
  var g=c.getElementsByTagName('script')[0];g.parentNode.insertBefore(s,g)
  })(window,document,8383838);
</script>
```

→ Pega en el campo **Footer**.

---

## Referencia de Hooks

| Hook | Función | Disparador |
|---|---|---|
| `ClientAreaHeadOutput` | `kn_hfi_head` | Antes de `</head>` |
| `ClientAreaHeaderOutput` | `kn_hfi_header` | Después de `<body>` |
| `ClientAreaFooterOutput` | `kn_hfi_footer` | Antes de `</body>` |

Todos los hooks se ejecutan con prioridad **1** (la más alta). El módulo cachea la configuración en `$_POST` para evitar lecturas repetidas a la base de datos durante una misma carga de página.

---

## Soporte Multi-idioma

El módulo carga las traducciones automáticamente según el **idioma del administrador** configurado en WHMCS.

### Idiomas incluidos

| Idioma | Archivo |
|---|---|
| Inglés | `lang/english.php` |
| Español | `lang/spanish.php` |
| Portugués | `lang/portuguese.php` |

### Añadir un nuevo idioma

1. Crea un nuevo archivo en `lang/` con el nombre del código de idioma de WHMCS, ej. `french.php`:
2. Define todas las claves `$_ADDONLANG` con tus traducciones.
3. WHMCS lo detectará y cargará automáticamente cuando el administrador cambie a ese idioma.

**Comportamiento de respaldo:** Si falta un archivo de idioma, el módulo usa inglés como fallback.

---

## Solución de problemas

| Síntoma | Causa probable | Solución |
|---|---|---|
| El código no aparece en el sitio | El interruptor de activación está en **No** | Ve a Configuración y pon el interruptor en **Sí** |
| El código aparece en todas las páginas menos en una específica | Esa página podría no ejecutar el hook | Asegúrate de que use el tema estándar del área de clientes |
| Errores de PHP después de actualizar | Archivo de idioma desactualizado | Vuelve a subir los archivos de `lang/` |
| Los cambios no se reflejan | Caché del navegador | Limpia la caché del navegador o usa una ventana de incógnito |

---

## Preguntas Frecuentes

**¿Puedo inyectar código solo para grupos de clientes específicos?**
No directamente — el módulo inyecta código para todos los usuarios. Puedes envolver tu código en condicionales PHP dentro de `hooks.php` si es necesario.

**¿Este módulo afecta las páginas del área de administración?**
No. Solo inyecta en hooks `ClientArea*Output`, por lo que las páginas de administración nunca se modifican.

**¿Mi configuración sobrevivirá a una actualización del módulo?**
Sí. Toda la configuración se almacena en la tabla `tbladdonmodules` de la base de datos y persiste entre actualizaciones.

**¿Hay un límite en la cantidad de código que puedo inyectar?**
No. Los campos de texto aceptan entrada ilimitada, pero recomendamos mantener el código inyectado lo más mínimo posible por rendimiento.

---

## Registro de cambios

### 0.2 (2025-05-25)
- Añadido soporte multi-idioma (inglés, español, portugués)
- Añadida estructura de directorio `lang/`
- Refactorización interna para preparación de traducciones

### 0.1 (Versión inicial)
- Inyección básica en head, header y footer
- Interruptores de activación/desactivación para cada zona
- Una sola consulta a la base de datos con caché en memoria

---

## Licencia

Este proyecto está licenciado bajo la **GNU General Public License v3.0**.

Eres libre de usar, modificar y redistribuir este módulo, siempre que mantengas el aviso de copyright original.

---

## Créditos

- **Autor:** MyPanelHost LLC
- **Sitio web:** [https://mypanelhost.com](https://mypanelhost.com)
- **Repositorio:** [GitHub](https://github.com/mypanelhost/whmcs-header-footer-injection)
