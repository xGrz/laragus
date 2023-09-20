<?php

namespace xGrz\LaraGus\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SearchGusDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this
            ->merge([
                'nip' => preg_replace('/[^0-9]/', '', $this->vat_id)
            ]);

    }

    /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->status(Response::HTTP_FORBIDDEN);
    }

    public function rules(): array
    {
        return [
            'vat_id' => ['required', 'digits:10']
        ];
    }
}
