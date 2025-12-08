<?php

namespace App\Components;

class Pagination
{
    public static function render(
        int $currentPage = 1,
        int $totalPage = 1,
        array $queryParams = [],
        int $maxVisible = 5,
        string $prevText = "Sebelumnya",
        string $nextText = "Selanjutnya"
    ): string {
        // Build query string from parameters
        $queryString = !empty($queryParams) ? http_build_query($queryParams) : '';
        $baseUrl = $queryString ? '?' . $queryString . '&page=' : '?page=';

        // Calculate prev and next pages
        $prevPage = $currentPage > 1 ? $currentPage - 1 : 1;
        $nextPage = $currentPage < $totalPage ? $currentPage + 1 : $totalPage;

        // Calculate visible page range
        $startPage = max(1, $currentPage - floor($maxVisible / 2));
        $endPage = min($totalPage, $startPage + $maxVisible - 1);

        if ($endPage - $startPage < $maxVisible - 1) {
            $startPage = max(1, $endPage - $maxVisible + 1);
        }

        ob_start();
?>
        <form class="w-full flex justify-between items-center h-fit px-2" method="GET">
            <!-- Previous Button -->
            <a href="<?= $baseUrl . $prevPage ?>"
                class="h-full px-3 py-2 rounded-md border border-primary text-white bg-primary text-xs font-medium transition-colors duration-150 <?= $currentPage <= 1 ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-white hover:text-primary' ?>">
                <?= htmlspecialchars($prevText) ?>
            </a>

            <!-- Page Numbers -->
            <div class="w-fit h-full border border-primary rounded-md overflow-hidden flex">
                <?php if ($startPage > 1): ?>
                    <!-- First Page -->
                    <a href="<?= $baseUrl . '1' ?>"
                        class="text-xs h-full px-3 py-2 cursor-pointer border-r border-primary transition-colors duration-150 <?= $currentPage == 1 ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-primary/10' ?>">
                        1
                    </a>

                    <!-- Ellipsis -->
                    <?php if ($startPage > 2): ?>
                        <span class="text-xs h-full px-3 py-2 bg-white text-primary border-r border-primary">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Visible Page Range -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="<?= $baseUrl . $i ?>"
                        class="text-xs h-full px-3 py-2 cursor-pointer border-r border-primary last:border-r-0 transition-colors duration-150 <?= $currentPage == $i ? 'bg-primary text-white font-semibold' : 'bg-white text-primary hover:bg-primary/10' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($endPage < $totalPage): ?>
                    <!-- Ellipsis if needed -->
                    <?php if ($endPage < $totalPage - 1): ?>
                        <span class="text-xs h-full px-3 py-2 bg-white text-primary border-r border-primary">...</span>
                    <?php endif; ?>

                    <!-- Last Page -->
                    <a href="<?= $baseUrl . $totalPage ?>"
                        class="text-xs h-full px-3 py-2 cursor-pointer transition-colors duration-150 <?= $currentPage == $totalPage ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-primary/10' ?>">
                        <?= $totalPage ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Next Button -->
            <a href="<?= $baseUrl . $nextPage ?>"
                class="h-full px-3 py-2 rounded-md border border-primary text-white text-xs font-medium transition-colors bg-primary duration-150 <?= $currentPage >= $totalPage ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-white hover:text-primary' ?>">
                <?= htmlspecialchars($nextText) ?>
            </a>
        </form>
<?php
        return ob_get_clean();
    }
}
