<?php
// aicontrol.php - Demo "Controle de IA generativa" (GenAI). Cobre visibilidade e
// governança de apps de IA generativa do tipo ChatGPT: estatísticas de adoção,
// citações de analistas, coaching de usuário em tempo real (modal) e link para o
// relatório de IA (reportai.php). Parte do fluxo de demo vinculado a partir de index.php.
//
// As funções JS comuns (changeLanguage, openModal/closeModal, área de transferência)
// ficam em assets/js/common.js e os textos i18n compartilhados entre páginas
// ficam em assets/js/i18n-common.js. O dicionário `translations` deste
// arquivo contém apenas strings específicas desta página.
?>
<!DOCTYPE html>
<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Demo sobre descoberta, controle e proteção do uso de IA generativa em ambientes corporativos.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Controle da IA</title>
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
        .quote-icon { position: absolute; top: -20px; left: 20px; width: 40px; height: 40px; background-color: #00A9CE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        /* Modals */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; border-radius: 16px; max-width: 600px; max-height: 90%; overflow: auto; position: relative; margin: 20px; }
        .modal-close { position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.5); color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 1001; font-weight: bold; }
        
        .logo-container { display: flex; align-items: center; gap: 10px; }
        .ai-logo { width: 32px; height: 32px; object-fit: contain; border-radius: 10px; background: #ffffff; padding: 4px; border: 1px solid #e5e7eb; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.08); }

        /* Unified language switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: #081A59; }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.-inset-1{inset:-0.25rem}.inset-0{inset:0px}.-right-20{right:-5rem}.bottom-20{bottom:5rem}.right-0{right:0px}.right-4{right:1rem}.top-0{top:0px}.top-4{top:1rem}.z-10{z-index:10}.z-50{z-index:50}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-10{margin-bottom:2.5rem}.mb-12{margin-bottom:3rem}.mb-16{margin-bottom:4rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.mt-0{margin-top:0px}.mt-0\.5{margin-top:0.125rem}.mt-16{margin-top:4rem}.mt-4{margin-top:1rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-1{height:0.25rem}.h-10{height:2.5rem}.h-12{height:3rem}.h-16{height:4rem}.h-2{height:0.5rem}.h-20{height:5rem}.h-4{height:1rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-8{height:2rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-1\/2{width:50%}.w-10{width:2.5rem}.w-12{width:3rem}.w-2{width:0.5rem}.w-4{width:1rem}.w-5{width:1.25rem}.w-6{width:1.5rem}.w-8{width:2rem}.w-auto{width:auto}.w-full{width:100%}.w-px{width:1px}.max-w-3xl{max-width:48rem}.max-w-5xl{max-width:64rem}.max-w-7xl{max-width:80rem}.flex-1{flex:1 1 0%}.flex-shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}.transform{transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}@keyframes pulse{50%{opacity:.5}}.animate-pulse{animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-1{gap:0.25rem}.gap-12{gap:3rem}.gap-16{gap:4rem}.gap-2{gap:0.5rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.space-y-1 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.25rem * var(--tw-space-y-reverse))}.space-y-2 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.5rem * var(--tw-space-y-reverse))}.space-y-4 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse))}.space-y-6 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded{border-radius:0.25rem}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-netskope{border-radius:24px}.rounded-netskope-sm{border-radius:12px}.rounded-xl{border-radius:0.75rem}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.border{border-width:1px}.border-b{border-bottom-width:1px}.border-t{border-top-width:1px}.border-blue-100{--tw-border-opacity:1;border-color:rgb(219 234 254 / var(--tw-border-opacity, 1))}.border-blue-200{--tw-border-opacity:1;border-color:rgb(191 219 254 / var(--tw-border-opacity, 1))}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-gray-300{--tw-border-opacity:1;border-color:rgb(209 213 219 / var(--tw-border-opacity, 1))}.border-netskope-blue{--tw-border-opacity:1;border-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-red-100{--tw-border-opacity:1;border-color:rgb(254 226 226 / var(--tw-border-opacity, 1))}.border-white\/10{border-color:rgb(255 255 255 / 0.1)}.border-white\/20{border-color:rgb(255 255 255 / 0.2)}.border-white\/50{border-color:rgb(255 255 255 / 0.5)}.bg-blue-100{--tw-bg-opacity:1;background-color:rgb(219 234 254 / var(--tw-bg-opacity, 1))}.bg-blue-50{--tw-bg-opacity:1;background-color:rgb(239 246 255 / var(--tw-bg-opacity, 1))}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-gray-50{--tw-bg-opacity:1;background-color:rgb(249 250 251 / var(--tw-bg-opacity, 1))}.bg-green-100{--tw-bg-opacity:1;background-color:rgb(220 252 231 / var(--tw-bg-opacity, 1))}.bg-green-500{--tw-bg-opacity:1;background-color:rgb(34 197 94 / var(--tw-bg-opacity, 1))}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-blue\/10{background-color:rgb(0 169 206 / 0.1)}.bg-netskope-deepBlue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-netskope-green{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-netskope-green\/20{background-color:rgb(175 241 152 / 0.2)}.bg-netskope-lightBlue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-netskope-orange{--tw-bg-opacity:1;background-color:rgb(255 130 0 / var(--tw-bg-opacity, 1))}.bg-red-100{--tw-bg-opacity:1;background-color:rgb(254 226 226 / var(--tw-bg-opacity, 1))}.bg-red-50\/50{background-color:rgb(254 242 242 / 0.5)}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/20{background-color:rgb(255 255 255 / 0.2)}.bg-white\/60{background-color:rgb(255 255 255 / 0.6)}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-yellow-100{--tw-bg-opacity:1;background-color:rgb(254 249 195 / var(--tw-bg-opacity, 1))}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-neon{background-image:linear-gradient(135deg, #00A9CE 0%, #AFF198 100%)}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-orange{--tw-gradient-from:#FF8200 var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 130 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-purple-500\/10{--tw-gradient-from:rgb(168 85 247 / 0.1) var(--tw-gradient-from-position);--tw-gradient-to:rgb(168 85 247 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-white{--tw-gradient-from:#fff var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-netskope-offWhite{--tw-gradient-to:#F5F5F5 var(--tw-gradient-to-position)}.to-pink-500\/10{--tw-gradient-to:rgb(236 72 153 / 0.1) var(--tw-gradient-to-position)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.to-yellow-500{--tw-gradient-to:#eab308 var(--tw-gradient-to-position)}.p-3{padding:0.75rem}.p-4{padding:1rem}.p-5{padding:1.25rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-8{padding-left:2rem;padding-right:2rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-20{padding-top:5rem;padding-bottom:5rem}.py-3{padding-top:0.75rem;padding-bottom:0.75rem}.py-4{padding-top:1rem;padding-bottom:1rem}.pb-24{padding-bottom:6rem}.pb-4{padding-bottom:1rem}.pl-4{padding-left:1rem}.pt-20{padding-top:5rem}.pt-3{padding-top:0.75rem}.pt-4{padding-top:1rem}.pt-6{padding-top:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-5xl{font-size:3rem;line-height:1}.text-base{font-size:1rem;line-height:1.5rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-medium{font-weight:500}.font-normal{font-weight:400}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.tracking-widest{letter-spacing:0.1em}.text-blue-600{--tw-text-opacity:1;color:rgb(37 99 235 / var(--tw-text-opacity, 1))}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity, 1))}.text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity, 1))}.text-green-600{--tw-text-opacity:1;color:rgb(22 163 74 / var(--tw-text-opacity, 1))}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-darkGray{--tw-text-opacity:1;color:rgb(42 43 45 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-purple-600{--tw-text-opacity:1;color:rgb(147 51 234 / var(--tw-text-opacity, 1))}.text-red-400{--tw-text-opacity:1;color:rgb(248 113 113 / var(--tw-text-opacity, 1))}.text-red-500{--tw-text-opacity:1;color:rgb(239 68 68 / var(--tw-text-opacity, 1))}.text-red-600{--tw-text-opacity:1;color:rgb(220 38 38 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.text-white\/70{color:rgb(255 255 255 / 0.7)}.text-white\/80{color:rgb(255 255 255 / 0.8)}.text-yellow-600{--tw-text-opacity:1;color:rgb(202 138 4 / var(--tw-text-opacity, 1))}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-10{opacity:0.1}.opacity-20{opacity:0.2}.opacity-30{opacity:0.3}.opacity-80{opacity:0.8}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-md{--tw-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.blur{--tw-blur:blur(8px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-blur-sm{--tw-backdrop-blur:blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-colors{transition-property:color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.hover\:-translate-y-1:hover{--tw-translate-y:-0.25rem;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.hover\:bg-gray-50:hover{--tw-bg-opacity:1;background-color:rgb(249 250 251 / var(--tw-bg-opacity, 1))}.hover\:bg-netskope-lightBlue:hover{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.hover\:bg-netskope-teal:hover{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.hover\:bg-white\/15:hover{background-color:rgb(255 255 255 / 0.15)}.hover\:text-netskope-teal:hover{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:opacity-90:hover{opacity:0.9}.hover\:shadow-hover:hover{--tw-shadow:0 20px 50px -10px rgba(0, 169, 206, 0.15);--tw-shadow-colored:0 20px 50px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.hover\:shadow-xl:hover{--tw-shadow:0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}@media (min-width: 768px){.md\:block{display:block}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:gap-24{gap:6rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-7xl{font-size:4.5rem;line-height:1}}@media (min-width: 1024px){.lg\:-mt-6{margin-top:-1.5rem}.lg\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.lg\:grid-cols-4{grid-template-columns:repeat(4, minmax(0, 1fr))}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-site-shell="ready" data-page-name="aicontrol" data-page-kind="story" style="overflow: auto;">
    <!-- Os atributos data-site-shell/data-page-name/data-page-kind e as classes
         site-shell-* são ganchos para o CSS/JS de chrome compartilhado do site
         (assets/vendor/css/site-global.css e assets/vendor/js/site-global.js,
         referenciados no <head>); não afetam o layout por si sós se esses
         assets não estiverem presentes. -->

    <!-- Cabeçalho fixo: logo (link para index.php), tagline da página. -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <div class="flex items-center gap-6">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            </div>

            <div class="flex items-center gap-6 site-shell-toolbar">
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header.tagline">IA Security & Governance</span>
                
            </div>
            
        </div>
    </header>

    <!-- Hero: título/subtítulo da demo de GenAI e cartão com 3 estatísticas de adoção/risco. -->
    <section class="relative bg-white pt-20 pb-24 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-green"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase">SkopeAI</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight" data-i18n="hero.title">Segurança em IA generativa<br><span class="font-lora italic font-normal text-netskope-green">Visibilidade e Controle</span></h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero.impact">60% dos usuários utilizam IA generativa por meio de contas pessoais.<br><strong class="text-netskope-deepBlue font-semibold">Proteja seus dados enquanto adota a GenAI na sua empresa.</strong></p>

                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-green mb-1">90%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="hero.stat1">das empresas têm planos de adoção da GenAI</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">40%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="hero.stat2">das violações serão por mau uso da GenAI</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-deepBlue mb-1">1.800+</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="hero.stat3">apps de IA catalogados no CCI</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg>
        </div>
    </section>

    <!-- Seção de citações de analistas (Gartner) sobre adoção/risco de IA generativa. -->
    <section class="bg-netskope-deepBlue py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="market.tag">Realidade do Mercado</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="market.title">O que dizem os analistas sobre IA generativa</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.1">"Mais de 90% dos responsáveis por tecnologia têm planos concretos para adotar IA generativa."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">State of Generative AI, Gartner Report</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full mt-0 lg:-mt-6">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.2">"Até 2027, mais de 40% das violações de dados serão causadas pelo uso inadequado da IA generativa."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">State of Generative AI, Gartner Report</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.3">"À medida que a adoção se acelera, os ataques que exploram a GenAI para phishing, deepfakes e engenharia social tornaram-se mais comuns..."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estratégia da Netskope: 4 pilares (User Coaching, Visibilidade e Controle,
         Proteção da Informação, CASB API para IA Corporativa). -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="strategy.tag">Estratégia da Netskope</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="strategy.title">Abordagem Integral para a Segurança de IA</h2>
                <p class="text-netskope-lightBlue max-w-3xl mx-auto text-lg" data-i18n="strategy.subtitle">Proteção completa, da visibilidade ao controle granular</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.1.title">User Coaching</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.1.desc">Eduque os usuários em tempo real quando tentam ações de risco:</p>
                    <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.1.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Permite o uso seguro de ferramentas de IA</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Bloqueia ou restringe comportamentos de risco</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Aplica políticas por usuário ou grupo</li></ul>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.2.title">Visibilidade e Controle</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.2.desc">Controle integral do uso de IA generativa:</p>
                    <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.2.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Visibilidade completa do Shadow IA</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Reconhecimento de instâncias pessoais vs corporativas</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Controle granular de atividades dentro de apps</li></ul>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.3.title">Proteção da Informação</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.3.desc">Proteção avançada de dados com IA:</p>
                     <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.3.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Proteção do dado em trânsito para a GenAI</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Mesmos perfis em todos os vetores</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> ML, OCR e Exact Data Match</li></ul>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.4.title">CASB API para IA Corporativa</h3>
                    <p class="text-white/80 text-sm mb-2" data-i18n="strat.4.desc">Proteção de Dados em Repouso, independentemente do dispositivo</p>
                    <div class="logo-container mb-2">
                        <img src="assets/images/external/chatgpt-logo.svg" alt="ChatGPT" class="ai-logo">
                        <span class="text-xs text-white/80">ChatGPT Enterprise</span>
                    </div>
                    <div class="logo-container mb-2">
                        <img src="assets/images/external/microsoft-logo.svg" alt="Microsoft" class="ai-logo">
                        <span class="text-xs text-white/80">Microsoft Copilot</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grade de casos de uso (6 cartões). O primeiro cartão ("User Coaching")
         tem um botão que abre o modal #coaching-modal definido mais abaixo. -->
    <section class="py-20 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="cases.tag">CASOS DE USO PRINCIPALES</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="cases.title">Proteção Integral de IA generativa</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg mb-10" data-i18n="cases.subtitle">Soluções específicas para os desafios de segurança da IA generativa</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col relative">
                    <button type="button" onclick="openModal('coaching-modal')" class="absolute top-4 right-4 text-netskope-blue hover:text-netskope-teal cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </button>
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.1.title">Conscientização com User Coaching</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.1.desc"><strong>Ensinar, não apenas Bloquear:</strong> Eduque os colaboradores em tempo real sobre práticas seguras de IA.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Real-time Education</span></div>
                </div>
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.2.title">Segurança em Gen IA</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.2.desc">Graças ao <strong>Reconhecimento de Instância</strong>, mais de 1.800 aplicações catalogadas no CCI e controle de atividades dentro dos apps.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">App Control</span></div>
                </div>
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.3.title">Proteção do Dado na GenAI</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.3.desc">Proteção por meio de <strong>CASB API</strong> para dados armazenados no ChatGPT Enterprise, Microsoft Copilot e outros.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">CASB API</span></div>
                </div>
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl flex items-center justify-center text-purple-600 mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.4.title">Proteção Unificada</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.4.desc">Mesmos perfis de proteção de dados em todos os vetores: prompts, respostas, arquivos enviados e dados armazenados.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-purple-600 uppercase tracking-wide">Unified Protection</span></div>
                </div>
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.5.title">Descoberta de Shadow IA</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.5.desc">Identifique aplicações de IA não autorizadas e avalie seu risco usando o Cloud Confidence Index (CCI) com mais de 1.800 apps catalogados.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Risk Assessment</span></div>
                </div>
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.6.title">Conformidade e Governança</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.6.desc">Auditoria contínua e controles de conformidade para o uso de IA generativa, garantindo aderência a regulamentações e políticas internas.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Compliance</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Link para o relatório de Shadow IA (reportai.php) + painel "Mapa de Uso de
         Gen IA" com dados de exemplo (departamentos, % de apps não aprovados). -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div>
                    <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="vis.tag">Visibilidade Completa</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="vis.title">Relatório de Visibilidade</h2>
                    <p class="text-lg text-netskope-lightBlue font-light leading-relaxed mb-8" data-i18n="vis.desc">Descubra o estado real do uso de Gen IA na sua organização. Nossa análise oferece uma visão completa de quais ferramentas estão sendo usadas.</p>
                    
                    <div class="space-y-6 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="vis.point1.title">Inventário Completo</h4>
                                <p class="text-sm text-white/80" data-i18n="vis.point1.desc">Identifique todas as aplicações de IA em uso.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="vis.point2.title">Análise de Risco</h4>
                                <p class="text-sm text-white/80" data-i18n="vis.point2.desc">Avalie padrões de uso e riscos específicos por área.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="vis.point3.title">Tendências em Tempo Real</h4>
                                <p class="text-sm text-white/80" data-i18n="vis.point3.desc">Monitoramento contínuo do uso de Gen IA.</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="reportai.php" class="inline-flex items-center gap-3 bg-white text-netskope-deepBlue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span data-i18n="vis.button">Ver Relatório de Shadow IA</span>
                    </a>
                </div>
                 
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-neon rounded-netskope blur opacity-30"></div>
                    <div class="relative bg-white text-netskope-darkGray p-8 rounded-netskope shadow-2xl">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-xl font-bold text-netskope-deepBlue" data-i18n="vis.map.title">Mapa de Uso de Gen IA</h3>
                            <span class="bg-netskope-lightBlue text-netskope-deepBlue px-3 py-1 rounded-full text-xs font-bold uppercase">Multi-departmental</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">M</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue" data-i18n="dept.mkt">Marketing</div>
                                        <div class="text-xs text-gray-500" data-i18n="dept.apps1">15 apps de IA detectados</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-green-600" data-i18n="dept.risk1">72% Alto CCI</div>
                                    <div class="text-xs text-gray-400" data-i18n="dept.level1">Risco Moderado</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-lg bg-red-50/50 border border-red-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">R&amp;D</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue" data-i18n="dept.rd">P&amp;D</div>
                                        <div class="text-xs text-gray-500" data-i18n="dept.apps2">8 apps de IA detectados</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-red-500" data-i18n="dept.risk2">35% Baixo CCI</div>
                                    <div class="text-xs text-red-400" data-i18n="dept.level2">Alto Risco</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">IT</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue" data-i18n="dept.it">Tecnologia</div>
                                        <div class="text-xs text-gray-500" data-i18n="dept.apps3">22 apps de IA detectados</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-green-600" data-i18n="dept.risk3">88% Alto CCI</div>
                                    <div class="text-xs text-gray-400" data-i18n="dept.level3">Baixo Risco</div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold text-gray-500" data-i18n="vis.unapproved">Apps Não Aprovados</span>
                                <span class="text-xs font-bold text-netskope-blue" data-i18n="vis.percent">42% do total</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-netskope-orange h-2 rounded-full" style="width: 42%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Botões de navegação de encerramento da demo (para diferenciais, para a landing, para demos.php). -->
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

    <!-- Modal "User Coaching em Ação": mockup de um popup de coaching em tempo
         real (simula o que um usuário final veria ao tentar colar dados
         sensíveis em uma IA generativa). Abre/fecha com openModal/closeModal
         de assets/js/common.js a partir do botão do cartão "User Coaching". -->
    <div id="coaching-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-close" onclick="closeModal('coaching-modal')">×</div>
            <div class="p-6">
                <h2 class="text-2xl font-bold text-netskope-deepBlue mb-6" data-i18n="modal.title">Exemplo de User Coaching em Ação</h2>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-netskope-blue rounded-lg text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-netskope-deepBlue" data-i18n="modal.sub1">Ensinar, não apenas Bloquear</h3>
                            <p class="text-xs text-netskope-gray" data-i18n="modal.sub1desc">Intervenção educativa em tempo real</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-blue-200 rounded-lg p-5 shadow-md">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <div class="text-base font-bold text-netskope-deepBlue" data-i18n="popup.title">⚠️ Atenção: Dados Sensíveis Detectados</div>
                                <div class="text-xs text-gray-500">Netskope User Coaching</div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <p class="text-sm text-gray-700" data-i18n="popup.msg">Você está tentando colar <strong class="text-red-600">código-fonte interno confidencial</strong> em uma instância pessoal do ChatGPT. Isso viola a política de segurança.</p>
                            
                            <div class="bg-blue-50 p-3 rounded border border-blue-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="text-sm font-medium text-gray-700"><strong data-i18n="popup.alt">Alternativa sugerida:</strong></span>
                                </div>
                                <p class="text-sm text-gray-600 pl-4" data-i18n="popup.altmsg">Use a instância corporativa do <strong>ChatGPT Enterprise</strong>.</p>
                            </div>
                            
                            <div class="flex gap-3 pt-3">
                                <button class="flex-1 bg-white border border-gray-300 text-gray-700 text-sm px-4 py-3 rounded shadow-sm hover:bg-gray-50 transition-colors" data-i18n="popup.btn1">Cancelar Ação</button>
                                <button class="flex-1 bg-netskope-blue text-white text-sm px-4 py-3 rounded shadow-sm hover:bg-netskope-teal transition-colors" data-i18n="popup.btn2">Usar Instância Corporativa</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-netskope-lightBlue p-4 rounded-lg">
                    <h4 class="font-bold text-netskope-deepBlue mb-2" data-i18n="modal.benefit">Benefícios do User Coaching:</h4>
                    <ul class="text-sm text-netskope-gray space-y-2" data-i18n="modal.list"><li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span><strong>Educação em contexto:</strong> Os usuários aprendem no momento exato.</span></li><li class="flex items-start gap-2"><span class="text-netskope-green font-bold">✓</span> <span><strong>Redução de Shadow IA:</strong> Oferece alternativas seguras.</span></li></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé: logo pequeno + texto de direitos reservados (fixo em inglês em ambos os idiomas). -->
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

    <!-- Utilitários JS compartilhados (changeLanguage, openModal/closeModal, área de transferência)
         e dicionário de traduções comum. Devem ser carregados antes do script inline. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header.tagline": "IA Security & Governance",
                "hero.title": "Segurança em IA generativa<br><span class=\"font-lora italic font-normal text-netskope-green\">Visibilidade e Controle</span>",
                "hero.impact": "60% dos usuários utilizam IA generativa por meio de contas pessoais.<br><strong class=\"text-netskope-deepBlue font-semibold\">Proteja seus dados enquanto adota a GenAI na sua empresa.</strong>",
                "hero.stat1": "das empresas têm planos de adoção da GenAI",
                "hero.stat2": "das violações serão por mau uso da GenAI",
                "hero.stat3": "apps de IA catalogados no CCI",
                "market.tag": "Realidade do Mercado",
                "market.title": "O que dizem os analistas sobre IA generativa",
                "quote.1": "\"Mais de 90% dos responsáveis por tecnologia têm planos concretos para adotar IA generativa.\"",
                "quote.2": "\"Até 2027, mais de 40% das violações de dados serão causadas pelo uso inadequado da IA generativa.\"",
                "quote.3": "\"À medida que a adoção se acelera, os ataques que exploram a GenAI para phishing, deepfakes e engenharia social tornaram-se mais comuns...\"",
                "strategy.tag": "Estratégia da Netskope",
                "strategy.title": "Abordagem Integral para a Segurança de IA",
                "strategy.subtitle": "Proteção completa, da visibilidade ao controle granular",
                "strat.1.title": "User Coaching",
                "strat.1.desc": "Eduque os usuários em tempo real quando tentam ações de risco:",
                "strat.1.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Permite o uso seguro de ferramentas de IA</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Bloqueia ou restringe comportamentos de risco</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Aplica políticas por usuário ou grupo</li>",
                "strat.2.title": "Visibilidade e Controle",
                "strat.2.desc": "Controle integral do uso de IA generativa:",
                "strat.2.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Visibilidade completa do Shadow IA</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Reconhecimento de instâncias pessoais vs corporativas</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Controle granular de atividades dentro de apps</li>",
                "strat.3.title": "Proteção da Informação",
                "strat.3.desc": "Proteção avançada de dados com IA:",
                "strat.3.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Proteção do dado em trânsito para a GenAI</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Mesmos perfis em todos os vetores</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> ML, OCR e Exact Data Match</li>",
                "strat.4.title": "CASB API para IA Corporativa",
                "strat.4.desc": "Proteção de Dados em Repouso, independentemente do dispositivo",
                "cases.tag": "CASOS DE USO PRINCIPALES",
                "cases.title": "Proteção Integral de IA generativa",
                "cases.subtitle": "Soluções específicas para os desafios de segurança da IA generativa",
                "case.1.title": "Conscientização com User Coaching",
                "case.1.desc": "<strong>Ensinar, não apenas Bloquear:</strong> Eduque os colaboradores em tempo real sobre práticas seguras de IA.",
                "case.2.title": "Segurança em Gen IA",
                "case.2.desc": "Graças ao <strong>Reconhecimento de Instância</strong>, mais de 1.800 aplicações catalogadas no CCI e controle de atividades dentro dos apps.",
                "case.3.title": "Proteção do Dado na GenAI",
                "case.3.desc": "Proteção por meio de <strong>CASB API</strong> para dados armazenados no ChatGPT Enterprise, Microsoft Copilot e outros.",
                "case.4.title": "Proteção Unificada",
                "case.4.desc": "Mesmos perfis de proteção de dados em todos os vetores: prompts, respostas, arquivos enviados e dados armazenados.",
                "case.5.title": "Descoberta de Shadow IA",
                "case.5.desc": "Identifique aplicações de IA não autorizadas e avalie seu risco usando o Cloud Confidence Index (CCI) com mais de 1.800 apps catalogados.",
                "case.6.title": "Conformidade e Governança",
                "case.6.desc": "Auditoria contínua e controles de conformidade para o uso de IA generativa, garantindo aderência a regulamentações e políticas internas.",
                "vis.tag": "Visibilidade Completa",
                "vis.title": "Relatório de Visibilidade",
                "vis.desc": "Descubra o estado real do uso de Gen IA na sua organização. Nossa análise oferece uma visão completa de quais ferramentas estão sendo usadas.",
                "vis.point1.title": "Inventário Completo",
                "vis.point1.desc": "Identifique todas as aplicações de IA em uso.",
                "vis.point2.title": "Análise de Risco",
                "vis.point2.desc": "Avalie padrões de uso e riscos específicos por área.",
                "vis.point3.title": "Tendências em Tempo Real",
                "vis.point3.desc": "Monitoramento contínuo do uso de Gen IA.",
                "vis.button": "Ver Relatório de Shadow IA",
                "vis.map.title": "Mapa de Uso de Gen IA",
                "dept.mkt": "Marketing",
                "dept.apps1": "15 apps de IA detectados",
                "dept.risk1": "72% Alto CCI",
                "dept.level1": "Risco Moderado",
                "dept.rd": "P&D",
                "dept.apps2": "8 apps de IA detectados",
                "dept.risk2": "35% Baixo CCI",
                "dept.level2": "Alto Risco",
                "dept.it": "Tecnologia",
                "dept.apps3": "22 apps de IA detectados",
                "dept.risk3": "88% Alto CCI",
                "dept.level3": "Baixo Risco",
                "vis.unapproved": "Apps Não Aprovados",
                "vis.percent": "42% do total",
                // nav_who / nav_back / nav_demo agora vêm de NetskopeCommonI18n
                "modal.title": "Exemplo de User Coaching em Ação",
                "modal.sub1": "Ensinar, não apenas Bloquear",
                "modal.sub1desc": "Intervenção educativa em tempo real",
                "popup.title": "⚠️ Atenção: Dados Sensíveis Detectados",
                "popup.msg": "Você está tentando colar <strong class=\"text-red-600\">código-fonte interno confidencial</strong> em uma instância pessoal do ChatGPT. Isso viola a política de segurança.",
                "popup.alt": "Alternativa sugerida:",
                "popup.altmsg": "Use a instância corporativa do <strong>ChatGPT Enterprise</strong>.",
                "popup.btn1": "Cancelar Ação",
                "popup.btn2": "Usar Instância Corporativa",
                "modal.benefit": "Benefícios do User Coaching:",
                "modal.list": "<li class=\"flex items-start gap-2\"><span class=\"text-netskope-green font-bold\">✓</span> <span><strong>Educação em contexto:</strong> Os usuários aprendem no momento exato.</span></li><li class=\"flex items-start gap-2\"><span class=\"text-netskope-green font-bold\">✓</span> <span><strong>Redução de Shadow IA:</strong> Oferece alternativas seguras.</span></li>"
            }
        };

        // changeLanguage(lang), openModal(modalId) e closeModal(modalId) agora ficam
        // em assets/js/common.js (implementações idênticas às que havia aqui).

        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar idioma
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');

            // Listeners do modal
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay').forEach(modal => {
                        modal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    });
                }
            });
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
