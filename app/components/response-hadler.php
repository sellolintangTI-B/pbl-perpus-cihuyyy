 <style>
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .alert-slide {
            animation: slideDown 0.5s ease-out;
        }
</style>
<?php
    $response = app\core\ResponseHandler::getResponse();
    if (!empty($response)) {
        $isSuccess = $response['type'] == 'success';
        $message = $response['message'];
?>
    <div class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4 alert-slide">
        <div class="<?= 'bg-white rounded-md shadow-lg border-l-4 max-w-2xl w-full overflow-hidden ' . ($isSuccess ? 'border-green-500' : 'border-red-500') ?>">
            <div class="flex items-start p-4">
                <?php if ($isSuccess) { ?>
                    <div class="shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                <?php } else { ?>
                    <div class="shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                <?php } ?>
                <div class="ml-3 flex-1">
                    <h3 class="<?= 'text-sm font-medium mb-2 ' . ($isSuccess ? 'text-green-800' : 'text-red-800') ?>">
                        <?= $isSuccess ? "Berhasil!" : "Terjadi Kesalahan!" ?>
                    </h3>
                    <?php if ($isSuccess) { ?>
                        <p class="text-sm text-green-700">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php } else { ?>
                        <div class="text-sm text-red-700">
                            <?php
                                if (is_array($message)) {
                                    echo "<ul class='list-disc list-inside space-y-1'>";
                                    foreach ($message as $err) {
                                        echo "<li>" . htmlspecialchars($err) . "</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>" . htmlspecialchars($message) . "</p>";
                                }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="shrink-0 ml-4 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
<?php
    }
?>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-slide');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
</script>