<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable=[
        'attended_at',
        'member_id'
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
