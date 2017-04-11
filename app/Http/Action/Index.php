<?php
declare(strict_types=1);

namespace App\Http\Action;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

/**
 * Class Index
 * @package App\Http\Action
 */
class Index extends Controller
{
    /**
     * @return View
     */
    public function __invoke(): View
    {
        return view('welcome');
    }
}
