<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransDetail extends Model
{
    use HasFactory;

    protected $table = 'trans_details';

    protected $guarded = [];

    public function trans()
    {
        return $this->belongsTo(Trans::class, 'trans_id');
    }
}
