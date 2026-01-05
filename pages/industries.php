<?php
$pageTitle = 'Industries We Serve';
$industries = getCategoryByParent("2");
?>

<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/industry_banner.jpg" class="w-full h-full object-cover"
            alt="Industries Hero" onerror="this.src='https://placehold.co/1920x600?text=Industries+Banner'">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
    <div class="container relative z-10 text-center text-white">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Industries We Serve</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90">
            Delivering specialized lubrication solutions across sectors to enhance performance and reliability.
        </p>
    </div>
</section>

<!-- Industries Grid -->
<section class="py-16 bg-[#fafafa]">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($industries as $industry): ?>
                <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>"
                    class="group block bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">

                    <!-- Image Wrapper -->
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
                            alt="<?php echo $industry['mcat_name']; ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            loading="lazy">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-300">
                        </div>

                        <!-- Icon/Overlay Content -->
                        <div class="absolute bottom-0 left-0 p-6 w-full">
                            <h3
                                class="text-2xl text-white font-bold mb-1 translate-y-0 transition-transform duration-300 group-hover:-translate-y-1">
                                <?php echo $industry['mcat_name']; ?>
                            </h3>
                            <div class="h-1 w-12 bg-[var(--color-primary)] transition-all duration-300 group-hover:w-full">
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <p class="text-[var(--color-neutral)] text-sm mb-4 line-clamp-3">
                            <?php echo $industry['mcat_desc']; ?>
                        </p>
                        <span
                            class="inline-flex items-center text-[var(--color-main-green)] font-semibold group-hover:text-[var(--color-primary)] transition-colors">
                            Explore Solutions
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2 transform transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-[var(--color-main-green)] text-white py-20">
    <div class="container text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Need a Custom Solution?</h2>
        <p class="max-w-2xl mx-auto mb-10 text-white/90">
            Our experts are ready to help you find the perfect lubrication strategy for your specific industry needs.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo SITE_URL; ?>/contact"
                class="inline-block bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold px-8 py-4 rounded-full hover:bg-white transition-colors">
                Contact Experts
            </a>
            <a href="<?php echo SITE_URL; ?>/product-finder"
                class="inline-block border-2 border-white text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-[var(--color-main-green)] transition-all">
                Find Products
            </a>
        </div>
    </div>
</section>