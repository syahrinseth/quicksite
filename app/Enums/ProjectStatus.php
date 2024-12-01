<?php

namespace App\Enums;

enum ProjectStatus : string 
{
    case Draft = "draft";
    case Pending = "pending";
    case Active = 'active';
    case Completed = "completed";
}