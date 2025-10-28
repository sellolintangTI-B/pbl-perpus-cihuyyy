<?php
namespace App\Components\Icon;
class Icon{
   public static function person(string $class = 'w-6 h-6 text-gray-700'): void {
        echo '<svg xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="currentColor"
                    class="' . htmlspecialchars($class) . '">
            <path d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m-8 6v-.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2v.8q0 .825-.587 1.413T18 20H6q-.825 0-1.412-.587T4 18"/>
        </svg>';
    }
    public static function dashboard(string $class = 'w-6 h-6 text-gray-700'): void {
        echo '<svg xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                viewBox="0 0 24 24">
            <path  d="M4 19v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-3q-.425 0-.712-.288T14 20v-5q0-.425-.288-.712T13 14h-2q-.425 0-.712.288T10 15v5q0 .425-.288.713T9 21H6q-.825 0-1.412-.587T4 19"/>
        </svg>';
    }
}