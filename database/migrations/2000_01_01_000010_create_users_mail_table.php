<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersMailTable
 */
class CreateUsersMailTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_mail';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50);
            $table->string('email', 255);
            $table->string('password', 255)->unique();
            $table->timestamps();
    
            $table->index(['user_id', 'email']);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }
}
