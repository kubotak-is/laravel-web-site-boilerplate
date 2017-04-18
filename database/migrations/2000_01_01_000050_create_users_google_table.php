<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersGoogleTable
 */
class CreateUsersGoogleTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_google';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50);
            $table->string('google_id')->unique();
            $table->string('token', 255);
            $table->timestamps();
    
            $table->index(['user_id', 'google_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }
}
