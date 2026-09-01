<?php
// oopsyoudidit.php - Página de "coaching"/bloqueo que se muestra cuando la demo
// simula que un usuario intentó acceder a una app o contenido restringido por
// política. Es una página de callback dentro del flujo de demo (enlazada desde
// escenarios de demos.php), con CTA de vuelta a demos.php.
//
// Las funciones JS comunes (changeLanguage, etc.) viven en assets/js/common.js
// y los textos i18n compartidos entre páginas viven en assets/js/i18n-common.js.
// El diccionario `translations` de este archivo solo contiene cadenas propias
// de esta página.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="page.title">¡Oops! Acceso Restringido</title>
    <link rel="icon" type="image/png" href="favicon.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Lora:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        netskope: {
                            deepBlue: '#081A59', blue: '#00A9CE', lightBlue: '#D9FAFF', teal: '#008095',
                            green: '#AFF198', orange: '#FF8200', darkGray: '#2A2B2D', gray: '#53565A'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], 
                        serif: ['Lora', 'serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #eef4fb;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(0, 169, 206, 0.15), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 130, 0, 0.1), transparent 25%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(8, 26, 89, 0.1);
            box-shadow: 0 20px 50px -10px rgba(8, 26, 89, 0.15);
        }
        .language-switcher {
            display: inline-flex; align-items: center; gap: 6px; padding: 4px;
            border-radius: 999px; background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(8, 26, 89, 0.12);
        }
        .lang-btn {
            min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700; color: #081A59; transition: all 0.2s;
        }
        .lang-btn.active {
            background: #081A59; color: #ffffff;
        }
        .pattern-overlay {
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(#00A9CE 1px, transparent 1px);
            background-size: 32px 32px; opacity: 0.05;
        }
    </style>
    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen text-netskope-darkGray font-sans relative overflow-hidden">
    <div class="pattern-overlay"></div>

    <!-- Header fijo: logo (link a index.php), etiqueta "Portal de Demos". -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-4">
                <span class="text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80 hidden md:inline" data-i18n="header.title">Portal de Demos</span>
            </div>
        </div>
    </header>

    <!-- Tarjeta central "Oops": ícono de alerta, mensaje de bloqueo, recuadro de
         políticas/buenas prácticas y CTA para volver a demos.php. -->
    <main class="flex-grow flex items-center justify-center py-12 px-6 relative z-10">
        <div class="max-w-3xl w-full glass-panel rounded-[24px] p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-netskope-orange via-netskope-blue to-netskope-green"></div>

            <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-red-100">
                <i data-lucide="shield-alert" class="w-12 h-12 text-netskope-orange"></i>
            </div>

            <div class="inline-flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-netskope-orange"></span>
                <span class="text-netskope-orange font-bold text-sm tracking-widest uppercase" data-i18n="hero.badge">Alerta de Seguridad</span>
            </div>
            
            <h1 class="text-3xl md:text-5xl font-black text-netskope-deepBlue mb-4" data-i18n="hero.title">¡Oops! Hiciste algo que no debías... 👀</h1>
            <p class="text-lg text-netskope-gray mb-8" data-i18n="hero.desc">Si estás viendo esta página, es probable que hayas intentado acceder a una aplicación o contenido restringido por las políticas de la organización.</p>

            <hr class="border-gray-200 mb-8">

            <div class="text-left bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-netskope-deepBlue mb-2 flex items-center gap-2">
                    <i data-lucide="book-open-check" class="w-5 h-5 text-netskope-blue"></i>
                    <span data-i18n="policy.title">Políticas y Cumplimiento Corporativo</span>
                </h2>
                <p class="text-sm text-netskope-gray mb-6 leading-relaxed" data-i18n="policy.desc">Recuerda que nuestra organización está comprometida con la seguridad de la información. Seguir las normativas no solo protege a la empresa, sino también tus datos y dispositivos.</p>
                
                <h3 class="font-bold text-netskope-teal mb-3" data-i18n="practices.title">💡 Mejores Prácticas de Navegación:</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-netskope-darkGray">
                        <i data-lucide="x-circle" class="w-5 h-5 text-netskope-orange flex-shrink-0 mt-0.5"></i>
                        <span data-i18n="prac.1">No utilices aplicaciones no autorizadas (Shadow IT) para compartir datos corporativos.</span>
                    </li>
                    <li class="flex items-start gap-3 text-sm text-netskope-darkGray">
                        <i data-lucide="shield-x" class="w-5 h-5 text-netskope-orange flex-shrink-0 mt-0.5"></i>
                        <span data-i18n="prac.2">Evita acceder a sitios de riesgo, piratería, o contenido inapropiado desde equipos de trabajo.</span>
                    </li>
                    <li class="flex items-start gap-3 text-sm text-netskope-darkGray">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-netskope-green flex-shrink-0 mt-0.5"></i>
                        <span data-i18n="prac.3">Si necesitas una herramienta en la nube, solicítala a través de los canales oficiales de TI.</span>
                    </li>
                </ul>
            </div>

            <a href="demos.php" class="inline-flex items-center gap-2 bg-netskope-deepBlue text-white px-8 py-4 rounded-full font-bold hover:bg-netskope-blue transition-colors shadow-lg hover:shadow-xl hover:-translate-y-1">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span data-i18n="btn.back">Volver a un lugar seguro</span>
            </a>
        </div>
    </main>

    <!-- Footer: logo pequeño + texto de derechos reservados (hardcodeado en inglés en ambos idiomas). -->
    <footer class="bg-white border-t border-gray-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-5 w-auto opacity-70">
            <p class="text-xs text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. <span data-i18n="footer.rights">Todos los derechos reservados.</span>
            </p>
        </div>
    </footer>

    <!-- Utilidades JS compartidas (changeLanguage, etc.) y diccionario de
         traducciones común. Deben cargarse antes del script inline de abajo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
            // Restaura el idioma guardado por el usuario en otras páginas (antes esta
            // página se quedaba siempre en español al cargar, sin sincronizar con la
            // preferencia guardada en localStorage como sí hacen el resto de páginas).
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
        });

        // Diccionario específico de esta página, fusionado con NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "page.title": "¡Oops! Acceso Restringido",
                "header.title": "Portal de Demos",
                "hero.badge": "Alerta de Seguridad",
                "hero.title": "¡Oops! Hiciste algo que no debías... 👀",
                "hero.desc": "Si estás viendo esta página, es probable que hayas intentado acceder a una aplicación o contenido restringido por las políticas de la organización.",
                "policy.title": "Políticas y Cumplimiento Corporativo",
                "policy.desc": "Recuerda que nuestra organización está comprometida con la seguridad de la información. Seguir las normativas no solo protege a la empresa, sino también tus datos y dispositivos.",
                "practices.title": "💡 Mejores Prácticas de Navegación:",
                "prac.1": "No utilices aplicaciones no autorizadas (Shadow IT) para compartir datos corporativos.",
                "prac.2": "Evita acceder a sitios de riesgo, piratería o contenido inapropiado desde equipos de trabajo.",
                "prac.3": "Si necesitas una herramienta en la nube, solicítala a través de los canales oficiales de TI.",
                "btn.back": "Volver a un lugar seguro",
                "footer.rights": "Todos los derechos reservados."
            }
        };

        // changeLanguage(lang) es ahora la función compartida de assets/js/common.js.
        // Nota: la versión local que había aquí no validaba el idioma recibido (no
        // hacía fallback a 'es' si venía algo inválido) ni persistía la selección en
        // localStorage, a diferencia de todas las demás páginas del sitio. La versión
        // compartida sí lo hace, por lo que esta página ahora también recuerda el
        // idioma elegido por el usuario al navegar de vuelta a demos.php y regresar.
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
