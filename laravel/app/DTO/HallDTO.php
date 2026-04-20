<?php

namespace App\DTO;

class HallDTO
{
    public function __construct(
        public string $name,
        public string $rows_count,
        public string $seats_per_row
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
