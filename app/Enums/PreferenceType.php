<?php

namespace App\Enums;

enum PreferenceType: string
{
    case Text = 'text';
    case TextContent = 'text_content';
    case TextContentVideo = 'text_content_video';
    case TextContentImage = 'text_content_image';
    case TextImage = 'text_image';
    case Image = 'image';
    case FileJson = 'file_json';
    case Table = 'table';
    case TextFile = 'text_file';


    public function word()
    {
        return match ($this->value) {
            default => ucwords(str_replace('_', ' ', $this->value))
        };
    }
}
