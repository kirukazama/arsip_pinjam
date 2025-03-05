<div>
    <flux:main container class="space-y-6">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Biro</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Biro</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="primary" wire:click="openModal()">Tambah Biro</flux:button>
            <flux:input size="sm" wire:model.live="search" placeholder="Search biro.."
                class="w-full max-w-sm ml-auto" />
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Biro</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biros as $index => $biro)
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $biro->biro_name }}</td>
                                <td class="px-4 py-2">
                                    <flux:dropdown position="bottom" align="end" offset="-15">
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                            inset="top bottom">
                                        </flux:button>
                                        <flux:menu>
                                            <flux:menu.item icon="document-text" wire:click="edit({{ $biro->id }})"
                                                name="form-data">Edit
                                            </flux:menu.item>
                                            <flux:menu.item icon="archive-box" variant="danger"
                                                wire:click="confirmDelete({{ $biro->id }})">Delete
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
                {{ $biros->links() }}
            </div>
        </div>

        <flux:modal name="form-data" variant="flyout">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">{{ $isEditMode ? 'Update Data Biro' : 'Tambah Data Biro' }}
                    </flux:heading>
                    <flux:subheading>{{ $isEditMode ? 'Update' : 'Tambah' }} Data Biro Anda.</flux:subheading>
                </div>

                <flux:input label="Nama Biro" placeholder="Masukkan Nama Biro" class="mt-4" wire:model="biroName" />

                <div class="flex space-x-4 mt-6">
                    <flux:spacer />
                    <flux:button type="submit" size="sm" variant="primary">
                        {{ $isEditMode ? 'Simpan Perubahan' : 'Tambah Biro' }}</flux:button>
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

                    <flux:button type="submit" variant="danger" wire:click="delete()">Ya Hapus
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </flux:main>
</div>
