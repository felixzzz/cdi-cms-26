<?php

namespace App\Enums;

enum TeamType: string
{
    case BOD = 'bod';
    case BOC = 'boc';
    case AUDIT = 'audit';

    public function word()
    {
        return match ($this->value) {
            'bod' => "BOD",
            'boc' => "BOC",
            'audit' => "Audit"
        };
    }
}
