<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_user_id' => 'required|numeric',
            'receiver_user_id' => 'required|numeric',
            'transferred_value' => 'required|numeric|min:1|max:99999999.99',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sender_user_id.required' => 'Sender user id is required!',
            'receiver_user_id.required' => 'Receiver user id is required!',
            'transferred_value.required' => 'Value to transfer is required',
        ];
    }

}
