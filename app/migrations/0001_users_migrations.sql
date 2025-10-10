CREATE EXTENSION IF NOT EXISTS "pgcrypto";
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    id_number VARCHAR(50),
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    institution VARCHAR(255),
    phone_number VARCHAR(20),
    role VARCHAR(20) CHECK (role IN ('Admin', 'Mahasiswa', 'Dosen', 'Guest')) NOT NULL,
    profile_picture_url VARCHAR(255),
    activation_proof_url VARCHAR(255),
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);