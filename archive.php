<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

get_header(); ?>

<div class="bg-neutral-50 border-b-4 border-black p-8 md:p-16 mb-8 text-center">

    <div class="mb-6">
        <span class="font-mono text-sm font-bold bg-[#FF90E8] border-2 border-black px-3 py-1 shadow-[4px_4px_0_0_#000] -rotate-2 inline-block uppercase">
            // ARCHIVE_FILTER_ACTIVE
        </span>
    </div>

    <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-4 text-black">
        <?php the_archive_title(); ?>
    </h1>

    <?php if ( get_the_archive_description() ) : ?>
        <div class="text-xl md:text-2xl font-bold font-mono uppercase text-neutral-600 max-w-3xl mx-auto mt-4">
            <?php the_archive_description(); ?>
        </div>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        $slug = get_post_field( 'post_name', get_the_ID() );
        $display_id = strtoupper(str_replace('-', ' ', $slug));
    ?>
        <article class="group relative block h-full">
            <div class="absolute inset-0 bg-black translate-x-3 translate-y-3 transition-transform group-hover:translate-x-4 group-hover:translate-y-4"></div>

            <a href="<?php the_permalink(); ?>" class="relative block h-full bg-white border-4 border-black p-6 flex flex-col justify-between transition-transform group-hover:-translate-y-1 group-hover:-translate-x-1 hover:bg-[#FFDE59]">

                <div class="mb-8">
                    <span class="font-mono text-xs font-bold border-2 border-black px-2 py-1 bg-white mb-4 inline-block">
                        ID: <?php echo esc_html($display_id); ?>
                    </span>

                    <?php if ($thumb_url) : ?>
                        <div class="mb-4 border-2 border-black aspect-video overflow-hidden grayscale group-hover:grayscale-0 transition-all">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <h2 class="text-3xl font-black uppercase leading-none break-words">
                        <?php the_title(); ?>
                    </h2>
                </div>

                <div class="flex justify-between items-end border-t-4 border-black pt-4">
                    <span class="font-bold uppercase text-sm">View Project</span>
                    <span class="text-2xl font-bold">&rarr;</span>
                </div>
            </a>
        </article>
    <?php endwhile; else : ?>
        <div class="col-span-full text-center py-24 border-4 border-dashed border-black opacity-50">
            <h3 class="text-4xl font-black uppercase">No Results Found</h3>
            <p class="font-mono mt-4">/SYSTEM/EMPTY_SET/ARCHIVE</p>
            <div class="mt-8">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block border-2 border-black px-4 py-2 font-bold hover:bg-black hover:text-white transition-colors">
                    RESET FILTERS
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php neoportfolio_pagination(); ?>

<?php get_footer(); ?>
