<?php
$slug = isset($_GET['slug']) ? $_GET['slug'] : (isset($_GET['category']) ? $_GET['category'] : '');
$industry = getCategoryDetailsBySlug($slug);

// Handle 404 or missing slug
if (!$industry) {
    // Optional: Redirect or show error. For now, showing a basic not found.
    $industry = [
        'mcat_name' => 'Industry Not Found',
        'mcat_desc' => 'The requested industry could not be found.',
        'mcat_image' => 'default-industry.jpg',
        'meta_description' => '',
        'slug' => ''
    ];
}

$pageTitle = $industry['mcat_name'];
$productInfo = getProductsByCategorySlug($slug); // Reusing logic from listing
// Fetch a few case studies - ideally would be filtered by industry, but using generic for now
$caseStudies = getCaseStudy(3);
?>

<!-- Hero Section -->
<section class="relative w-full h-[500px] overflow-hidden bg-black">
    <div class="absolute inset-0 opacity-60">
        <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
            alt="<?php echo $industry['mcat_name']; ?>" class="w-full h-full object-cover object-center"
            onerror="this.src='https://placehold.co/1920x600?text=Industry+Banner'">
    </div>
    <div class="container relative z-10 h-full flex flex-col justify-center text-white">
        <nav class="flex items-center gap-2 text-sm md:text-base font-light mb-4 opacity-80 uppercase tracking-widest">
            <a href="<?php echo SITE_URL; ?>/" class="hover:underline">Home</a>
            <span>/</span>
            <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories" class="hover:underline">Industries</a>
            <span>/</span>
            <span class="font-bold"><?php echo $industry['mcat_name']; ?></span>
        </nav>
        <h1 class="text-4xl md:text-6xl font-bold mb-4 capitalize"><?php echo $industry['mcat_name']; ?></h1>
        <p class="text-lg md:text-xl max-w-2xl opacity-90 leading-relaxed">
            <?php echo $industry['mcat_desc']; ?>
        </p>
    </div>
</section>

<!-- Overview / Challenge Section -->
<section class="py-16 md:py-24 bg-white">
    <div class="container flex flex-col md:flex-row gap-12 items-center">
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl md:text-4xl font-bold text-[var(--color-main-green)] mb-6">
                Specialized Solutions for <?php echo $industry['mcat_name']; ?>
            </h2>
            <div class="text-[var(--color-neutral)] text-lg leading-relaxed flex flex-col gap-4">
                <p>
                    <?php echo !empty($industry['meta_description']) ? $industry['meta_description'] : "In the fast-paced world of " . strtolower($industry['mcat_name']) . ", downtime is not an option. Mosil provides specialized lubrication solutions designed to withstand the unique challenges of your sector."; ?>
                </p>
                <p>
                    From extreme temperatures to heavy loads, our tribology experts have engineered products that ensure
                    your equipment performs at its peak, reducing maintenance costs and extending machinery life.
                </p>
            </div>
            <a href="<?php echo SITE_URL; ?>/contact"
                class="inline-flex items-center mt-8 text-[var(--color-main-green)] font-bold border-b-2 border-[var(--color-main-green)] pb-1 hover:text-[var(--color-primary)] hover:border-[var(--color-primary)] transition-all">
                Speak to an Industry Expert
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="relative rounded-lg overflow-hidden shadow-2xl">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/manufacturing-plant.png" alt="Industry Application"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[var(--color-main-green)]/10"></div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-16 bg-[#F5F5F5]">
    <div class="container">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-2xl md:text-4xl font-bold text-[var(--color-main-green)]">Featured Products</h2>
            <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $slug; ?>/all"
                class="text-[var(--color-neutral)] hover:text-[var(--color-main-green)] font-semibold transition-colors">
                View All Products &rarr;
            </a>
        </div>

        <?php if (!empty($productInfo['products'])): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Show only first 4 products
                $displayProducts = array_slice($productInfo['products'], 0, 4);
                foreach ($displayProducts as $product): ?>
                    <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $slug; ?>/<?php echo $product['slug']; ?>"
                        class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="aspect-[4/3] bg-gray-100 flex items-center justify-center p-4">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/products-image/<?php echo $product['image']; ?>"
                                alt="<?php echo $product['name']; ?>"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-[var(--color-main-green)] mb-2 line-clamp-1">
                                <?php echo $product['name']; ?></h3>
                            <p class="text-sm text-gray-500 line-clamp-2"><?php echo $product['short_description']; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">No specific products found for this industry.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Case Studies -->
<?php if (!empty($caseStudies)): ?>
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container">
            <h2 class="text-2xl md:text-3xl font-bold text-[var(--color-main-green)] mb-10 text-center">Success Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($caseStudies as $study): ?>
                    <div class="group relative overflow-hidden rounded-lg min-h-[300px]">
                        <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            alt="<?php echo $study['title']; ?>">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-6 text-white">
                            <h3 class="text-xl font-bold mb-2"><?php echo $study['title']; ?></h3>
                            <p class="text-sm line-clamp-2 opacity-90"><?php echo cleanText($study['solution']); ?></p>
                            <a href="<?php echo SITE_URL; ?>/case-studies"
                                class="mt-4 text-[var(--color-primary)] text-sm font-bold uppercase tracking-wider inline-block">Read
                                Case Study</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>