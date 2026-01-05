<?php
$pageTitle = 'Case Studies';
$caseStudies = getCaseStudy(); // Fetch all
?>

<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center overflow-hidden bg-[var(--color-black)]">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/high-performance.png"
            class="w-full h-full object-cover opacity-50" alt="Case Studies Banner"
            onerror="this.src='https://placehold.co/1920x600/1A3B1B/FFFFFF?text=Case+Studies'">
    </div>
    <div class="container relative z-10 text-center text-white">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Case Studies</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90">
            Real-world examples of how MOSIL delivers performance and reliability across industries.
        </p>
    </div>
</section>

<!-- Case Studies Grid -->
<section class="py-16 md:py-24 bg-white">
    <div class="container">
        <?php if (empty($caseStudies)): ?>
            <div class="text-center py-20">
                <h3 class="text-2xl text-[var(--color-main-green)]">No case studies found.</h3>
                <p class="text-gray-500 mt-2">Checking back soon.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($caseStudies as $study): ?>
                    <div
                        class="group bg-white rounded-lg overflow-hidden shadow-lg border border-gray-100 flex flex-col h-full hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative h-[240px] overflow-hidden">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="<?php echo $study['title']; ?>" loading="lazy">
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-[var(--color-main-green)] mb-3 leading-tight">
                                <?php echo $study['title']; ?>
                            </h3>

                            <div class="text-[var(--color-neutral)] text-sm leading-relaxed mb-4 flex-1">
                                <span
                                    class="font-bold text-[var(--color-primary)] uppercase text-xs tracking-wide block mb-1">Challenge
                                    & Solution:</span>
                                <?php echo cleanText($study['solution']); ?>
                            </div>

                            <div class="pt-4 mt-auto border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-400 uppercase">Success Story</span>
                                <!-- If there's a detailed view, link there. For now, it's a self-contained card. -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-[var(--color-main-green)] text-white py-16">
    <div class="container text-center">
        <h2 class="text-3xl font-bold mb-4">Have a Similar Challenge?</h2>
        <p class="max-w-xl mx-auto mb-8 text-white/90">
            Our experts apply Quadra Thinking to solve your toughest lubrication problems.
        </p>
        <a href="<?php echo SITE_URL; ?>/contact"
            class="inline-block bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold px-8 py-3 rounded-full hover:bg-white transition-colors">
            Get a Consultation
        </a>
    </div>
</section>