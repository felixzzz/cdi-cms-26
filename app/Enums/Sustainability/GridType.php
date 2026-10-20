<?php

namespace App\Enums\Sustainability;

enum GridType: string
{
    case IconContentCard = 'icon_content_card';
    case IconListCard = 'icon_list_card';
    case BoxIconCard = 'box_icon_card';
    case ImageContentCard = 'image_content_card';
    case default = '';

    public function word()
    {
        return match ($this->value) {
            'icon_content_card' => 'Icon Content Card',
            'icon_list_card' => 'Icon List Card',
            'box_icon_card' => 'Box Icon Card',
            'image_content_card' => 'Image Content Card',
        };
    }
}
