<?php

namespace App\Services\Interfaces;

use App\Models\BankChangeRequest;
use Illuminate\Http\Request;

interface BankChangeRequestServiceInterface
{
    public function getPendingRequests();
    public function createRequest(Request $request);
    public function getUserRequests(int $userId);
    public function updateRequest(BankChangeRequest $request, array $data);
}
