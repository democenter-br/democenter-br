/**
 * assets/js/i18n-common.js
 * ---------------------------------------------------------------------------
 * Diccionario de traducciones en español con las cadenas que se repiten
 * IDÉNTICAS en varias de las páginas de demo del Democenter Netskope.
 * Partner edition: PT-BR se eliminó; este archivo solo expone `es`.
 *
 * Se carga en TODAS las páginas "simples" del sitio (todas menos demos.php),
 * justo antes del script inline propio de cada página, y se fusiona con el
 * diccionario específico de esa página así:
 *
 *   const translations = {
 *       es: { ...NetskopeCommonI18n.es, "clave_propia_1": "...", ... }
 *   };
 *
 * El diccionario propio de cada página va DESPUÉS en el spread para poder
 * sobreescribir una clave común si alguna vez hiciera falta (aunque hoy no se
 * usa esa posibilidad).
 *
 * Qué se incluyó aquí (y qué no):
 * - Las 3 claves de navegación inferior "¿Quién es Netskope? / Volver a la
 *   landing / ¿Quieres Verlo? 😉" aparecían, con el mismo texto exacto,
 *   en agenticai.php, aicontrol.php, vpnevolution.php, navigationevolution.php,
 *   dataprotection.php y networktransformation.php - pero cada página usaba un
 *   nombre de clave data-i18n distinto (btn.who / btn_who / btnWho, etc.). Se
 *   unificaron aquí bajo nombres canónicos (nav_who / nav_back / nav_demo) y
 *   se actualizaron los atributos data-i18n de esas 6 páginas para usarlos.
 * - El botón "Volver a..." de oopsyoudidit.php NO se incluyó aquí porque su
 *   texto es distinto ("Volver a un lugar seguro" en vez de "Volver a la
 *   landing"): es contenido genuinamente específico de esa página.
 * - Los textos de pie de página (© ... Netskope. All rights reserved.) NO
 *   están en el sistema de i18n en ninguna página (están hardcodeados en
 *   inglés igual en los 2 idiomas), así que no había nada que centralizar ahí.
 * - Los "taglines" del header (p. ej. "SaaS y Navegación Segura", "Casos de
 *   Éxito LATAM") son distintos en cada página (identifican la página), por lo
 *   que se dejaron como contenido específico de cada una.
 * - keydifferentiators.php NO se fusiona con este archivo: usa su propio
 *   catálogo cargado desde assets/json/keydifferentiators.i18n.json (ver
 *   comentario al inicio de ese .php). Si en el futuro se quiere compartir
 *   texto con esa página, hay que sincronizar manualmente ambos catálogos.
 *
 * Duda para revisar (flag para Leo): las secciones "Lo que dicen los
 * analistas" (market.title / analystSays / market_title / analyst_title,
 * presentes en agenticai/aicontrol/dataprotection/navigationevolution/
 * networktransformation/vpnevolution) tienen en la mayoría de los casos un
 * sufijo distinto por página ("...sobre IA generativa", "...sobre Single
 * Vendor SASE", etc.), por lo que NO se centralizaron. Pero agenticai.php,
 * dataprotection.php y navigationevolution.php usan el título genérico
 * "Lo que dicen los analistas" sin sufijo — si se confirma que debe ser
 * siempre igual en esas 3, podría moverse aquí en una futura pasada.
 * ---------------------------------------------------------------------------
 */
const NetskopeCommonI18n = {
    es: {
        "nav_who": "¿Quién es Netskope?",
        "nav_back": "Volver a la landing",
        "nav_demo": "¿Quieres Verlo? 😉"
    }
};
