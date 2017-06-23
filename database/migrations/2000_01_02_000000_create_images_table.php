<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateImagesTable
 */
class CreateImagesTable extends Migration
{
    use Helper;
    
    /** @var string */
    protected $table = 'images';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchemeBuilder()->create($this->table, function (Blueprint $table) {
            $table->increments('image_id');
            $table->string('path');
            $table->string('filename');
            $table->string('ext');
            $table->dateTime('created_at');
        });
    }
}
