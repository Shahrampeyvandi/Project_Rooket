<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Episode extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function path()
    {
        return "/courses/{$this->course->slug}/episode/{$this->number}";
    }
    // ---- video download ----
    public function download()
    {
         if (!auth()->check()) return "#";
        $status = false;
         switch ($this->type){
             case 'free':
                 $status = true;
                 break;
             case 'vip':
                 if (auth()->user()->isActive())  $status = true;
                 break;
             case 'cach':
                 if (auth()->user()->checkLearning($this->course))   $status = true;
                 break;
         }
         $timestamp = \Carbon\Carbon::now()->addHours(5)->timestamp;
         $hash= Hash::make('DJSKFksd@i$f#&*ocndx' . $this->id . request()->ip() . $timestamp);


      return $status ? "/download/$this->id?mac=$hash&t=$timestamp" : "#";
    }
}
