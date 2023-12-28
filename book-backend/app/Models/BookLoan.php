<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookLoan extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['book_id','user_id','loan_date','due_date','return_date','extended','extension_date','penalty_amount','penalty_status','status'];
}
