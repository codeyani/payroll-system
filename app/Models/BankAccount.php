<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'bank_name',
        'account_number',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // Encrypt account numbers before saving
    public function setBankNameAttribute($value)
    {
        $this->attributes['bank_name'] = Crypt::encryptString($value);
    }
    
    // Encrypt account numbers before saving
    public function setAccountNumberAttribute($value)
    {
        $this->attributes['account_number'] = Crypt::encryptString($value);
    }

    // Accessor to decrypt bank_name
    public function getBankNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Accessor to decrypt account_number
    public function getAccountNumberAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
