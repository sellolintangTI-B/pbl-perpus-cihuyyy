CREATE EXTENSION IF NOT EXISTS "pgcrypto";
DROP TABLE IF EXISTS rooms CASCADE;
CREATE TABLE rooms (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    floor SMALLINT,
    description TEXT,
    min_capacity INT NOT NULL,
    max_capacity INT NOT NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    is_operational BOOLEAN DEFAULT TRUE,
    requires_special_approval BOOLEAN DEFAULT FALSE,
    room_img_url VARCHAR(255)
);
