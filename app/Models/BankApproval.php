<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankApproval extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'approver_id', 'status', 'comments', 'updated_at'];

    protected $casts = ['status' => 'string'];

    public function request()
    {
        return $this->belongsTo(BankChangeRequest::class, 'request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
