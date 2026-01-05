<?php
$pageTitle = 'Newsroom';
$blogs = getBlogs(50); // increased limit to show more
?>

<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center overflow-hidden bg-[var(--color-main-green)]">
    <div class="absolute inset-0 z-0">
        <!-- Optional pattern or image -->
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/news_banner.jpg"
            class="w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Newsroom"
            onerror="this.src='https://placehold.co/1920x600/1A3B1B/FFFFFF?text=Newsroom'">
    </div>
    <div class="container relative z-10 text-center text-white">
        <span
            class="inline-block py-1 px-3 border border-white/30 rounded-full text-xs font-semibold uppercase tracking-wider mb-4 bg-white/10 backdrop-blur-sm">
            Updates & Insights
        </span>
        <h1 class="text-4xl md:text-6xl font-bold mb-6">MOSIL Newsroom</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto text-white/80">
            Latest news, case studies, and industry insights from the world of lubrication.
        </p>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-16 md:py-24 bg-white">
    <div class="container">
        <?php if (empty($blogs)): ?>
            <div class="text-center py-20">
                <h3 class="text-2xl text-[var(--color-main-green)]">No news articles found.</h3>
                <p class="text-gray-500 mt-2">Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                <?php foreach ($blogs as $blog): ?>
                    <article class="flex flex-col group h-full">
                        <!-- Image -->
                        <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0 mb-6 bg-gray-100">
                            <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode($blog["slug"]) ?>" class="block h-full w-full">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                    alt="<?php echo $blog['title']; ?>"
                                    class="block h-full w-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
                                    loading="lazy" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                            </a>

                            <div
                                class="absolute bottom-3 left-3 px-3 py-1 bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold text-[11px] uppercase tracking-wide rounded-sm">
                                <?php echo $blog['category_name']; ?>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col flex-1">
                            <div class="flex items-center text-xs text-[#A3A3A3] mb-3 font-medium uppercase tracking-wide">
                                <span><?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
                                <span class="mx-2">•</span>
                                <span><?php echo $blog['category_name']; ?></span>
                            </div>

                            <h2
                                class="font-bold text-xl leading-[140%] text-[#3B3B3B] mb-3 group-hover:text-[var(--color-main-green)] transition-colors line-clamp-2">
                                <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode($blog["slug"]) ?>">
                                    <?php echo $blog['title']; ?>
                                </a>
                            </h2>

                            <p class="font-normal text-[15px] leading-[160%] text-[#666666] mb-6 line-clamp-3 flex-1">
                                <?php
                                $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                                echo substr($content, 0, 180) . (strlen($content) > 180 ? '...' : '');
                                ?>
                            </p>

                            <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode($blog["slug"]) ?>"
                                class="inline-flex items-center font-bold text-[16px] text-[var(--color-main-green)] hover:text-[var(--color-primary)] transition-colors mt-auto">
                                Read Article
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-2 transition-transform group-hover:translate-x-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Newsletter / Subscribe (Optional) -->
<section class="bg-[#f0f0f0] py-20">
    <div class="container text-center max-w-4xl">
        <h2 class="text-3xl font-bold text-[var(--color-main-green)] mb-4">Stay Informed</h2>
        <p class="text-gray-600 mb-8">Subscribe to our newsletter to receive the latest updates directly in your inbox.
        </p>

        <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto"
            onsubmit="event.preventDefault(); alert('Subscribed!');">
            <input type="email" placeholder="Your email address" required
                class="flex-1 px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-[var(--color-main-green)] focus:ring-1 focus:ring-[var(--color-main-green)]">
            <button type="submit"
                class="px-8 py-3 bg-[var(--color-main-green)] text-white font-bold rounded-full hover:bg-[var(--color-black)] transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>