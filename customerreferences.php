<?php
// customerreferences.php - Casos de sucesso / referências de clientes da Netskope
// na LATAM (Brasil, México, restante da LATAM), com filtro por região. Página de
// apoio dentro do fluxo de demo, normalmente vinculada a partir de index.php.
//
// As funções JS comuns (changeLanguage, etc.) ficam em assets/js/common.js
// e os textos de i18n compartilhados entre páginas ficam em assets/js/i18n-common.js.
// O dicionário `translations` deste arquivo contém apenas strings próprias
// desta página (cabeçalhos, filtros de região e descrições de clientes).
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Casos de sucesso da Netskope na América Latina organizados por região.">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Referencias LATAM</title>
    
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
                            green: '#AFF198', orange: '#FF8200', darkGray: '#2A2B2D', gray: '#53565A'
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Lora', 'serif'] },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; color: #2A2B2D; overflow-x: hidden; }
        .bg-pattern { background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 30px 30px; opacity: 0.08; }
        .card-hover { transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -10px rgba(8, 26, 89, 0.15); border-color: #00A9CE; }
        .logo-container { height: 76px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; padding: 0.75rem 1rem; border-radius: 14px; border: 1px solid #e5e7eb; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7); width: 100%; }
        .logo-img { max-height: 48px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 3px 8px rgba(8, 26, 89, 0.12)); }
        .plus-decoration { position: absolute; color: #00A9CE; font-weight: 300; opacity: 0.2; user-select: none; z-index: 0; }
        
        /* Language Switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="min-h-screen flex flex-col relative" data-page-name="customerreferences">

    <div class="plus-decoration text-6xl top-20 left-10">+</div>
    <div class="plus-decoration text-8xl top-40 right-10 text-netskope-green">+</div>
    <div class="plus-decoration text-4xl bottom-20 left-1/4">+</div>

    <!-- Cabeçalho fixo: logo (link para index.php), rótulo da página. -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-sm font-medium text-netskope-gray hidden md:block tracking-wide" data-i18n="header_title">Casos de Sucesso LATAM</div>
            </div>
        </div>
    </header>

    <!-- Hero: título e descrição da seção de casos de sucesso, sobre fundo azul com decorações. -->
    <div class="relative bg-netskope-deepBlue text-white overflow-hidden pb-12 pt-16 md:pt-24 md:pb-20">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] rounded-full bg-netskope-blue opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-netskope-green opacity-10 blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight leading-tight" data-i18n="hero_title">Histórias de Transformação</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto mt-4" data-i18n="hero_desc">Descubra como as organizações líderes na América Latina confiam na Netskope para proteger sua jornada rumo à nuvem.</p>
            <div class="w-24 h-1 bg-netskope-green mx-auto mt-8 rounded-full"></div>
        </div>
    </div>

    <main class="flex-grow bg-[#F9FAFB] relative z-10 px-4 sm:px-6 lg:px-8 py-16 -mt-8 rounded-t-[40px] shadow-[0_-10px_40px_rgba(0,0,0,0.03)]">
        <div class="max-w-7xl mx-auto">
            
            <!-- Botões de filtro por região (all/br/mx/latam); a lógica de filtragem está no script inline abaixo. -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn active px-6 py-2 rounded-full bg-netskope-deepBlue text-white font-semibold text-sm transition-colors shadow-md" data-filter="all" data-i18n="filter_all">Todos</button>
                <button class="filter-btn px-6 py-2 rounded-full bg-white text-netskope-deepBlue border border-gray-200 hover:bg-netskope-lightBlue font-semibold text-sm transition-colors shadow-sm" data-filter="br" data-i18n="filter_br">Brasil</button>
                <button class="filter-btn px-6 py-2 rounded-full bg-white text-netskope-deepBlue border border-gray-200 hover:bg-netskope-lightBlue font-semibold text-sm transition-colors shadow-sm" data-filter="mx" data-i18n="filter_mx">México</button>
                <button class="filter-btn px-6 py-2 rounded-full bg-white text-netskope-deepBlue border border-gray-200 hover:bg-netskope-lightBlue font-semibold text-sm transition-colors shadow-sm" data-filter="latam" data-i18n="filter_latam">Restante da LATAM</button>
            </div>

            <!-- Grade de cartões de clientes (um por empresa); cada um leva data-region
                 para o filtro acima e aponta para o portal público de clientes da Netskope. -->
            <div class="flex flex-wrap justify-center gap-6 md:gap-8" id="reference-grid">

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="br">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/votorantim-logo.png" alt="Votorantim Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">Brasil</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Votorantim</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_votorantim_desc">Transformação digital segura para um dos maiores conglomerados industriais do Brasil.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="mx">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/cinepolis-logo.png" alt="Cinépolis Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">México</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Cinépolis</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_cinepolis_desc">Proteção de dados e experiência do usuário otimizada para a rede de cinemas líder.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="latam">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/sura-logo.png" alt="Grupo SURA Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">Colombia</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Grupo SURA</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_sura_desc">Estratégia SASE unificada para proteger operações financeiras em toda a região andina.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="br">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/renner-logo.png" alt="Lojas Renner Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">Brasil</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Lojas Renner</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_renner_desc">Segurança na nuvem e conformidade regulatória para o gigante do varejo brasileiro.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="mx">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/kavak-logo.png" alt="Kavak Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">México</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Kavak</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_kavak_desc">Proteção de infraestrutura cloud nativa para o unicórnio automotivo de maior crescimento.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

                <a href="https://www.netskope.com/customers" target="_blank" class="ref-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl card-hover border border-gray-100 flex flex-col relative overflow-hidden text-center items-center" data-region="latam">
                    <div class="logo-container group-hover:bg-netskope-lightBlue transition-colors duration-300">
                        <img src="assets/images/external/mercadolibre-logo.png" alt="Mercado Libre Logo" class="logo-img">
                    </div>
                    <span class="text-[10px] font-bold text-netskope-teal uppercase tracking-widest mb-2 bg-netskope-lightBlue px-2 py-1 rounded-full">Argentina</span>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 group-hover:text-netskope-blue transition-colors">Mercado Libre</h3>
                    <p class="text-netskope-gray text-sm leading-relaxed flex-grow" data-i18n="card_meli_desc">Visibilidade e controle granular para o maior ecossistema de e-commerce e fintech da LATAM.</p>
                    <div class="mt-4 text-netskope-teal text-sm font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        <span data-i18n="btn_view">Ver referencia</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </div>
                </a>

            </div>
        </div>
    </main>

    <!-- Rodapé: logo pequeno + texto de direitos reservados (fixo em inglês). -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-auto">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="index.php"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved. | Privacy Policy
            </p>
        </div>
    </footer>

    <!-- Utilitários JS compartilhados (changeLanguage, modais, área de transferência) e dicionário
         de traduções comum. Devem ser carregados antes do script inline abaixo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header_title": "Casos de Sucesso LATAM",
                "hero_title": "Histórias de Transformação",
                "hero_desc": "Descubra como as organizações líderes na América Latina confiam na Netskope para proteger sua jornada rumo à nuvem.",
                "filter_all": "Todos",
                "filter_br": "Brasil",
                "filter_mx": "México",
                "filter_latam": "Restante da LATAM",
                "card_votorantim_desc": "Transformação digital segura para um dos maiores conglomerados industriais do Brasil.",
                "card_cinepolis_desc": "Proteção de dados e experiência do usuário otimizada para a rede de cinemas líder.",
                "card_sura_desc": "Estratégia SASE unificada para proteger operações financeiras em toda a região andina.",
                "card_renner_desc": "Segurança na nuvem e conformidade regulatória para o gigante do varejo brasileiro.",
                "card_kavak_desc": "Proteção de infraestrutura cloud nativa para o unicórnio automotivo de maior crescimento.",
                "card_meli_desc": "Visibilidade e controle granular para o maior ecossistema de e-commerce e fintech da LATAM.",
                "btn_view": "Ir para o portal de clientes"
            }
        };

        // changeLanguage(lang) agora é a função compartilhada de assets/js/common.js,
        // que opera sobre o objeto global `translations` definido acima.

        // Lógica do Filtro de Regiões (específica desta página: filtra os
        // cartões de referências de clientes por região usando data-region).
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                // Estilos dos botões
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('bg-netskope-deepBlue', 'text-white', 'shadow-md');
                    b.classList.add('bg-white', 'text-netskope-deepBlue', 'shadow-sm');
                });
                e.target.classList.remove('bg-white', 'text-netskope-deepBlue', 'shadow-sm');
                e.target.classList.add('bg-netskope-deepBlue', 'text-white', 'shadow-md');

                // Filtrar Cartões
                const filter = e.target.getAttribute('data-filter');
                document.querySelectorAll('.ref-card').forEach(card => {
                    if(filter === 'all' || card.getAttribute('data-region') === filter) {
                        card.classList.remove('hidden');
                        card.classList.add('flex');
                    } else {
                        card.classList.remove('flex');
                        card.classList.add('hidden');
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
            lucide.createIcons();
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
