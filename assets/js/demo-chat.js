/**
 * assets/js/demo-chat.js
 * ---------------------------------------------------------------------------
 * Widget flotante "Borderbot" (burbuja de chat) que se inyecta por JS en las
 * páginas del Demo Center. Construye su propio DOM (botón flotante, panel de
 * chat y modal de aviso legal/uso), queda en español (partner edition),
 * aplica un límite de 3 consultas por día por navegador (via localStorage,
 * solo como UX -- el límite real y autoritativo se aplica server-side en
 * api/demo-chat.php) y llama a ese endpoint para obtener las respuestas.
 * Se auto-ejecuta como IIFE para no ensuciar el scope global; si el widget ya
 * existe en la página (id="demo-chat-root") no hace nada (evita duplicados).
 * ---------------------------------------------------------------------------
 */
(function () {
  if (document.getElementById('demo-chat-root')) return; // Evita inyectar el widget dos veces si el script se carga más de una vez.

  // Textos del widget en español (independientes del sistema i18n de las
  // páginas, porque este widget se inyecta por JS).
  var ES = {
    title: 'Borderbot',
    sub: 'Solo consultas del Demo Center · 3 por dia',
    ph: 'Ej.: donde esta el ZTNA?',
    send: 'Enviar',
    hi: 'Hola, soy Borderbot. Solo respondo preguntas de este Demo Center.',
    alertTitle: 'Borderbot',
    alertBody: 'Usalo solo para consultas del Demo Center (paginas, demos, IPs y como navegar este portal).<br><br>No es un asistente general.<br><br>Limite: 3 interacciones por persona, por dia.',
    ok: 'Entendido',
    quota: 'Ya usaste las 3 interacciones de hoy. Vuelve manana.'
  };
  /** Partner edition: el widget queda solo en español. */
  function copy() { return ES; }
  /** Código de idioma que se envía al backend. */
  function lang() { return 'es'; }

  /**
   * Obtiene (o genera y persiste en localStorage) un identificador de usuario
   * anónimo por navegador. Se envía al backend para llevar la cuota "por
   * usuario" (además de la cuota global) en api/demo-chat.php.
   */
  function uid() {
    var k = 'borderbot_uid';
    var v = localStorage.getItem(k);
    if (!v) {
      v = 'u' + Math.random().toString(36).slice(2) + Date.now().toString(36);
      localStorage.setItem(k, v);
    }
    return v;
  }
  /** Fecha actual en formato YYYY-MM-DD (UTC), usada como clave de cuota diaria. */
  function today() { return new Date().toISOString().slice(0, 10); }
  /**
   * Cantidad de mensajes ya usados hoy según localStorage (solo para UX local,
   * no es la fuente de verdad: el servidor vuelve a validar la cuota real).
   */
  function used() {
    try {
      var o = JSON.parse(localStorage.getItem('borderbot_quota') || '{}');
      return o.d === today() ? (o.n || 0) : 0;
    } catch (e) { return 0; }
  }
  /** Incrementa en 1 el contador local de mensajes usados hoy. */
  function bump() {
    localStorage.setItem('borderbot_quota', JSON.stringify({ d: today(), n: used() + 1 }));
  }

  var avatar = '/assets/images/borderbot.png'; // Avatar del bot, reutilizado en el botón, el header del panel y el modal de aviso.
  // Construye el botón flotante + panel de chat y los inserta en el <body>.
  var root = document.createElement('div');
  root.id = 'demo-chat-root';
  root.innerHTML =
    '<div id="demo-chat-panel">' +
      '<div id="demo-chat-head"><img src="' + avatar + '" alt="Borderbot"><div><span id="bb-title"></span><small id="bb-sub"></small></div></div>' +
      '<div id="demo-chat-log"></div>' +
      '<form id="demo-chat-form">' +
        '<input id="demo-chat-input" autocomplete="off">' +
        '<button id="demo-chat-send" type="submit"></button>' +
      '</form>' +
    '</div>' +
    '<button id="demo-chat-toggle" type="button" aria-label="Borderbot"><img src="' + avatar + '" alt="Borderbot"></button>';
  document.body.appendChild(root);

  // Construye el modal ("mask") de aviso de uso que se muestra la primera vez
  // que el usuario abre el chat en la sesión, antes de dejarlo escribir.
  var mask = document.createElement('div');
  mask.id = 'demo-chat-mask';
  mask.innerHTML =
    '<div id="demo-chat-alert">' +
      '<img src="' + avatar + '" alt="Borderbot">' +
      '<h3 id="bb-alert-title"></h3>' +
      '<p id="bb-alert-body"></p>' +
      '<button type="button" id="demo-chat-alert-ok"></button>' +
    '</div>';
  document.body.appendChild(mask);

  var log = document.getElementById('demo-chat-log');
  var input = document.getElementById('demo-chat-input');
  var send = document.getElementById('demo-chat-send');
  var greeted = false;

  /** Aplica el diccionario de idioma actual a todos los textos estáticos del widget. */
  function applyUi() {
    var c = copy();
    document.getElementById('bb-title').textContent = c.title;
    document.getElementById('bb-sub').textContent = c.sub;
    input.placeholder = c.ph;
    send.textContent = c.send;
    document.getElementById('bb-alert-title').textContent = c.alertTitle;
    document.getElementById('bb-alert-body').innerHTML = c.alertBody;
    document.getElementById('demo-chat-alert-ok').textContent = c.ok;
  }
  /** Agrega un mensaje al historial del chat con la clase CSS dada ('user'/'bot'/'err'). */
  function add(text, cls) {
    var d = document.createElement('div');
    d.className = 'demo-chat-msg ' + cls;
    d.textContent = text;
    log.appendChild(d);
    log.scrollTop = log.scrollHeight;
  }
  applyUi();
  add(copy().hi, 'bot'); // Saludo inicial del bot, mostrado apenas se carga la página.
  greeted = true;

  /**
   * Si ya se alcanzó la cuota local de 3 mensajes/día, deshabilita el input y
   * el botón de enviar y muestra el mensaje de "cuota agotada". Devuelve true
   * si quedó bloqueado (para que el llamador no siga con el flujo normal).
   */
  function lockIfQuota() {
    if (used() < 3) return false;
    input.disabled = true;
    send.disabled = true;
    add(copy().quota, 'err');
    return true;
  }
  lockIfQuota();

  // Abre/cierra el panel de chat al hacer clic en el botón flotante.
  document.getElementById('demo-chat-toggle').addEventListener('click', function () {
    if (root.classList.contains('open')) {
      root.classList.remove('open');
      return;
    }
    applyUi();
    mask.classList.add('show');
  });
  // Cierra el modal de aviso y abre el panel de chat cuando el usuario confirma que entendió.
  document.getElementById('demo-chat-alert-ok').addEventListener('click', function () {
    mask.classList.remove('show');
    root.classList.add('open');
    if (!lockIfQuota()) input.focus();
  });
  // Envío del formulario: valida cuota local, muestra el mensaje del usuario,
  // llama al backend (api/demo-chat.php) y muestra la respuesta o el error.
  document.getElementById('demo-chat-form').addEventListener('submit', function (ev) {
    ev.preventDefault();
    if (used() >= 3) { lockIfQuota(); return; }
    var q = (input.value || '').trim();
    if (!q) return;
    input.value = '';
    add(q, 'user');
    send.disabled = true;
    fetch('/api/demo-chat.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ q: q, lang: lang(), uid: uid() })
    }).then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
      .then(function (res) {
        send.disabled = false;
        if (res.j && res.j.a) {
          bump();
          add(res.j.a, 'bot');
          lockIfQuota();
        } else {
          add((res.j && res.j.error) || 'No hubo respuesta', 'err');
        }
      })
      .catch(function () {
        send.disabled = false;
        add('Error de red al llamar a Borderbot', 'err');
      });
  });
})();
