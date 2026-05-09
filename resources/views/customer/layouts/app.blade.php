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

</body>
</html>