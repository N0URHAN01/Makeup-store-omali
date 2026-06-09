<footer id="contact" class="bg-[#fff7fa] border-t border-pink-100 mt-24">

    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- BRAND --}}
            <div>

                <h3
                    class="text-4xl font-bold text-pink-600 mb-4"
                    style="font-family: 'Playfair Display', serif;">
                    Om Ali
                </h3>

                <p class="text-gray-500 leading-relaxed text-sm">
                    Everything you need for skincare, haircare,
                    body care, makeup and perfumes in one place.
                    Carefully selected products with quality you can trust.
                </p>

            </div>

            {{-- LINKS --}}
            <div>

                <h4 class="font-bold text-gray-900 mb-5">
                    Quick Links
                </h4>

                <ul class="space-y-3 text-gray-500 text-sm">

                    <li>
                        <a href="{{ route('home') }}"
                           class="hover:text-pink-600 transition">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products.index') }}"
                           class="hover:text-pink-600 transition">
                            Shop
                        </a>
                    </li>

                    <li>
                        <a href="#categories"
                           class="hover:text-pink-600 transition">
                            Categories
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('order.track') }}"
                           class="hover:text-pink-600 transition">
                            Track Order
                        </a>
                    </li>

                </ul>

            </div>

            {{-- SERVICE --}}
            <div>

                <h4 class="font-bold text-gray-900 mb-5">
                    Customer Service
                </h4>

                <ul class="space-y-3 text-gray-500 text-sm">

                    <li>Shipping Across Egypt</li>

                    <li>Easy Returns & Exchange</li>

                    <li>Order Tracking</li>

                    <li>After Delivery Support</li>

                </ul>

            </div>

            {{-- CONTACT --}}
            <div>

                <h4 class="font-bold text-gray-900 mb-5">
                    Contact Us
                </h4>

               <ul class="space-y-4 text-sm">

    {{-- WhatsApp --}}
    <li>
        <a href="https://wa.me/201015097292"
           target="_blank"
           class="flex items-center gap-3 text-gray-500 hover:text-green-600 transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.52 3.48A11.82 11.82 0 0012.04 0C5.52 0 .24 5.28.24 11.8c0 2.08.54 4.1 1.58 5.88L0 24l6.5-1.7a11.76 11.76 0 005.54 1.4h.01c6.52 0 11.8-5.28 11.8-11.8 0-3.15-1.22-6.1-3.43-8.42zM12.05 21.7c-1.76 0-3.48-.47-4.98-1.36l-.36-.21-3.86 1.01 1.03-3.77-.23-.39a9.72 9.72 0 01-1.49-5.18c0-5.4 4.39-9.79 9.79-9.79 2.62 0 5.08 1.02 6.93 2.87a9.73 9.73 0 012.86 6.92c0 5.4-4.39 9.8-9.79 9.8zm5.37-7.34c-.29-.15-1.7-.84-1.97-.94-.26-.1-.45-.15-.64.15-.19.29-.74.94-.9 1.13-.17.2-.33.22-.62.08-.29-.15-1.2-.44-2.29-1.41-.85-.76-1.43-1.7-1.59-1.99-.17-.29-.02-.44.13-.59.13-.13.29-.33.43-.49.14-.17.19-.29.29-.49.1-.2.05-.37-.02-.52-.07-.15-.64-1.54-.88-2.11-.23-.55-.47-.48-.64-.49h-.55c-.19 0-.49.07-.75.37-.26.29-.98.96-.98 2.34s1 2.71 1.14 2.9c.15.2 1.96 3 4.75 4.2.66.28 1.17.45 1.57.58.66.21 1.26.18 1.74.11.53-.08 1.7-.69 1.94-1.36.24-.67.24-1.24.17-1.36-.07-.12-.26-.19-.55-.34z"/>
            </svg>

            WhatsApp
        </a>
    </li>

    {{-- Facebook --}}
    <li>
        <a href="https://www.facebook.com/share/17SJhRWR54/"
           target="_blank"
           class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.03 4.39 11.02 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.03 1.79-4.7 4.53-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.95.93-1.95 1.88v2.26h3.32l-.53 3.49h-2.79V24C19.61 23.09 24 18.1 24 12.07z"/>
            </svg>

            Facebook
        </a>
    </li>

    {{-- Instagram --}}
    <li>
        <a href="https://www.instagram.com/omalicosmetics1?igsh=MXA1emFzbXFhaHVmdg=="
           target="_blank"
           class="flex items-center gap-3 text-gray-500 hover:text-pink-600 transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 2h8.5A3.75 3.75 0 0120 7.75v8.5A3.75 3.75 0 0116.25 20h-8.5A3.75 3.75 0 014 16.25v-8.5A3.75 3.75 0 017.75 4zm8.88 1.5a.88.88 0 100 1.75.88.88 0 000-1.75zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"/>
            </svg>

            Instagram
        </a>
    </li>

    {{-- TikTok --}}
    <li>
        <a href="https://www.tiktok.com/@om.ali.cosmetics?_r=1&_t=ZS-96rpCok8SaA"
           target="_blank"
           class="flex items-center gap-3 text-gray-500 hover:text-black transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-1.89V15.2a5.2 5.2 0 11-5.2-5.2c.18 0 .36.02.54.05v2.64a2.57 2.57 0 00-.54-.06 2.57 2.57 0 102.57 2.57V0h2.62a4.83 4.83 0 004.78 4.1v2.59z"/>
            </svg>

            TikTok
        </a>
    </li>

</ul>
            </div>

        </div>

        {{-- DIVIDER --}}
        <div class="border-t border-pink-100 mt-12 pt-6">

            <div class="flex flex-col md:flex-row justify-between items-center gap-3">

                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Om Ali. All rights reserved.
                </p>

                <p class="text-sm text-gray-400">
                    Beauty • Makeup • Skincare • Perfumes
                </p>

            </div>

        </div>

    </div>

</footer>