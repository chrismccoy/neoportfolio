<?php
/**
 * The template for displaying all single posts
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

get_header();

while (have_posts()) :
    the_post();

    $project_link  = get_post_meta(get_the_ID(), '_neoportfolio_project_link', true);
    $purchase_link = get_post_meta(get_the_ID(), '_neoportfolio_purchase_link', true);
    $video_url     = get_post_meta(get_the_ID(), '_neoportfolio_video_url', true);
    ?>

    <header class="mb-12">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block font-mono font-bold text-sm bg-neo-black text-neo-white px-4 py-2 hover:bg-neo-yellow hover:text-neo-black hover:shadow-neo hover:shadow-neo-black border-2 border-transparent hover:border-neo-black transition-all mb-8">
            < PORTFOLIO
        </a>

        <div class="w-full">
            <h1 class="text-5xl md:text-7xl xl:text-8xl font-black uppercase tracking-[-0.05em] leading-none mb-8 break-words w-full">
                <span class="bg-neo-yellow px-2 decoration-clone box-decoration-clone leading-[1.25]">
                    <?php the_title(); ?>
                </span>
            </h1>
        </div>

        <?php echo neoportfolio_display_taxonomy_terms(get_the_ID()); ?>
        <?php echo neoportfolio_display_project_links(get_the_ID()); ?>

        <?php if ($project_link || $purchase_link || $video_url) : ?>
            <div class="w-full border-b-4 border-neo-black mt-8 mb-8"></div>
        <?php endif; ?>
    </header>

    <section class="space-y-16">
        <article class="flex flex-col gap-12 w-full">

            <div class="w-full">
                <div class="flex items-center gap-2 mb-6 opacity-50">
                    <div class="h-4 bg-neo-black w-32"></div>
                    <span class="font-mono text-xs font-bold uppercase">/README.md</span>
                </div>

                <!-- Content Area using Typography Plugin config -->
                <div class="prose prose-xl md:prose-2xl max-w-none w-full font-sans text-neo-black">
                    <?php the_content(); ?>
                </div>

                <?php echo neoportfolio_display_features(get_the_ID()); ?>
            </div>

            <?php if ($video_url) : ?>
                <div class="w-full mt-12 md:mt-20 border-t-4 border-dashed border-neo-black pt-12">
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-3xl font-black uppercase bg-neo-black text-neo-white px-4 py-2 inline-block shadow-neo shadow-neo-red">
                            Video_Preview
                        </h3>
                        <div class="flex-grow h-4 bg-neo-black repeating-linear-gradient"></div>
                    </div>

                    <div class="relative group w-full">
                        <div class="absolute inset-0 bg-neo-cyan translate-x-3 translate-y-3 border-4 border-neo-black"></div>
                        <div class="relative border-4 border-neo-black bg-neo-white p-2">
                            <div class="aspect-video bg-neo-black border-2 border-neo-black w-full">
                                <?php if (strpos($video_url, 'youtube') !== false || strpos($video_url, 'vimeo') !== false) : ?>
                                    <iframe class="w-full h-full" src="<?php echo esc_url($video_url); ?>" frameborder="0" allowfullscreen></iframe>
                                <?php else : ?>
                                    <video controls class="w-full h-full object-cover">
                                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                    </video>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 flex justify-between items-center bg-neo-black text-neo-white px-2 py-1 font-mono text-xs font-bold uppercase">
                                <span>Media_Player.exe</span>
                                <span class="animate-pulse text-neo-red">● PLAYING</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </article>

        <?php echo neoportfolio_display_gallery(get_the_ID()); ?>

    </section>

    <div id="lightbox" class="fixed inset-0 bg-neo-cyan/95 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full">
            <button class="lightbox-close absolute top-4 right-4 text-neo-black text-2xl font-bold p-2 cursor-pointer bg-neo-white border-2 border-neo-black hover:bg-neo-yellow">
                Close X
            </button>
            <div class="border-8 border-neo-black bg-neo-white p-2 shadow-neo-3xl shadow-neo-black">
                <img id="lightbox-img" class="w-full h-auto border-2 border-neo-black" src="" alt="Full size screenshot">
            </div>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
