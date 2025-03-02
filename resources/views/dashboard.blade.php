<x-layouts.app>
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Users -->
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl shadow-md border dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Users</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">1,245</p>
        </div>

        <!-- Card 2: Pending Archives -->
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl shadow-md border dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Pending Archives</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">34</p>
        </div>

        <!-- Card 3: Approved Archives -->
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl shadow-md border dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Approved Archives</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">567</p>
        </div>

        <!-- Table for Recent Activities -->
        <div class="col-span-1 md:col-span-3 bg-white dark:bg-zinc-900 p-4 rounded-xl shadow-md border dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Recent Activities</h3>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="border-b dark:border-zinc-700">
                            <th class="py-2 px-4 text-gray-700 dark:text-gray-300">User</th>
                            <th class="py-2 px-4 text-gray-700 dark:text-gray-300">Activity</th>
                            <th class="py-2 px-4 text-gray-700 dark:text-gray-300">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b dark:border-zinc-700">
                            <td class="py-2 px-4 text-gray-900 dark:text-white">John Doe</td>
                            <td class="py-2 px-4 text-gray-700 dark:text-gray-300">Uploaded a document</td>
                            <td class="py-2 px-4 text-gray-700 dark:text-gray-300">2025-03-01</td>
                        </tr>
                        <tr class="border-b dark:border-zinc-700">
                            <td class="py-2 px-4 text-gray-900 dark:text-white">Jane Smith</td>
                            <td class="py-2 px-4 text-gray-700 dark:text-gray-300">Approved an archive</td>
                            <td class="py-2 px-4 text-gray-700 dark:text-gray-300">2025-02-28</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
