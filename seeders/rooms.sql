
-- =============================================
-- 1. SETUP & CLEANUP
-- =============================================
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

-- Hapus data lama agar bersih (urutan penting karena Foreign Keys)
TRUNCATE TABLE feedbacks, booking_participants, booking_logs, bookings, rooms, users RESTART IDENTITY CASCADE;

-- =============================================
-- 2. SEEDER ROOMS (Sesuai Request)
-- =============================================
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
(gen_random_uuid(), 'Pusat Perancis', 2, 'Ruang Koleksi Bahasa Prancis.', 6, 12, FALSE, TRUE, FALSE, 'storage/rooms/pusat_prancis.jpg'),

-- Tanpa minimal dan maksimal (Set default logic agar aman)
(gen_random_uuid(), 'Ruang Rapat', 2, 'Ruang Rapat Utama.', 1, 20, FALSE, TRUE, TRUE, 'storage/rooms/ruang_rapat.jpg');


-- =============================================
-- 3. SEEDER USERS
-- =============================================
-- Password default (Hashed)
-- User: @Skme123
-- Admin: @Dmin123

-- 3.1 Insert User Spesifik (Nugroho)
INSERT INTO users (
    id_number, email, password_hash, first_name, last_name, 
    institution, major, study_program, phone_number, 
    role, is_active, active_periode, created_at
) VALUES (
    '2407411057', 
    'nugroho.nur.cahyo.tik24@stu.pnj.ac.id', 
    crypt('@Skme123', gen_salt('bf')), -- Hash @Skme123
    'Nugroho', 'Nur Cahyo', 
    'Politeknik Negeri Jakarta', 'Teknik Informatika dan Komputer', 'Teknik Informatika', '081234567890', 
    'Mahasiswa', TRUE, '2028-06-30 23:59:59'::TIMESTAMP, NOW() - INTERVAL '3 years'
);

-- 3.2 Insert 1 Admin
INSERT INTO users (
    id_number, email, password_hash, first_name, last_name, 
    institution, major, study_program, phone_number, 
    role, is_active, active_periode, created_at
) VALUES (
    'ADMIN001', 
    'admin.perpustakaan@pnj.ac.id', 
    crypt('@Dmin123', gen_salt('bf')), -- Hash @Dmin123
    'Admin', 'Perpustakaan', 
    'Politeknik Negeri Jakarta', 'Pusat', 'Administrasi', '081199887766', 
    'Admin', TRUE, '2029-12-31 23:59:59'::TIMESTAMP, NOW() - INTERVAL '3 years'
);

-- 3.3 Insert 49 Dummy Users (Looping)
DO $$
DECLARE
    i INT;
    first_names TEXT[] := ARRAY['Aditya', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indah', 'Joko', 'Kartika', 'Lestari', 'Mahendra', 'Nadia', 'Oscar', 'Putri', 'Qori', 'Rizky', 'Siti', 'Tio', 'Utami', 'Vina', 'Wahyu', 'Xena', 'Yusuf', 'Zahra', 'Ahmad', 'Bayu', 'Chandra', 'Dinda'];
    last_names TEXT[] := ARRAY['Pratama', 'Santoso', 'Wijaya', 'Kusuma', 'Saputra', 'Nugraha', 'Hidayat', 'Wibowo', 'Siregar', 'Basri', 'Winata', 'Utomo', 'Firmansyah', 'Sari', 'Permadi', 'Susanti', 'Hakim', 'Ramadhan', 'Kurniawan', 'Putra'];
    v_first TEXT;
    v_last TEXT;
    v_angkatan INT;
    v_angkatan_2digit TEXT;
    v_end_year INT;
    v_active_periode TIMESTAMP;
    v_nim TEXT;
    v_jurusan_code TEXT;
    v_urutan INT;
BEGIN
    FOR i IN 1..49 LOOP
        v_first := first_names[1 + floor(random() * array_length(first_names, 1))::int];
        v_last := last_names[1 + floor(random() * array_length(last_names, 1))::int];
        
        -- Random angkatan antara 2022-2025 (untuk masa aktif sampai 2029)
        v_angkatan := floor(random() * 4 + 2022); -- 2022, 2023, 2024, 2025
        v_angkatan_2digit := substring(v_angkatan::TEXT from 3 for 2); -- Ambil 2 digit terakhir: 22, 23, 24, 25
        v_end_year := v_angkatan + 4; -- D4 = 4 tahun
        
        -- Set active_periode sebagai tanggal akhir masa aktif (akhir Juni tahun kelulusan)
        v_active_periode := (v_end_year || '-06-30 23:59:59')::TIMESTAMP;
        
        -- Generate NIM dengan format mirip Nugroho: 2407411057
        -- Format: [2 digit angkatan][07][4][11][random 3 digit]
        v_jurusan_code := '07'; -- Kode jurusan TI
        v_urutan := 10000 + floor(random() * 90000)::INT; -- 5 digit random (10000-99999)
        v_nim := v_angkatan_2digit || v_jurusan_code || '4' || lpad(v_urutan::TEXT, 5, '0');
        
        INSERT INTO users (
            id_number, email, password_hash, first_name, last_name, 
            institution, major, study_program, phone_number, 
            role, is_active, active_periode, created_at
        ) VALUES (
            v_nim,
            lower(v_first || '.' || v_last || i::TEXT || '@stu.pnj.ac.id'),
            crypt('@Skme123', gen_salt('bf')),
            v_first, v_last,
            'Politeknik Negeri Jakarta', 'Teknik Informatika dan Komputer', 'Teknik Informatika',
            '08' || lpad(floor(random() * 10000000000)::TEXT, 10, '0'),
            'Mahasiswa', 
            TRUE, 
            v_active_periode,
            NOW() - INTERVAL '3 years' + (i || ' days')::INTERVAL
        );
    END LOOP;
END $$;


-- =============================================
-- 4. SEEDER BOOKINGS (Complex Logic)
-- =============================================
DO $booking_seeder$
DECLARE
    v_booking_count INT := 0;
    v_target_bookings INT := 1000;
    v_start_period DATE := CURRENT_DATE - INTERVAL '3 years';
    v_max_attempts INT := 5000; -- Prevent infinite loop
    v_attempts INT := 0;
    
    -- Variables for creating a booking
    v_date DATE;
    v_dow INT; -- Day of week (1=Mon, 7=Sun)
    v_room RECORD;
    v_pic RECORD;
    v_start_time TIMESTAMP;
    v_end_time TIMESTAMP;
    v_duration INT; -- Minutes
    v_slot_choice INT;
    v_booking_id UUID;
    v_status TEXT;
    v_cancel_count INT;
    v_max_start_offset INT;
    
    -- Loop vars
    v_participants_needed INT;
    v_is_cancelled BOOLEAN;
    
BEGIN
    WHILE v_booking_count < v_target_bookings AND v_attempts < v_max_attempts LOOP
        v_attempts := v_attempts + 1;
        
        -- A. Tentukan Tanggal Acak (3 tahun terakhir)
        v_date := v_start_period + (floor(random() * 1095) || ' days')::interval;
        v_dow := extract(isodow from v_date);

        -- B. RULES: Weekend (Sat=6, Sun=7) -> Skip
        IF v_dow >= 6 THEN
            CONTINUE;
        END IF;

        -- C. Tentukan Waktu Berdasarkan Schedule.json
        v_slot_choice := floor(random() * 2) + 1; -- 1 (Pagi) atau 2 (Siang)
        v_duration := floor(random() * 121 + 60); -- Durasi 60-180 menit

        IF v_dow BETWEEN 1 AND 4 THEN
            IF v_slot_choice = 1 THEN
                -- Slot Pagi: 08:00 - 12:00 (240 mins window)
                v_max_start_offset := GREATEST(0, 240 - v_duration);
                v_start_time := v_date + '08:00:00'::time + (floor(random() * (v_max_start_offset + 1)) || ' minutes')::interval;
            ELSE
                -- Slot Siang: 13:00 - 15:50 (170 mins window)
                IF v_duration > 170 THEN 
                    v_duration := floor(random() * 111 + 60); -- 60-170 menit
                END IF;
                v_max_start_offset := GREATEST(0, 170 - v_duration);
                v_start_time := v_date + '13:00:00'::time + (floor(random() * (v_max_start_offset + 1)) || ' minutes')::interval;
            END IF;
        ELSE -- Jumat (5)
            IF v_slot_choice = 1 THEN
                -- Slot Pagi: 08:00 - 11:00 (180 mins)
                v_max_start_offset := GREATEST(0, 180 - v_duration);
                v_start_time := v_date + '08:00:00'::time + (floor(random() * (v_max_start_offset + 1)) || ' minutes')::interval;
            ELSE
                -- Slot Siang: 13:00 - 16:30 (210 mins)
                v_max_start_offset := GREATEST(0, 210 - v_duration);
                v_start_time := v_date + '13:00:00'::time + (floor(random() * (v_max_start_offset + 1)) || ' minutes')::interval;
            END IF;
        END IF;

        v_end_time := v_start_time + (v_duration || ' minutes')::interval;

        -- D. Pilih Ruangan Secara Acak (Exclude Ruang Rapat yang require special approval)
        SELECT * INTO v_room FROM rooms 
        WHERE is_deleted = FALSE 
        AND is_operational = TRUE 
        AND requires_special_approval = FALSE
        ORDER BY random() LIMIT 1;
        
        IF v_room.id IS NULL THEN
            CONTINUE;
        END IF;

        -- E. RULES: Room tidak bisa overlap
        IF EXISTS (
            SELECT 1 FROM bookings b
            JOIN booking_logs bl ON b.id = bl.booking_id
            WHERE b.room_id = v_room.id 
            AND b.is_deleted = FALSE
            AND bl.status != 'cancelled'
            AND (b.start_time, b.end_time) OVERLAPS (v_start_time, v_end_time)
        ) THEN
            CONTINUE;
        END IF;

        -- F. Pilih PIC (User)
        SELECT * INTO v_pic FROM users WHERE role = 'Mahasiswa' AND is_active = TRUE ORDER BY random() LIMIT 1;
        
        IF v_pic.id IS NULL THEN
            CONTINUE;
        END IF;

        -- G. RULES: User tidak bisa booking overlap
        IF EXISTS (
            SELECT 1 FROM bookings b
            JOIN booking_logs bl ON b.id = bl.booking_id
            WHERE b.user_id = v_pic.id 
            AND b.is_deleted = FALSE
            AND bl.status != 'cancelled'
            AND (b.start_time, b.end_time) OVERLAPS (v_start_time, v_end_time)
        ) THEN
            CONTINUE;
        END IF;

        -- H. Insert Booking
        v_booking_id := gen_random_uuid();
        v_is_cancelled := random() < 0.2; -- 20% cancelled
        
        INSERT INTO bookings (
            id, user_id, room_id, start_time, duration, end_time, 
            booking_code, is_deleted, created_at
        ) VALUES (
            v_booking_id, v_pic.id, v_room.id, v_start_time, v_duration, v_end_time,
            upper(substring(md5(random()::text), 1, 5)), 
            FALSE, 
            v_start_time - INTERVAL '1 day'
        );

        -- I. Insert Participants (Sesuai Min/Max Room)
        v_participants_needed := floor(random() * (LEAST(v_room.max_capacity, 10) - GREATEST(v_room.min_capacity, 1) + 1)) + GREATEST(v_room.min_capacity, 1);
        
        INSERT INTO booking_participants (id, booking_id, user_id, created_at)
        SELECT gen_random_uuid(), v_booking_id, id, v_start_time - INTERVAL '1 day'
        FROM users 
        WHERE id != v_pic.id AND role = 'Mahasiswa' AND is_active = TRUE
        ORDER BY random() 
        LIMIT LEAST(v_participants_needed, (SELECT count(*) FROM users WHERE role = 'Mahasiswa' AND is_active = TRUE) - 1);

        -- J. Handle Logs & Status
        -- Log Created
        INSERT INTO booking_logs (booking_id, status, created_at) 
        VALUES (v_booking_id, 'created', v_start_time - INTERVAL '1 day');

        IF v_is_cancelled THEN
            -- Log Cancelled
            INSERT INTO booking_logs (booking_id, status, cancelled_by, reason, created_at) 
            VALUES (v_booking_id, 'cancelled', v_pic.id, 
                    CASE floor(random() * 4)
                        WHEN 0 THEN 'Berubah pikiran'
                        WHEN 1 THEN 'Jadwal bentrok'
                        WHEN 2 THEN 'Ada keperluan mendadak'
                        ELSE 'Tidak bisa hadir'
                    END,
                    v_start_time - (floor(random() * 23 + 1) || ' hours')::interval);

            -- Update suspend count for user
            SELECT count(*) INTO v_cancel_count 
            FROM booking_logs bl 
            JOIN bookings b ON bl.booking_id = b.id 
            WHERE b.user_id = v_pic.id AND bl.status = 'cancelled';

            IF v_cancel_count >= 3 THEN
                UPDATE users 
                SET suspend_count = LEAST(v_cancel_count, 3),
                    is_suspend = TRUE, 
                    suspend_untill = NOW() + INTERVAL '7 days' 
                WHERE id = v_pic.id;
            ELSIF v_cancel_count > 0 THEN
                UPDATE users 
                SET suspend_count = v_cancel_count
                WHERE id = v_pic.id;
            END IF;

        ELSE
            -- Log Checked In (saat start time)
            INSERT INTO booking_logs (booking_id, status, created_at) 
            VALUES (v_booking_id, 'checked_in', v_start_time + (floor(random() * 15) || ' minutes')::interval);

            -- Log Finished (saat end time)
            INSERT INTO booking_logs (booking_id, status, created_at) 
            VALUES (v_booking_id, 'finished', v_end_time + (floor(random() * 30) || ' minutes')::interval);

            -- K. Feedback (70% dari booking finished, 85% rating 4-5)
            IF random() < 0.7 THEN
                DECLARE
                    v_rating INT;
                    v_random_val FLOAT;
                BEGIN
                    v_random_val := random();
                    -- 85% chance rating 4-5, 15% chance rating 1-3
                    IF v_random_val < 0.85 THEN
                        -- 50% rating 5, 35% rating 4
                        IF v_random_val < 0.50 THEN
                            v_rating := 5;
                        ELSE
                            v_rating := 4;
                        END IF;
                    ELSE
                        -- 15% untuk rating 1-3 (5% each)
                        v_rating := floor(random() * 3 + 1); -- 1-3
                    END IF;
                    
                    INSERT INTO feedbacks (user_id, booking_id, rating, feedback, created_at)
                    VALUES (
                        v_pic.id, 
                        v_booking_id, 
                        v_rating,
                        CASE 
                            WHEN v_rating = 5 THEN 
                                CASE floor(random() * 5)
                                    WHEN 0 THEN 'Ruangan sangat nyaman dan bersih, fasilitas lengkap!'
                                    WHEN 1 THEN 'Sempurna! Pelayanan excellent dan ruangan sangat bagus.'
                                    WHEN 2 THEN 'Sangat puas, ruangan bersih dan fasilitasnya modern.'
                                    WHEN 3 THEN 'Luar biasa! Suasana tenang dan sangat mendukung produktivitas.'
                                    ELSE 'Perfect! Sangat merekomendasikan ruangan ini.'
                                END
                            WHEN v_rating = 4 THEN
                                CASE floor(random() * 5)
                                    WHEN 0 THEN 'Ruangan nyaman dan bersih, sangat memuaskan.'
                                    WHEN 1 THEN 'Fasilitas lengkap, sangat membantu kegiatan kami.'
                                    WHEN 2 THEN 'Tempat strategis dan mudah diakses, recommended.'
                                    WHEN 3 THEN 'Suasana tenang, cocok untuk belajar dan diskusi.'
                                    ELSE 'Pelayanan memuaskan, ruangan sesuai ekspektasi.'
                                END
                            WHEN v_rating = 3 THEN
                                CASE floor(random() * 3)
                                    WHEN 0 THEN 'Cukup bagus, tapi AC-nya kurang dingin.'
                                    WHEN 1 THEN 'Lumayan, beberapa fasilitas perlu diperbaiki.'
                                    ELSE 'Standar, tidak ada yang istimewa tapi cukup memadai.'
                                END
                            WHEN v_rating = 2 THEN
                                CASE floor(random() * 3)
                                    WHEN 0 THEN 'Kurang memuaskan, kebersihan perlu ditingkatkan.'
                                    WHEN 1 THEN 'AC tidak berfungsi dengan baik, cukup panas.'
                                    ELSE 'Beberapa fasilitas rusak, perlu perbaikan segera.'
                                END
                            ELSE -- rating 1
                                CASE floor(random() * 3)
                                    WHEN 0 THEN 'Sangat tidak memuaskan, ruangan kotor dan tidak terawat.'
                                    WHEN 1 THEN 'Fasilitas banyak yang rusak, sangat mengecewakan.'
                                    ELSE 'Pelayanan buruk, tidak sesuai dengan yang diharapkan.'
                                END
                        END,
                        v_end_time + (floor(random() * 120 + 10) || ' minutes')::interval
                    );
                END;
            END IF;
        END IF;

        v_booking_count := v_booking_count + 1;
        
        -- Progress indicator (every 100 bookings)
        IF v_booking_count % 100 = 0 THEN
            RAISE NOTICE 'Progress: % / % bookings created', v_booking_count, v_target_bookings;
        END IF;
    END LOOP;

    RAISE NOTICE 'Seeding completed: % bookings created in % attempts', v_booking_count, v_attempts;
END $booking_seeder$;
