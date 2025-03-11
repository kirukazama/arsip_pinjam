<div>
    <flux:main container class="space-y-6">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Peminjaman Arsip</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Peminjaman Arsip</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />
        <div class="flex items-center gap-2">
            <flux:input size="sm" wire:model.live="search" placeholder="Search.."
                class="w-full max-w-sm ml-auto" />
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Kode Arsip</th>
                            <th class="px-4 py-2">Nama Arsip</th>
                            <th class="px-4 py-2">Biro</th> <!-- Kolom Biro ditambahkan -->
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsips as $index => $arsip)
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_kode }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_name }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->biro->biro_name }}</td> <!-- Tampilkan nama biro -->
                                <td class="px-4 py-2">
                                    <flux:button variant="primary" size="sm" wire:click="openPinjamModal({{ $arsip->id }})">
                                        Pinjam
                                    </flux:button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $arsips->links() }} <!-- Tetap gunakan pagination links -->
            </div>
        </div>
    </flux:main>

    <!-- Modal Peminjaman -->
    <flux:modal name="pinjam-modal" variant="flyout" wire:model="showPinjamModal">
        <form wire:submit.prevent="pinjam" class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">Pinjam Arsip</flux:heading>
                <flux:subheading>Isi detail peminjaman arsip.</flux:subheading>
            </div>

            <flux:input label="Tanggal Peminjaman" type="date" placeholder="Masukkan Tanggal Peminjaman" class="mt-4"
                wire:model="pinjamTanggal" />

            <flux:input label="Tanggal Kembali" type="date" placeholder="Masukkan Tanggal Kembali" class="mt-4"
                wire:model="kembaliTanggal" />

            <flux:input label="Telepon" placeholder="Masukkan Nomor Telepon" class="mt-4"
                wire:model="pinjamTelp" />

            <flux:input label="Tujuan Peminjaman" placeholder="Masukkan Tujuan Peminjaman" class="mt-4"
                wire:model="pinjamTujuan" />

            <flux:textarea label="Keterangan (optional)" placeholder="Keterangan (Optional)" class="mt-4"
                wire:model="keterangan" />

            <div class="flex space-x-4 mt-6">
                <flux:spacer />
                <flux:button type="submit" size="sm" variant="primary">
                    Pinjam Arsip
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>