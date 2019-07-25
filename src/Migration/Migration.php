<?php

namespace App\Migration;

interface Migration
{
    /**
     * @return string SQL
     */
    public function up(): string ;

    /**
     * @return string SQL
     */
    public function down(): string ;
}