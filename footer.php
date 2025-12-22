<?php
/**
 * The template for displaying the footer
 *
 * @package NeoPortfolio
 * @since 1.0.0
 */
?>
        </main>

        <footer class="mt-auto">
            <div class="flex h-4 border-t-4 border-black">
                <div class="w-1/3 bg-[#FFDE59] border-r-4 border-black"></div>
                <div class="w-1/3 bg-[#FF90E8] border-r-4 border-black"></div>
                <div class="w-1/3 bg-[#5CE1E6]"></div>
            </div>

            <div class="bg-black text-white p-8 border-t-4 border-black">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">

                    <div class="order-3 md:order-1 text-center md:text-left">
                        <p class="font-mono text-sm font-bold">
                            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
                        </p>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 order-1 md:order-2">
                        <a href="#" class="w-12 h-12 flex items-center justify-center bg-white border-2 border-white text-black hover:bg-[#FFDE59] hover:border-[#FFDE59] hover:text-black transition-colors text-2xl">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <button id="scrollToTopBtn" aria-label="Scroll to Top"
        class="fixed bottom-[30px] right-[30px] z-[9999] flex h-[60px] w-[60px] items-center justify-center border-4 border-black bg-[#FFDE59] text-black shadow-[4px_4px_0_0_#000] cursor-pointer opacity-0 pointer-events-none translate-y-[20px] transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-[8px_8px_0_0_#000] [&.show]:opacity-100 [&.show]:pointer-events-auto [&.show]:translate-y-0">
        <i class="fa-solid fa-arrow-up text-2xl font-black"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollBtn = document.getElementById('scrollToTopBtn');
            const lightbox = document.getElementById('lightbox');

            // Lightbox
            if(lightbox) {
                const lightboxImg = document.getElementById('lightbox-img');
                document.querySelectorAll('.screenshot-thumbnail').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        lightboxImg.src = link.getAttribute('href');
                        lightbox.classList.remove('hidden');
                    });
                });

                document.querySelector('.lightbox-close').addEventListener('click', () => {
                    lightbox.classList.add('hidden');
                });

                lightbox.addEventListener('click', (e) => {
                    if(e.target === lightbox) lightbox.classList.add('hidden');
                });
            }

            // Scroll to top
            function handleScroll() {
                if ((window.scrollY || document.documentElement.scrollTop) > 100) {
                    scrollBtn.classList.add('show');
                } else {
                    scrollBtn.classList.remove('show');
                }
            }
            window.addEventListener('scroll', handleScroll);
            handleScroll();

            scrollBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>
