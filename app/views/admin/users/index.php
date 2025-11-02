<div class="border p-3">
    <div class="overflow-x-auto">
        <table class="">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Institusi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Single Row Example -->
                <?php foreach ($data['users'] as $user) :  ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <?= $data['no']++ ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <?= $user->first_name . ' ' . $user->last_name ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-blue-600 font-medium">
                            <?= $user->email ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?= $user->role ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-blue-600 font-medium">
                            <?= $user->institution ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <?= $user->is_active == 1 ? "Active" : "Not Active" ?>
                        </td>
                        <td class="px-6 py-4">
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>