<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTwitterTable
 */
class CreateUsersTwitterTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_twitter';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50);
            $table->string('twitter_id')->unique();
            $table->string('nickname');
            $table->string('token', 255);
            $table->string('token_secret', 255);
            $table->timestamps();
    
            $table->index(['user_id', 'twitter_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }
}
