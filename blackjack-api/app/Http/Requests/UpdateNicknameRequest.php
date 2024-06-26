<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateNicknameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // FOR NOW, THIS IS BEING HANDLED IN THE USER POLICY.
        // // Get the authenticated user.
        // $authUser = $this->user();

        // // Get the UUID from the route parameters.
        // $id = $this->route('id');

        // // If the authenticated user's UUID does not match the UUID in the route parameters, throw an exception.
        // if ($authUser->uuid !== $id) {
        //     throw new AuthorizationException('Your UUID does not match the UUID in the request.');
        // }

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
            'nickname' => [
                function ($attribute, $value, $fail) {
                    // If the nickname is not provided, set it to 'Anonymous'.
                    $value = $value ?? 'Anonymous';
                    // Get the UUID from the route.
                    $uuid = $this->route('id');
                    // Find the user by its UUID.
                    $user = User::where('uuid', $uuid)->first();
                    // If the user does not exist, return an error.
                    if (!$user) {
                        $fail('User not found with the UUID provided.');
                    }
                    // If the nickname is not 'Anonymous' and it already exists in another user with different UUID, return an error.
                    else if ($value !== 'Anonymous' && User::where('nickname', $value)->where('uuid', '<>', $user->uuid)->exists()) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
        ];
    }
}
