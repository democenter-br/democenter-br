<!--
    keydifferentiators.php - Página "¿Quién es Netskope?" / diferenciadores clave.
    Es la tarjeta principal enlazada desde index.php: explica la propuesta de
    valor de Netskope (red NewEdge, posición en cuadrantes de analistas,
    consola única, etc.) con varios modales de detalle (Gartner/Forrester/IDC,
    NewEdge). Nota: a diferencia de las otras 10 páginas del sitio, este
    archivo no usa tags <?php ?> (es HTML puro con extensión .php) y su
    diccionario de traducciones se carga desde un catálogo externo
    (assets/json/keydifferentiators.i18n.json) vía XHR síncrono, en vez del
    objeto `translations` embebido que usan las demás páginas.

    Las funciones JS comunes (changeLanguage, openModal/closeModal, etc.) viven
    en assets/js/common.js y se cargan aquí también, pero esta página define
    sus PROPIAS versiones locales de changeLanguage/openModal/closeModal (con
    firmas y comportamiento distintos: openModal/closeModal reciben el elemento
    del modal, no un ID, y changeLanguage integra lógica adicional específica
    de esta página). Esas versiones locales, al declararse después en el mismo
    scope global, sobrescriben a las de common.js sin conflicto. No se fusionó
    NetskopeCommonI18n (assets/js/i18n-common.js) en el catálogo de esta
    página para no interferir con su mecanismo de carga desde JSON externo;
    si en el futuro se quiere compartir texto entre esta página y las demás,
    conviene revisar manualmente ambos catálogos para evitar que el texto
    diverja con el tiempo.
-->
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Resumen estructurado de los diferenciadores de Netskope para reforzar mensajes comerciales consistentes.">
    
    <link rel="icon" type="image/png" href="favicon.png">
<title>Democenter Netskope | Diferenciadores Clave</title>
    
    <!-- Fuentes -->
    <link href="assets/vendor/css/offline-fonts.css" rel="stylesheet">
    <link href="assets/vendor/css/site-global.css" rel="stylesheet">
    <script src="assets/vendor/js/site-global.js"></script>
    <script src="assets/vendor/js/lucide.min.js"></script>

    <!-- Tailwind Config -->
    <script src="assets/vendor/js/tailwindcss-cdn.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        netskope: {
                            deepBlue: '#081A59',
                            blue: '#00A9CE',
                            lightBlue: '#D9FAFF',
                            teal: '#008095',
                            green: '#AFF198', 
                            orange: '#FF8200',
                            darkGray: '#2A2B2D',
                            gray: '#53565A',
                            lightGray: '#C8C9C7',
                            offWhite: '#F5F5F5'
                        },
                        nk: {
                            'deep-blue': '#081A59',
                            'blue': '#00A9CE',
                            'light-blue': '#D9FAFF',
                            'teal': '#008095',
                            'orange': '#FF8200',
                            'lightning-green': '#AFF198',
                            'dark-gray': '#2A2B2D',
                            'gray': '#53565A',
                            'off-white': '#F5F5F5'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], 
                        serif: ['Lora', 'serif'], 
                    },
                    backgroundImage: {
                        'gradient-confident': 'linear-gradient(135deg, #081A59 0%, #00A9CE 100%)',
                        'gradient-neon': 'linear-gradient(135deg, #00A9CE 0%, #AFF198 100%)',
                        'pattern-net': "radial-gradient(#00A9CE 1.5px, transparent 1.5px)",
                    },
                    borderRadius: {
                        'netskope': '24px', 
                        'netskope-sm': '12px',
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(8, 26, 89, 0.08)',
                        'hover': '0 20px 50px -10px rgba(0, 169, 206, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Estilos Generales */
        body { 
            font-family: 'Inter', sans-serif; 
            color: #2A2B2D; 
            background-color: #F5F5F5; 
            overflow-x: hidden; 
        }
        
        .font-lora { font-family: 'Lora', serif; }

        /* Lang Buttons Styles (Requested) */
        .lang-btn {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.9);
            color: #081A59;
        }
        .lang-btn.active {
            background: #081A59;
            color: white;
        }
        .lang-btn:not(.active):hover {
            background: rgba(0, 169, 206, 0.1);
            color: #081A59;
            border-color: #00A9CE;
        }
        
        
        .language-switcher {
            display: flex;
            gap: 4px;
            align-items: center;
        }
/* Graphic Device: Plus (+) Pattern */
        .plus-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2300A9CE' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 40V20h20v-2H20V0h-2v18H0v2h18v20z'/%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
            z-index: 0;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px -10px rgba(0, 169, 206, 0.15);
        }

        /* Netskope "Bubble" shape simulation */
        .bubble-shape {
            border-radius: 24px;
            border-top-right-radius: 60px;
        }

        .nk-diff-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            line-height: 1;
        }

        .nk-diff-icon i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            line-height: 1;
        }

        .nk-diff-icon--lock {
            font-size: 1.65rem;
        }

        .nk-diff-icon--lock i {
            position: relative;
            top: -2px;
        }

        .nk-diff-chip-icon {
            font-size: 0.8rem;
            line-height: 1;
        }

        .nk-diff-chip-icon i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }


        .nk-diff-section {
            position: relative;
            background:
                radial-gradient(circle at 12% 10%, rgba(0, 169, 206, 0.16), transparent 28%),
                radial-gradient(circle at 88% 12%, rgba(175, 241, 152, 0.14), transparent 22%),
                linear-gradient(180deg, #f3f8fc 0%, #eef5fb 42%, #f8fbfd 100%);
        }

        .nk-diff-shell {
            position: relative;
            padding: clamp(28px, 4vw, 52px);
            border-radius: 40px;
            background: linear-gradient(148deg, #081A59 0%, #0A3374 42%, #0C6A9E 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 34px 80px -42px rgba(8, 26, 89, 0.82);
            overflow: hidden;
            isolation: isolate;
        }

        .nk-diff-shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(to right, rgba(255, 255, 255, 0.06) 0 1px, transparent 1px 42px),
                repeating-linear-gradient(to bottom, rgba(255, 255, 255, 0.06) 0 1px, transparent 1px 42px);
            opacity: 0.22;
            mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 0.82), transparent 88%);
            -webkit-mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 0.82), transparent 88%);
            pointer-events: none;
        }

        .nk-diff-shell::after {
            content: "";
            position: absolute;
            right: -140px;
            top: -150px;
            width: 360px;
            height: 360px;
            border-radius: 36% 64% 46% 54% / 52% 40% 60% 48%;
            background:
                radial-gradient(circle at 30% 30%, rgba(217, 250, 255, 0.38), transparent 48%),
                linear-gradient(145deg, rgba(0, 169, 206, 0.34), rgba(175, 241, 152, 0.22));
            opacity: 0.78;
            pointer-events: none;
        }

        .nk-diff-heading {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 20px 28px;
            align-items: end;
            margin-bottom: 28px;
        }

        .nk-diff-heading-copy {
            max-width: 760px;
        }

        .nk-diff-section-title {
            font-size: clamp(2.3rem, 2rem + 1.25vw, 4rem);
            line-height: 0.98;
            letter-spacing: -0.05em;
            color: #ffffff;
            max-width: 13ch;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .nk-diff-section-sub {
            font-size: 1rem;
            line-height: 1.75;
            color: rgba(233, 243, 255, 0.82);
            max-width: 42rem;
        }

        .nk-diff-chip-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .nk-diff-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            line-height: 1.35;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .nk-diff-chip::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: linear-gradient(180deg, #AFF198 0%, #00A9CE 100%);
            flex-shrink: 0;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.06);
        }

        .nk-diff-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 22px;
        }

        .nk-diff-card {
            --card-accent: #00A9CE;
            --card-accent-alt: #AFF198;
            --card-bg: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 254, 0.98) 100%);
            --card-border: rgba(8, 26, 89, 0.1);
            --card-hover-border: rgba(8, 26, 89, 0.16);
            --card-divider: rgba(8, 26, 89, 0.08);
            --card-heading: #081A59;
            --card-text: #4B566A;
            --card-stage-bg: linear-gradient(145deg, rgba(229, 248, 255, 0.96) 0%, rgba(255, 255, 255, 0.98) 54%, rgba(217, 250, 255, 0.92) 100%);
            --card-stage-border: rgba(8, 26, 89, 0.08);
            --card-stage-grid: rgba(8, 26, 89, 0.07);
            --card-stage-orb: rgba(0, 169, 206, 0.26);
            --card-tag-bg: rgba(8, 26, 89, 0.04);
            --card-tag-border: rgba(8, 26, 89, 0.08);
            --card-tag-text: var(--card-accent);
            --card-stat-bg: rgba(8, 26, 89, 0.04);
            --card-stat-border: rgba(8, 26, 89, 0.08);
            --card-number: var(--card-accent);
            --card-ink: #081A59;
            --card-plus-bg: rgba(255, 255, 255, 0.7);
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100%;
            padding: 24px;
            border-radius: 32px;
            border: 1px solid var(--card-border);
            background: var(--card-bg);
            overflow: hidden;
            isolation: isolate;
            box-shadow: 0 26px 48px -38px rgba(8, 26, 89, 0.72);
            transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
        }

        .nk-diff-card::before {
            content: "";
            position: absolute;
            inset: 0 auto auto 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--card-accent) 0%, var(--card-accent-alt) 100%);
        }

        .nk-diff-card::after {
            content: "";
            position: absolute;
            right: -84px;
            bottom: -118px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.42) 0%, rgba(255, 255, 255, 0) 72%);
            opacity: 0.42;
            pointer-events: none;
        }

        .nk-diff-card:hover {
            transform: translateY(-6px);
            border-color: var(--card-hover-border);
            box-shadow: 0 32px 62px -42px rgba(8, 26, 89, 0.82);
        }

        .nk-diff-card > * {
            position: relative;
            z-index: 1;
        }

        .nk-diff-card--feature {
            padding: 26px;
        }

        .nk-diff-card--feature .nk-diff-card-frame {
            display: grid;
            gap: 20px;
            height: 100%;
        }

        .nk-diff-card--feature .nk-diff-card-copy {
            display: flex;
            flex-direction: column;
        }

        .nk-diff-card--newedge {
            --card-accent: #00A9CE;
            --card-accent-alt: #AFF198;
            --card-bg: linear-gradient(150deg, rgba(7, 24, 85, 0.99) 0%, rgba(8, 79, 132, 0.97) 55%, rgba(0, 169, 206, 0.92) 100%);
            --card-border: rgba(255, 255, 255, 0.12);
            --card-hover-border: rgba(255, 255, 255, 0.2);
            --card-divider: rgba(255, 255, 255, 0.14);
            --card-heading: #ffffff;
            --card-text: rgba(233, 245, 255, 0.84);
            --card-stage-bg: linear-gradient(155deg, rgba(255, 255, 255, 0.12) 0%, rgba(217, 250, 255, 0.18) 100%);
            --card-stage-border: rgba(255, 255, 255, 0.16);
            --card-stage-grid: rgba(255, 255, 255, 0.12);
            --card-stage-orb: rgba(175, 241, 152, 0.26);
            --card-tag-bg: rgba(255, 255, 255, 0.12);
            --card-tag-border: rgba(255, 255, 255, 0.16);
            --card-tag-text: #ffffff;
            --card-stat-bg: rgba(255, 255, 255, 0.12);
            --card-stat-border: rgba(255, 255, 255, 0.16);
            --card-number: #D9FAFF;
            --card-ink: #ffffff;
            --card-plus-bg: rgba(255, 255, 255, 0.14);
        }

        .nk-diff-card--visibility {
            --card-accent: #081A59;
            --card-accent-alt: #00A9CE;
            --card-stage-bg: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(228, 241, 255, 0.92) 100%);
            --card-stage-orb: rgba(8, 26, 89, 0.16);
            --card-tag-text: #081A59;
        }

        .nk-diff-card--dlp {
            --card-accent: #FF8200;
            --card-accent-alt: #00A9CE;
            --card-stage-bg: linear-gradient(145deg, rgba(255, 250, 244, 0.98) 0%, rgba(255, 255, 255, 0.98) 52%, rgba(255, 130, 0, 0.08) 100%);
            --card-stage-orb: rgba(255, 130, 0, 0.16);
            --card-tag-text: #FF8200;
        }

        .nk-diff-card--ai {
            --card-accent: #5EBB6F;
            --card-accent-alt: #00A9CE;
            --card-stage-bg: linear-gradient(145deg, rgba(247, 255, 247, 0.98) 0%, rgba(255, 255, 255, 0.98) 48%, rgba(175, 241, 152, 0.22) 100%);
            --card-stage-orb: rgba(175, 241, 152, 0.18);
            --card-tag-text: #3F9860;
        }

        .nk-diff-card--dem {
            --card-accent: #008095;
            --card-accent-alt: #00A9CE;
            --card-stage-bg: linear-gradient(145deg, rgba(234, 249, 252, 0.98) 0%, rgba(255, 255, 255, 0.98) 52%, rgba(0, 128, 149, 0.08) 100%);
            --card-stage-orb: rgba(0, 128, 149, 0.14);
            --card-tag-text: #008095;
        }

        .nk-diff-card--sase {
            --card-accent: #00A9CE;
            --card-accent-alt: #AFF198;
            --card-bg: linear-gradient(148deg, rgba(8, 26, 89, 0.99) 0%, rgba(11, 59, 126, 0.96) 52%, rgba(34, 155, 206, 0.9) 100%);
            --card-border: rgba(255, 255, 255, 0.12);
            --card-hover-border: rgba(255, 255, 255, 0.2);
            --card-divider: rgba(255, 255, 255, 0.14);
            --card-heading: #ffffff;
            --card-text: rgba(232, 243, 255, 0.82);
            --card-stage-bg: linear-gradient(155deg, rgba(255, 255, 255, 0.12) 0%, rgba(217, 250, 255, 0.16) 100%);
            --card-stage-border: rgba(255, 255, 255, 0.16);
            --card-stage-grid: rgba(255, 255, 255, 0.12);
            --card-stage-orb: rgba(217, 250, 255, 0.24);
            --card-tag-bg: rgba(255, 255, 255, 0.12);
            --card-tag-border: rgba(255, 255, 255, 0.16);
            --card-tag-text: #ffffff;
            --card-number: #D9FAFF;
            --card-ink: #ffffff;
            --card-plus-bg: rgba(255, 255, 255, 0.14);
        }

        .nk-diff-stage {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-height: 188px;
            padding: 18px;
            margin-bottom: 20px;
            border-radius: 26px;
            border: 1px solid var(--card-stage-border);
            background: var(--card-stage-bg);
            overflow: hidden;
        }

        .nk-diff-stage::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(to right, var(--card-stage-grid) 0 1px, transparent 1px 26px),
                repeating-linear-gradient(to bottom, var(--card-stage-grid) 0 1px, transparent 1px 26px);
            opacity: 0.2;
            pointer-events: none;
        }

        .nk-diff-stage::after {
            content: "";
            position: absolute;
            left: -42px;
            bottom: -54px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--card-stage-orb) 0%, rgba(255, 255, 255, 0) 72%);
            pointer-events: none;
        }

        .nk-diff-card--feature .nk-diff-stage {
            min-height: 100%;
            margin-bottom: 0;
            justify-content: space-between;
        }

        .nk-diff-stage-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .nk-diff-number {
            font-family: 'Lora', serif;
            font-size: clamp(2.2rem, 2rem + 0.8vw, 3rem);
            line-height: 0.9;
            letter-spacing: -0.05em;
            color: var(--card-number);
        }

        .nk-diff-badge {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--card-accent);
            background: var(--card-plus-bg);
            border: 1px solid var(--card-stage-border);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
            flex-shrink: 0;
        }

        .nk-diff-badge svg,
        .nk-diff-illustration svg {
            width: 100%;
            height: 100%;
            fill: none;
            overflow: visible;
        }

        .nk-diff-badge svg {
            width: 22px;
            height: 22px;
        }

        .nk-diff-badge svg * {
            stroke: currentColor;
            fill: none;
            stroke-width: 1.85;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nk-diff-plus {
            position: absolute;
            z-index: 1;
            width: 18px;
            height: 18px;
            color: var(--card-accent);
            opacity: 0.72;
        }

        .nk-diff-plus::before,
        .nk-diff-plus::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 999px;
            background: currentColor;
        }

        .nk-diff-plus::before {
            width: 18px;
            height: 2px;
        }

        .nk-diff-plus::after {
            width: 2px;
            height: 18px;
        }

        .nk-diff-plus--a {
            top: 18px;
            right: 88px;
        }

        .nk-diff-plus--b {
            right: 20px;
            bottom: 18px;
            opacity: 0.42;
        }

        .nk-diff-illustration {
            position: relative;
            z-index: 1;
            width: 100%;
            min-height: 114px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .nk-diff-illustration::before {
            content: "";
            position: absolute;
            right: 0;
            width: min(78%, 160px);
            height: min(100%, 152px);
            border-radius: 28px 52px 28px 28px;
            background: linear-gradient(165deg, rgba(255, 255, 255, 0.86) 0%, rgba(255, 255, 255, 0.38) 100%);
            border: 1px solid var(--card-stage-border);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
        }

        .nk-diff-card--feature .nk-diff-illustration {
            min-height: 240px;
            justify-content: center;
        }

        .nk-diff-card--feature .nk-diff-illustration::before {
            right: auto;
            width: min(82%, 290px);
            height: min(88%, 260px);
        }

        .nk-diff-illustration svg {
            width: min(86%, 136px);
            height: min(86%, 136px);
            position: relative;
            z-index: 1;
            margin-right: 14px;
        }

        .nk-diff-card--feature .nk-diff-illustration svg {
            width: min(76%, 214px);
            height: min(76%, 214px);
            margin-right: 0;
        }

        .nk-diff-illustration .nk-ill-main,
        .nk-diff-illustration .nk-ill-main-thin,
        .nk-diff-illustration .nk-ill-accent,
        .nk-diff-illustration .nk-ill-alt {
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nk-diff-illustration .nk-ill-main {
            stroke: var(--card-ink);
            stroke-width: 2px;
        }

        .nk-diff-illustration .nk-ill-main-thin {
            stroke: var(--card-ink);
            stroke-width: 1.62px;
            opacity: 0.92;
        }

        .nk-diff-illustration .nk-ill-accent {
            stroke: var(--card-accent-alt);
            stroke-width: 1.55px;
        }

        .nk-diff-illustration .nk-ill-alt {
            stroke: var(--card-accent);
            stroke-width: 1.55px;
        }

        .nk-diff-illustration .nk-ill-fill {
            fill: var(--card-accent);
            stroke: none;
        }

        .nk-diff-body {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .nk-diff-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .nk-diff-title {
            font-size: clamp(1.34rem, 1.18rem + 0.42vw, 1.8rem);
            line-height: 1.06;
            letter-spacing: -0.045em;
            color: var(--card-heading);
            margin-bottom: 12px;
        }

        .nk-diff-desc {
            font-size: 0.97rem;
            line-height: 1.76;
            color: var(--card-text);
        }

        .nk-diff-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .nk-diff-stat {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 14px;
            border-radius: 999px;
            border: 1px solid var(--card-stat-border);
            background: var(--card-stat-bg);
            color: var(--card-heading);
            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1.35;
        }

        .nk-diff-stat::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--card-accent-alt);
            flex-shrink: 0;
        }

        .nk-diff-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--card-divider);
        }

        .nk-diff-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 999px;
            border: 1px solid var(--card-tag-border);
            background: var(--card-tag-bg);
            color: var(--card-tag-text);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .nk-diff-tag::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .nk-diff-signal {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .nk-diff-signal span {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--card-accent);
            opacity: 0.28;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .nk-diff-signal span:nth-child(2) {
            opacity: 0.56;
        }

        .nk-diff-signal span:nth-child(3) {
            opacity: 0.96;
        }

        .nk-diff-card:hover .nk-diff-signal span {
            transform: translateY(-2px);
        }

        @media (min-width: 900px) {
            .nk-diff-heading {
                grid-template-columns: minmax(0, 1.35fr) minmax(280px, 0.65fr);
            }

            .nk-diff-chip-group {
                justify-content: flex-end;
            }
        }

        @media (min-width: 768px) {
            .nk-diff-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .nk-diff-card--feature {
                grid-column: span 2;
            }

            .nk-diff-card--feature .nk-diff-card-frame {
                grid-template-columns: minmax(0, 1.06fr) minmax(280px, 0.94fr);
            }
        }

        @media (min-width: 1280px) {
            .nk-diff-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .nk-diff-card--feature {
                grid-column: span 2;
            }

            .nk-diff-card--sase {
                grid-column: span 2;
            }
        }

        /* --- ESTILOS MAPA --- */
        .nk-ping-slow { animation: nk-ping 3s cubic-bezier(0, 0, 0.2, 1) infinite; }
        @keyframes nk-ping { 75%, 100% { transform: scale(2); opacity: 0; } }

        .nk-pulse-ring {
            position: absolute;
            border-radius: 50%;
            animation: nk-ripple 2.5s linear infinite;
        }
        @keyframes nk-ripple {
            0% { width: 100%; height: 100%; opacity: 0.6; transform: scale(1); }
            100% { width: 250%; height: 250%; opacity: 0; transform: scale(2.5); }
        }

        .nk-node-hover:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease;
            cursor: pointer;
            z-index: 50;
        }

        .nk-tech-grid {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(217, 250, 255, 0.5) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(217, 250, 255, 0.5) 1px, transparent 1px);
            position: relative;
        }

        .nk-vignette { background: radial-gradient(circle, transparent 50%, rgba(255, 255, 255, 0.9) 100%); }

        .nk-infra-shell {
            background: linear-gradient(165deg, #ffffff 0%, #f8fcff 100%);
            border: 1px solid rgba(8, 26, 89, 0.08);
            box-shadow: 0 25px 70px -30px rgba(8, 26, 89, 0.28);
        }

        .nk-infra-header {
            background:
                radial-gradient(circle at 90% -20%, rgba(0, 169, 206, 0.15), transparent 45%),
                linear-gradient(180deg, #ffffff 0%, #fbfeff 100%);
        }

        .nk-infra-kicker {
            color: #00A9CE;
            letter-spacing: 0.16em;
        }

        .nk-info-panel {
            background: linear-gradient(180deg, rgba(248, 251, 255, 0.95) 0%, #ffffff 100%);
        }

        .nk-node-card {
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .nk-node-card:hover {
            background-color: rgba(0, 169, 206, 0.06);
            border-color: rgba(0, 169, 206, 0.18);
        }

        .nk-node-card.active {
            background: linear-gradient(135deg, rgba(0, 169, 206, 0.18) 0%, rgba(0, 169, 206, 0.1) 100%);
            border-color: rgba(0, 169, 206, 0.1);
            box-shadow: 0 16px 30px -24px rgba(8, 26, 89, 0.55);
        }

        .nk-sla-item {
            border: 1px solid rgba(8, 26, 89, 0.08);
            border-radius: 12px;
            background-color: #ffffff;
            padding: 10px 12px;
        }

        .nk-footer-panel {
            background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
        }

        .nk-newedge-stage {
            position: relative;
            width: calc(100% - 56px);
            max-width: 920px;
            border-radius: 24px;
            border: 1px solid rgba(8, 26, 89, 0.1);
            background:
                radial-gradient(circle at 86% 16%, rgba(0, 169, 206, 0.14), transparent 34%),
                linear-gradient(155deg, #f9fdff 0%, #f3f9ff 100%);
            box-shadow: 0 20px 42px -30px rgba(8, 26, 89, 0.5);
            overflow: hidden;
        }

        .nk-stage-kicker {
            font-size: 11px;
            font-weight: 700;
            color: #008095;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .nk-cap-card {
            border: 1px solid rgba(8, 26, 89, 0.08);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(4px);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .nk-cap-card:hover {
            transform: translateY(-2px);
            border-color: rgba(0, 169, 206, 0.32);
            box-shadow: 0 16px 30px -26px rgba(8, 26, 89, 0.5);
        }

        .nk-cap-title {
            font-size: clamp(1rem, 1.4vw, 1.2rem);
            line-height: 1.25;
        }

        .nk-latam-atlas {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .nk-latam-city {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 116px;
            padding: 14px;
            border-radius: 18px;
            border: 1px solid rgba(8, 26, 89, 0.08);
            background:
                radial-gradient(circle at 88% 12%, rgba(175, 241, 152, 0.22), transparent 34%),
                rgba(255, 255, 255, 0.9);
            box-shadow: 0 14px 30px -26px rgba(8, 26, 89, 0.52);
            overflow: hidden;
        }

        .nk-latam-city::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 4px;
            background: linear-gradient(180deg, #00A9CE 0%, #AFF198 100%);
        }

        .nk-latam-city--primary {
            grid-row: span 2;
            min-height: 244px;
            background:
                radial-gradient(circle at 82% 10%, rgba(217, 250, 255, 0.42), transparent 34%),
                linear-gradient(155deg, rgba(8, 26, 89, 0.98) 0%, rgba(0, 128, 149, 0.92) 100%);
            color: #ffffff;
        }

        .nk-latam-city--primary::before {
            width: 5px;
            background: linear-gradient(180deg, #AFF198 0%, #D9FAFF 100%);
        }

        .nk-latam-city-head {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .nk-latam-city-name {
            font-size: 0.96rem;
            line-height: 1.2;
            font-weight: 800;
            color: #081A59;
        }

        .nk-latam-city-country {
            margin-top: 3px;
            font-size: 0.68rem;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #008095;
        }

        .nk-latam-city--primary .nk-latam-city-name,
        .nk-latam-city--primary .nk-latam-city-country {
            color: #ffffff;
        }

        .nk-latam-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 30px;
            padding: 0 9px;
            border-radius: 999px;
            background: rgba(0, 169, 206, 0.12);
            color: #008095;
            font-size: 0.8rem;
            font-weight: 900;
            line-height: 1;
            flex-shrink: 0;
        }

        .nk-latam-city--primary .nk-latam-count {
            background: rgba(255, 255, 255, 0.16);
            color: #D9FAFF;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .nk-latam-node-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: auto;
            position: relative;
            z-index: 1;
        }

        .nk-latam-node {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            padding: 7px 10px;
            border-radius: 999px;
            border: 1px solid rgba(0, 169, 206, 0.2);
            background: rgba(217, 250, 255, 0.45);
            color: #081A59;
            font-size: 0.76rem;
            font-weight: 900;
            letter-spacing: 0.04em;
        }

        .nk-latam-city--primary .nk-latam-node {
            border-color: rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.13);
            color: #ffffff;
        }

        .nk-latam-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .nk-latam-summary-card {
            border-radius: 16px;
            border: 1px solid rgba(8, 26, 89, 0.08);
            background: #ffffff;
            padding: 14px 10px;
            text-align: center;
        }

        .nk-latam-summary-number {
            display: block;
            font-family: 'Lora', serif;
            font-size: 1.8rem;
            line-height: 1;
            color: #00A9CE;
        }

        .nk-latam-summary-label {
            display: block;
            margin-top: 5px;
            font-size: 0.66rem;
            line-height: 1.2;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #53565A;
        }

        .nk-latam-region-list {
            display: grid;
            gap: 8px;
        }

        .nk-latam-region {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(8, 26, 89, 0.08);
            background: rgba(255, 255, 255, 0.72);
        }

        .nk-latam-region span:first-child {
            color: #081A59;
            font-size: 0.82rem;
            font-weight: 800;
        }

        .nk-latam-region span:last-child {
            color: #008095;
            font-size: 0.76rem;
            font-weight: 900;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .nk-latam-atlas,
            .nk-latam-summary-grid {
                grid-template-columns: 1fr;
            }

            .nk-latam-city--primary {
                grid-row: auto;
                min-height: 150px;
            }
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.85);
            display: flex; justify-content: center; align-items: center;
            z-index: 1000; padding: 20px;
        }
        .modal-overlay.hidden {
            /* !important necesario: .modal-overlay ya define display:flex,
               así que la clase .hidden por sí sola (con igual especificidad)
               no ganaría la cascada sin forzar el override. */
            display: none !important;
        }
        .modal-content {
            background: white; border-radius: 20px;
            max-width: 1200px; max-height: 90vh;
            overflow-y: auto; position: relative; padding: 30px;
        }
        .close-modal {
            position: absolute; top: 20px; right: 20px;
            background: #081A59; color: white;
            border: none; border-radius: 50%; width: 40px; height: 40px;
            font-size: 20px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            z-index: 1001;
        }
        .modal-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px;
        }
        .modal-image, .modal-image-full {
            width: 100%; height: auto; border-radius: 12px; object-fit: contain;
        }
        .modal-image-full { max-height: 80vh; }

        @media (max-width: 768px) {
            .modal-grid { grid-template-columns: 1fr; }
            .modal-content { padding: 20px; }
            .nk-diff-shell {
                padding: 24px;
                border-radius: 30px;
            }
            .nk-diff-section-title {
                max-width: none;
            }
            .nk-diff-chip-group {
                gap: 8px;
            }
            .nk-diff-chip {
                width: 100%;
                justify-content: flex-start;
            }
            .nk-diff-card {
                padding: 20px;
                border-radius: 28px;
            }
            .nk-diff-stage {
                min-height: 172px;
                padding: 16px;
                border-radius: 22px;
            }
            .nk-diff-badge {
                width: 44px;
                height: 44px;
                border-radius: 15px;
            }
            .nk-diff-plus--a {
                right: 78px;
            }
            .nk-diff-illustration {
                min-height: 100px;
            }
            .nk-diff-illustration::before {
                width: min(78%, 144px);
                height: min(100%, 138px);
            }
            .nk-diff-illustration svg {
                width: min(84%, 124px);
                height: min(84%, 124px);
                margin-right: 12px;
            }
            .nk-diff-card--feature .nk-diff-illustration {
                min-height: 190px;
            }
            .nk-diff-card--feature .nk-diff-illustration::before {
                width: min(88%, 240px);
                height: min(88%, 210px);
            }
            .nk-diff-card--feature .nk-diff-illustration svg {
                width: min(76%, 180px);
                height: min(76%, 180px);
                margin-right: 0;
            }
            .nk-diff-meta,
            .nk-diff-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            .nk-diff-tag {
                letter-spacing: 0.12em;
            }
        }

        /* Unified language switcher */
        .language-switcher {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(8, 26, 89, 0.12);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 8px 20px rgba(8, 26, 89, 0.08);
        }

        .lang-btn {
            min-width: 36px;
            height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            border: 1px solid transparent;
            background: transparent;
            color: #081A59;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .lang-btn:hover {
            background: rgba(0, 169, 206, 0.12);
            border-color: rgba(0, 169, 206, 0.35);
            color: #081A59;
        }

        .lang-btn.active {
            background: #081A59;
            border-color: #081A59;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(8, 26, 89, 0.28);
        }
    </style>
<!-- CSS de Tailwind pre-compilado/inline (salida de build, minificado) más
     metaetiquetas SEO/social duplicadas del <head>. No editar a mano: si se
     necesitan nuevas utilidades de Tailwind, deben regenerarse con el build
     habitual; los cambios manuales aquí se perderían en la próxima compilación. -->
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.pointer-events-none{pointer-events:none}.absolute{position:absolute}.relative{position:relative}.sticky{position:sticky}.-inset-1{inset:-0.25rem}.inset-0{inset:0px}.right-0{right:0px}.top-0{top:0px}.-right-20{right:-5rem}.bottom-20{bottom:5rem}.bottom-4{bottom:1rem}.left-0{left:0px}.left-4{left:1rem}.right-4{right:1rem}.top-4{top:1rem}.z-10{z-index:10}.z-50{z-index:50}.mx-auto{margin-left:auto;margin-right:auto}.mb-12{margin-bottom:3rem}.mb-8{margin-bottom:2rem}.mb-0\.5{margin-bottom:0.125rem}.mb-1{margin-bottom:0.25rem}.mb-16{margin-bottom:4rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.ml-1{margin-left:0.25rem}.mt-1{margin-top:0.25rem}.mt-1\.5{margin-top:0.375rem}.mt-10{margin-top:2.5rem}.mt-2{margin-top:0.5rem}.mt-3{margin-top:0.75rem}.mt-5{margin-top:1.25rem}.mt-6{margin-top:1.5rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-1{height:0.25rem}.h-20{height:5rem}.h-8{height:2rem}.h-full{height:100%}.h-1\.5{height:0.375rem}.h-10{height:2.5rem}.h-12{height:3rem}.h-3{height:0.75rem}.h-32{height:8rem}.h-5{height:1.25rem}.h-6{height:1.5rem}.h-auto{height:auto}.min-h-screen{min-height:100vh}.min-h-\[360px\]{min-height:360px}.w-1\/2{width:50%}.w-8{width:2rem}.w-auto{width:auto}.w-1\.5{width:0.375rem}.w-10{width:2.5rem}.w-12{width:3rem}.w-20{width:5rem}.w-3{width:0.75rem}.w-32{width:8rem}.w-5{width:1.25rem}.w-full{width:100%}.w-px{width:1px}.max-w-5xl{max-width:64rem}.max-w-7xl{max-width:80rem}.max-w-2xl{max-width:42rem}.max-w-3xl{max-width:48rem}.max-w-4xl{max-width:56rem}.max-w-6xl{max-width:72rem}.max-w-xl{max-width:36rem}.shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}.cursor-pointer{cursor:pointer}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.items-baseline{align-items:baseline}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-3{gap:0.75rem}.gap-6{gap:1.5rem}.gap-1\.5{gap:0.375rem}.gap-16{gap:4rem}.gap-2{gap:0.5rem}.gap-4{gap:1rem}.gap-8{gap:2rem}.space-x-1 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.25rem * var(--tw-space-x-reverse));margin-left:calc(0.25rem * calc(1 - var(--tw-space-x-reverse)))}.space-x-3 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.75rem * var(--tw-space-x-reverse));margin-left:calc(0.75rem * calc(1 - var(--tw-space-x-reverse)))}.space-x-4 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1rem * var(--tw-space-x-reverse));margin-left:calc(1rem * calc(1 - var(--tw-space-x-reverse)))}.space-y-2 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.5rem * var(--tw-space-y-reverse))}.space-y-3 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.75rem * var(--tw-space-y-reverse))}.space-y-4 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse))}.space-y-6 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem * var(--tw-space-y-reverse))}.divide-y > :not([hidden]) ~ :not([hidden]){--tw-divide-y-reverse:0;border-top-width:calc(1px * calc(1 - var(--tw-divide-y-reverse)));border-bottom-width:calc(1px * var(--tw-divide-y-reverse))}.divide-gray-200 > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(229 231 235 / var(--tw-divide-opacity, 1))}.overflow-hidden{overflow:hidden}.rounded-3xl{border-radius:1.5rem}.rounded-\[28px\]{border-radius:28px}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-netskope{border-radius:24px}.rounded-xl{border-radius:0.75rem}.rounded-bl-\[100px\]{border-bottom-left-radius:100px}.rounded-br-lg{border-bottom-right-radius:0.5rem}.rounded-tl-lg{border-top-left-radius:0.5rem}.border{border-width:1px}.border-b{border-bottom-width:1px}.border-b-2{border-bottom-width:2px}.border-l-2{border-left-width:2px}.border-r-2{border-right-width:2px}.border-t{border-top-width:1px}.border-t-2{border-top-width:2px}.border-gray-100{--tw-border-opacity:1;border-color:rgb(243 244 246 / var(--tw-border-opacity, 1))}.border-gray-100\/90{border-color:rgb(243 244 246 / 0.9)}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-netskope-blue\/20{border-color:rgb(0 169 206 / 0.2)}.border-nk-blue\/15{border-color:rgb(0 169 206 / 0.15)}.border-white\/20{border-color:rgb(255 255 255 / 0.2)}.bg-netskope-green{--tw-bg-opacity:1;background-color:rgb(175 241 152 / var(--tw-bg-opacity, 1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-gray-200{--tw-bg-opacity:1;background-color:rgb(229 231 235 / var(--tw-bg-opacity, 1))}.bg-netskope-blue{--tw-bg-opacity:1;background-color:rgb(0 169 206 / var(--tw-bg-opacity, 1))}.bg-netskope-lightBlue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-netskope-lightBlue\/40{background-color:rgb(217 250 255 / 0.4)}.bg-netskope-offWhite{--tw-bg-opacity:1;background-color:rgb(245 245 245 / var(--tw-bg-opacity, 1))}.bg-netskope-teal{--tw-bg-opacity:1;background-color:rgb(0 128 149 / var(--tw-bg-opacity, 1))}.bg-nk-deep-blue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.bg-nk-light-blue{--tw-bg-opacity:1;background-color:rgb(217 250 255 / var(--tw-bg-opacity, 1))}.bg-nk-off-white{--tw-bg-opacity:1;background-color:rgb(245 245 245 / var(--tw-bg-opacity, 1))}.bg-transparent{background-color:transparent}.bg-white\/10{background-color:rgb(255 255 255 / 0.1)}.bg-white\/80{background-color:rgb(255 255 255 / 0.8)}.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.bg-gradient-confident{background-image:linear-gradient(135deg, #081A59 0%, #00A9CE 100%)}.bg-gradient-neon{background-image:linear-gradient(135deg, #00A9CE 0%, #AFF198 100%)}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.bg-gradient-to-br{background-image:linear-gradient(to bottom right, var(--tw-gradient-stops))}.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops))}.from-netskope-lightBlue\/50{--tw-gradient-from:rgb(217 250 255 / 0.5) var(--tw-gradient-from-position);--tw-gradient-to:rgb(217 250 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-netskope-blue\/20{--tw-gradient-from:rgb(0 169 206 / 0.2) var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 169 206 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.from-white{--tw-gradient-from:#fff var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position)}.to-netskope-green\/20{--tw-gradient-to:rgb(175 241 152 / 0.2) var(--tw-gradient-to-position)}.to-nk-light-blue\/10{--tw-gradient-to:rgb(217 250 255 / 0.1) var(--tw-gradient-to-position)}.p-6{padding:1.5rem}.p-7{padding:1.75rem}.p-8{padding:2rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-4{padding-left:1rem;padding-right:1rem}.px-5{padding-left:1.25rem;padding-right:1.25rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-12{padding-top:3rem;padding-bottom:3rem}.py-2\.5{padding-top:0.625rem;padding-bottom:0.625rem}.py-24{padding-top:6rem;padding-bottom:6rem}.py-4{padding-top:1rem;padding-bottom:1rem}.py-5{padding-top:1.25rem;padding-bottom:1.25rem}.py-6{padding-top:1.5rem;padding-bottom:1.5rem}.pb-24{padding-bottom:6rem}.pt-20{padding-top:5rem}.pb-5{padding-bottom:1.25rem}.pt-4{padding-top:1rem}.pt-5{padding-top:1.25rem}.text-left{text-align:left}.text-center{text-align:center}.text-right{text-align:right}.font-mono{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}.text-5xl{font-size:3rem;line-height:1}.text-base{font-size:1rem;line-height:1.5rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-\[10px\]{font-size:10px}.text-\[11px\]{font-size:11px}.text-lg{font-size:1.125rem;line-height:1.75rem}.font-bold{font-weight:700}.font-light{font-weight:300}.font-normal{font-weight:400}.font-medium{font-weight:500}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.italic{font-style:italic}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.leading-6{line-height:1.5rem}.leading-none{line-height:1}.tracking-widest{letter-spacing:0.1em}.tracking-\[0\.12em\]{letter-spacing:0.12em}.tracking-\[0\.18em\]{letter-spacing:0.18em}.tracking-\[0\.22em\]{letter-spacing:0.22em}.tracking-wide{letter-spacing:0.025em}.tracking-wider{letter-spacing:0.05em}.text-netskope-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-netskope-deepBlue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-netskope-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity, 1))}.text-netskope-darkGray{--tw-text-opacity:1;color:rgb(42 43 45 / var(--tw-text-opacity, 1))}.text-netskope-green{--tw-text-opacity:1;color:rgb(175 241 152 / var(--tw-text-opacity, 1))}.text-netskope-lightBlue{--tw-text-opacity:1;color:rgb(217 250 255 / var(--tw-text-opacity, 1))}.text-netskope-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-netskope-teal{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.text-nk-blue{--tw-text-opacity:1;color:rgb(0 169 206 / var(--tw-text-opacity, 1))}.text-nk-deep-blue{--tw-text-opacity:1;color:rgb(8 26 89 / var(--tw-text-opacity, 1))}.text-nk-gray{--tw-text-opacity:1;color:rgb(83 86 90 / var(--tw-text-opacity, 1))}.text-nk-orange{--tw-text-opacity:1;color:rgb(255 130 0 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.text-white\/80{color:rgb(255 255 255 / 0.8)}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.opacity-80{opacity:0.8}.opacity-10{opacity:0.1}.opacity-20{opacity:0.2}.opacity-30{opacity:0.3}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-\[0_-5px_15px_-5px_rgba\(0\2c 0\2c 0\2c 0\.05\)\]{--tw-shadow:0 -5px 15px -5px rgba(0,0,0,0.05);--tw-shadow-colored:0 -5px 15px -5px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-soft{--tw-shadow:0 10px 40px -10px rgba(8, 26, 89, 0.08);--tw-shadow-colored:0 10px 40px -10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.blur{--tw-blur:blur(8px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.backdrop-blur-md{--tw-backdrop-blur:blur(12px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition-colors{transition-property:color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-opacity{transition-property:opacity;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.transition-shadow{transition-property:box-shadow;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.duration-300{transition-duration:300ms}.hover\:border-nk-light-blue:hover{--tw-border-opacity:1;border-color:rgb(217 250 255 / var(--tw-border-opacity, 1))}.hover\:text-netskope-teal:hover{--tw-text-opacity:1;color:rgb(0 128 149 / var(--tw-text-opacity, 1))}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.hover\:shadow-lg:hover{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.group:hover .group-hover\:bg-nk-deep-blue{--tw-bg-opacity:1;background-color:rgb(8 26 89 / var(--tw-bg-opacity, 1))}.group:hover .group-hover\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.group:hover .group-hover\:opacity-20{opacity:0.2}@media (min-width: 640px){.sm\:block{display:block}.sm\:w-auto{width:auto}.sm\:flex-row{flex-direction:row}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}}@media (min-width: 768px){.md\:flex{display:flex}.md\:min-h-\[500px\]{min-height:500px}.md\:w-1\/3{width:33.333333%}.md\:w-2\/3{width:66.666667%}.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.md\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.md\:grid-cols-4{grid-template-columns:repeat(4, minmax(0, 1fr))}.md\:flex-row{flex-direction:row}.md\:gap-5{gap:1.25rem}.md\:divide-x > :not([hidden]) ~ :not([hidden]){--tw-divide-x-reverse:0;border-right-width:calc(1px * var(--tw-divide-x-reverse));border-left-width:calc(1px * calc(1 - var(--tw-divide-x-reverse)))}.md\:divide-y-0 > :not([hidden]) ~ :not([hidden]){--tw-divide-y-reverse:0;border-top-width:calc(0px * calc(1 - var(--tw-divide-y-reverse)));border-bottom-width:calc(0px * var(--tw-divide-y-reverse))}.md\:border-l{border-left-width:1px}.md\:border-t-0{border-top-width:0px}.md\:p-10{padding:2.5rem}.md\:p-7{padding:1.75rem}.md\:p-8{padding:2rem}.md\:px-12{padding-left:3rem;padding-right:3rem}.md\:px-8{padding-left:2rem;padding-right:2rem}.md\:py-8{padding-top:2rem;padding-bottom:2rem}.md\:pt-0{padding-top:0px}.md\:text-left{text-align:left}.md\:text-right{text-align:right}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-7xl{font-size:4.5rem;line-height:1}.md\:text-3xl{font-size:1.875rem;line-height:2.25rem}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-5xl{font-size:3rem;line-height:1}.md\:text-base{font-size:1rem;line-height:1.5rem}.md\:text-xl{font-size:1.25rem;line-height:1.75rem}}@media (min-width: 1024px){.lg\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}}@media (min-width: 1280px){.xl\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}}</style><meta name="application-name" content="Democenter Netskope | Diferenciadores Clave"><meta name="apple-mobile-web-app-title" content="Democenter Netskope | Diferenciadores Clave"><meta name="theme-color" content="#081A59"><meta property="og:title" content="Democenter Netskope | Diferenciadores Clave"><meta property="og:description" content="Resumen estructurado de los diferenciadores de Netskope para reforzar mensajes comerciales consistentes."><meta property="og:type" content="website"><!-- URL canónica de producción del demo center (fija, no una IP/credencial); usada para SEO/og:url. --><link rel="canonical" href="https://democenter.ib-demo.com/demolatam/keydifferentiators.php">    <!-- TEAM-HIDE:CHATBOT css <link rel="stylesheet" href="/assets/css/demo-chat.css?v=4"> -->
</head>
<body class="flex flex-col min-h-screen antialiased text-base" data-site-shell="ready" data-page-name="keydifferentiators" data-page-kind="story">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 site-shell-header">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between site-shell-header-inner">
            <a href="index.php" class="site-shell-logo"><img src="assets/images/brand/netskope-logo-stacked-color.png" alt="Netskope" class="h-8 w-auto"></a>
            
            <div class="flex items-center gap-6 site-shell-toolbar">
                <div class="hidden md:flex items-center">
                    <span class="text-xs font-bold text-netskope-deepBlue tracking-widest uppercase opacity-80" data-i18n="who_is_netskope">¿Quién es Netskope?</span>
                </div>

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
                    <span class="w-8 h-1 bg-netskope-green"></span>
                    <span class="text-netskope-deepBlue font-bold text-sm tracking-widest uppercase" data-i18n="why_netskope">Por qué Netskope</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold text-netskope-deepBlue mb-8 leading-tight">
                    <span data-i18n="hero_title_1">Tu seguridad</span> <br>
                    <span class="font-lora italic font-normal text-netskope-blue" data-i18n="hero_title_2">sin límites.</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-netskope-gray font-light leading-relaxed mb-12">
                    <span data-i18n="hero_desc_1">La única plataforma que converge capacidades de seguridad y red líderes en el mercado en una arquitectura unificada.</span><br>
                    <strong class="text-netskope-deepBlue font-semibold" data-i18n="hero_desc_2">Validado por los analistas. Con la confianza de nuestros clientes.</strong>
                </p>

                <!-- Analyst Validation Bar -->
                <div class="bg-white/80 backdrop-blur-md border border-netskope-blue/20 p-8 rounded-netskope shadow-soft w-full">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-center divide-y md:divide-y-0 md:divide-x divide-gray-200">
                        <div class="text-center px-4">
                            <div class="text-sm font-bold text-netskope-deepBlue uppercase mb-2">Gartner</div>
                            <button type="button" class="analyst-trigger" data-modal-trigger="gartnerModal" aria-haspopup="dialog" aria-controls="gartnerModal"><span class="analyst-trigger-label text-2xl font-bold text-netskope-blue hover:text-netskope-teal transition-colors" id="gartnerTrigger" data-i18n="leader_sse_sase">Líder SSE y SASE</span></button>
                            <p class="text-xs text-netskope-gray mt-1" data-i18n="gartner_sub">Cuadrante Mágico SSE &amp; Single Vendor SASE</p>
                        </div>
                        <div class="text-center px-4 pt-4 md:pt-0">
                            <div class="text-sm font-bold text-netskope-deepBlue uppercase mb-2">Forrester</div>
                            <button type="button" class="analyst-trigger" data-modal-trigger="forresterModal" aria-haspopup="dialog" aria-controls="forresterModal"><span class="analyst-trigger-label text-2xl font-bold text-netskope-blue hover:text-netskope-teal transition-colors" id="forresterTrigger" data-i18n="leader_wave">Líder Wave</span></button>
                            <p class="text-xs text-netskope-gray mt-1" data-i18n="forrester_sub">Soluciones de Security Service Edge</p>
                        </div>
                        <div class="text-center px-4 pt-4 md:pt-0">
                            <div class="text-sm font-bold text-netskope-deepBlue uppercase mb-2">IDC</div>
                            <button type="button" class="analyst-trigger" data-modal-trigger="idcModal" aria-haspopup="dialog" aria-controls="idcModal"><span class="analyst-trigger-label text-2xl font-bold text-netskope-blue hover:text-netskope-teal transition-colors" data-i18n="leader_marketscape">Líder MarketScape</span></button>
                            <p class="text-xs text-netskope-gray mt-1" data-i18n="idc_sub">worldwide DLP</p>
                        </div>
                        <div class="text-center px-4 pt-4 md:pt-0">
                            <div class="text-sm font-bold text-netskope-deepBlue uppercase mb-2" data-i18n="customers">Clientes</div>
                            <div class="text-2xl font-bold text-netskope-blue" data-i18n="ref_count">Más de 400 referencias</div>
                            <a href="customerreferences.php" class="block mt-2" id="customerReferencesLink">
                                <span class="text-sm font-bold text-netskope-deepBlue underline" data-i18n="see_details">Ver Detalles</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="absolute -right-20 bottom-20 text-netskope-green opacity-20">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path>
            </svg>
        </div>
    </section>

    <!-- Modal Gartner -->
    <div id="gartnerModal" class="modal-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="gartnerModalTitle">
        <div class="modal-content">
            <button class="close-modal" type="button" data-modal-close="gartnerModal" id="closeModal" aria-label="Cerrar">×</button>
            <h3 id="gartnerModalTitle" class="text-2xl font-bold text-netskope-deepBlue mb-6 text-center" data-i18n="gartner_recognition">Reconocimientos Gartner</h3>
            <div class="modal-grid">
                <div>
                    <h4 class="text-lg font-bold text-netskope-blue mb-4">Magic Quadrant for Security Service Edge (Jul 2026)</h4>
                    <img src="assets/images/external/gartner-sse-2026.png" class="modal-image" alt="Gartner SSE Quadrant" style="height: 400px;">
                    <p class="text-sm text-gray-600 mt-3" data-i18n="gartner_desc_sse">Netskope reconocido como Líder en el Cuadrante Mágico de SSE</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-netskope-blue mb-4">Magic Quadrant for SASE Platforms (Jul 2026)</h4>
                    <img src="assets/images/external/gartner-sase-2026.png" class="modal-image" alt="Gartner SASE Quadrant" style="height: 400px;">
                    <p class="text-sm text-gray-600 mt-3" data-i18n="gartner_desc_sase">Netskope reconocido como Líder en el Cuadrante Mágico de SASE Platforms</p>
                </div>
            </div>
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© Gartner, Inc. | As of July 2026</p>
            </div>
        </div>
    </div>

    <!-- Modal Forrester -->
    <div id="forresterModal" class="modal-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="forresterModalTitle">
        <div class="modal-content max-w-5xl">
            <button class="close-modal" type="button" data-modal-close="forresterModal" id="closeForresterModal" aria-label="Cerrar">×</button>
            <h3 id="forresterModalTitle" class="text-2xl font-bold text-netskope-deepBlue mb-6 text-center" data-i18n="forrester_recognition">Reconocimiento Forrester</h3>
            <div class="max-w-4xl mx-auto">
                <h4 class="text-lg font-bold text-netskope-blue mb-4 text-center">Forrester Wave: Security Service Edge Solutions (Q3 2025)</h4>
                <img src="assets/images/external/forrester-wave-sse-2025.png" class="modal-image" alt="Forrester Wave for Security Service Edge Solutions" style="width: 75%; max-height: 75vh; border-radius: 0; margin: 0 auto;">
                <p class="text-sm text-gray-600 mt-3 text-center" data-i18n="forrester_desc">Netskope reconocido como Wave Leader en Security Service Edge Solutions.</p>
            </div>
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Forrester Wave for Security Service Edge Solutions | Q3 2025</p>
            </div>
        </div>
    </div>

    <!-- Modal IDC -->
    <div id="idcModal" class="modal-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="idcModalTitle">
        <div class="modal-content max-w-3xl">
            <button class="close-modal" type="button" data-modal-close="idcModal" aria-label="Cerrar">×</button>
            <h3 id="idcModalTitle" class="text-2xl font-bold text-netskope-deepBlue mb-6 text-center" data-i18n="idc_recognition">Reconocimiento IDC MarketScape</h3>
            <div class="max-w-xl mx-auto">
                <h4 class="text-lg font-bold text-netskope-blue mb-4 text-center">IDC MarketScape: worldwide DLP</h4>
                <img src="assets/images/analyst/idc-worldwide-dlp-marketscape.png" class="modal-image w-full" alt="IDC MarketScape worldwide DLP" style="max-height: 70vh;">
                <p class="text-sm text-gray-600 mt-3 text-center" data-i18n="idc_desc">Netskope reconocido como Líder en IDC MarketScape para worldwide DLP.</p>
            </div>
        </div>
    </div>

    <!-- Unified Platform -->
    <section class="py-24 bg-gradient-confident text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-net opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-white to-transparent opacity-10"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left: Narrative -->
                <div>
                    <span class="text-netskope-green font-bold text-xs uppercase tracking-widest mb-2 block" data-i18n="converged_platform">Plataforma Convergente</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-i18n="simplify_ops">Simplifica tus Operaciones.</h2>
                    <p class="text-lg text-netskope-lightBlue font-light leading-relaxed mb-8" data-i18n="improve_sec">Mejora la Seguridad mientras reduces la complejidad, los costos y la carga operativa con una plataforma cloud nativa.</p>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-netskope-green flex items-center justify-center text-netskope-deepBlue shrink-0 font-bold text-lg">1</div>
                            <div>
                                <h4 class="text-xl font-bold mb-1" data-i18n="single_console">Una Sola Consola</h4>
                                <p class="text-sm text-white/80" data-i18n="single_console_desc">Gestión unificada de políticas, incidentes y análisis para SWG, CASB, ZTNA, DSPM y SD-WAN. Visibilidad completa en un solo dashboard.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-netskope-blue flex items-center justify-center text-white shrink-0 font-bold text-lg">1</div>
                            <div>
                                <h4 class="text-xl font-bold mb-1" data-i18n="single_client">Un Solo Cliente</h4>
                                <p class="text-sm text-white/80" data-i18n="single_client_desc">Un agente ligero que dirige tráfico web, cloud y privado, aplicando protección del dato sin afectar el rendimiento.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-netskope-teal flex items-center justify-center text-white shrink-0 font-bold text-lg">1</div>
                            <div>
                                <h4 class="text-xl font-bold mb-1" data-i18n="single_engine">Un Solo Motor</h4>
                                <p class="text-sm text-white/80" data-i18n="single_engine_desc">El <strong>Zero Trust Engine</strong> decodifica el tráfico una sola vez y aplica todas las políticas de seguridad simultáneamente en Single Pass.</p>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="mt-10 p-6 bg-white/10 rounded-lg border border-white/20">
                        <p class="text-lg text-white font-medium">
                            <strong class="text-netskope-green" data-i18n="objective">El objetivo:</strong> <span data-i18n="objective_desc">Proteger al usuario esté donde esté sin empeorar la experiencia del usuario.</span>
                        </p>
                    </div>
                </div>

                <!-- Right: Platform Visualization -->
                <div class="grid grid-cols-1 gap-8">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-neon rounded-netskope blur opacity-30"></div>
                        <div class="relative bg-white text-netskope-darkGray p-8 rounded-netskope shadow-2xl h-full">
                            <div class="text-center mb-8">
                                <h3 class="text-3xl font-bold text-netskope-deepBlue mb-2">NewEdge</h3>
                                <p class="text-lg text-netskope-gray" data-i18n="newedge_slogan">La red de seguridad más conectada del mundo</p>
                            </div>
                            
                            <div class="space-y-6 mb-8">
                                <div class="flex items-start gap-3">
                                    <span class="w-3 h-3 rounded-full bg-netskope-green mt-1.5"></span>
                                    <div><span class="text-lg font-medium" data-i18n="newedge_stat_1">+120 data centers | +75 Regiones</span></div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="w-3 h-3 rounded-full bg-netskope-green mt-1.5"></span>
                                    <div><span id="newedge-stat-2" class="text-lg font-medium" data-i18n="newedge_stat_2">13 nodos activos en Latinoamérica</span></div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="w-3 h-3 rounded-full bg-netskope-green mt-1.5"></span>
                                    <div><span class="text-lg font-medium" data-i18n="newedge_stat_3">Compute Completo y peering directo a AWS, GCP y Azure</span></div>
                                </div>
                            </div>
                            
                            <div class="text-center mb-8">
                                <img src="assets/images/external/newedge-coverage.svg" alt="NewEdge Network Coverage" class="w-full h-auto rounded-lg border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow" id="newedgeImage">
                                <p class="text-sm text-netskope-gray mt-2" data-i18n="click_zoom">Haz clic para ampliar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal NewEdge Image -->
    <div id="newedgeModal" class="modal-overlay hidden">
        <div class="modal-content max-w-6xl">
            <button class="close-modal" type="button" id="closeNewedgeModal" aria-label="Cerrar">×</button>
            <h3 class="text-2xl font-bold text-netskope-deepBlue mb-6 text-center" data-i18n="newedge_global_coverage">Cobertura Global NewEdge</h3>
            <img src="assets/images/external/newedge-coverage.svg" alt="NewEdge Network Coverage" class="modal-image-full">
            <div class="mt-6 text-center">
                <p class="text-lg font-bold text-netskope-deepBlue" data-i18n="newedge_slogan">La red de seguridad más conectada del mundo</p>
                <p class="text-sm text-gray-600 mt-2" data-i18n="newedge_modal_sub">+120 data centers | +75 Regiones | Compute Completo en cada nodo</p>
            </div>
        </div>
    </div>

    <!-- Key Differentiators Grid -->
    <section class="py-6 bg-netskope-offWhite">
        <div class="container mx-auto px-6 md:px-12">

            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-netskope-deepBlue mb-4" data-i18n="use_cases_title">Casos de Uso de Netskope</h2>
                <div class="w-20 h-1.5 bg-gradient-neon mx-auto rounded-full"></div>
                <p class="text-netskope-gray mt-6 max-w-2xl mx-auto" data-i18n="use_cases_sub">Soluciones específicas para los desafíos de seguridad más críticos del mercado</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Differentiator 1: NewEdge -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-netskope-teal" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-1.07 3.97-2.74 5.27z"></path></svg>
                    </div>
                    
                    <div class="nk-diff-icon w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="network" aria-hidden="true" class="lucide lucide-network leading-none"><rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10">NewEdge</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_newedge_desc">Nuestra infraestructura está en puntos neutros de IX, no depende de nubes públicas. NewEdge es la red de seguridad más conectada del mundo.</p>
                    <div class="pt-4 border-t border-gray-100 space-y-2 mt-auto relative z-10">
                         <div class="flex items-center gap-2 text-xs text-netskope-gray">
                            <span class="w-1.5 h-1.5 rounded-full bg-netskope-green"></span>
                            <span data-i18n="stat_dcs">+120 data centers</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-netskope-gray">
                            <span class="w-1.5 h-1.5 rounded-full bg-netskope-green"></span>
                            <span data-i18n="stat_regions">+75 Regiones</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-netskope-gray">
                            <span class="w-1.5 h-1.5 rounded-full bg-netskope-green"></span>
                            <span data-i18n="stat_compute">Compute Completo (Sin Hairpinning)</span>
                        </div>
                    </div>
                </div>

                <!-- Differentiator 2: Context & Decryption -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                         <svg class="w-32 h-32 text-netskope-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path></svg>
                    </div>

                    <div class="nk-diff-icon w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="eye" aria-hidden="true" class="lucide lucide-eye leading-none"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10" data-i18n="diff_visibility_title">Visibilidad y Control Profundo</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_visibility_desc">Vamos más allá de permitir o bloquear dominios. Entendemos el lenguaje de la nube (JSON, API) para aplicar controles granulares basados en el contexto.</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto relative z-10 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-netskope-lightBlue/40 text-netskope-teal text-[10px] font-bold uppercase tracking-wider">
                            <span class="nk-diff-chip-icon inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="code-2" aria-hidden="true" class="lucide lucide-code-2 leading-none"><path d="m18 16 4-4-4-4"></path><path d="m6 8-4 4 4 4"></path><path d="m14.5 4-5 16"></path></svg>
                            </span>
                            <span data-i18n="tag_cloud_decode">Decodificación Cloud</span>
                        </span>
                    </div>
                </div>

                <!-- Differentiator 3: Data Protection -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                         <svg class="w-32 h-32 text-netskope-deepBlue" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></svg>
                    </div>

                    <div class="nk-diff-icon nk-diff-icon--lock w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="lock" aria-hidden="true" class="lucide lucide-lock leading-none"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10" data-i18n="diff_dlp_title">DLP Avanzado con IA</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_dlp_desc">Protección de datos de nivel Enterprise. Clasificación por ML para imágenes (pasaportes, capturas) y documentos, no solo expresiones regulares o diccionarios.</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto relative z-10 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-netskope-lightBlue/40 text-netskope-teal text-[10px] font-bold uppercase tracking-wider">
                            <span class="nk-diff-chip-icon inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="target" aria-hidden="true" class="lucide lucide-target leading-none"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                            </span>
                            <span data-i18n="tag_precision">Precisión Extrema</span>
                        </span>
                    </div>
                </div>

                 <!-- Differentiator 4: AI Security -->
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                         <svg class="w-32 h-32 text-netskope-green" fill="currentColor" viewBox="0 0 24 24"><path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21 1.01.33 2.05.33 3.13 0 4.41-3.59 8-8 8z"></path></svg>
                    </div>

                    <div class="nk-diff-icon w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="bot" aria-hidden="true" class="lucide lucide-bot leading-none"><path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10" data-i18n="diff_ai_title">Líderes en Seguridad de IA</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_ai_desc">Habilita el uso seguro de la IA generativa. Netskope ofrece la visibilidad y el control más completos del mercado para aplicaciones como ChatGPT y Copilot.</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto relative z-10 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-netskope-lightBlue/40 text-netskope-teal text-[10px] font-bold uppercase tracking-wider">
                            <span class="nk-diff-chip-icon inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="sparkles" aria-hidden="true" class="lucide lucide-sparkles leading-none"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg>
                            </span>
                            <span>SkopeAI</span>
                        </span>
                    </div>
                </div>

                 <!-- Differentiator 5: Digital Experience -->
                 <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-netskope-orange" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                    </div>

                    <div class="nk-diff-icon w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="gauge" aria-hidden="true" class="lucide lucide-gauge leading-none"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10" data-i18n="diff_dem_title">Experiencia de Usuario (DEM)</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_dem_desc">La seguridad no debe empeorar la experiencia del usuario. Monitorea y optimiza su experiencia de extremo a extremo con visibilidad hop-by-hop.</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto relative z-10 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-netskope-lightBlue/40 text-netskope-teal text-[10px] font-bold uppercase tracking-wider">
                            <span class="nk-diff-chip-icon inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="zap" aria-hidden="true" class="lucide lucide-zap leading-none"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>
                            </span>
                            <span data-i18n="tag_proactive">Proactividad</span>
                        </span>
                    </div>
                </div>

                <!-- Differentiator 6: Single Vendor SASE -->
                <div class="bg-white p-8 rounded-netskope shadow-soft card-hover group flex flex-col h-full relative overflow-hidden bubble-shape">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-netskope-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"></path></svg>
                    </div>

                    <div class="nk-diff-icon w-12 h-12 bg-netskope-lightBlue rounded-xl flex items-center justify-center text-netskope-blue mb-6 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="cloud-upload" aria-hidden="true" class="lucide lucide-cloud-upload leading-none"><path d="M12 13v8"></path><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="m8 17 4-4 4 4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-netskope-deepBlue mb-3 relative z-10">Single Vendor SASE</h3>
                    <p class="text-sm text-netskope-gray mb-6 flex-grow relative z-10" data-i18n="diff_sase_desc">La única solución SASE completa de un único proveedor. Integración nativa de redes y seguridad en una arquitectura unificada que elimina la complejidad.</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto relative z-10 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-netskope-lightBlue/40 text-netskope-teal text-[10px] font-bold uppercase tracking-wider">
                            <span class="nk-diff-chip-icon inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="layers-3" aria-hidden="true" class="lucide lucide-layers-3 leading-none"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                            </span>
                            <span data-i18n="tag_unified">Arquitectura Unificada</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- INFRAESTRUCTURA IBERIA SECTION -->
    <!-- Visible por defecto (español / LATAM); se oculta en otros idiomas y se
         reemplaza por #infra-glance-shell más abajo. Ver updateLanguageSpecificContent(). -->
    <section id="netskope-infra-section" class="w-full px-4 py-6 md:py-8 flex justify-center items-center bg-transparent">
        <div id="infra-iberia-shell" class="nk-infra-shell w-full max-w-6xl mx-auto rounded-3xl overflow-hidden flex flex-col" aria-hidden="false">
            
            <div class="nk-infra-header p-7 md:p-10 pb-5 text-center border-b border-gray-100/90">
                <h2 class="nk-infra-kicker text-xs font-bold uppercase mb-2">NewEdge Network</h2>
                <h1 class="text-3xl md:text-5xl font-bold text-nk-deep-blue leading-tight" data-i18n="infra_title">Infraestructura en Latinoamérica</h1>
                <p class="text-gray-500 mt-3 text-sm md:text-base" data-i18n="infra_subtitle">Topología de red de alta disponibilidad</p>
            </div>

            <div class="flex flex-col md:flex-row flex-grow">
                <!-- MAPA -->
                <div class="w-full md:w-2/3 relative flex items-start justify-center min-h-[360px] md:min-h-[500px] bg-white nk-tech-grid overflow-hidden py-6">
                    <div class="absolute inset-0 nk-vignette pointer-events-none"></div>

                    <div class="nk-newedge-stage z-10 p-6 md:p-8">
                        <p class="nk-stage-kicker" data-i18n="infra_stage_kicker">NewEdge en Latinoamérica</p>
                        <h3 class="text-2xl md:text-3xl font-bold text-nk-deep-blue leading-tight mb-6" data-i18n="infra_stage_title">Infraestructura propia, conectada donde realmente pasa Internet.</h3>

                        <div class="nk-latam-atlas">
                            <article class="nk-latam-city nk-latam-city--primary">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">São Paulo</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_brazil">Brasil</p>
                                    </div>
                                    <span class="nk-latam-count">3</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">SAO1</span>
                                    <span class="nk-latam-node">SAO3</span>
                                    <span class="nk-latam-node">SAO4</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Buenos Aires</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_argentina">Argentina</p>
                                    </div>
                                    <span class="nk-latam-count">1</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">BUE1</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Santiago</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_chile">Chile</p>
                                    </div>
                                    <span class="nk-latam-count">2</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">SCL1</span>
                                    <span class="nk-latam-node">SCL2</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Bogotá</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_colombia">Colombia</p>
                                    </div>
                                    <span class="nk-latam-count">2</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">BOG1</span>
                                    <span class="nk-latam-node">BOG2</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Lima</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_peru">Perú</p>
                                    </div>
                                    <span class="nk-latam-count">1</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">LIM1</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Querétaro</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_mexico">México</p>
                                    </div>
                                    <span class="nk-latam-count">1</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">QRO1</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Brasília</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_brazil">Brasil</p>
                                    </div>
                                    <span class="nk-latam-count">1</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">BSB1</span>
                                </div>
                            </article>

                            <article class="nk-latam-city">
                                <div class="nk-latam-city-head">
                                    <div>
                                        <h4 class="nk-latam-city-name">Rio de Janeiro</h4>
                                        <p class="nk-latam-city-country" data-i18n="country_brazil">Brasil</p>
                                    </div>
                                    <span class="nk-latam-count">1</span>
                                </div>
                                <div class="nk-latam-node-list">
                                    <span class="nk-latam-node">GIG1</span>
                                </div>
                            </article>
                        </div>
                    </div>
                    
                    <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-gray-200 rounded-tl-lg"></div>
                    <div class="absolute bottom-4 right-4 w-8 h-8 border-b-2 border-r-2 border-gray-200 rounded-br-lg"></div>
                </div>

                <!-- INFO PANNEL -->
                <div class="nk-info-panel w-full md:w-1/3 p-6 md:p-8 border-t md:border-t-0 md:border-l border-gray-100 flex flex-col justify-center space-y-4">
                    
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-[0.12em] mb-2" data-i18n="node_status">Estado de los Nodos</h3>

                    <div class="nk-latam-summary-grid">
                        <div class="nk-latam-summary-card">
                            <span class="nk-latam-summary-number">13</span>
                            <span class="nk-latam-summary-label" data-i18n="latam_nodes_label">Nodos</span>
                        </div>
                        <div class="nk-latam-summary-card">
                            <span class="nk-latam-summary-number">8</span>
                            <span class="nk-latam-summary-label" data-i18n="latam_cities_label">Ciudades</span>
                        </div>
                        <div class="nk-latam-summary-card">
                            <span class="nk-latam-summary-number">6</span>
                            <span class="nk-latam-summary-label" data-i18n="latam_countries_label">Países</span>
                        </div>
                    </div>

                    <div class="nk-latam-region-list">
                        <div class="nk-latam-region"><span data-i18n="country_brazil">Brasil</span><span data-i18n="latam_brazil_nodes">6 nodos</span></div>
                        <div class="nk-latam-region"><span data-i18n="country_chile">Chile</span><span data-i18n="latam_chile_nodes">2 nodos</span></div>
                        <div class="nk-latam-region"><span data-i18n="country_colombia">Colombia</span><span data-i18n="latam_colombia_nodes">2 nodos</span></div>
                        <div class="nk-latam-region"><span data-i18n="country_argentina">Argentina</span><span data-i18n="latam_argentina_nodes">1 nodo</span></div>
                        <div class="nk-latam-region"><span data-i18n="country_mexico">México</span><span data-i18n="latam_mexico_nodes">1 nodo</span></div>
                        <div class="nk-latam-region"><span data-i18n="country_peru">Perú</span><span data-i18n="latam_peru_nodes">1 nodo</span></div>
                    </div>

                    <!-- SLA SECTION -->
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-nk-deep-blue uppercase tracking-wide mb-3" data-i18n="latam_architecture_title">Arquitectura NewEdge</h4>
                        
                        <div class="space-y-3">
                            <div class="nk-sla-item flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="server" aria-hidden="true" class="lucide lucide-server text-nk-blue text-xs w-5 text-center"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"></rect><rect width="20" height="8" x="2" y="14" rx="2" ry="2"></rect><line x1="6" x2="6.01" y1="6" y2="6"></line><line x1="6" x2="6.01" y1="18" y2="18"></line></svg>
                                    <span class="text-xs text-nk-gray font-medium ml-1" data-i18n="latam_full_compute">Compute completo por nodo</span>
                                </div>
                                <span class="text-sm font-bold text-nk-deep-blue font-mono">13/13</span>
                            </div>
                            
                            <div class="nk-sla-item flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" aria-hidden="true" class="lucide lucide-map-pin text-nk-orange text-xs w-5 text-center"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    <span class="text-xs text-nk-gray font-medium ml-1" data-i18n="latam_local_access">Acceso regional cercano</span>
                                </div>
                                <span class="text-sm font-bold text-nk-deep-blue font-mono">LATAM</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer: Certificación y Clientes -->
            <div class="nk-footer-panel p-6 md:p-7 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6 z-10 relative shadow-[0_-5px_15px_-5px_rgba(0,0,0,0.05)]">
                
                <div class="flex items-center space-x-3 group w-full sm:w-auto justify-center sm:justify-start">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-nk-light-blue text-nk-deep-blue group-hover:bg-nk-deep-blue group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" aria-hidden="true" class="lucide lucide-users text-sm"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="text-left">
                        <div class="flex items-baseline space-x-1">
                            <span class="text-xl font-bold text-nk-deep-blue">13</span>
                            <span class="text-xs font-semibold text-nk-blue uppercase tracking-wider" data-i18n="latam_active_nodes">nodos activos</span>
                        </div>
                        <p class="text-xs text-gray-500" data-i18n="latam_footer_coverage">Cobertura NewEdge en Latinoamérica</p>
                    </div>
                </div>

                <div class="hidden sm:block w-px h-8 bg-gray-200"></div>

                <div class="flex items-center space-x-4 bg-nk-off-white px-5 py-2.5 rounded-xl border border-gray-100 hover:border-nk-light-blue transition-colors cursor-pointer w-full sm:w-auto justify-center sm:justify-between shadow-sm">
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-0.5" data-i18n="latam_main_hub">Hub principal</p>
                        <p class="text-xs font-bold text-nk-deep-blue">São Paulo · SAO1/3/4</p>
                    </div>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="h-10 w-10 rounded-full bg-nk-deep-blue text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="radio-tower" aria-hidden="true" class="lucide lucide-radio-tower w-5 h-5"><path d="M4.9 16.1C1 12.2 1 5.8 4.9 1.9"></path><path d="M7.8 4.7a6.14 6.14 0 0 0-.8 7.5"></path><circle cx="12" cy="9" r="2"></circle><path d="M16.2 4.8c2 2 2.26 5.11.8 7.47"></path><path d="M19.1 1.9a9.96 9.96 0 0 1 0 14.1"></path><path d="M9.5 18h5"></path><path d="m8 22 4-11 4 11"></path></svg>
                    </div>
                </div>

            </div>

            
        </div>

        <!-- Contraparte de #infra-iberia-shell para idiomas no ibéricos (p. ej. 'en'):
             resumen genérico "Netskope de un vistazo" en lugar del detalle de LATAM.
             Oculto por defecto ('hidden'); alternado por updateLanguageSpecificContent(). -->
        <div id="infra-glance-shell" class="nk-infra-shell w-full max-w-6xl mx-auto rounded-3xl overflow-hidden hidden" aria-hidden="true">
            <div class="nk-infra-header border-b border-gray-100/90 px-6 py-6 md:px-8 md:py-8">
                <div class="mx-auto max-w-4xl text-center">
                    <p class="nk-infra-kicker text-[11px] font-bold uppercase tracking-[0.22em] text-center" data-i18n="glance_kicker">Resumen Netskope</p>
                    <h2 class="mt-2 text-3xl md:text-4xl font-bold text-nk-deep-blue leading-tight text-center" data-i18n="glance_title">Netskope de un vistazo</h2>
                    <p class="text-gray-500 mt-2 text-sm md:text-base text-center" data-i18n="glance_subtitle">Un resumen breve para conversaciones internacionales.</p>
                </div>
            </div>

            <div class="bg-white px-5 py-6 md:px-8 md:py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-5">
                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_1_kicker">Cultura de</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_1_title">Innovación</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_1_desc">Más de 300 patentes concedidas y en trámite, incluidas más de 50 en IA/ML, respaldadas por más de 1.000 ingenieros y científicos.</p>
                    </article>

                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_2_kicker">Trayectoria consolidada</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_2_title">Líder de mercado</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_2_desc">Líder en el Cuadrante Mágico de Gartner durante 9 años consecutivos y parte de Forbes Cloud 100 durante 9 años seguidos.</p>
                    </article>

                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_3_kicker">Alto rendimiento</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_3_title">Nube privada</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_3_desc">NewEdge ofrece una experiencia de usuario fluida y localizada en más de 75 regiones y más de 220 países y territorios.</p>
                    </article>

                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_4_kicker">Empresa pública</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_4_title">NASDAQ: NTSK</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_4_desc">Más de US$700 millones en ARR y más de 2.900 empleados apoyando a clientes a escala global.</p>
                    </article>

                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_5_kicker">Procesador a gran escala de</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_5_title">Tráfico cloud inline</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_5_desc">La arquitectura proxy inline descifra e inspecciona tráfico para cientos de millones de usuarios en todo el mundo.</p>
                    </article>

                    <article class="rounded-[28px] border border-gray-100 bg-white px-5 py-5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-nk-deep-blue" data-i18n="glance_card_6_kicker">Motor Zero Trust</p>
                        <h3 class="font-lora text-2xl md:text-3xl leading-none text-nk-blue mt-2" data-i18n="glance_card_6_title">Cumplimiento</h3>
                        <p class="mt-3 text-sm leading-6 text-nk-gray" data-i18n="glance_card_6_desc">Los principios de zero trust se aplican a cada interacción con datos sensibles y ayudan a cumplir requisitos de privacidad y residencia.</p>
                    </article>
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="rounded-[28px] border border-nk-blue/15 bg-gradient-to-br from-white to-nk-light-blue/10 px-5 py-4 text-center md:text-left">
                        <p class="font-lora text-3xl md:text-4xl leading-none text-nk-blue">&gt;4,000</p>
                        <p class="mt-1 text-lg md:text-xl font-bold text-nk-deep-blue" data-i18n="glance_stat_1_label">Clientes</p>
                    </div>
                    <div class="rounded-[28px] border border-nk-blue/15 bg-gradient-to-br from-white to-nk-light-blue/10 px-5 py-4 text-center md:text-left">
                        <p class="font-lora text-3xl md:text-4xl leading-none text-nk-blue">&gt;30</p>
                        <p class="mt-1 text-lg md:text-xl font-bold text-nk-deep-blue" data-i18n="glance_stat_2_label">del Fortune 100</p>
                    </div>
                    <div class="rounded-[28px] border border-nk-blue/15 bg-gradient-to-br from-white to-nk-light-blue/10 px-5 py-4 text-center md:text-left">
                        <p class="font-lora text-3xl md:text-4xl leading-none text-nk-blue">+200</p>
                        <p class="mt-1 text-lg md:text-xl font-bold text-nk-deep-blue" data-i18n="glance_stat_3_label">Zonas de localización</p>
                    </div>
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

    <!-- Utilidades JS compartidas. Esta página define sus propias versiones de
         changeLanguage/openModal/closeModal más abajo (ver comentario al inicio
         del archivo), que sobrescriben a las de aquí sin conflicto. Se cargan
         igualmente por consistencia con el resto de páginas del sitio. -->
    <script src="assets/js/common.js"></script>
    <script src="assets/js/i18n-common.js"></script>
    <!-- JavaScript para los modales y traducción -->
    <script>
        // --- LOGICA DE TRADUCCION CON PROTECCION PARA CONSOLA ---
        // Diccionario "de rescate": esta página carga su catálogo real desde
        // assets/json/keydifferentiators.i18n.json (ver loadTranslations() más abajo);
        // estas 2 claves son un respaldo/corrección que sobrevive a la fusión con el
        // JSON externo (ver Object.assign en loadTranslations).
        let translations = {
            es: {
                "single_console": "Una Sola Consola",
                "single_console_desc": "Gestión unificada de políticas, incidentes y análisis para SWG, CASB, ZTNA, DSPM y SD-WAN. Visibilidad completa en un solo dashboard."
            }
        };

        (function loadTranslations() {
            try {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'assets/json/keydifferentiators.i18n.json', false);
                xhr.send(null);
                if (xhr.status >= 200 && xhr.status < 300) {
                    let externalData = (window.NetskopeSecurityUtils && typeof window.NetskopeSecurityUtils.loadJsonCatalogFromText === 'function') 
                                        ? window.NetskopeSecurityUtils.loadJsonCatalogFromText(xhr.responseText) 
                                        : JSON.parse(xhr.responseText);
                    
                    // Fusionar datos, preservando nuestra correccion de "Consola"
                    if(externalData.es) translations.es = Object.assign({}, externalData.es, translations.es);
                }
            } catch (error) {
                console.error('Usando traduccion interna de rescate', error);
            }
        })();

        /**
         * updateLanguageSpecificContent(lang)
         * Muestra/oculta bloques cuyo contenido solo tiene sentido para ciertos
         * idiomas: la sección "Infraestructura en Latinoamérica" (#infra-iberia-shell)
         * se muestra en español (audiencia LATAM), mientras que el resumen
         * genérico "Netskope de un vistazo" (#infra-glance-shell) se muestra para
         * cualquier otro idioma residual; ambos bloques son mutuamente excluyentes.
         * También reemplaza el texto de #newedge-stat-2 por una versión "global"
         * (zonas de localización) cuando no se está en idioma ibérico. No retorna
         * ningún valor; solo muta el DOM. Llamada al final de changeLanguage().
         * @param {string} lang - Código de idioma actual (partner edition: 'es').
         */
        function updateLanguageSpecificContent(lang) {
            const isIberianLanguage = lang === 'es';
            const iberiaShell = document.getElementById('infra-iberia-shell');
            const glanceShell = document.getElementById('infra-glance-shell');
            const newedgeStat2 = document.getElementById('newedge-stat-2');

            if (iberiaShell) {
                iberiaShell.classList.toggle('hidden', !isIberianLanguage);
                iberiaShell.setAttribute('aria-hidden', isIberianLanguage ? 'false' : 'true');
            }

            if (glanceShell) {
                glanceShell.classList.toggle('hidden', isIberianLanguage);
                glanceShell.setAttribute('aria-hidden', isIberianLanguage ? 'true' : 'false');
            }

            if (newedgeStat2 && !isIberianLanguage) {
                const localizedZones = (translations[lang] && translations[lang].newedge_stat_2_global)
                    || '+200 zonas de localización';
                newedgeStat2.textContent = localizedZones;
            }
        }

        /**
         * changeLanguage(lang)
         * Versión LOCAL de esta página (intencionalmente distinta de la función
         * genérica en assets/js/common.js): además de traducir el DOM, sincroniza
         * la visibilidad de bloques específicos de idioma ibérico/global
         * (updateLanguageSpecificContent) y contempla 'en' como idioma soportado
         * transitorio. Se mantiene local a propósito; no se debe eliminar.
         * Los chequeos a window.NetskopeSecurityUtils / window.NetskopeSiteLanguageUtils
         * son "hooks" defensivos para utilidades que nunca se implementaron en este
         * proyecto (código muerto); si algún día existen, se usarían automáticamente.
         */
        function changeLanguage(lang) {
            const supportedLangs = ['es'];
            if (!supportedLangs.includes(lang)) lang = 'es';

            // Update buttons state
            document.querySelectorAll('.lang-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            const activeBtn = document.getElementById(`btn-${lang}`);
            if (activeBtn) activeBtn.classList.add('active');

            // Update content
            const dict = translations[lang];
            const elements = document.querySelectorAll('[data-i18n]');
            elements.forEach(element => {
                const key = element.getAttribute('data-i18n');
                if (dict && dict[key]) {
                    if (window.NetskopeSecurityUtils && typeof window.NetskopeSecurityUtils.applyTranslatedHtml === 'function') {
                        window.NetskopeSecurityUtils.applyTranslatedHtml(element, dict[key]);
                    } else {
                        element.innerHTML = dict[key];
                    }
                }
            });
            
            document.documentElement.lang = lang;
            const utils = window.NetskopeSiteLanguageUtils;
            if (utils && typeof utils.persistLanguagePreference === 'function') {
                utils.persistLanguagePreference(lang);
            } else {
                localStorage.setItem('netskope-lang', lang);
            }
            updateLanguageSpecificContent(lang);
        }

        // Initialize Language
        (function initializeLanguage() {
            const supportedLangs = ['es'];
            const utils = window.NetskopeSiteLanguageUtils;
            const langToUse = utils && typeof utils.resolvePreferredLanguage === 'function'
                ? utils.resolvePreferredLanguage(supportedLangs, 'es')
                : 'es';
            changeLanguage(langToUse);
        })();

        // --- LOGICA EXISTENTE MODALES ---
        // Modales de citas de analistas (Gartner/Forrester/IDC) y de la imagen NewEdge,
        // controlados por atributos data-modal-trigger / data-modal-close.
        const gartnerModal = document.getElementById('gartnerModal');
        const forresterModal = document.getElementById('forresterModal');
        const idcModal = document.getElementById('idcModal');
        const analystModalTriggers = document.querySelectorAll('[data-modal-trigger]');
        const analystModalCloseButtons = document.querySelectorAll('[data-modal-close]');

        /**
         * openModal(modal) / closeModal(modal)
         * Versiones LOCALES de esta página, intencionalmente distintas de las
         * genéricas en assets/js/common.js: aquí reciben el ELEMENTO del modal
         * (no un string con el ID) y usan classList('hidden') en vez de
         * style.display, porque estos modales ya parten de la clase `hidden` de
         * Tailwind. Se mantienen locales a propósito (no se deben unificar con
         * las de common.js sin también adaptar todas las llamadas de abajo).
         */
        function openModal(modal) {
            if (!modal) return;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modal) {
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        analystModalTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                openModal(document.getElementById(trigger.dataset.modalTrigger));
            });
        });

        analystModalCloseButtons.forEach((button) => {
            button.addEventListener('click', () => {
                closeModal(document.getElementById(button.dataset.modalClose));
            });
        });
        
        // Modal NewEdge
        const newedgeImage = document.getElementById('newedgeImage');
        const newedgeModal = document.getElementById('newedgeModal');
        const closeNewedgeModal = document.getElementById('closeNewedgeModal');
        
        if(newedgeImage) {
            newedgeImage.addEventListener('click', () => {
                openModal(newedgeModal);
            });
        }
        
        if(closeNewedgeModal) {
            closeNewedgeModal.addEventListener('click', () => {
                closeModal(newedgeModal);
            });
        }
        
        // Close modals on click outside
        window.addEventListener('click', (e) => {
            if (e.target === gartnerModal) closeModal(gartnerModal);
            if (e.target === forresterModal) closeModal(forresterModal);
            if (e.target === idcModal) closeModal(idcModal);
            if (e.target === newedgeModal) closeModal(newedgeModal);
        });

        window.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            [gartnerModal, forresterModal, idcModal, newedgeModal].forEach((modal) => {
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal(modal);
                }
            });
        });

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
    <!-- TEAM-HIDE:CHATBOT js <script src="/assets/js/demo-chat.js?v=4"></script> -->
</body>
</html>
