<?php

namespace App\Enums;

enum QuickLinkCategory: int
{
    case Home = 1;
    case Governance = 2;
    case AboutUs = 3;

    public function key()
    {
        return match ($this->value) {
            1 => 'home',
            2 => 'governance',
            3 => 'about_us',
            default => ''
        };
    }

    public function word()
    {
        return match ($this->value) {
            1 => 'Home',
            2 => 'Governance',
            3 => 'About Us'
        };
    }
}
