<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../db.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_root(): string
{
    return str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/') ? '../' : '';
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'admin';
}

function require_admin(): void
{
    if (!is_admin()) {
        header('Location: ../login.php');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function fallback_destinations(): array
{
    return [
        [
            'id' => 1,
            'title' => 'Maldives Overwater Sanctuaries',
            'country' => 'Maldives',
            'category' => 'island',
            'summary' => 'Private reef villas, glass lagoons, and moonlit dining above the Indian Ocean.',
            'image' => 'assets/images/destinations/maldives.webp',
        ],
        [
            'id' => 2,
            'title' => 'Swiss Alpine Grand Tour',
            'country' => 'Switzerland',
            'category' => 'mountain',
            'summary' => 'Helicopter transfers, glacier rail journeys, and quiet chalets above blue valleys.',
            'image' => 'assets/images/destinations/swiss-alps.webp',
        ],
        [
            'id' => 3,
            'title' => 'Dubai Future Coast',
            'country' => 'United Arab Emirates',
            'category' => 'city',
            'summary' => 'A polished skyline escape with desert dinners, yacht lounges, and private shopping.',
            'image' => 'assets/images/destinations/dubai.webp',
        ],
        [
            'id' => 4,
            'title' => 'Santorini Blue Hour',
            'country' => 'Greece',
            'category' => 'heritage',
            'summary' => 'Cycladic suites, caldera sailing, and a slow golden descent into the Aegean.',
            'image' => 'assets/images/destinations/santorini.webp',
        ],
        [
            'id' => 5,
            'title' => 'Kyoto Silk Season',
            'country' => 'Japan',
            'category' => 'heritage',
            'summary' => 'Temple gardens, tea rituals, ryokan evenings, and private cultural access.',
            'image' => 'assets/images/destinations/kyoto.webp',
        ],
        [
            'id' => 6,
            'title' => 'Sahara Starlight Convoy',
            'country' => 'Morocco',
            'category' => 'desert',
            'summary' => 'Cinematic dunes, luxury tented camps, and sunrise drives through copper sand.',
            'image' => 'assets/images/destinations/sahara.webp',
        ],
        [
            'id' => 7,
            'title' => 'Bali Rainforest Hideaway',
            'country' => 'Indonesia',
            'category' => 'beach',
            'summary' => 'Clifftop pools, rice terrace mornings, and slow island hospitality.',
            'image' => 'assets/images/destinations/bali.webp',
        ],
        [
            'id' => 8,
            'title' => 'Iceland Aurora Circuit',
            'country' => 'Iceland',
            'category' => 'adventure',
            'summary' => 'Black beaches, ice caves, geothermal retreats, and northern light nights.',
            'image' => 'assets/images/destinations/iceland.webp',
        ],
    ];
}

function fallback_packages(): array
{
    return [
        [
            'id' => 1,
            'title' => 'Maldives Celestial Villa',
            'destination' => 'Maldives',
            'category' => 'island',
            'price' => 4850,
            'rating' => 4.9,
            'duration' => '6 days',
            'description' => 'A private overwater escape with reef snorkeling, champagne sandbank dining, and sunset seaplane arrivals.',
            'highlights' => 'Overwater villa,Private reef guide,Sunset yacht dinner,Spa ritual',
            'image' => 'assets/images/destinations/maldives.webp',
            'status' => 'active',
        ],
        [
            'id' => 2,
            'title' => 'Swiss Alps Signature Route',
            'destination' => 'Switzerland',
            'category' => 'mountain',
            'price' => 6200,
            'rating' => 4.8,
            'duration' => '8 days',
            'description' => 'Glacier rail, helicopter viewpoints, lake hotels, and a private alpine dining program.',
            'highlights' => 'Glacier Express,Private chalet,Heli viewpoint,Michelin dinner',
            'image' => 'assets/images/destinations/swiss-alps.webp',
            'status' => 'active',
        ],
        [
            'id' => 3,
            'title' => 'Dubai Golden Horizon',
            'destination' => 'United Arab Emirates',
            'category' => 'city',
            'price' => 3900,
            'rating' => 4.7,
            'duration' => '5 days',
            'description' => 'A polished city and desert journey with skyline suites, yacht evenings, and private souk styling.',
            'highlights' => 'Skyline suite,Desert supper,Yacht lounge,Private shopping',
            'image' => 'assets/images/destinations/dubai.webp',
            'status' => 'active',
        ],
        [
            'id' => 4,
            'title' => 'Kyoto Private Season',
            'destination' => 'Japan',
            'category' => 'heritage',
            'price' => 5400,
            'rating' => 4.9,
            'duration' => '7 days',
            'description' => 'A quiet cultural itinerary with temple access, ryokan stays, tea ceremony, and chef-led dining.',
            'highlights' => 'Private temples,Ryokan suite,Tea master,Chef table',
            'image' => 'assets/images/destinations/kyoto.webp',
            'status' => 'active',
        ],
        [
            'id' => 5,
            'title' => 'Sahara Nightfall Caravan',
            'destination' => 'Morocco',
            'category' => 'desert',
            'price' => 3150,
            'rating' => 4.8,
            'duration' => '6 days',
            'description' => 'Luxury desert camping, cinematic dune drives, Atlas foothill lodges, and stargazing suppers.',
            'highlights' => 'Tented camp,Dune drive,Atlas lodge,Stargazing',
            'image' => 'assets/images/destinations/sahara.webp',
            'status' => 'active',
        ],
        [
            'id' => 6,
            'title' => 'Iceland Aurora Atelier',
            'destination' => 'Iceland',
            'category' => 'adventure',
            'price' => 5700,
            'rating' => 4.8,
            'duration' => '7 days',
            'description' => 'A northern light journey through black beaches, ice caves, geothermal spas, and volcanic coastlines.',
            'highlights' => 'Aurora chase,Ice cave,Geothermal spa,Black beach',
            'image' => 'assets/images/destinations/iceland.webp',
            'status' => 'active',
        ],
    ];
}

function storage_file(string $name): string
{
    return __DIR__ . '/../storage/' . $name . '.json';
}

function default_storage_data(string $name): array
{
    if ($name === 'destinations') {
        return fallback_destinations();
    }

    if ($name === 'packages') {
        return fallback_packages();
    }

    if ($name === 'users') {
        return [
            [
                'id' => 1,
                'name' => 'Royal Atlas Admin',
                'email' => 'admin@royalatlas.test',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('c'),
            ],
            [
                'id' => 2,
                'name' => 'Demo Traveler',
                'email' => 'traveler@royalatlas.test',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 'customer',
                'created_at' => date('c'),
            ],
        ];
    }

    if ($name === 'bookings') {
        return [];
    }

    return [];
}

function storage_read(string $name): array
{
    $file = storage_file($name);

    if (!is_file($file)) {
        storage_write($name, default_storage_data($name));
    }

    $json = file_get_contents($file);
    $data = json_decode((string) $json, true);

    return is_array($data) ? $data : default_storage_data($name);
}

function storage_write(string $name, array $data): void
{
    $file = storage_file($name);
    $dir = dirname($file);

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($file, $json === false ? '[]' : $json, LOCK_EX);
}

function next_storage_id(array $rows): int
{
    $max = 0;

    foreach ($rows as $row) {
        $max = max($max, (int) ($row['id'] ?? 0));
    }

    return $max + 1;
}

function get_destinations(?string $category = null): array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $sql = 'SELECT * FROM destinations';
        $params = [];

        if ($category) {
            $sql .= ' WHERE category = :category';
            $params['category'] = $category;
        }

        $sql .= ' ORDER BY sort_order ASC, id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        if ($rows) {
            return $rows;
        }
    }

    $rows = storage_read('destinations');

    return array_values(array_filter($rows, static function (array $item) use ($category): bool {
        return !$category || $item['category'] === $category;
    }));
}

function get_packages(array $filters = [], ?int $limit = null): array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $sql = "SELECT * FROM packages WHERE status = 'active'";
        $params = [];

        if (!empty($filters['category'])) {
            $sql .= ' AND category = :category';
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $sql .= ' AND (title LIKE :term OR destination LIKE :term OR description LIKE :term)';
            $params['term'] = '%' . $filters['search'] . '%';
        }

        $sql .= ' ORDER BY rating DESC, id DESC';

        if ($limit !== null) {
            $sql .= ' LIMIT ' . max(1, $limit);
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        if ($rows) {
            return $rows;
        }
    }

    $rows = storage_read('packages');
    $rows = array_values(array_filter($rows, static fn (array $item): bool => ($item['status'] ?? 'active') === 'active'));

    if (!empty($filters['category'])) {
        $rows = array_values(array_filter($rows, static fn (array $item): bool => $item['category'] === $filters['category']));
    }

    if (!empty($filters['search'])) {
        $term = strtolower((string) $filters['search']);
        $rows = array_values(array_filter($rows, static function (array $item) use ($term): bool {
            return str_contains(strtolower($item['title'] . ' ' . $item['destination'] . ' ' . $item['description']), $term);
        }));
    }

    return $limit === null ? $rows : array_slice($rows, 0, $limit);
}

function get_package(int $id): ?array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->prepare('SELECT * FROM packages WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $package = $stmt->fetch();

        if ($package) {
            return $package;
        }
    }

    foreach (storage_read('packages') as $package) {
        if ((int) $package['id'] === $id) {
            return $package;
        }
    }

    return null;
}

function get_admin_packages(): array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->query('SELECT * FROM packages ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    $rows = storage_read('packages');
    usort($rows, static fn (array $a, array $b): int => (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0));

    return $rows;
}

function save_package(array $data, ?int $id = null): int
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE packages SET title = :title, destination = :destination, category = :category, price = :price, rating = :rating, duration = :duration, description = :description, highlights = :highlights, image = :image, status = :status WHERE id = :id');
            $stmt->execute($data + ['id' => $id]);
            return $id;
        }

        $stmt = $pdo->prepare('INSERT INTO packages (title, destination, category, price, rating, duration, description, highlights, image, status) VALUES (:title, :destination, :category, :price, :rating, :duration, :description, :highlights, :image, :status)');
        $stmt->execute($data);
        return (int) $pdo->lastInsertId();
    }

    $rows = storage_read('packages');

    if ($id) {
        foreach ($rows as &$row) {
            if ((int) ($row['id'] ?? 0) === $id) {
                $row = array_merge($row, $data, ['id' => $id, 'updated_at' => date('c')]);
                storage_write('packages', $rows);
                return $id;
            }
        }
    }

    $data['id'] = next_storage_id($rows);
    $data['created_at'] = date('c');
    $rows[] = $data;
    storage_write('packages', $rows);

    return (int) $data['id'];
}

function delete_package(int $id): void
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->prepare('DELETE FROM packages WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return;
    }

    $rows = array_values(array_filter(storage_read('packages'), static fn (array $row): bool => (int) ($row['id'] ?? 0) !== $id));
    storage_write('packages', $rows);
}

function get_bookings(): array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->query('SELECT bookings.*, packages.title AS package_title FROM bookings LEFT JOIN packages ON packages.id = bookings.package_id ORDER BY bookings.id DESC');
        return $stmt->fetchAll();
    }

    $packages = storage_read('packages');
    $packageNames = [];

    foreach ($packages as $package) {
        $packageNames[(int) ($package['id'] ?? 0)] = $package['title'] ?? 'Package';
    }

    $bookings = storage_read('bookings');

    foreach ($bookings as &$booking) {
        $booking['package_title'] = $packageNames[(int) ($booking['package_id'] ?? 0)] ?? 'Custom journey';
    }

    usort($bookings, static fn (array $a, array $b): int => (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0));

    return $bookings;
}

function create_booking(array $data): int
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->prepare('INSERT INTO bookings (name, email, phone, package_id, travel_date, guests, notes, status) VALUES (:name, :email, :phone, :package_id, :travel_date, :guests, :notes, :status)');
        $stmt->execute($data + ['status' => 'new']);
        return (int) $pdo->lastInsertId();
    }

    $rows = storage_read('bookings');
    $data['id'] = next_storage_id($rows);
    $data['status'] = 'new';
    $data['created_at'] = date('c');
    $rows[] = $data;
    storage_write('bookings', $rows);

    return (int) $data['id'];
}

function find_user_by_email(string $email): ?array
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    foreach (storage_read('users') as $user) {
        if (strtolower((string) ($user['email'] ?? '')) === strtolower($email)) {
            return $user;
        }
    }

    return null;
}

function create_user_account(string $name, string $email, string $password): void
{
    $pdo = db();

    if ($pdo instanceof PDO) {
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'customer',
        ]);
        return;
    }

    if (find_user_by_email($email)) {
        throw new RuntimeException('This email is already registered.');
    }

    $rows = storage_read('users');
    $rows[] = [
        'id' => next_storage_id($rows),
        'name' => $name,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'customer',
        'created_at' => date('c'),
    ];
    storage_write('users', $rows);
}

function split_highlights(?string $highlights): array
{
    return array_values(array_filter(array_map('trim', explode(',', (string) $highlights))));
}

function upload_package_image(array $file): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }

    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be smaller than 5MB.');
    }

    $info = getimagesize($file['tmp_name']);
    $allowed = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_WEBP => 'webp',
    ];

    if (!$info || !isset($allowed[$info[2]])) {
        throw new RuntimeException('Upload a JPG, PNG, or WebP image.');
    }

    $filename = 'package-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$info[2]];
    $relative = 'assets/uploads/' . $filename;
    $target = __DIR__ . '/../' . $relative;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Could not save uploaded image.');
    }

    return $relative;
}

function read_json_file(string $path): array
{
    if (!is_file($path)) {
        return [];
    }

    $json = file_get_contents($path);
    $data = json_decode((string) $json, true);

    return is_array($data) ? $data : [];
}
