<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

get_header(); ?>

<section class="text-center py-16">
    <h1 class="text-9xl font-extrabold uppercase tracking-tighter text-neo-yellow" style="-webkit-text-stroke: 2px black; text-stroke: 2px black;">
        404
    </h1>
    <h2 class="mt-4 text-4xl font-bold uppercase">
        Page Not Found
    </h2>
    <p class="max-w-xl mx-auto mt-4 text-lg text-neutral-700">
        Oops! The page you are looking for does not exist. It might have been moved, renamed, or deleted.
    </p>
    <div class="mt-8">
        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="inline-block px-8 py-4 bg-neo-yellow text-neo-black text-xl font-bold border-4 border-neo-black uppercase shadow-neo shadow-neo-black cursor-pointer transition-all duration-150 hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-neo-sm hover:shadow-neo-black active:translate-x-1 active:translate-y-1 active:shadow-none">
            &larr; Go to Homepage
        </a>
    </div>
</section>

<?php get_footer(); ?>
