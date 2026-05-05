<?php

namespace App\Repositories\Impl;

use App\DTO\SessionDTO;
use App\Models\MovieSession;
use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Support\Facades\Session as FacadesSession;

class SessionRepository implements SessionRepositoryInterface
{
    public function create(array $data)
    {
        return MovieSession::create($data);
    }

    public function findById(int $id)
    {
        return MovieSession::findOrFail($id);
    }

    public function update($session, array $data)
    {
        $session->update($data);
        return $session;
    }

    public function delete($session)
    {
        return $session->delete();
    }

    public function getAll(int $perPage, ?string $date = null)
    {
        $query = MovieSession::with(['movie', 'hall'])
        ->latest()
        ->cursorPaginate($perPage);

        if ($date) {
            $query = MovieSession::with(['movie', 'hall'])
            ->whereDate('date', $date)
            ->latest()
            ->cursorPaginate($perPage);
        }
        return $query;
    }

    public function getSeats(int $id)
    {
        return MovieSession::with(['hall.seats'])->findOrFail($id);
    }
}
