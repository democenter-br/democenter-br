<?php
// navigationevolution.php - Demo "Evolución de la Navegación" (Next Gen SWG).
// Explica la evolución de la seguridad web/SaaS: estadísticas de mercado, citas
// de analistas, los 5 pilares de la estrategia de Netskope, casos de uso y el
// enlace al informe de visibilidad (reportit.php). Parte del flujo de demo
// enlazado desde index.php.
//
// Las funciones JS comunes (changeLanguage, modales, portapapeles) viven en
// assets/js/common.js y los textos de i18n compartidos entre páginas (botones
// de navegación como "¿Quién es Netskope?"/"Volver a la landing"/"¿Quieres
// verlo?") viven en assets/js/i18n-common.js. El diccionario `translations`
// de este archivo solo contiene las cadenas específicas de esta página.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Demo sobre la evolución de la navegación segura con visibilidad, control y protección de datos en SaaS y web.">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Evolución de la Navegación</title>
    
    <!-- CDNs -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
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
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Lora', 'serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; color: #2A2B2D; background-color: #F5F5F5; overflow-x: hidden; }
        .font-lora { font-family: 'Lora', serif; }
        
        .plus-pattern {
            position: absolute; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2300A9CE' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 40V20h20v-2H20V0h-2v18H0v2h18v20z'/%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3; z-index: 0;
        }

        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 50px -10px rgba(0, 169, 206, 0.15); }
        .rounded-netskope { border-radius: 24px; }
        .rounded-netskope-sm { border-radius: 12px; }

        .quote-icon {
            position: absolute; top: -20px; left: 20px; width: 40px; height: 40px;
            background-color: #00A9CE; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Language Switcher */
        .language-switcher {
            display: inline-flex; align-items: center; gap: 6px; padding: 4px;
            border-radius: 999px; background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08);
        }

        .lang-btn {
            min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px;
            border: 1px solid transparent; background: transparent; color: #081A59;
            font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease;
        }

        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-page-name="navigationevolution">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6">
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="secure_saas">SaaS y Navegación Segura</span>
                
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-white pt-20 pb-20 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-teal"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase">Next Gen SWG</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="hero_title_1">La Evolución de la</span> <br>
                    <span class="font-lora italic font-normal text-netskope-blue" data-i18n="hero_title_2">Navegación Web.</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero_subtitle">Más del 95% del tráfico está cifrado. Más del 50% del malware viene de la nube. <br><strong class="text-netskope-deepBlue font-semibold">Los proxies tradicionales están ciegos ante las amenazas actuales.</strong></p>

                <!-- Stats Single Line -->
                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-sm inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-green mb-1">+60%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_shadow">Son "Shadow IT"</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">70%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_traffic">Tráfico es SaaS</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-deepBlue mb-1">+50%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_malware">malware en SaaS</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg>
        </div>
    </section>

    <!-- Market Reality / Citations -->
    <section class="bg-netskope-deepBlue py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block">Market Reality</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="analyst_title">Lo que dicen los analistas</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-6">
                <!-- Quote 1 -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_1">"Los Threat Actors aprovechan servicios legítimos de la nube y SaaS para eludir los controles de seguridad tradicionales basados en el perímetro."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">IDC — Worldwide Secure Access Service Edge Market Analysis, 2024</p>
                    </div>
                </div>

                <!-- Quote 2 -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full mt-0 lg:-mt-6">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_2">"La mayoría del tráfico empresarial está ahora encriptado, limitando la efectividad de los controles de seguridad tradicionales."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">IDC Worldwide SASE/SSE Market Analysis 2024</p>
                    </div>
                </div>

                <!-- Quote 3 -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_3">"Más de la mitad de las aplicaciones SaaS utilizadas por los empleados no están gestionadas por TI. La falta de visibilidad sigue siendo uno de los principales desafíos."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Forrester Research, SSE 2024</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Estrategia de Netskope -->
    <section class="py-20 bg-gradient-to-br from-netskope-deepBlue to-netskope-blue text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="strat_label">Estrategia de Netskope</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="strat_title">Cinco pilares para la Evolución de la Navegación</h2>
                <p class="text-netskope-lightBlue max-w-3xl mx-auto text-lg" data-i18n="strat_subtitle">Next-Gen Secure Web Gateway que incluye CASB, DLP y Enterprise Browser</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
                
                <!-- Pillar 1: Mobility -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope hover:bg-white/20 transition-all group lg:col-span-3">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-netskope-green flex items-center justify-center text-netskope-deepBlue shadow-lg">
                            <i data-lucide="laptop" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold">Control Everywhere</h3>
                    </div>
                    <p class="text-netskope-lightBlue text-sm leading-relaxed mb-4" data-i18n="pillar_1_desc">Protección constante esté donde esté el usuario: oficina, casa o una cafetería.</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2"><span class="text-netskope-green">✓</span> <span data-i18n="pillar_1_item_1">Sin backhauling al CPD, direct-to-cloud</span></li>
                        <li class="flex items-center gap-2"><span class="text-netskope-green">✓</span> <span data-i18n="pillar_1_item_2">Un solo agente, Netskope Client</span></li>
                    </ul>
                </div>

                <!-- Pillar 2: CASB Inline -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope hover:bg-white/20 transition-all group lg:col-span-3">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-netskope-blue flex items-center justify-center text-white shadow-lg">
                            <i data-lucide="cloud" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold">CASB Inline</h3>
                    </div>
                    <p class="text-netskope-lightBlue text-sm leading-relaxed mb-4" data-i18n="pillar_2_desc">Control granular de actividades e instancias. No bloquees la app, controla su uso y actividades.</p>
                    <div class="bg-white/10 rounded p-3 text-xs font-mono border border-white/10">
                        <div class="flex justify-between mb-1">
                            <span>App: OneDrive</span><span class="text-cyan-300 font-bold">Instance: Corporate -> ALLOW</span>
                        </div>
                        <div class="flex justify-between">
                            <span>App: OneDrive</span><span class="text-red-400 font-bold">Instance: Personal -> BLOCK</span>
                        </div>
                    </div>
                </div>

                <!-- Pillar 3: Visibility -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope hover:bg-white/20 transition-all group lg:col-span-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-netskope-teal flex items-center justify-center text-white shadow-lg">
                            <i data-lucide="eye" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold" data-i18n="pillar_3_title">Visibilidad - Shadow IT</h3>
                    </div>
                    <p class="text-netskope-lightBlue text-sm leading-relaxed mb-4" data-i18n="pillar_3_desc">Descubre el 97% de apps que el firewall no ve. Evalua riesgos automáticamente.</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2"><span class="text-netskope-teal">✓</span> Cloud Confidence Index (CCI)</li>
                        <li class="flex items-center gap-2"><span class="text-netskope-teal">✓</span> <span data-i18n="pillar_3_item_2">+80,000 Apps Clasificadas</span></li>
                    </ul>
                </div>

                <!-- Pillar 4: Threat Protection -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope hover:bg-white/20 transition-all group lg:col-span-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-600 flex items-center justify-center text-white shadow-lg">
                            <i data-lucide="shield-alert" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold">Threat Protection</h3>
                    </div>
                    <p class="text-netskope-lightBlue text-sm leading-relaxed mb-4" data-i18n="pillar_4_desc">Defensa avanzada contra malware en la nube y web. Sandboxing y ML en tiempo real.</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2"><span class="text-purple-400">✓</span> <span data-i18n="pillar_4_item_1">50% del malware viene de la nube</span></li>
                        <li class="flex items-center gap-2"><span class="text-purple-400">✓</span> <span data-i18n="pillar_4_item_2">Antiphishing con Machine Learning</span></li>
                    </ul>
                </div>

                <!-- Pillar 5: Enterprise Browser -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope hover:bg-white/20 transition-all group md:col-span-2 lg:col-span-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-netskope-orange flex items-center justify-center text-white shadow-lg">
                            <i data-lucide="chrome" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold" data-i18n="pillar_5_title">Enterprise Browser</h3>
                    </div>
                    <p class="text-netskope-lightBlue text-sm leading-relaxed mb-4" data-i18n="pillar_5_desc">Navegador seguro gestionado para dispositivos no gestionados y terceros.</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2"><span class="text-netskope-orange">✓</span> <span data-i18n="pillar_5_item_1">Acceso Zero Trust sin agentes</span></li>
                        <li class="flex items-center gap-2"><span class="text-netskope-orange">✓</span> <span data-i18n="pillar_5_item_2">DLP y Protección contra amenazas nativa</span></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Casos de uso / Contexto -->
    <section class="py-20 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="use_case_label">IMPLEMENTACIÓN PRÁCTICA</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="use_case_title">Casos de uso clave</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg mb-10" data-i18n="use_case_subtitle">Descubre cómo Netskope transforma la seguridad de navegación en escenarios reales</p>
                
                <!-- Zero Trust Engine -->
                <div class="bg-white rounded-netskope p-8 shadow-sm border border-gray-100 mb-10">
                    <h3 class="text-2xl font-bold text-netskope-blue mb-4 text-center" data-i18n="context_title">El Contexto Importa: Zero Trust Engine</h3>
                    <p class="text-netskope-gray text-center mb-8 max-w-2xl mx-auto" data-i18n="context_desc">Las políticas basadas en "Permitir/Bloquear Dominio" ya no sirven. Netskope decodifica el lenguaje de la nube (API/JSON) en tiempo real.</p>
                    
                    <div class="flex flex-wrap justify-center gap-6 mb-4">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-netskope-blue font-bold mb-2 border border-gray-200">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500" data-i18n="context_who">QUIÉN</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-netskope-blue font-bold mb-2 border border-gray-200">
                                <i data-lucide="smartphone" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500" data-i18n="context_device">DISPOSITIVO</span>
                        </div>
                        <div class="flex flex-col items-center relative">
                            <div class="w-14 h-14 rounded-full bg-netskope-blue flex items-center justify-center text-white font-bold mb-2 shadow-lg ring-4 ring-blue-100">
                                <i data-lucide="box" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-netskope-blue" data-i18n="context_app">APP & INSTANCIA</span>
                        </div>
                        <div class="flex flex-col items-center relative">
                            <div class="w-14 h-14 rounded-full bg-netskope-green flex items-center justify-center text-netskope-deepBlue font-bold mb-2 shadow-lg ring-4 ring-green-100">
                                <i data-lucide="activity" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-green-500" data-i18n="context_activity">ACTIVIDAD</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-netskope-blue font-bold mb-2 border border-gray-200">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500" data-i18n="context_data">DATO</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas Casos de Uso -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 1 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-netskope-blue/10 flex items-center justify-center text-netskope-blue mb-4">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3" data-i18n="card_1_title">Navegación</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_1_desc">Protección contra amenazas web y phishing con inspección SSL completa y control de acceso granular basado en contexto.</p>
                </div>
                <!-- 2 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-netskope-green/10 flex items-center justify-center text-netskope-green mb-4">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3" data-i18n="card_2_title">Gobierno del dato</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_2_desc">Control DLP en tiempo real durante la navegación, previniendo pérdida de datos sensibles en aplicaciones web y cloud.</p>
                </div>
                <!-- 3 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-netskope-orange/10 flex items-center justify-center text-netskope-orange mb-4">
                        <i data-lucide="bot" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3">Data Protection (AI)</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_3_desc">Seguridad proactiva para herramientas de IA generativa, controlando qué datos se comparten y previniendo fugas de IP.</p>
                </div>
                <!-- 4 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-purple-600/10 flex items-center justify-center text-purple-600 mb-4">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3">Threat Protection</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_4_desc">Detección avanzada de amenazas con sandboxing, machine learning y análisis en tiempo real de contenido malicioso.</p>
                </div>
                <!-- 5 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-netskope-teal/10 flex items-center justify-center text-netskope-teal mb-4">
                        <i data-lucide="link" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3">EDR Integration</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_5_desc">Correlación de eventos de red con endpoints mediante Cloud Exchange, habilitando respuesta extendida a incidentes.</p>
                </div>
                <!-- 6 -->
                <div class="bg-white p-6 rounded-netskope shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 card-hover flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-netskope-orange/10 flex items-center justify-center text-netskope-orange mb-4">
                        <i data-lucide="smartphone" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-3" data-i18n="card_6_title">Dispositivos No Gestionados</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_6_desc">Extiende la seguridad a contratistas y BYOD sin instalar agentes, asegurando el dato.</p>
                </div>
            </div>

            <!-- Cloud Exchange Highlight -->
            <div class="mt-16">
                <div class="bg-netskope-deepBlue rounded-netskope overflow-hidden shadow-lg">
                    <div class="flex flex-col lg:flex-row">
                        <div class="lg:w-1/2 p-12 text-white">
                            <h3 class="text-2xl font-bold mb-6">Cloud Exchange</h3>
                            <p class="text-netskope-lightBlue mb-6 leading-relaxed" data-i18n="ce_desc">Netskope Cloud Exchange amplía las capacidades de seguridad mediante integraciones nativas con ecosistemas de seguridad líderes.</p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center gap-3"><span class="text-netskope-blue">✓</span> <span data-i18n="ce_item_1">Integración con EDR, SIEM y XSOAR</span></li>
                                <li class="flex items-center gap-3"><span class="text-netskope-blue">✓</span> <span data-i18n="ce_item_2">Orquestación de respuestas automatizadas</span></li>
                                <li class="flex items-center gap-3"><span class="text-netskope-blue">✓</span> <span data-i18n="ce_item_3">API-first para integraciones personalizadas</span></li>
                            </ul>
                            <a href="https://www.netskope.com/products/cloud-exchange" target="_blank" class="inline-flex items-center gap-2 bg-white text-netskope-deepBlue px-6 py-3 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all">
                                <span data-i18n="ce_button">Ver arquitectura Cloud Exchange</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                        <div class="lg:w-1/2 bg-gray-900 flex items-center justify-center p-4">
                            <img src="assets/images/external/netskope-cloud-exchange.png" alt="Netskope Cloud Exchange" class="rounded-lg shadow-2xl border border-gray-800 max-w-full h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reporte de Visibilidad -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="bg-gradient-to-r from-netskope-deepBlue to-netskope-teal rounded-netskope overflow-hidden shadow-xl">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-2/3 p-12 text-white">
                        <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-4 block" data-i18n="report_label">Visibilidad Completa</span>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="report_title">Informe de Visibilidad de Aplicaciones</h2>
                        <p class="text-netskope-lightBlue text-lg mb-8 leading-relaxed" data-i18n="report_subtitle">Nuestro análisis te proporciona una visión completa de dónde navegan tus usuarios y a qué riesgos se exponen.</p>
                        
                        <!-- Grid original de 4 elementos restaurado -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Shadow IT</h4>
                                    <p class="text-sm text-white/80" data-i18n="report_item_1">¿qué aplicaciones están usando tus usuarios y no están gestionadas?</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="report_item_2_title">Análisis de Riesgo</h4>
                                    <p class="text-sm text-white/80">Threat Protection</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="report_item_3_title">Tendencias en Tiempo Real</h4>
                                    <p class="text-sm text-white/80" data-i18n="report_item_3_desc">Monitoreo continuo del movimiento de datos</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="report_item_4_title">Recomendaciones</h4>
                                    <p class="text-sm text-white/80" data-i18n="report_item_4_desc">Plan de remediación</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="reportit.php" class="inline-flex items-center gap-3 bg-white text-netskope-deepBlue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-lg hover:-translate-y-1">
                            <i data-lucide="file-bar-chart" class="w-5 h-5"></i>
                            <span data-i18n="report_button">Ver Informe de Visibilidad</span>
                        </a>
                    </div>
                    
                    <!-- Escudo original restaurado -->
                    <div class="lg:w-1/3 bg-black/20 flex items-center justify-center p-8">
                        <div class="relative">
                            <div class="w-48 h-48 mx-auto bg-[#00A9CE] rounded-full flex items-center justify-center mb-6 shadow-lg">
                                <svg class="w-20 h-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="text-center text-white">
                                <h3 class="text-xl font-bold mb-2" data-i18n="custom_analysis_title">Análisis Personalizado</h3>
                                <p class="text-sm opacity-80" data-i18n="custom_analysis_desc">Informe adaptado a tu entorno específico</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to action final -->
    <section class="pb-20 bg-white text-center">
        <div class="flex flex-col md:flex-row justify-center gap-6 px-6">
            <a href="keydifferentiators.php" class="bg-netskope-blue text-white px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-teal transition-all shadow-md flex items-center justify-center gap-3">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <span data-i18n="nav_who">¿Quién es Netskope?</span>
            </a>
            <a href="index.php" class="bg-white text-netskope-deepBlue border border-netskope-blue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-md flex items-center justify-center gap-3">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span data-i18n="nav_back">Volver a la landing</span>
            </a>
            <a href="demos.php" class="bg-netskope-orange text-white px-8 py-4 rounded-netskope-sm font-bold hover:opacity-90 transition-all shadow-md flex items-center justify-center gap-3">
                <i data-lucide="play-circle" class="w-5 h-5"></i>
                <span data-i18n="nav_demo">¿Quieres Verlo? 😉</span>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Utilidades JS compartidas (changeLanguage, modales, portapapeles) y diccionario
         de traducciones común. Deben cargarse antes del script inline de abajo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- Script de Traducción Nativo: diccionario específico de esta página, fusionado
         con NetskopeCommonI18n (assets/js/i18n-common.js) para los textos compartidos. -->
    <script>
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "secure_saas": "SaaS y Navegación Segura",
                "hero_title_1": "La Evolución de la", "hero_title_2": "Navegación Web.",
                "hero_subtitle": "Más del 95% del tráfico está cifrado. Más del 50% del malware viene de la nube. <br><strong class=\"text-netskope-deepBlue font-semibold\">Los proxies tradicionales están ciegos ante las amenazas actuales.</strong>",
                "stat_shadow": "Son 'Shadow IT'", "stat_traffic": "Tráfico es SaaS", "stat_malware": "malware en SaaS",
                "analyst_title": "Lo que dicen los analistas",
                "quote_1": "\"Los Threat Actors aprovechan servicios legítimos de la nube y SaaS para eludir los controles de seguridad tradicionales basados en el perímetro.\"",
                "quote_2": "\"La mayoría del tráfico empresarial está ahora encriptado, limitando la efectividad de los controles de seguridad tradicionales.\"",
                "quote_3": "\"Más de la mitad de las aplicaciones SaaS utilizadas por los empleados no están gestionadas por TI. La falta de visibilidad sigue siendo uno de los principales desafíos.\"",
                "strat_label": "Estrategia de Netskope", "strat_title": "Cinco pilares para la Evolución de la Navegación", "strat_subtitle": "Next-Gen Secure Web Gateway que incluye CASB, DLP y Enterprise Browser",
                "pillar_1_desc": "Protección constante esté donde esté el usuario: oficina, casa o una cafetería.",
                "pillar_1_item_1": "Sin backhauling al CPD, direct-to-cloud", "pillar_1_item_2": "Un solo agente, Netskope Client",
                "pillar_2_desc": "Control granular de actividades e instancias. No bloquees la app, controla su uso y actividades.",
                "pillar_3_title": "Visibilidad - Shadow IT", "pillar_3_desc": "Descubre el 97% de apps que el firewall no ve. Evalua riesgos automáticamente.", "pillar_3_item_2": "+80,000 Apps Clasificadas",
                "pillar_4_desc": "Defensa avanzada contra malware en la nube y web. Sandboxing y ML en tiempo real.", "pillar_4_item_1": "50% del malware viene de la nube", "pillar_4_item_2": "Antiphishing con Machine Learning",
                "pillar_5_title": "Enterprise Browser", "pillar_5_desc": "Navegador seguro gestionado para dispositivos no gestionados y terceros.", "pillar_5_item_1": "Acceso Zero Trust sin agentes", "pillar_5_item_2": "DLP y Protección contra amenazas nativa",
                "use_case_label": "IMPLEMENTACIÓN PRÁCTICA", "use_case_title": "Casos de uso clave", "use_case_subtitle": "Descubre cómo Netskope transforma la seguridad de navegación en escenarios reales",
                "context_title": "El Contexto Importa: Zero Trust Engine", "context_desc": "Las políticas basadas en \"Permitir/Bloquear Dominio\" ya no sirven. Netskope decodifica el lenguaje de la nube (API/JSON) en tiempo real.",
                "context_who": "QUIÉN", "context_device": "DISPOSITIVO", "context_app": "APP & INSTANCIA", "context_activity": "ACTIVIDAD", "context_data": "DATO",
                "card_1_title": "Navegación", "card_1_desc": "Protección contra amenazas web y phishing con inspección SSL completa y control de acceso granular basado en contexto.",
                "card_2_title": "Gobierno del dato", "card_2_desc": "Control DLP en tiempo real durante la navegación, previniendo pérdida de datos sensibles en aplicaciones web y cloud.",
                "card_3_desc": "Seguridad proactiva para herramientas de IA generativa, controlando qué datos se comparten y previniendo fugas de IP.",
                "card_4_desc": "Detección avanzada de amenazas con sandboxing, machine learning y análisis en tiempo real de contenido malicioso.",
                "card_5_desc": "Correlación de eventos de red con endpoints mediante Cloud Exchange, habilitando respuesta extendida a incidentes.",
                "card_6_title": "Dispositivos No Gestionados", "card_6_desc": "Extiende la seguridad a contratistas y BYOD sin instalar agentes, asegurando el dato.",
                "ce_desc": "Netskope Cloud Exchange amplía las capacidades de seguridad mediante integraciones nativas con ecosistemas de seguridad líderes.", "ce_item_1": "Integración con EDR, SIEM y XSOAR", "ce_item_2": "Orquestación de respuestas automatizadas", "ce_item_3": "API-first para integraciones personalizadas", "ce_button": "Ver arquitectura Cloud Exchange",
                "report_label": "Visibilidad Completa", "report_title": "Informe de Visibilidad de Aplicaciones", "report_subtitle": "Nuestro análisis te proporciona una visión completa de dónde navegan tus usuarios y a qué riesgos se exponen.",
                "report_item_1": "¿qué aplicaciones están usando tus usuarios y no están gestionadas?", "report_item_2_title": "Análisis de Riesgo",
                "report_item_3_title": "Tendencias en Tiempo Real", "report_item_3_desc": "Monitoreo continuo del movimiento de datos",
                "report_item_4_title": "Recomendaciones", "report_item_4_desc": "Plan de remediación",
                "report_button": "Ver Informe de Visibilidad", "custom_analysis_title": "Análisis Personalizado", "custom_analysis_desc": "Informe adaptado a tu entorno específico"
                // nav_who / nav_back / nav_demo ahora vienen de NetskopeCommonI18n
            }
        };

        // changeLanguage(lang) es ahora la función compartida de assets/js/common.js,
        // que opera sobre el objeto global `translations` definido arriba.

        document.addEventListener('DOMContentLoaded', () => {
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
            lucide.createIcons();
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
