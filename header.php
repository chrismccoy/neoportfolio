<?php
/**
 * The header for our theme
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

$theme_version = wp_get_theme()->get('Version');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-neo-cyan text-neo-black font-sans min-h-screen selection:bg-neo-black selection:text-neo-yellow'); ?>>

    <div class="max-w-6xl mx-auto min-h-screen bg-neo-white border-x-4 border-neo-black shadow-neo-xl shadow-neo-black flex flex-col">

        <header class="p-6 md:p-8 border-b-4 border-neo-black flex justify-between items-center bg-neo-white sticky top-0 z-50">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="group relative inline-block">
                <div class="absolute inset-0 bg-neo-yellow translate-x-2 translate-y-2 border-2 border-neo-black transition-transform group-hover:translate-x-3 group-hover:translate-y-3"></div>
                <div class="relative bg-neo-white border-4 border-neo-black px-6 py-2 transition-transform group-hover:-translate-x-1 group-hover:-translate-y-1">
                    <span class="text-2xl md:text-3xl font-black uppercase tracking-tighter italic">
                        <?php bloginfo('name'); ?>
                    </span>
                </div>
            </a>

            <div class="hidden md:block">
                <span class="font-mono text-sm font-bold bg-neo-pink border-2 border-neo-black px-3 py-1 shadow-neo shadow-neo-black rotate-3 inline-block">
                    v<?php echo esc_html($theme_version); ?>
                </span>
            </div>
        </header>

        <main class="flex-grow p-6 md:p-10">
