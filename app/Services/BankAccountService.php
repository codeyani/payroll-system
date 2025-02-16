<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Services\Interfaces\BankAccountServiceInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BankAccountService implements BankAccountServiceInterface
{
    /**
     * Retrieve the bank details of a specific user.
     *
     * @param int $userId
     * @return BankAccount|null
     */
    public function getBankDetails(int $userId): ?BankAccount
    {
        return BankAccount::where('employee_id', $userId)->first();
    }

    /**
     * Create a new bank account for a user.
     *
     * @param Request $request
     * @param int $userId
     * @return BankAccount|JsonResponse
     */
    public function createBankAccount(Request $request, int $userId): BankAccount|JsonResponse
    {
        try {
            // Validate the request input
            $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_number' => 'required|string|unique:bank_accounts,account_number',
            ]);

            // Create and return the new bank account
            return BankAccount::create([
                'employee_id' => $userId,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_no,
            ]);
        } catch (ValidationException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422));
        }
    }
}
