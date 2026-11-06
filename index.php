<?php
// index.php - Página inicial (landing) do Democenter Netskope.
// É o ponto de entrada do fluxo de demo: apresenta o card principal
// "Quem é a Netskope?" (keydifferentiators.php) e os 6 cards dos
// pilares da proposta de valor (navegação, dados, VPN/ZTNA, IA generativa,
// IA agêntica e transformação de rede), além do CTA final para demos.php.
//
// Este arquivo é HTML estático servido via PHP (sem lógica de servidor real).
// As funções JS comuns (changeLanguage, copyPlainText, openModal, closeModal...)
// ficam em assets/js/common.js e o dicionário de traduções compartilhado
// (textos de navegação/botões repetidos em várias páginas) fica em
// assets/js/i18n-common.js. Ambos são carregados antes do script inline desta
// página e são mesclados com o dicionário próprio desta página.
?>
<!DOCTYPE html>
<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore as demos da Netskope sobre segurança, rede, dados e IA em uma página inicial unificada e coerente.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Início</title>
    <script src="assets/vendor/js/tailwindcss-cdn.js"></script>
    <script src="assets/vendor/js/lucide.min.js"></script>
    <link href="assets/vendor/css/offline-fonts.css" rel="stylesheet">
    <link href="assets/vendor/css/site-global.css" rel="stylesheet">
    <script src="assets/vendor/js/site-global.js"></script>
    <style>
        :root {
            --deep-blue: #081A59;
            --netskope-blue: #00A9CE;
            --light-blue: #D9FAFF;
            --teal: #008095;
            --lightning-green: #AFF198;
            --white: #FFFFFF;
            --netskope-orange: #FF8200;
            --dark-gray: #2A2B2D;
            --netskope-gray: #53565A;
            --medium-gray: #979998;
            --light-gray: #C8C9C7;
            --off-white: #F5F5F5;

            --app-bg: #eef5fc;
            --surface: rgba(255, 255, 255, 0.92);
            --surface-strong: #ffffff;
            --text-primary: #081A59;
            --text-secondary: #415777;
            --border-soft: rgba(8, 26, 89, 0.12);
            --header-bg: rgba(255, 255, 255, 0.86);
            --footer-bg: rgba(255, 255, 255, 0.95);
            --hero-gradient-start: #071b58;
            --hero-gradient-end: #00a9ce;
            --grid-line: rgba(0, 169, 206, 0.08);
            --glow-shadow: 0 18px 48px rgba(8, 26, 89, 0.14);
            --lang-surface: rgba(255, 255, 255, 0.86);
            --lang-text: #081A59;
            --lang-active-bg: #081A59;
            --lang-active-text: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at 8% -10%, rgba(0, 169, 206, 0.28), transparent 40%),
                radial-gradient(circle at 92% -20%, rgba(175, 241, 152, 0.2), transparent 38%),
                var(--app-bg);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(to right, var(--grid-line) 1px, transparent 1px),
                linear-gradient(to bottom, var(--grid-line) 1px, transparent 1px);
            background-size: 56px 56px;
            opacity: 0.55;
            z-index: -1;
        }

        .font-graphik { font-family: 'Inter', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }

        .bg-gradient-cloud { background: linear-gradient(135deg, var(--netskope-blue), var(--light-blue)); }
        .bg-gradient-confident { background: linear-gradient(130deg, var(--hero-gradient-start), var(--hero-gradient-end)); }
        .bg-gradient-confident-green { background: linear-gradient(135deg, var(--teal), var(--lightning-green)); }
        .bg-gradient-neon { background: linear-gradient(135deg, var(--netskope-blue), var(--lightning-green)); }

        .invisible-net {
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at top right, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(circle at top right, black 40%, transparent 100%);
        }

        .plus-decoration { position: absolute; width: 40px; height: 40px; pointer-events: none; z-index: 0; }
        .plus-decoration::before, .plus-decoration::after { content: ''; position: absolute; background-color: var(--netskope-blue); border-radius: 99px; }
        .plus-decoration::before { width: 100%; height: 8px; top: 50%; transform: translateY(-50%); }
        .plus-decoration::after { height: 100%; width: 8px; left: 50%; transform: translateX(-50%); }
        .plus-white::before, .plus-white::after { background-color: var(--white); opacity: 0.3; }
        .plus-orange::before, .plus-orange::after { background-color: var(--netskope-orange); }
        .plus-green::before, .plus-green::after { background-color: var(--lightning-green); }

        .netskope-card {
            background: var(--surface);
            border-radius: 24px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 8px 32px rgba(8, 26, 89, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .netskope-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--glow-shadow);
            border-color: rgba(0, 169, 206, 0.45);
        }

        .pill-badge {
            background: linear-gradient(90deg, var(--netskope-blue), var(--light-blue));
            color: var(--deep-blue);
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .icon-box { display: flex; align-items: center; justify-content: center; border-radius: 16px; transition: all 0.3s ease; }
        .icon-primary { background: rgba(0, 169, 206, 0.1); color: var(--netskope-blue); }
        .group:hover .icon-primary { background: var(--netskope-blue); color: var(--white); }
        .icon-teal { background: rgba(0, 128, 149, 0.1); color: var(--teal); }
        .group:hover .icon-teal { background: var(--teal); color: var(--white); }
        .icon-green { background: rgba(175, 241, 152, 0.25); color: #4A7A25; }
        .group:hover .icon-green { background: var(--lightning-green); color: var(--deep-blue); }

        .text-deep-blue { color: var(--text-primary); }
        .text-netskope-blue { color: var(--netskope-blue); }
        .text-teal { color: var(--teal); }
        .text-gray-custom { color: var(--text-secondary); }

        .btn-netskope {
            background-color: var(--deep-blue);
            color: white;
            padding: 10px 24px;
            border-radius: 99px;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid rgba(0, 169, 206, 0.25);
            box-shadow: 0 8px 18px rgba(8, 26, 89, 0.24);
        }

        .btn-netskope:hover {
            background-color: #102a74;
            box-shadow: 0 10px 22px rgba(0, 169, 206, 0.26);
        }

        .site-header { background: var(--header-bg); border-bottom-color: var(--border-soft); box-shadow: 0 10px 26px rgba(2, 10, 30, 0.12); }
        .site-footer { background: var(--footer-bg); border-top-color: var(--border-soft); }

        .hero-soc::after {
            content: '';
            position: absolute;
            inset: auto -20% -45% auto;
            width: 60%;
            height: 80%;
            background: radial-gradient(circle at center, rgba(175, 241, 152, 0.3), transparent 65%);
            filter: blur(36px);
            pointer-events: none;
        }

        .language-switcher {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px;
            border-radius: 999px;
            background: var(--lang-surface);
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 8px 20px rgba(8, 26, 89, 0.14);
        }

        .lang-btn {
            min-width: 36px;
            height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--lang-text);
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: var(--lang-text); }
        .lang-btn.active { background: var(--lang-active-bg); border-color: var(--lang-active-bg); color: var(--lang-active-text); box-shadow: 0 4px 12px rgba(8, 26, 89, 0.3); }

        /* !important aqui porque estas classes convivem com .netskope-card (que já define
           border-color por padrão) e precisam sobrescrever essa cor base para dar ao
           card principal e ao card de CTA de demo um tom de borda distintivo. */
        .main-feature-card { border-color: rgba(0, 169, 206, 0.22) !important; }
        .main-feature-logo { background: var(--surface-strong) !important; border-color: var(--border-soft) !important; }
        .site-logo, .feature-logo-img { transition: filter 0.2s ease, opacity 0.2s ease; }
        .demo-cta-card { border-color: rgba(0, 128, 149, 0.2) !important; }

    </style>
    <!-- Bloco seguinte: CSS de utilitários do Tailwind pré-compilado/inline (não
         escrito à mão) para que a página funcione sem depender do build ao vivo
         do Tailwind. Não requer comentários linha a linha: são apenas classes
         utilitárias padrão do Tailwind v3.4.17. -->
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.pointer-events-none{pointer-events:none}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.inset-0{inset:0px}.bottom-10{bottom:2.5rem}.left-10{left:2.5rem}.right-0{right:0px}.right-20{right:5rem}.right-4{right:1rem}.top-0{top:0px}.top-20{top:5rem}.top-4{top:1rem}.z-10{z-index:10}.z-20{z-index:20}.z-50{z-index:50}.mx-auto{margin-left:auto;margin-right:auto}.-mr-20{margin-right:-5rem}.-mt-20{margin-top:-5rem}.mb-10{margin-bottom:2.5rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mt-10{margin-top:2.5rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.grid{display:grid}.hidden{display:none}.h-1\.5{height:0.375rem}.h-12{height:3rem}.h-14{height:3.5rem}.h-16{height:4rem}.h-20{height:5rem}.h-3{height:0.75rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-64{height:16rem}.h-7{height:1.75rem}.h-8{height:2rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-14{width:3.5rem}.w-16{width:4rem}.w-24{width:6rem}.w-3{width:0.75rem}.w-5{width:1.25rem}.w-64{width:16rem}.w-7{width:1.75rem}.w-8{width:2rem}.w-auto{width:auto}.max-w-3xl{max-width:48rem}.max-w-5xl{max-width:64rem}.max-w-7xl{max-width:80rem}.max-w-xl{max-width:36rem}.flex-1{flex:1 1 0%}.flex-shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}.scale-150{--tw-scale-x:1.5;--tw-scale-y:1.5;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.scale-50{--tw-scale-x:.5;--tw-scale-y:.5;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-10{gap:2.5rem}.gap-2{gap:0.5rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.overflow-hidden{overflow:hidden}.rounded-2xl{border-radius:1rem}.rounded-full{border-radius:9999px}.border{border-width:1px}.border-b{border-bottom-width:1px}.border-t{border-top-width:1px}.border-blue-100{--tw-border-opacity:1;border-color:rgb(219 234 254 / var(--tw-border-opacity, 1))}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-teal-100{--tw-border-opacity:1;border-color:rgb(204 251 241 / var(--tw-border-opacity, 1))}.bg-\[\#AFF198\]{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-gradient-to-br{background-image:linear-gradient(to bottom right, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.from-blue-50{--tw-gradient-from:#eff6ff var(--tw-gradient-from-position);--tw-gradient-to:rgb(239 246 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-teal-50{--tw-gradient-from:#f0fdfa var(--tw-gradient-from-position);--tw-gradient-to:rgb(240 253 250 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-transparent{--tw-gradient-from:transparent var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 0 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0)  var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), transparent var(--tw-gradient-via-position), var(--tw-gradient-to)}.to-\[\#D9FAFF\]{--tw-gradient-to:#D9FAFF var(--tw-gradient-to-position)}.to-white{--tw-gradient-to:#fff var(--tw-gradient-to-position)}.fill-current{fill:currentColor}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-12{padding-top:3rem;padding-bottom:3rem}.pb-24{padding-bottom:6rem}.pb-32{padding-bottom:8rem}.pt-24{padding-top:6rem}.text-center{text-align:center}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-4xl{font-size:2.25rem;line-height:2.5rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-medium{font-weight:500}.font-normal{font-weight:400}.font-semibold{font-weight:600}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.text-\[\#D9FAFF\]{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-blue-100{--tw-text-opacity:1;color:rgb(219 234 254 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.opacity-0{opacity:0}.opacity-20{opacity:0.2}.opacity-30{opacity:0.3}.opacity-80{opacity:0.8}.shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.blur-3xl{--tw-blur:blur(64px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-colors{transition-property:color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-opacity{transition-property:opacity;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-transform{transition-property:transform;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.duration-300{transition-duration:300ms}.hover\:border-teal-200:hover{--tw-border-opacity:1;border-color:rgb(153 246 228 / var(--tw-border-opacity, 1))}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:shadow-xl:hover{--tw-shadow:0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.group:hover .group-hover\:scale-110{--tw-scale-x:1.1;--tw-scale-y:1.1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.group:hover .group-hover\:gap-3{gap:0.75rem}.group:hover .group-hover\:text-\[\#4A7A25\]{--tw-text-opacity:1;color:rgb(74 122 37 / var(--tw-text-opacity, 1))}.group:hover .group-hover\:opacity-100{opacity:1}@media (min-width: 640px){.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}}@media (min-width: 768px){.md\:inline{display:inline}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:items-baseline{align-items:baseline}.md\:justify-start{justify-content:flex-start}.md\:p-10{padding:2.5rem}.md\:p-12{padding:3rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:text-left{text-align:left}.md\:text-right{text-align:right}.md\:text-6xl{font-size:3.75rem;line-height:1}.md\:text-xl{font-size:1.25rem;line-height:1.75rem}}@media (min-width: 1024px){.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen" data-site-shell="ready" data-page-name="landing" data-page-kind="story">
    
    
    <!-- Header fijo: logo (link a index.php), tagline. -->
    <header class="site-header backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <div class="flex items-center gap-2">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="site-logo h-8 w-auto"></a>
            </div>
            <nav class="flex items-center gap-8 site-shell-toolbar">
                <span class="text-sm font-medium text-netskope-gray tracking-wide hidden md:inline" data-i18n="header_tagline">Segurança e redes reinventadas</span>
                
            </nav>
        </div>
    </header>

    <!-- Hero principal da landing: título, subtítulo e decorações sobre fundo degradê. -->
    <section class="hero-soc relative bg-gradient-confident text-white overflow-hidden pt-24 pb-32">
        <div class="absolute inset-0 invisible-net opacity-30"></div>
        <div class="plus-decoration plus-white opacity-20 top-20 left-10 scale-150"></div>
        <div class="plus-decoration plus-green opacity-80 bottom-10 right-20"></div>

        <div class="relative max-w-5xl mx-auto px-6 text-center z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                <span class="hero-pretitle font-lora italic font-normal block mb-2 text-[#D9FAFF]" data-i18n="hero_pretitle">A Transformação da</span>
                <span class="font-graphik" data-i18n="hero_title">Segurança, Rede e IA</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-3xl mx-auto font-light leading-relaxed mb-10" data-i18n="hero_subtitle">Uma plataforma SASE pensada para que você esteja seguro, esteja onde estiver.</p>
            <div class="w-24 h-1.5 bg-[#AFF198] mx-auto rounded-full"></div>
        </div>
    </section>

    <main class="relative z-20 -mt-20 px-4 sm:px-6" id="main-content">
        <div class="max-w-7xl mx-auto pb-24">
            
            <!-- Card principal "Quem é a Netskope?": aponta para keydifferentiators.php,
                 o ponto de entrada para o catálogo completo de diferenciais do produto. -->
            <a href="keydifferentiators.php" class="main-feature-card group netskope-card p-8 md:p-12 flex flex-col md:flex-row items-center gap-10 mb-10 relative overflow-hidden bg-gradient-to-br from-blue-50 to-white border-blue-100">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-cloud opacity-20 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                <div class="main-feature-logo bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex-shrink-0">
                    <img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="feature-logo-img h-12 w-auto">
                </div>
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row items-center md:items-baseline gap-4 mb-4">
                        <h2 class="text-3xl font-bold text-deep-blue font-graphik" data-i18n="mainCard_title">Quem é a Netskope?</h2>
                        <span class="pill-badge shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-3 h-3"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg>
                            <span data-i18n="mainCard_badge">LÍDER EM TODOS OS QUADRANTES</span>
                        </span>
                    </div>
                    <p class="text-gray-custom text-lg leading-relaxed mb-6" data-i18n="mainCard_desc">Por que sacrificar a experiência do usuário pela segurança? Com nossa rede <span class="font-semibold text-deep-blue">NewEdge</span> você tem as duas coisas. Obtenha velocidade na navegação, proteção da informação e a tranquilidade necessária para adotar a IA.</p>
                    <div class="flex items-center justify-center md:justify-start gap-2 text-netskope-blue font-semibold group-hover:gap-3 transition-all">
                        <span data-i18n="mainCard_cta">Descubra nossos diferenciais-chave</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-5 h-5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Grade de 6 cards: um dos pilares da proposta de valor por card,
                 cada um apontando para sua página de demo dedicada. -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="navigationevolution.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="plus-decoration plus-orange opacity-0 group-hover:opacity-100 transition-opacity top-4 right-4 scale-50"></div>
                    <div class="w-14 h-14 icon-box icon-primary mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><circle cx="12" cy="12" r="10"></circle><path d="m16.24 7.76-1.804 5.411a2 2 0 0 1-1.265 1.265L7.76 16.24l1.804-5.411a2 2 0 0 1 1.265-1.265z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-netskope-blue transition-colors" data-i18n="card_1_title">Evolução da navegação</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_1_desc">Melhore a segurança web com Next Generation SWG. Inspecione o tráfego TLS e controle instâncias e atividades em aplicações SaaS.</p>
                </a>

                <a href="dataprotection.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="w-14 h-14 icon-box icon-teal mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-teal transition-colors" data-i18n="card_2_title">Proteção de Dados</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_2_desc">Proteção avançada da informação com IA/ML. Proteja dados sensíveis em movimento e em repouso por qualquer vetor.</p>
                </a>

                <a href="vpnevolution.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="w-14 h-14 icon-box icon-primary mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-netskope-blue transition-colors" data-i18n="card_3_title">Evolução da VPN</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_3_desc">Netskope Private Access (ZTNA). Acesso direto, rápido e seguro a aplicações privadas, eliminando a superfície de ataque das VPNs tradicionais.</p>
                </a>

                <a href="aicontrol.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="w-14 h-14 icon-box icon-green mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-[#4A7A25] transition-colors" data-i18n="card_4_title">Controle de IA generativa</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_4_desc">Habilite o uso seguro do ChatGPT e de mais de 2.000 apps de IA generativa. Visibilidade granular e coaching em tempo real para os usuários.</p>
                </a>

                <!-- TEAM-HIDE:AGENTIC-MCP START (variante partner: o card/link para agenticai.php não é exposto na home;
                     este era o bug conhecido da cópia demolatam-team/ original: team-simple.css tentava ocultar
                     este link com a[href*="agenticai.php"] mas nunca era linkado a partir de nenhuma pagina, entao o
                     link continuava visivel. Aqui ele e ocultado corretamente com o mesmo mecanismo TEAM-HIDE do resto do site.
                <a href="agenticai.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="w-14 h-14 icon-box icon-green mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><path d="M12 20v2"></path><path d="M12 2v2"></path><path d="M17 20v2"></path><path d="M17 2v2"></path><path d="M2 12h2"></path><path d="M2 17h2"></path><path d="M2 7h2"></path><path d="M20 12h2"></path><path d="M20 17h2"></path><path d="M20 7h2"></path><path d="M7 20v2"></path><path d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-[#4A7A25] transition-colors" data-i18n="card_5_title">Adoção Segura de IA agêntica</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_5_desc">Controle e proteja os fluxos de trabalho na interação entre os agentes de IA. Com IA Gateway, IA Guardrails e IA Red Teaming.</p>
                </a>
                TEAM-HIDE:AGENTIC-MCP END -->

                <a href="networktransformation.php" class="group netskope-card p-8 flex flex-col h-full relative">
                    <div class="w-14 h-14 icon-box icon-primary mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-7 h-7"><rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-deep-blue mb-3 group-hover:text-netskope-blue transition-colors" data-i18n="card_6_title">Transformação da Rede</h3>
                    <p class="text-gray-custom text-sm leading-relaxed flex-grow" data-i18n="card_6_desc">Transformação de rede com Single Vendor SASE. Simplificação, segurança e interconexão de filiais com priorização de tráfego e segurança IoT.</p>
                </a>
            </div>

            <!-- CTA final: convida a acessar o Portal de Demos interativas (demos.php). -->
            <div class="mt-10">
                <a href="demos.php" class="demo-cta-card group relative bg-gradient-to-br from-teal-50 to-white rounded-2xl p-8 md:p-10 shadow-lg border border-teal-100 overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 transition-all hover:shadow-xl hover:border-teal-200">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#D9FAFF] opacity-30"></div>
                    <div class="relative z-10 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-deep-blue font-graphik mb-2" data-i18n="demo_title">Quer ver ao vivo? 😉</h3>
                        <p class="text-gray-custom max-w-xl" data-i18n="demo_desc">Agende uma demo personalizada e descubra como a Netskope pode transformar a segurança da sua organização.</p>
                    </div>
                    <div class="relative z-10 w-16 h-16 bg-gradient-confident text-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="w-8 h-8 fill-current"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer: logo pequeno + texto de direitos reservados (fixo em inglês). -->
    <footer class="site-footer bg-white border-t border-gray-200 py-12 mt-auto site-shell-footer">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6 site-shell-footer-inner">
            <div class="flex items-center gap-4 site-shell-footer-meta">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="site-logo h-6 w-auto"></a>
            </div>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved.
                | <span class="text-netskope-blue cursor-pointer hover:underline">Privacy Policy</span>
            </p>
        </div>
    </footer>

    <!-- Utilidades JS compartidas (changeLanguage, modales, portapapeles) y diccionario
         de traduções comum (botões/textos repetidos em várias páginas). Devem
         ser carregados ANTES do script inline desta página porque este último os usa. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Dicionário de traduções desta página. É mesclado com NetskopeCommonI18n
        // (assets/js/i18n-common.js) para herdar os textos compartilhados entre páginas;
        // as chaves abaixo são específicas de index.php (hero, cards da landing, etc).
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header_tagline": "Segurança e redes reinventadas",
                "hero_pretitle": "A Transformação da",
                "hero_title": "Segurança, Rede e IA",
                "hero_subtitle": "Uma plataforma SASE pensada para que você esteja seguro, esteja onde estiver.",
                "mainCard_title": "Quem é a Netskope?",
                "mainCard_badge": "LÍDER EM TODOS OS QUADRANTES",
                "mainCard_desc": "Por que sacrificar a experiência do usuário pela segurança? Com nossa rede <span class=\"font-semibold text-deep-blue\">NewEdge</span> você tem as duas coisas. Obtenha velocidade na navegação, proteção da informação e a tranquilidade necessária para adotar a IA.",
                "mainCard_cta": "Descubra nossos diferenciais-chave",
                
                "card_1_title": "Evolução da navegação",
                "card_1_desc": "Melhore a segurança web com Next Generation SWG. Inspecione o tráfego TLS e controle instâncias e atividades em aplicações SaaS.",
                
                "card_2_title": "Proteção de Dados",
                "card_2_desc": "Proteção avançada da informação com IA/ML. Proteja dados sensíveis em movimento e em repouso por qualquer vetor.",
                
                "card_3_title": "Evolução da VPN",
                "card_3_desc": "Netskope Private Access (ZTNA). Acesso direto, rápido e seguro a aplicações privadas, eliminando a superfície de ataque das VPNs tradicionais.",
                
                "card_4_title": "Controle de IA generativa",
                "card_4_desc": "Habilite o uso seguro do ChatGPT e de mais de 2.000 apps de IA generativa. Visibilidade granular e coaching em tempo real para os usuários.",
                
                "card_5_title": "Adoção Segura de IA agêntica",
                "card_5_desc": "Controle e proteja os fluxos de trabalho na interação entre os agentes de IA. Com IA Gateway, IA Guardrails e IA Red Teaming.",
                
                "card_6_title": "Transformação da Rede",
                "card_6_desc": "Transformação de rede com Single Vendor SASE. Simplificação, segurança e interconexão de filiais com priorização de tráfego e segurança IoT.",
                
                "demo_title": "Quer ver ao vivo? 😉",
                "demo_desc": "Agende uma demo personalizada e descubra como a Netskope pode transformar a segurança da sua organização."
            }
        };

        // changeLanguage(lang) não é mais definida aqui: a versão compartilhada fica em
        // assets/js/common.js e opera sobre o objeto global `translations` acima.

        document.addEventListener('DOMContentLoaded', () => {
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
