INSERT INTO users (
    id, id_number, email, password_hash, first_name, last_name,
    institution, phone_number, major, study_program, role, 
    activation_proof_url, is_active, created_at, active_periode
) VALUES
-- PASS BUAT ADMIN ADMIN123
(gen_random_uuid(), '2407411031', 'farrelmaahira104@gmail.com', '$2y$10$qOjYJlIcJFQ4k1GeL4m07eejEG0fszjMRyyZp.lN8mcqdGXSSGCo.', 'Farrel', 'Nugraha', 'Politeknik Negeri Jakarta', '08123192783','TIK', 'Teknik Informatika', 'Admin', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110301', 'mahasiswa1@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Farrel', 'Nugraha', 'Politeknik Negeri Jakarta', '081234567801','TIK', 'Teknik Informatika', 'Mahasiswa', NULL, true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110302', 'mahasiswa2@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Alya', 'Putri', 'Politeknik Negeri Jakarta', '081234567802','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110303', 'mahasiswa3@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Rafi', 'Hidayat', 'Politeknik Negeri Jakarta', '081234567803','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110304', 'mahasiswa4@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Sinta', 'Rahma', 'Politeknik Negeri Jakarta', '081234567804','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110305', 'mahasiswa5@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Bima', 'Satya', 'Politeknik Negeri Jakarta', '081234567805','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110306', 'mahasiswa6@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Nabila', 'Ananda', 'Politeknik Negeri Jakarta', '081234567806','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110307', 'mahasiswa7@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Dimas', 'Pratama', 'Politeknik Negeri Jakarta', '081234567807','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years'),
(gen_random_uuid(), '24074110308', 'mahasiswa8@example.com', '$2a$12$9f1.HJUGK2f8smMGGPp0puy9TKbY1dtFL0RiMaeCOPe5pUESXWQUO', 'Citra', 'Anggraini', 'Politeknik Negeri Jakarta', '081234567808','TIK', 'Teknik Informatika', 'Mahasiswa', NULL,  true, CURRENT_TIMESTAMP, NOW() + INTERVAL '4 years');
