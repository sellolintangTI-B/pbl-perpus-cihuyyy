INSERT INTO users (
    id, id_number, email, password_hash, first_name, last_name,
    institution, phone_number, major, role, profile_picture_url,
    activation_proof_url, is_active, created_at
) VALUES
(gen_random_uuid(), '24074110301', 'mahasiswa1@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Farrel', 'Nugraha', 'Politeknik Negeri Jakarta', '081234567801', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110302', 'mahasiswa2@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Alya', 'Putri', 'Politeknik Negeri Jakarta', '081234567802', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110303', 'mahasiswa3@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Rafi', 'Hidayat', 'Politeknik Negeri Jakarta', '081234567803', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110304', 'mahasiswa4@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Sinta', 'Rahma', 'Politeknik Negeri Jakarta', '081234567804', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110305', 'mahasiswa5@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Bima', 'Satya', 'Politeknik Negeri Jakarta', '081234567805', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110306', 'mahasiswa6@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Nabila', 'Ananda', 'Politeknik Negeri Jakarta', '081234567806', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110307', 'mahasiswa7@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Dimas', 'Pratama', 'Politeknik Negeri Jakarta', '081234567807', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP),
(gen_random_uuid(), '24074110308', 'mahasiswa8@example.com', '$2b$10$CwTycUXWue0Thq9StjUM0uJ8Y3yE0YwzVZpXbI2H1IhTz1eWwKjBu', 'Citra', 'Anggraini', 'Politeknik Negeri Jakarta', '081234567808', 'Teknik Informatika', 'Mahasiswa', NULL, NULL, true, CURRENT_TIMESTAMP);
