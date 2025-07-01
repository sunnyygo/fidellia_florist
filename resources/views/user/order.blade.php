<x-layout-user>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>

    <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
      <div class="mx-auto w-full flex-none lg:w-2/3 xl:max-w-4xl">
        <div class="space-y-6">
          @foreach ($orders as $o)
          <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
            <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
              <input type="checkbox"
                class="order-checkbox"
                data-name="{{ $o->product->name }}"
                data-price="{{ $o->product->price }}"
                value="{{ $o->id }}">
              <a href="#" class="shrink-0 md:order-1">
                @php
                $firstImage = $o->product->images->first()->image_url ?? null;
                @endphp

                @if ($firstImage)
                    <img src="{{ asset($firstImage) }}" class="mx-auto w-32 h-32 object-contain" />
                @else
                    <div class="text-center text-gray-400">Tidak ada foto</div>
                @endif
              </a>

              <label for="counter-input" class="sr-only">Choose quantity:</label>
              <div class="flex items-center justify-between md:order-3 md:justify-end">
                <div class="text-end md:order-4 md:w-32">
                <p class="text-base font-bold text-gray-900 dark:text-white">
                  Rp.{{ number_format($o->product->price, 0, ',', '.') }}
                </p>

                @php
                  $status = strtolower($o->status);
                  $statusClasses = match($status) {
                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                    'unpaid' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
                  };
                @endphp

                <p class="inline-block whitespace-normal {{ $statusClasses }} text-xs font-medium px-2 py-0.5 rounded mt-2">
                  {{ ucfirst($o->status) }}
                </p>
              </div>

                <div>
                </div>
              </div>

              <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                <a href="#" class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{ $o->product->name }}</a>

                <div class="flex items-center gap-4">
                  <button data-name="{{ $o->product->name }}"
    data-price="{{ number_format($o->product->price, 0, ',', '.') }}"
    data-description="{{ $o->product->description }}"
    data-address="{{ $o->address }}"
    data-phone="{{ $o->phone }}"
    data-customer="{{ $o->name }}"
    data-flower="{{ $o->flower->name }}"
    data-flowercolor="{{ $o->flowerColor->name }}"
    data-background="{{ $o->backgroundColor->name }}"
    data-list="{{ $o->listColor->name }}"
    data-images='@json($o->product->images)' type="button" data-modal-target="PreviewModal" data-modal-toggle="PreviewModal" class="btn-preview inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-1 mt-1 -ml-0.5">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                    </svg>
                    Lihat Detail Pesanan
                  </button>
                  <form class="flex items-center" action="{{ route('user.delete.order', $o->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                  <button type="input" class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                    <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    Remove
                  </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Order Summary -->
        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-1/3">
          <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>
            <div class="space-y-4">
              <dl class="flex justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Name</dt>
                <dd class="text-gray-900 dark:text-white">Tn. {{ $o->name }}</dd>
              </dl>
              <dl class="flex justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                <dd class="text-gray-900">{{ $o->email }}</dd>
              </dl>
              <dl class="flex justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Phone</dt>
                <dd class="text-gray-900 dark:text-white">{{ $o->phone }}</dd>
              </dl>
              <dl class="flex justify-between border-t border-gray-200 pt-2 dark:border-gray-700">
                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                <dd id="total-price" class="text-base font-bold text-gray-900 dark:text-white">Rp.</dd>
              </dl>
              <ul id="selected-orders" class="text-sm text-gray-700 dark:text-gray-300 space-y-1"></ul>
            </div>
            <form action="{{ route('user.order.checkout') }}" method="POST" id="checkout-form">
              @csrf
              <input type="hidden" name="total_amount" id="total-amount-input">
              <input type="hidden" name="selected_orders" id="selected-orders-input">
              <button type="submit" class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800">
                Proceed to Checkout
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Preview Produk -->
<div id="PreviewModal" tabindex="-1" aria-hidden="true"
     class="backdrop-blur-md hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pesanan</h3>
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

            <!-- Info Produk -->
            <div class="mb-2">
  <h4 id="preview-name" class="text-xl font-bold text-gray-900 dark:text-white"></h4>
  <p id="preview-price" class="text-lg font-semibold text-primary-600"></p>
</div>
<p id="preview-description" class="text-gray-700 dark:text-gray-300 mb-2"></p>

<!-- Tambahan info dari orders -->
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Pemesan:</strong> <span id="preview-customer"></span></p>
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>No. HP:</strong> <span id="preview-phone"></span></p>
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Alamat:</strong> <span id="preview-address"></span></p>
<hr class="my-2 border-gray-300 dark:border-gray-600">

<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Jenis Bunga:</strong> <span id="preview-flower"></span></p>
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Warna Bunga:</strong> <span id="preview-flowercolor"></span></p>
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Warna Background:</strong> <span id="preview-background"></span></p>
<p class="text-sm text-gray-700 dark:text-gray-300 mb-1"><strong>Warna List:</strong> <span id="preview-list"></span></p>
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

    const previewCustomer = document.getElementById('preview-customer');
    const previewPhone = document.getElementById('preview-phone');
    const previewAddress = document.getElementById('preview-address');

        const previewFlower = document.getElementById('preview-flower');
    const previewFlowerColor = document.getElementById('preview-flowercolor');
    const previewBackground = document.getElementById('preview-background');
    const previewList = document.getElementById('preview-list');

    previewButtons.forEach(button => {
        button.addEventListener('click', () => {
            previewName.textContent = button.dataset.name;
            previewPrice.textContent = 'Rp. ' + button.dataset.price;
            previewDescription.textContent = button.dataset.description;

            previewCustomer.textContent = button.dataset.customer;
            previewPhone.textContent = button.dataset.phone;
            previewAddress.textContent = button.dataset.address;

            previewFlower.textContent = button.dataset.flower;
            previewFlowerColor.textContent = button.dataset.flowercolor;
            previewBackground.textContent = button.dataset.background;
            previewList.textContent = button.dataset.list;
            

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const checkboxes = document.querySelectorAll('.order-checkbox');
      const totalInput = document.getElementById('total-amount-input');
      const selectedOrdersInput = document.getElementById('selected-orders-input');
      const totalPriceEl = document.getElementById('total-price');
      const selectedList = document.getElementById('selected-orders');

      function updateSummary() {
        let total = 0;
        let selected = [];

        selectedList.innerHTML = '';

        checkboxes.forEach(cb => {
          if (cb.checked) {
            const price = parseInt(cb.dataset.price);
            selected.push(cb.value);
            total += price;

            const li = document.createElement('li');
            li.textContent = cb.dataset.name + ' - Rp. ' + price.toLocaleString('id-ID');
            selectedList.appendChild(li);
          }
        });

        totalInput.value = total;
        selectedOrdersInput.value = selected.join(',');
        totalPriceEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
      }

      checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));
      updateSummary();
    });
  </script>



</x-layout-user>