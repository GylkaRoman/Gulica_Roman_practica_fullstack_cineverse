<?php

namespace App\DTO;

use App\Enums\SessionFormat;
use App\Enums\SessionLanguage;

class SessionDTO
{
    public function __construct(
        public int $movie_id,
        public int $hall_id,
        public string $date,
        public string $time,
        public SessionFormat $format,
        public SessionLanguage $language,
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
