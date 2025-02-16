<?php

namespace App\Services;

use App\Models\BankChangeRequest;
use App\Services\Interfaces\BankChangeRequestServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BankChangeRequestService implements BankChangeRequestServiceInterface
{
    /**
     * Retrieve all pending bank change requests.
     *
     * @return Collection
     */
    public function getPendingRequests(): Collection
    {
        return BankChangeRequest::where('status', 'Pending')->get();
    }

    /**
     * Create a new bank change request for the authenticated user.
     *
     * @param Request $request
     * @return BankChangeRequest
     */
    public function createRequest(Request $request): BankChangeRequest
    {
        try {
            $validated = $request->validate([
                'new_bank_name' => 'required|string|max:255',
                'new_account_no' => 'required|string|max:255',
                'reason' => 'required|string',
            ]);

            return BankChangeRequest::create([
                'employee_id' => Auth::id(),
                'old_bank_name' => Auth::user()->bankAccount->bank_name,
                'new_bank_name' => $validated['new_bank_name'],
                'old_account_no' => Auth::user()->bankAccount->account_number,
                'new_account_no' => $validated['new_account_no'],
                'reason' => $validated['reason'],
                'status' => 'Pending',
            ]);
        } catch (ValidationException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422));
        }
    }

    /**
     * Retrieve all bank change requests submitted by a specific user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserRequests(int $userId): Collection
    {
        return BankChangeRequest::where('employee_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Update a bank change request with new data.
     *
     * @param BankChangeRequest $request
     * @param array $data
     * @return BankChangeRequest
     */
    public function updateRequest(BankChangeRequest $request, array $data): BankChangeRequest
    {
        try {
            $validated = validator($data, [
                'status' => 'required|in:Approved,Rejected',
                'comments' => 'nullable|string',
            ])->validate();

            $request->update($validated);

            return $request;
        } catch (ValidationException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422));
        }
    }
}
