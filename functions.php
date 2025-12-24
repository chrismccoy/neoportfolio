<?php
/**
 * NeoPortfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 *
 * Adds support for standard WordPress features like title tags,
 * thumbnails, and HTML5 elements.
 */
function neoportfolio_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ]
    );
}

add_action('after_setup_theme', 'neoportfolio_theme_setup');

/**
 * Enqueue Frontend Assets
 *
 * Loads the compiled Tailwind CSS, Google Fonts, and Font Awesome
 */
function neoportfolio_enqueue_assets()
{
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;700&family=Inter:wght@400;700;900&display=swap',
        [],
        null
    );

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Compiled Tailwind CSS
    $theme_version = wp_get_theme()->get('Version');
    wp_enqueue_style(
        'neoportfolio-compiled',
        get_template_directory_uri() . '/assets/css/theme.css',
        [],
        $theme_version
    );
}

add_action('wp_enqueue_scripts', 'neoportfolio_enqueue_assets');

/**
 * Enqueue Admin Assets
 *
 * Loads jQuery UI Sortable, WordPress Media Uploader, Emoji Mart Library,
 * and custom admin assets for the post editing screens.
 */
function neoportfolio_admin_assets($hook)
{
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');

        // Emoji Mart Library
        wp_enqueue_script(
            'emoji-mart',
            'https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js',
            [],
            'latest',
            true
        );

        // Custom Theme Admin CSS
        wp_enqueue_style(
            'neoportfolio-admin-css',
            get_template_directory_uri() . '/assets/css/portfolio.css',
            [],
            '1.0.0'
        );

        // Custom Theme Admin JS
        wp_enqueue_script(
            'neoportfolio-admin-js',
            get_template_directory_uri() . '/assets/js/portfolio.js',
            ['jquery', 'jquery-ui-sortable', 'emoji-mart'],
            '1.0.0',
            true
        );
    }
}

add_action('admin_enqueue_scripts', 'neoportfolio_admin_assets');

/**
 * Register Meta Box
 *
 * Adds the Project Data & Visuals meta box to the Post editor.
 */
function neoportfolio_add_main_meta_box()
{
    add_meta_box(
        'neoportfolio_project_data',
        'Project Data & Visuals',
        'neoportfolio_render_main_meta',
        'post',
        'advanced',
        'high'
    );
}
add_action('add_meta_boxes', 'neoportfolio_add_main_meta_box');

/**
 * Render Meta Box
 *
 * Outputs the HTML for Intro Text, Gallery, Project Links, and Features.
 */
function neoportfolio_render_main_meta($post)
{
    wp_nonce_field('neoportfolio_save_data', 'neoportfolio_nonce');

    // Retrieve Data
    $intro_text    = get_post_meta($post->ID, '_neoportfolio_intro_text', true);
    $project_link  = get_post_meta($post->ID, '_neoportfolio_project_link', true);
    $purchase_link = get_post_meta($post->ID, '_neoportfolio_purchase_link', true);
    $video_url     = get_post_meta($post->ID, '_neoportfolio_video_url', true);
    $features      = get_post_meta($post->ID, '_neoportfolio_features', true);
    $gallery_ids   = get_post_meta($post->ID, '_neoportfolio_gallery_ids', true);

    if (!is_array($features)) {
        $features = [];
    }
    ?>
    <div id="neoportfolio-meta-wrapper">

        <div class="meta-section">
            <h4>📢 Intro Block</h4>
            <div class="meta-field">
                <label>Intro Text</label>
                <textarea name="neoportfolio_intro_text" style="height: 80px;" placeholder="Appears in the large yellow box..."><?php echo esc_textarea($intro_text); ?></textarea>
            </div>
        </div>

        <div class="meta-section" style="background: #fff; border-style: dashed;">
            <h4>🖼️ Visual Assets Gallery</h4>
            <div id="gallery-preview-container">
                <?php
                if ($gallery_ids) {
                    $ids = explode(',', $gallery_ids);
                    foreach ($ids as $id) {
                        $img = wp_get_attachment_image_src($id, 'thumbnail');
                        if ($img) {
                            echo '<div class="gallery-item" data-id="' . esc_attr($id) . '"><span class="gallery-remove">×</span><img src="' . esc_url($img[0]) . '"></div>';
                        }
                    }
                }
                ?>
            </div>
            <input type="hidden" name="neoportfolio_gallery_ids" id="neoportfolio_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>">
            <button type="button" id="manage-gallery" class="button button-secondary button-large-custom">Select / Manage Images</button>
            <p class="description" style="margin-top: 10px; text-align: center;">Drag and drop images to reorder.</p>
        </div>

        <hr style="margin: 30px 0; border: 0; border-top: 4px solid #000;">

        <div class="meta-section">
            <h4>🔗 Project Details</h4>
            <div class="meta-field">
                <label>Live Project Link</label>
                <input type="url" name="neoportfolio_project_link" value="<?php echo esc_attr($project_link); ?>" placeholder="https://...">
            </div>
            <div class="meta-field">
                <label>Purchase Link</label>
                <input type="url" name="neoportfolio_purchase_link" value="<?php echo esc_attr($purchase_link); ?>" placeholder="https://...">
            </div>
            <div class="meta-field">
                <label>Video URL</label>
                <input type="text" name="neoportfolio_video_url" value="<?php echo esc_attr($video_url); ?>" placeholder="https://...">
            </div>
        </div>

        <hr style="margin: 30px 0; border: 0; border-top: 4px solid #000;">

        <h4 style="font-weight: 800; text-transform: uppercase; font-size: 14px; margin-bottom: 15px;">✨ Feature List Items</h4>
        <div id="features-container">
            <?php foreach ($features as $index => $feature) :
                $emoji   = isset($feature['emoji']) ? $feature['emoji'] : '';
                $title   = isset($feature['title']) ? $feature['title'] : '';
                $preview = trim($emoji . ' ' . $title);
                if (empty($preview)) {
                    $preview = "New Feature Item";
                }
                ?>
                <div class="feature-row">
                    <div class="row-header">
                        <span class="row-title-preview">
                            <span class="dashicons dashicons-move drag-handle"></span>
                            <span class="preview-text"><?php echo esc_html($preview); ?></span>
                        </span>
                        <div class="row-actions">
                            <button type="button" class="toggle-row">Edit</button>
                            <button type="button" class="remove-row">Delete</button>
                        </div>
                    </div>
                    <div class="row-content">
                        <div class="meta-field">
                            <label>Emoji Icon</label>
                            <div class="emoji-input-wrapper">
                                <input type="text" class="input-emoji" name="neoportfolio_features[<?php echo $index; ?>][emoji]" value="<?php echo esc_attr($feature['emoji']); ?>" placeholder="">
                                <button type="button" class="emoji-trigger-btn">😀</button>
                            </div>
                        </div>
                        <div class="meta-field">
                            <label>Feature Title</label>
                            <input type="text" class="input-title" name="neoportfolio_features[<?php echo $index; ?>][title]" value="<?php echo esc_attr($feature['title']); ?>">
                        </div>
                        <div class="meta-field">
                            <label>Description</label>
                            <textarea class="input-text" style="height: 60px;" name="neoportfolio_features[<?php echo $index; ?>][text]"><?php echo esc_textarea($feature['text']); ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-feature-row" class="button button-primary button-large-custom">+ Add New Feature Row</button>

    </div>
    <?php
}

/**
 * Save Meta Data
 *
 * Sanitizes and saves all data from the meta box when the post is saved.
 * Handles Array sanitization for repeater fields.
 */
function neoportfolio_save_meta_data($post_id)
{
    // Security Checks
    if (!isset($_POST['neoportfolio_nonce']) || !wp_verify_nonce($_POST['neoportfolio_nonce'], 'neoportfolio_save_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Simple Fields (Links, Video, Intro, Gallery)
    $simple_fields = [
        'neoportfolio_project_link',
        'neoportfolio_purchase_link',
        'neoportfolio_video_url',
        'neoportfolio_intro_text',
        'neoportfolio_gallery_ids'
    ];

    foreach ($simple_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        } else {
            // Explicitly clear gallery if empty field was sent
            if ($field === 'neoportfolio_gallery_ids') {
                update_post_meta($post_id, '_' . $field, '');
            }
        }
    }

    // Save Features Repeater Array
    if (isset($_POST['neoportfolio_features']) && is_array($_POST['neoportfolio_features'])) {
        $sanitized_features = [];
        foreach ($_POST['neoportfolio_features'] as $feature) {
            // Only save row if at least one field has content
            if (!empty($feature['title']) || !empty($feature['text']) || !empty($feature['emoji'])) {
                $sanitized_features[] = [
                    'emoji' => sanitize_text_field($feature['emoji']),
                    'title' => sanitize_text_field($feature['title']),
                    'text'  => sanitize_textarea_field($feature['text']),
                ];
            }
        }
        update_post_meta($post_id, '_neoportfolio_features', $sanitized_features);
    } else {
        // If Intro exists in POST but Features does not, user deleted all features.
        if (isset($_POST['neoportfolio_intro_text'])) {
            delete_post_meta($post_id, '_neoportfolio_features');
        }
    }
}

add_action('save_post', 'neoportfolio_save_meta_data');

/**
 * Display Features & Intro
 *
 * Function to output the Intro Block and the Features Grid.
 */
function neoportfolio_display_features($post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }

    $features   = get_post_meta($post_id, '_neoportfolio_features', true);
    $intro_text = get_post_meta($post_id, '_neoportfolio_intro_text', true);

    if ((empty($features) || !is_array($features)) && empty($intro_text)) {
        return '';
    }

    ob_start();
    ?>
    <div class="w-full not-prose my-12">
        <style>
            .neo-grid-fix>p,
            .neo-grid-fix>br {
                display: none !important;
            }
        </style>

        <?php if (!empty($intro_text)) : ?>
            <div class="mb-16 border-l-[12px] border-neo-yellow bg-neutral-50 border-y-4 border-r-4 border-neo-black p-6 md:p-10 shadow-neo-lg shadow-neo-black">
                <div class="flex items-center gap-2 mb-4 opacity-60">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="font-mono text-xs font-bold uppercase">/DESCRIPTION.md</span>
                </div>
                <p class="text-xl md:text-2xl font-black uppercase leading-tight text-neo-black m-0">
                    <?php echo nl2br(esc_html($intro_text)); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($features)) : ?>
            <div class="flex items-center gap-4 mb-10">
                <h3 class="text-3xl md:text-4xl font-black uppercase bg-neo-black text-neo-white px-6 py-3 inline-block shadow-neo-md shadow-neo-cyan transform -rotate-1 m-0">
                    ✨ Features
                </h3>
                <div class="flex-grow h-4 bg-neo-black repeating-linear-gradient hidden md:block"></div>
            </div>
            <div class="neo-grid-fix grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
            <?php foreach ($features as $f) : ?>
                <div class="group relative h-full">
                    <div class="absolute inset-0 bg-neo-black translate-x-2 translate-y-2"></div>
                    <div class="relative h-full bg-neo-white border-4 border-neo-black p-6 transition-transform group-hover:-translate-x-1 group-hover:-translate-y-1 group-hover:bg-neo-yellow flex flex-col">
                        <strong class="block text-xl font-black uppercase mb-3 border-b-4 border-neo-black pb-2 text-neo-black">
                            <?php echo esc_html($f['emoji'] . ' ' . $f['title']); ?>
                        </strong>
                        <p class="font-mono text-sm font-bold leading-relaxed text-neutral-800 flex-grow">
                            <?php echo esc_html($f['text']); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Display Gallery
 *
 * Function to output the visual assets gallery using the meta box IDs.
 */
function neoportfolio_display_gallery($post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }

    $gallery_ids = get_post_meta($post_id, '_neoportfolio_gallery_ids', true);
    if (empty($gallery_ids)) {
        return '';
    }

    $ids_array    = explode(',', $gallery_ids);
    $project_slug = strtoupper(str_replace('-', '_', get_post_field('post_name', $post_id)));

    ob_start();
    ?>
    <div class="border-t-8 border-neo-black pt-12 mt-12 not-prose">
        <div class="flex items-center gap-4 mb-8">
            <h3 class="text-4xl font-black uppercase bg-neo-black text-neo-white px-4 py-2 inline-block shadow-neo shadow-neo-cyan">
                Visual_Assets
            </h3>
            <div class="flex-grow h-4 bg-neo-black repeating-linear-gradient"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <?php
            $i = 0;
            foreach ($ids_array as $img_id) :
                $i++;
                $full_src    = wp_get_attachment_image_src($img_id, 'full');
                $display_src = wp_get_attachment_image_src($img_id, 'large');

                if (!$full_src) {
                    continue;
                }

                $filename = $project_slug . '_IMG_' . str_pad($i, 3, '0', STR_PAD_LEFT) . '.JPG';
                ?>
                <a href="<?php echo esc_url($full_src[0]); ?>" class="screenshot-thumbnail group block relative cursor-pointer">
                    <div class="border-4 border-neo-black bg-neo-white shadow-neo-lg shadow-neo-black transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-neo-2xl shadow-neo-black">
                        <div class="bg-neo-pink border-b-4 border-neo-black p-2 flex items-center">
                            <div class="flex-grow bg-neo-white border-2 border-neo-black h-7 px-2 flex items-center overflow-hidden">
                                <span class="font-mono text-[10px] md:text-xs font-bold truncate opacity-60">
                                    <?php echo esc_html($filename); ?>
                                </span>
                            </div>
                        </div>
                        <div class="relative overflow-hidden aspect-video border-b-2 border-transparent">
                            <div class="absolute inset-0 bg-neo-black/20 opacity-0 group-hover:opacity-100 transition-opacity z-10 flex items-center justify-center backdrop-blur-[1px]">
                                <span class="bg-neo-black text-neo-white font-mono font-bold px-4 py-2 border-2 border-neo-white shadow-neo shadow-neo-white transform -rotate-3 hover:scale-110 transition-transform">
                                    [ ZOOM_IN ]
                                </span>
                            </div>
                            <img src="<?php echo esc_url($display_src[0]); ?>" alt="" class="w-full h-full object-cover">
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Custom Pagination
 *
 * Renders stylized "Previous" and "Next" buttons with a page counter.
 */
function neoportfolio_pagination()
{
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages <= 1) {
        return;
    }

    $current_page = max(1, get_query_var('paged'));

    echo '<div class="w-full border-b-4 border-neo-black mt-16 mb-8"></div>';
    echo '<div class="flex flex-col md:flex-row justify-between items-center gap-4">';

    // Previous Link
    if ($current_page > 1) {
        $prev_link = get_pagenum_link($current_page - 1);
        echo '<a href="' . esc_url($prev_link) . '" class="group relative inline-block">
                <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                <div class="relative bg-neo-white border-4 border-neo-black px-6 py-3 font-bold uppercase hover:-translate-y-1 hover:-translate-x-1 hover:bg-neo-yellow transition-all">
                    &larr; Previous
                </div>
              </a>';
    } else {
        echo '<div class="opacity-30 pointer-events-none border-4 border-neo-black px-6 py-3 font-bold uppercase bg-neutral-200">
                &larr; Previous
              </div>';
    }

    // Page Counter
    echo '<div class="font-mono font-bold text-lg bg-neo-black text-neo-white px-4 py-2 border-4 border-transparent shadow-neo shadow-neo-pink">
            PAGE ' . $current_page . ' / ' . $total_pages . '
          </div>';

    // Next Link
    if ($current_page < $total_pages) {
        $next_link = get_pagenum_link($current_page + 1);
        echo '<a href="' . esc_url($next_link) . '" class="group relative inline-block">
                <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                <div class="relative bg-neo-white border-4 border-neo-black px-6 py-3 font-bold uppercase hover:-translate-y-1 hover:-translate-x-1 hover:bg-neo-yellow transition-all">
                    Next &rarr;
                </div>
              </a>';
    } else {
        echo '<div class="opacity-30 pointer-events-none border-4 border-neo-black px-6 py-3 font-bold uppercase bg-neutral-200">
                Next &rarr;
              </div>';
    }

    echo '</div>';
}

/**
 * Display Post Categories and Tags
 *
 * Helper function to output categories and tags in a neo-brutalism style.
 */
function neoportfolio_display_taxonomy_terms($post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }

    if (!$post_id) {
        return '';
    }

    $categories = get_the_category($post_id);
    $tags       = get_the_tags($post_id);

    if (empty($categories) && empty($tags)) {
        return '';
    }

    ob_start();
    ?>
    <div class="neoportfolio-taxonomies mb-8 flex flex-wrap gap-3 not-prose">
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="group relative inline-flex items-center text-neo-black no-underline">
                    <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                    <span class="relative block bg-neo-cyan border-2 border-neo-black px-4 py-2 text-sm font-black uppercase transition-transform group-hover:-translate-x-0 group-hover:-translate-y-0 group-hover:bg-neo-white">
                        <i class="fa-solid fa-folder mr-1"></i><?php echo esc_html($category->name); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($tags)) : ?>
            <?php foreach ($tags as $tag) : ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="group relative inline-flex items-center text-neo-black no-underline">
                    <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                    <span class="relative block bg-neo-pink border-2 border-neo-black px-4 py-2 text-sm font-black uppercase transition-transform group-hover:-translate-x-0 group-hover:-translate-y-0 group-hover:bg-neo-white">
                        <i class="fa-solid fa-hashtag mr-1"></i><?php echo esc_html($tag->name); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Display Project Links (Live, Purchase, Video)
 *
 * Function to output project links in a neo-brutalism style.
 */
function neoportfolio_display_project_links($post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }

    if (!$post_id) {
        return '';
    }

    $project_link  = get_post_meta($post_id, '_neoportfolio_project_link', true);
    $purchase_link = get_post_meta($post_id, '_neoportfolio_purchase_link', true);
    $video_url     = get_post_meta($post_id, '_neoportfolio_video_url', true);

    if (empty($project_link) && empty($purchase_link) && empty($video_url)) {
        return '';
    }

    ob_start();
    ?>
    <div class="neoportfolio-project-links mb-12 mt-6 flex flex-wrap items-center gap-4 not-prose">
        <?php if (!empty($project_link)) : ?>
            <a href="<?php echo esc_url($project_link); ?>" target="_blank" rel="noopener noreferrer" class="group relative inline-block text-neo-black no-underline">
                <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                <div class="relative bg-neo-yellow border-4 border-neo-black px-6 py-3 font-bold uppercase transition-all group-hover:-translate-y-0 group-hover:-translate-x-0 group-hover:bg-neo-white">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Live Project
                </div>
            </a>
        <?php endif; ?>

        <?php if (!empty($purchase_link)) : ?>
            <a href="<?php echo esc_url($purchase_link); ?>" target="_blank" rel="noopener noreferrer" class="group relative inline-block text-neo-black no-underline">
                <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                <div class="relative bg-neo-pink border-4 border-neo-black px-6 py-3 font-bold uppercase transition-all group-hover:-translate-y-0 group-hover:-translate-x-0 group-hover:bg-neo-white">
                    <i class="fa-solid fa-cart-shopping mr-2"></i> Buy Now
                </div>
            </a>
        <?php endif; ?>

        <?php if (!empty($video_url)) :
            // Simple check for YouTube/Vimeo for icon, otherwise generic video
            $video_icon = 'fa-solid fa-video';
            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                $video_icon = 'fa-brands fa-youtube';
            } elseif (strpos($video_url, 'vimeo.com') !== false) {
                $video_icon = 'fa-brands fa-vimeo-v';
            }
            ?>
            <a href="<?php echo esc_url($video_url); ?>" target="_blank" rel="noopener noreferrer" class="group relative inline-block text-neo-black no-underline">
                <div class="absolute inset-0 bg-neo-black translate-x-1 translate-y-1"></div>
                <div class="relative bg-neo-green border-4 border-neo-black px-6 py-3 font-bold uppercase transition-all group-hover:-translate-y-0 group-hover:-translate-x-0 group-hover:bg-neo-white">
                    <i class="<?php echo esc_attr($video_icon); ?> mr-2"></i> Watch Video
                </div>
            </a>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Remove default WordPress editor for 'post' post type.
 *
 * Since all content is managed via a custom meta box, the default editor
 * is no longer needed and can be removed for a cleaner UI.
 */
function neoportfolio_remove_post_editor()
{
    remove_post_type_support('post', 'editor');
}
add_action('admin_init', 'neoportfolio_remove_post_editor');
