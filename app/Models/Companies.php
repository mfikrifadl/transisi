<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $guarded = [
        'id'
    ];

    public function employees()
    {
        return $this->hasMany('App\Models\Employees', 'company_d', 'id');
    }
}
