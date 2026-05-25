# Header & Footer Code Injection para WHMCS

**Versão:** 0.2 | **Autor:** MyPanelHost LLC | **Licença:** GPL

Um módulo addon leve para WHMCS que permite injetar código JavaScript, CSS, HTML, meta tags e qualquer outro código estático no **head**, **header** (após `<body>`) e **footer** (antes de `</body>`) da área do cliente — sem modificar arquivos de template.

---

## Funcionalidades

- **Três zonas de injeção** — Injeta código no `<head>`, após `<body>` e antes de `</body>`.
- **Ativação/desativação individual** — Cada zona pode ser ligada ou desligada independentemente pelo painel de administração.
- **Sem editar templates** — Funciona através de hooks do WHMCS; não é necessário modificar arquivos `.tpl`.
- **Única consulta ao banco de dados** — Todas as configurações são armazenadas em cache em memória com uma única leitura de `tbladdonmodules`.
- **Suporte multi-idioma** — Inclui traduções para inglês, espanhol e português. Facilmente extensível.
- **Pegada mínima** — Apenas dois arquivos PHP mais arquivos de idioma. Sem alterações no esquema do banco de dados.
- **Atualização segura** — As configurações são preservadas ao atualizar o módulo.

---

## Requisitos

- WHMCS 7.x, 8.x ou superior
- PHP 7.3 ou superior

---

## Instalação

### 1. Enviar o módulo

Copie a pasta `kn_header_footer_injection` para o diretório `modules/addons/` do seu WHMCS:

```bash
cp -r kn_header_footer_injection /caminho/para/whmcs/modules/addons/
```

Estrutura esperada após copiar:

```
modules/addons/kn_header_footer_injection/
├── kn_header_footer_injection.php
├── hooks.php
└── lang/
    ├── english.php
    ├── spanish.php
    └── portuguese.php
```

### 2. Ativar o módulo

1. Faça login no **Painel de Administração** do WHMCS.
2. Vá em **Configurações do Sistema → Módulos Addon** (ou *Setup → Addon Modules*).
3. Encontre **"Header & Footer Code Injection"** na lista.
4. Clique no botão **Ativar**.

### 3. Configurar o módulo

1. Após a ativação, clique em **Configurar** ao lado do módulo.
2. Cole seu código no campo de texto correspondente:
   - **Código no Head** — para injeção no `<head>` (analytics, meta tags, fontes, etc.).
   - **Código no Header** — para conteúdo logo após `<body>` (barras superiores, banners, avisos).
   - **Código no Footer** — para conteúdo antes de `</body>` (widgets de chat, analytics, scripts).
3. Certifique-se de que o interruptor **Ativar** correspondente esteja em **Sim**.
4. Clique em **Salvar Alterações**.

> 💡 **Dica:** Você pode deixar campos vazios e ativar/desativar zonas conforme necessário.

---

## Exemplos de uso

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

→ Cole no campo **Footer**.

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

→ Cole no campo **Head**.

### Barra de promoção (header)

```html
<div style="background: #ff6b35; color: #fff; text-align: center; padding: 10px; font-weight: bold;">
  🎉 Oferta por tempo limitado — 30% DE DESCONTO no seu primeiro pedido! Use o código <strong>BEMVINDO30</strong>
</div>
```

→ Cole no campo **Header**.

### Widget de chat ao vivo (footer)

```html
<script>
  window.__lc = window.__lc || {};
  window.__lc.license = SEU_NUMERO_DE_LICENCA;
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

→ Cole no campo **Footer**.

---

## Referência de Hooks

| Hook | Função | Disparador |
|---|---|---|
| `ClientAreaHeadOutput` | `kn_hfi_head` | Antes de `</head>` |
| `ClientAreaHeaderOutput` | `kn_hfi_header` | Após `<body>` |
| `ClientAreaFooterOutput` | `kn_hfi_footer` | Antes de `</body>` |

Todos os hooks executam com prioridade **1** (a mais alta). O módulo armazena configurações em cache em `$_POST` para evitar leituras repetidas ao banco de dados durante um único carregamento de página.

---

## Suporte Multi-idioma

O módulo carrega as traduções automaticamente conforme o **idioma do administrador** configurado no WHMCS.

### Idiomas incluídos

| Idioma | Arquivo |
|---|---|
| Inglês | `lang/english.php` |
| Espanhol | `lang/spanish.php` |
| Português | `lang/portuguese.php` |

### Adicionar um novo idioma

1. Crie um novo arquivo em `lang/` com o nome do código de idioma do WHMCS, ex. `french.php`:
2. Defina todas as chaves `$_ADDONLANG` com suas traduções.
3. O WHMCS detectará e carregará automaticamente quando o administrador mudar para esse idioma.

**Comportamento de fallback:** Se um arquivo de idioma estiver faltando, o módulo usa o inglês como fallback.

---

## Solução de problemas

| Sintoma | Causa provável | Solução |
|---|---|---|
| O código não aparece no site | O interruptor de ativação está em **Não** | Vá em Configuração e coloque o interruptor em **Sim** |
| O código aparece em todas as páginas exceto uma específica | Essa página pode não executar o hook | Certifique-se de que use o tema padrão da área do cliente |
| Erros de PHP após atualização | Arquivo de idioma desatualizado | Reenvie os arquivos mais recentes de `lang/` |
| Alterações não surtem efeito | Cache do navegador | Limpe o cache do navegador ou use uma janela anônima |

---

## Perguntas Frequentes

**Posso injetar código apenas para grupos específicos de clientes?**
Não diretamente — o módulo injeta código para todos os usuários. Você pode envolver seu código em condicionais PHP dentro de `hooks.php` se necessário.

**Este módulo afeta as páginas da área de administração?**
Não. Ele injeta apenas nos hooks `ClientArea*Output`, portanto as páginas de administração nunca são modificadas.

**Minhas configurações sobreviverão a uma atualização do módulo?**
Sim. Todas as configurações são armazenadas na tabela `tbladdonmodules` do banco de dados e persistem entre atualizações.

**Há um limite na quantidade de código que posso injetar?**
Não. Os campos de texto aceitam entrada ilimitada, mas recomendamos manter o código injetado o mais mínimo possível por desempenho.

---

## Registro de alterações

### 0.2 (2025-05-25)
- Adicionado suporte multi-idioma (inglês, espanhol, português)
- Adicionada estrutura de diretório `lang/`
- Refatoração interna para preparação de traduções

### 0.1 (Versão inicial)
- Injeção básica em head, header e footer
- Interruptores de ativação/desativação para cada zona
- Única consulta ao banco de dados com cache em memória

---

## Licença

Este projeto está licenciado sob a **GNU General Public License v3.0**.

Você é livre para usar, modificar e redistribuir este módulo, desde que mantenha o aviso de copyright original.

---

## Créditos

- **Autor:** MyPanelHost LLC
- **Site:** [https://mypanelhost.com](https://mypanelhost.com)
- **Repositório:** [GitHub](https://github.com/mypanelhost/whmcs-header-footer-injection)
