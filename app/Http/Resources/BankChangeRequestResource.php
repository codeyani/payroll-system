<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankChangeRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'old_bank_name' => $this->old_bank_name,
            'new_bank_name' => $this->new_bank_name,
            'old_account_no' => $this->maskAccountNumber($this->old_account_no),
            'new_account_no' => $this->maskAccountNumber($this->new_account_no),
            'employee_id' => $this->employee_id,
            'reason' => $this->reason,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
