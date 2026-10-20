<?php

namespace App\Enums\Sustainability;

enum ContentType: string
{
    case Content = 'content';
    case Grid = 'grid';
    case SimpleTextInformation = 'simple_text_information';
    case FileInformation = 'file_information';
    case ListInformation = 'list_information';
    case Swiper = 'swiper';

    public function word()
    {
        return match ($this->value) {
            'content' => 'Content',
            'grid' => 'Grid',
            'simple_text_information' => 'Simple Text Information',
            'file_information' => 'File Information',
            'list_information' => 'List Information',
            'swiper' => 'Swiper',
        };
    }
}
