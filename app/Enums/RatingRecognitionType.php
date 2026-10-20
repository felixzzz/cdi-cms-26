<?php

namespace App\Enums;

enum RatingRecognitionType: string
{
    case Rating = 'rating';
    case Recognition = 'recognition';

    public function word()
    {
        return match ($this->value) {
            'rating' => 'Rating',
            'recognition' => 'Recognition'
        };
    }
}
