<?php
declare(strict_types=1);

namespace App\Authentication;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Web
 * @package App
 */
class Web extends Authenticatable
{
    use Notifiable;
    
    /**
     * @var string
     */
    protected $table = 'users';
    
    /**
     * @var string
     */
    protected $primaryKey = 'user_id';
    
    /**
     * @var string
     */
    protected $keyType = 'string';
}
