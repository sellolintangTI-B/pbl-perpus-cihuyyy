CREATE EXTENSION IF NOT EXISTS "pgcrypto";
INSERT INTO rooms (
    id, name, floor, description,
    min_capacity, max_capacity,
    is_deleted, is_operational,
    requires_special_approval, room_img_url
)
VALUES
-- Lantai 1
(gen_random_uuid(), 'Ruang Server', 1, 'Ruangan dengan akses terbatas untuk peralatan server dan jaringan.', 1, 3, FALSE, TRUE, TRUE, 'https://example.com/img/room3.jpg'),

-- Lantai 2
(gen_random_uuid(), 'Ruang Kelas 2A', 2, 'Ruang kelas standar dengan proyektor dan AC.', 10, 25, FALSE, TRUE, FALSE, 'https://example.com/img/room4.jpg'),
(gen_random_uuid(), 'Ruang Kelas 2B', 2, 'Ruang kelas sedang dengan fasilitas lengkap.', 15, 30, FALSE, TRUE, FALSE, 'https://example.com/img/room5.jpg'),

