<div>
    <flux:main container class="space-y-6">
        {{-- @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"></span>
            </div>
        @endif --}}
        <div class="flex justify-between items-center">
            <flux:heading size="xl">Inbox</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#">Admin</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Master</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Inbox</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:separator variant="subtle" class="my-4" />
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">No. Tlp</th>
                            <th class="px-4 py-2">Biro</th>
                            <th class="px-4 py-2">Nama Arsip</th>
                            <th class="px-4 py-2">Tgl Pinjam</th>
                            <th class="px-4 py-2">Keterangan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($biros as $index => $biro) --}}
                            <tr class="border-b dark:border-gray-600">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100"></td>
                                <td class="px-4 py-2">
                                    <flux:dropdown position="bottom" align="end" offset="-15">
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                            inset="top bottom">
                                        </flux:button>
                                        <flux:menu>
                                            <flux:modal.trigger name="form-data" class="p-4">
                                                <flux:menu.item icon="document-text"
                                                    wire:click="" name="form-data">Edit
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
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{-- {{ $biros->links() }} --}}
            </div>
        </div>
    </flux:main>
</div>
