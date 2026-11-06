/**
 * assets/js/common.js
 * ---------------------------------------------------------------------------
 * Funções JS compartilhadas pelas páginas de demo do Democenter Netskope.
 *
 * Contexto: cada uma das 11 páginas "simples" do site (index.php,
 * keydifferentiators.php, navigationevolution.php, customerreferences.php,
 * vpnevolution.php, aicontrol.php, oopsyoudidit.php, agenticai.php,
 * networktransformation.php, reportai.php, dataprotection.php, reportit.php)
 * tinha sua própria cópia, praticamente idêntica, das funções de troca de
 * idioma e (em algumas) de abertura/fechamento de modal. Este arquivo centraliza
 * essas funções para evitar ter que editar até 11 arquivos a cada vez que
 * um bug é corrigido ou o comportamento é ajustado.
 *
 * demos.php (a página de demos interativas, ~2500 linhas) NÃO foi migrada para
 * este arquivo nesta rodada por seu tamanho/complexidade; fica para uma rodada
 * à parte. No entanto, as funções de área de transferência abaixo (copyPlainText,
 * fallbackCopyText, showCopyFeedback) foram escritas para serem compatíveis com
 * a forma como demos.php já as usa, de modo que esse arquivo possa migrar para
 * este comum mais adiante sem mudanças de comportamento.
 *
 * Como é usado em cada página:
 *   <script src="assets/js/common.js"></script>
 *   <script src="assets/js/i18n-common.js"></script>
 *   <script> ... script inline próprio da página (com seu const translations = {...}) ... </script>
 *
 * Os <script> acima devem ser carregados ANTES do script inline de cada
 * página, porque este último normalmente chama changeLanguage(...) em seu
 * DOMContentLoaded / IIFE de inicialização.
 * ---------------------------------------------------------------------------
 */

/**
 * Namespace com utilitários de idioma. É exposto como objeto (em vez de apenas
 * funções soltas) para que páginas com lógica adicional de changeLanguage
 * (p. ex. reportai.php / reportit.php, que também precisam atualizar gráficos
 * Chart.js ao trocar de idioma) possam reutilizar o "trabalho pesado" de aplicar
 * o dicionário ao DOM sem duplicar esse código em sua própria função
 * changeLanguage local.
 */
const NetskopeCommon = {
    /**
     * Aplica o idioma ao documento. Partner edition: somente espanhol. Qualquer
     * valor diferente de 'es' (incluindo um 'pt' antigo no localStorage) é
     * normalizado para 'es'. Substitui o innerHTML de todos os elementos
     * [data-i18n] usando o dicionário, define <html lang="es"> e persiste
     * a preferência no localStorage sob a chave 'netskope-lang'.
     *
     * @param {string} lang - é ignorado se não for 'es'
     * @param {Object} dictionaries - objeto no formato { es: {...} } (normalmente a
     *                                variável `translations` que cada página define em seu script inline)
     * @returns {string} o idioma efetivamente aplicado, já normalizado (útil para que quem
     *                    chama possa usá-lo depois, p. ex. para atualizar gráficos)
     */
    applyLanguage(lang, dictionaries) {
        if (lang !== 'es') lang = 'es';
        const dict = (dictionaries && dictionaries[lang]) || {};

        document.querySelectorAll('.lang-btn').forEach((btn) => {
            btn.classList.remove('active');
            if (btn.id === 'btn-' + lang) btn.classList.add('active');
        });

        document.querySelectorAll('[data-i18n]').forEach((el) => {
            const key = el.getAttribute('data-i18n');
            if (dict[key] === undefined) return;
            // Igual à versão mais completa que existia em demos.php: se o
            // elemento for um <pre>, usa-se textContent (para não interpretar HTML
            // dentro de blocos de código); em qualquer outro caso, innerHTML.
            if (el.tagName === 'PRE') {
                el.textContent = dict[key];
            } else {
                el.innerHTML = dict[key];
            }
        });

        document.documentElement.lang = lang;
        localStorage.setItem('netskope-lang', lang);

        return lang;
    }
};

/**
 * changeLanguage(lang)
 * ---------------------------------------------------------------------------
 * Função global de compatibilidade para as páginas que NÃO têm lógica
 * adicional própria (sem gráficos, sem seções que mudam de visibilidade
 * conforme o idioma, etc.). Essas páginas simplesmente definem seu próprio
 * `const translations = { es: {...} }` em seu script inline e deixam
 * que esta função (carregada antes, a partir deste arquivo) cuide de tudo.
 *
 * Páginas com necessidades especiais (reportai.php, reportit.php, que atualizam
 * gráficos Chart.js; keydifferentiators.php, que tem lógica adicional de
 * idioma ibérico e carrega seu catálogo de um JSON externo) definem sua PRÓPRIA
 * função changeLanguage em seu script inline. Como as declarações de
 * função posteriores sobrescrevem as anteriores no mesmo escopo global,
 * essas páginas simplesmente "ganham" sobre esta versão sem nenhum conflito.
 *
 * @param {string} lang - somente 'es' na partner edition
 */
function changeLanguage(lang) {
    if (typeof translations === 'undefined') return;
    NetskopeCommon.applyLanguage(lang, translations);
}

/**
 * openModal(modalId) / closeModal(modalId)
 * ---------------------------------------------------------------------------
 * Abre/fecha um modal simples identificado pelo ID do elemento, exibindo ou
 * ocultando o contêiner com style.display e bloqueando/restaurando o
 * scroll do body. Esta é a implementação que aicontrol.php e
 * dataprotection.php compartilhavam de forma praticamente idêntica (e que
 * networktransformation.php replicava com o nome openImageModal/closeModal).
 *
 * Nota de discrepância encontrada ao consolidar: a cópia de closeModal() que
 * dataprotection.php tinha continha um bug de copiar/colar:
 *     document.getElementById(modalAddress = modalId)
 * (uma atribuição acidental a uma variável global não declarada `modalAddress`
 * em vez de simplesmente passar `modalId`). Não alterava o resultado visível
 * porque a expressão de atribuição avalia para o valor de modalId do mesmo jeito, mas é
 * um código confuso e com vazamento de variável global. Esta versão consolidada não o
 * reproduz.
 *
 * keydifferentiators.php define suas PRÓPRIAS versões de openModal/closeModal
 * com uma assinatura diferente (recebem o elemento do modal, não um ID) e lógica
 * diferente (classList em vez de style.display); elas são mantidas locais nesse
 * arquivo de propósito e sobrescrevem estas sem conflito.
 *
 * @param {string} modalId - id do elemento contêiner do modal
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

/**
 * Funções de área de transferência ("Copiar" em blocos de código / comandos das
 * demos). Nenhuma das 11 páginas "simples" as usa hoje (somente demos.php),
 * mas elas são incluídas aqui já generalizadas -e documentadas- para que uma futura
 * consolidação de demos.php possa apontar para esta única implementação em vez
 * de manter sua própria cópia.
 *
 * A versão original em demos.php dependia de uma função local `t(key, fallback)`
 * para obter o texto "Copiado!" traduzido; aqui ela foi generalizada recebendo
 * esse texto como parâmetro opcional (copiedLabel), com 'Copiado!' como padrão,
 * para não acoplar este arquivo comum à função de tradução interna de demos.php.
 */

/**
 * copyPlainText(codeText, feedbackEl, copiedLabel)
 * Copia texto simples para a área de transferência tentando, em ordem: (1) o método
 * "fallback" baseado em um <textarea> oculto + document.execCommand('copy')
 * (mais confiável em iframes/contextos restritos), (2) a Clipboard API
 * moderna (navigator.clipboard.writeText) e (3) como último recurso, um
 * window.prompt() para que o usuário copie manualmente.
 *
 * @param {string} codeText - texto a copiar
 * @param {HTMLElement} [feedbackEl] - elemento onde exibir o feedback "Copiado!" (ver showCopyFeedback)
 * @param {string} [copiedLabel] - texto de feedback a exibir (padrão: 'Copiado!')
 */
function copyPlainText(codeText, feedbackEl, copiedLabel) {
    if (codeText == null) return;
    const str = String(codeText);
    let copied = false;
    try {
        copied = fallbackCopyText(str, null, true);
    } catch (e) {
        copied = false;
    }
    if (copied) {
        showCopyFeedback(feedbackEl, copiedLabel);
        return;
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(str).then(function () {
            showCopyFeedback(feedbackEl, copiedLabel);
        }).catch(function () {
            window.prompt('Copie o texto (Ctrl/Cmd+C) e clique em OK:', str);
        });
        return;
    }
    window.prompt('Copie o texto (Ctrl/Cmd+C) e clique em OK:', str);
}

/**
 * fallbackCopyText(codeText, feedbackEl, silent, copiedLabel)
 * Método de cópia "clássico": cria um <textarea> invisível fora da tela,
 * seleciona seu conteúdo e executa document.execCommand('copy'). É usado como
 * primeira tentativa porque funciona em mais contextos (inclusive iframes) do que a
 * Clipboard API moderna.
 *
 * @param {string} codeText - texto a copiar
 * @param {HTMLElement} [feedbackEl] - elemento de feedback (só é usado se silent for false)
 * @param {boolean} [silent] - se true, não exibe o feedback aqui (o chamador faz isso, p. ex. copyPlainText)
 * @param {string} [copiedLabel] - texto de feedback a exibir
 * @returns {boolean} true se o navegador reportou a cópia como bem-sucedida
 */
function fallbackCopyText(codeText, feedbackEl, silent, copiedLabel) {
    const textArea = document.createElement('textarea');
    textArea.value = codeText;
    textArea.setAttribute('readonly', '');
    textArea.style.position = 'fixed';
    textArea.style.top = '0';
    textArea.style.left = '0';
    textArea.style.width = '2em';
    textArea.style.height = '2em';
    textArea.style.padding = '0';
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
    textArea.style.background = 'transparent';
    textArea.style.opacity = '0';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    textArea.setSelectionRange(0, textArea.value.length);
    let ok = false;
    try {
        ok = document.execCommand('copy');
    } catch (err) {
        ok = false;
    }
    document.body.removeChild(textArea);
    if (ok && !silent) showCopyFeedback(feedbackEl, copiedLabel);
    return ok;
}

/**
 * showCopyFeedback(feedbackEl, copiedLabel)
 * Exibe brevemente (2s) um texto de confirmação ("Copiado!" por padrão)
 * no elemento indicado e, depois, restaura o texto original.
 *
 * @param {HTMLElement} [feedbackEl] - elemento a atualizar; se não for informado, usa #copyText
 * @param {string} [copiedLabel] - texto a exibir temporariamente (padrão: 'Copiado!')
 */
function showCopyFeedback(feedbackEl, copiedLabel) {
    const btnText = feedbackEl || document.getElementById('copyText');
    if (!btnText) return;
    const originalText = btnText.innerText;
    btnText.innerText = copiedLabel || 'Copiado!';
    setTimeout(() => { btnText.innerText = originalText; }, 2000);
}
