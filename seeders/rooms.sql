CREATE EXTENSION IF NOT EXISTS "pgcrypto";
INSERT INTO rooms (
    id, name, floor, description,
    min_capacity, max_capacity,
    is_deleted, is_operational,
    requires_special_approval, room_img_url
)
VALUES
-- Ruangan Minimal 2 Orang dan Maksimal 4 Orang
(gen_random_uuid(), 'Ruang Asa', 1, 'Ruang Bimbingan & Konseling.', 2, 4, FALSE, TRUE, FALSE, 'storage/rooms/ruang_asa.jpg'),
(gen_random_uuid(), 'Lentera Edukasi', 1, 'Ruang Bimbingan & Konseling.', 2, 4, FALSE, TRUE, FALSE, 'storage/rooms/lentera_edukasi.jpg'),

-- Ruang Minimal 6 dan Maksimal 12 Orang
(gen_random_uuid(), 'Ruang Layar', 2, 'Ruang Audio Visual.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/ruang_layar.jpg'),
(gen_random_uuid(), 'Ruang Sinergi', 2, 'Ruang Telekonferensi.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/ruang_sinergi.jpg'),
(gen_random_uuid(), 'Zona Interaktif', 2, 'Ruang Kreasi dan Rekreasi.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/zona_interaktif.jpg'),
(gen_random_uuid(), 'Sudut Pustaka', 2, 'Ruang Baca Kelompok.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/sudut_pustaka.jpg'),
(gen_random_uuid(), 'Galeri Literasi', 2, 'Ruang Baca Kelompok.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/galeri_literasi.jpg'),
(gen_random_uuid(), 'Ruang Cendekia', 2, 'Ruang Baca Kelompok.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/ruang_cendekia.jpg'),
(gen_random_uuid(), 'Pusat Perancis', 2, 'Ruang Koleksi Bahasa Prancis.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/pusat_prancis.jpg');