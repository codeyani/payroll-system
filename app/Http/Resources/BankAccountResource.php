<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bank_name' => $this->bank_name,
            'account_number' => $this->maskAccountNumber($this->account_number),
        ];
    }

    /**
     * Mask account number, showing only the last 4 digits.
     */
    private function maskAccountNumber($accountNumber)
    {
        return str_repeat('*', max(0, strlen($accountNumber) - 4)) . substr($accountNumber, -4);
    }
}
