<?php

namespace App;

use function PHPUnit\Framework\matches;

enum OrderDetailStatus:string
{
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';

    public function getColor():string
    {
        return match($this){
            self::APPROVED=>'primary',
            self::SUBMITTED=>'success',
            self::REJECTED=>'danger',
        };
    }
}
