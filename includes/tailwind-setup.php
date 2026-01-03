<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
    /* Helvetica Light (300) */
    @font-face {
        font-family: 'Helvetica';
        src: url('<?php echo SITE_URL; ?>/assets/fonts/helvetica-light.ttf') format('truetype');
        font-weight: 300;
        font-style: normal;
        font-display: swap;
    }

    /* Helvetica Regular (400) */
    @font-face {
        font-family: 'Helvetica';
        src: url('<?php echo SITE_URL; ?>/assets/fonts/Helvetica.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }

    /* Helvetica Italic (400i) */
    @font-face {
        font-family: 'Helvetica';
        src: url('<?php echo SITE_URL; ?>/assets/fonts/Helvetica-Oblique.ttf') format('truetype');
        font-weight: 400;
        font-style: italic;
        font-display: swap;
    }

    /* Helvetica Bold (700) */
    @font-face {
        font-family: 'Helvetica';
        src: url('<?php echo SITE_URL; ?>/assets/fonts/Helvetica-Bold.ttf') format('truetype');
        font-weight: 700;
        font-style: normal;
        font-display: swap;
    }

    /* Helvetica Bold Italic (700i) */
    @font-face {
        font-family: 'Helvetica';
        src: url('<?php echo SITE_URL; ?>/assets/fonts/Helvetica-BoldOblique.ttf') format('truetype');
        font-weight: 700;
        font-style: italic;
        font-display: swap;
    }
</style>

<style type="text/tailwindcss">
    @theme {
        /* Core Color Palette */
        --color-y50: #FEF9E6;
        --color-y75: #FAE696;
        --color-y100: #F9DC6B;
        --color-y300: #F4C300;
        --color-g300: #30442C;
        --color-g50: #EAECEA;
        --color-g75: #AAB2A8;
        --color-g100: #879385;
        --color-b0: #FFFFFF;
        --color-b10: #fafafa;
        --color-b20: #f5f5f5;
        --color-b40: #DEDEDE;
        --color-b70: #A3A3A3;
        --color-b100: #757575;
        --color-b200: #666666;
        --color-b600: #2E2E2E;
        --color-b700: #1C1C1C;
        --color-b900: #000000;
        --color-main-green: #1A3B1B;

        /* Semantic Color Mapping */
        --color-primary: var(--color-y300);
        --color-primary-high: var(--color-y50);
        --color-primary-mid: var(--color-y75);
        --color-primary-low: var(--color-y100);

        --color-secondary: var(--color-g300);
        --color-secondary-high: var(--color-g50);
        --color-secondary-mid: var(--color-g75);
        --color-secondary-low: var(--color-g100);

        --color-neutral: var(--color-b0);

        --color-heading-high: var(--color-b900);
        --color-heading-mid: var(--color-b700);
        --color-heading-low: var(--color-b600);

        --color-subtext-high: var(--color-b70);
        --color-subtext-mid: var(--color-b100);
        --color-subtext-low: var(--color-b200);

        --color-bg-body-high: var(--color-b10);
        --color-bg-body-mid: var(--color-b20);
        --color-bg-body-low: var(--color-b40);

        /* Font Configuration */
        /* Overriding the default sans font to be Helvetica */
        --font-sans: "Helvetica";

        /* Custom Spacing */
        --spacing-header-height: 60px;

        /* Custom Animations */
        --animate-fade-in-up: fadeInUp 0.6s ease-out forwards;
        --animate-slide-left: slideInLeft 0.8s ease-out forwards;
        --animate-slide-right: slideInRight 0.8s ease-out forwards;
        --animate-reveal-up: revealUp 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;

        /* Keyframes within Theme */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    }

    @layer base {
        :root {
            /* Legacy CSS variables remain for raw CSS usage */
            --container-width: 1280px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 32px;
            --spacing-xl: 64px;
            --text-sm: 14px;
        }

        html, body {
            @apply overflow-x-hidden antialiased font-sans text-gray-900;
        }
    }

    @layer utilities {
        .container {
            @apply max-w-[var(--container-width)] mx-auto px-[var(--spacing-md)] lg:px-0; 
        }

        .animate-card {
            @apply animate-fade-in-up;
        }
    }
</style>