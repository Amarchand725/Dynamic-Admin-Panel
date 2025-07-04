<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasModelLogObserver;

class BaseModel extends Model
{
    use HasFactory, HasModelLogObserver;
}
