<?php

namespace App\Http\Requests;

use App\Models\ShortLink;
use Illuminate\Foundation\Http\FormRequest;

class ShortLinkRequest extends FormRequest
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
            'original_url' => ['required', 'url', 'max:255'],
            'short_code' => ['required', 'string']
        ];
    }

    protected function prepareForValidation()
    {
        $lastShortLink = ShortLink::latest('id')->first();

        if ($lastShortLink) {
            $parts = explode("/", $lastShortLink->short_code);
            $shortenedCode = end($parts);

            $this->merge(['short_code' => 'site.ru/' . ++$shortenedCode]);
        } else {
            $this->merge(['short_code' => 'site.ru/a']);
        }
    }
}
