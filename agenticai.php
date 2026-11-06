<?php
// agenticai.php - Demo "Adoção Segura de IA agêntica". Apresenta 6 cartões de
// capacidades (IA Gateway, IA Guardrails, IA Red Teaming, etc.) com diagramas
// ampliáveis (zoom) e links de fechamento de fluxo para keydifferentiators.php,
// index.php e demos.php. Parte do fluxo de demo vinculado a partir de index.php.
//
// As funções JS comuns (changeLanguage, área de transferência) ficam em
// assets/js/common.js e os textos i18n compartilhados entre páginas ficam em
// assets/js/i18n-common.js. O dicionário `translations` deste arquivo contém
// apenas strings específicas desta página. O "diagram preview modal" (zoom
// de diagramas) é uma função autocontida e específica desta página: NÃO
// foi movida para common.js porque cria seu próprio modal dinamicamente e define
// sua própria closeModal local de escopo limitado (não colide com a global).
?>
<!DOCTYPE html>
<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Guia visual para explicar a adoção segura de Agentic AI com visibilidade, guardrails e Zero Trust.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Agentic AI</title>
    <link href="assets/vendor/css/offline-fonts.css" rel="stylesheet">
    <link href="assets/vendor/css/site-global.css" rel="stylesheet">
    <script src="assets/vendor/js/site-global.js"></script>
    <script src="assets/vendor/js/tailwindcss-cdn.js"></script>
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
        .flow-arrow-container { position: relative; display: flex; align-items: center; justify-content: center; width: 100%; height: 44px; }
        .flow-line { height: 3px; width: 100%; position: absolute; top: 50%; z-index: 1; }
        .flow-label { position: relative; z-index: 2; background-color: white; padding: 8px 18px; border-radius: 16px; font-size: 1rem; font-weight: 700; white-space: nowrap; box-shadow: 0 6px 14px rgba(0,0,0,0.08); }
        .quote-icon { position: absolute; top: -20px; left: 20px; width: 40px; height: 40px; background-color: #00A9CE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .trust-pillar { height: 136px; width: 128px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; border-radius: 18px; color: white; font-weight: 800; padding: 10px; position: relative; box-shadow: 0 10px 24px rgba(0,0,0,0.14); transition: transform 0.2s; }
        .trust-pillar:hover { transform: translateY(-3px); }
        .trust-pillar-label { font-size: 1.05rem; line-height: 1.1; text-transform: uppercase; }
        .bg-pillar-std { background: linear-gradient(180deg, #A8D1D9 0%, #008095 100%); }
        .bg-pillar-ai { background: linear-gradient(180deg, #C2E5ED 0%, #00A9CE 100%); }
        .bg-pillar-gray { background: linear-gradient(180deg, #D1D3D4 0%, #53565A 100%); }
        .bg-pillar-orange { background: linear-gradient(180deg, #FFE0B2 0%, #FF8200 100%); }
        .decision-pill-horizontal { background-color: #081A59; color: white; border-radius: 64px; padding: 24px 48px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; box-shadow: 0 20px 44px rgba(8, 26, 89, 0.24); position: relative; width: 100%; max-width: 1520px; margin-top: 32px; }
        .decision-group { display: flex; align-items: center; gap: 34px; }
        .decision-text { font-weight: 800; font-size: 2rem; letter-spacing: 0.06em; }
        .decision-text-small { font-family: monospace; font-size: 1.1rem; opacity: 0.6; margin-right: 10px; }
        .decision-text.action { color: #AFF198; } 
        .decision-text.block { color: #FF8200; } 
        .decision-text.coach { color: #00A9CE; } 
        .diagram-preview-trigger { position: relative; cursor: zoom-in; transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .diagram-preview-trigger:hover { transform: translateY(-4px) scale(1.01); }
        .diagram-preview-trigger::after { content: attr(data-preview-label); position: absolute; top: 14px; right: 14px; background: rgba(8, 26, 89, 0.92); color: #fff; border-radius: 999px; padding: 8px 10px; font-size: 0; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 24px rgba(8, 26, 89, 0.2); border: 2px solid rgba(255,255,255,0.95); z-index: 5; }
        .diagram-preview-trigger::before { content: '+'; position: absolute; top: 14px; right: 14px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; font-weight: 500; z-index: 6; pointer-events: none; }
        .diagram-preview-modal { position: fixed; inset: 0; background: rgba(6, 15, 42, 0.82); display: flex; align-items: center; justify-content: center; padding: 28px; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
        .diagram-preview-modal.is-open { opacity: 1; pointer-events: auto; }
        .diagram-preview-dialog { width: min(96vw, 1800px); max-height: 92vh; overflow: auto; background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%); border-radius: 32px; padding: 28px; box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35); position: relative; }
        .diagram-preview-body { padding: 8px 6px 36px; }
        .diagram-preview-content { transform-origin: top center; margin-bottom: 12px; }
        .diagram-preview-close { position: sticky; top: 0; margin-left: auto; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border: 0; border-radius: 999px; background: #081A59; color: white; font-size: 1.5rem; cursor: pointer; z-index: 2; }
        .diagram-preview-body .diagram-preview-trigger::before,
        .diagram-preview-body .diagram-preview-trigger::after { display: none; }
        .diagram-preview-body .diagram-preview-trigger { cursor: default; transform: none; }

        @media (min-width: 1024px) {
            .diagram-preview-body .diagram-preview-content { transform: scale(1.12); }
            .diagram-preview-body { padding-bottom: 72px; }
        }

        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: #081A59; }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.inset-0{inset:0px}.-right-20{right:-5rem}.-top-20{top:-5rem}.-top-4{top:-1rem}.left-0{left:0px}.left-1\/2{left:50%}.right-0{right:0px}.top-0{top:0px}.z-10{z-index:10}.z-20{z-index:20}.z-50{z-index:50}.col-span-2{grid-column:span 2 / span 2}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-10{margin-bottom:2.5rem}.mb-12{margin-bottom:3rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.ml-6{margin-left:1.5rem}.mr-6{margin-right:1.5rem}.mt-0{margin-top:0px}.mt-2{margin-top:0.5rem}.mt-4{margin-top:1rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-0{height:0px}.h-1{height:0.25rem}.h-10{height:2.5rem}.h-12{height:3rem}.h-16{height:4rem}.h-2{height:0.5rem}.h-20{height:5rem}.h-24{height:6rem}.h-3{height:0.75rem}.h-32{height:8rem}.h-4{height:1rem}.h-40{height:10rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-64{height:16rem}.h-8{height:2rem}.h-full{height:100%}.min-h-\[240px\]{min-height:240px}.min-h-\[260px\]{min-height:260px}.min-h-screen{min-height:100vh}.w-0{width:0px}.w-1\/2{width:50%}.w-10{width:2.5rem}.w-12{width:3rem}.w-16{width:4rem}.w-2{width:0.5rem}.w-20{width:5rem}.w-3{width:0.75rem}.w-32{width:8rem}.w-4{width:1rem}.w-5{width:1.25rem}.w-6{width:1.5rem}.w-64{width:16rem}.w-8{width:2rem}.w-auto{width:auto}.w-full{width:100%}.w-px{width:1px}.max-w-2xl{max-width:42rem}.max-w-3xl{max-width:48rem}.max-w-5xl{max-width:64rem}.max-w-7xl{max-width:80rem}.max-w-\[92rem\]{max-width:92rem}.max-w-\[96rem\]{max-width:96rem}.shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}.-translate-x-1\/2{--tw-translate-x:-50%;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.scale-105{--tw-scale-x:1.05;--tw-scale-y:1.05;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.transform{transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}@keyframes pulse{50%{opacity:.5}}.animate-pulse{animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.flex-col{flex-direction:column}.flex-wrap{flex-wrap:wrap}.items-end{align-items:flex-end}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-10{gap:2.5rem}.gap-12{gap:3rem}.gap-2{gap:0.5rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-5{gap:1.25rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.-space-x-2 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(-0.5rem * var(--tw-space-x-reverse));margin-left:calc(-0.5rem * calc(1 - var(--tw-space-x-reverse)))}.space-y-4 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.whitespace-nowrap{white-space:nowrap}.rounded{border-radius:0.25rem}.rounded-2xl{border-radius:1rem}.rounded-\[28px\]{border-radius:28px}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-netskope{border-radius:24px}.rounded-netskope-sm{border-radius:12px}.rounded-xl{border-radius:0.75rem}.rounded-l-full{border-top-left-radius:9999px;border-bottom-left-radius:9999px}.rounded-t{border-top-left-radius:0.25rem;border-top-right-radius:0.25rem}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.border{border-width:1px}.border-2{border-width:2px}.border-b{border-bottom-width:1px}.border-b-\[7px\]{border-bottom-width:7px}.border-l{border-left-width:1px}.border-l-4{border-left-width:4px}.border-l-\[12px\]{border-left-width:12px}.border-r{border-right-width:1px}.border-r-\[12px\]{border-right-width:12px}.border-t{border-top-width:1px}.border-t-\[7px\]{border-top-width:7px}.border-dashed{border-style:dashed}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-netskope-blue{--tw-border-opacity:1;border-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-netskope-blue\/20{border-color:rgb(0 169 206 / 0.2)}.border-netskope-deepBlue{--tw-border-opacity:1;border-color:rgb(8 26 89 / var(--tw-border-opacity, 1))}.border-netskope-deepBlue\/30{border-color:rgb(8 26 89 / 0.3)}.border-netskope-lightBlue{--tw-border-opacity:1;border-color:rgb(217 250 255 / var(--tw-border-opacity, 1))}.border-white{--tw-border-opacity:1;border-color:rgb(255 255 255 / var(--tw-border-opacity, 1))}.border-white\/10{border-color:rgb(255 255 255 / 0.1)}.border-white\/20{border-color:rgb(255 255 255 / 0.2)}.border-white\/5{border-color:rgb(255 255 255 / 0.05)}.border-white\/50{border-color:rgb(255 255 255 / 0.5)}.border-b-transparent{border-bottom-color:transparent}.border-l-netskope-blue{--tw-border-opacity:1;border-left-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-l-netskope-orange{--tw-border-opacity:1;border-left-color:rgb(255 130 0 / var(--tw-border-opacity, 1))}.border-r-netskope-blue{--tw-border-opacity:1;border-right-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-t-transparent{border-top-color:transparent}.bg-blue-500\/30{background-color:rgb(59 130 246 / 0.3)}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-gray-50{--tw-bg-opacity:1;background-color:rgb(249 250 251 / var(--tw-bg-opacity, 1))}.bg-green-500\/30{background-color:rgb(34 197 94 / 0.3)}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-blue\/10{background-color:rgb(0 169 206 / 0.1)}.bg-netskope-blue\/20{background-color:rgb(0 169 206 / 0.2)}.bg-netskope-blue\/30{background-color:rgb(0 169 206 / 0.3)}.bg-netskope-deepBlue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-netskope-green{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-netskope-green\/10{background-color:rgb(175 241 152 / 0.1)}.bg-netskope-green\/20{background-color:rgb(175 241 152 / 0.2)}.bg-netskope-green\/30{background-color:rgb(175 241 152 / 0.3)}.bg-netskope-lightBlue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-netskope-lightBlue\/10{background-color:rgb(217 250 255 / 0.1)}.bg-netskope-orange\/20{background-color:rgb(255 130 0 / 0.2)}.bg-netskope-teal\/30{background-color:rgb(0 128 149 / 0.3)}.bg-orange-500\/30{background-color:rgb(249 115 22 / 0.3)}.bg-purple-500\/30{background-color:rgb(168 85 247 / 0.3)}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/20{background-color:rgb(255 255 255 / 0.2)}.bg-white\/5{background-color:rgb(255 255 255 / 0.05)}.bg-white\/60{background-color:rgb(255 255 255 / 0.6)}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.bg-gradient-to-t{background-image:linear-gradient(to top, var(--tw-gradient-stops))}.from-netskope-blue\/50{--tw-gradient-from:rgb(0 169 206 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 169 206 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-green{--tw-gradient-from:#AFF198 var(--tw-gradient-from-position);--tw-gradient-to:rgb(175 241 152 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-lightBlue{--tw-gradient-from:#D9FAFF var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-orange{--tw-gradient-from:#FF8200 var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 130 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-white{--tw-gradient-from:#fff var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-netskope-blue{--tw-gradient-to:#00A9CE var(--tw-gradient-to-position)}.to-netskope-offWhite{--tw-gradient-to:#F5F5F5 var(--tw-gradient-to-position)}.to-netskope-orange{--tw-gradient-to:#FF8200 var(--tw-gradient-to-position)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.to-yellow-500{--tw-gradient-to:#eab308 var(--tw-gradient-to-position)}.p-4{padding:1rem}.p-5{padding:1.25rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-2{padding-left:0.5rem;padding-right:0.5rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-8{padding-left:2rem;padding-right:2rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-20{padding-top:5rem;padding-bottom:5rem}.py-3{padding-top:0.75rem;padding-bottom:0.75rem}.py-4{padding-top:1rem;padding-bottom:1rem}.pb-20{padding-bottom:5rem}.pl-6{padding-left:1.5rem}.pr-6{padding-right:1.5rem}.pt-16{padding-top:4rem}.pt-3{padding-top:0.75rem}.pt-4{padding-top:1rem}.text-center{text-align:center}.text-right{text-align:right}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-4xl{font-size:2.25rem;line-height:2.5rem}.text-5xl{font-size:3rem;line-height:1}.text-\[10px\]{font-size:10px}.text-base{font-size:1rem;line-height:1.5rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-normal{font-weight:400}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.tracking-widest{letter-spacing:0.1em}.text-blue-500{--tw-text-opacity:1;color:rgb(59 130 246 / var(--tw-text-opacity, 1))}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-green-600{--tw-text-opacity:1;color:rgb(22 163 74 / var(--tw-text-opacity, 1))}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-orange-500{--tw-text-opacity:1;color:rgb(249 115 22 / var(--tw-text-opacity, 1))}.text-purple-500{--tw-text-opacity:1;color:rgb(168 85 247 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.text-white\/50{color:rgb(255 255 255 / 0.5)}.text-white\/80{color:rgb(255 255 255 / 0.8)}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-10{opacity:0.1}.opacity-50{opacity:0.5}.opacity-60{opacity:0.6}.opacity-70{opacity:0.7}.opacity-80{opacity:0.8}.shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-md{--tw-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.ring-4{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.ring-netskope-lightBlue\/30{--tw-ring-color:rgb(217 250 255 / 0.3)}.blur-3xl{--tw-blur:blur(64px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-blur-sm{--tw-backdrop-blur:blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-colors{transition-property:color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.hover\:bg-netskope-lightBlue:hover{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.hover\:bg-netskope-teal:hover{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.hover\:bg-white:hover{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.hover\:bg-white\/15:hover{background-color:rgb(255 255 255 / 0.15)}.hover\:text-netskope-teal:hover{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:opacity-90:hover{opacity:0.9}.hover\:shadow-hover:hover{--tw-shadow:0 20px 50px -10px rgba(0, 169, 206, 0.15);--tw-shadow-colored:0 20px 50px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}@media (min-width: 768px){.md\:block{display:block}.md\:flex{display:flex}.md\:h-10{height:2.5rem}.md\:h-12{height:3rem}.md\:h-20{height:5rem}.md\:h-24{height:6rem}.md\:w-10{width:2.5rem}.md\:w-12{width:3rem}.md\:w-20{width:5rem}.md\:w-24{width:6rem}.md\:w-44{width:11rem}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:gap-12{gap:3rem}.md\:gap-24{gap:6rem}.md\:p-10{padding:2.5rem}.md\:p-6{padding:1.5rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:px-8{padding-left:2rem;padding-right:2rem}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-7xl{font-size:4.5rem;line-height:1}.md\:text-base{font-size:1rem;line-height:1.5rem}.md\:text-sm{font-size:0.875rem;line-height:1.25rem}}@media (min-width: 1024px){.lg\:-mt-4{margin-top:-1rem}.lg\:w-1\/2{width:50%}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.lg\:flex-row{flex-direction:row}}@media (min-width: 1280px){.xl\:mt-0{margin-top:0px}.xl\:gap-5{gap:1.25rem}.xl\:gap-8{gap:2rem}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-site-shell="ready" data-page-name="agenticai" data-page-kind="story">

<!-- Header -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6 site-shell-toolbar">
                <div class="hidden md:flex items-center">
                    <span class="text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header.tagline">IA Security & Governance</span>
                </div>

            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-white pt-16 pb-20 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-6">
                    <span class="w-8 h-1 bg-netskope-green"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="hero.badge">Segurança de IA agêntica</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-6 leading-tight" data-i18n="hero.title">Adoção Segura de<br><span class="font-lora italic font-normal text-netskope-green">IA agêntica</span></h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-10" data-i18n="hero.desc">74% dos líderes de aplicações de TI acreditam que os agentes de IA representam um novo vetor de ataque.<br><strong class="text-netskope-deepBlue font-semibold">Proteja as interações de IA para IA e garanta a autonomia responsável.</strong></p>

                <!-- Stats -->
                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-6 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-netskope-green mb-1">33%</div>
                        <div class="text-[10px] text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.1">apps com IA agêntica em 2028</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-netskope-blue mb-1">74%</div>
                        <div class="text-[10px] text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.2">veem um novo vetor de ataque</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-netskope-deepBlue mb-1">100%</div>
                        <div class="text-[10px] text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.3">interações de IA para IA protegidas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Market Reality Section -->
    <section class="bg-netskope-deepBlue py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="market.tag">Realidade do Mercado</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="market.title">O que dizem os analistas</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-4">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-6 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-base leading-relaxed mb-4 mt-2 flex-grow" data-i18n="quote.1">"As tecnologias de GenAI evoluem em um ritmo sem precedentes, tornando um desafio para os CIOs navegar neste cenário dinâmico."</p>
                    <div class="border-t border-white/20 pt-3 mt-auto"><p class="text-white font-bold text-xs tracking-wide">Gartner</p></div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-6 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full mt-0 lg:-mt-4">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-base leading-relaxed mb-4 mt-2 flex-grow" data-i18n="quote.2">"Até 2028, um terço dos aplicativos de software empresarial incluirá IA agêntica, contra menos de 1% em 2024."</p>
                    <div class="border-t border-white/20 pt-3 mt-auto"><p class="text-white font-bold text-xs tracking-wide">Gartner Predicts</p></div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-6 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-base leading-relaxed mb-4 mt-2 flex-grow" data-i18n="quote.3">"74% dos líderes de aplicações de TI acreditam que os agentes de IA representam um novo vetor de ataque em sua organização."</p>
                    <div class="border-t border-white/20 pt-3 mt-auto"><p class="text-white font-bold text-xs tracking-wide">Gartner Survey</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- STRATEGY SECTION -->
    <section class="py-16 bg-gradient-confident text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="strat.tag">Estratégia da Netskope</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="strat.title">Proteção Integral para IA agêntica</h2>
                <p class="text-netskope-lightBlue max-w-3xl mx-auto text-lg" data-i18n="strat.subtitle">Soluções específicas para os desafios únicos das arquiteturas de IA para IA</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-8 h-8 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">AI Gateway</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.gw.desc">Gateway unificado para comunicações agênticas em implantações privadas.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-8 h-8 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">AI Security Guardrails</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.guard.desc">Proteção contra ameaças de IA como prompt injection e moderação de conteúdo.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-8 h-8 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">AI Red Teaming</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.red.desc">Testes de estresse proativos e descoberta de vulnerabilidades em LLMs.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-8 h-8 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">DSPM for RAG</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.dspm.desc">Proteção do pipeline de dados, descoberta e classificação para RAG.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-8 h-8 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">AI-SPM</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.aispm.desc">Gestão contínua da postura de segurança e inventário de ativos de IA.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-5 rounded-netskope hover:bg-white/15 transition-all border-l-4 border-l-netskope-orange">
                    <div class="w-8 h-8 bg-netskope-orange/20 rounded-lg flex items-center justify-center text-netskope-orange mb-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg></div>
                    <h3 class="text-base font-bold mb-2">Agentic Broker</h3>
                    <p class="text-white/80 text-xs" data-i18n="strat.broker.desc">Detecta e monitora tráfego MCP exposto à internet e aplica controle de acesso.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW PARADIGM SECTION (COM ZOOM INTACTO) -->
    <section class="py-16 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-netskope-deepBlue mb-3" data-i18n="paradigm.title">O Novo Paradigma: Interações de IA para IA</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-base" data-i18n="paradigm.desc">Enquanto a IA generativa tradicional se concentra em interações usuário-para-LLM, a IA agêntica introduz comunicações autônomas.</p>
            </div>
            <div class="grid grid-cols-1 gap-10 max-w-[92rem] mx-auto diagram-preview-trigger" data-preview-label="Clique para ampliar">
                <!-- ROW 1 -->
                <div class="bg-white p-8 md:p-10 rounded-netskope shadow-soft flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12 relative border border-gray-100 min-h-[240px]">
                    <div class="flex flex-col items-center gap-3 w-32 md:w-44 shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-2 border-netskope-deepBlue flex items-center justify-center bg-white"><svg class="w-10 h-10 md:w-12 md:h-12 text-netskope-deepBlue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                        <span class="text-xs md:text-sm font-bold text-netskope-deepBlue text-center" data-i18n="flow.user">User using GenAI</span>
                    </div>
                    <div class="flex-grow w-full flex flex-col gap-6 relative px-2 md:px-8">
                        <div class="flow-arrow-container" style="height: 40px;">
                             <div class="absolute left-0 w-3 h-3 bg-netskope-lightBlue rounded-full"></div>
                             <div class="flow-line bg-gradient-to-r from-netskope-lightBlue to-netskope-blue"></div>
                             <div class="absolute right-0 w-0 h-0 border-t-[7px] border-t-transparent border-l-[12px] border-l-netskope-blue border-b-[7px] border-b-transparent"></div>
                             <span class="flow-label text-netskope-deepBlue border border-gray-100 py-1" data-i18n="flow.zt">Zero Trust Engine</span>
                        </div>
                        <div class="flow-arrow-container" style="height: 40px;">
                             <div class="absolute left-0 w-0 h-0 border-t-[7px] border-t-transparent border-r-[12px] border-r-netskope-blue border-b-[7px] border-b-transparent"></div>
                             <div class="flow-line bg-netskope-blue"></div>
                             <div class="absolute right-0 w-0 h-0 border-t-[7px] border-t-transparent border-l-[12px] border-l-netskope-blue border-b-[7px] border-b-transparent"></div>
                             <span class="flow-label text-netskope-blue border border-netskope-lightBlue py-1">+ AI Guardrails</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-3 w-32 md:w-44 shrink-0">
                         <div class="flex -space-x-2">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-200 z-20"><svg class="w-8 h-8 md:w-10 md:h-10 text-purple-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg></div>
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-200 z-10"><svg class="w-8 h-8 md:w-10 md:h-10 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path></svg></div>
                         </div>
                        <span class="text-xs md:text-sm font-bold text-netskope-gray text-center" data-i18n="flow.genai">GenAI Apps</span>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="bg-white p-8 md:p-10 rounded-netskope shadow-soft flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12 relative border border-netskope-blue/20 ring-4 ring-netskope-lightBlue/30 min-h-[260px]">
                    <div class="flex flex-col items-center gap-3 w-32 md:w-44 shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl border-2 border-netskope-deepBlue flex items-center justify-center bg-white shadow-md">
                            <svg class="w-10 h-10 md:w-12 md:h-12 text-netskope-deepBlue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path><circle cx="12" cy="11" r="1.5" fill="currentColor"></circle></svg>
                        </div>
                        <span class="text-xs md:text-sm font-bold text-netskope-deepBlue text-center" data-i18n="flow.agentic">IA agêntica using LLMs</span>
                    </div>
                    <div class="flex-grow w-full flex flex-col gap-6 relative px-2 md:px-8">
                        <div class="flow-arrow-container" style="height: 40px;">
                             <div class="absolute left-0 w-0 h-0 border-t-[7px] border-t-transparent border-r-[12px] border-r-netskope-blue border-b-[7px] border-b-transparent"></div>
                             <div class="flow-line bg-netskope-blue"></div>
                             <div class="absolute right-0 w-0 h-0 border-t-[7px] border-t-transparent border-l-[12px] border-l-netskope-blue border-b-[7px] border-b-transparent"></div>
                             <span class="flow-label text-netskope-blue border-2 border-netskope-blue shadow-sm py-1" data-i18n="flow.gw">IA GW + Guardrails</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-3 w-32 md:w-44 shrink-0">
                         <div class="flex -space-x-2">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full border border-gray-200 flex items-center justify-center shadow-sm z-20"><svg class="w-8 h-8 md:w-10 md:h-10 text-orange-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg></div>
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full border border-gray-200 flex items-center justify-center shadow-sm z-10"><svg class="w-8 h-8 md:w-10 md:h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg></div>
                         </div>
                        <span class="text-xs md:text-sm font-bold text-netskope-gray text-center" data-i18n="flow.llm">On-prem & Cloud LLMs</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ZERO TRUST ENGINE VISUAL SECTION -->
    <section class="py-12 bg-white relative">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-2" data-i18n="zt.title">Netskope Zero Trust Engine + IA Guardrails</h2>
                <p class="text-netskope-gray max-w-2xl mx-auto text-sm" data-i18n="zt.desc">Extensão do mecanismo Zero Trust para cobrir todo o ciclo de vida da IA.</p>
            </div>

            <div class="flex flex-col items-center justify-center gap-10 max-w-[96rem] mx-auto diagram-preview-trigger" data-preview-label="Clique para ampliar">
                <div class="flex items-end gap-6 xl:gap-8 flex-wrap justify-center w-full">
                    <!-- Standard Trust -->
                    <div class="flex items-end gap-4 xl:gap-5">
                        <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-std"><span class="trust-pillar-label" data-i18n="zt.p1">Identity<br>Trust</span></div><span class="text-xs text-netskope-blue font-bold text-center">User</span></div>
                        <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-std"><span class="trust-pillar-label" data-i18n="zt.p2">Device<br>Trust</span></div><span class="text-xs text-netskope-blue font-bold text-center">Managed</span></div>
                        <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-gray opacity-50"><span class="trust-pillar-label" data-i18n="zt.p3">Location<br>Trust</span></div><span class="text-xs text-gray-400 font-bold text-center">Office</span></div>
                        <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-gray opacity-50"><span class="trust-pillar-label" data-i18n="zt.p4">App<br>Trust</span></div><span class="text-xs text-gray-400 font-bold text-center">ChatGPT</span></div>
                    </div>
                    <!-- AI Context -->
                    <div class="border-2 border-dashed border-netskope-deepBlue/30 rounded-[28px] p-5 md:p-6 bg-netskope-lightBlue/10 relative mt-4 xl:mt-0">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-4 py-1 text-sm font-bold text-netskope-deepBlue uppercase tracking-wide whitespace-nowrap" data-i18n="zt.context">New IA Context</div>
                        <div class="flex items-end gap-4 xl:gap-5">
                            <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-ai"><span class="trust-pillar-label" data-i18n="zt.p5">Instance<br>Trust</span></div><span class="text-xs text-netskope-teal font-bold text-center">Corporate</span></div>
                            <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-ai"><span class="trust-pillar-label" data-i18n="zt.p6">Activity<br>Trust</span></div><span class="text-xs text-netskope-teal font-bold text-center">Post</span></div>
                            <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-gray opacity-60"><span class="trust-pillar-label" data-i18n="zt.p7">Behavior<br>Trust</span></div><span class="text-xs text-gray-500 font-bold text-center">Risk Score</span></div>
                            <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-gray opacity-60"><span class="trust-pillar-label" data-i18n="zt.p8">Data<br>Trust</span></div><span class="text-xs text-gray-500 font-bold text-center">Confidential</span></div>
                            <div class="flex flex-col items-center gap-2"><div class="trust-pillar bg-pillar-orange shadow-md scale-105 border-2 border-white z-10"><span class="trust-pillar-label text-netskope-deepBlue" data-i18n="zt.p9">IA<br>Comms</span></div><span class="text-xs text-netskope-orange font-bold text-center">Content Mod</span></div>
                        </div>
                    </div>
                </div>
                <!-- Decision Pill -->
                <div class="decision-pill-horizontal">
                    <div class="absolute left-0 h-full w-2 bg-gradient-to-b from-netskope-green to-netskope-orange rounded-l-full opacity-70"></div>
                    <div class="mr-6 border-r border-white/20 pr-6"><div class="text-base text-white/50 font-bold uppercase tracking-widest" data-i18n="zt.outcome">Policy Decision</div></div>
                    <div class="decision-group flex-grow justify-center"><span class="decision-text action">ALLOW</span><span class="decision-text block">BLOCK</span><span class="decision-text coach">COACH</span></div>
                    <div class="decision-group hidden md:flex border-l border-white/20 pl-6 ml-6"><span class="decision-text-small">REAUTH</span><span class="decision-text-small">JUSTIFY</span><span class="decision-text-small">ISOLATE</span></div>
                    <div class="ml-6 pl-6 border-l border-white/20"><p class="text-sm md:text-base text-netskope-blue font-bold leading-tight text-right" data-i18n="zt.result">Block Upload<br>& Coach the User</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- UPDATED USE CASES SECTION (RESTAURADO CON LAS 6 TARJETAS ORIGINALES) -->
    <section class="py-20 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="cases.badge">CASOS DE USO CLAVE</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="cases.title">Seis Casos de Uso para Proteger a GenAI</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg mb-10" data-i18n="cases.desc">Visibilidade e controle para o uso gerenciado e não gerenciado em toda a organização</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Case 1 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-green/10 rounded-xl flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.1.title">Acesso Seguro a Ferramentas de IA</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.1.desc">Controle de acesso contextual. Diferencia instâncias pessoais e corporativas para bloquear dados sensíveis em contas não autorizadas.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-green uppercase tracking-wide">Instance Awareness</span></div>
                </div>
                <!-- Case 2 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.2.title">Segurança para Apps de IA Próprios</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.2.desc">Integre o Netskope DLP em aplicações personalizadas. Obtenha um veredito de segurança antes de enviar dados ao LLM para prevenir vazamentos.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-blue uppercase tracking-wide">DLP on Demand</span></div>
                </div>
                <!-- Case 3 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-green/10 rounded-xl flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.3.title">Proteção do Pipeline de Dados</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.3.desc">Visibilidade de onde os dados de IA vivem e fluem. Descubra e classifique dados sensíveis em datasets de treinamento e RAG com DSPM.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-green uppercase tracking-wide">DSPM for AI</span></div>
                </div>
                <!-- Case 4 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.4.title">Segurança nas Interações de Agentes</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.4.desc">Elimine pontos cegos nas comunicações de IA para IA e serviço-para-serviço. Inspeção de conteúdo para prevenir ataques e vazamentos de dados.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-blue uppercase tracking-wide">AI Gateway</span></div>
                </div>
                <!-- Case 5 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-green/10 rounded-xl flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.5.title">Proteção contra Ameaças de IA</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.5.desc">Defesa proativa contra Prompt Injection, Jailbreaking e malware. Red teaming para avaliar a exposição a riscos antes da produção.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-green uppercase tracking-wide">Threat Protection</span></div>
                </div>
                <!-- Case 6 -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.6.title">Postura de Segurança e Compliance</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.6.desc">Inventário contínuo de ativos de IA, identificação de caminhos de ataque e avaliação de privilégios de acesso excessivos.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-blue uppercase tracking-wide">AI-SPM</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW VISIBILITY SECTION (ENLACE REPARADO A REPORTAI.PHP) -->
    <section class="py-20 bg-netskope-deepBlue text-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="w-full lg:w-1/2">
                    <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="vis.badge">VISIBILIDAD AVANZADA</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="vis.title">Obtenha Visibilidade Total do Uso de IA</h2>
                    <p class="text-lg text-white/80 mb-8 leading-relaxed" data-i18n="vis.desc">Identifique quais aplicações de IA são utilizadas em sua organização, quem as usa e com quais dados. Detecte Shadow IA e avalie o risco do uso de instâncias pessoais em comparação com as corporativas.</p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3"><span class="w-6 h-6 rounded-full bg-netskope-green/20 flex items-center justify-center text-netskope-green font-bold">✓</span> <span data-i18n="vis.list.1">Tendências de uso de Apps de IA e Shadow IA</span></li>
                        <li class="flex items-center gap-3"><span class="w-6 h-6 rounded-full bg-netskope-green/20 flex items-center justify-center text-netskope-green font-bold">✓</span> <span data-i18n="vis.list.2">Análise de atividade e instâncias (Pessoal vs Corp)</span></li>
                        <li class="flex items-center gap-3"><span class="w-6 h-6 rounded-full bg-netskope-green/20 flex items-center justify-center text-netskope-green font-bold">✓</span> <span data-i18n="vis.list.3">Detecção de violações de DLP e movimentação de dados</span></li>
                    </ul>
                    <a href="reportai.php" class="inline-flex items-center gap-2 bg-netskope-green text-netskope-deepBlue font-bold px-6 py-3 rounded-full hover:bg-white transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span data-i18n="vis.btn">Ver Relatório de Visibilidade</span>
                    </a>
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm relative overflow-hidden">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-netskope-blue/20 rounded-full blur-3xl"></div>
                        <div class="relative z-10 grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-lg p-4 h-32 border border-white/5"><div class="h-2 w-20 bg-white/20 rounded mb-2"></div><div class="h-16 bg-gradient-to-t from-netskope-blue/50 to-transparent rounded opacity-50"></div></div>
                            <div class="bg-white/10 rounded-lg p-4 h-32 border border-white/5"><div class="h-2 w-20 bg-white/20 rounded mb-4"></div><div class="flex gap-2"><div class="w-8 h-8 rounded-full bg-purple-500/30"></div><div class="w-8 h-8 rounded-full bg-green-500/30"></div><div class="w-8 h-8 rounded-full bg-blue-500/30"></div></div></div>
                            <div class="col-span-2 bg-white/10 rounded-lg p-4 h-40 border border-white/5 flex items-end justify-between gap-2"><div class="w-full h-10 bg-netskope-green/30 rounded-t"></div><div class="w-full h-16 bg-netskope-blue/30 rounded-t"></div><div class="w-full h-24 bg-purple-500/30 rounded-t"></div><div class="w-full h-12 bg-orange-500/30 rounded-t"></div><div class="w-full h-20 bg-netskope-teal/30 rounded-t"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Buttons -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center">
                <div class="flex flex-col md:flex-row justify-center gap-6">
                    <a href="keydifferentiators.php" class="bg-netskope-blue text-white px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-teal transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span data-i18n="nav_who">Quem é a Netskope?</span>
                    </a>

                    <a href="index.php" class="bg-white text-netskope-deepBlue border border-netskope-blue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span data-i18n="nav_back">Voltar para a landing</span>
                    </a>

                    <a href="demos.php" class="bg-gradient-to-r from-netskope-orange to-yellow-500 text-white px-8 py-4 rounded-netskope-sm font-bold hover:opacity-90 transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3 animate-pulse">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span data-i18n="nav_demo">Quer Ver? 😉</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-auto site-shell-footer">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6 site-shell-footer-inner">
            <div class="flex items-center gap-4 site-shell-footer-meta">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-6 w-auto"></a>
            </div>
            <p class="text-sm text-netskope-gray text-center md:text-right">
                © <script>document.write(new Date().getFullYear())</script> Netskope. All rights reserved.
                |
                <span class="text-netskope-blue cursor-pointer hover:underline">Privacy Policy</span>
            </p>
        </div>
    </footer>

    <!-- Utilitários JS compartilhados (changeLanguage, área de transferência) e dicionário de
         traduções comum. Devem ser carregados antes do script inline abaixo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- Script de Tradução Nativa, Zoom e Fallback -->
    <script>
        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header.tagline": "IA Security & Governance",
                "hero.badge": "Segurança de IA agêntica",
                "hero.title": "Adoção Segura de<br><span class=\"font-lora italic font-normal text-netskope-green\">IA agêntica</span>",
                "hero.desc": "74% dos líderes de aplicações de TI acreditam que os agentes de IA representam um novo vetor de ataque.<br><strong class=\"text-netskope-deepBlue font-semibold\">Proteja as interações de IA para IA e garanta a autonomia responsável.</strong>",
                "stat.1": "apps com IA agêntica em 2028",
                "stat.2": "veem um novo vetor de ataque",
                "stat.3": "interações de IA para IA protegidas",
                "market.tag": "Realidade do Mercado",
                "market.title": "O que dizem os analistas",
                "quote.1": "\"As tecnologias de GenAI evoluem em um ritmo sem precedentes, tornando um desafio para os CIOs navegar neste cenário dinâmico.\"",
                "quote.2": "\"Até 2028, um terço dos aplicativos de software empresarial incluirá IA agêntica, contra menos de 1% em 2024.\"",
                "quote.3": "\"74% dos líderes de aplicações de TI acreditam que os agentes de IA representam um novo vetor de ataque em sua organização.\"",
                "strat.tag": "Estratégia da Netskope",
                "strat.title": "Proteção Integral para IA agêntica",
                "strat.subtitle": "Soluções específicas para os desafios únicos das arquiteturas de IA para IA",
                "strat.gw.desc": "Gateway unificado para comunicações agênticas em implantações privadas.",
                "strat.guard.desc": "Proteção contra ameaças de IA como prompt injection e moderação de conteúdo.",
                "strat.red.desc": "Testes de estresse proativos e descoberta de vulnerabilidades em LLMs.",
                "strat.dspm.desc": "Proteção do pipeline de dados, descoberta e classificação para RAG.",
                "strat.aispm.desc": "Gestão contínua da postura de segurança e inventário de ativos de IA.",
                "strat.broker.desc": "Detecta e monitora tráfego MCP exposto à internet e aplica controle de acesso.",
                "paradigm.title": "O Novo Paradigma: Interações de IA para IA",
                "paradigm.desc": "Enquanto a IA generativa tradicional se concentra em interações usuário-para-LLM, a IA agêntica introduz comunicações autônomas.",
                "flow.user": "User using GenAI",
                "flow.zt": "Zero Trust Engine",
                "flow.genai": "GenAI Apps",
                "flow.agentic": "IA agêntica using LLMs",
                "flow.gw": "IA GW + Guardrails",
                "flow.llm": "On-prem & Cloud LLMs",
                "zt.title": "Netskope Zero Trust Engine + IA Guardrails",
                "zt.desc": "Extensão do mecanismo Zero Trust para cobrir todo o ciclo de vida da IA.",
                "zt.p1": "Identity<br>Trust",
                "zt.p2": "Device<br>Trust",
                "zt.p3": "Location<br>Trust",
                "zt.p4": "App<br>Trust",
                "zt.context": "New IA Context",
                "zt.p5": "Instance<br>Trust",
                "zt.p6": "Activity<br>Trust",
                "zt.p7": "Behavior<br>Trust",
                "zt.p8": "Data<br>Trust",
                "zt.p9": "IA<br>Comms",
                "zt.outcome": "Policy Decision",
                "zt.result": "Block Upload<br>& Coach the User",
                "cases.badge": "CASOS DE USO CLAVE",
                "cases.title": "Seis Casos de Uso para Proteger a GenAI",
                "cases.desc": "Visibilidade e controle para o uso gerenciado e não gerenciado em toda a organização",
                "case.1.title": "Acesso Seguro a Ferramentas de IA",
                "case.1.desc": "Controle de acesso contextual. Diferencia instâncias pessoais e corporativas para bloquear dados sensíveis em contas não autorizadas.",
                "case.2.title": "Segurança para Apps de IA Próprios",
                "case.2.desc": "Integre o Netskope DLP em aplicações personalizadas. Obtenha um veredito de segurança antes de enviar dados ao LLM para prevenir vazamentos.",
                "case.3.title": "Proteção do Pipeline de Dados",
                "case.3.desc": "Visibilidade de onde os dados de IA vivem e fluem. Descubra e classifique dados sensíveis em datasets de treinamento e RAG com DSPM.",
                "case.4.title": "Segurança nas Interações de Agentes",
                "case.4.desc": "Elimine pontos cegos nas comunicações de IA para IA e serviço-para-serviço. Inspeção de conteúdo para prevenir ataques e vazamentos de dados.",
                "case.5.title": "Proteção contra Ameaças de IA",
                "case.5.desc": "Defesa proativa contra Prompt Injection, Jailbreaking e malware. Red teaming para avaliar a exposição a riscos antes da produção.",
                "case.6.title": "Postura de Segurança e Compliance",
                "case.6.desc": "Inventário contínuo de ativos de IA, identificação de caminhos de ataque e avaliação de privilégios de acesso excessivos.",
                "vis.badge": "VISIBILIDAD AVANZADA",
                "vis.title": "Obtenha Visibilidade Total do Uso de IA",
                "vis.desc": "Identifique quais aplicações de IA são utilizadas em sua organização, quem as usa e com quais dados. Detecte Shadow IA e avalie o risco do uso de instâncias pessoais em comparação com as corporativas.",
                "vis.list.1": "Tendências de uso de Apps de IA e Shadow IA",
                "vis.list.2": "Análise de atividade e instâncias (Pessoal vs Corp)",
                "vis.list.3": "Detecção de violações de DLP e movimentação de dados",
                "vis.btn": "Ver Relatório de Visibilidade"
                // nav_who / nav_back / nav_demo agora vêm de NetskopeCommonI18n
            }
        };

        // changeLanguage(lang) agora é a função compartilhada de assets/js/common.js,
        // que opera sobre o objeto global `translations` definido acima.

        /**
         * initDiagramPreviews()
         * Constrói dinamicamente um modal de "zoom" para pré-visualizar os
         * diagramas de arquitetura (.diagram-preview-trigger) em tamanho grande. É
         * específico desta página: cria seu próprio <div class="diagram-preview-modal">
         * em document.body e define uma função closeModal() LOCAL (de escopo de
         * função, não global) que apenas fecha esse modal dinâmico. Não colide com
         * closeModal/openModal globais de assets/js/common.js.
         *
         * Não recebe parâmetros nem retorna nada; é invocada uma única vez a partir do
         * DOMContentLoaded mais abaixo. Se a página não tiver nenhum
         * .diagram-preview-trigger, não faz nada (early return).
         *
         * @returns {void}
         */
        function initDiagramPreviews() {
            const triggers = document.querySelectorAll('.diagram-preview-trigger');
            if (!triggers.length) return;

            const existingModal = document.querySelector('.diagram-preview-modal');
            if (existingModal) existingModal.remove();

            const modal = document.createElement('div');
            modal.className = 'diagram-preview-modal';
            modal.innerHTML = `
                <div class="diagram-preview-dialog">
                    <button type="button" class="diagram-preview-close" aria-label="Fechar preview">&times;</button>
                    <div class="diagram-preview-body"></div>
                </div>
            `;
            document.body.appendChild(modal);

            const body = modal.querySelector('.diagram-preview-body');
            const closeBtn = modal.querySelector('.diagram-preview-close');

            const closeModal = () => {
                modal.classList.remove('is-open');
                body.innerHTML = '';
                document.body.style.overflow = '';
            };

            triggers.forEach((trigger) => {
                trigger.addEventListener('click', () => {
                    const clone = trigger.cloneNode(true);
                    clone.classList.remove('diagram-preview-trigger');
                    clone.classList.add('diagram-preview-content');
                    body.innerHTML = '';
                    body.appendChild(clone);
                    modal.classList.add('is-open');
                    document.body.style.overflow = 'hidden';
                });
            });

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => {
                if (event.target === modal) closeModal();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
            initDiagramPreviews();
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
