<?php

namespace App\Enums;

enum ValidationStatus: string
{
    case WAITING = 'en attente';
    case VALIDATED = 'validée';
    case REFUSED = 'refusée';
}
