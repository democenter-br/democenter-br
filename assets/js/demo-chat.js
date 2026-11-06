/**
 * assets/js/demo-chat.js
 * ---------------------------------------------------------------------------
 * Widget flutuante "Borderbot" (balão de chat) injetado via JS nas
 * páginas do Demo Center. Constrói seu próprio DOM (botão flutuante, painel de
 * chat e modal de aviso legal/uso), permanece em espanhol (partner edition),
 * aplica um limite de 3 consultas por dia por navegador (via localStorage,
 * apenas como UX -- o limite real e autoritativo é aplicado no servidor em
 * api/demo-chat.php) e chama esse endpoint para obter as respostas.
 * Auto-executa como IIFE para não poluir o escopo global; se o widget já
 * existir na página (id="demo-chat-root") não faz nada (evita duplicatas).
 * ---------------------------------------------------------------------------
 */
(function () {
  if (document.getElementById('demo-chat-root')) return; // Evita injetar o widget duas vezes se o script for carregado mais de uma vez.

  // Textos do widget (independentes do sistema i18n das
  // páginas, porque este widget é injetado via JS).
  var ES = {
    title: 'Borderbot',
    sub: 'Somente consultas do Demo Center · 3 por dia',
    ph: 'Ex.: onde fica o ZTNA?',
    send: 'Enviar',
    hi: 'Olá, eu sou o Borderbot. Só respondo perguntas sobre este Demo Center.',
    alertTitle: 'Borderbot',
    alertBody: 'Use-o somente para consultas sobre o Demo Center (páginas, demos, IPs e como navegar neste portal).<br><br>Não é um assistente geral.<br><br>Limite: 3 interações por pessoa, por dia.',
    ok: 'Entendi',
    quota: 'Você já usou as 3 interações de hoje. Volte amanhã.'
  };
  /** Partner edition: o widget permanece somente em espanhol. */
  function copy() { return ES; }
  /** Código de idioma enviado ao backend. */
  function lang() { return 'es'; }

  /**
   * Obtém (ou gera e persiste no localStorage) um identificador de usuário
   * anônimo por navegador. É enviado ao backend para controlar a cota "por
   * usuário" (além da cota global) em api/demo-chat.php.
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
  /** Data atual no formato YYYY-MM-DD (UTC), usada como chave da cota diária. */
  function today() { return new Date().toISOString().slice(0, 10); }
  /**
   * Quantidade de mensagens já usadas hoje segundo o localStorage (apenas para UX local,
   * não é a fonte da verdade: o servidor valida novamente a cota real).
   */
  function used() {
    try {
      var o = JSON.parse(localStorage.getItem('borderbot_quota') || '{}');
      return o.d === today() ? (o.n || 0) : 0;
    } catch (e) { return 0; }
  }
  /** Incrementa em 1 o contador local de mensagens usadas hoje. */
  function bump() {
    localStorage.setItem('borderbot_quota', JSON.stringify({ d: today(), n: used() + 1 }));
  }

  var avatar = '/assets/images/borderbot.png'; // Avatar do bot, reutilizado no botão, no header do painel e no modal de aviso.
  // Constrói o botão flutuante + painel de chat e os insere no <body>.
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

  // Constrói o modal ("mask") de aviso de uso exibido na primeira vez
  // que o usuário abre o chat na sessão, antes de permitir que ele escreva.
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

  /** Aplica o dicionário de idioma atual a todos os textos estáticos do widget. */
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
  /** Adiciona uma mensagem ao histórico do chat com a classe CSS indicada ('user'/'bot'/'err'). */
  function add(text, cls) {
    var d = document.createElement('div');
    d.className = 'demo-chat-msg ' + cls;
    d.textContent = text;
    log.appendChild(d);
    log.scrollTop = log.scrollHeight;
  }
  applyUi();
  add(copy().hi, 'bot'); // Saudação inicial do bot, exibida assim que a página é carregada.
  greeted = true;

  /**
   * Se a cota local de 3 mensagens/dia já foi atingida, desabilita o input e
   * o botão de enviar e exibe a mensagem de "cota esgotada". Devolve true
   * se ficou bloqueado (para que o chamador não siga com o fluxo normal).
   */
  function lockIfQuota() {
    if (used() < 3) return false;
    input.disabled = true;
    send.disabled = true;
    add(copy().quota, 'err');
    return true;
  }
  lockIfQuota();

  // Abre/fecha o painel de chat ao clicar no botão flutuante.
  document.getElementById('demo-chat-toggle').addEventListener('click', function () {
    if (root.classList.contains('open')) {
      root.classList.remove('open');
      return;
    }
    applyUi();
    mask.classList.add('show');
  });
  // Fecha o modal de aviso e abre o painel de chat quando o usuário confirma que entendeu.
  document.getElementById('demo-chat-alert-ok').addEventListener('click', function () {
    mask.classList.remove('show');
    root.classList.add('open');
    if (!lockIfQuota()) input.focus();
  });
  // Envio do formulário: valida a cota local, exibe a mensagem do usuário,
  // chama o backend (api/demo-chat.php) e exibe a resposta ou o erro.
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
          add((res.j && res.j.error) || 'Não houve resposta', 'err');
        }
      })
      .catch(function () {
        send.disabled = false;
        add('Erro de rede ao chamar o Borderbot', 'err');
      });
  });
})();
