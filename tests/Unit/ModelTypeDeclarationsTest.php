<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ModelTypeDeclarationsTest extends TestCase
{
    public function test_eloquent_scopes_declare_builder_parameter_and_return_types(): void
    {
        foreach ($this->modelFiles() as $file) {
            $contents = file_get_contents($file);

            preg_match_all('/public function scope\w+\(([^)]*)\)([^\{]*)\{/', $contents, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $this->assertStringContainsString('Builder $query', $match[1], $file);
                $this->assertStringContainsString(': Builder', $match[2], $file);
            }
        }
    }

    public function test_eloquent_relationships_declare_return_types(): void
    {
        foreach ($this->modelFiles() as $file) {
            $contents = file_get_contents($file);

            preg_match_all(
                '/public function \w+\([^)]*\)([^\{]*)\{\s*return \$this->(hasOne|hasMany|belongsToMany|morphTo)\(/',
                $contents,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
                $expectedType = match ($match[2]) {
                    'hasOne' => 'HasOne',
                    'hasMany' => 'HasMany',
                    'belongsToMany' => 'BelongsToMany',
                    'morphTo' => 'MorphTo',
                };

                $this->assertStringContainsString(': ' . $expectedType, $match[1], $file);
            }
        }
    }

    private function modelFiles(): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(__DIR__ . '/../../app/Models')
        );
        $files = [];

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
