{{-- HERO SECTION --}}
<section class="relative bg-[#fcf7fa] overflow-hidden">

    {{-- SOFT BACKGROUND --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -left-40 w-[420px] h-[420px] bg-pink-200/30 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-32 -right-32 w-[360px] h-[360px] bg-rose-200/30 blur-3xl rounded-full"></div>
    </div>

    <div class="relative w-full px-3 sm:px-5 lg:px-8 py-6 lg:py-10">

        <div class="max-w-[1320px] mx-auto grid lg:grid-cols-[1fr_130px] gap-5 items-stretch">

            {{-- HERO SLIDER --}}
            <div class="relative overflow-hidden rounded-[28px] sm:rounded-[34px] shadow-[0_14px_60px_rgba(0,0,0,0.10)]">

                <div id="heroSlides" class="relative">

                    {{-- SLIDE 1 --}}
                    <div class="hero-slide relative h-[520px] sm:h-[580px] lg:h-[560px] xl:h-[600px]">

                        <img src="{{ asset('images/hero/hero1.png') }}"
                             class="absolute inset-0 w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/10"></div>

                        <div class="relative z-10 h-full flex items-center px-6 sm:px-10 md:px-16 lg:px-20">

                            <div class="max-w-2xl text-white">

                                <span class="inline-flex items-center bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-xs sm:text-sm font-medium mb-5">
                                    Premium Fragrances
                                </span>

                                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                                    Luxury Perfumes
                                    <span class="block text-pink-500 mt-1">
                                        For Every Style
                                    </span>
                                </h1>

                                <p class="mt-5 text-white/85 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                                    Discover high-quality perfumes for women and men,
                                    carefully selected with long-lasting scents and elegant packaging.
                                </p>

                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-8">
                                    <a href="#products"
                                       class="px-6 sm:px-8 py-3 rounded-full bg-pink-500 hover:bg-pink-600 text-white text-sm sm:text-base font-semibold transition">
                                        Shop Now
                                    </a>

                                    <a href="{{ route('order.track') }}"
                                       class="px-6 sm:px-8 py-3 rounded-full border border-white/30 bg-white/10 backdrop-blur-md hover:bg-white/20 transition text-white text-sm sm:text-base font-semibold">
                                        Track Your Order
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- SLIDE 2 --}}
                    <div class="hero-slide hidden relative h-[520px] sm:h-[580px] lg:h-[560px] xl:h-[600px]">

                        <img src="{{ asset('images/hero/hero2f.png') }}"
                             class="absolute inset-0 w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/10"></div>

                        <div class="relative z-10 h-full flex items-center px-6 sm:px-10 md:px-16 lg:px-20">

                            <div class="max-w-2xl text-white">

                                <span class="inline-flex items-center bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-xs sm:text-sm font-medium mb-5">
                                    Makeup Collection
                                </span>

                                <h2 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                                    Everything You Need
                                    <span class="block text-pink-500 mt-1">
                                        For Your Beauty Look
                                    </span>
                                </h2>

                                <p class="mt-5 text-white/85 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                                    From everyday essentials to trending makeup products,
                                    explore original and inspired collections with amazing offers.
                                </p>

                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-8">
                                    <a href="#products"
                                       class="px-6 sm:px-8 py-3 rounded-full bg-pink-500 hover:bg-pink-600 text-white text-sm sm:text-base font-semibold transition">
                                        Shop Now
                                    </a>

                                    <a href="{{ route('order.track') }}"
                                       class="px-6 sm:px-8 py-3 rounded-full border border-white/30 bg-white/10 backdrop-blur-md hover:bg-white/20 transition text-white text-sm sm:text-base font-semibold">
                                        Track Your Order
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- SLIDE 3 --}}
                    <div class="hero-slide hidden relative h-[520px] sm:h-[580px] lg:h-[560px] xl:h-[600px]">

                        <img src="{{ asset('images/hero/hero3.png') }}"
                             class="absolute inset-0 w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/10"></div>

                        <div class="relative z-10 h-full flex items-center px-6 sm:px-10 md:px-16 lg:px-20">

                            <div class="max-w-2xl text-white">

                                <span class="inline-flex items-center bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-xs sm:text-sm font-medium mb-5">
                                    Skincare Essentials
                                </span>

                                <h2 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                                    Healthy Skin Starts
                                    <span class="block text-pink-500 mt-1">
                                        With Proper Care
                                    </span>
                                </h2>

                                <p class="mt-5 text-white/85 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                                    Shop Korean skincare, Egyptian brands, and daily care essentials
                                    designed to keep your skin healthy, fresh, and glowing.
                                </p>

                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-8">
                                    <a href="#products"
                                       class="px-6 sm:px-8 py-3 rounded-full bg-pink-500 hover:bg-pink-600 text-white text-sm sm:text-base font-semibold transition">
                                        Shop Now
                                    </a>

                                    <a href="{{ route('order.track') }}"
                                       class="px-6 sm:px-8 py-3 rounded-full border border-white/30 bg-white/10 backdrop-blur-md hover:bg-white/20 transition text-white text-sm sm:text-base font-semibold">
                                        Track Your Order
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- DOTS --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex justify-center gap-2">
                    <button class="hero-dot w-8 h-2 rounded-full bg-pink-500 transition" data-slide="0"></button>
                    <button class="hero-dot w-2 h-2 rounded-full bg-white/60 transition" data-slide="1"></button>
                    <button class="hero-dot w-2 h-2 rounded-full bg-white/60 transition" data-slide="2"></button>
                </div>

            </div>

            {{-- SIDE CARDS --}}
            <div class="hidden lg:flex flex-col gap-5">

                <button class="hero-card group" data-slide="0">
                    <div class="relative overflow-hidden rounded-2xl h-[173px] xl:h-[186px] border-2 border-pink-500 shadow-xl">
                        <img src="{{ asset('images/hero/hero1.png') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-black/35"></div>

                        <div class="absolute bottom-4 left-3 text-left">
                            <h3 class="text-white font-semibold text-sm">Perfumes</h3>
                            <p class="text-white/70 text-xs">Luxury collection</p>
                        </div>
                    </div>
                </button>

                <button class="hero-card group" data-slide="1">
                    <div class="relative overflow-hidden rounded-2xl h-[173px] xl:h-[186px] border-2 border-transparent">
                        <img src="{{ asset('images/hero/hero2f.png') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-black/35"></div>

                        <div class="absolute bottom-4 left-3 text-left">
                            <h3 class="text-white font-semibold text-sm">Makeup</h3>
                            <p class="text-white/70 text-xs">Beauty essentials</p>
                        </div>
                    </div>
                </button>

                <button class="hero-card group" data-slide="2">
                    <div class="relative overflow-hidden rounded-2xl h-[173px] xl:h-[186px] border-2 border-transparent">
                        <img src="{{ asset('images/hero/hero3.png') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-black/35"></div>

                        <div class="absolute bottom-4 left-3 text-left">
                            <h3 class="text-white font-semibold text-sm">Skincare</h3>
                            <p class="text-white/70 text-xs">Daily care</p>
                        </div>
                    </div>
                </button>

            </div>

        </div>

    </div>

</section>

{{-- HERO SCRIPT --}}
<script>
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    const cards = document.querySelectorAll('.hero-card');

    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('hidden', i !== index);
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('w-8', 'bg-pink-500');
                dot.classList.remove('w-2', 'bg-white/60');
            } else {
                dot.classList.remove('w-8', 'bg-pink-500');
                dot.classList.add('w-2', 'bg-white/60');
            }
        });

        cards.forEach((card, i) => {
            const inner = card.querySelector('div');

            if (i === index) {
                inner.classList.add('border-pink-500', 'shadow-xl');
                inner.classList.remove('border-transparent');
            } else {
                inner.classList.remove('border-pink-500', 'shadow-xl');
                inner.classList.add('border-transparent');
            }
        });

        currentSlide = index;
    }

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            showSlide(Number(dot.dataset.slide));
        });
    });

    cards.forEach(card => {
        card.addEventListener('click', () => {
            showSlide(Number(card.dataset.slide));
        });
    });

    setInterval(() => {
        currentSlide++;

        if (currentSlide >= slides.length) {
            currentSlide = 0;
        }

        showSlide(currentSlide);
    }, 5000);
</script>