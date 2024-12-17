<?php

namespace App\Enums;

abstract class AttributeProperties{
    CONST is_show_on_upload = 1;
    CONST color = 2;
    CONST print_side = 3;
    CONST show_attr_label = 4;

    public static function getNames()
    {
        return [
            self::is_show_on_upload => 'Show On Upload',
            self::color => 'Is Color',
            self::print_side => 'Is Print Side',
            self::show_attr_label => 'Show attribute name (for open list)',
        ];
    }

}