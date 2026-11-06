<?php
// reportai.php - Relatório/dashboard de exemplo sobre uso de IA generativa e
// Shadow IA (gráficos Chart.js: distribuição de apps de IA, tendências). É
// vinculado normalmente a partir de aicontrol.php como "relatório de IA" de encerramento da demo.
//
// As funções JS comuns (changeLanguage boilerplate, etc.) ficam em
// assets/js/common.js e os textos i18n compartilhados entre páginas ficam em
// assets/js/i18n-common.js. O dicionário `translations` deste arquivo contém
// apenas strings específicas desta página. changeLanguage() continua
// definida localmente porque também precisa atualizar os gráficos Chart.js
// (updateCharts) quando o idioma muda; delega o trabalho repetitivo de
// aplicar o dicionário ao DOM para NetskopeCommon.applyLanguage().
?>
<!DOCTYPE html>
<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard e narrativa comercial para analisar o uso de IA com uma apresentação consistente e reutilizável.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Report IA</title>
    
    <link href="assets/vendor/css/offline-fonts.css" rel="stylesheet">
    <link href="assets/vendor/css/site-global.css" rel="stylesheet">
    <script src="assets/vendor/js/site-global.js"></script>
    <script src="assets/vendor/js/tailwindcss-cdn.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/vendor/js/chart.umd.min.js"></script>
    <script src="assets/vendor/js/lucide.min.js"></script>

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
                    backgroundImage: {
                        'gradient-confident': 'linear-gradient(135deg, #081A59 0%, #00A9CE 100%)',
                        'gradient-neon': 'linear-gradient(135deg, #00A9CE 0%, #AFF198 100%)',
                        'pattern-net': "radial-gradient(#00A9CE 1.5px, transparent 1.5px)",
                    },
                    borderRadius: { 'netskope': '24px', 'netskope-sm': '12px' },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(8, 26, 89, 0.08)',
                        'hover': '0 20px 50px -10px rgba(0, 169, 206, 0.15)',
                        'modal': '0 25px 100px -20px rgba(8, 26, 89, 0.3)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; color: #2A2B2D; background-color: #F5F5F5; overflow-x: hidden; }
        .font-lora { font-family: 'Lora', serif; }
        .plus-pattern { position: absolute; width: 100%; height: 100%; background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2300A9CE' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 40V20h20v-2H20V0h-2v18H0v2h18v20z'/%3E%3C/g%3E%3C/svg%3E"); opacity: 0.3; z-index: 0; }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 50px -10px rgba(0, 169, 206, 0.15); }
        
        .chart-container { position: relative; height: 300px; width: 100%; }
        .image-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(8, 26, 89, 0.9); z-index: 1000; align-items: center; justify-content: center; animation: fadeIn 0.3s ease; }
        .image-modal.active { display: flex; }
        .modal-content { max-width: 90%; max-height: 90%; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 100px -20px rgba(8, 26, 89, 0.3); animation: scaleIn 0.3s ease; }
        .modal-image { width: 100%; height: auto; display: block; }
        .modal-close { position: absolute; top: 20px; right: 20px; background: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 24px; color: #081A59; transition: all 0.2s ease; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .modal-close:hover { background: #00A9CE; color: white; transform: rotate(90deg); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .image-preview { cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden; }
        .image-preview:hover { transform: translateY(-4px); box-shadow: 0 15px 40px -10px rgba(0, 169, 206, 0.25); }
        .image-preview::after { content: '🔍 Clique para ampliar'; position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(8, 26, 89, 0.8)); color: white; padding: 12px; font-size: 12px; text-align: center; opacity: 0; transition: opacity 0.3s ease; }
        .image-preview:hover::after { opacity: 1; }

        /* Unified language switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: #081A59; }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.-right-20{right:-5rem}.bottom-20{bottom:5rem}.right-0{right:0px}.top-0{top:0px}.z-10{z-index:10}.z-50{z-index:50}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-10{margin-bottom:2.5rem}.mb-12{margin-bottom:3rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.mr-2{margin-right:0.5rem}.mt-12{margin-top:3rem}.mt-4{margin-top:1rem}.mt-6{margin-top:1.5rem}.mt-8{margin-top:2rem}.mt-auto{margin-top:auto}.inline-block{display:inline-block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-1{height:0.25rem}.h-16{height:4rem}.h-3{height:0.75rem}.h-6{height:1.5rem}.h-8{height:2rem}.h-full{height:100%}.w-1\/2{width:50%}.w-16{width:4rem}.w-3{width:0.75rem}.w-6{width:1.5rem}.w-8{width:2rem}.w-auto{width:auto}.w-full{width:100%}.w-px{width:1px}.max-w-5xl{max-width:64rem}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-12{gap:3rem}.gap-2{gap:0.5rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.space-y-2 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.5rem * var(--tw-space-y-reverse))}.space-y-3 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.75rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:9999px}.rounded-netskope{border-radius:24px}.rounded-netskope-sm{border-radius:12px}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.border{border-width:1px}.border-b{border-bottom-width:1px}.border-t{border-top-width:1px}.border-gray-100\/50{border-color:rgb(243 244 246 / 0.5)}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-white\/50{border-color:rgb(255 255 255 / 0.5)}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-deepBlue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-netskope-green{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-netskope-offWhite{--tw-bg-opacity:1;background-color:rgb(245 245 245 / var(--tw-bg-opacity, 1))}.bg-netskope-orange{--tw-bg-opacity:1;background-color:rgb(255 130 0 / var(--tw-bg-opacity, 1))}.bg-netskope-teal{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/60{background-color:rgb(255 255 255 / 0.6)}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.p-4{padding:1rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-5{padding-top:1.25rem;padding-bottom:1.25rem}.pb-24{padding-bottom:6rem}.pt-20{padding-top:5rem}.text-center{text-align:center}.text-base{font-size:1rem;line-height:1.5rem}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-4xl{font-size:2.25rem;line-height:2.5rem}.text-5xl{font-size:3rem;line-height:1}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-medium{font-weight:500}.font-normal{font-weight:400}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.tracking-widest{letter-spacing:0.1em}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-20{opacity:0.2}.opacity-80{opacity:0.8}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-blur-xl{--tw-backdrop-blur:blur(24px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}@media (min-width: 768px){.md\:mb-0{margin-bottom:0px}.md\:block{display:block}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:gap-24{gap:6rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-7xl{font-size:4.5rem;line-height:1}}@media (min-width: 1024px){.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="antialiased text-base" data-site-shell="ready" data-page-name="reportai" data-page-kind="tool">

    <!-- Header fixo: logo (link para index.php), etiqueta da página. -->
    <header class="bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-gray-100/50 site-shell-header">
        <div class="container mx-auto px-6 md:px-12 py-5 flex justify-between items-center site-shell-header-inner">
            <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6 site-shell-toolbar">
                <span class="text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80 hidden md:block" data-i18n="header.title">Relatório de IA e Shadow IA</span>
                
            </div>
        </div>
    </header>

    <!-- Hero: título, descrição e stats em destaque (Shadow IA, incidentes, apps de IA detectados). -->
    <section class="relative bg-white pt-20 pb-24 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-teal"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="hero.badge">Análise de Segurança</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight" data-i18n="hero.title">Relatório de Uso de <br><span class="font-lora italic font-normal text-netskope-blue">IA e Shadow IA</span></h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero.desc">68% das organizações utilizam IA não autorizada. <br><strong class="text-netskope-deepBlue font-semibold">A Shadow IA representa um risco crítico de vazamento de dados.</strong></p>

                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-orange mb-1">68%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.1">Usam Shadow IA</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">42%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.2">Incidentes de Dados</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-deepBlue mb-1">150+</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.3">Apps de IA Detectados</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg>
        </div>
    </section>

    <!-- Dashboard de Uso de IA: grade de 3 gráficos Chart.js (distribuição IA/Shadow IA,
         top apps de IA e risco por departamento); sua configuração e inicialização
         estão no script inline abaixo (initCharts). -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-netskope-deepBlue mb-2" data-i18n="dash.title">Dashboard de Uso de IA</h2>
            <p class="text-netskope-gray mb-10" data-i18n="dash.desc">Análise completa do uso de aplicativos de IA autorizados e não autorizados na organização</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <div class="bg-netskope-offWhite p-6 rounded-netskope card-hover">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="chart.1.title">Distribuição de IA vs Shadow IA</h3>
                    <div class="chart-container">
                        <canvas id="iaDistributionChart" style="display: block; box-sizing: border-box; height: 300px; width: 100%;"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-netskope-gray">
                        <p><span class="inline-block w-3 h-3 bg-netskope-blue mr-2"></span> <strong data-i18n="chart.1.leg1">IA Autorizada (32%):</strong> ChatGPT Enterprise, Copilot, Gemini Business</p>
                        <p><span class="inline-block w-3 h-3 bg-netskope-orange mr-2"></span> <strong data-i18n="chart.1.leg2">Shadow IA (68%):</strong> ChatGPT Free, Midjourney, Claude, Stable Diffusion</p>
                    </div>
                </div>
                
                <div class="bg-netskope-offWhite p-6 rounded-netskope card-hover">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="chart.2.title">Top Apps de IA Detectados</h3>
                    <div class="chart-container">
                        <canvas id="topAppsChart" style="display: block; box-sizing: border-box; height: 300px; width: 100%;"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-netskope-gray">
                        <p data-i18n="chart.2.desc">O ChatGPT representa 45% do uso total de IA, seguido pelo Copilot (22%) e pelo Midjourney (18%).</p>
                    </div>
                </div>
                
                <div class="bg-netskope-offWhite p-6 rounded-netskope card-hover">
                    <h3 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="chart.3.title">Risco por Departamento</h3>
                    <div class="chart-container">
                        <canvas id="riskByDeptChart" style="display: block; box-sizing: border-box; height: 300px; width: 100%;"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-netskope-gray">
                        <p data-i18n="chart.3.desc">P&amp;D e Marketing apresentam maior exposição devido ao uso intensivo de ferramentas generativas.</p>
                    </div>
                </div>
            </div>
            
            <!-- Fluxo de Dados Sensíveis: infográfico estático (não é Chart.js) com 3 métricas
                 em destaque e setas decorativas. -->
            <div class="bg-gradient-confident text-white p-8 rounded-netskope mb-12">
                <h3 class="text-2xl font-bold mb-6 text-center" data-i18n="flow.title">Fluxo de Dados Sensíveis para Apps de IA</h3>
                <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                    <div class="text-center mb-6 md:mb-0">
                        <div class="text-4xl font-bold mb-2">2.3TB</div>
                        <div class="text-netskope-lightBlue" data-i18n="flow.1">Dados sensíveis transferidos</div>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                    <div class="text-center mb-6 md:mb-0">
                        <div class="text-4xl font-bold mb-2">87%</div>
                        <div class="text-netskope-lightBlue" data-i18n="flow.2">Para apps não autorizados</div>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">42%</div>
                        <div class="text-netskope-lightBlue" data-i18n="flow.3">Contêm Propriedade Intelectual ou PII</div>
                    </div>
                </div>
                <p class="text-center text-netskope-lightBlue text-sm" data-i18n="flow.period">Análise realizada no período: Janeiro 2025 - Janeiro 2026</p>
            </div>
            
            <!-- Principais Riscos Detectados e Recomendações de Mitigação (duas colunas). -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-soft">
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-netskope-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <span data-i18n="risk.title">Principais Riscos Detectados</span>
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="risk.1"><strong>Vazamento de PI:</strong> Código-fonte enviado ao ChatGPT (47 incidentes)</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="risk.2"><strong>Exposição de PII:</strong> Dados de clientes em prompts do Midjourney (23 incidentes)</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="risk.3"><strong>Violação de conformidade:</strong> Dados financeiros em apps não compatíveis com a GDPR (18 incidentes)</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="risk.4"><strong>Model poisoning:</strong> Entrada de dados maliciosos em LLMs (9 incidentes)</span></li>
                    </ul>
                </div>
                
                <div class="bg-white border border-gray-200 p-6 rounded-netskope shadow-soft">
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-netskope-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span data-i18n="rec.title">Recomendações de Mitigação</span>
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span><span data-i18n="rec.1"><strong>Implementar DLP para IA:</strong> Bloquear uploads de dados sensíveis para apps não autorizados</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span><span data-i18n="rec.2"><strong>Criar política de uso de IA:</strong> Educar colaboradores sobre riscos e alternativas seguras</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span><span data-i18n="rec.3"><strong>Adotar soluções corporativas:</strong> Migrar para ChatGPT Enterprise, Copilot com proteções</span></li>
                        <li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span><span data-i18n="rec.4"><strong>Monitoramento contínuo:</strong> Usar a Netskope para detectar novos apps de IA em tempo real</span></li>
                    </ul>
                </div>
            </div>

            <!-- Visibilidade Avançada: captura de tela real (mainImage) ampliável no modal
                 #imageModal (lógica de abertura/fechamento no final do script inline), além de
                 achados e implicações de segurança em texto. -->
            <section class="py-16 bg-netskope-offWhite">
                <div class="container mx-auto px-6 md:px-12">
                    <h2 class="text-3xl font-bold text-netskope-deepBlue mb-2" data-i18n="adv.title">Visibilidade Avançada do Uso de IA</h2>
                    <p class="text-netskope-gray mb-10">
                        <span data-i18n="adv.desc">Análise detalhada das instâncias detectadas de aplicativos de IA na organização.</span>
                        <span class="text-netskope-blue font-medium" data-i18n="adv.click">Clique na imagem para ampliá-la.</span>
                    </p>

                    <div class="bg-white p-8 rounded-netskope shadow-soft card-hover">
                        <div class="image-container">
                            <!-- onerror: se o screenshot local não carregar, usa um placeholder
                                 genérico de placehold.co em vez de mostrar uma imagem quebrada. -->
                            <img src="assets/images/screenshot-2026-02-04-16-45-38.png" alt="Top Instâncias Detectadas - Google Gemini" class="w-full rounded-netskope-sm border border-gray-200 image-preview" id="mainImage" onerror="this.onerror=null; this.src='https://placehold.co/800x400/eef5fc/081A59?text=Screenshot+Pendiente';">
                        </div>

                        <div class="mt-8">
                            <h4 class="text-lg font-bold text-netskope-deepBlue mb-4" data-i18n="det.title">Análise Detalhada</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h5 class="font-bold text-netskope-gray mb-2" data-i18n="det.find">Principais Achados:</h5>
                                    <ul class="space-y-2 text-sm text-netskope-gray">
                                        <li class="flex items-start gap-2"><span class="text-netskope-blue font-bold">•</span><span data-i18n="det.f1">Foram detectadas <strong>610 atividades</strong> de risco em Gen IA</span></li>
                                        <li class="flex items-start gap-2"><span class="text-netskope-blue font-bold">•</span><span data-i18n="det.f2">Foram detectados mais de 400 usuários utilizando Gen IA NÃO Corporativa</span></li>
                                        <li class="flex items-start gap-2"><span class="text-netskope-blue font-bold">•</span><span data-i18n="det.f3">68% dos aplicativos pertencem à Shadow IA</span></li>
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="font-bold text-netskope-gray mb-2" data-i18n="det.imp">Implicações de Segurança:</h5>
                                    <ul class="space-y-2 text-sm text-netskope-gray">
                                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="det.i1">Possível uso não autorizado de IA generativa</span></li>
                                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="det.i2">Risco de vazamento de dados para serviços em nuvem</span></li>
                                        <li class="flex items-start gap-2"><span class="text-netskope-orange font-bold">•</span><span data-i18n="det.i3">Falta de visibilidade sobre o tipo de dados compartilhados</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Tendência de Uso de IA: gráfico de linhas Chart.js (12 meses) com uso total de
                 IA, Shadow IA e incidentes de segurança, além de 3 métricas-resumo abaixo. -->
            <div class="bg-netskope-offWhite p-8 rounded-netskope mt-12">
                <h3 class="text-2xl font-bold text-netskope-deepBlue mb-6" data-i18n="trend.title">Tendência de Uso de IA (Últimos 12 Meses)</h3>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="trendChart" style="display: block; box-sizing: border-box; height: 400px; width: 100%;"></canvas>
                </div>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="text-center p-4 bg-white rounded-netskope-sm">
                        <div class="text-2xl font-bold text-netskope-blue">+247%</div>
                        <div class="text-netskope-gray" data-i18n="trend.1">Crescimento no uso de IA</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-netskope-sm">
                        <div class="text-2xl font-bold text-netskope-orange">+189%</div>
                        <div class="text-netskope-gray" data-i18n="trend.2">Crescimento em Shadow IA</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-netskope-sm">
                        <div class="text-2xl font-bold text-netskope-teal">-32%</div>
                        <div class="text-netskope-gray" data-i18n="trend.3">Redução após políticas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de imagem: oculto por padrão (display:none via .image-modal), ativado com
         a classe .active ao clicar em mainImage; fecha com o botão ×, clique fora
         do conteúdo ou a tecla Escape. Lógica de abertura/fechamento no script inline. -->
    <div class="image-modal" id="imageModal">
        <button class="modal-close" id="modalClose">×</button>
        <div class="modal-content">
            <img src="" alt="" class="modal-image" id="modalImage">
        </div>
    </div>

    <!-- Como a Netskope Protege contra os Riscos da Shadow IA (3 cards de capacidades). -->
    <section class="py-16 bg-gradient-confident text-white">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-3xl font-bold text-center mb-12" data-i18n="help.title">Como a Netskope Protege contra os Riscos da Shadow IA</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-netskope text-center">
                    <div class="w-16 h-16 rounded-full bg-netskope-blue flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="help.1.title">Detecção em Tempo Real</h3>
                    <p class="text-netskope-lightBlue" data-i18n="help.1.desc">Identifica automaticamente mais de 150 aplicativos de IA, incluindo novos que não estão nas listas tradicionais.</p>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-netskope text-center">
                    <div class="w-16 h-16 rounded-full bg-netskope-green flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="help.2.title">Proteção de Dados</h3>
                    <p class="text-netskope-lightBlue" data-i18n="help.2.desc">DLP avançado para prevenir o vazamento de Propriedade Intelectual, PII e dados regulados para aplicativos de IA não autorizados.</p>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-netskope text-center">
                    <div class="w-16 h-16 rounded-full bg-netskope-teal flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2 6 6 0 006 6zm0 0V9m0 0a2 2 0 100-4 2 2 0 000 4zm0 0h4m-4 0H5m4 0h4m4 0a2 2 0 100-4 2 2 0 000 4zm0 0v6m0-6h4m-4 0h4"></path></svg></div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="help.3.title">Controle Granular</h3>
                    <p class="text-netskope-lightBlue" data-i18n="help.3.desc">Políticas contextuais que permitem usos produtivos enquanto bloqueiam atividades de risco.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer: logo pequeno + texto de direitos reservados (hardcoded em inglês). -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-auto site-shell-footer">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6 site-shell-footer-inner">
            <div class="flex items-center gap-4 site-shell-footer-meta">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            </div>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved.
                | <span class="text-netskope-blue cursor-pointer hover:underline">Privacy Policy</span>
            </p>
        </div>
    </footer>

    <!-- Utilitários JS compartilhados (NetskopeCommon.applyLanguage, etc.) e dicionário
         de traduções comum. Devem ser carregados antes do script inline abaixo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Referências às 4 instâncias Chart.js ativas (preenchidas em initCharts) para
        // poder atualizar seus rótulos/labels a partir de updateCharts ao trocar de idioma.
        let chartInstances = {};

        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header.title": "Relatório de IA e Shadow IA",
                "hero.badge": "Análise de Segurança",
                "hero.title": "Relatório de Uso de <br><span class=\"font-lora italic font-normal text-netskope-blue\">IA e Shadow IA</span>",
                "hero.desc": "68% das organizações utilizam IA não autorizada. <br><strong class=\"text-netskope-deepBlue font-semibold\">A Shadow IA representa um risco crítico de vazamento de dados.</strong>",
                "stat.1": "Usam Shadow IA",
                "stat.2": "Incidentes de Dados",
                "stat.3": "Apps de IA Detectados",
                "dash.title": "Dashboard de Uso de IA",
                "dash.desc": "Análise completa do uso de aplicativos de IA autorizados e não autorizados na organização",
                "chart.1.title": "Distribuição de IA vs Shadow IA",
                "chart.1.leg1": "IA Autorizada (32%):",
                "chart.1.leg2": "Shadow IA (68%):",
                "chart.2.title": "Top Apps de IA Detectados",
                "chart.2.desc": "O ChatGPT representa 45% do uso total de IA, seguido pelo Copilot (22%) e pelo Midjourney (18%).",
                "chart.3.title": "Risco por Departamento",
                "chart.3.desc": "P&amp;D e Marketing apresentam maior exposição devido ao uso intensivo de ferramentas generativas.",
                "flow.title": "Fluxo de Dados Sensíveis para Apps de IA",
                "flow.1": "Dados sensíveis transferidos",
                "flow.2": "Para apps não autorizados",
                "flow.3": "Contêm Propriedade Intelectual ou PII",
                "flow.period": "Análise realizada no período: Janeiro 2025 - Janeiro 2026",
                "risk.title": "Principais Riscos Detectados",
                "risk.1": "<strong>Vazamento de PI:</strong> Código-fonte enviado ao ChatGPT (47 incidentes)",
                "risk.2": "<strong>Exposição de PII:</strong> Dados de clientes em prompts do Midjourney (23 incidentes)",
                "risk.3": "<strong>Violação de conformidade:</strong> Dados financeiros em apps não compatíveis com a GDPR (18 incidentes)",
                "risk.4": "<strong>Model poisoning:</strong> Entrada de dados maliciosos em LLMs (9 incidentes)",
                "rec.title": "Recomendações de Mitigação",
                "rec.1": "<strong>Implementar DLP para IA:</strong> Bloquear uploads de dados sensíveis para apps não autorizados",
                "rec.2": "<strong>Criar política de uso de IA:</strong> Educar colaboradores sobre riscos e alternativas seguras",
                "rec.3": "<strong>Adotar soluções corporativas:</strong> Migrar para ChatGPT Enterprise, Copilot com proteções",
                "rec.4": "<strong>Monitoramento contínuo:</strong> Usar a Netskope para detectar novos apps de IA em tempo real",
                "adv.title": "Visibilidade Avançada do Uso de IA",
                "adv.desc": "Análise detalhada das instâncias detectadas de aplicativos de IA na organização.",
                "adv.click": "Clique na imagem para ampliá-la.",
                "det.title": "Análise Detalhada",
                "det.find": "Principais Achados:",
                "det.f1": "Foram detectadas <strong>610 atividades</strong> de risco em Gen IA",
                "det.f2": "Foram detectados mais de 400 usuários utilizando Gen IA NÃO Corporativa",
                "det.f3": "68% dos aplicativos pertencem à Shadow IA",
                "det.imp": "Implicações de Segurança:",
                "det.i1": "Possível uso não autorizado de IA generativa",
                "det.i2": "Risco de vazamento de dados para serviços em nuvem",
                "det.i3": "Falta de visibilidade sobre o tipo de dados compartilhados",
                "trend.title": "Tendência de Uso de IA (Últimos 12 Meses)",
                "trend.1": "Crescimento no uso de IA",
                "trend.2": "Crescimento em Shadow IA",
                "trend.3": "Redução após políticas",
                "help.title": "Como a Netskope Protege contra os Riscos da Shadow IA",
                "help.1.title": "Detecção em Tempo Real",
                "help.1.desc": "Identifica automaticamente mais de 150 aplicativos de IA, incluindo novos que não estão nas listas tradicionais.",
                "help.2.title": "Proteção de Dados",
                "help.2.desc": "DLP avançado para prevenir o vazamento de Propriedade Intelectual, PII e dados regulados para aplicativos de IA não autorizados.",
                "help.3.title": "Controle Granular",
                "help.3.desc": "Políticas contextuais que permitem usos produtivos enquanto bloqueiam atividades de risco.",

                // Rótulos dos 4 gráficos Chart.js, usados por updateCharts() ao trocar de idioma.
                "chartLabels": {
                    "iaDist": ["IA Autorizada", "Shadow IA"],
                    "topApps": ["ChatGPT", "Copilot", "Midjourney", "Claude", "Stable Diffusion", "Outros"],
                    "topAppsLabel": "% de Uso",
                    "riskDept": ["P&D", "Marketing", "Finanças", "Operações", "Legal", "RH"],
                    "riskLabel": "Nível de Risco",
                    "trendLabels": ["Jan 25", "Mar 25", "Mai 25", "Jul 25", "Set 25", "Nov 25", "Jan 26"],
                    "trendTotal": "Uso Total de IA",
                    "trendShadow": "Shadow IA",
                    "trendIncidents": "Incidentes de Segurança",
                    "trendYAxis": "Usuários Ativos (milhares)"
                }
            }
        };

        /**
         * updateCharts(lang)
         * ---------------------------------------------------------------------------
         * Atualiza os rótulos (labels de eixos/legendas) dos 4 gráficos Chart.js
         * desta página com o dicionário chartLabels do idioma indicado, sem alterar
         * os dados numéricos nem as cores. Chamada a partir de changeLanguage(). Não faz
         * nada se as instâncias do Chart.js ainda não existirem (p. ex. se initCharts
         * falhou) ou se o dicionário do idioma não trouxer chartLabels.
         *
         * @param {string} lang - partner edition: somente 'es'
         */
        function updateCharts(lang) {
            if (!translations[lang] || !translations[lang].chartLabels) return;
            const labels = translations[lang].chartLabels;

            if (chartInstances.iaDistributionChart) {
                chartInstances.iaDistributionChart.data.labels = labels.iaDist;
                chartInstances.iaDistributionChart.update();
            }

            if (chartInstances.topAppsChart) {
                chartInstances.topAppsChart.data.datasets[0].label = labels.topAppsLabel;
                chartInstances.topAppsChart.data.labels = labels.topApps;
                chartInstances.topAppsChart.update();
            }

            if (chartInstances.riskByDeptChart) {
                chartInstances.riskByDeptChart.data.datasets[0].label = labels.riskLabel;
                chartInstances.riskByDeptChart.data.labels = labels.riskDept;
                chartInstances.riskByDeptChart.update();
            }

            if (chartInstances.trendChart) {
                chartInstances.trendChart.data.labels = labels.trendLabels;
                chartInstances.trendChart.data.datasets[0].label = labels.trendTotal;
                chartInstances.trendChart.data.datasets[1].label = labels.trendShadow;
                chartInstances.trendChart.data.datasets[2].label = labels.trendIncidents;
                chartInstances.trendChart.options.scales.y.title.text = labels.trendYAxis;
                chartInstances.trendChart.update();
            }
        }

        /**
         * changeLanguage(lang)
         * É mantida local (não é totalmente delegada a assets/js/common.js) porque,
         * além de traduzir o DOM, esta página precisa atualizar os rótulos dos
         * gráficos Chart.js (updateCharts). O trabalho repetitivo de aplicar o
         * dicionário ao DOM é delegado a NetskopeCommon.applyLanguage (common.js).
         */
        function changeLanguage(lang) {
            lang = NetskopeCommon.applyLanguage(lang, translations);
            try { updateCharts(lang); } catch(e) {}
        }

        /**
         * initCharts()
         * ---------------------------------------------------------------------------
         * Cria os 4 gráficos Chart.js do dashboard (um por <canvas>) e guarda cada
         * instância em chartInstances para que updateCharts() possa atualizar seus
         * labels ao trocar de idioma. Cada gráfico é criado em seu próprio try/catch
         * para que um canvas ausente ou um erro do Chart.js não derrube os demais.
         * Dados de demo (fixos), não vêm de nenhum backend.
         */
        function initCharts() {
            if (typeof Chart === 'undefined') {
                console.error("Não foi possível carregar o Chart.js.");
                return;
            }

            // Doughnut: % de uso de IA autorizada (32%) vs Shadow IA não autorizada (68%).
            try {
                const iaDistributionCtx = document.getElementById('iaDistributionChart').getContext('2d');
                chartInstances.iaDistributionChart = new Chart(iaDistributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['IA Autorizada', 'Shadow IA'],
                        datasets: [{
                            data: [32, 68],
                            backgroundColor: ['#00A9CE', '#FF8200'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } }
                    }
                });
            } catch(e) {}

            // Barras: top apps de IA detectados por % de uso (ChatGPT, Copilot, etc.).
            try {
                const topAppsCtx = document.getElementById('topAppsChart').getContext('2d');
                chartInstances.topAppsChart = new Chart(topAppsCtx, {
                    type: 'bar',
                    data: {
                        labels: ['ChatGPT', 'Copilot', 'Midjourney', 'Claude', 'Stable Diffusion', 'Outros'],
                        datasets: [{
                            label: '% de Uso',
                            data: [45, 22, 18, 8, 4, 3],
                            backgroundColor: ['#00A9CE', '#008095', '#FF8200', '#AFF198', '#081A59', '#C8C9C7'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, max: 50, ticks: { callback: function(value) { return value + '%'; } } } }
                    }
                });
            } catch(e) {}

            // Radar: nível de risco (0-100) por departamento (P&D, Marketing, Finanças, etc.).
            try {
                const riskDeptCtx = document.getElementById('riskByDeptChart').getContext('2d');
                chartInstances.riskByDeptChart = new Chart(riskDeptCtx, {
                    type: 'radar',
                    data: {
                        labels: ['P&D', 'Marketing', 'Finanças', 'Operações', 'Legal', 'RH'],
                        datasets: [{
                            label: 'Nível de Risco',
                            data: [85, 78, 45, 32, 60, 28],
                            backgroundColor: 'rgba(255, 130, 0, 0.2)',
                            borderColor: '#FF8200',
                            pointBackgroundColor: '#FF8200',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#FF8200'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { r: { beginAtZero: true, max: 100, ticks: { stepSize: 20 } } }
                    }
                });
            } catch(e) {}

            // Linha: tendência de 12 meses de uso total de IA, Shadow IA e incidentes de segurança.
            try {
                const trendCtx = document.getElementById('trendChart').getContext('2d');
                chartInstances.trendChart = new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan 25', 'Mar 25', 'Mai 25', 'Jul 25', 'Set 25', 'Nov 25', 'Jan 26'],
                        datasets: [
                            { label: 'Uso Total de IA', data: [120, 185, 220, 280, 320, 380, 415], borderColor: '#00A9CE', backgroundColor: 'rgba(0, 169, 206, 0.1)', fill: true, tension: 0.4 },
                            { label: 'Shadow IA', data: [85, 130, 155, 205, 245, 300, 320], borderColor: '#FF8200', backgroundColor: 'rgba(255, 130, 0, 0.1)', fill: true, tension: 0.4 },
                            { label: 'Incidentes de Segurança', data: [5, 8, 12, 15, 18, 22, 14], borderColor: '#081A59', backgroundColor: 'rgba(8, 26, 89, 0.1)', fill: false, tension: 0.4, borderDash: [5, 5] }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: { y: { beginAtZero: true, title: { display: true, text: 'Usuários Ativos (milhares)' } } }
                    }
                });
            } catch(e) {}
        }

        /**
         * initializePage() (IIFE)
         * ---------------------------------------------------------------------------
         * Ponto de entrada desta página: inicializa gráficos, idioma, ícones e a
         * lógica do modal de imagem ampliável. Cada etapa roda em seu próprio try/catch
         * (execução segura e sequencial) para que uma falha pontual (p. ex. o Chart.js não
         * carregar) não impeça o restante da página de continuar funcionando.
         */
        (function initializePage() {
            try { initCharts(); } catch(e) { console.error('Erro ao carregar gráficos', e); }
            try { changeLanguage(localStorage.getItem('netskope-lang') || 'es'); } catch(e) { console.error('Erro de idioma', e); }
            try { if (typeof lucide !== 'undefined') lucide.createIcons(); } catch(e) {}

            // Lógica do modal de imagem: abre #imageModal com a captura ampliada ao
            // clicar em mainImage, e o fecha com o botão ×, clique fora do
            // conteúdo ou a tecla Escape.
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalClose = document.getElementById('modalClose');
            const mainImage = document.getElementById('mainImage');
            
            if(mainImage) {
                mainImage.addEventListener('click', function() {
                    const src = this.getAttribute('src');
                    const alt = this.getAttribute('alt');
                    if(modalImage) {
                        modalImage.setAttribute('src', src);
                        modalImage.setAttribute('alt', alt);
                    }
                    if(imageModal) {
                        imageModal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            }
            
            if(modalClose) {
                modalClose.addEventListener('click', function() {
                    if(imageModal) imageModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }
            
            if(imageModal) {
                imageModal.addEventListener('click', function(e) {
                    if (e.target === imageModal) {
                        imageModal.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && imageModal && imageModal.classList.contains('active')) {
                    imageModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        })();
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
