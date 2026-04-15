<?php

if (!function_exists('format_price')) {
    function format_price(int $price): string
    {
        if ($price >= 1_000_000) {
            return number_format($price / 1_000_000, 1, '.', '') . ' млн ₽';
        }
        return number_format($price, 0, '.', ' ') . ' ₽';
    }
}
