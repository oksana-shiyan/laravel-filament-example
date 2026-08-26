<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->convertColumnToJsonTranslations('categories', 'name');
        $this->convertColumnToJsonTranslations('products', 'name');
        $this->convertColumnToJsonTranslations('products', 'description', nullable: true);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->convertJsonTranslationsToString('categories', 'name');
        $this->convertJsonTranslationsToString('products', 'name');
        $this->convertJsonTranslationsToString('products', 'description', nullable: true, text: true);
    }

    private function convertColumnToJsonTranslations(string $table, string $column, bool $nullable = false): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            if ($nullable) {
                DB::statement("ALTER TABLE {$table} ALTER COLUMN {$column} TYPE jsonb USING CASE WHEN {$column} IS NULL THEN NULL ELSE jsonb_build_object('en', {$column}) END");
            } else {
                DB::statement("ALTER TABLE {$table} ALTER COLUMN {$column} TYPE jsonb USING jsonb_build_object('en', {$column})");
            }

            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($column): void {
            $blueprint->json("{$column}_translations")->nullable();
        });

        foreach (DB::table($table)->select(['id', $column])->get() as $row) {
            $value = $row->{$column};

            if ($value === null) {
                continue;
            }

            $decoded = json_decode((string) $value, true);
            $payload = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
                ? $decoded
                : ['en' => $value];

            DB::table($table)->where('id', $row->id)->update([
                "{$column}_translations" => json_encode($payload, JSON_UNESCAPED_UNICODE),
            ]);
        }

        Schema::table($table, function (Blueprint $blueprint) use ($column): void {
            $blueprint->dropColumn($column);
        });

        Schema::table($table, function (Blueprint $blueprint) use ($column): void {
            $blueprint->renameColumn("{$column}_translations", $column);
        });
    }

    private function convertJsonTranslationsToString(string $table, string $column, bool $nullable = false, bool $text = false): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            $targetType = $text ? 'text' : 'varchar(255)';
            DB::statement("ALTER TABLE {$table} ALTER COLUMN {$column} TYPE {$targetType} USING COALESCE({$column}->>'en', {$column}::text)");

            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($column, $nullable, $text): void {
            if ($text) {
                $blueprint->text("{$column}_plain")->nullable($nullable);
            } else {
                $blueprint->string("{$column}_plain")->nullable($nullable);
            }
        });

        foreach (DB::table($table)->select(['id', $column])->get() as $row) {
            $value = $row->{$column};
            $decoded = is_string($value) ? json_decode($value, true) : null;
            $plain = is_array($decoded) ? ($decoded['en'] ?? reset($decoded) ?: null) : $value;

            DB::table($table)->where('id', $row->id)->update([
                "{$column}_plain" => $plain,
            ]);
        }

        Schema::table($table, function (Blueprint $blueprint) use ($column): void {
            $blueprint->dropColumn($column);
        });

        Schema::table($table, function (Blueprint $blueprint) use ($column): void {
            $blueprint->renameColumn("{$column}_plain", $column);
        });
    }
};
