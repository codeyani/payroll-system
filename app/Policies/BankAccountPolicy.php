<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BankAccount;

class BankAccountPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can view their own bank account details.
     */
    public function viewBankAccount(User $user)
    {
        return $user->hasPermissionTo('view bank account');
    }

    /**
     * Determine if the user can create a bank account.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create bank account');
    }
}
