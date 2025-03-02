<div>
    <flux:main container class="space-y-6">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                pegawai="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" pegawai="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Settings</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>pegawai</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />

        <div class="flex items-center gap-2">
            <flux:modal.trigger name="form-data">
                <flux:button size="sm" variant="primary">Tambah Pegawai</flux:button>
            </flux:modal.trigger>
            <flux:input size="sm" wire:model.live="search" placeholder="Cari dengan NIP / Nama.."
                class="w-full max-w-sm ml-auto" />
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Jabatan</th>
                            <th class="px-4 py-2">Biro</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pegawais)
                            @foreach ($pegawais as $index => $pegawai)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->pegawai_nip }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->pegawai_name }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->jabatan_name }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                        {{ $pegawai->biro->biro_name }}</td>
                                    <td class="px-4 py-2">
                                        <flux:dropdown position="bottom" align="end" offset="-15">
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                                inset="top bottom">
                                            </flux:button>
                                            <flux:menu>
                                                <flux:modal.trigger name="form-data" class="p-4">
                                                    <flux:menu.item icon="document-text"
                                                        wire:click="edit({{ $pegawai->id }})" name="form-data">Edit
                                                    </flux:menu.item>
                                                </flux:modal.trigger>
                                                <flux:modal.trigger name="delete">
                                                    <flux:menu.item icon="archive-box" variant="danger">Delete
                                                    </flux:menu.item>
                                                </flux:modal.trigger>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-900 dark:text-gray-100">
                                    Data tidak ditemukan / Masih Kosong.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if($pegawais)
            <div class="mt-4">
                {{ $pegawais->links() }}
            </div>
            @endif
        </div>

        <flux:modal name="form-data" variant="flyout">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">{{ $isEditMode ? 'Update Data Pegawai' : 'Tambah Data Pegawai' }}
                    </flux:heading>
                    <flux:subheading>{{ $isEditMode ? 'Update' : 'Tambah' }} Data Pegawai Anda.</flux:subheading>
                </div>

                <flux:input label="NIP" placeholder="Masukkan NIP" class="mt-4" wire:model="pegawaiNip" />

                <flux:input label="Nama Pegawai" placeholder="Masukkan Nama Pegawai" class="mt-4"
                    wire:model="pegawaiName" />

                <flux:input label="Jabatan" placeholder="Masukkan Jabatan Pegawai" class="mt-4"
                    wire:model="jabatanName" />

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
                        {{ $isEditMode ? 'Simpan Perubahan' : 'Tambah Pegawai' }}</flux:button>
                </div>
            </form>
        </flux:modal>

        <flux:modal name="delete" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Baris ini ?</flux:heading>

                    <flux:subheading>
                        <p>You're about to delete this project.</p>
                    </flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger" wire:click="delete({{ @$pegawai->id }})">Ya Hapus
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </flux:main>
</div>
