<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BankChangeRequest;

class BankChangeRequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can view their own bank change requests.
     */
    public function viewOwnRequests(User $user)
    {
        return $user->hasPermissionTo('submit bank change request');
    }

    /**
     * Determine if the user can view a specific bank change request.
     */
    public function viewSpecificRequest(User $user, BankChangeRequest $bankChangeRequest)
    {
        return $user->id === $bankChangeRequest->employee_id || $user->hasRole('HR');
    }

    /**
     * Determine if the user can view all bank change requests (HR only).
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view bank change request');
    }

    /**
     * Determine if the user can submit a bank change request (Employee only).
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('submit bank change request');
    }

    /**
     * Determine if the HR can approve/reject a bank change request.
     */
    public function update(User $user, BankChangeRequest $bankChangeRequest)
    {
        return $user->hasPermissionTo('approve bank change request') || 
               $user->hasPermissionTo('reject bank change request');
    }
}
