<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable=['price','resnumber','payment' ,'user_id' , 'course_id'];

    public function scopeSpanningPayment($query , $month , $paymen) {
        $query->selectRaw('monthname(created_at) month , count(*) published')
            ->where('created_at' , '>' , Carbon::now()->subMonth($month))
            ->wherePayment($paymen)
            ->groupBy('month')
            ->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
