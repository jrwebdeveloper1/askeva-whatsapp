<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskevaWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('askeva_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('message_id', 255);
            $table->string('from_wa_id', 20);
            $table->string('from_name', 255)->nullable();
            $table->string('business_phone_number_id', 50);
            $table->string('display_phone_number', 20)->nullable();
            $table->text('body');
            $table->json('raw_payload');
            $table->timestamp('received_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('askeva_webhooks');
    }
}
