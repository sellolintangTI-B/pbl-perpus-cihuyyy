<?php
use App\Core\ResponseHandler;
$response = ResponseHandler::getResponse();

?>
<form class="max-w-md bg-white rounded-lg shadow-md p-6 space-y-4" method="post" enctype="multipart/form-data" action="<?= URL ?>/admin/room/update/<?= $data->id ?>">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
            Name
        </label>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= $data->name ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div>
        <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">
            Floor
        </label>
        <input
            type="number"
            id="floor"
            name="floor"
            value="<?= $data->floor ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div>
        <label for="min" class="block text-sm font-medium text-gray-700 mb-1">
            Min
        </label>
        <input
            type="number"
            id="min"
            name="min"
            value="<?= $data->min_capacity ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div>
        <label for="max" class="block text-sm font-medium text-gray-700 mb-1">
            Max
        </label>
        <input
            type="number"
            id="max"
            name="max"
            value="<?= $data->max_capacity ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="flex items-center">
        <input
            type="checkbox"
            id="isSpecial"
            name="isSpecial"
            <?= $data->requires_special_approval ? 'checked' : '' ?>
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
        <label for="isSpecial" class="ml-2 text-sm font-medium text-gray-700">
            Is Special
        </label>
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
            Image
        </label>
        <input
            type="file"
            id="image"
            name="file_upload"
            accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>

    <div class="pt-4">
        <button
            type="submit"
            class="w-full bg-blue-600 text-black py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            Submit
        </button>
    </div>
</form>