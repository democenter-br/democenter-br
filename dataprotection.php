<?php
// dataprotection.php - Demo "Protección del Dato" (DSPM/DLP). Cubre el
// problema de datos sensibles en la nube, Zero Trust Engine, feature
// highlights (Data Lineage, integración con Microsoft Purview vía modales) y
// el enlace al informe de visibilidad de datos. Parte del flujo de demo
// enlazado desde index.php.
//
// Las funciones JS comunes (changeLanguage, openModal/closeModal, portapapeles)
// viven en assets/js/common.js y los textos i18n compartidos entre páginas
// viven en assets/js/i18n-common.js. El diccionario `translations` de este
// archivo solo contiene cadenas específicas de esta página.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Recorrido comercial sobre protección del dato, DLP contextual y gobierno de información en la nube con Netskope.">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Protección del Dato</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        netskope: {
                            deepBlue: '#081A59', blue: '#00A9CE', lightBlue: '#D9FAFF', teal: '#008095',
                            green: '#AFF198', orange: '#FF8200', darkGray: '#2A2B2D', gray: '#53565A',
                            lightGray: '#C8C9C7', offWhite: '#F5F5F5'
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Lora', 'serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; color: #2A2B2D; background-color: #F5F5F5; overflow-x: hidden; }
        .font-lora { font-family: 'Lora', serif; }
        .plus-pattern { position: absolute; width: 100%; height: 100%; background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2300A9CE' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 40V20h20v-2H20V0h-2v18H0v2h18v20z'/%3E%3C/g%3E%3C/svg%3E"); opacity: 0.3; z-index: 0; }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 50px -10px rgba(0, 169, 206, 0.15); border-color: #00A9CE; }
        .context-grid-item { transition: all 0.3s ease; }
        .context-grid-item:hover { transform: scale(1.05); }
        .rounded-netskope { border-radius: 24px; }
        .rounded-netskope-sm { border-radius: 12px; }

        /* Modals */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; border-radius: 16px; max-width: 90%; max-height: 90%; overflow: auto; position: relative; }
        .modal-close { position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.5); color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 1001; }

        /* Language Switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
        .quote-icon { position: absolute; top: -20px; left: 20px; width: 40px; height: 40px; background-color: #00A9CE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-page-name="dataprotection">

    <!-- Header fijo: logo (link a index.php), tagline de la página. -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            </div>

            <div class="flex items-center gap-6">
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="headerTagline">Seguridad de datos</span>
                
            </div>
        </div>
    </header>

    <!-- Hero: título/subtítulo de la demo de protección del dato y tarjeta de 3
         estadísticas (identificadores de datos, % datos en cloud, precisión IA/ML). -->
    <section class="relative bg-white pt-20 pb-24 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-teal"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="zeroTrustLabel">Zero Trust Engine</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="heroTitle">El Dato es el Nuevo <br> <span class="font-lora italic font-normal text-netskope-teal">Perímetro.</span></span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12">
                    <span data-i18n="heroSubtitle">El 60% de los datos sensibles ya residen en la nube.</span><br>
                    <strong class="text-netskope-deepBlue font-semibold" data-i18n="heroStrong">Protege la información en movimiento, en uso y en reposo.</strong>
                </p>

                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-teal mb-1">3.000+</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="statIdentifiers">Identificadores de Datos</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">60%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="statCloudData">Datos en Cloud</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-deepBlue mb-1">97%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="statAccuracy">Precisión IA/ML</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg>
        </div>
    </section>

    <!-- Sección de citas de analistas (Gartner) sobre DSPM/protección del dato. -->
    <section class="bg-netskope-deepBlue py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="marketRealityLabel">Realidad del Mercado</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="analystSays">Lo que dicen los analistas</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><i data-lucide="quote" class="w-5 h-5 text-white"></i></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote1">"La información es el petróleo del siglo XXI, y la analítica es el motor de combustión."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner Symposium/ITxpo</p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full mt-0 lg:-mt-6">
                    <div class="quote-icon"><i data-lucide="quote" class="w-5 h-5 text-white"></i></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote2">"Para 2026, más del 20% de las organizaciones implementarán tecnología DSPM, debido a los requisitos urgentes de identificar y localizar repositorios de datos previamente desconocidos."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner Market Guide for DSPM</p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><i data-lucide="quote" class="w-5 h-5 text-white"></i></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote3">"La protección de datos va más allá del DLP tradicional. Requiere un enfoque contextual que considere usuario, dispositivo, app, actividad y datos simultáneamente."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">SSE Critical Capabilities de Gartner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Zero Trust Engine: grilla de dimensiones de contexto (usuario, ubicación,
         app/instancia, actividad) + bloque de acciones de política granulares. -->
    <section class="py-20 bg-gradient-to-br from-netskope-deepBlue to-netskope-blue text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="ztLabel">Zero Trust</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="contextKey">El Contexto es la Clave</h2>
                <p class="text-netskope-lightBlue max-w-3xl mx-auto text-lg" data-i18n="ztSubtitle">Protección del dato basada en contexto multi-dimensional</p>
            </div>

            <div class="mb-16">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope">
                    <h3 class="text-xl font-bold mb-6 text-center" data-i18n="dlpMore">Protección de datos es más que DLP</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="context-grid-item bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 text-center">
                            <div class="w-12 h-12 rounded-full bg-netskope-blue flex items-center justify-center mx-auto mb-3"><i data-lucide="user" class="w-6 h-6 text-white"></i></div>
                            <h4 class="font-bold text-sm" data-i18n="ctxUser">Dispositivo/Usuario</h4>
                            <p class="text-xs opacity-80 mt-1" data-i18n="ctxUserSub">Restricción basada en identidad</p>
                        </div>
                        <div class="context-grid-item bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 text-center">
                            <div class="w-12 h-12 rounded-full bg-netskope-green flex items-center justify-center mx-auto mb-3"><i data-lucide="map-pin" class="w-6 h-6 text-white"></i></div>
                            <h4 class="font-bold text-sm" data-i18n="ctxLoc">Ubicación</h4>
                            <p class="text-xs opacity-80 mt-1" data-i18n="ctxLocSub">Control geográfico y de red</p>
                        </div>
                        <div class="context-grid-item bg-netskope-blue/30 hover:bg-netskope-blue/40 p-4 rounded-lg border border-netskope-blue text-center relative">
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-netskope-orange rounded-full flex items-center justify-center text-xs font-bold">★</div>
                            <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mx-auto mb-3 text-netskope-blue"><i data-lucide="layout-grid" class="w-6 h-6"></i></div>
                            <h4 class="font-bold text-sm" data-i18n="ctxApp">App & Instancia</h4>
                            <p class="text-xs opacity-80 mt-1" data-i18n="ctxAppSub">Control granular por app</p>
                        </div>
                        <div class="context-grid-item bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 text-center">
                            <div class="w-12 h-12 rounded-full bg-netskope-teal flex items-center justify-center mx-auto mb-3"><i data-lucide="activity" class="w-6 h-6 text-white"></i></div>
                            <h4 class="font-bold text-sm" data-i18n="ctxAct">Actividad</h4>
                            <p class="text-xs opacity-80 mt-1">Upload, edit, share, download</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/5 p-6 rounded-lg border border-white/10">
                        <h4 class="font-bold mb-4 text-center" data-i18n="policyActions">Acciones de Política Granulares</h4>
                        <div class="flex flex-wrap justify-center gap-3">
                            <span class="px-4 py-2 bg-netskope-green/20 text-netskope-green rounded-full text-sm font-bold" data-i18n="actAllow">PERMITIR</span>
                            <span class="px-4 py-2 bg-netskope-blue/20 text-netskope-blue rounded-full text-sm font-bold" data-i18n="actAlert">ADVERTIR</span>
                            <span class="px-4 py-2 bg-yellow-500/20 text-yellow-500 rounded-full text-sm font-bold">COACH</span>
                            <span class="px-4 py-2 bg-red-500/20 text-red-500 rounded-full text-sm font-bold" data-i18n="actBlock">BLOQUEAR</span>
                            <span class="px-4 py-2 bg-white/20 text-white rounded-full text-sm font-bold">MFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vectores de protección: 5 tarjetas (Web/SaaS, Endpoint/Email, Private Apps,
         Gen AI, Enterprise Browser), seguidas de un bloque destacado de "Dato en
         Reposo" (CASB API + DSPM) y un panel dividido de clasificación IA/ML
         (TYOC, EDM). -->
    <section class="py-24 bg-netskope-offWhite">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="vecTitle">Protección del Dato en Todos los Vectores</h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-netskope-blue to-netskope-green mx-auto rounded-full"></div>
                <p class="text-netskope-gray mt-6 max-w-2xl mx-auto" data-i18n="vecSubtitle">Una consola y una política para proteger todos los datos en movimiento, en uso y en reposo, sin importar el canal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover group flex flex-col h-full border border-gray-100">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6"><i data-lucide="cloud" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Web & SaaS</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="vecWeb">Para prevenir la subida de datos sensibles a instancias personales de OneDrive, Google Drive o herramientas de IA como ChatGPT.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Inline + API</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover group flex flex-col h-full border border-gray-100">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6"><i data-lucide="laptop" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Endpoint & Email</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="vecEnd">Controla dispositivos USB, impresoras, bluetooth, carpetas y correos. Protege tus datos en uso incluso cuando el dispositivo está offline.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Data in Use</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover group flex flex-col h-full border border-gray-100">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6"><i data-lucide="shield" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Private Apps</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="vecPriv">Aplica DLP al tráfico interno hacia aplicaciones privadas en el Data Center o Cloud Privada a través de Netskope Private Access.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Zero Trust Access</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover group flex flex-col h-full border border-gray-100">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white mb-6"><i data-lucide="bot" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Gen AI & Agentic AI</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="vecAI">Protege la información compartida con modelos de IA generativa y agentes autónomos. Controla prompts y respuestas.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-purple-600 uppercase tracking-wide">AI Security</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover group flex flex-col h-full border border-gray-100">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-cyan-500 rounded-xl flex items-center justify-center text-white mb-6"><i data-lucide="chrome" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="vecBrowserTitle">Enterprise Browser</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="vecBrowser">Controles adicionales en BYOD: watermark, bloqueo de screenshots y restricción de copiar/pegar.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-indigo-600 uppercase tracking-wide" data-i18n="vecBrowserTag">Seguridad del Navegador</span></div>
                </div>
            </div>
            
            <div class="mt-8">
                <div class="bg-gradient-to-r from-netskope-deepBlue/5 to-netskope-teal/5 p-8 rounded-netskope border border-netskope-blue/20">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="w-16 h-16 bg-netskope-orange rounded-xl flex items-center justify-center text-white"><i data-lucide="database" class="w-8 h-8"></i></div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-netskope-deepBlue mb-2" data-i18n="vecRestTitle">Protección del Dato en Reposo</h3>
                            <p class="text-netskope-gray" data-i18n="vecRestSub">CASB API + DSPM para descubrir, clasificar y proteger datos sensibles en repositorios cloud y on-premises. Identifica PII, PCI, propiedad intelectual y evalúa el riesgo del dato.</p>
                        </div>
                        <div class="flex gap-3">
                            <span class="px-4 py-2 bg-netskope-blue/20 text-netskope-blue rounded-full text-sm font-bold">CASB API</span>
                            <span class="px-4 py-2 bg-netskope-orange/20 text-netskope-orange rounded-full text-sm font-bold">DSPM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 bg-white rounded-netskope shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-8 bg-gray-50 flex items-center justify-center">
                        <div class="bg-white border border-gray-200 p-8 rounded-netskope shadow-sm w-full max-w-md">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-3 bg-netskope-deepBlue rounded-lg text-white"><i data-lucide="binary" class="w-6 h-6"></i></div>
                                <div>
                                    <h3 class="text-lg font-bold text-netskope-deepBlue" data-i18n="classTitle">Clasificación IA/ML</h3>
                                    <p class="text-xs text-netskope-gray" data-i18n="classSub">Reconocimiento avanzado de documentos</p>
                                </div>
                            </div>
                            <ul class="space-y-3">
                                <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium text-gray-700" data-i18n="docPass">Pasaportes y DNI</span>
                                    <span class="text-xs font-bold text-netskope-green bg-green-50 px-2 py-1 rounded">Image Rec.</span>
                                </li>
                                <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium text-gray-700" data-i18n="docCode">Código Fuente</span>
                                    <span class="text-xs font-bold text-netskope-teal bg-teal-50 px-2 py-1 rounded">ML Model</span>
                                </li>
                                <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium text-gray-700" data-i18n="docScreen">Capturas de Pantalla</span>
                                    <span class="text-xs font-bold text-netskope-blue bg-blue-50 px-2 py-1 rounded">OCR + ML</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col justify-center">
                        <h2 class="text-2xl font-bold text-netskope-deepBlue mb-6" data-i18n="aiPrecTitle">Precisión Impulsada por IA</h2>
                        <p class="text-netskope-gray mb-6 leading-relaxed" data-i18n="aiPrecText">Olvida las expresiones regulares y sus falsos positivos. Netskope utiliza Inteligencia Artificial para clasificar documentos no estructurados con precisión milimétrica.</p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-netskope-green/20 flex items-center justify-center text-netskope-green shrink-0 font-bold text-sm">✓</div>
                                <p class="text-sm text-gray-600" data-i18n="featTYOC"><strong>Train Your Own Classifier (TYOC):</strong> Entrena al sistema con tus propios documentos e imágenes confidenciales.</p>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-netskope-green/20 flex items-center justify-center text-netskope-green shrink-0 font-bold text-sm">✓</div>
                                <p class="text-sm text-gray-600" data-i18n="featEDM"><strong>Exact Data Match (EDM):</strong> Huella digital de bases de datos para proteger registros específicos de clientes, evitando falsos positivos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grilla de casos de uso (6 tarjetas). Las tarjetas "Data Lineage" e
         "Integración Microsoft Purview" tienen un botón que abre los modales
         #data-lineage-modal y #purview-modal definidos más abajo. -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="ucLabel">CASOS DE USO CLAVE</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="ucTitle">Protección del Dato</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg mb-10" data-i18n="ucSubtitle">Soluciones específicas para la protección de los datos más críticos</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><i data-lucide="globe" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="uc1Title">Protección en Navegación</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc1Text">DLP en tiempo real durante la navegación web. Previene la fuga de datos sensibles a través de formularios web, uploads a cloud y descargas no autorizadas.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Inline Protection</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Gobierno del Dato + DSPM</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc2Text">Entiende el riesgo con DSPM: descubre dónde están tus datos sensibles, evalúa configuraciones erróneas y aplica controles de remediación.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-blue uppercase tracking-wide">Risk Assessment</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl flex items-center justify-center text-purple-600 mb-4"><i data-lucide="bot" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="uc3Title">Dato en IA</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc3Text">IA Gateway y Guardrails para proteger datos compartidos con ChatGPT, Copilot y herramientas de IA agéntica. Solución de IA Red Teaming para evaluar riesgos.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-purple-600 uppercase tracking-wide">AI Security</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col">
                    <div class="w-12 h-12 bg-netskope-teal/10 rounded-xl flex items-center justify-center text-netskope-teal mb-4"><i data-lucide="search" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="uc4Title">Descubrimiento y Clasificación</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc4Text">Encuentra y clasifica datos sensibles esté donde estén: cloud, on-premises, endpoints. Catalogación automática con IA.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Auto Discovery</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col relative">
                    <button type="button" onclick="openModal('data-lineage-modal')" class="absolute top-4 right-4 text-netskope-blue hover:text-netskope-teal cursor-pointer">
                        <i data-lucide="external-link" class="w-5 h-5"></i>
                    </button>
                    <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 mb-4"><i data-lucide="git-branch" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Data Lineage</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc5Text">Traza el recorrido completo de los datos: origen, transformaciones, movimientos y accesos. Auditoría completa del ciclo de vida.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-orange-500 uppercase tracking-wide">Full Traceability</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-sm card-hover border border-gray-100 flex flex-col relative">
                    <button type="button" onclick="openModal('purview-modal')" class="absolute top-4 right-4 text-netskope-blue hover:text-netskope-teal cursor-pointer">
                        <i data-lucide="external-link" class="w-5 h-5"></i>
                    </button>
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 mb-4"><i data-lucide="combine" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="uc6Title">Integración Microsoft <span class="text-netskope-blue">Purview</span></h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc6Text">Integración nativa con Microsoft Purview para gobierno de datos unificado. Sincronización de etiquetas y políticas entre plataformas.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-blue-500 uppercase tracking-wide">Ecosystem Integration</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- DSPM (Data Security Posture Management): descripción + panel de ejemplo
         "Mapa de Datos" con repositorios de muestra (AWS S3, M365 SharePoint) y
         barra de % de PII detectado. -->
    <section class="py-24 bg-gradient-to-br from-netskope-deepBlue to-netskope-teal text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block">Data Security Posture Management</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="dspmTitle">Visibilidad DSPM Total.</h2>
                    <p class="text-lg text-netskope-lightBlue font-light leading-relaxed mb-8" data-i18n="dspmText">No se puede proteger lo que no se ve. <strong>Netskope DSPM</strong> descubre datos sensibles y cataloga el riesgo en la nube pública, tanto IaaS, PaaS como SaaS y centros de datos on-premises.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-netskope-green flex items-center justify-center text-netskope-deepBlue shrink-0 font-bold text-lg">+</div>
                            <div>
                                <h4 class="text-xl font-bold mb-1" data-i18n="dspmFeat1">Descubrimiento Híbrido</h4>
                                <p class="text-sm text-white/80" data-i18n="dspmFeat1Sub">Descubre PII, PCI y propiedad intelectual en AWS, Azure, Google Cloud o servidores de archivos locales.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-netskope-blue flex items-center justify-center text-white shrink-0 font-bold text-lg">+</div>
                            <div>
                                <h4 class="text-xl font-bold mb-1" data-i18n="dspmFeat2">Evaluación de Riesgo</h4>
                                <p class="text-sm text-white/80" data-i18n="dspmFeat2Sub">Identifica permisos excesivos y configuraciones erróneas que exponen los datos de la compañía.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-netskope-blue to-netskope-green rounded-netskope blur opacity-30"></div>
                    <div class="relative bg-white text-netskope-darkGray p-8 rounded-netskope shadow-2xl">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-xl font-bold text-netskope-deepBlue" data-i18n="mapTitle">Mapa de Datos</h3>
                            <span class="bg-netskope-lightBlue text-netskope-deepBlue px-3 py-1 rounded-full text-xs font-bold uppercase">Multi-Cloud</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-2 h-2 rounded-full bg-netskope-teal"></span>
                                    <span class="text-xs font-bold uppercase text-gray-500">AWS S3 Bucket</span>
                                </div>
                                <div class="text-2xl font-bold text-netskope-deepBlue mb-1">1.2 TB</div>
                                <div class="text-xs text-red-500 font-bold" data-i18n="mapStatus1">Público (Non-Compliant)</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-2 h-2 rounded-full bg-netskope-blue"></span>
                                    <span class="text-xs font-bold uppercase text-gray-500">M365 SharePoint</span>
                                </div>
                                <div class="text-2xl font-bold text-netskope-deepBlue mb-1">450 GB</div>
                                <div class="text-xs text-netskope-green font-bold" data-i18n="mapStatus2">Protegido (DLP)</div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold text-gray-500" data-i18n="mapSensTypes">Tipos de Datos Sensibles</span>
                                <span class="text-xs font-bold text-netskope-blue" data-i18n="mapPII">32% PII Detectado</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-netskope-blue h-2 rounded-full" style="width: 32%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enlace al informe de visibilidad del dato (reportit.php), con lista de
         features del informe y panel lateral de "Análisis Personalizado". -->
    <section class="py-20 bg-netskope-offWhite">
        <div class="container mx-auto px-6 md:px-12">
            <div class="bg-gradient-to-r from-netskope-deepBlue to-netskope-teal rounded-netskope overflow-hidden shadow-2xl">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-2/3 p-12 text-white">
                        <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-4 block" data-i18n="reportLabel">Visibilidad Completa</span>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="reportTitle">Informe de Visibilidad del Dato</h2>
                        <p class="text-netskope-lightBlue text-lg mb-8 leading-relaxed" data-i18n="reportText">Descubre el estado real de tus datos sensibles en la nube y on-premises. Nuestro análisis te proporciona una visión completa de dónde están los datos más críticos y qué riesgos presentan.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="flex items-start gap-3">
                                <i data-lucide="clipboard-list" class="w-6 h-6 text-white opacity-80 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="repFeat1">Inventario Completo</h4>
                                    <p class="text-sm text-white/80" data-i18n="repFeat1Sub">Clasificación de los repositorios de datos sensibles</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="shield-alert" class="w-6 h-6 text-white opacity-80 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="repFeat2">Análisis de Riesgo</h4>
                                    <p class="text-sm text-white/80" data-i18n="repFeat2Sub">Evaluación de configuraciones y permisos</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="trending-up" class="w-6 h-6 text-white opacity-80 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="repFeat3">Tendencias en Tiempo Real</h4>
                                    <p class="text-sm text-white/80" data-i18n="repFeat3Sub">Monitoreo continuo del movimiento de datos</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-square" class="w-6 h-6 text-white opacity-80 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="repFeat4">Recomendaciones</h4>
                                    <p class="text-sm text-white/80" data-i18n="repFeat4Sub">Plan de remediación</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="reportit.php" class="inline-flex items-center gap-3 bg-white text-netskope-deepBlue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-lg hover:-translate-y-1">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                            <span data-i18n="btnReport">Ver Informe de Visibilidad</span>
                        </a>
                    </div>
                    
                    <div class="lg:w-1/3 bg-black/20 flex items-center justify-center p-8">
                        <div class="text-center text-white">
                            <i data-lucide="radar" class="w-20 h-20 mx-auto text-netskope-green mb-4"></i>
                            <h3 class="text-xl font-bold mb-2" data-i18n="customAnalysis">Análisis Personalizado</h3>
                            <p class="text-sm opacity-80" data-i18n="customAnalysisSub">Informe adaptado a tu entorno específico</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Botones de navegación de cierre de la demo (a diferenciadores, a la landing, a demos.php). -->
    <section class="py-16 bg-white text-center">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex flex-col md:flex-row justify-center gap-6">
                <a href="keydifferentiators.php" class="bg-netskope-blue text-white px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-teal transition-all shadow-md flex items-center justify-center gap-3">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                    <span data-i18n="nav_who">¿Quién es Netskope?</span>
                </a>
                <a href="index.php" class="bg-white text-netskope-deepBlue border border-netskope-blue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-md flex items-center justify-center gap-3">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span data-i18n="nav_back">Volver a la landing</span>
                </a>
                <a href="demos.php" class="bg-gradient-to-r from-netskope-orange to-yellow-500 text-white px-8 py-4 rounded-netskope-sm font-bold hover:opacity-90 transition-all shadow-md flex items-center justify-center gap-3 animate-pulse">
                    <i data-lucide="play-circle" class="w-5 h-5"></i>
                    <span data-i18n="nav_demo">¿Quieres Verlo? 😉</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Modal de captura "Data Lineage": imagen de ejemplo del trazado de datos +
         descripción. Se abre/cierra con openModal/closeModal de assets/js/common.js
         desde el botón de la tarjeta "Data Lineage" de arriba. -->
    <div id="data-lineage-modal" class="modal-overlay">
        <div class="modal-content max-w-2xl w-full p-6">
            <div class="modal-close" onclick="closeModal('data-lineage-modal')">×</div>
            <div class="p-4">
                <img src="assets/images/external/data-lineage.png" alt="Data Lineage Visualization" class="w-full h-auto rounded-lg mx-auto shadow-sm">
            </div>
            <div class="mt-4">
                <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="modal1Title">Data Lineage de Netskope</h3>
                <p class="text-netskope-gray text-sm leading-relaxed" data-i18n="modal1Text">Visualización completa del recorrido de los datos a través de diferentes sistemas y aplicaciones. Traza el origen, transformaciones y accesos para auditoría y cumplimiento.</p>
            </div>
        </div>
    </div>

    <!-- Modal de captura "Integración Microsoft Purview": imagen de ejemplo +
         descripción. Se abre/cierra con openModal/closeModal de assets/js/common.js
         desde el botón de la tarjeta "Integración Microsoft Purview" de arriba. -->
    <div id="purview-modal" class="modal-overlay">
        <div class="modal-content max-w-2xl w-full p-6">
            <div class="modal-close" onclick="closeModal('purview-modal')">×</div>
            <div class="p-4">
                <img src="assets/images/external/microsoft-purview-integration.png" alt="Microsoft Purview Integration" class="w-full h-auto rounded-lg mx-auto shadow-sm">
            </div>
            <div class="mt-4">
                <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="modal2Title">Integración con Microsoft Purview</h3>
                <p class="text-netskope-gray text-sm leading-relaxed" data-i18n="modal2Text">Integración nativa entre Netskope y Microsoft Purview para un gobierno de datos unificado. Sincronización bidireccional de etiquetas de clasificación y políticas de protección de datos.</p>
            </div>
        </div>
    </div>

    <!-- Footer: logo pequeño + texto de derechos reservados (hardcodeado en inglés). -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved. | Privacy Policy
            </p>
        </div>
    </footer>

    <!-- Utilidades JS compartidas (changeLanguage, openModal/closeModal, portapapeles)
         y diccionario de traducciones común. Deben cargarse antes del script inline. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Diccionario específico de esta página, fusionado con NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "headerTagline": "Seguridad de datos",
                "zeroTrustLabel": "Zero Trust Engine",
                "heroTitle": "El Dato es el Nuevo <br> <span class=\"text-netskope-teal\">Perímetro.</span>",
                "heroSubtitle": "El 60% de los datos sensibles ya residen en la nube.",
                "heroStrong": "Protege la información en movimiento, en uso y en reposo.",
                "statIdentifiers": "Identificadores de Datos", "statCloudData": "Datos en Cloud", "statAccuracy": "Precisión IA/ML",
                "marketRealityLabel": "Realidad del Mercado", "analystSays": "Lo que dicen los analistas",
                "quote1": "\"La información es el petróleo del siglo XXI, y la analítica es el motor de combustión.\"",
                "quote2": "\"Para 2026, más del 20% de las organizaciones implementarán tecnología DSPM, debido a los requisitos urgentes de identificar y localizar repositorios de datos previamente desconocidos.\"",
                "quote3": "\"La protección de datos va más allá del DLP tradicional. Requiere un enfoque contextual que considere usuario, dispositivo, app, actividad y datos simultáneamente.\"",
                "ztLabel": "Zero Trust", "contextKey": "El Contexto Es la Clave", "ztSubtitle": "Protección del dato basada en contexto multi-dimensional",
                "dlpMore": "Protección de datos es más que DLP", "ctxUser": "Dispositivo/Usuario", "ctxUserSub": "Restricción basada en identidad",
                "ctxLoc": "Ubicación", "ctxLocSub": "Control geográfico y de red", "ctxApp": "App & Instancia", "ctxAppSub": "Control granular por app", "ctxAct": "Actividad",
                "policyActions": "Acciones de Política Granulares", "actAllow": "PERMITIR", "actAlert": "ADVERTIR", "actBlock": "BLOQUEAR",
                "vecTitle": "Protección del Dato en Todos los Vectores", "vecSubtitle": "Una consola y una política para proteger todos los datos en movimiento, en uso y en reposo, sin importar el canal.",
                "vecWeb": "Para prevenir la subida de datos sensibles a instancias personales de OneDrive, Google Drive o herramientas de IA como ChatGPT.",
                "vecEnd": "Controla dispositivos USB, impresoras, bluetooth, carpetas y correos. Protege tus datos en uso incluso cuando el dispositivo está offline.",
                "vecPriv": "Aplica DLP al tráfico interno hacia aplicaciones privadas en el Data Center o Cloud Privada a través de Netskope Private Access.",
                "vecAI": "Protege la información compartida con modelos de IA generativa y agentes autónomos. Controla prompts y respuestas.",
                "vecBrowserTitle": "Enterprise Browser", "vecBrowser": "Controles adicionales en BYOD: watermark, bloqueo de screenshots y restricción de copiar/pegar.", "vecBrowserTag": "Seguridad del Navegador",
                "vecRestTitle": "Protección del Dato en Reposo", "vecRestSub": "CASB API + DSPM para descubrir, clasificar y proteger datos sensibles en repositorios cloud y on-premises. Identifica PII, PCI, propiedad intelectual y evalúa el riesgo del dato.",
                "classTitle": "Clasificación IA/ML", "classSub": "Reconocimiento avanzado de documentos", "docPass": "Pasaportes y DNI", "docCode": "Código Fuente", "docScreen": "Capturas de Pantalla",
                "aiPrecTitle": "Precisión Impulsada por IA", "aiPrecText": "Olvida las expresiones regulares y sus falsos positivos. Netskope utiliza Inteligencia Artificial para clasificar documentos no estructurados con precisión milimétrica.",
                "featTYOC": "<strong>Train Your Own Classifier (TYOC):</strong> Entrena al sistema con tus propios documentos e imágenes confidenciales.",
                "featEDM": "<strong>Exact Data Match (EDM):</strong> Huella digital de bases de datos para proteger registros específicos de clientes, evitando falsos positivos.",
                "ucLabel": "CASAS DE USO CLAVE", "ucTitle": "Protección del Dato", "ucSubtitle": "Soluciones específicas para la protección de los datos más críticos",
                "uc1Title": "Protección en Navegación", "uc1Text": "DLP en tiempo real durante la navegación web. Previene la fuga de datos sensibles a través de formularios web, uploads a cloud y descargas no autorizadas.",
                "uc3Title": "Dato en IA", "uc3Text": "IA Gateway y Guardrails para proteger datos compartidos con ChatGPT, Copilot y herramientas de IA agéntica. Solución de IA Red Teaming para evaluar riesgos.",
                "uc4Title": "Descubrimiento y Clasificación", "uc4Text": "Encuentra y clasifica datos sensibles esté donde estén: cloud, on-premises, endpoints. Catalogación automática con IA.",
                "uc6Title": "Integración Microsoft Purview", "uc6Text": "Integración nativa con Microsoft Purview para gobierno de datos unificado. Sincronización de etiquetas y políticas entre plataformas.",
                "dspmTitle": "Visibilidad DSPM Total.", "dspmText": "No se puede proteger lo que no se ve. <strong>Netskope DSPM</strong> descubre datos sensibles y cataloga el riesgo en la nube pública, tanto IaaS, PaaS como SaaS y centros de datos on-premises.",
                "dspmFeat1": "Descubrimiento Híbrido", "dspmFeat1Sub": "Descubre PII, PCI y propiedad intelectual en AWS, Azure, Google Cloud o servidores de archivos locales.",
                "dspmFeat2": "Evaluación de Riesgo", "dspmFeat2Sub": "Identifica permisos excesivos y configuraciones erróneas que exponen los datos de la compañía.",
                "mapTitle": "Mapa de Datos", "mapStatus1": "Público (Non-Compliant)", "mapStatus2": "Protegido (DLP)", "mapSensTypes": "Tipos de Datos Sensibles", "mapPII": "32% PII Detectado",
                "reportLabel": "Visibilidad Completa", "reportTitle": "Informe de Visibilidad del Dato", "reportText": "Descubre el estado real de tus datos sensibles en la nube y on-premises. Nuestro análisis te proporciona una visión completa de dónde están los datos más críticos y qué riesgos presentan.",
                "repFeat1": "Inventario Completo", "repFeat1Sub": "Clasificación de los repositorios de datos sensibles",
                "repFeat2": "Análisis de Riesgo", "repFeat2Sub": "Evaluación de configuraciones y permisos",
                "repFeat3": "Tendencias en Tiempo Real", "repFeat3Sub": "Monitoreo continuo del movimiento de datos",
                "repFeat4": "Recomendaciones", "repFeat4Sub": "Plan de remediación",
                "btnReport": "Ver Informe de Visibilidad", "customAnalysis": "Análisis Personalizado", "customAnalysisSub": "Informe adaptado a tu entorno específico",
                // nav_who / nav_back / nav_demo ahora vienen de NetskopeCommonI18n
                "modal1Title": "Data Lineage de Netskope", "modal1Text": "Visualización completa del recorrido de los datos a través de diferentes sistemas y aplicaciones. Traza el origen, transformaciones y accesos para auditoría y cumplimiento.",
                "modal2Title": "Integración con Microsoft Purview", "modal2Text": "Integración nativa entre Netskope y Microsoft Purview para un gobierno de datos unificado. Sincronización bidireccional de etiquetas de clasificación y políticas de protección de datos."
            }
        };

        // changeLanguage(lang), openModal(modalId) y closeModal(modalId) ahora viven
        // en assets/js/common.js. Nota: la versión local de closeModal() que había
        // aquí tenía un bug ("document.getElementById(modalAddress = modalId)", una
        // asignación accidental a una variable global no declarada `modalAddress`
        // en vez de simplemente pasar `modalId`). No afectaba el resultado visible
        // porque la expresión de asignación igual evalúa a modalId, pero quedaba
        // fealdad/código muerto; la versión compartida en common.js ya no lo tiene.

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
