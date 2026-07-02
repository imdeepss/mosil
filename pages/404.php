<section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden bg-gradient-to-b from-[#f8fcf8] to-white">
    <!-- Background pattern -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none" style="background-image: url('<?php echo SITE_URL; ?>/assets/images/ui/Vector.png'); background-size: cover; background-position: center;"></div>

    <!-- Decorative blobs -->
    <div class="absolute top-0 left-1/4 w-72 h-72 bg-main-green rounded-full mix-blend-multiply filter blur-3xl opacity-[0.05] animate-blob z-0"></div>
    <div class="absolute top-0 right-1/4 w-72 h-72 bg-[#1A3B1B] rounded-full mix-blend-multiply filter blur-3xl opacity-[0.05] animate-blob animation-delay-2000 z-0"></div>
    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 w-72 h-72 bg-main-green rounded-full mix-blend-multiply filter blur-3xl opacity-[0.05] animate-blob animation-delay-4000 z-0"></div>

    <div class="container relative z-10 text-center px-4 py-20">
        <!-- Giant 404 with gradient -->
        <h1 class="text-[8rem] md:text-[15rem] font-extrabold leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-[#1A3B1B] via-main-green to-[#1A3B1B] drop-shadow-sm select-none">
            404
        </h1>
        
        <!-- Heading -->
        <h2 class="text-2xl md:text-4xl font-bold text-[#1A3B1B] mt-4 mb-6 tracking-tight">
            Oops! You've lost your way.
        </h2>
        
        <!-- Description -->
        <p class="text-base md:text-lg text-[#575757] max-w-lg mx-auto mb-10 leading-relaxed font-medium">
            We can't seem to find the page you're looking for. It might have been removed, renamed, or temporarily unavailable.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo SITE_URL; ?>/" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-main-green border border-transparent rounded-full hover:bg-[#1A3B1B] hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                <span class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Homepage
                </span>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/contact" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-main-green transition-all duration-200 bg-white border-2 border-main-green rounded-full hover:bg-[#f0f7f0] hover:shadow-sm hover:-translate-y-1">
                Contact Support
            </a>
        </div>
    </div>
</section>

<!-- Add some custom animations for the blobs -->
<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
