<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('old_bank_name', 255);
            $table->string('new_bank_name', 255);
            $table->string('old_account_no', 255); // Encrypt this in the model
            $table->string('new_account_no', 255); // Encrypt this in the model
            $table->text('reason');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('bank_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('approver_id');
            $table->enum('status', ['Approved', 'Rejected']);
            $table->text('comments')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('request_id')->references('id')->on('bank_change_requests')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade'); // Assuming HR personnel are users
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_approvals');
        Schema::dropIfExists('bank_change_requests');
    }
};
