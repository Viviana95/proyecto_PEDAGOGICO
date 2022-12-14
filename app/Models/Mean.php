<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mean extends Model
{
    use HasFactory;
    protected $fillable = ['title','image', 'file', 'language_id'];
    
    public function users(){
        return $this->belongsToMany(User::class);        
    }

    public function formats(){
        return $this->belongsToMany(Format::class);
    }
    public function languages(){
        return $this->belongsTo(Language::class);
    }
}
