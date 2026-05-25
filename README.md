# Header & Footer Code Injection for WHMCS

**Version:** 0.2 | **Author:** MyPanelHost LLC | **License:** GPL

A lightweight WHMCS addon module that allows you to inject custom JavaScript, CSS, HTML, meta tags, and any other static code into the **head**, **header** (after `<body>`), and **footer** (before `</body>`) of your client area — without touching core template files.

---

## Features

- **Three injection zones** — Inject code in `<head>`, after `<body>`, and before `</body>`.
- **Individual enable/disable toggles** — Turn each zone on or off independently from the admin panel.
- **No template edits** — Works via WHMCS hooks; no need to modify `.tpl` files.
- **Single database query** — All settings are cached in memory with a single read from `tbladdonmodules`.
- **Multi-language support** — Comes with English, Spanish, and Portuguese translations. Easily extensible.
- **Minimal footprint** — Just two PHP files plus language files. No database schema changes.
- **Safe upgrade** — Settings are preserved on module updates.

---

## Requirements

- WHMCS 7.x, 8.x or later
- PHP 7.3 or later

---

## Installation

### 1. Upload the module

Copy the `kn_header_footer_injection` folder into your WHMCS `modules/addons/` directory:

```bash
cp -r kn_header_footer_injection /path/to/whmcs/modules/addons/
```

Expected structure after copying:

```
modules/addons/kn_header_footer_injection/
├── kn_header_footer_injection.php
├── hooks.php
└── lang/
    ├── english.php
    ├── spanish.php
    └── portuguese.php
```

### 2. Activate the module

1. Log in to your WHMCS **Admin Panel**.
2. Navigate to **System Settings → Addon Modules** (or *Setup → Addon Modules*).
3. Find **"Header & Footer Code Injection"** in the list.
4. Click the **Activate** button.

### 3. Configure the module

1. After activation, click **Configure** next to the module.
2. Paste your code into the appropriate textarea(s):
   - **Code in Head** — for `<head>` injection (analytics, meta tags, fonts, etc.).
   - **Code in Header** — for content just after `<body>` (topbars, banners, notices).
   - **Code in Footer** — for content just before `</body>` (chat widgets, analytics, scripts).
3. Ensure the corresponding **Enable** toggle is set to **Yes**.
4. Click **Save Changes**.

> 💡 **Tip:** You can leave fields empty and toggle zones on/off as needed.

---

## Usage Examples

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

→ Paste in the **Footer** field.

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

→ Paste in the **Head** field.

### Promotion Topbar (header)

```html
<div style="background: #ff6b35; color: #fff; text-align: center; padding: 10px; font-weight: bold;">
  🎉 Limited time offer — 30% OFF your first order! Use code <strong>WELCOME30</strong>
</div>
```

→ Paste in the **Header** field.

### Live Chat Widget (footer)

```html
<script>
  window.__lc = window.__lc || {};
  window.__lc.license = YOUR_LICENSE_NUMBER;
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

→ Paste in the **Footer** field.

---

## Module Hooks Reference

| Hook | Function | Trigger |
|---|---|---|
| `ClientAreaHeadOutput` | `kn_hfi_head` | Before `</head>` |
| `ClientAreaHeaderOutput` | `kn_hfi_header` | After `<body>` |
| `ClientAreaFooterOutput` | `kn_hfi_footer` | Before `</body>` |

All hooks run at priority **1** (highest). The module caches settings in `$_POST` to avoid repeated database reads during a single page load.

---

## Multi-language Support

The module loads translations automatically based on the **admin language** set in WHMCS.

### Included languages

| Language | File |
|---|---|
| English | `lang/english.php` |
| Spanish | `lang/spanish.php` |
| Portuguese | `lang/portuguese.php` |

### Adding a new language

1. Create a new file in `lang/` named after the WHMCS language code, e.g. `french.php`:
2. Define all `$_ADDONLANG` keys with your translations.
3. WHMCS will detect and load it automatically when the admin switches to that language.

**Fallback behavior:** If a language file is missing, the module falls back to English.

---

## Troubleshooting

| Symptom | Likely cause | Solution |
|---|---|---|
| Code is not appearing on the site | The enable toggle is set to **No** | Go to Configuration and set the toggle to **Yes** |
| Code appears on all pages but not a specific one | The page may not trigger the hook | Ensure the page uses the standard client area theme |
| PHP errors after update | Language file mismatch | Re-upload the latest `lang/` files |
| Changes not taking effect | Browser cache | Clear your browser cache or use a private window |

---

## Frequently Asked Questions

**Can I inject code only for specific client groups?**
Not directly — the module injects code for all users. You can wrap your code in PHP conditionals inside `hooks.php` if needed.

**Does this module affect admin area pages?**
No. It only injects into `ClientArea*Output` hooks, so admin pages are never modified.

**Will my settings survive a module upgrade?**
Yes. All settings are stored in the `tbladdonmodules` database table and persist across upgrades.

**Is there a limit to how much code I can inject?**
No. The textarea fields accept unlimited input, but we recommend keeping injected code as minimal as possible for performance.

---

## Changelog

### 0.2 (2025-05-25)
- Added multi-language support (English, Spanish, Portuguese)
- Added `lang/` directory structure
- Internal refactoring for translation readiness

### 0.1 (Initial release)
- Basic head, header, and footer injection
- Enable/disable toggles for each zone
- Single database query with in-memory caching

---

## License

This project is licensed under the **GNU General Public License v3.0**.

You are free to use, modify, and redistribute this module, provided that you retain the original copyright notice.

---

## Credits

- **Author:** MyPanelHost LLC
- **Website:** [https://mypanelhost.com](https://mypanelhost.com)
- **Repository:** [GitHub](https://github.com/mypanelhost/whmcs-header-footer-injection)
