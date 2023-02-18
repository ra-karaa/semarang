<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    use HasFactory;

    protected $table = 'trans';

    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(TransDetail::class);
    }
}
