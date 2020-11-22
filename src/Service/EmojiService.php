<?php


namespace App\Service;


class EmojiService
{
    public static function getRandomEmoji()
    {
        $emojis = ['😍', '🤩', '🤙', '👏', '👌', '😋', '😻', '👍'];
        return $emojis[rand(0,count($emojis)-1)];
    }
}
