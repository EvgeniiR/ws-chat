<?php
namespace App\Migration;

use App\MigrationsComponent\Migration;

class Version20190723174016730 extends Migration {
    /**
     * @return string SQL
     */
    public function up(): string {
        return <<<'SQL'
CREATE TABLE "messages" (
  "id" SERIAL NOT NULL PRIMARY KEY,
  "username" VARCHAR(100) NOT NULL,
  "message" VARCHAR(2000) NOT NULL,
  "date_time" timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP
)
SQL;
    }
    
    /**
     * @return string SQL
     */
    public function down(): string {
        return <<<'SQL'
DROP TABLE "messages";
SQL;
    }
}
