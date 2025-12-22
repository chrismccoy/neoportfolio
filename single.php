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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block font-mono font-bold text-sm bg-black text-white px-4 py-2 hover:bg-[#FFDE59] hover:text-black hover:shadow-[4px_4px_0_0_#000] border-2 border-transparent hover:border-black transition-all mb-8">
            < PORTFOLIO
        </a>

        <div class="w-full">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black uppercase tracking-tighter leading-none mb-8 break-words w-full">
                <span class="bg-[#FFDE59] px-2 decoration-clone box-decoration-clone leading-[1.3]">
                    <?php the_title(); ?>
                </span>
            </h1>
        </div>

        <?php echo neoportfolio_display_taxonomy_terms(get_the_ID()); ?>

        <?php echo neoportfolio_display_project_links(get_the_ID()); ?>

        <?php if ($project_link || $purchase_link || $video_url) : ?>
            <div class="w-full border-b-4 border-black mt-8 mb-8"></div>
        <?php endif; ?>
    </header>

    <section class="space-y-16">
        <article class="flex flex-col gap-12 w-full">

            <div class="w-full">
                <div class="flex items-center gap-2 mb-6 opacity-50">
                    <div class="h-4 bg-black w-32"></div>
                    <span class="font-mono text-xs font-bold uppercase">/README.md</span>
                </div>

                <div class="prose prose-xl md:prose-2xl max-w-none w-full font-sans text-black
                            prose-headings:font-black prose-headings:uppercase prose-headings:border-b-4 prose-headings:border-black prose-headings:pb-4 prose-headings:mb-6
                            prose-p:font-bold prose-p:leading-relaxed prose-p:mb-8
                            prose-a:bg-[#5CE1E6] prose-a:px-1 prose-a:text-black prose-a:border-2 prose-a:border-black prose-a:no-underline hover:prose-a:shadow-[4px_4px_0_0_#000] hover:prose-a:-translate-y-1 prose-a:transition-all
                            prose-blockquote:border-l-[12px] prose-blockquote:border-[#FF90E8] prose-blockquote:bg-gray-50 prose-blockquote:p-8 prose-blockquote:text-xl prose-blockquote:font-black prose-blockquote:not-italic
                            prose-img:border-4 prose-img:border-black prose-img:shadow-[8px_8px_0_0_#000] prose-img:w-full">
                    <?php the_content(); ?>
                </div>

                <?php echo neoportfolio_display_features(get_the_ID()); ?>
            </div>

            <?php if ($video_url) : ?>
                <div class="w-full mt-12 md:mt-20 border-t-4 border-dashed border-black pt-12">
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-3xl font-black uppercase bg-black text-white px-4 py-2 inline-block shadow-[4px_4px_0_0_#FF4D4D]">
                            Video_Preview
                        </h3>
                        <div class="flex-grow h-4 bg-black repeating-linear-gradient"></div>
                    </div>

                    <div class="relative group w-full">
                        <div class="absolute inset-0 bg-[#5CE1E6] translate-x-3 translate-y-3 border-4 border-black"></div>
                        <div class="relative border-4 border-black bg-white p-2">
                            <div class="aspect-video bg-black border-2 border-black w-full">
                                <?php if (strpos($video_url, 'youtube') !== false || strpos($video_url, 'vimeo') !== false) : ?>
                                    <iframe class="w-full h-full" src="<?php echo esc_url($video_url); ?>" frameborder="0" allowfullscreen></iframe>
                                <?php else : ?>
                                    <video controls class="w-full h-full object-cover">
                                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                    </video>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 flex justify-between items-center bg-black text-white px-2 py-1 font-mono text-xs font-bold uppercase">
                                <span>Media_Player.exe</span>
                                <span class="animate-pulse text-[#FF4D4D]">● PLAYING</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </article>

        <?php echo neoportfolio_display_gallery(get_the_ID()); ?>

    </section>

    <div id="lightbox" class="fixed inset-0 bg-[#5CE1E6]/95 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full">
            <button class="lightbox-close absolute top-4 right-4 text-black text-2xl font-bold p-2 cursor-pointer bg-white border-2 border-black hover:bg-[#FFDE59]">
                Close X
            </button>
            <div class="border-8 border-black bg-white p-2 shadow-[20px_20px_0_0_#000]">
                <img id="lightbox-img" class="w-full h-auto border-2 border-black" src="" alt="Full size screenshot">
            </div>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
