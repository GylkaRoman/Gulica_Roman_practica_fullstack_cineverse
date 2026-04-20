<?php

namespace App\DTO;

class HallDTO
{
    public function __construct(
        public string $name,
        public int $rows_count,
        public int $seats_per_row
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['rows_count'],
            $data['seats_per_row']
        );
    }
}
