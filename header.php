<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <main>
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

// Retrieve the theme version dynamically from style.css
$theme_version = wp_get_theme()->get('Version');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-[#5CE1E6] text-black font-sans min-h-screen selection:bg-black selection:text-[#FFDE59]'); ?>>

    <div class="max-w-6xl mx-auto min-h-screen bg-white border-x-4 border-black shadow-[10px_10px_0_0_rgba(0,0,0,1)] flex flex-col">

        <header class="p-6 md:p-8 border-b-4 border-black flex justify-between items-center bg-white sticky top-0 z-50">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="group relative inline-block">
                <div class="absolute inset-0 bg-[#FFDE59] translate-x-2 translate-y-2 border-2 border-black transition-transform group-hover:translate-x-3 group-hover:translate-y-3"></div>
                <div class="relative bg-white border-4 border-black px-6 py-2 transition-transform group-hover:-translate-x-1 group-hover:-translate-y-1">
                    <span class="text-2xl md:text-3xl font-black uppercase tracking-tighter italic">
                        <?php bloginfo('name'); ?>
                    </span>
                </div>
            </a>

            <div class="hidden md:block">
                <span class="font-mono text-sm font-bold bg-[#FF90E8] border-2 border-black px-3 py-1 shadow-[4px_4px_0_0_#000] rotate-3 inline-block">
                    v<?php echo esc_html($theme_version); ?>
                </span>
            </div>
        </header>

        <main class="flex-grow p-6 md:p-10">
