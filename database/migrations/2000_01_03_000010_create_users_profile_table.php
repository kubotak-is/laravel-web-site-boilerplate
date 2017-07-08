<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersProfileTable
 */
class CreateUsersProfileTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_profile';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50)->unique();
            $table->text('message');
    
            $table->index('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }
}
