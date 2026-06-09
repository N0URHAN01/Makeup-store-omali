<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','Home')</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-white">

    {{-- Navbar --}}
    @include('customer.home.sections.navbar')

    {{-- Page Content --}}
    @yield('content')

    {{-- Toast Container --}}
    <div id="toast-container"
         class="fixed bottom-6 right-6 z-50 space-y-3"></div>

    {{-- ================= TOAST ================= --}}
    <script>
        function showToast(message, type = "success") {

            const container = document.getElementById("toast-container");

            const toast = document.createElement("div");

            toast.className =
                "flex items-center gap-3 bg-white border shadow-xl rounded-xl px-5 py-3 text-sm font-semibold transition";

            if(type === "success"){
                toast.classList.add("border-green-200","text-green-700");
            }else{
                toast.classList.add("border-red-200","text-red-700");
            }

            toast.innerHTML = `<span>${message}</span>`;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    {{-- ================= MAIN SCRIPT ================= --}}
    <script>
    document.addEventListener("DOMContentLoaded", function(){

        // ================= VARIANTS =================
        const variantBtns = document.querySelectorAll('.variant-btn');
        const selectedVariantInput = document.getElementById('selectedVariant');
        const variantError = document.getElementById('variantError');

        variantBtns.forEach(btn => {
            btn.addEventListener('click', () => {

                // remove active
                variantBtns.forEach(b => b.classList.remove('ring-2', 'ring-pink-500'));

                // add active
                btn.classList.add('ring-2', 'ring-pink-500');

                // set selected
                if (selectedVariantInput) {
                    selectedVariantInput.value = btn.dataset.id;
                }

                // hide error
                variantError?.classList.add('hidden');

                // change main image (if exists)
                const mainImage = document.getElementById('mainImage');
                const lightboxImage = document.getElementById('lightboxImage');

                if (btn.dataset.image && mainImage) {
                    mainImage.src = btn.dataset.image;
                }

                if (btn.dataset.image && lightboxImage) {
                    lightboxImage.src = btn.dataset.image;
                }
            });
        });


        // ================= ADD TO CART =================
        document.querySelectorAll(".add-to-cart-form").forEach(function(form){

            form.addEventListener("submit", function(e){

                const variantBtns = document.querySelectorAll('.variant-btn');
                const variantInput = this.querySelector('#selectedVariant');
                const variantError = document.getElementById('variantError');

                // ✅ VALIDATION
                if (variantBtns.length > 0 && variantInput && !variantInput.value) {
                    e.preventDefault();

                    variantError?.classList.remove('hidden');

                    document.getElementById('variantsContainer')
                        ?.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    showToast("Please select a color first", "error");

                    return;
                }

                e.preventDefault();

                const button = this.querySelector(".add-to-cart-btn");
                const formData = new FormData(this);

                button.disabled = true;
                button.innerText = "Adding...";

                fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })

                .then(response => response.text())

                .then(() => {

                    showToast("Added to cart successfully");

                    button.disabled = false;
                    button.innerText = "Add to cart";

                    if (typeof loadCartCount === "function") {
                        loadCartCount();
                    }

                })

                .catch((error) => {

                    console.error(error);

                    showToast("Something went wrong","error");

                    button.disabled = false;
                    button.innerText = "Add to cart";

                });

            });

        });

    });
    </script>
{{-- WHATSAPP FLOAT BUTTON --}}
<a href="https://wa.me/201015097292?text=Hello%20I%20need%20help"
   target="_blank"
   class="fixed bottom-6 right-6 z-[9999] w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition duration-300 bg-[#25D366]">

    <svg xmlns="http://www.w3.org/2000/svg"
         width="30"
         height="30"
         viewBox="0 0 24 24"
         fill="white">

        <path d="M20.52 3.48A11.79 11.79 0 0 0 12.06 0C5.49 0 .12 5.37.12 11.94c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.88 11.88 0 0 0 5.79 1.48h.01c6.57 0 11.94-5.37 11.94-11.94 0-3.19-1.24-6.19-3.49-8.42ZM12.07 21.8a9.8 9.8 0 0 1-4.99-1.37l-.36-.21-3.72.98.99-3.63-.24-.37a9.8 9.8 0 1 1 8.32 4.6Zm5.39-7.35c-.29-.15-1.71-.84-1.98-.93-.27-.1-.47-.15-.67.15-.2.29-.77.93-.95 1.12-.17.2-.35.22-.64.07-.29-.15-1.23-.45-2.34-1.44-.87-.77-1.46-1.73-1.63-2.02-.17-.29-.02-.45.13-.6.13-.13.29-.35.44-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.29-1.05 1.03-1.05 2.5 0 1.47 1.08 2.9 1.23 3.1.15.2 2.12 3.23 5.13 4.53.72.31 1.28.5 1.72.64.72.23 1.37.2 1.88.12.58-.09 1.71-.7 1.95-1.37.24-.67.24-1.24.17-1.37-.07-.13-.27-.2-.56-.35Z"/>

    </svg>

</a>
</body>
</html>