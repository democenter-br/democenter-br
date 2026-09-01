/**
 * assets/js/common.js
 * ---------------------------------------------------------------------------
 * Funciones JS compartidas por las páginas de demo del Democenter Netskope.
 *
 * Contexto: cada una de las 11 páginas "simples" del sitio (index.php,
 * keydifferentiators.php, navigationevolution.php, customerreferences.php,
 * vpnevolution.php, aicontrol.php, oopsyoudidit.php, agenticai.php,
 * networktransformation.php, reportai.php, dataprotection.php, reportit.php)
 * tenía su propia copia, prácticamente idéntica, de las funciones de cambio de
 * idioma y (en algunas) de apertura/cierre de modal. Este archivo centraliza
 * esas funciones para evitar tener que editar hasta 11 archivos cada vez que
 * se corrige un bug o se ajusta el comportamiento.
 *
 * demos.php (la página de demos interactivas, ~2500 líneas) NO fue migrada a
 * este archivo en esta pasada por su tamaño/complejidad; queda para una pasada
 * aparte. Sin embargo, las funciones de portapapeles de abajo (copyPlainText,
 * fallbackCopyText, showCopyFeedback) se escribieron para ser compatibles con
 * la forma en que demos.php ya las usa, de modo que ese archivo pueda migrar a
 * este común más adelante sin cambios de comportamiento.
 *
 * Cómo se usa en cada página:
 *   <script src="assets/js/common.js"></script>
 *   <script src="assets/js/i18n-common.js"></script>
 *   <script> ... script inline propio de la página (con su const translations = {...}) ... </script>
 *
 * Los <script> de arriba deben cargarse ANTES del script inline de cada
 * página, porque este último normalmente llama a changeLanguage(...) en su
 * DOMContentLoaded / IIFE de inicialización.
 * ---------------------------------------------------------------------------
 */

/**
 * Namespace con utilidades de idioma. Se expone como objeto (en vez de sólo
 * funciones sueltas) para que páginas con lógica adicional de changeLanguage
 * (p. ej. reportai.php / reportit.php, que también deben refrescar gráficas
 * Chart.js al cambiar de idioma) puedan reusar el "trabajo pesado" de aplicar
 * el diccionario al DOM sin duplicar ese código en su propia función
 * changeLanguage local.
 */
const NetskopeCommon = {
    /**
     * Aplica el idioma al documento. Partner edition: solo español. Cualquier
     * valor distinto de 'es' (incluido un 'pt' viejo en localStorage) se
     * normaliza a 'es'. Reemplaza el innerHTML de todos los elementos
     * [data-i18n] usando el diccionario, fija <html lang="es">, y persiste
     * la preferencia en localStorage bajo la clave 'netskope-lang'.
     *
     * @param {string} lang - se ignora si no es 'es'
     * @param {Object} dictionaries - objeto con la forma { es: {...} } (normalmente la
     *                                variable `translations` que cada página define en su script inline)
     * @returns {string} el idioma efectivamente aplicado, ya normalizado (útil para que quien
     *                    llama pueda usarlo después, p. ej. para refrescar gráficas)
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
            // Igual que en la versión más completa que existía en demos.php: si el
            // elemento es un <pre>, se usa textContent (para no interpretar HTML
            // dentro de bloques de código); en cualquier otro caso, innerHTML.
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
 * Función global de compatibilidad para las páginas que NO tienen lógica
 * adicional propia (sin gráficas, sin secciones que cambian de visibilidad
 * según el idioma, etc.). Estas páginas simplemente definen su propio
 * `const translations = { es: {...} }` en su script inline y dejan
 * que esta función (cargada antes, desde este archivo) se encargue de todo.
 *
 * Páginas con necesidades especiales (reportai.php, reportit.php, que refrescan
 * gráficas Chart.js; keydifferentiators.php, que tiene lógica adicional de
 * idioma ibérico y carga su catálogo desde un JSON externo) definen su PROPIA
 * función changeLanguage en su script inline. Como las declaraciones de
 * función posteriores sobrescriben a las anteriores en el mismo scope global,
 * esas páginas simplemente "ganan" sobre esta versión sin ningún conflicto.
 *
 * @param {string} lang - solo 'es' en partner edition
 */
function changeLanguage(lang) {
    if (typeof translations === 'undefined') return;
    NetskopeCommon.applyLanguage(lang, translations);
}

/**
 * openModal(modalId) / closeModal(modalId)
 * ---------------------------------------------------------------------------
 * Abre/cierra un modal simple identificado por su ID de elemento, mostrando u
 * ocultando el contenedor con style.display y bloqueando/restaurando el
 * scroll del body. Esta es la implementación que compartían aicontrol.php y
 * dataprotection.php de forma prácticamente idéntica (y que
 * networktransformation.php replicaba bajo el nombre openImageModal/closeModal).
 *
 * Nota de discrepancia encontrada al consolidar: la copia de closeModal() que
 * tenía dataprotection.php contenía un bug de copy/paste:
 *     document.getElementById(modalAddress = modalId)
 * (una asignación accidental a una variable global no declarada `modalAddress`
 * en vez de pasar simplemente `modalId`). No cambiaba el resultado visible
 * porque la expresión de asignación igual evalúa al valor de modalId, pero es
 * código confuso/con fuga de variable global. Esta versión consolidada no lo
 * reproduce.
 *
 * keydifferentiators.php define sus PROPIAS versiones de openModal/closeModal
 * con una firma distinta (reciben el elemento del modal, no un ID) y lógica
 * distinta (classList en vez de style.display); esas se mantienen locales en
 * ese archivo a propósito y sobrescriben a estas sin conflicto.
 *
 * @param {string} modalId - id del elemento contenedor del modal
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
 * Funciones de portapapeles ("Copiar" en bloques de código / comandos de las
 * demos). Ninguna de las 11 páginas "simples" las usa hoy (solo demos.php),
 * pero se incluyen aquí ya generalizadas -y documentadas- para que una futura
 * consolidación de demos.php pueda apuntar a esta única implementación en vez
 * de mantener su propia copia.
 *
 * La versión original en demos.php dependía de una función local `t(key, fallback)`
 * para obtener el texto "¡Copiado!" traducido; aquí se generalizó recibiendo
 * ese texto como parámetro opcional (copiedLabel), con 'Copiado!' como default,
 * para no acoplar este archivo común a la función de traducción interna de demos.php.
 */

/**
 * copyPlainText(codeText, feedbackEl, copiedLabel)
 * Copia texto plano al portapapeles probando, en orden: (1) el método
 * "fallback" basado en un <textarea> oculto + document.execCommand('copy')
 * (más confiable en iframes/contextos restringidos), (2) la Clipboard API
 * moderna (navigator.clipboard.writeText), y (3) como último recurso, un
 * window.prompt() para que el usuario copie manualmente.
 *
 * @param {string} codeText - texto a copiar
 * @param {HTMLElement} [feedbackEl] - elemento donde mostrar el feedback "¡Copiado!" (ver showCopyFeedback)
 * @param {string} [copiedLabel] - texto de feedback a mostrar (default: 'Copiado!')
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
            window.prompt('Copia el texto (Ctrl/Cmd+C) y pulsa Aceptar:', str);
        });
        return;
    }
    window.prompt('Copia el texto (Ctrl/Cmd+C) y pulsa Aceptar:', str);
}

/**
 * fallbackCopyText(codeText, feedbackEl, silent, copiedLabel)
 * Método de copia "clásico": crea un <textarea> invisible fuera de pantalla,
 * selecciona su contenido y ejecuta document.execCommand('copy'). Se usa como
 * primer intento porque funciona en más contextos (incluyendo iframes) que la
 * Clipboard API moderna.
 *
 * @param {string} codeText - texto a copiar
 * @param {HTMLElement} [feedbackEl] - elemento de feedback (solo se usa si silent es false)
 * @param {boolean} [silent] - si true, no muestra el feedback aquí (lo hace el llamador, p. ej. copyPlainText)
 * @param {string} [copiedLabel] - texto de feedback a mostrar
 * @returns {boolean} true si el navegador reportó la copia como exitosa
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
 * Muestra brevemente (2s) un texto de confirmación ("¡Copiado!" por defecto)
 * en el elemento indicado, y luego restaura su texto original.
 *
 * @param {HTMLElement} [feedbackEl] - elemento a actualizar; si no se indica, se usa #copyText
 * @param {string} [copiedLabel] - texto a mostrar temporalmente (default: 'Copiado!')
 */
function showCopyFeedback(feedbackEl, copiedLabel) {
    const btnText = feedbackEl || document.getElementById('copyText');
    if (!btnText) return;
    const originalText = btnText.innerText;
    btnText.innerText = copiedLabel || 'Copiado!';
    setTimeout(() => { btnText.innerText = originalText; }, 2000);
}
