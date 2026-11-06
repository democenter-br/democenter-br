<?php
// reportit.php - Relatório/dashboard de exemplo de visibilidade, DLP e Threat
// Protection (gráficos Chart.js: violações DLP, tendência de ameaças). É
// vinculado normalmente a partir de navigationevolution.php como "relatório de
// visibilidade" de encerramento da demo.
//
// As funções JS comuns (changeLanguage boilerplate, etc.) ficam em
// assets/js/common.js e os textos i18n compartilhados entre páginas ficam em
// assets/js/i18n-common.js. O dicionário `translations` deste arquivo contém
// apenas strings específicas desta página. changeLanguage() continua
// definida localmente porque também precisa atualizar os gráficos Chart.js;
// delega o trabalho repetitivo de aplicar o dicionário ao DOM para
// NetskopeCommon.applyLanguage().
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard de visibilidade, DLP e threat protection alinhado visual e funcionalmente com o restante do portal.">
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
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header_subtitle">Dashboard de Visibilidade, DLP e Threat Protection</span>
                
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
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="hero_tag">Segurança Integral na Nuvem</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="hero_title_1">Dashboard de</span> <br>
                    <span class="font-lora italic font-normal text-netskope-blue" data-i18n="hero_title_2">Visibilidade, DLP e Threat Protection</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero_desc">Proteção completa contra ameaças na nuvem, Shadow IT e vazamentos de dados. <br><strong class="text-netskope-deepBlue font-semibold">Mais de 50% do malware vem da nuvem.</strong></p>

                <!-- Stats single line -->
                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-teal mb-1">97%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide">Shadow IT</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">4.279</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stats_risk">Eventos de Risco</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-orange mb-1">13</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stats_dlp">Violações DLP</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Metrics -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-netskope-deepBlue mb-2" data-i18n="dash_title">Dashboard de Segurança Integral</h2>
            <p class="text-netskope-gray mb-10" data-i18n="dash_subtitle">Visão completa de visibilidade, proteção de dados e ameaças na nuvem</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <!-- Metric 1 -->
                <div class="bg-gradient-to-r from-netskope-lightBlue to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">5.9TB</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_1_label">Dados Transferidos</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-blue/10 flex items-center justify-center">
                            <i data-lucide="download-cloud" class="w-6 h-6 text-netskope-blue"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 12%</span> <span data-i18n="metric_1_comp">vs mês anterior</span>
                    </div>
                </div>
                
                <!-- Metric 2 -->
                <div class="bg-gradient-to-r from-netskope-green/20 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">1.885</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_2_label">Apps Detectados</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-green/20 flex items-center justify-center">
                            <i data-lucide="layout-grid" class="w-6 h-6 text-netskope-green"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 8%</span> <span data-i18n="metric_2_comp">novos apps neste mês</span>
                    </div>
                </div>
                
                <!-- Metric 3 -->
                <div class="bg-gradient-to-r from-netskope-orange/10 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">13</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_3_label">Violações DLP</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-netskope-orange/10 flex items-center justify-center">
                            <i data-lucide="shield-alert" class="w-6 h-6 text-netskope-orange"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↓ 5%</span> <span data-i18n="metric_3_comp">redução vs mês anterior</span>
                    </div>
                </div>
                
                <!-- Metric 4 -->
                <div class="bg-gradient-to-r from-purple-100 to-white p-6 rounded-netskope card-hover border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold text-netskope-deepBlue">44</div>
                            <div class="text-sm text-netskope-gray mt-1" data-i18n="metric_4_label">Ameaças Bloqueadas</div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-200 flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-purple-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-netskope-gray">
                        <span class="text-netskope-green">↑ 18%</span> <span data-i18n="metric_4_comp">mais ameaças detectadas</span>
                    </div>
                </div>
            </div>

            <!-- DLP Section -->
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-netskope-teal flex items-center justify-center">
                        <i data-lucide="lock" class="w-5 h-5 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-netskope-deepBlue" data-i18n="dlp_title">Proteção de Dados (DLP)</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-sm">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="dlp_overview_title">Resumo de Violações DLP</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_total">Total de Violações</div><div class="text-sm text-netskope-gray" data-i18n="time_this_month">Este mês</div></div>
                                <div class="text-2xl font-bold text-netskope-orange">13</div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_exposed">Dados Sensíveis Expostos</div><div class="text-sm text-netskope-gray" data-i18n="dlp_in_violations">Em violações</div></div>
                                <div class="text-2xl font-bold text-netskope-orange">2.3GB</div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-netskope-offWhite rounded-[12px]">
                                <div><div class="font-medium text-netskope-gray" data-i18n="dlp_top_apps">Apps com Mais Violações</div><div class="text-sm text-netskope-gray">Top 3</div></div>
                                <div class="text-right"><div class="font-bold text-netskope-deepBlue">ChatGPT (5)</div><div class="text-sm text-netskope-gray">Dropbox (4) • Gmail (4)</div></div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-bold text-netskope-teal mb-3" data-i18n="dlp_types_title">Tipos de Dados Comprometidos</h4>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_pii">Informações Pessoais (PII)</span><span class="text-sm font-bold text-netskope-orange">45%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-orange h-2 rounded-full" style="width: 45%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_ip">Propriedade Intelectual</span><span class="text-sm font-bold text-netskope-blue">32%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-blue h-2 rounded-full" style="width: 32%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-netskope-gray" data-i18n="dlp_financial">Dados Financeiros</span><span class="text-sm font-bold text-netskope-teal">18%</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-netskope-teal h-2 rounded-full" style="width: 18%"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-netskope-deepBlue/5 to-white p-6 rounded-netskope border border-netskope-blue/20">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="dlp_policies_title">Políticas DLP Ativas</h3>
                        <div class="space-y-4 mb-6">
                            <div class="p-3 bg-white rounded-[12px] border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-netskope-deepBlue" data-i18n="policy_1_name">✓ Bloqueio de PII no ChatGPT</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded" data-i18n="status_active">Ativa</span>
                                </div>
                                <p class="text-sm text-netskope-gray" data-i18n="policy_1_desc">Bloqueia informações pessoais identificáveis em prompts de IA</p>
                            </div>
                            <div class="p-3 bg-white rounded-[12px] border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-netskope-deepBlue" data-i18n="policy_2_name">✓ Monitoramento de PI no GitHub</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded" data-i18n="status_active">Ativa</span>
                                </div>
                                <p class="text-sm text-netskope-gray" data-i18n="policy_2_desc">Detecta código-fonte sensível em repositórios públicos</p>
                            </div>
                        </div>
                        <div class="bg-netskope-lightBlue/30 p-4 rounded-[12px]">
                            <h4 class="font-bold text-netskope-deepBlue mb-2" data-i18n="dlp_rec_title">Recomendações DLP</h4>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="dlp_rec_1"><strong>Implementar política de bloqueio</strong> para dados financeiros</span></li>
                                <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="dlp_rec_2"><strong>Extender DLP a Microsoft Copilot</strong></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="bg-netskope-offWhite p-6 rounded-netskope mb-8">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="chart_dlp_title">Violações DLP por Aplicativo</h3>
                    <div class="chart-container"><canvas id="dlpViolationsChart"></canvas></div>
                </div>
            </div>

            <!-- Threat Protection Section -->
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-netskope-deepBlue" data-i18n="threat_title">Proteção contra Ameaças</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-sm">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_overview_title">Resumo de Ameaças</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-netskope-offWhite p-4 rounded-[12px] text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-1">44</div><div class="text-sm text-netskope-gray" data-i18n="threat_stat_1">Ameaças Bloqueadas</div>
                            </div>
                            <div class="bg-netskope-offWhite p-4 rounded-[12px] text-center">
                                <div class="text-3xl font-bold text-netskope-orange mb-1">27</div><div class="text-sm text-netskope-gray" data-i18n="threat_stat_2">Alertas de Phishing</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-netskope border border-purple-200">
                        <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_types_title">Tipos de Ameaças Detectadas</h3>
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
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="threat_trend_title">Tendência de Ameaças</h3>
                    <div class="chart-container"><canvas id="threatsTrendChart"></canvas></div>
                </div>
            </div>

            <!-- Risk Assessment Summary (Imagen 2 Reparada) -->
            <div class="bg-white border border-gray-200 p-8 rounded-netskope shadow-sm mb-16">
                <h3 class="text-2xl font-bold text-netskope-deepBlue mb-6" data-i18n="risk_title">Avaliação de Risco Consolidada</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-netskope-orange flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="alert-triangle" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">Shadow IT</h4>
                        <div class="text-3xl font-bold text-netskope-orange mb-2" data-i18n="risk_high">Alto</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_shadow_desc">97% de apps não aprovados</p>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-netskope-teal flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="lock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">DLP</h4>
                        <div class="text-3xl font-bold text-netskope-teal mb-2" data-i18n="risk_medium">Médio</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_dlp_desc">13 violações em risco</p>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-100 rounded-[24px]">
                        <div class="w-16 h-16 rounded-full bg-purple-600 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="shield" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-netskope-deepBlue mb-2">Threat Protection</h4>
                        <div class="text-3xl font-bold text-purple-600 mb-2" data-i18n="risk_med_high">Médio-Alto</div>
                        <p class="text-sm text-netskope-gray" data-i18n="risk_tp_desc">44 amenazas bloqueadas</p>
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-lg font-bold text-netskope-teal mb-4" data-i18n="action_plan_title">Plano de Ação Prioritário</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-r from-netskope-lightBlue to-white p-6 rounded-[12px] border border-gray-100">
                            <h5 class="font-bold text-netskope-deepBlue mb-3" data-i18n="plan_short">Curto Prazo</h5>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_1">Implementar políticas de bloqueio para dados financeiros</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_2">Ativar sandboxing para apps de alto risco</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_short_3">Revisar políticas de acesso ao Microsoft Copilot</span></li>
                            </ul>
                        </div>
                        <div class="bg-gradient-to-r from-netskope-green/20 to-white p-6 rounded-[12px] border border-gray-100">
                            <h5 class="font-bold text-netskope-deepBlue mb-3" data-i18n="plan_med">Médio Prazo</h5>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_1">Criar programa de awareness sobre Shadow IT</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_2">Implementar DLP para GDPR/HIPAA</span></li>
                                <li class="flex items-center gap-2 text-netskope-gray"><span class="text-netskope-green font-bold">✓</span> <span data-i18n="plan_med_3">Estabelecer políticas de uso de IA corporativa</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How Netskope Provides Comprehensive Protection (Seção de Captura Restaurada) -->
    <section class="py-20 bg-gradient-to-br from-[#081A59] to-[#00A9CE] text-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-center mb-12" data-i18n="comp_prot_title">Como a Netskope Oferece Proteção Integral</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Visibilidad -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#008095] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="eye" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_vis_title">Visibilidade Total</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_vis_desc">Detecta os 97% de aplicativos que os firewalls tradicionais não enxergam, incluindo Shadow IT e aplicativos não autorizados.</p>
                </div>
                
                <!-- DLP -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#00A9CE] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="lock" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_dlp_title">Proteção de Dados (DLP)</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_dlp_desc">DLP avançado para prevenir vazamentos de dados sensíveis para aplicativos não autorizados e Shadow IT.</p>
                </div>
                
                <!-- Threat Protection -->
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-[24px] text-center border border-white/10 hover:bg-white/20 transition-all shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-[#9333ea] flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-i18n="comp_tp_title">Threat Protection</h3>
                    <p class="text-[#D9FAFF] text-sm leading-relaxed" data-i18n="comp_tp_desc">Defesa avançada contra malware na nuvem, phishing e ataques zero-day com sandboxing e ML.</p>
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

    <!-- Utilitários JS compartilhados (NetskopeCommon.applyLanguage, etc.) e dicionário
         de traduções comum. Devem ser carregados antes do script inline abaixo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- Scripts de Controleee -->
    <script>
        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header_subtitle": "Dashboard de Visibilidade, DLP e Threat Protection",
                "hero_tag": "Segurança Integral na Nuvem",
                "hero_title_1": "Dashboard de", "hero_title_2": "Visibilidade, DLP e Threat Protection",
                "hero_desc": "Proteção completa contra ameaças na nuvem, Shadow IT e vazamentos de dados. <br><strong class=\"text-netskope-deepBlue font-semibold\">Mais de 50% do malware vem da nuvem.</strong>",
                "stats_risk": "Eventos de Risco", "stats_dlp": "Violações DLP",
                "dash_title": "Dashboard de Segurança Integral",
                "dash_subtitle": "Visão completa de visibilidade, proteção de dados e ameaças na nuvem",
                "metric_1_label": "Dados Transferidos", "metric_1_comp": "vs mês anterior",
                "metric_2_label": "Apps Detectados", "metric_2_comp": "novos apps neste mês",
                "metric_3_label": "Violações DLP", "metric_3_comp": "redução vs mês anterior",
                "metric_4_label": "Ameaças Bloqueadas", "metric_4_comp": "mais ameaças detectadas",
                "dlp_title": "Proteção de Dados (DLP)",
                "dlp_overview_title": "Resumo de Violações DLP",
                "dlp_total": "Total de Violações", "time_this_month": "Este mês",
                "dlp_exposed": "Dados Sensíveis Expostos", "dlp_in_violations": "Em violações",
                "dlp_top_apps": "Apps com Mais Violações",
                "dlp_types_title": "Tipos de Dados Comprometidos",
                "dlp_pii": "Informações Pessoais (PII)", "dlp_ip": "Propriedade Intelectual", "dlp_financial": "Dados Financeiros", "dlp_other": "Outros",
                "dlp_policies_title": "Políticas DLP Ativas", "policy_1_name": "✓ Bloqueio de PII no ChatGPT", "status_active": "Ativa",
                "policy_1_desc": "Bloqueia informações pessoais identificáveis em prompts de IA",
                "policy_2_name": "✓ Monitoramento de PI no GitHub", "policy_2_desc": "Detecta código-fonte sensível em repositórios públicos",
                "policy_3_name": "⚠ Alerta para dados financeiros em e-mail", "status_alert": "Alerta", "policy_3_desc": "Notifica, mas não bloqueia dados financeiros em e-mails externos",
                "dlp_rec_title": "Recomendações DLP",
                "dlp_rec_1": "<strong>Implementar política de bloqueio</strong> para dados financeiros em e-mails externos",
                "dlp_rec_2": "<strong>Estender o DLP ao Microsoft Copilot</strong> para instâncias não corporativas",
                "dlp_rec_3": "<strong>Criar política específica</strong> para dados de saúde (HIPAA) em apps de IA",
                "chart_dlp_title": "Violações DLP por Aplicativo",
                "chart_dlp_desc_1": "<span class=\"text-netskope-orange font-bold\">ChatGPT lidera</span> com 5 violações, seguido por Dropbox e Gmail com 4 cada.",
                "chart_dlp_desc_2": "<span class=\"text-netskope-blue\">87% das violações</span> ocorrem em aplicativos de Shadow IT não aprovados.",
                "threat_title": "Proteção contra Ameaças", "threat_overview_title": "Resumo de Ameaças",
                "threat_stat_1": "Ameaças Bloqueadas", "threat_stat_2": "Alertas de Phishing", "threat_stat_3": "Malware Detectado", "threat_stat_4": "Ataques Zero-Day",
                "threat_bar_1": "Ameaças Provenientes da Nuvem", "threat_desc_1": "Mais da metade do malware vem de aplicativos na nuvem",
                "threat_bar_2": "Tempo Médio de Detecção", "threat_desc_2": "Detecção em tempo real com machine learning",
                "threat_bar_3": "Prevenção de Perda de Dados", "threat_desc_3": "Eficácia na prevenção de exfiltração de dados",
                "threat_types_title": "Tipos de Ameaças Detectadas", "threat_type_1": "Phishing e Credential Theft",
                "threat_type_1_desc": "Sites fraudulentos que imitam apps corporativos para roubar credenciais",
                "threat_type_2": "Malware na Nuvem", "threat_type_2_desc": "Arquivos maliciosos no SharePoint, Dropbox e outros apps colaborativos",
                "threat_type_3": "Zero-Day Exploits", "threat_type_3_desc": "Vulnerabilidades sem correção em aplicações SaaS",
                "threat_cap_title": "Capacidades de Threat Protection",
                "threat_cap_1": "<strong>Sandboxing em tempo real</strong> para análise dinâmica de arquivos",
                "threat_cap_2": "<strong>Machine Learning</strong> para detecção de phishing avançado",
                "threat_cap_3": "<strong>Threat Intelligence</strong> integrada com feeds globais",
                "threat_trend_title": "Tendência de Ameaças (Últimos 6 Meses)",
                "trend_1": "Aumento nas ameaças de phishing", "trend_2": "Aumento de malware na nuvem", "trend_3": "Redução no tempo de detecção",
                "risk_title": "Avaliação de Risco Consolidada", "risk_high": "Alto", "risk_shadow_desc": "97% de apps não aprovados, 60% do tráfego para SaaS",
                "risk_medium": "Médio", "risk_dlp_desc": "13 violações, 2,3 GB de dados em risco", "risk_med_high": "Médio-Alto", "risk_tp_desc": "44 ameaças bloqueadas, 52% do malware vem da nuvem",
                "action_plan_title": "Plano de Ação Prioritário", "plan_short": "Curto Prazo",
                "plan_short_1": "Implementar políticas de bloqueio para dados financeiros", "plan_short_2": "Ativar sandboxing para apps de alto risco", "plan_short_3": "Revisar políticas de acesso ao Microsoft Copilot",
                "plan_med": "Médio Prazo", "plan_med_1": "Criar programa de awareness sobre Shadow IT", "plan_med_2": "Implementar DLP para GDPR/HIPAA", "plan_med_3": "Estabelecer políticas de uso de IA corporativa",
                "comp_prot_title": "Como a Netskope Oferece Proteção Integral", "comp_vis_title": "Visibilidade Total", "comp_vis_desc": "Detecta os 97% de aplicativos que os firewalls tradicionais não enxergam, incluindo Shadow IT e aplicativos não autorizados.",
                "comp_dlp_title": "Proteção de Dados (DLP)", "comp_dlp_desc": "DLP avançado para prevenir vazamentos de dados sensíveis para aplicativos não autorizados e Shadow IT.",
                "comp_tp_title": "Threat Protection", "comp_tp_desc": "Defesa avançada contra malware na nuvem, phishing e ataques zero-day com sandboxing e ML.",
                
                // Gráficos
                "chart_labels_dlp": ['ChatGPT', 'Dropbox', 'Gmail', 'OneDrive', 'Slack', 'GitHub', 'Outros'],
                "chart_label_dlp_dataset": "Violações DLP",
                "chart_labels_months": ['Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro', 'Janeiro'],
                "chart_label_phishing": "Phishing", "chart_label_malware": "Malware", "chart_label_blocked": "Ameaças Bloqueadas"
            }
        };

        let dlpViolationsChart, threatsTrendChart;

        /**
         * changeLanguage(lang)
         * É mantida local (não é totalmente delegada a assets/js/common.js) porque,
         * além de traduzir o DOM, esta página precisa atualizar os rótulos dos
         * gráficos Chart.js (DLP e tendência de ameaças). O trabalho repetitivo
         * de aplicar o dicionário ao DOM é delegado a NetskopeCommon.applyLanguage.
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

        // Inicialização: cria os 2 gráficos Chart.js da página (dados de demo fixos,
        // não vêm de nenhum backend) e depois aplica o idioma salvo, que por sua vez
        // atualiza os rótulos de ambos os gráficos via changeLanguage().
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            // Barras: violações DLP por aplicativo (ChatGPT, Dropbox, Gmail, etc.).
            const dlpViolationsCtx = document.getElementById('dlpViolationsChart').getContext('2d');
            dlpViolationsChart = new Chart(dlpViolationsCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Violações',
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

            // Linha: tendência de 6 meses de phishing, malware e ameaças bloqueadas.
            const threatsTrendCtx = document.getElementById('threatsTrendChart').getContext('2d');
            threatsTrendChart = new Chart(threatsTrendCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        { label: 'Phishing', data: [18, 20, 22, 24, 25, 27], borderColor: '#FF8200', backgroundColor: 'rgba(255, 130, 0, 0.1)', fill: true, tension: 0.4 },
                        { label: 'Malware', data: [10, 12, 13, 14, 14, 15], borderColor: '#00A9CE', backgroundColor: 'rgba(0, 169, 206, 0.1)', fill: true, tension: 0.4 },
                        { label: 'Ameaças Bloqueadas', data: [30, 32, 35, 38, 41, 44], borderColor: '#008095', backgroundColor: 'rgba(0, 128, 149, 0.1)', fill: false, tension: 0.4, borderDash: [5, 5] }
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
