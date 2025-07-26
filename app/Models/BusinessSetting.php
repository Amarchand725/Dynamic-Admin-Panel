<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasModelLogObserver;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
}
