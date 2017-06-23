<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersImageTable
 */
class CreateUsersImageTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'users_image';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->string('user_id', 50)->unique();
            $table->integer('image_id')->unsigned();
    
            $table->index(['user_id', 'image_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('image_id')->references('image_id')->on('images');
        });
    }
}
