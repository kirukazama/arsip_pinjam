<div>
    <flux:main container class="space-y-6">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Users</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Users</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />
        <div class="flex items-center gap-2">
            <flux:input size="sm" wire:model.live="search" placeholder="Search Pegawai.."
                class="w-full max-w-sm ml-auto" />
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Jabatan</th>
                            <th class="px-4 py-2">Biro</th>
                            {{-- <th class="px-4 py-2">Jumlah Akun</th> --}}
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawais as $pegawai)
                            <!-- Pegawai Row -->
                            <tr class="border-b dark:border-gray-600" wire:click="toggleExpand({{ $pegawai->id }})">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    @if (in_array($pegawai->id, $expandedPegawaiIds))
                                        <flux:icon.chevron-down />
                                    @else
                                        <flux:icon.chevron-right />
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->pegawai_nip }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $pegawai->pegawai_name }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->jabatan_name }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ $pegawai->biro->biro_name ?? '-' }}</td>
                                {{-- <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pegawai->user->count() }}</td> --}}
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    <flux:button size="sm" variant="primary"
                                        wire:click="openModal({{ $pegawai->id }})">
                                        <flux:icon.plus size="xs" />
                                    </flux:button>
                                </td>
                            </tr>

                            <!-- User Rows -->
                            @if (in_array($pegawai->id, $expandedPegawaiIds))
                                <tr
                                    class="bg-emerald-200 dark:bg-emerald-700 text-gray-900 dark:text-gray-100 text-left">
                                    <td class="px-4 py-2"></td>
                                    <td class="px-4 py-2">User Name</td>
                                    <td class="px-4 py-2" colspan="2">Email</td>
                                    <td class="px-4 py-2">Role</td>
                                    <td class="px-4 py-2"></td>
                                </tr>
                                @foreach ($pegawai->user as $user)
                                    <tr class="bg-indigo-50 hover:bg-indigo-100">
                                        <td></td>
                                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                                        <td colspan="2" class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                            {{ $user->email }}</td>
                                        <td class="px-12 py-4 whitespace-nowrap">{{ $user->role->role_name ?? '-' }}
                                        </td>
                                        <td>
                                            <flux:dropdown position="bottom" align="end" offset="-15">
                                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                                    inset="top bottom">
                                                </flux:button>
                                                <flux:menu>
                                                    <flux:menu.item icon="document-text"
                                                        wire:click="edit({{ $user->id }})" name="form-data">Edit
                                                    </flux:menu.item>
                                                    <flux:menu.item icon="archive-box" variant="danger"
                                                        wire:click="confirmDelete({{ $user->id }})">Delete
                                                    </flux:menu.item>
                                                </flux:menu>
                                            </flux:dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $pegawais->links() }}
            </div>
        </div>

        <flux:modal name="form-data" variant="flyout">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">{{ $isEditMode ? 'Update Data Biro' : 'Tambah Data Biro' }}
                    </flux:heading>
                    <flux:subheading>{{ $isEditMode ? 'Update' : 'Tambah' }} Data Biro Anda.</flux:subheading>
                </div>

                <flux:input hidden wire:model="pegawaiId" />
                <flux:input label="User Name" placeholder="Masukkan User Name" class="mt-4" wire:model="userName" />
                <flux:input label="Email" placeholder="contoh@contoh.com" class="mt-4" wire:model="userEmail"
                    type="email" />
                <flux:select label="Role" wire:model="roleId">
                    <option>:: Pilih Role ::</option>
                    @if ($roles)
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    @endif
                </flux:select>
                <div class="flex space-x-4 mt-6">
                    <flux:spacer />
                    <flux:button type="submit" size="sm" variant="primary">
                        {{ $isEditMode ? 'Simpan Perubahan' : 'Tambah Akun' }}</flux:button>
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
