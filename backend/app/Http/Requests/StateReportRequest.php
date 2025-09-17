<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateReportRequest extends FormRequest
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
        return [
			'student_profile_id' => 'required',
			'report_date' => 'required',
			'location' => 'string',
        ];
    }
}
