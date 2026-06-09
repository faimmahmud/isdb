<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Abstracts\JsonRepository;

class BookingRepository extends JsonRepository
{
    public function recent(int $limit = 10): array
    {
        return array_slice(array_reverse($this->all()), 0, max(1, $limit));
    }

    public function saveBooking(array $booking): bool
    {
        if (empty($booking['id'])) {
            $booking['id'] = uniqid('bk_', true);
        }

        return $this->upsert($booking);
    }
}
