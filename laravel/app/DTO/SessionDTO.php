<?php

namespace App\DTO;

class SessionDTO
{
    public function __construct(
        public int $movie_id,
        public int $hall_id,
        public string $date,
        public string $time,
        public string $format,
        public string $language,
        public float $base_price,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['movie_id'],
            $data['hall_id'],
            $data['date'],
            $data['time'],
            $data['format'],
            $data['language'],
            $data['base_price'],
        );
    }
}
