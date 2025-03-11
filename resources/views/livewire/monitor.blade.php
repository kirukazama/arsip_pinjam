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
            <flux:input size="sm" wire:model.live="search" placeholder="Cari dengan kode / nama Arsip"
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
                            <th class="px-4 py-2">Tanggal Pinjam</th> <!-- Kolom Biro ditambahkan -->
                            <th class="px-4 py-2">Tanggal Kembali</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $index => $pinjam)
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pinjam->arsip->arsip_kode }}
                                </td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pinjam->arsip->arsip_name }}
                                </td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ date('d-m-Y', strtotime($pinjam->pinjam_tanggal)) }}
                                </td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ date('d-m-Y', strtotime($pinjam->kembali_tanggal)) }}
                                </td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"><flux:badge variant="solid" color="{{ $pinjam->pinjam_status === 'tolak verifikator' ? 'red' : ($pinjam->pinjam_status === 'setuju verifikator' ? 'green' : 'blue') }}">{{ $pinjam->pinjam_status }}</flux:badge></td>
                                <td class="px-4 py-2">
                                    <flux:button variant="primary" size="sm"
                                        wire:click="detail({{ $pinjam->id }})">
                                        Detail
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100 text-center" colspan="7">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $peminjamans->links() }} <!-- Tetap gunakan pagination links -->
            </div>
        </div>
    </flux:main>

    <flux:modal name="pinjam-modal" variant="flyout" wire:model="showDetail">
        <div class="space-y-2">
            <flux:heading size="lg">Detail Peminjaman Arsip</flux:heading>
            <flux:subheading>detail peminjaman arsip.</flux:subheading>
        </div>
        <flux:separator variant="subtle" class="my-4" />

        <form wire:submit.prevent="pinjam" class="space-y-6">
            <table class="w-full border border-gray-300 rounded-lg border-collapse">
                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300 w-1/3">Kode Arsip</td>
                        <td class="p-2 border border-gray-300">{{ $arsipKode }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300 w-1/3">Nama Arsip</td>
                        <td class="p-2 border border-gray-300">{{ $arsipName }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300 w-1/3">Jenis Arsip</td>
                        <td class="p-2 border border-gray-300">{{ ucfirst($arsipJenis) }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300 w-1/3">Asal Arsip</td>
                        <td class="p-2 border border-gray-300">Biro {{ ucfirst($biroName) }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300 w-1/3">Tanggal Peminjaman</td>
                        <td class="p-2 border border-gray-300">{{ date('d-m-Y', strtotime($pinjamTanggal)) }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300">Tanggal Kembali</td>
                        <td class="p-2 border border-gray-300">{{ date('d-m-Y', strtotime($kembaliTanggal)) }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300">Status Pinjam</td>
                        <td class="p-2 border border-gray-300">{{ $pinjamStatus }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300">Telepon Peminjam</td>
                        <td class="p-2 border border-gray-300">{{ $pinjamTelp }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300">Tujuan Peminjaman</td>
                        <td class="p-2 border border-gray-300">{{ $pinjamTujuan }}</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-2 font-semibold border border-gray-300">Keterangan</td>
                        <td class="p-2 border border-gray-300">{{ $keterangan }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 font-semibold border border-gray-300">Catatan Verifikator</td>
                        <td class="p-2 border border-gray-300">{{ $catatan }}</td>
                    </tr>
                </tbody>
            </table>
        </form>
    </flux:modal>
</div>
