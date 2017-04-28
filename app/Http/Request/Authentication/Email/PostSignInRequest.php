<?php
declare(strict_types=1);

namespace App\Http\Request\Authentication\Email;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostSignInRequest
 * @package App\Http\Request\Authentication\Email
 */
class PostSignInRequest extends FormRequest
{
    /**
     * @var string
     */
    protected $redirectRoute = 'auth.get.sign_in';
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => ['required', 'regex:/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,100}+\z/i'],
        ];
    }
    
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
