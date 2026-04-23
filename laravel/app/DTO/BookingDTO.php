<?php

namespace App\DTO;

class BookingDTO
{
    public function __construct(
        public int $userId,
        public int $sessionId,
        public array $seatIds,
    ) {}

    public static function fromArray(array $data, int $userId): self
    {
        return new self(
            userId : $userId,
            sessionId : $data['session_Id'],
            seatIds: $data['seat_Ids'],
        );
    }
}
