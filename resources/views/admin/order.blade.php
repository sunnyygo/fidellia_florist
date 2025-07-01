<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-hidden relative">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                {{-- <th scope="col" class="px-4 py-3">Foto</th> --}}
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Jenis Papan Bunga</th>
                <th scope="col" class="px-4 py-3">Jenis Bunga</th>
                <th scope="col" class="px-4 py-3">Warna Bunga</th>
                <th scope="col" class="px-4 py-3">Warna Backround</th>
                <th scope="col" class="px-4 py-3">Warna List</th>
                <th scope="col" class="px-4 py-3">Kalimat</th>
                <th scope="col" class="px-4 py-3">Alamat</th>
                <th scope="col" class="px-4 py-3">Status Pembayaran</th>
                <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $o)
                @php
                    $dropdownId = 'dropdown-' . $o->id;
                @endphp
                <tr class="border-b dark:border-gray-700 relative">
                    {{-- <td class="px-4 py-3"><img class="size-8 rounded-full" src="{{ $u->foto ? asset('foto/' . $u->foto) : 'https://via.placeholder.com/32' }}" alt="Belum ada" /></td> --}}
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $o->name }}
                    </th>
                    <td class="px-4 py-3">{{ $o->product->name }}</td>
                    <td class="px-4 py-3">{{ $o->flower->name }}</td>
                    <td class="px-4 py-3">{{ $o->flowerColor->name }}</td>
                    <td class="px-4 py-3">{{ $o->backgroundColor->name }}</td>
                    <td class="px-4 py-3">{{ $o->listColor->name }}</td>
                    <td class="px-4 py-3">{{ $o->kalimat }}</td>
                    <td class="px-4 py-3">{{ $o->address }}</td>
                    <td class="px-4 py-3">{{ $o->status }}</td>
                    <td class="px-4 py-3">
                    <form action="{{ route('admin.update.order', $o->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $o->id }}">
                        <select name="status_order" onchange="this.form.submit()" class="bg-gray-100 rounded px-2 py-1">
                            <option value="pending" {{ $o->status_order == 'pending' ? 'selected' : '' }} >Pending</option>
                            <option value="selesai" {{ $o->status_order == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancel" {{ $o->status_order == 'cancel' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-layout>