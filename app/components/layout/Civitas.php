<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title??"SIMARU"?></title>
    <link href="/public/css/output.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
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
</head>
<body class="font-poppins bg-gray-100">
    <!-- Error Messages -->
    <?php
        $error = ErrorHandler::getError();
        if(!empty($error)) {
    ?>
        <div class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4 alert-slide">
            <div class="bg-white rounded-lg shadow-lg border-l-4 border-red-500 max-w-2xl w-full overflow-hidden">
                <div class="flex items-start p-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-red-800 mb-2">
                            Terjadi Kesalahan
                        </h3>
                        <div class="text-sm text-red-700">
                            <?php
                                if(is_array($error)){
                                    echo "<ul class='list-disc list-inside space-y-1'>";
                                    foreach($error as $err){
                                        echo "<li>" . htmlspecialchars($err) . "</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>" . htmlspecialchars($error) . "</p>";
                                }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Close Button -->
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4 text-red-400 hover:text-red-600 transition">
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
    
    <!-- Success Messages -->
    <?php
        if(isset($_SESSION['success'])) {
    ?>
        <div class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4 alert-slide">
            <div class="bg-white rounded-lg shadow-lg border-l-4 border-green-500 max-w-2xl w-full overflow-hidden">
                <div class="flex items-start p-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-green-800 mb-1">
                            Berhasil!
                        </h3>
                        <p class="text-sm text-green-700">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </p>
                    </div>
                    
                    <!-- Close Button -->
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4 text-green-400 hover:text-green-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    <?php
        unset($_SESSION['success']);
        }
    ?>
    
    <!-- Main Content -->
    <div>
        <?=$content?>
    </div>
    
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
</body>
</html>