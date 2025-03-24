<?php

namespace App\Http\Requests;

use App\Enums\DirectionType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class UpdateRouteRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'directions' => 'sometimes|array|min:1|max:2',
            'directions.*.direction' => new Enum(DirectionType::class),
            'directions.*.stops' => 'sometimes|array|min:2',
            'directions.*.stops.*' => 'sometimes|exists:stops,id'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Название маршрута должно быть строкой',
            'name.max' => 'Название маршрута не должно превышать 255 символов',
            'directions.array' => 'Направления должны быть представлены в виде массива',
            'directions.min' => 'Должно быть указано минимум одно направление',
            'directions.max' => 'Можно указать максимум два направления',
            'directions.*.stops.array' => 'Остановки должны быть представлены в виде массива',
            'directions.*.stops.min' => 'Должно быть указано минимум две остановки',
            'directions.*.stops.*.exists' => 'Указанная остановка не существует',
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
