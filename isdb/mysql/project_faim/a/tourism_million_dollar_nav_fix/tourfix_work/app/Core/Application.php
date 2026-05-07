<?php
declare(strict_types=1);

namespace App\Core;

use App\Repositories\BookingRepository;
use App\Repositories\PackageRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\BookingService;
use App\Services\CsrfService;
use App\Services\ImageUploadService;

final class Application
{
    private PackageRepository $packages;
    private UserRepository $users;
    private BookingRepository $bookings;
    private AuthService $auth;
    private BookingService $bookingService;
    private ImageUploadService $uploader;

    public function __construct(private string $basePath)
    {
        $this->packages = new PackageRepository($basePath . '/data/packages.json');
        $this->users = new UserRepository($basePath . '/data/users.json');
        $this->bookings = new BookingRepository($basePath . '/data/bookings.json');
        $this->auth = new AuthService($this->users);
        $this->bookingService = new BookingService($this->bookings);
        $this->uploader = new ImageUploadService($basePath . '/uploads');

        $this->seedAdmin();
    }

    public function packages(): PackageRepository { return $this->packages; }
    public function users(): UserRepository { return $this->users; }
    public function bookings(): BookingRepository { return $this->bookings; }
    public function auth(): AuthService { return $this->auth; }
    public function bookingService(): BookingService { return $this->bookingService; }
    public function uploader(): ImageUploadService { return $this->uploader; }
    public function csrf(): string { return CsrfService::token(); }

    private function seedAdmin(): void
    {
        if (!$this->users->findByEmail('admin@demo.com')) {
            $this->users->saveUser([
                'id' => uniqid('usr_', true),
                'name' => 'Demo Admin',
                'email' => 'admin@demo.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('c'),
            ]);
        }
    }
}
