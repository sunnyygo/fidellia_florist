<x-layout-user>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <!-- Heading & Filters -->
    <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
      <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Katalog Product</h2>
      </div>
      <div class="flex items-center space-x-4">
        <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
          <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
          </svg>
          Sort
          <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
          </svg>
        </button>
        <div id="dropdownSort1" class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700" data-popper-placement="bottom">
          <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400" aria-labelledby="sortDropdownButton">
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> The most popular </a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Newest </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
      @foreach ($products as $p)
      <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="h-56 w-full">
          <a href="#">
               @php
            $firstImage = $p->images->first()->image_url ?? null;
              @endphp

              @if ($firstImage)
                  <img src="{{ asset($firstImage) }}" class="mx-auto h-56 object-contain" />
              @else
                  <div class="text-center text-gray-400">Tidak ada foto</div>
              @endif
          </a>
        </div>
        <div class="pt-6">

          <p class="text-2xl mb-3 font-extrabold leading-tight text-gray-900 dark:text-white">
              {{ $p->name }}
        </p>
          <p class="text-lg font-semibold leading-tight text-gray-900 dark:text-white">Rp.{{ number_format($p->price, 0, ',', '.') }}</p>

          <div class="mt-4 flex items-center justify-between gap-4">
            <button type="button" data-modal-target="PreviewModal"
                data-modal-toggle="PreviewModal"
                data-id="{{ $p->id }}"
                data-price="{{ $p->price }}"
                data-name="{{ $p->name }}"
                data-price="{{ number_format($p->price, 0, ',', '.') }}"
                data-description="{{ $p->description }}"
                data-images='@json($p->images)' aria-controls="drawer-read-product-advanced" class="btn-preview py-2 px-3 flex items-center text-sm font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2 -ml-0.5">
                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                        </svg>
                                        Preview
                                    </button>

            <button type="button"
        class="btn-checkout inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        data-id="{{ $p->id }}"
        data-price="{{ $p->price }}"
        data-modal-target="aproveModal"
        data-modal-toggle="aproveModal">
    
    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
         width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
</svg>

    OrderNow
</button>

          </div>
        </div>
      </div>  
      @endforeach
    </div>
</section>

<!-- Modal Preview Produk -->
<div id="PreviewModal" tabindex="-1" aria-hidden="true"
     class="backdrop-blur-md hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Produk</h3>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="PreviewModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Gambar Produk -->
            <div id="preview-images" class="grid grid-cols-3 gap-4 mb-4">
                <!-- diisi lewat JS -->
            </div>

            <!-- Info Produk -->
            <div class="mb-2">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white" id="preview-name"></h4>
                <p class="text-lg font-semibold text-primary-600" id="preview-price"></p>
            </div>
            <p class="text-gray-700 dark:text-gray-300" id="preview-description"></p>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const previewButtons = document.querySelectorAll('.btn-preview');
    const previewImages = document.getElementById('preview-images');
    const previewName = document.getElementById('preview-name');
    const previewPrice = document.getElementById('preview-price');
    const previewDescription = document.getElementById('preview-description');

    previewButtons.forEach(button => {
        button.addEventListener('click', () => {
            previewName.textContent = button.dataset.name;
            previewPrice.textContent = 'Rp. ' + button.dataset.price;
            previewDescription.textContent = button.dataset.description;

            let images = [];
            try {
                images = JSON.parse(button.dataset.images);
            } catch (e) {
                console.error('Gagal parsing gambar:', e);
            }

            previewImages.innerHTML = '';
            images.forEach(img => {
                const el = document.createElement('img');
                el.src = `/${img.image_url}`;
                el.className = 'w-full aspect-square object-cover rounded border';
                previewImages.appendChild(el);
            });
        });
    });
});
</script>

<!-- Modal Checkout -->
<div id="aproveModal" tabindex="-1" aria-hidden="true"
     class="hidden fixed top-0 left-0 right-0 z-50 w-full overflow-y-auto overflow-x-hidden h-full bg-black/50 backdrop-blur-sm">
  <div class="relative p-4 w-full max-w-3xl mx-auto mt-10">
    <div class="relative mt-60 bg-white rounded-lg shadow dark:bg-gray-800 p-6">
      <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Checkout Papan Bunga</h3>
        <button type="button" class="text-gray-400 hover:text-gray-900" data-modal-toggle="aproveModal">
          ✕
        </button>
      </div>

      <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Jenis Bunga -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Bunga</label>
          <div class="space-y-2">
            @foreach($flowers as $flower)
              <label>
                <input type="radio" name="flower_type" value="{{ $flower->id }}" class="flower-radio" required>
                {{ ucfirst($flower->name) }}
              </label><br>
            @endforeach
          </div>
        </div>
        <input type="hidden" name="product_id" id="selectedProductId">
        <input type="hidden" name="total_price" id="selectedProductPrice">
        <!-- Warna Bunga -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Warna Bunga</label>
          <div id="color-options" class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
            <p>Pilih jenis bunga terlebih dahulu</p>
          </div>
        </div>

        <!-- Warna Background -->
<div class="mb-4">
  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Warna Background</label>
  <div class="grid grid-cols-6 gap-2">
    @foreach($backgroundColors as $item)
      @php $color = $item->color; @endphp
      <label class="relative cursor-pointer">
        <input type="radio" name="background_color" value="{{ $color->id }}" class="sr-only peer">
        <div class="w-10 h-10 rounded-full border {{ 'bg-' . ($colorMap[$color->name] ?? 'gray') . '-500' }} peer-checked:ring-4 peer-checked:ring-primary-500 peer-checked:border-primary-700 transition"></div>
      </label>
    @endforeach
  </div>
</div>

<!-- Warna List -->
<div class="mb-4">
  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Warna List</label>
  <div class="grid grid-cols-6 gap-2">
    @foreach($listColors as $item)
      @php $color = $item->color; @endphp
      <label class="relative cursor-pointer">
        <input type="radio" name="list_color" value="{{ $color->id }}" class="sr-only peer">
        <div class="w-10 h-10 rounded-full border {{ 'bg-' . ($colorMap[$color->name] ?? 'gray') . '-500' }} peer-checked:ring-4 peer-checked:ring-primary-500 peer-checked:border-primary-700 transition"></div>
      </label>
    @endforeach
  </div>
</div>


        <!-- Logo Pembeli -->
        <div class="mb-4">
          <label for="logo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo Pembeli</label>
          <input type="file" name="logo" id="logo"
                 class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
        </div>

        <!-- Data Pembeli -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
            <input type="text" name="name" required class="w-full rounded border p-2 text-sm">
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">No HP</label>
            <input type="text" name="phone" required class="w-full rounded border p-2 text-sm">
          </div>
        </div>
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" name="email" required class="w-full rounded border p-2 text-sm">
          </div>
          <div class="mt-4">
          <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Kalimat yang akan ditulis dipapan</label>
          <textarea name="kalimat" rows="3" required class="w-full rounded border p-2 text-sm"></textarea>
        </div>
        <div class="mt-4">
          <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
          <textarea name="address" rows="3" required class="w-full rounded border p-2 text-sm"></textarea>
        </div>

        <div class="mt-6 flex justify-end">
          <button type="submit"
                  class="px-6 py-2 text-sm text-white font-medium rounded bg-primary-700 hover:bg-primary-800">
            Lanjutkan Pembayaran
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // 1. Menangani perubahan radio jenis bunga → load warna bunga
  const flowerRadios = document.querySelectorAll('.flower-radio');
  const colorOptions = document.getElementById('color-options');

  flowerRadios.forEach(radio => {
    radio.addEventListener('change', async function () {
      const flowerId = this.value;

      try {
        const response = await fetch(`/get-flower-variants/${flowerId}`);
        const data = await response.json();

        colorOptions.innerHTML = '';

        if (data.length > 0) {
          data.forEach(variant => {
            const label = document.createElement('label');
            label.innerHTML = `
              <input type="radio" name="flower_color" value="${variant.color_id}" required>
              ${variant.color_name}
            `;
            colorOptions.appendChild(label);
            colorOptions.appendChild(document.createElement('br'));
          });
        } else {
          colorOptions.innerHTML = '<p class="text-sm text-gray-500">Tidak ada warna tersedia</p>';
        }
      } catch (error) {
        console.error('Gagal mengambil varian bunga:', error);
        colorOptions.innerHTML = '<p class="text-sm text-red-500">Gagal memuat warna</p>';
      }
    });
  });

  // 2. Menangani klik tombol Checkout → isi hidden input
  const checkoutButtons = document.querySelectorAll('.btn-checkout');
  const productIdInput = document.getElementById('selectedProductId');
  const priceInput = document.getElementById('selectedProductPrice');

  checkoutButtons.forEach(button => {
    button.addEventListener('click', () => {
      const productId = button.dataset.id;
      const productPrice = button.dataset.price;

      if (!productId || !productPrice) {
        console.error('Data produk tidak ditemukan pada tombol checkout');
        return;
      }

      productIdInput.value = productId;
      priceInput.value = productPrice;

      console.log("✔️ ID Produk diset:", productId);
      console.log("✔️ Harga Produk diset:", productPrice);
    });
  });

  // 3. Debug saat form dikirim
  const checkoutForm = document.querySelector('#aproveModal form');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', function (e) {
      console.log("🟡 Form sedang dikirim...");
      console.log("📦 product_id:", productIdInput.value);
      console.log("💰 total_price:", priceInput.value);
    });
  }
</script>



</x-layout-user>