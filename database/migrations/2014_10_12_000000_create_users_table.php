<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Personal Info
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName');
            $table->enum('suffix_name', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('email')->unique();
            $table->string('contactNum')->unique();
            $table->enum('applicationType', ['SHS', 'ALS', 'OLD', 'TRANSFER']);
            $table->enum('gender', ['male', 'female']);
            
            // Other Information
            $table->string('maidenName')->nullable();
            $table->date('birthDate');
            $table->string('birthPlace');
            $table->string('address');
            $table->string('region');
            $table->string('city');
            $table->string('barangay');
            $table->string('zip');

            // Father Information
            $table->string('fatherLast');
            $table->string('fatherFirst');
            $table->string('fatherMiddle');
            $table->enum('fatherSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('fatherAddress');
            $table->string('fatherContact');
            $table->string('fatherJob');
            $table->string('fatherIncome');

            // Mother Information
            $table->string('motherLast');
            $table->string('motherFirst');
            $table->string('motherMiddle');
            $table->enum('motherSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('motherAddress');
            $table->string('motherContact');
            $table->string('motherJob');
            $table->string('motherIncome');

            // Guardian Information
            $table->string('guardianLast');
            $table->string('guardianFirst');
            $table->string('guardianMiddle');
            $table->enum('guardianSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('guardianAddress');
            $table->string('guardianContact');
            $table->string('guardianJob');
            $table->string('guardianIncome');

            // School Information
            $table->string('lrn');
            $table->string('school');
            $table->string('schoolEmail');
            $table->enum('schoolType', ['public', 'private']);
            $table->enum('strand', ['ABM', 'HUMSS', 'STEM', 'GAS' , 'TVL', 'SPORTS' , 'ADT', 'PBM']);
            $table->string('gwa');

            // Program Choices
            $table->string('choice1');
            $table->string('choice2');
            $table->string('choice3');

            //Documents
            $table->binary('birthCert');
            $table->binary('form137');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
