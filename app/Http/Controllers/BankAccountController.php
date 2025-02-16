<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;
use App\Services\Interfaces\BankAccountServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BankAccountController extends Controller
{
    private BankAccountServiceInterface $bankAccountService;

    /**
     * Constructor to initialize the bank account service.
     *
     * @param BankAccountServiceInterface $bankAccountService
     */
    public function __construct(BankAccountServiceInterface $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    /**
     * Fetch the authenticated employee's bank details.
     *
     * @return BankAccountResource|JsonResponse
     */
    public function getBankDetails(): BankAccountResource|JsonResponse
    {
        // Authorize the action using Gates
        Gate::authorize('viewBankAccount', BankAccount::class);
        
        // Retrieve the bank details for the authenticated user
        $bankAccount = $this->bankAccountService->getBankDetails(Auth::id());

        // Return a 404 response if no bank details are found
        if (!$bankAccount) {
            return response()->json(['message' => 'No bank details found'], 404);
        }
        // Return the bank account details as a resource
        return new BankAccountResource($bankAccount);
    }

    /**
     * Store a new bank account for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Authorize the creation of a new bank account
        Gate::authorize('create', BankAccount::class);

        // Create the bank account using the service
        $bankAccount = $this->bankAccountService->createBankAccount($request, Auth::id());

        // Return a success response with the created bank account details
        return response()->json([
            'message' => 'Bank account created successfully!',
            'bank_account' => $bankAccount
        ], 201);
    }
}