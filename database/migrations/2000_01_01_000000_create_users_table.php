<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50)->unique();
            $table->string('name', 255);
            $table->boolean('frozen')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamp('last_login_time');
            $table->timestamps();
    
            $table->primary('user_id');
        });
    }
}
