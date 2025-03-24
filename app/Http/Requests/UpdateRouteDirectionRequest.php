<?php

namespace App\Http\Requests;

use App\Enums\DirectionType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class UpdateRouteDirectionRequest extends FormRequest
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
            'direction' => new Enum(DirectionType::class),
            'name' => 'sometimes|string|max:255',
            'stops' => 'array',
            'stops.*' => 'exists:stops,id'
        ];
    }

    public function messages(): array
    {
        return [
            'direction.in' => 'Тип направления может быть только ПРЯМОЕ или ОБРАТНОЕ',
            'name.string' => 'Название должно быть строкой',
            'stops.array' => 'Остановки должны быть представлены в виде массива',
            'stops.*.exists' => 'Указанная остановка не существует'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => collect($validator->errors())->map(function ($errors, $field) {
                return [
                    'field' => $field,
                    'message' => $errors[0]
                ];
            })->values()->all()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
