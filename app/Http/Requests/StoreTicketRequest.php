<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ];

        if ($this->user()->isAdmin()) {
            $rules['agent_id'] = 'nullable|exists:users,id';
        }

        if ($this->user()->isUser()) {
            $rules['admin_id'] = 'required|exists:users,id';
        }

        return $rules;
    }
}