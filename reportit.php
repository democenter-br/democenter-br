<?php
// reportit.php - Reporte/dashboard de ejemplo de visibilidad, DLP y Threat
// Protection (gráficas Chart.js: violaciones DLP, tendencia de amenazas). Se
// enlaza normalmente desde navigationevolution.php como "informe de
// visibilidad" de cierre de demo.
//
// Las funciones JS comunes (changeLanguage boilerplate, etc.) viven en
// assets/js/common.js y los textos i18n compartidos entre páginas viven en
// assets/js/i18n-common.js. El diccionario `translations` de este archivo solo
// contiene cadenas específicas de esta página. changeLanguage() sigue
// definida localmente porque además debe refrescar las gráficas Chart.js;
// delega el trabajo repetitivo de aplicar el diccionario al DOM en
// NetskopeCommon.applyLanguage().
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard de visibilidad, DLP y threat protection alineado visual y funcionalmente con el resto del portal.">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Report IT</title>
    
    <!-- CDNs Oficiales -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
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
        .chart-container { position: relative; height: 300px; width: 100%; }
        .rounded-netskope { border-radius: 24px; }

        /* Language Switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="antialiased text-base">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-gray-100/50">
        <div class="container mx-auto px-6 md:px-12 py-5 flex justify-between items-center">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6">
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header_subtitle">Dashboard de Visibilidad, DLP y Threat Protection</span>
                
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-white pt-20 pb-24 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-teal"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="hero_tag">Seguridad Integral en la Nube</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="hero_title_1">Dashboard de</span> <br>
                    <span class="font-lora italic font-normal text-netskope-blue" data-i18n="hero_title_2">Visibilidad, DLP y Threat Protection</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero_desc">Protección completa contra amenazas en la nube, Shadow IT y fugas de datos. <br><strong class="text-netskope-deepBlue font-semibold">Más del 50% del malware viene de la nube.</strong></p>

                <!-- Stats single line -->
                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-teal mb-1">97%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide">Shadow IT</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">4.279</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stats_risk">Eventos de Riesgo</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-orange mb-1">13</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stats_dlp">Violaciones DLP</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Metrics -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-netskope-deepBlue mb-2" data-i18n="dash_title">Dashboard de Seguridad Integral</h2>
            <p class="text-netskope-gray mb-10" data-i18n="dash_subtitle">Visión completa de visibilidad, protección de datos y amenazas en la nube</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <!-- Metric 1 -->
                <div class="bg-gradient-to-r from-netskope-lightBlue to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">5.9TB</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_1_label">Datos Transferidos</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-blue/10 flex items-center justify-center">
                            <i data-lucide="download-cloud" class="w-6 h-6 text-netskope-blue"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 12%</span> <span data-i18n="metric_1_comp">vs mes anterior</span>
                    </div>
                </div>
                
                <!-- Metric 2 -->
                <div class="bg-gradient-to-r from-netskope-green/20 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">1.885</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_2_label">Apps Detectadas</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-green/20 flex items-center justify-center">
                            <i data-lucide="layout-grid" class="w-6 h-6 text-netskope-green"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 8%</span> <span data-i18n="metric_2_comp">nuevas apps este mes</span>
                    </div>
                </div>
                
                <!-- Metric 3 -->
                <div class="bg-gradient-to-r from-netskope-orange/10 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">13</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_3_label">Violaciones DLP</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-orange/10 flex items-center justify-center">
                            <i data-lucide="shield-alert" class="w-6 h-6 text-netskope-orange"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↓ 5%</span> <span data-i18n="metric_3_comp">reducción vs mes anterior</span>
                    </div>
                </div>
                
                <!-- Metric 4 -->
                <div class="bg-gradient-to-r from-purple-100 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">44</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_4_label">Amenazas Bloqueadas</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-200 flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-purple-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 18%</span> <span data-i18n="metric_4_comp">más amenazas detectadas</span>
                    </div>
                </div>
            </div>

            <!-- DLP Section -->
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-netskope-teal flex items-center justify-center">
                        <i data-lucide="lock" class="w-5 h-5 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-netskope-deepBlue" data-i18n="dlp_title">Protección de Datos (DLP)</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-sm">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="dlp_overview_title">Resumen de Violaciones DLP</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_total">Total Violaciones</div><div class="text-sm text-netskope-gray" data-i18n="time_this_month">Este mes</div></div>
                                <div class="text-2xl font-bold text-netskope-orange">13</div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_exposed">Datos Sensibles Expuestos</div><div class="text-sm text-netskope-gray" data-i18n="dlp_in_violations">En violaciones</div></div>
                                <div class="text-2xl font-bold text-netskope-orange">2.3GB</div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_top_apps">Apps con Más Violaciones</div><div class="text-sm text-netskope-gray">Top 3</div></div>
                                <div class="text-right"><div class="font-bold text-netskope-deepBlue">ChatGPT (5)</div><div class="text-sm text-netskope-gray">Dropbox (4) • Gmail (4)</div></div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-bold text-netskope-teal mb-3" data-i18n="dlp_types_title">Tipos de Datos Comprometidos</h4>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_pii">Información Personal (PII)</span><span class="text-sm font-bold text-netskope-orange">45%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-orange h-2 rounded-full" style="width: 45%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_ip">Propiedad Intelectual</span><span class="text-sm font-bold text-netskope-blue">32%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-blue h-2 rounded-full" style="width: 32%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_financial">Datos Financieros</span><span class="text-sm font-bold text-netskope-teal">18%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-teal h-2 rounded-full" style="width: 18%"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-netskope-deepBlue/5 to-white p-6 rounded-netskope border border-netskope-blue/20">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="dlp_policies_title">Políticas DLP Activas</h3>
                        <div class="space-y-4 mb-6">
                            <div class="p-3 bg-white rounded-[12px] border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-netskope-deepBlue" data-i18n="policy_1_name">✓ Bloqueo de PII en ChatGPT</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded" data-i18n="status_active">Activa</span>
                                </div>
                                <p class="text-sm text-netskope-gray" data-i18n="policy_1_desc">Bloquea información personal identificable en prompts de IA</p>
                            </div>
                            <div class="p-3 bg-white rounded-[12px] border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-netskope-deepBlue" data-i18n="policy_2_name">✓ Monitoreo de IP en GitHub</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded" data-i18n="status_active">Activa</span>
                                </div>
                                <p class="text-sm text-netskope-gray" data-i18n="policy_2_desc">Detecta código fuente sensible en repositorios públicos</p>
                            </div>
                        </div>
                        <div class="bg-netskope-lightBlue/30 p-4 rounded-[12px]">
                            <h4 class="font-bold text-netskope-deepBlue mb-2" data-i18n="dlp_rec_title">Recomendaciones DLP</h4>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="dlp_rec_1"><strong>Implementar política de bloqueo</strong> para datos financieros</span></li>
                                <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="dlp_rec_2"><strong>Extender DLP a Microsoft Copilot</strong></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="bg-netskope-offWhite p-6 rounded-netskope mb-8">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="chart_dlp_title">Violaciones DLP por Aplicación</h3>
                    <div class="chart-container"><canvas id="dlpViolationsChart"></canvas></div>
                </div>
            </div>

            <!-- Threat Protection Section -->
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-netskope-deepBlue" data-i18n="threat_title">Protección contra Amenazas</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-sm">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_overview_title">Resumen de Amenazas</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-netskope-offWhite p-4 rounded-[12px] text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-1">44</div><div class="text-sm text-netskope-gray" data-i18n="threat_stat_1">Amenazas Bloqueadas</div>
                            </div>
                            <div class="bg-netskope-offWhite p-4 rounded-[12px] text-center">
                                <div class="text-3xl font-bold text-netskope-orange mb-1">27</div><div class="text-sm text-netskope-gray" data-i18n="threat_stat_2">Alertas de Phishing</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-netskope border border-purple-200">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_types_title">Tipos de Amenazas Detectadas</h3>
                        <div class="space-y-4">
                            <div class="p-3 bg-white rounded-[12px] border border-red-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-red-500 rounded-full"></div><span class="font-medium text-netskope-deepBlue" data-i18n="threat_type_1">Phishing</span></div>
                                    <span class="text-sm font-bold text-red-600">27 casos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-netskope shadow-sm border border-gray-100 mb-12">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_trend_title">Tendencia de Amenazas</h3>
                    <div class="chart-container"><canvas id="threatsTrendChart"></canvas></div>
                </div>
            </div>

            <!-- Risk Assessment Summary (Imagen 2 Reparada) -->
            <div class="bg-white border border-gray-200 p-8 rounded-netskope shadow-sm mb-16">
                <h3 class="text-2xl font-bold text-netskope-deepBlue mb-6" data-i18n="risk_title">Evaluación de Riesgo Consolidada</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-netskope-orange flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="alert-triangle" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">Shadow IT</h4>
                        <div class="text-3xl font-bold text-netskope-orange mb-2" data-i18n="risk_high">Alto</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_shadow_desc">97% de apps no aprobadas</p>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-netskope-teal flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="lock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">DLP</h4>
                        <div class="text-3xl font-bold text-netskope-teal mb-2" data-i18n="risk_medium">Medio</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_dlp_desc">13 violaciones en riesgo</p>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-purple-600 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="shield" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">Threat Protection</h4>
                        <div class="text-3xl font-bold text-purple-600 mb-2" data-i18n="risk_med_high">Medio-Alto</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_tp_desc">44 amenazas bloqueadas</p>
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-lg font-bold text-netskope-teal mb-4" data-i18n="action_plan_title">Plan de Acción Prioritario</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-r from-netskope-lightBlue to-white p-6 rounded-[12px] border border-gray-100">
                            <h5 class="font-bold text-netskope-deepBlue mb-3" data-i18n="plan_short">Corto Plazo</h5>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_1">Implementar políticas de bloqueo para datos financieros</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_2">Activar sandboxing para apps de alto riesgo</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_3">Revisar políticas de acceso a Microsoft Copilot</span></li>
                            </ul>
                        </div>
                        <div class="bg-gradient-to-r from-netskope-green/20 to-white p-6 rounded-[12px] border border-gray-100">
                            <h5 class="font-bold text-netskope-deepBlue mb-3" data-i18n="plan_med">Medio Plazo</h5>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_1">Crear programa de awareness sobre Shadow IT</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_2">Implementar DLP para GDPR/HIPAA</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_3">Establecer políticas de uso de IA corporativa</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How Netskope Provides Comprehensive Protection (Sección de Captura Restaurada) -->
    <section class="py-20 bg-gradient-to-br from-[#081A59] to-[#00A9CE] text-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-center mb-12" data-i18n="comp_prot_title">Cómo Netskope Proporciona Protección Integral</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Visibilidad -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#008095] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="eye" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_vis_title">Visibilidad Total</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_vis_desc">Detecta el 97% de aplicaciones que los firewalls tradicionales no ven, incluyendo Shadow IT y aplicaciones no autorizadas.</p>
                </div>
                
                <!-- DLP -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#00A9CE] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="lock" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_dlp_title">Protección de Datos (DLP)</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_dlp_desc">DLP avanzado para prevenir fugas de datos sensibles hacia aplicaciones no autorizadas y Shadow IT.</p>
                </div>
                
                <!-- Threat Protection -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#9333ea] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_tp_title">Threat Protection</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_tp_desc">Defensa avanzada contra malware en la nube, phishing y ataques zero-day con sandboxing y ML.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved. | Privacy Policy
            </p>
        </div>
    </footer>

    <!-- Utilidades JS compartidas (NetskopeCommon.applyLanguage, etc.) y diccionario
         de traducciones común. Deben cargarse antes del script inline de abajo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- Scripts de Control -->
    <script>
        // Diccionario específico de esta página, fusionado con NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header_subtitle": "Dashboard de Visibilidad, DLP y Threat Protection",
                "hero_tag": "Seguridad Integral en la Nube",
                "hero_title_1": "Dashboard de", "hero_title_2": "Visibilidad, DLP y Threat Protection",
                "hero_desc": "Protección completa contra amenazas en la nube, Shadow IT y fugas de datos. <br><strong class=\"text-netskope-deepBlue font-semibold\">Más del 50% del malware viene de la nube.</strong>",
                "stats_risk": "Eventos de Riesgo", "stats_dlp": "Violaciones DLP",
                "dash_title": "Dashboard de Seguridad Integral",
                "dash_subtitle": "Visión completa de visibilidad, protección de datos y amenazas en la nube",
                "metric_1_label": "Datos Transferidos", "metric_1_comp": "vs mes anterior",
                "metric_2_label": "Apps Detectadas", "metric_2_comp": "nuevas apps este mes",
                "metric_3_label": "Violaciones DLP", "metric_3_comp": "reducción vs mes anterior",
                "metric_4_label": "Amenazas Bloqueadas", "metric_4_comp": "más amenazas detectadas",
                "dlp_title": "Protección de Datos (DLP)",
                "dlp_overview_title": "Resumen de Violaciones DLP",
                "dlp_total": "Total Violaciones", "time_this_month": "Este mes",
                "dlp_exposed": "Datos Sensibles Expuestos", "dlp_in_violations": "En violaciones",
                "dlp_top_apps": "Apps con Más Violaciones",
                "dlp_types_title": "Tipos de Datos Comprometidos",
                "dlp_pii": "Información Personal (PII)", "dlp_ip": "Propiedad Intelectual", "dlp_financial": "Datos Financieros", "dlp_other": "Otros",
                "dlp_policies_title": "Políticas DLP Activas", "policy_1_name": "✓ Bloqueo de PII en ChatGPT", "status_active": "Activa",
                "policy_1_desc": "Bloquea información personal identificable en prompts de IA",
                "policy_2_name": "✓ Monitoreo de IP en GitHub", "policy_2_desc": "Detecta código fuente sensible en repositorios públicos",
                "policy_3_name": "⚠ Alerta por datos financieros en email", "status_alert": "Alerta", "policy_3_desc": "Notifica pero no bloquea datos financieros en correos externos",
                "dlp_rec_title": "Recomendaciones DLP",
                "dlp_rec_1": "<strong>Implementar política de bloqueo</strong> para datos financieros en emails externos",
                "dlp_rec_2": "<strong>Extender DLP a Microsoft Copilot</strong> para instancias no corporativas",
                "dlp_rec_3": "<strong>Crear política específica</strong> para datos de salud (HIPAA) en apps de IA",
                "chart_dlp_title": "Violaciones DLP por Aplicación",
                "chart_dlp_desc_1": "<span class=\"text-netskope-orange font-bold\">ChatGPT lidera</span> con 5 violaciones, seguido por Dropbox y Gmail con 4 cada uno.",
                "chart_dlp_desc_2": "<span class=\"text-netskope-blue\">87% de las violaciones</span> ocurren en aplicaciones de Shadow IT no aprobadas.",
                "threat_title": "Protección contra Amenazas", "threat_overview_title": "Resumen de Amenazas",
                "threat_stat_1": "Amenazas Bloqueadas", "threat_stat_2": "Alertas de Phishing", "threat_stat_3": "Malware Detectado", "threat_stat_4": "Ataques Zero-Day",
                "threat_bar_1": "Amenazas Provenientes de la Nube", "threat_desc_1": "Más de la mitad del malware viene de aplicaciones en la nube",
                "threat_bar_2": "Tiempo Medio de Detección", "threat_desc_2": "Detección en tiempo real con machine learning",
                "threat_bar_3": "Prevención de Pérdida de Datos", "threat_desc_3": "Efectividad en prevenir exfiltración de datos",
                "threat_types_title": "Tipos de Amenazas Detectadas", "threat_type_1": "Phishing y Credential Theft",
                "threat_type_1_desc": "Sitios fraudulentos que imitan apps corporativas para robar credenciales",
                "threat_type_2": "Malware en la Nube", "threat_type_2_desc": "Archivos maliciosos en SharePoint, Dropbox y otras apps colaborativas",
                "threat_type_3": "Zero-Day Exploits", "threat_type_3_desc": "Vulnerabilidades no parcheadas en aplicaciones SaaS",
                "threat_cap_title": "Capacidades de Threat Protection",
                "threat_cap_1": "<strong>Sandboxing en tiempo real</strong> para análisis dinámico de archivos",
                "threat_cap_2": "<strong>Machine Learning</strong> para detección de phishing avanzado",
                "threat_cap_3": "<strong>Threat Intelligence</strong> integrada con feeds globales",
                "threat_trend_title": "Tendencia de Amenazas (Últimos 6 Meses)",
                "trend_1": "Aumento en amenazas de phishing", "trend_2": "Aumento en malware en la nube", "trend_3": "Reducción en tiempo de detección",
                "risk_title": "Evaluación de Riesgo Consolidada", "risk_high": "Alto", "risk_shadow_desc": "97% de apps no aprobadas, 60% del tráfico a SaaS",
                "risk_medium": "Medio", "risk_dlp_desc": "13 violaciones, 2.3GB de datos en riesgo", "risk_med_high": "Medio-Alto", "risk_tp_desc": "44 amenazas bloqueadas, 52% de malware de la nube",
                "action_plan_title": "Plan de Acción Prioritario", "plan_short": "Corto Plazo",
                "plan_short_1": "Implementar políticas de bloqueo para datos financieros", "plan_short_2": "Activar sandboxing para apps de alto riesgo", "plan_short_3": "Revisar políticas de acceso a Microsoft Copilot",
                "plan_med": "Medio Plazo", "plan_med_1": "Crear programa de awareness sobre Shadow IT", "plan_med_2": "Implementar DLP para GDPR/HIPAA", "plan_med_3": "Establecer políticas de uso de IA corporativa",
                "comp_prot_title": "Cómo Netskope Proporciona Protección Integral", "comp_vis_title": "Visibilidad Total", "comp_vis_desc": "Detecta el 97% de aplicaciones que los firewalls tradicionales no ven, incluyendo Shadow IT y aplicaciones no autorizadas.",
                "comp_dlp_title": "Protección de Datos (DLP)", "comp_dlp_desc": "DLP avanzado para prevenir fugas de datos sensibles hacia aplicaciones no autorizadas y Shadow IT.",
                "comp_tp_title": "Threat Protection", "comp_tp_desc": "Defensa avanzada contra malware en la nube, phishing y ataques zero-day con sandboxing y ML.",
                
                // Gráficos
                "chart_labels_dlp": ['ChatGPT', 'Dropbox', 'Gmail', 'OneDrive', 'Slack', 'GitHub', 'Otros'],
                "chart_label_dlp_dataset": "Violaciones DLP",
                "chart_labels_months": ['Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero'],
                "chart_label_phishing": "Phishing", "chart_label_malware": "Malware", "chart_label_blocked": "Amenazas Bloqueadas"
            }
        };

        let dlpViolationsChart, threatsTrendChart;

        /**
         * changeLanguage(lang)
         * Se mantiene local (no se delega por completo en assets/js/common.js) porque,
         * además de traducir el DOM, esta página necesita refrescar las etiquetas de
         * las gráficas Chart.js (DLP y tendencia de amenazas). El trabajo repetitivo
         * de aplicar el diccionario al DOM se delega en NetskopeCommon.applyLanguage.
         */
        function changeLanguage(lang) {
            lang = NetskopeCommon.applyLanguage(lang, translations);
            const dict = translations[lang];

            if (dlpViolationsChart) {
                dlpViolationsChart.data.labels = dict.chart_labels_dlp;
                dlpViolationsChart.data.datasets[0].label = dict.chart_label_dlp_dataset;
                dlpViolationsChart.update();
            }

            if (threatsTrendChart) {
                threatsTrendChart.data.labels = dict.chart_labels_months;
                threatsTrendChart.data.datasets[0].label = dict.chart_label_phishing;
                threatsTrendChart.data.datasets[1].label = dict.chart_label_malware;
                threatsTrendChart.data.datasets[2].label = dict.chart_label_blocked;
                threatsTrendChart.update();
            }
        }

        // Inicialización: crea las 2 gráficas Chart.js de la página (datos de demo fijos,
        // no vienen de ningún backend) y luego aplica el idioma guardado, que a su vez
        // refresca las etiquetas de ambas gráficas vía changeLanguage().
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            // Barras: violaciones DLP por aplicación (ChatGPT, Dropbox, Gmail, etc.).
            const dlpViolationsCtx = document.getElementById('dlpViolationsChart').getContext('2d');
            dlpViolationsChart = new Chart(dlpViolationsCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Violaciones',
                        data: [5, 4, 4, 2, 1, 1, 3],
                        backgroundColor: ['#FF8200', '#00A9CE', '#008095', '#AFF198', '#081A59', '#53565A', '#C8C9C7'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // Línea: tendencia de 6 meses de phishing, malware y amenazas bloqueadas.
            const threatsTrendCtx = document.getElementById('threatsTrendChart').getContext('2d');
            threatsTrendChart = new Chart(threatsTrendCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        { label: 'Phishing', data: [18, 20, 22, 24, 25, 27], borderColor: '#FF8200', backgroundColor: 'rgba(255, 130, 0, 0.1)', fill: true, tension: 0.4 },
                        { label: 'Malware', data: [10, 12, 13, 14, 14, 15], borderColor: '#00A9CE', backgroundColor: 'rgba(0, 169, 206, 0.1)', fill: true, tension: 0.4 },
                        { label: 'Amenazas Bloqueadas', data: [30, 32, 35, 38, 41, 44], borderColor: '#008095', backgroundColor: 'rgba(0, 128, 149, 0.1)', fill: false, tension: 0.4, borderDash: [5, 5] }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: { y: { beginAtZero: true } }
                }
            });

            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
