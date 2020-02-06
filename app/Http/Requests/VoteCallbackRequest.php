<?php

namespace App\Http\Requests;

use App\VoteProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VoteCallbackRequest extends FormRequest
{
    public $voteProvider;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            $this->voteProvider->callback_user_name => ['required', 'string', 'max:255'],
            $this->voteProvider->callback_success_name => ['required', 'string', 'max:255'],
        ];
    }

    public function authorize()
    {
        $this->voteProvider = VoteProvider::firstWhere('callback_secret', $this->route('voteprovider_secret'))->enabled();

        return $this->voteProvider;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
