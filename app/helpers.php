<?php
// In your helpers.php or as a separate component
if (!function_exists('emoji_for_type')) {
    function emoji_for_type()
    {
        $emojis = ['🔍', '📌', '🏷️', '💬', '😂', '🎁', '📅', '📋️'];
        return $emojis[array_rand($emojis)];
    }
}
