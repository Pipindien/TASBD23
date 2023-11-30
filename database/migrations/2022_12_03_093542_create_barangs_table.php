<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Store;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant', function (Blueprint $table) {
            $table->id('id_tenant');
            $table->string('nama_stand');
            $table->integer('harga_sewa');
            $table->integer('stock');
            $table->foreignIdFor(Gudang::class,'id_lokasi');
            $table->foreignIdFor(Store::class,'id_jenis');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant');
    }
};
