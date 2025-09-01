<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        if ($user->isAdmin()) {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'priority' => 'required|in:low,medium,high',
                'status' => 'required|in:open,in_progress,closed',
                'agent_id' => 'nullable|exists:users,id',
            ];
        }

        if ($user->isAgent()) {
            return [
                'status' => 'required|in:open,in_progress,closed',
            ];
        }

        if ($user->isUser()) {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'priority' => 'required|in:low,medium,high',
            ];
        }

        return []; 
    }
}