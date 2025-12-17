CREATE EXTENSION IF NOT EXISTS "pgcrypto";
DROP VIEW IF EXISTS v_booking_details;
DROP TABLE IF EXISTS reset_password;
DROP TABLE IF EXISTS feedbacks;
DROP TABLE IF EXISTS booking_participants;
DROP TABLE IF EXISTS booking_logs;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS suspensions;
DROP TABLE IF EXISTS library_close_logs;
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users  (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    id_number VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    institution VARCHAR(255) NOT NULL,
    major VARCHAR(100),
    study_program VARCHAR(100),
    phone_number VARCHAR(20) UNIQUE NOT NULL,
    active_periode TIMESTAMP,
    role VARCHAR(20) CHECK (role IN ('Admin', 'Mahasiswa', 'Dosen', 'Guest')) NOT NULL,
    suspend_count SMALLINT,
    is_suspend BOOLEAN DEFAULT FALSE,
    suspend_untill TIMESTAMP, 
    profile_picture_url VARCHAR(255),
    activation_proof_url VARCHAR(255),
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta')
);