<?php

namespace App\Components;

class Pagination
{
    public static function render(array $data): void
    {
        $currentPage = $data['current_page'] ?? 1;
        $totalPages = $data['total_pages'] ?? 1;
        $baseUrl = $data['base_url'] ?? '';
        $queryParams = $data['query_params'] ?? [];
        $prevText = $data['prev_text'] ?? 'Sebelumnya';
        $nextText = $data['next_text'] ?? 'Selanjutnya';
        $maxVisible = $data['max_visible'] ?? 5; // maksimum data yang ditampilkan

        // Generate query string for pagination
        $buildUrl = function ($page) use ($baseUrl, $queryParams) {
            $params = array_merge($queryParams, ['page' => $page]);
            $queryString = http_build_query($params);
            return $baseUrl . ($queryString ? '?' . $queryString : '');
        };

        // Calculate visible page range
        $visiblePages = self::getVisiblePages($currentPage, $totalPages, $maxVisible);
?>
        <div class="flex items-center justify-center gap-2 py-4">
            <!-- Previous Button -->
            <?php if ($currentPage > 1): ?>
                <a href="<?= $buildUrl($currentPage - 1) ?>"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <?= $prevText ?>
                </a>
            <?php else: ?>
                <button disabled
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-300 text-gray-500 font-medium text-sm cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <?= $prevText ?>
                </button>
            <?php endif; ?>

            <!-- Page Numbers -->
            <div class="flex items-center gap-1">
                <?php foreach ($visiblePages as $page): ?>
                    <?php if ($page === '...'): ?>
                        <span class="px-3 py-2 text-gray-500 font-medium text-sm">...</span>
                    <?php else: ?>
                        <?php if ($page == $currentPage): ?>
                            <span class="min-w-[40px] h-10 flex items-center justify-center rounded-lg bg-blue-600 text-white font-semibold text-sm">
                                <?= $page ?>
                            </span>
                        <?php else: ?>
                            <a href="<?= $buildUrl($page) ?>"
                                class="min-w-[40px] h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 font-medium text-sm hover:bg-gray-50 hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <?= $page ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Next Button -->
            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= $buildUrl($currentPage + 1) ?>"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition-colors duration-200">
                    <?= $nextText ?>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            <?php else: ?>
                <button disabled
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-300 text-gray-500 font-medium text-sm cursor-not-allowed">
                    <?= $nextText ?>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            <?php endif; ?>
        </div>
<?php
    }

    /**
     * Calculate visible page numbers with ellipsis
     * 
     * @param int $current Current page number
     * @param int $total Total pages
     * @param int $maxVisible Maximum visible page links
     * @return array Array of page numbers and ellipsis
     */
    private static function getVisiblePages(int $current, int $total, int $maxVisible): array
    {
        if ($total <= $maxVisible) {
            return range(1, $total);
        }

        $pages = [];
        $halfVisible = floor($maxVisible / 2);

        // Always show first page
        $pages[] = 1;

        // Calculate start and end of visible range
        $start = max(2, $current - $halfVisible);
        $end = min($total - 1, $current + $halfVisible);

        // Adjust if we're near the start
        if ($current <= $halfVisible + 1) {
            $end = min($total - 1, $maxVisible - 1);
            $start = 2;
        }

        // Adjust if we're near the end
        if ($current >= $total - $halfVisible) {
            $start = max(2, $total - $maxVisible + 2);
            $end = $total - 1;
        }

        // Add ellipsis after first page if needed
        if ($start > 2) {
            $pages[] = '...';
        }

        // Add visible page range
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        // Add ellipsis before last page if needed
        if ($end < $total - 1) {
            $pages[] = '...';
        }

        // Always show last page
        if ($total > 1) {
            $pages[] = $total;
        }

        return $pages;
    }
}
