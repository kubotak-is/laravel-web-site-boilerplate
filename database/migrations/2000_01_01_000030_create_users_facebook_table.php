<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersFacebookTable
 */
class CreateUsersFacebookTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_facebook';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50);
            $table->string('facebook_id')->unique();
            $table->string('token', 255);
            $table->timestamps();
    
            $table->index(['user_id', 'facebook_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }
}
