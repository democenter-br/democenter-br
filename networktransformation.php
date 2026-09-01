<?php
// networktransformation.php - Demo "Transformación de la Red" (Single Vendor
// SASE / SD-WAN). Cubre priorización de tráfico, DEM (Digital Experience
// Monitoring, con modal de imagen ampliable) y resultados de negocio. Parte
// del flujo de demo enlazado desde index.php.
//
// Las funciones JS comunes (changeLanguage, closeModal, etc.) viven en
// assets/js/common.js y los textos i18n compartidos entre páginas viven en
// assets/js/i18n-common.js. El diccionario `translations` de este archivo solo
// contiene cadenas específicas de esta página.
?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Narrativa comercial sobre modernización de red y seguridad convergente con Netskope One.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Transformación de la Red</title>
    <link href="assets/vendor/css/offline-fonts.css" rel="stylesheet">
    <link href="assets/vendor/css/site-global.css" rel="stylesheet">
    <script src="assets/vendor/js/site-global.js"></script>
    <script src="assets/vendor/js/tailwindcss-cdn.js"></script>
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
        
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; border-radius: 16px; max-width: 600px; max-height: 90%; overflow: auto; position: relative; margin: 20px; }
        .modal-close { position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.5); color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 1001; font-weight: bold; }
        .image-modal-content { max-width: 90%; max-height: 90%; width: auto; height: auto; }
        .image-modal-content img { width: 100%; height: auto; border-radius: 12px; }
        
        .timeline-item { position: relative; padding-left: 40px; margin-bottom: 30px; }
        .timeline-dot { position: absolute; left: 0; top: 0; width: 24px; height: 24px; border-radius: 50%; background: #00A9CE; border: 4px solid white; box-shadow: 0 0 0 4px #D9FAFF; }
        .timeline-line { position: absolute; left: 11px; top: 24px; width: 2px; height: calc(100% + 30px); background: #00A9CE; opacity: 0.3; }
        .timeline-item:last-child .timeline-line { display: none; }

        /* Unified language switcher */
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: #081A59; }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.-inset-1{inset:-0.25rem}.inset-0{inset:0px}.-right-20{right:-5rem}.bottom-20{bottom:5rem}.right-0{right:0px}.top-0{top:0px}.z-10{z-index:10}.z-50{z-index:50}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-10{margin-bottom:2.5rem}.mb-12{margin-bottom:3rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.mt-16{margin-top:4rem}.mt-auto{margin-top:auto}.inline-block{display:inline-block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-1{height:0.25rem}.h-12{height:3rem}.h-16{height:4rem}.h-2{height:0.5rem}.h-20{height:5rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-8{height:2rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-1\/2{width:50%}.w-12{width:3rem}.w-5{width:1.25rem}.w-6{width:1.5rem}.w-8{width:2rem}.w-auto{width:auto}.w-full{width:100%}.w-px{width:1px}.max-w-3xl{max-width:48rem}.max-w-4xl{max-width:56rem}.max-w-5xl{max-width:64rem}.max-w-7xl{max-width:80rem}.max-w-\[200px\]{max-width:200px}.flex-shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}@keyframes pulse{50%{opacity:.5}}.animate-pulse{animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-12{gap:3rem}.gap-2{gap:0.5rem}.gap-24{gap:6rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.space-y-3 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.75rem * var(--tw-space-y-reverse))}.space-y-4 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse))}.space-y-6 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-netskope{border-radius:24px}.rounded-netskope-sm{border-radius:12px}.rounded-xl{border-radius:0.75rem}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.border{border-width:1px}.border-2{border-width:2px}.border-b{border-bottom-width:1px}.border-t{border-top-width:1px}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-green-100{--tw-border-opacity:1;border-color:rgb(220 252 231 / var(--tw-border-opacity, 1))}.border-netskope-blue{--tw-border-opacity:1;border-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-netskope-green\/20{border-color:rgb(175 241 152 / 0.2)}.border-netskope-green\/30{border-color:rgb(175 241 152 / 0.3)}.border-white\/10{border-color:rgb(255 255 255 / 0.1)}.border-white\/20{border-color:rgb(255 255 255 / 0.2)}.border-white\/50{border-color:rgb(255 255 255 / 0.5)}.bg-blue-100{--tw-bg-opacity:1;background-color:rgb(219 234 254 / var(--tw-bg-opacity, 1))}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-gray-50{--tw-bg-opacity:1;background-color:rgb(249 250 251 / var(--tw-bg-opacity, 1))}.bg-green-100{--tw-bg-opacity:1;background-color:rgb(220 252 231 / var(--tw-bg-opacity, 1))}.bg-green-50\/50{background-color:rgb(240 253 244 / 0.5)}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-blue\/10{background-color:rgb(0 169 206 / 0.1)}.bg-netskope-deepBlue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-netskope-green{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-netskope-green\/10{background-color:rgb(175 241 152 / 0.1)}.bg-netskope-green\/20{background-color:rgb(175 241 152 / 0.2)}.bg-netskope-lightBlue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-netskope-offWhite{--tw-bg-opacity:1;background-color:rgb(245 245 245 / var(--tw-bg-opacity, 1))}.bg-orange-100{--tw-bg-opacity:1;background-color:rgb(255 237 213 / var(--tw-bg-opacity, 1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/20{background-color:rgb(255 255 255 / 0.2)}.bg-white\/60{background-color:rgb(255 255 255 / 0.6)}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-neon{background-image:linear-gradient(135deg, #00A9CE 0%, #AFF198 100%)}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-orange{--tw-gradient-from:#FF8200 var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 130 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-purple-500\/10{--tw-gradient-from:rgb(168 85 247 / 0.1) var(--tw-gradient-from-position);--tw-gradient-to:rgb(168 85 247 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-white{--tw-gradient-from:#fff var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-netskope-offWhite{--tw-gradient-to:#F5F5F5 var(--tw-gradient-to-position)}.to-pink-500\/10{--tw-gradient-to:rgb(236 72 153 / 0.1) var(--tw-gradient-to-position)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.to-yellow-500{--tw-gradient-to:#eab308 var(--tw-gradient-to-position)}.p-3{padding:0.75rem}.p-4{padding:1rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-8{padding-left:2rem;padding-right:2rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-2{padding-top:0.5rem;padding-bottom:0.5rem}.py-20{padding-top:5rem;padding-bottom:5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.pb-24{padding-bottom:6rem}.pb-4{padding-bottom:1rem}.pt-20{padding-top:5rem}.pt-4{padding-top:1rem}.text-center{text-align:center}.text-right{text-align:right}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-4xl{font-size:2.25rem;line-height:2.5rem}.text-5xl{font-size:3rem;line-height:1}.text-base{font-size:1rem;line-height:1.5rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-medium{font-weight:500}.font-normal{font-weight:400}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.tracking-widest{letter-spacing:0.1em}.text-blue-600{--tw-text-opacity:1;color:rgb(37 99 235 / var(--tw-text-opacity, 1))}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-green-600{--tw-text-opacity:1;color:rgb(22 163 74 / var(--tw-text-opacity, 1))}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-darkGray{--tw-text-opacity:1;color:rgb(42 43 45 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-orange-600{--tw-text-opacity:1;color:rgb(234 88 12 / var(--tw-text-opacity, 1))}.text-purple-600{--tw-text-opacity:1;color:rgb(147 51 234 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.text-white\/50{color:rgb(255 255 255 / 0.5)}.text-white\/70{color:rgb(255 255 255 / 0.7)}.text-white\/80{color:rgb(255 255 255 / 0.8)}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-10{opacity:0.1}.opacity-20{opacity:0.2}.opacity-30{opacity:0.3}.opacity-80{opacity:0.8}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-blur-sm{--tw-backdrop-blur:blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.hover\:bg-netskope-lightBlue:hover{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.hover\:bg-netskope-teal:hover{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.hover\:bg-white\/15:hover{background-color:rgb(255 255 255 / 0.15)}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:opacity-90:hover{opacity:0.9}.hover\:shadow-hover:hover{--tw-shadow:0 20px 50px -10px rgba(0, 169, 206, 0.15);--tw-shadow-colored:0 20px 50px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}@media (min-width: 768px){.md\:block{display:block}.md\:flex{display:flex}.md\:w-1\/3{width:33.333333%}.md\:w-2\/3{width:66.666667%}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:items-center{align-items:center}.md\:gap-24{gap:6rem}.md\:gap-6{gap:1.5rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-7xl{font-size:4.5rem;line-height:1}}@media (min-width: 1024px){.lg\:-mt-6{margin-top:-1.5rem}.lg\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-site-shell="ready" data-page-name="networktransformation" data-page-kind="story">

   <!-- Header: logo (link a index.php) + tagline (misma estructura site-shell-* que agenticai.php). -->
   <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6 site-shell-toolbar">
                <div class="hidden md:flex items-center">
                    <span class="text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header.tagline">Single Vendor SASE & Network Transformation</span>
                </div>

            </div>
        </div>
    </header>

    <!-- Hero Section: título, descripción y bloque de estadísticas de mercado. -->
    <section class="relative bg-white pt-20 pb-24 overflow-hidden">
        <div class="plus-pattern"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-bl from-netskope-lightBlue/50 to-transparent rounded-bl-[100px]"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-3 mb-8">
                    <span class="w-8 h-1 bg-netskope-green"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase">Netskope One SASE</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight" data-i18n="hero.title">Transformación de Red<br><span class="font-lora italic font-normal text-netskope-green">Single Vendor SASE</span></h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12" data-i18n="hero.desc">Por qué cada vez más empresas transforman su red con Single Vendor SASE<br><strong class="text-netskope-deepBlue font-semibold">Consolida, simplifica y transforma tu infraestructura de red.</strong></p>

                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-green mb-1">70%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.1">de compras SD-WAN serán Single Vendor SASE en 2028</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-blue mb-1">50%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.2">nuevos implementaciones SASE serán Single Vendor en 2028</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-netskope-deepBlue mb-1">80%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat.3">reducción tiempo troubleshooting</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path></svg>
        </div>
    </section>

    <!-- Market Reality Section: citas de analistas (Gartner, Forrester) sobre Single Vendor SASE. -->
    <section class="bg-netskope-deepBlue py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-24">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="market.tag">Realidad del Mercado</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="market.title">Lo que dicen los analistas sobre Single Vendor SASE</h2>
            </div>

            <!-- !important en margin-top/padding-top: el título de arriba ya tiene mb-24 (3rem) vía
                 Tailwind, pero se necesitaba separación adicional entre el título y esta grilla de
                 citas; se forzó inline con !important para no arriesgarse a que utilidades Tailwind
                 de mayor especificidad (o el orden de las clases del <style> minificado más abajo)
                 lo terminen anulando. -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" style="margin-top: 6rem !important; padding-top: 2rem !important;">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.1">"Para 2028, el 70% de las compras de SD-WAN formarán parte de una oferta de plataforma SASE de un solo proveedor, frente al 25% en 2025."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner Prediction</p>
                        <p class="text-white/70 text-xs" data-i18n="quote.sub1">Tendencias del mercado SASE</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.2">"Para 2028, el 50% de los nuevos implementaciones de SASE se basarán en una oferta de plataforma SASE de un solo proveedor, frente al 30% en 2025."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner Prediction</p>
                        <p class="text-white/70 text-xs" data-i18n="quote.sub2">Evolución de arquitecturas SASE</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote.3">"Las organizaciones buscan plataformas SASE de un solo proveedor para reducir la complejidad, mejorar la experiencia del usuario y consolidar la gestión."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Forrester Wave for SASE Solutions 2025</p>
                        <p class="text-white/70 text-xs" data-i18n="quote.sub3">Netskope nombrado Líder</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Evolution Timeline Section: línea de tiempo MPLS -> SD-WAN -> Single Vendor SASE. -->
    <section class="py-20 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-24">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="evo.tag">EVOLUCIÓN DE LA CONECTIVIDAD</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="evo.title">Del MPLS a Single Vendor SASE</h2>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <div class="timeline-item" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
                        <div class="timeline-dot"></div>
                        <div class="timeline-line"></div>
                        <div class="bg-white p-8 rounded-netskope shadow-soft">
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <div class="md:w-1/3">
                                    <div class="bg-netskope-deepBlue text-white px-4 py-2 rounded-full inline-block mb-3">
                                        <span class="text-xs font-bold uppercase">2000s</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-2" data-i18n="evo.1.title">MPLS - Conectividad Hub-and-Spoke</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <p class="text-netskope-gray mb-4" data-i18n="evo.1.desc"><strong>Topologías simples y estáticas:</strong> Conexión de sedes individuales a centros de datos corporativos. Enlaces privados, complejos de escalar y con poca flexibilidad para la nube.</p>
                                    <div class="bg-netskope-offWhite p-4 rounded-lg">
                                        <p class="text-sm text-netskope-gray font-medium" data-i18n="evo.1.bad">🚫 Complejidad en expansión<br>🚫 Sin optimización para nube</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
                        <div class="timeline-dot"></div>
                        <div class="timeline-line"></div>
                        <div class="bg-white p-8 rounded-netskope shadow-soft">
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <div class="md:w-1/3">
                                    <div class="bg-netskope-blue text-white px-4 py-2 rounded-full inline-block mb-3">
                                        <span class="text-xs font-bold uppercase">2010s</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-2">SD-WAN - SDN</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <p class="text-netskope-gray mb-4" data-i18n="evo.2.desc"><strong>Conexión one-to-many:</strong> Sedes conectadas a nubes públicas y privadas. Reduce complejidad con internet, pero carece de seguridad integrada y visibilidad en aplicaciones SaaS.</p>
                                    <div class="bg-netskope-offWhite p-4 rounded-lg">
                                        <p class="text-sm text-netskope-gray font-medium" data-i18n="evo.2.bad">⚠️ Múltiples appliances en sede<br>⚠️ Seguridad desacoplada<br>⚠️ Visibilidad limitada de SaaS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
                        <div class="timeline-dot bg-netskope-green"></div>
                        <div class="timeline-line"></div>
                        <div class="bg-white p-8 rounded-netskope shadow-soft border-2 border-netskope-green/30">
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <div class="md:w-1/3">
                                    <div class="bg-netskope-green text-netskope-deepBlue px-4 py-2 rounded-full inline-block mb-3">
                                        <span class="text-xs font-bold uppercase" data-i18n="evo.3.badge">2020s - Presente</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-2">Single Vendor SASE</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <p class="text-netskope-gray mb-4" data-i18n="evo.3.desc"><strong>Conexión many-to-many:</strong> Interconexión de hogares, máquinas, sedes y nubes con redes y seguridad. Arquitectura unificada con política única, console única y experiencia de usuario consistente.</p>
                                    <div class="bg-netskope-green/10 p-4 rounded-lg border border-netskope-green/20">
                                        <p class="text-sm text-netskope-gray font-medium" data-i18n="evo.3.good">✅ Console única de gestión<br>✅ Políticas consistentes en todos los entornos<br>✅ Experiencia de usuario optimizada</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STRATEGY SECTION: los 3 pilares de Netskope One SASE (Arquitectura Unificada,
         SASE contextual y NewEdge Global Network). -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="strat.tag">Estrategia de Netskope</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="strat.title">Netskope One: Plataforma SASE de Un Solo Proveedor</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.1.title">Arquitectura Unificada</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.1.desc">Una plataforma construida desde cero, no una integración de productos dispares:</p>
                    <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.1.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Motor de políticas único para red y seguridad</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Console única de gestión</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Cliente unificado para todos los escenarios</li></ul>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.2.title">SASE que usa el contexto</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.2.desc">Inteligencia compartida entre SD-WAN y SSE:</p>
                    <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.2.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Monitoreo de enlaces en tiempo real</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Priorización automática de 85k+ aplicaciones</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> Priorización del tráfico en base al contexto</li></ul>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h3 class="text-lg font-bold mb-3" data-i18n="strat.3.title">NewEdge Global Network</h3>
                    <p class="text-white/80 text-sm mb-3" data-i18n="strat.3.desc">Red global construida para SASE sin compromisos de rendimiento:</p>
                    <ul class="text-white/70 text-xs space-y-1" data-i18n="strat.3.list"><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> 79+ regiones globales con computación completa</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> 10K+ adyacencias de red</li><li class="flex items-start gap-1"><span class="text-netskope-green text-xs">✓</span> 5-9s SLA de disponibilidad</li></ul>
                </div>
            </div>
        </div>
    </section>

    <!-- USE CASES SECTION: 6 tarjetas de casos de uso. La tarjeta 5 (DEM & Troubleshooting)
         incluye el botón de lupa que abre el modal de imagen #dem-image-modal (más abajo). -->
    <section class="py-20 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="cases.tag">CASOS DE USO PRINCIPALES</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="cases.title">Transformación de Red con Single Vendor SASE</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col relative">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.1.title">Transformación de Sedes</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.1.desc">Reemplaza routers y múltiples appliances con un único SASE Gateway que ofrece SD-WAN, firewall, SWG y optimización en un solo dispositivo.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Consolidación</span></div>
                </div>
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.2.title">Optimización SaaS & UCaaS</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.2.desc">Asegura la experiencia de los usuarios para aplicaciones críticas como Zoom, Teams y Office 365, incluso sobre enlaces domésticos o celulares.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">App Performance</span></div>
                </div>
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.3.title">Seguridad IoT/OT</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.3.desc">Descubrimiento y clasificación automática de dispositivos IoT/OT, con segmentación dinámica y control de acceso para reducir superficie de ataque.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Device Intelligence</span></div>
                </div>
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl flex items-center justify-center text-purple-600 mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.4.title">WAN como Servicio</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.4.desc">Modelo de consumo flexible que elimina la complejidad de gestionar infraestructura propia, reduciendo TCO frente a soluciones DIY (Do It Yourself).</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-purple-600 uppercase tracking-wide">OpEx Model</span></div>
                </div>
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <!-- Botón de lupa: abre #dem-image-modal vía openImageModal() (alias local que delega en openModal() de common.js). -->
                    <button type="button" onclick="openImageModal('dem-image-modal')" class="absolute top-4 right-4 text-netskope-blue hover:text-netskope-teal cursor-pointer"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></button>
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.5.title">DEM & Troubleshooting</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.5.desc">Monitoreo de experiencia digital (DEM) integrado para visibilidad hop-by-hop y mejora de los tiempos de resolución de problemas, reduciendo tiempo de troubleshooting en 80%.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">AI Ops</span></div>
                </div>
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4 4 0 003 15z"></path></svg></div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="case.6.title">Networking Multi-Cloud</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="case.6.desc">Conexión segura y optimizada entre cargas de trabajo en AWS, Azure, GCP y centros de datos privados, con automatización que reduce tiempos de implementación de meses a días.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Cloud Automation</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact/Results Section: casos reales de clientes con métricas de impacto + panel resumen de resultados. -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="impact.tag">Impacto Cliente</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="impact.title">Resultados con Netskope One SASE</h2>
                    <p class="text-lg text-netskope-lightBlue font-light leading-relaxed mb-8" data-i18n="impact.desc">Empresas líderes transforman sus redes con la plataforma SASE de Netskope, logrando resultados medibles en productividad, seguridad y eficiencia operativa.</p>
                    <div class="space-y-6 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="impact.1.title">80% Reducción en Tiempo de Troubleshooting</h4>
                                <p class="text-sm text-white/80" data-i18n="impact.1.desc">Uno de los mayores distribuidores mayoristas de materiales para techos en Norteamérica (>1,000 ubicaciones)</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="impact.2.title">50% Reducción en TCO</h4>
                                <p class="text-sm text-white/80" data-i18n="impact.2.desc">Minorista global de viajes operando en aeropuertos, líneas de cruceros y centros de viaje (>5,000 ubicaciones)</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                            <div>
                                <h4 class="font-bold text-lg mb-1" data-i18n="impact.3.title">$2.6M Ahorrados con WAN as a Service</h4>
                                <p class="text-sm text-white/80" data-i18n="impact.3.desc">Líder tecnológico en préstamos hipotecarios (>200 ubicaciones y >4,000 usuarios)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-neon rounded-netskope blur opacity-30"></div>
                    <div class="relative bg-white text-netskope-darkGray p-8 rounded-netskope shadow-2xl">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-xl font-bold text-netskope-deepBlue" data-i18n="res.title">Resultados Clave</h3>
                            <span class="bg-netskope-lightBlue text-netskope-deepBlue px-3 py-1 rounded-full text-xs font-bold uppercase">Multi-industry</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">T</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue" data-i18n="res.1.label">Tiempo Troubleshooting</div>
                                        <div class="text-xs text-gray-500" data-i18n="res.1.sub">Reducción promedio</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-green-600">-80%</div>
                                    <div class="text-xs text-gray-400" data-i18n="res.high">Impacto Alto</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-green-50/50 border border-green-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">$</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue" data-i18n="res.2.label">Reducción TCO</div>
                                        <div class="text-xs text-gray-500" data-i18n="res.2.sub">Consolidación productos</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-green-600">-50%</div>
                                    <div class="text-xs text-green-400" data-i18n="res.crit">Impacto Crítico</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">I</div>
                                    <div>
                                        <div class="text-sm font-bold text-netskope-deepBlue">IoT Visibility</div>
                                        <div class="text-xs text-gray-500" data-i18n="res.3.sub">Dispositivos descubiertos</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-green-600">+40%</div>
                                    <div class="text-xs text-gray-400" data-i18n="res.risk">Reducción riesgo</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold text-gray-500" data-i18n="res.roi">ROI en 3 años</span>
                                <span class="text-xs font-bold text-netskope-blue">&gt;100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-netskope-green h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Buttons: cierre de flujo hacia keydifferentiators.php / index.php / demos.php. -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center">
                <div class="flex flex-col md:flex-row justify-center gap-6">
                    <a href="keydifferentiators.php" class="bg-netskope-blue text-white px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-teal transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span data-i18n="nav_who">¿Quién es Netskope?</span>
                    </a>

                    <a href="index.php" class="bg-white text-netskope-deepBlue border border-netskope-blue px-8 py-4 rounded-netskope-sm font-bold hover:bg-netskope-lightBlue transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span data-i18n="nav_back">Volver a la landing</span>
                    </a>

                    <a href="demos.php" class="bg-gradient-to-r from-netskope-orange to-yellow-500 text-white px-8 py-4 rounded-netskope-sm font-bold hover:opacity-90 transition-all shadow-soft hover:shadow-hover flex items-center justify-center gap-3 animate-pulse">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span data-i18n="nav_demo">¿Quieres Verlo? 😉</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- DEM Image Modal: se abre desde el botón de lupa de la tarjeta "DEM & Troubleshooting"
         de arriba; cierra con closeModal(), la función compartida de assets/js/common.js. -->
    <div id="dem-image-modal" class="modal-overlay">
        <div class="modal-content image-modal-content">
            <div class="modal-close" onclick="closeModal('dem-image-modal')">×</div>
            <div class="p-4">
                <h3 class="text-xl font-bold text-netskope-deepBlue mb-4">DEM (Digital Experience Monitoring)</h3>
                <img src="assets/images/external/dem-digital-experience.png" alt="DEM - Digital Experience Monitoring" class="w-full h-auto rounded-lg">
                <p class="text-sm text-netskope-gray mt-4" data-i18n="modal.desc">Monitoreo de experiencia digital integrada para visibilidad completa del rendimiento de aplicaciones y red.</p>
            </div>
        </div>
    </div>

    <!-- Footer: logo pequeño + texto de derechos reservados (hardcodeado en inglés). -->
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

    <!-- Utilidades JS compartidas (changeLanguage, closeModal, etc.) y diccionario
         de traducciones común. Deben cargarse antes del script inline de abajo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <script>
        // Diccionario específico de esta página, fusionado con NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header.tagline": "Single Vendor SASE & Network Transformation",
                "hero.title": "Transformación de Red<br><span class=\"font-lora italic font-normal text-netskope-green\">Single Vendor SASE</span>",
                "hero.desc": "Por qué cada vez más empresas transforman su red con Single Vendor SASE<br><strong class=\"text-netskope-deepBlue font-semibold\">Consolida, simplifica y transforma tu infraestructura de red.</strong>",
                "stat.1": "de compras SD-WAN serán Single Vendor SASE en 2028",
                "stat.2": "nuevos implementaciones SASE serán Single Vendor en 2028",
                "stat.3": "reducción tiempo troubleshooting",
                "market.tag": "Realidad del Mercado",
                "market.title": "Lo que dicen los analistas sobre Single Vendor SASE",
                "quote.1": "\"Para 2028, el 70% de las compras de SD-WAN formarán parte de una oferta de plataforma SASE de un solo proveedor, frente al 25% en 2025.\"",
                "quote.sub1": "Tendencias del mercado SASE",
                "quote.2": "\"Para 2028, el 50% de los nuevos implementaciones de SASE se basarán en una oferta de plataforma SASE de un solo proveedor, frente al 30% en 2025.\"",
                "quote.sub2": "Evolución de arquitecturas SASE",
                "quote.3": "\"Las organizaciones buscan plataformas SASE de un solo proveedor para reducir la complejidad, mejorar la experiencia del usuario y consolidar la gestión.\"",
                "quote.sub3": "Netskope nombrado Líder",
                "evo.tag": "EVOLUCIÓN DE LA CONECTIVIDAD",
                "evo.title": "Del MPLS a Single Vendor SASE",
                "evo.1.title": "MPLS - Conectividad Hub-and-Spoke",
                "evo.1.desc": "<strong>Topologías simples y estáticas:</strong> Conexión de sedes individuales a centros de datos corporativos. Enlaces privados, complejos de escalar y con poca flexibilidad para la nube.",
                "evo.1.bad": "🚫 Complejidad en expansión<br>🚫 Sin optimización para nube",
                "evo.2.desc": "<strong>Conexión one-to-many:</strong> Sedes conectadas a nubes públicas y privadas. Reduce complejidad con internet, pero carece de seguridad integrada y visibilidad en aplicaciones SaaS.",
                "evo.2.bad": "⚠️ Múltiples appliances en sede<br>⚠️ Seguridad desacoplada<br>⚠️ Visibilidad limitada de SaaS",
                "evo.3.badge": "2020s - Presente",
                "evo.3.desc": "<strong>Conexión many-to-many:</strong> Interconexión de hogares, máquinas, sedes y nubes con redes y seguridad. Arquitectura unificada con política única, console única y experiencia de usuario consistente.",
                "evo.3.good": "✅ Console única de gestión<br>✅ Políticas consistentes en todos los entornos<br>✅ Experiencia de usuario optimizada",
                "strat.tag": "Estrategia de Netskope",
                "strat.title": "Netskope One: Plataforma SASE de Un Solo Proveedor",
                "strat.1.title": "Arquitectura Unificada",
                "strat.1.desc": "Una plataforma construida desde cero, no una integración de productos dispares:",
                "strat.1.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Motor de políticas único para red y seguridad</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Console única de gestión</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Cliente unificado para todos los escenarios</li>",
                "strat.2.title": "SASE que usa el contexto",
                "strat.2.desc": "Inteligencia compartida entre SD-WAN y SSE:",
                "strat.2.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Monitoreo de enlaces en tiempo real</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Priorización automática de 85k+ aplicaciones</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> Priorización del tráfico en base al contexto</li>",
                "strat.3.title": "NewEdge Global Network",
                "strat.3.desc": "Red global construida para SASE sin compromisos de rendimiento:",
                "strat.3.list": "<li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> 79+ regiones globales con computación completa</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> 10K+ adyacencias de red</li><li class=\"flex items-start gap-1\"><span class=\"text-netskope-green text-xs\">✓</span> 5-9s SLA de disponibilidad</li>",
                "cases.tag": "CASOS DE USO PRINCIPALES",
                "cases.title": "Transformación de Red con Single Vendor SASE",
                "case.1.title": "Transformación de Sedes",
                "case.1.desc": "Reemplaza routers y múltiples appliances con un único SASE Gateway que ofrece SD-WAN, firewall, SWG y optimización en un solo dispositivo.",
                "case.2.title": "Optimización SaaS & UCaaS",
                "case.2.desc": "Asegura la experiencia de los usuarios para aplicaciones críticas como Zoom, Teams y Office 365, incluso sobre enlaces domésticos o celulares.",
                "case.3.title": "Seguridad IoT/OT",
                "case.3.desc": "Descubrimiento y clasificación automática de dispositivos IoT/OT, con segmentación dinámica y control de acceso para reducir superficie de ataque.",
                "case.4.title": "WAN como Servicio",
                "case.4.desc": "Modelo de consumo flexible que elimina la complejidad de gestionar infraestructura propia, reduciendo TCO frente a soluciones DIY (Do It Yourself).",
                "case.5.title": "DEM & Troubleshooting",
                "case.5.desc": "Monitoreo de experiencia digital (DEM) integrado para visibilidad hop-by-hop y mejora de los tiempos de resolución de problemas, reduciendo tiempo de troubleshooting en 80%.",
                "case.6.title": "Networking Multi-Cloud",
                "case.6.desc": "Conexión segura y optimizada entre cargas de trabajo en AWS, Azure, GCP y centros de datos privados, con automatización que reduce tiempos de implementación de meses a días.",
                "impact.tag": "Impacto Cliente",
                "impact.title": "Resultados con Netskope One SASE",
                "impact.desc": "Empresas líderes transforman sus redes con la plataforma SASE de Netskope, logrando resultados medibles en productividad, seguridad y eficiencia operativa.",
                "impact.1.title": "80% Reducción en Tiempo de Troubleshooting",
                "impact.1.desc": "Uno de los mayores distribuidores mayoristas de materiales para techos en Norteamérica (>1,000 ubicaciones)",
                "impact.2.title": "50% Reducción en TCO",
                "impact.2.desc": "Minorista global de viajes operando en aeropuertos, líneas de cruceros y centros de viaje (>5,000 ubicaciones)",
                "impact.3.title": "$2.6M Ahorrados con WAN as a Service",
                "impact.3.desc": "Líder tecnológico en préstamos hipotecarios (>200 ubicaciones y >4,000 usuarios)",
                "res.title": "Resultados Clave",
                "res.1.label": "Tiempo Troubleshooting",
                "res.1.sub": "Reducción promedio",
                "res.high": "Impacto Alto",
                "res.2.label": "Reducción TCO",
                "res.2.sub": "Consolidación productos",
                "res.crit": "Impacto Crítico",
                "res.3.sub": "Dispositivos descubiertos",
                "res.risk": "Reducción riesgo",
                "res.roi": "ROI en 3 años",
                // nav_who / nav_back / nav_demo ahora vienen de NetskopeCommonI18n
                "modal.desc": "Monitoreo de experiencia digital integrada para visibilidad completa del rendimiento de aplicaciones y red."
            }
        };

        // changeLanguage(lang) y closeModal(modalId) son ahora las funciones
        // compartidas de assets/js/common.js. Nota: la versión local que había aquí
        // incluía chequeos defensivos a window.NetskopeSiteLanguageUtils y
        // window.NetskopeSecurityUtils, dos helpers que nunca llegaron a existir en
        // este proyecto (código muerto); el comportamiento real ya era idéntico a
        // usar localStorage/innerHTML directamente, como hace la versión compartida.

        /**
         * openImageModal(modalId)
         * Alias de compatibilidad: el HTML de esta página usa onclick="openImageModal(...)"
         * (nombre histórico) en vez de openModal(...). Delega en la función openModal
         * compartida de assets/js/common.js para no duplicar la lógica de mostrar el modal.
         */
        function openImageModal(modalId) {
            openModal(modalId);
        }

        /**
         * initializePage() (IIFE)
         * Inicialización específica de esta página, ejecutada una sola vez al
         * evaluar el script (no espera DOMContentLoaded porque este <script> ya
         * está al final del <body>). Hace, en orden: (1) aplica el idioma guardado
         * en localStorage vía changeLanguage(); (2) renderiza los íconos Lucide si
         * la librería está disponible; (3) anima con IntersectionObserver los
         * .timeline-item de la sección de evolución al entrar en viewport; (4)
         * registra el cierre del modal de imagen (#dem-image-modal, vía
         * .modal-overlay) al hacer click fuera del contenido o al presionar Escape,
         * como respaldo adicional a closeModal()/openImageModal() de más arriba.
         *
         * @returns {void}
         */
        (function initializePage() {
            // Inicializar idioma (usa el valor guardado o 'es' por defecto)
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');

            // Iconos
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            // Timeline animation on scroll
            const timelineItems = document.querySelectorAll('.timeline-item');
            if(window.IntersectionObserver) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, { threshold: 0.1 });
                
                timelineItems.forEach(item => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(item);
                });
            }

            // Close modal when clicking outside
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay').forEach(modal => {
                        modal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    });
                }
            });
        })();
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
