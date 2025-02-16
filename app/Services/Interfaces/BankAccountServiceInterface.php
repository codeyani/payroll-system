<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface BankAccountServiceInterface
{
    public function getBankDetails(int $userId);
    public function createBankAccount(Request $request, int $userId);
}
