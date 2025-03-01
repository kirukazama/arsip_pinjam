<section class="w-full">
    <x-user-management.layout heading="{{ __('LIST USERS') }}" subheading="{{ __('Manage users with DataTable and form') }}">

        <!-- Search & Add Button -->
        <div class="mb-4 flex justify-between items-center">
            <flux:modal.trigger name="add-user">
                <flux:button variant="primary">Add User</flux:button>
            </flux:modal.trigger>
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search users..." class="p-2 border rounded w-1/3">
        </div>

        <!-- Table Users -->
        <table class="w-full border-collapse border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-950 text-white">
                    <th class="border p-2">Username</th>
                    <th class="border p-2">Nama Pegawai</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paginatedUsers as $user)
                    <tr class="border">
                        <td class="border p-2">{{ $user['username'] }}</td>
                        <td class="border p-2">{{ $user['nama_pegawai'] }}</td>
                        <td class="border p-2">{{ $user['email'] }}</td>
                        <td class="border p-2">{{ $user['role'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $paginatedUsers->links() }}
        </div>

        <flux:modal name="add-user" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Add User</flux:heading>
                    <flux:subheading>Make create to management user</flux:subheading>
                </div>

                <flux:input label="Username" placeholder="Your name" />
                <flux:input label="Nama Pegawai" placeholder="Your name" />
                <flux:input label="Email" type="email   " placeholder="Your Email" />

                <flux:select label="Role" wire:model="role" placeholder="Choose Role...">
                    <flux:select.option>User</flux:select.option>
                    <flux:select.option>Approver</flux:select.option>
                    <flux:select.option>Admin</flux:select.option>
                </flux:select>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </div>
            </div>
        </flux:modal>

    </x-user-management.layout>
</section>
