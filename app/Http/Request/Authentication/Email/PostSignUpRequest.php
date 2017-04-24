<?php
declare(strict_types=1);

namespace App\Http\Request\Authentication\Email;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostSignUpRequest
 * @package App\Http\Request\Authentication\Email
 */
class PostSignUpRequest extends FormRequest
{
    /**
     * @var string
     */
    protected $redirectRoute = 'auth.get.sign_up';
    
    /**
     * @return array
     */
    public function rules(): array
    {
        $database = config('database.default');
        return [
            'name'     => 'required|min:4',
            'email'    => "required|email|unique:{$database}.users_mail",
            'password' => ['required', 'regex:/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,100}+\z/i'],
            'confirm'  => 'required|same:password',
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
