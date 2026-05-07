<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\BookingRepository;

final class BookingService
{
    public function __construct(private BookingRepository $bookings)
    {
    }

    public function create(array $input): array
    {
        $name = trim((string)($input['name'] ?? ''));
        $email = trim((string)($input['email'] ?? ''));
        $phone = trim((string)($input['phone'] ?? ''));
        $package = trim((string)($input['package'] ?? ''));
        $date = trim((string)($input['date'] ?? ''));
        $people = max(1, (int)($input['people'] ?? 1));
        $message = trim((string)($input['message'] ?? ''));

        if ($name === '' || $email === '' || $phone === '' || $package === '' || $date === '') {
            return ['success' => false, 'message' => 'Please complete all required booking fields.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }

        $this->bookings->saveBooking([
            'id' => uniqid('bk_', true),
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'package' => $package,
            'date' => $date,
            'people' => $people,
            'message' => $message,
            'created_at' => date('c'),
        ]);

        return ['success' => true, 'message' => 'Booking submitted successfully. Our concierge will contact you shortly.'];
    }
}
