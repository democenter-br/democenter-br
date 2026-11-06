<?php
// vpnevolution.php - Demo "Evolução da VPN" (Netskope Private Access / ZTNA
// Universal). Cobre por que substituir VPNs tradicionais, benefícios do ZTNA,
// citações de analistas e casos de uso principais. Parte do fluxo de demo vinculado
// a partir de index.php.
//
// As funções JS comuns (changeLanguage, etc.) ficam em assets/js/common.js
// e os textos i18n compartilhados entre páginas ficam em assets/js/i18n-common.js.
// O dicionário `translations` deste arquivo contém apenas strings
// específicas desta página.
?>
<!DOCTYPE html>
<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Comparativo visual entre VPN tradicional e Universal ZTNA com argumentos, benefícios e casos de uso.">
    
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Democenter Netskope | Evolução da VPN</title>
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
        
        .language-switcher { display: inline-flex; align-items: center; gap: 6px; padding: 4px; border-radius: 999px; background: rgba(255, 255, 255, 0.86); border: 1px solid rgba(8, 26, 89, 0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08); }
        .lang-btn { min-width: 36px; height: 30px; padding: 0 10px; border-radius: 999px; border: 1px solid transparent; background: transparent; color: #081A59; font-size: 0.75rem; font-weight: 700; line-height: 1; cursor: pointer; transition: all 0.2s ease; }
        .lang-btn:hover { background: rgba(0, 169, 206, 0.12); border-color: rgba(0, 169, 206, 0.35); color: #081A59; }
        .lang-btn.active { background: #081A59; border-color: #081A59; color: #ffffff; box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28); }

        .plus-pattern { position: absolute; width: 100%; height: 100%; background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2300A9CE' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 40V20h20v-2H20V0h-2v18H0v2h18v20z'/%3E%3C/g%3E%3C/svg%3E"); opacity: 0.3; z-index: 0; }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 50px -10px rgba(0, 169, 206, 0.15); }
        
        .quote-icon { position: absolute; top: -20px; left: 20px; width: 40px; height: 40px; background-color: #00A9CE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.absolute{position:absolute}.relative{position:relative}.inset-0{inset:0px}.-right-20{right:-5rem}.bottom-20{bottom:5rem}.right-0{right:0px}.top-0{top:0px}.z-10{z-index:10}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-10{margin-bottom:2.5rem}.mb-12{margin-bottom:3rem}.mb-16{margin-bottom:4rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.mt-0\.5{margin-top:0.125rem}.mt-16{margin-top:4rem}.mt-4{margin-top:1rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-1{height:0.25rem}.h-12{height:3rem}.h-16{height:4rem}.h-24{height:6rem}.h-3{height:0.75rem}.h-4{height:1rem}.h-48{height:12rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-8{height:2rem}.h-full{height:100%}.w-1\/2{width:50%}.w-12{width:3rem}.w-24{width:6rem}.w-3{width:0.75rem}.w-4{width:1rem}.w-48{width:12rem}.w-5{width:1.25rem}.w-6{width:1.5rem}.w-8{width:2rem}.w-auto{width:auto}.w-full{width:100%}.w-px{width:1px}.max-w-3xl{max-width:48rem}.max-w-5xl{max-width:64rem}.max-w-\[200px\]{max-width:200px}.flex-shrink-0{flex-shrink:0}.shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}@keyframes pulse{50%{opacity:.5}}.animate-pulse{animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-12{gap:3rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.gap-8{gap:2rem}.space-y-4 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-netskope{border-radius:24px}.rounded-netskope-sm{border-radius:12px}.rounded-xl{border-radius:0.75rem}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.border{border-width:1px}.border-b{border-bottom-width:1px}.border-t{border-top-width:1px}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-netskope-blue{--tw-border-opacity:1;border-color:rgb(0 169 206 / var(--tw-border-opacity, 1))}.border-netskope-teal\/30{border-color:rgb(0 128 149 / 0.3)}.border-red-500\/30{border-color:rgb(239 68 68 / 0.3)}.border-white\/10{border-color:rgb(255 255 255 / 0.1)}.border-white\/20{border-color:rgb(255 255 255 / 0.2)}.border-white\/50{border-color:rgb(255 255 255 / 0.5)}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-blue\/10{background-color:rgb(0 169 206 / 0.1)}.bg-netskope-darkGray\/30{background-color:rgb(42 43 45 / 0.3)}.bg-netskope-deepBlue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-netskope-green\/20{background-color:rgb(175 241 152 / 0.2)}.bg-netskope-green\/30{background-color:rgb(175 241 152 / 0.3)}.bg-netskope-lightBlue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-netskope-offWhite{--tw-bg-opacity:1;background-color:rgb(245 245 245 / var(--tw-bg-opacity, 1))}.bg-netskope-teal{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.bg-netskope-teal\/10{background-color:rgb(0 128 149 / 0.1)}.bg-netskope-teal\/20{background-color:rgb(0 128 149 / 0.2)}.bg-red-500\/10{background-color:rgb(239 68 68 / 0.1)}.bg-red-500\/20{background-color:rgb(239 68 68 / 0.2)}.bg-red-500\/30{background-color:rgb(239 68 68 / 0.3)}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/20{background-color:rgb(255 255 255 / 0.2)}.bg-white\/60{background-color:rgb(255 255 255 / 0.6)}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.bg-gradient-to-br{background-image:linear-gradient(to bottom right, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.from-netskope-blue{--tw-gradient-from:#00A9CE var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 169 206 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-deepBlue{--tw-gradient-from:#081A59 var(--tw-gradient-from-position);--tw-gradient-to:rgb(8 26 89 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-orange{--tw-gradient-from:#FF8200 var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 130 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-white{--tw-gradient-from:#fff var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-netskope-offWhite{--tw-gradient-to:#F5F5F5 var(--tw-gradient-to-position)}.to-netskope-teal{--tw-gradient-to:#008095 var(--tw-gradient-to-position)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.to-yellow-500{--tw-gradient-to:#eab308 var(--tw-gradient-to-position)}.p-12{padding:3rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-8{padding-left:2rem;padding-right:2rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-20{padding-top:5rem;padding-bottom:5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.pb-24{padding-bottom:6rem}.pt-20{padding-top:5rem}.pt-4{padding-top:1rem}.pt-6{padding-top:1.5rem}.text-center{text-align:center}.text-base{font-size:1rem;line-height:1.5rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-5xl{font-size:3rem;line-height:1}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-normal{font-weight:400}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.tracking-wide{letter-spacing:0.025em}.tracking-widest{letter-spacing:0.1em}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-red-400{--tw-text-opacity:1;color:rgb(248 113 113 / var(--tw-text-opacity, 1))}.text-red-500{--tw-text-opacity:1;color:rgb(239 68 68 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.text-white\/80{color:rgb(255 255 255 / 0.8)}.text-white\/90{color:rgb(255 255 255 / 0.9)}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-10{opacity:0.1}.opacity-20{opacity:0.2}.opacity-80{opacity:0.8}.shadow-hover{--tw-shadow:0 20px 50px -10px rgba(0, 169, 206, 0.15);--tw-shadow-colored:0 20px 50px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-blur-sm{--tw-backdrop-blur:blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.hover\:bg-netskope-lightBlue:hover{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.hover\:bg-netskope-teal:hover{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.hover\:bg-white\/15:hover{background-color:rgb(255 255 255 / 0.15)}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:opacity-90:hover{opacity:0.9}.hover\:shadow-hover:hover{--tw-shadow:0 20px 50px -10px rgba(0, 169, 206, 0.15);--tw-shadow-colored:0 20px 50px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}@media (min-width: 768px){.md\:block{display:block}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:gap-24{gap:6rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-7xl{font-size:4.5rem;line-height:1}}@media (min-width: 1024px){.lg\:-mt-6{margin-top:-1.5rem}.lg\:w-1\/3{width:33.333333%}.lg\:w-2\/3{width:66.666667%}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.lg\:grid-cols-4{grid-template-columns:repeat(4, minmax(0, 1fr))}.lg\:flex-row{flex-direction:row}}</style>    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-site-shell="ready" data-page-name="vpnevolution" data-page-kind="story">
    <!-- Os atributos data-site-shell/data-page-name/data-page-kind e as classes
         site-shell-* são ganchos para o CSS/JS do chrome compartilhado do site
         (assets/vendor/css/site-global.css e assets/vendor/js/site-global.js,
         referenciados no <head>); não afetam o layout por si só se esses
         assets não estiverem presentes. -->

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <div class="flex items-center gap-6">
                <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            </div>

            <div class="flex items-center gap-6 site-shell-toolbar">
                <span class="hidden md:block text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="header_tagline">Universal ZTNA - Substituição de VPN</span>
                
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
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="hero_eyebrow">Acesso Remoto Seguro</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="hero_title_1">Evolução das VPNs</span><br>
                    <span class="font-lora italic font-normal text-netskope-teal" data-i18n="hero_title_2">Rumo ao Universal ZTNA</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12">
                    <span data-i18n="hero_desc_1">As VPNs tradicionais ficaram obsoletas.</span><br>
                    <strong class="text-netskope-deepBlue font-semibold" data-i18n="hero_desc_2">O Universal ZTNA oferece menor superfície de ataque e melhor experiência do usuário.</strong>
                </p>

                <!-- Stats -->
                <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-netskope shadow-soft inline-flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 w-full">
                    <div class="text-center max-w-[200px]">
                        <div class="text-5xl font-bold text-red-500 mb-1">56%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_1">das empresas tiveram um incidente de segurança com a VPN</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center max-w-[200px]">
                        <div class="text-5xl font-bold text-netskope-teal mb-1">78%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_2">citam mais segurança como principal motivo para migrar para ZTNA</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>
                    <div class="text-center max-w-[200px]">
                        <div class="text-5xl font-bold text-netskope-orange mb-1">22%</div>
                        <div class="text-xs text-netskope-deepBlue font-bold uppercase tracking-wide" data-i18n="stat_3">dos usuários apontam a lentidão da VPN como principal reclamação</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Market Reality Section -->
    <section class="bg-netskope-deepBlue py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#00A9CE 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="market_eyebrow">Realidade do Mercado</span>
                <h2 class="text-3xl font-bold text-white" data-i18n="market_title">O que dizem os analistas e agências de segurança</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_1">"Os concentradores VPN são pontos de entrada para redes protegidas, o que os torna alvos atraentes. Os atores de ameaças persistentes avançadas (APT) já exploraram e continuarão explorando as VPNs."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">NSA / CISA Advisory</p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full mt-0 lg:-mt-6">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_2">"Os Threat Actors estão aproveitando as vulnerabilidades das VPNs para obter acesso a redes desprotegidas. Várias vulnerabilidades de VPN que afetam produtos importantes foram divulgadas e estão sendo exploradas ativamente."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">NSA Cybersecurity Advisory</p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-8 rounded-netskope relative hover:bg-white/15 transition-all group flex flex-col h-full">
                    <div class="quote-icon"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg></div>
                    <p class="text-netskope-lightBlue font-lora italic text-lg leading-relaxed mb-6 mt-4 flex-grow" data-i18n="quote_3">"O ZTNA oferece uma alternativa escalável por meio do uso de pontos de aplicação de políticas distribuídos, melhorando o desempenho e reduzindo a latência em comparação com as VPNs tradicionais."</p>
                    <div class="border-t border-white/20 pt-4 mt-auto">
                        <p class="text-white font-bold text-sm tracking-wide">Gartner Research</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VPN vs ZTNA Comparison Section -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="comp_eyebrow">Comparação</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">VPN vs Universal ZTNA</h2>
                <p class="text-netskope-lightBlue max-w-3xl mx-auto text-lg" data-i18n="comp_subtitle">Por que as organizações estão migrando de VPNs tradicionais para o Universal ZTNA</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-netskope">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- VPN Column -->
                    <div class="bg-red-500/10 border border-red-500/30 p-6 rounded-netskope">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center text-red-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white" data-i18n="vpn_title">VPN Tradicional</h3>
                        </div>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-red-500/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                                <span class="text-white/90" data-i18n="vpn_point_1"><strong>Acesso Amplo:</strong> Acesso completo à rede</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-red-500/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                                <span class="text-white/90" data-i18n="vpn_point_2"><strong>Confiança Implícita:</strong> Conexão primeiro, autenticação depois</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-red-500/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                                <span class="text-white/90" data-i18n="vpn_point_3"><strong>Experiência Ruim:</strong> Latência por backhauling/hairpinning</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-red-500/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                                <span class="text-white/90" data-i18n="vpn_point_4"><strong>Complexidade Operacional:</strong> Múltiplos consoles e VPNs</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- ZTNA Column -->
                    <div class="bg-netskope-teal/10 border border-netskope-teal/30 p-6 rounded-netskope">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-netskope-teal/20 rounded-lg flex items-center justify-center text-netskope-green">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Universal ZTNA</h3>
                        </div>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-netskope-green/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-netskope-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                                <span class="text-white/90" data-i18n="ztna_point_1"><strong>Acesso Granular:</strong> Controle específico por aplicação</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-netskope-green/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-netskope-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                                <span class="text-white/90" data-i18n="ztna_point_2"><strong>Confiança Zero:</strong> Autenticação primeiro, conexão depois</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-netskope-green/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-netskope-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                                <span class="text-white/90" data-i18n="ztna_point_3"><strong>Melhor Experiência:</strong> Conexão direta sem backhauling</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-netskope-green/30 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-netskope-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                                <span class="text-white/90" data-i18n="ztna_point_4"><strong>Operações Simplificadas:</strong> Console único</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Netskope Strategy Section -->
    <section class="py-20 bg-netskope-offWhite">
        <div class="container mx-auto px-6 md:px-12">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="strat_title">Estratégia da Netskope para ZTNA</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg" data-i18n="strat_desc">Uma abordagem integral que combina segurança, experiência do usuário e inovação com IA</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="strat_card_1_title">Acesso Rápido e Transparente</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="strat_card_1_desc">Por meio da NewEdge, a rede de segurança mais conectada do mundo, independentemente da localização das aplicações.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">NewEdge Network</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="strat_card_2_title">Todos os Fluxos de Tráfego</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="strat_card_2_desc">Suporte completo a fluxos cliente-servidor e servidor-cliente, eliminando as limitações do ZTNA.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Bidirectional</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Enterprise Browser</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="strat_card_3_desc">Método de acesso adicional para BYOD e terceiros, com isolamento completo de dados e controles de segurança adicionais.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Agentless Access</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full">
                    <div class="w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3" data-i18n="strat_card_4_title">Visibilidade e Controle Total</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow" data-i18n="strat_card_4_desc">Visibilidade completa do acesso a aplicações internas e controle granular para prevenir movimentação lateral.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Full Visibility</span></div>
                </div>
            </div>

            <!-- AI Copilot Section -->
            <div class="mt-16 bg-gradient-to-r from-netskope-deepBlue to-netskope-teal rounded-netskope overflow-hidden shadow-hover">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-2/3 p-12 text-white">
                        <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-4 block" data-i18n="ai_eyebrow">Inovação IA-Powered</span>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Netskope One Copilot for Private Access</h2>
                        <p class="text-netskope-lightBlue text-lg mb-8 leading-relaxed" data-i18n="ai_desc">IA para simplificar a adoção do ZTNA. Automatiza a otimização de políticas e reduz o risco.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="ai_point_1_title">Definição de Segmentos de Apps</h4>
                                    <p class="text-sm text-white/80" data-i18n="ai_point_1_desc">Define destinos granulares e segmentos de aplicações</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="ai_point_2_title">Implementação de Políticas ZTNA</h4>
                                    <p class="text-sm text-white/80" data-i18n="ai_point_2_desc">Define políticas granulares com base em padrões de uso reais</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="ai_point_3_title">Otimização Contínua</h4>
                                    <p class="text-sm text-white/80" data-i18n="ai_point_3_desc">Fornece recomendações para políticas existentes</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1" data-i18n="ai_point_4_title">Eliminação de Configurações Obsoletas</h4>
                                    <p class="text-sm text-white/80" data-i18n="ai_point_4_desc">Destaca e elimina destinos, apps e políticas inativos para reduzir o risco</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-1/3 bg-netskope-darkGray/30 flex items-center justify-center p-8">
                        <div class="relative">
                            <div class="w-48 h-48 mx-auto bg-gradient-to-br from-netskope-blue to-netskope-teal rounded-full flex items-center justify-center mb-6">
                                <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div class="text-center text-white">
                                <h3 class="text-xl font-bold mb-2" data-i18n="ai_circle_title">Eficiência Potencializada por IA</h3>
                                <p class="text-sm opacity-80" data-i18n="ai_circle_desc">Simplifica as operações e reduz o risco</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-gradient-confident text-white relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="ben_eyebrow">Principais Benefícios</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" data-i18n="ben_title">Melhorias em relação à VPN Tradicional</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_1_title">Segurança Aprimorada</h3>
                    <p class="text-white/80" data-i18n="ben_1_desc">Substitui o acesso amplo da VPN por controles específicos por aplicação e privilégio mínimo.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_2_title">Superfície de Ataque Reduzida</h3>
                    <p class="text-white/80" data-i18n="ben_2_desc">A autenticação contínua verifica a identidade do usuário antes de conceder acesso.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_3_title">Acesso Simplificado</h3>
                    <p class="text-white/80" data-i18n="ben_3_desc">Os usuários se conectam diretamente a aplicações aprovadas, sem exposição completa da rede.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_4_title">Melhor Experiência Remota</h3>
                    <p class="text-white/80" data-i18n="ben_4_desc">Elimina túneis VPN lentos e frágeis para um acesso remoto mais rápido.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_5_title">Gerenciamento Centralizado</h3>
                    <p class="text-white/80" data-i18n="ben_5_desc">Simplifica o controle de políticas e a visibilidade em todas as aplicações privadas.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-netskope hover:bg-white/15 transition-all">
                    <div class="w-12 h-12 bg-netskope-green/20 rounded-lg flex items-center justify-center text-netskope-green mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3" data-i18n="ben_6_title">Sem Publicação de Serviços</h3>
                    <p class="text-white/80" data-i18n="ben_6_desc">Melhora a segurança ao não publicar serviços visíveis e prevenir movimentação lateral.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="py-20 bg-gradient-to-b from-white to-netskope-offWhite relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-10">
                <span class="text-netskope-blue font-bold text-xs uppercase tracking-widest mb-3 block" data-i18n="uc_eyebrow">PRINCIPAIS CASOS DE USO</span>
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="uc_title">Universal ZTNA em Ação</h2>
                <p class="text-netskope-gray max-w-3xl mx-auto text-lg mb-10" data-i18n="uc_desc">Soluções específicas para substituir tecnologias legadas e melhorar o acesso seguro</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">VPN Full Replacement</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_1_desc">Substituição completa de VPNs legadas com controles de acesso adaptativos e de privilégio mínimo, conectividade em nível de aplicação e segurança integrada.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Legacy Modernization</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">VDI Alternative</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_2_desc">Alternativa a VDI/DaaS por meio de ZTNA + Enterprise Browser, com isolamento completo de dados e controles de segurança adicionais.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Cost Reduction</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Privileged Remote Access (PRA)</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_3_desc">Substituição de PAM com acesso baseado em navegador, portal do usuário e controles unificados de Threat Protection e DLP.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Secure Access</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Mergers &amp; Acquisitions</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_4_desc">Integração de empresas sem problemas de overlapping de endereçamento, acelerando e minimizando riscos em processos de fusões e aquisições.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Fast Integration</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Protect Hybrid Workforce</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_5_desc">Acesso unificado e adaptativo para os trabalhadores híbridos, com visibilidade end-to-end.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">Workforce Security</span></div>
                </div>

                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col">
                    <div class="w-12 h-12 bg-netskope-blue/10 rounded-xl flex items-center justify-center text-netskope-blue mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3">Secure Third Party/BYOD</h3>
                    <p class="text-netskope-gray mb-6 flex-grow" data-i18n="uc_6_desc">Acesso seguro para fornecedores, terceiros e dispositivos não gerenciados, com isolamento de dados e controles específicos.</p>
                    <div class="pt-4 border-t border-gray-100"><span class="text-xs font-bold text-netskope-teal uppercase tracking-wide">External Access</span></div>
                </div>
            </div>

            <!-- Botões de ação -->
            <div class="mt-16 text-center">
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

    <!-- Utilitários JS compartilhados (changeLanguage, etc.) e dicionário de
         traduções comum. Devem ser carregados antes do script inline abaixo. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- Script de Tradução Nativo e Fallback -->
    <script>
        // Dicionário específico desta página, mesclado com NetskopeCommonI18n.
        const translations = {
            es: {
                ...NetskopeCommonI18n.es,
                "header_tagline": "Universal ZTNA - Substituição de VPN",
                "hero_eyebrow": "Acesso Remoto Seguro",
                "hero_title_1": "Evolução das VPNs",
                "hero_title_2": "Rumo ao Universal ZTNA",
                "hero_desc_1": "As VPNs tradicionais ficaram obsoletas.",
                "hero_desc_2": "O Universal ZTNA oferece menor superfície de ataque e melhor experiência do usuário.",
                "stat_1": "das empresas tiveram um incidente de segurança com a VPN",
                "stat_2": "citam mais segurança como principal motivo para migrar para ZTNA",
                "stat_3": "dos usuários apontam a lentidão da VPN como principal reclamação",
                "market_eyebrow": "Realidade do Mercado",
                "market_title": "O que dizem os analistas e agências de segurança",
                "quote_1": "\"Os concentradores VPN são pontos de entrada para redes protegidas, o que os torna alvos atraentes. Os atores de ameaças persistentes avançadas (APT) já exploraram e continuarão explorando as VPNs.\"",
                "quote_2": "\"Os Threat Actors estão aproveitando as vulnerabilidades das VPNs para obter acesso a redes desprotegidas. Várias vulnerabilidades de VPN que afetam produtos importantes foram divulgadas e estão sendo exploradas ativamente.\"",
                "quote_3": "\"O ZTNA oferece uma alternativa escalável por meio do uso de pontos de aplicação de políticas distribuídos, melhorando o desempenho e reduzindo a latência em comparação com as VPNs tradicionais.\"",
                "comp_eyebrow": "Comparação",
                "comp_subtitle": "Por que as organizações estão migrando de VPNs tradicionais para o Universal ZTNA",
                "vpn_title": "VPN Tradicional",
                "vpn_point_1": "<strong>Acesso Amplo:</strong> Acesso completo à rede",
                "vpn_point_2": "<strong>Confiança Implícita:</strong> Conexão primeiro, autenticação depois",
                "vpn_point_3": "<strong>Experiência Ruim:</strong> Latência por backhauling/hairpinning",
                "vpn_point_4": "<strong>Complexidade Operacional:</strong> Múltiplos consoles e VPNs",
                "ztna_point_1": "<strong>Acesso Granular:</strong> Controle específico por aplicação",
                "ztna_point_2": "<strong>Confiança Zero:</strong> Autenticação primeiro, conexão depois",
                "ztna_point_3": "<strong>Melhor Experiência:</strong> Conexão direta sem backhauling",
                "ztna_point_4": "<strong>Operações Simplificadas:</strong> Console único",
                "strat_title": "Estratégia da Netskope para ZTNA",
                "strat_desc": "Uma abordagem integral que combina segurança, experiência do usuário e inovação com IA",
                "strat_card_1_title": "Acesso Rápido e Transparente",
                "strat_card_1_desc": "Por meio da NewEdge, a rede de segurança mais conectada do mundo, independentemente da localização das aplicações.",
                "strat_card_2_title": "Todos os Fluxos de Tráfego",
                "strat_card_2_desc": "Suporte completo a fluxos cliente-servidor e servidor-cliente, eliminando as limitações do ZTNA.",
                "strat_card_3_desc": "Método de acesso adicional para BYOD e terceiros, com isolamento completo de dados e controles de segurança adicionais.",
                "strat_card_4_title": "Visibilidade e Controle Total",
                "strat_card_4_desc": "Visibilidade completa do acesso a aplicações internas e controle granular para prevenir movimentação lateral.",
                "ai_eyebrow": "Inovação IA-Powered",
                "ai_desc": "IA para simplificar a adoção do ZTNA. Automatiza a otimização de políticas e reduz o risco.",
                "ai_point_1_title": "Definição de Segmentos de Apps",
                "ai_point_1_desc": "Define destinos granulares e segmentos de aplicações",
                "ai_point_2_title": "Implementação de Políticas ZTNA",
                "ai_point_2_desc": "Define políticas granulares com base em padrões de uso reais",
                "ai_point_3_title": "Otimização Contínua",
                "ai_point_3_desc": "Fornece recomendações para políticas existentes",
                "ai_point_4_title": "Eliminação de Configurações Obsoletas",
                "ai_point_4_desc": "Destaca e elimina destinos, apps e políticas inativos para reduzir o risco",
                "ai_circle_title": "Eficiência Potencializada por IA",
                "ai_circle_desc": "Simplifica as operações e reduz o risco",
                "ben_eyebrow": "Principais Benefícios",
                "ben_title": "Melhorias em relação à VPN Tradicional",
                "ben_1_title": "Segurança Aprimorada",
                "ben_1_desc": "Substitui o acesso amplo da VPN por controles específicos por aplicação e privilégio mínimo.",
                "ben_2_title": "Superfície de Ataque Reduzida",
                "ben_2_desc": "A autenticação contínua verifica a identidade do usuário antes de conceder acesso.",
                "ben_3_title": "Acesso Simplificado",
                "ben_3_desc": "Os usuários se conectam diretamente a aplicações aprovadas, sem exposição completa da rede.",
                "ben_4_title": "Melhor Experiência Remota",
                "ben_4_desc": "Elimina túneis VPN lentos e frágeis para um acesso remoto mais rápido.",
                "ben_5_title": "Gerenciamento Centralizado",
                "ben_5_desc": "Simplifica o controle de políticas e a visibilidade em todas as aplicações privadas.",
                "ben_6_title": "Sem Publicação de Serviços",
                "ben_6_desc": "Melhora a segurança ao não publicar serviços visíveis e prevenir movimentação lateral.",
                "uc_eyebrow": "PRINCIPAIS CASOS DE USO",
                "uc_title": "Universal ZTNA em Ação",
                "uc_desc": "Soluções específicas para substituir tecnologias legadas e melhorar o acesso seguro",
                "uc_1_desc": "Substituição completa de VPNs legadas com controles de acesso adaptativos e de privilégio mínimo, conectividade em nível de aplicação e segurança integrada.",
                "uc_2_desc": "Alternativa a VDI/DaaS por meio de ZTNA + Enterprise Browser, com isolamento completo de dados e controles de segurança adicionais.",
                "uc_3_desc": "Substituição de PAM com acesso baseado em navegador, portal do usuário e controles unificados de Threat Protection e DLP.",
                "uc_4_desc": "Integração de empresas sem problemas de overlapping de endereçamento, acelerando e minimizando riscos em processos de fusões e aquisições.",
                "uc_5_desc": "Acesso unificado e adaptativo para os trabalhadores híbridos, com visibilidade end-to-end.",
                "uc_6_desc": "Acesso seguro para fornecedores, terceiros e dispositivos não gerenciados, com isolamento de dados e controles específicos."
                // nav_who / nav_back / nav_demo agora vêm de NetskopeCommonI18n
            }
        };

        // changeLanguage(lang) agora é a função compartilhada de assets/js/common.js.
        // Nota: a versão local que existia aqui incluía uma verificação defensiva para
        // window.NetskopeSecurityUtils.applyTranslatedHtml, um helper que nunca chegou
        // a existir neste projeto (código morto); por isso o comportamento real
        // era idêntico a usar innerHTML diretamente, como faz a versão compartilhada.

        document.addEventListener('DOMContentLoaded', () => {
            changeLanguage(localStorage.getItem('netskope-lang') || 'es');
        });
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
