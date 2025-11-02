CREATE EXTENSION IF NOT EXISTS "pgcrypto";
INSERT INTO rooms (
    id, name, floor, description,
    min_capacity, max_capacity,
    is_deleted, is_operational,
    requires_special_approval, room_img_url
)
VALUES
-- Lantai 1
(gen_random_uuid(), 'Ruang Rapat Utama', 1, 'Ruang rapat besar untuk kegiatan umum dan pertemuan resmi.', 10, 30, FALSE, TRUE, FALSE, 'https://example.com/img/room1.jpg'),
(gen_random_uuid(), 'Ruang Seminar A', 1, 'Cocok untuk seminar kecil atau pelatihan internal.', 20, 50, FALSE, TRUE, FALSE, 'https://example.com/img/room2.jpg'),
(gen_random_uuid(), 'Ruang Server', 1, 'Ruangan dengan akses terbatas untuk peralatan server dan jaringan.', 1, 3, FALSE, TRUE, TRUE, 'https://example.com/img/room3.jpg'),

-- Lantai 2
(gen_random_uuid(), 'Ruang Kelas 2A', 2, 'Ruang kelas standar dengan proyektor dan AC.', 10, 25, FALSE, TRUE, FALSE, 'https://example.com/img/room4.jpg'),
(gen_random_uuid(), 'Ruang Kelas 2B', 2, 'Ruang kelas sedang dengan fasilitas lengkap.', 15, 30, FALSE, TRUE, FALSE, 'https://example.com/img/room5.jpg'),
(gen_random_uuid(), 'Ruang Praktikum Komputer', 2, 'Berisi 20 unit komputer dan jaringan LAN.', 10, 20, FALSE, TRUE, TRUE, 'https://example.com/img/room6.jpg'),

-- Lantai 3
(gen_random_uuid(), 'Ruang Auditorium', 3, 'Ruang besar untuk acara kampus, seminar, atau peluncuran produk.', 50, 150, FALSE, TRUE, FALSE, 'https://example.com/img/room7.jpg'),
(gen_random_uuid(), 'Ruang Meeting Dosen', 3, 'Ruang rapat khusus dosen atau staf pengajar.', 5, 15, FALSE, TRUE, FALSE, 'https://example.com/img/room8.jpg'),
(gen_random_uuid(), 'Ruang Penelitian', 3, 'Ruang tertutup dengan peralatan penelitian dan keamanan tinggi.', 3, 8, FALSE, TRUE, TRUE, 'https://example.com/img/room9.jpg'),

-- Lantai 4
(gen_random_uuid(), 'Ruang Multimedia', 4, 'Ruang dilengkapi dengan perangkat audio dan video untuk presentasi.', 10, 25, FALSE, TRUE, FALSE, 'https://example.com/img/room10.jpg'),
(gen_random_uuid(), 'Ruang Diskusi Mahasiswa', 4, 'Tempat santai untuk diskusi kelompok mahasiswa.', 4, 12, FALSE, TRUE, FALSE, 'https://example.com/img/room11.jpg'),
(gen_random_uuid(), 'Ruang Maintenance', 4, 'Ruang teknisi untuk penyimpanan alat perawatan gedung.', 1, 5, FALSE, FALSE, TRUE, 'https://example.com/img/room12.jpg');