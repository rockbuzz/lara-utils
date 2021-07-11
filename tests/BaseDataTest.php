<?php

namespace Tests;

use ErrorException;
use Rockbuzz\LaraUtils\Data\Base;

class BaseDataTest extends TestCase
{
    /** @test */
    public function data_has_get(): void
    {
        $item = [
            'id' => 123,
            'name' => 'Name Test'
        ];

        $data = new class($item) extends Base {

            public function getNameAttribute()
            {
                return 'Sr. ' . $this->item['name'];
            }
        };

        $this->assertEquals(123, $data->id);
        $this->assertEquals('Sr. Name Test', $data->name);

        $this->expectException(ErrorException::class);

        $data->description;
    }
}
