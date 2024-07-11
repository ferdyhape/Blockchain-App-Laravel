<?php

namespace App\Http\Requests\User;

use App\Services\ProjectService;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxWithdraw = ProjectService::getProjectById($this->route('id'))->campaign->wallet->balance;
        return [
            "payment_method_detail_id" => "required|uuid|exists:payment_method_details,id",
            "amount" => "required|numeric|min:100000|max:$maxWithdraw",
        ];
    }
}
