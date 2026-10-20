<?php

namespace App\Enums;

enum TopicType: string
{
    case Whistleblowing = 'whistleblowing';
    case ContactUs = 'contact_us';

    public function word()
    {
        return match ($this->value) {
            'whistleblowing' => 'Whistleblowing',
            'contact_us' => 'Contact Us'
        };
    }
}
