<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

/**
 * Class GetSignUp
 * @package App\Http\Action\Authentication\Email
 */
class GetSignUp extends Controller
{
    /**
     * @return View
     */
    public function __invoke(): View
    {
        return view('authentication.sign_up');
    }
}
