<?php

namespace App\Models;

use App\Traits\HasModelLogObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, SoftDeletes, HasModelLogObserver;

    protected $guarded = [];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
