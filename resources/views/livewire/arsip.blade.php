<div>
    <flux:main container class="space-y-6">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Arsip</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Arsip</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="primary" wire:click="openModal()">Tambah Arsip</flux:button>
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
                            <th class="px-4 py-2">Tanggal Masuk</th>
                            <th class="px-4 py-2">Tanggal Akhir</th>
                            <th class="px-4 py-2">Aktif</th>
                            <th class="px-4 py-2">Lokasi ID</th>
                            <th class="px-4 py-2">Biro ID</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsips as $index => $arsip)
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_kode }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_name }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_masuk }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->arsip_akhir }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ $arsip->is_active ? 'Ya' : 'Tidak' }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->lokasi_id }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $arsip->biro_id }}</td>
                                <td class="px-4 py-2">
                                    <flux:dropdown position="bottom" align="end" offset="-15">
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                            inset="top bottom">
                                        </flux:button>
                                        <flux:menu>
                                            <flux:menu.item icon="document-text" wire:click="edit({{ $arsip->id }})"
                                                name="form-data">Edit
                                            </flux:menu.item>
                                            <flux:menu.item icon="archive-box" variant="danger"
                                                wire:click="confirmDelete({{ $arsip->id }})">Delete
                                            </flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $arsips->links() }}
            </div>
        </div>

        <flux:modal name="form-data" variant="flyout">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">
                        {{ $isEditMode ? 'Update Data Arsip' : 'Tambah Data Arsip' }}
                    </flux:heading>
                    <flux:subheading>{{ $isEditMode ? 'Update' : 'Tambah' }} Data Arsip Anda.</flux:subheading>
                </div>

                <flux:input label="Kode Arsip" placeholder="Masukkan Kode Arsip" class="mt-4"
                    wire:model="arsipKode" />
                <flux:input label="Nama Arsip" placeholder="Masukkan Nama Arsip" class="mt-4"
                    wire:model="arsipName" />
                <flux:input label="Tanggal Masuk" type="date" placeholder="Masukkan Tanggal Masuk" class="mt-4"
                    wire:model="arsipMasuk" />
                <flux:input label="Tanggal Akhir" type="date" placeholder="Masukkan Tanggal Akhir" class="mt-4"
                    wire:model="arsipAkhir" />
                <flux:checkbox label="Aktif" wire:model="isActive" class="mt-4" checked />
                <flux:select label="Pilih Lokasi" wire:model="lokasiId">
                    <option>:: Pilih Lokasi ::</option>
                    @if ($lokasis)
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->lokasi_cabin }}/{{ $lokasi->lokasi_column }}/{{ $lokasi->lokasi_row }}</option>
                        @endforeach
                    @endif
                </flux:select>
                <flux:select label="Pilih Biro" wire:model="biroId">
                    <option>:: Pilih Biro ::</option>
                    @if ($biros)
                        @foreach ($biros as $biro)
                            <option value="{{ $biro->id }}">{{ $biro->biro_name }}</option>
                        @endforeach
                    @endif
                </flux:select>
                <div class="flex space-x-4 mt-6">
                    <flux:spacer />
                    <flux:button type="submit" size="sm" variant="primary">
                        {{ $isEditMode ? 'Simpan Perubahan' : 'Tambah Arsip' }}</flux:button>
                </div>
            </form>
        </flux:modal>

        <flux:modal name="delete" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Hapus Arsip ini ?</flux:heading>

                    <flux:subheading>
                        <p>Anda akan menghapus arsip ini.</p>
                    </flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger" wire:click="delete()">Ya Hapus</flux:button>
                </div>
            </div>
        </flux:modal>
    </flux:main>
</div>
