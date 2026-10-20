<?php

namespace App\Enums;

enum SustainabilityReportType: String
{
    case Report = 'report';
    case Publication = 'publication';

    public function word()
    {
        return match ($this->value) {
            'report' => 'Report',
            'publication' => 'Publication'
        };
    }
}
