<?php

namespace App\Components\Icon;

class Icon
{
    public static function person(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="currentColor"
                    class="' . htmlspecialchars($class) . '">
            <path d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m-8 6v-.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2v.8q0 .825-.587 1.413T18 20H6q-.825 0-1.412-.587T4 18"/>
        </svg>';
    }
    public static function home(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                viewBox="0 0 24 24">
            <path  d="M4 19v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-3q-.425 0-.712-.288T14 20v-5q0-.425-.288-.712T13 14h-2q-.425 0-.712.288T10 15v5q0 .425-.288.713T9 21H6q-.825 0-1.412-.587T4 19"/>
        </svg>';
    }
    public static function room(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                viewBox="0 0 24 24">
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.9205 0.0104654L14.5455 1.69797C14.6735 1.72302 14.7888 1.79177 14.8717 1.89246C14.9547 1.99316 15 2.11954 15 2.24997V15.75C15 15.8805 14.9547 16.0068 14.8717 16.1075C14.7888 16.2082 14.6735 16.277 14.5455 16.302L5.9205 17.9895C5.83902 18.0055 5.75503 18.0032 5.67454 17.9828C5.59406 17.9625 5.51908 17.9245 5.45498 17.8718C5.39089 17.819 5.33927 17.7527 5.30383 17.6776C5.26839 17.6025 5.25001 17.5206 5.25 17.4375V0.562468C5.25001 0.479446 5.26839 0.397455 5.30383 0.322379C5.33927 0.247302 5.39089 0.181001 5.45498 0.128234C5.51908 0.0754665 5.59406 0.0375414 5.67454 0.0171798C5.75503 -0.00318166 5.83902 -0.00547475 5.9205 0.0104654ZM8.25 8.25C8.05109 8.25 7.86032 8.32902 7.71967 8.46967C7.57902 8.61032 7.5 8.80109 7.5 9C7.5 9.19891 7.57902 9.38968 7.71967 9.53033C7.86032 9.67099 8.05109 9.75 8.25 9.75C8.44891 9.75 8.63968 9.67099 8.78033 9.53033C8.92098 9.38968 9 9.19891 9 9C9 8.80109 8.92098 8.61032 8.78033 8.46967C8.63968 8.32902 8.44891 8.25 8.25 8.25ZM4.5 1.87497V16.125H0.5625C0.426572 16.125 0.295244 16.0758 0.192802 15.9865C0.0903607 15.8971 0.0237362 15.7737 0.00524998 15.639L0 15.5625V2.43747C5.73217e-06 2.30155 0.0492322 2.17022 0.138575 2.06778C0.227919 1.96533 0.351335 1.89871 0.486 1.88022L0.5625 1.87497H4.5Z"/>
            </svg>';
    }
    public static function logout(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            viewBox="0 0 24 24">
            fill="none" xmlns="http://www.w3.org/2000/svg">
        <path  d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z"/>
        </svg>';
    }
    public static function plus(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            viewBox="0 0 18 18">
            fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.71429 9.71429H1.28572C0.921433 9.71429 0.61629 9.59771 0.37029 9.36457C0.12429 9.13143 0.000861576 8.84324 4.43349e-06 8.5C-0.000852709 8.15676 0.122576 7.86857 0.37029 7.63543C0.618004 7.40229 0.923147 7.28571 1.28572 7.28571H7.71429V1.21429C7.71429 0.870242 7.83772 0.582052 8.08457 0.349718C8.33143 0.117385 8.63657 0.000813711 9 4.18719e-06C9.36343 -0.000805336 9.669 0.115766 9.91671 0.349718C10.1644 0.583671 10.2874 0.871861 10.2857 1.21429V7.28571H16.7143C17.0786 7.28571 17.3841 7.40229 17.631 7.63543C17.8779 7.86857 18.0009 8.15676 18 8.5C17.9991 8.84324 17.8757 9.13183 17.6297 9.36579C17.3837 9.59974 17.0786 9.71591 16.7143 9.71429H10.2857V15.7857C10.2857 16.1298 10.1623 16.4184 9.91543 16.6515C9.66857 16.8846 9.36343 17.0008 9 17C8.63657 16.9992 8.33143 16.8826 8.08457 16.6503C7.83772 16.4179 7.71429 16.1298 7.71429 15.7857V9.71429Z"/>
        </svg>';
    }
    public static function search(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 24 24">
            <path  d="M9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l5.6 5.6q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-5.6-5.6q-.75.6-1.725.95T9.5 16m0-2q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
        </svg>';
    }
    public static function dotMenu(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 30 6">
            <path d="M22.4 3C22.4 2.20435 22.695 1.44129 23.2201 0.87868C23.7452 0.31607 24.4574 0 25.2 0C25.9426 0 26.6548 0.31607 27.1799 0.87868C27.705 1.44129 28 2.20435 28 3C28 3.79565 27.705 4.55871 27.1799 5.12132C26.6548 5.68393 25.9426 6 25.2 6C24.4574 6 23.7452 5.68393 23.2201 5.12132C22.695 4.55871 22.4 3.79565 22.4 3ZM11.2 3C11.2 2.20435 11.495 1.44129 12.0201 0.87868C12.5452 0.31607 13.2574 0 14 0C14.7426 0 15.4548 0.31607 15.9799 0.87868C16.505 1.44129 16.8 2.20435 16.8 3C16.8 3.79565 16.505 4.55871 15.9799 5.12132C15.4548 5.68393 14.7426 6 14 6C13.2574 6 12.5452 5.68393 12.0201 5.12132C11.495 4.55871 11.2 3.79565 11.2 3ZM0 3C0 2.20435 0.294999 1.44129 0.820101 0.87868C1.3452 0.31607 2.05739 0 2.8 0C3.54261 0 4.2548 0.31607 4.7799 0.87868C5.305 1.44129 5.6 2.20435 5.6 3C5.6 3.79565 5.305 4.55871 4.7799 5.12132C4.2548 5.68393 3.54261 6 2.8 6C2.05739 6 1.3452 5.68393 0.820101 5.12132C0.294999 4.55871 0 3.79565 0 3Z"/>        
        </svg>';
    }
    public static function arrowLeft(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 24 24">
            <path d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z"/>
        </svg>';
    }
    public static function eye(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 24 24">
                <path  d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
        </svg>';
    }
    public static function pencil(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg
        xmlns="http://www.w3.org/2000/svg" 
        fill="currentColor"
        class="' . htmlspecialchars($class) . '"
        fill="none"
        viewBox="0 0 24 24">
            <path fill="currentColor" d="M5 3c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7h-2v7H5V5h7V3zm12.78 1a.7.7 0 0 0-.48.2l-1.22 1.21l2.5 2.5L19.8 6.7c.26-.26.26-.7 0-.95L18.25 4.2c-.13-.13-.3-.2-.47-.2m-2.41 2.12L8 13.5V16h2.5l7.37-7.38z"/>
        </svg>';
    }
    public static function trash(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 24 24">
            <path fill="currentColor" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"/>
            </svg>';
    }
    public static function lock(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor"
            class="' . htmlspecialchars($class) . '"
            fill="none"
            viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 17a2 2 0 0 1-2-2c0-1.11.89-2 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2m6 3V10H6v10zm0-12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10c0-1.11.89-2 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3"/>
            </svg>';
    }
    public static function calendar_pencil(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                fill="none"
                viewBox="0 0 24 24">
                <path  d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V3q0-.425.288-.712T7 2t.713.288T8 3v1h8V3q0-.425.288-.712T17 2t.713.288T18 3v1h1q.825 0 1.413.588T21 6v4.025q0 .425-.288.713t-.712.287t-.712-.288t-.288-.712V10H5v10h6q.425 0 .713.288T12 21t-.288.713T11 22zm9-1v-1.65q0-.2.075-.387t.225-.338l5.225-5.2q.225-.225.5-.325t.55-.1q.3 0 .575.113t.5.337l.925.925q.2.225.313.5t.112.55t-.1.563t-.325.512l-5.2 5.2q-.15.15-.337.225T16.65 22H15q-.425 0-.712-.287T14 21m6.575-4.6l.925-.975l-.925-.925l-.95.95z"/>
            </svg>
            ';
    }
    public static function people(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                fill="none"
                viewBox="0 0 24 24">
                <path fill="currentColor" d="M16.5 12A2.5 2.5 0 0 0 19 9.5A2.5 2.5 0 0 0 16.5 7A2.5 2.5 0 0 0 14 9.5a2.5 2.5 0 0 0 2.5 2.5M9 11a3 3 0 0 0 3-3a3 3 0 0 0-3-3a3 3 0 0 0-3 3a3 3 0 0 0 3 3m7.5 3c-1.83 0-5.5.92-5.5 2.75V19h11v-2.25c0-1.83-3.67-2.75-5.5-2.75M9 13c-2.33 0-7 1.17-7 3.5V19h7v-2.25c0-.85.33-2.34 2.37-3.47C10.5 13.1 9.66 13 9 13"/>
                </svg>
            ';
    }
    public static function location(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                fill="none"
                viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7"/>
            </svg>
            ';
    }
    public static function file(string $class = 'w-6 h-6 text-gray-700'): void
    {
        echo '<svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="currentColor"
                class="' . htmlspecialchars($class) . '"
                fill="none"
                viewBox="0 0 24 24">
                <path fill="currentColor" d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm0 2h7v5h5v11H6zm2 8v2h8v-2zm0 4v2h5v-2z"/>
            </svg>
            ';
    }
}
