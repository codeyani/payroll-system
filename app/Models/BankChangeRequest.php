<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BankChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'old_bank_name',
        'new_bank_name',
        'old_account_no',
        'new_account_no',
        'reason',
        'status',
        'submitted_at',
    ];

    protected $dates = ['submitted_at'];

    protected $casts = ['status' => 'string'];

    // Encrypt bank name before saving
    public function setOldBankNameAttribute($value)
    {
        $this->attributes['old_bank_name'] = Crypt::encryptString($value);
    }

    public function setNewBankNameAttribute($value)
    {
        $this->attributes['new_bank_name'] = Crypt::encryptString($value);
    }

    // Encrypt account numbers before saving
    public function setOldAccountNoAttribute($value)
    {
        $this->attributes['old_account_no'] = Crypt::encryptString($value);
    }

    public function setNewAccountNoAttribute($value)
    {
        $this->attributes['new_account_no'] = Crypt::encryptString($value);
    }

    // Decrypt when retrieving
    public function getOldBankNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getNewBankNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Decrypt when retrieving
    public function getOldAccountNoAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getNewAccountNoAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function approvals()
    {
        return $this->hasMany(BankApproval::class, 'request_id');
    }
}