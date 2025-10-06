CREATE EXTENSION IF NOT EXISTS "pgcrypto";
CREATE TABLE IF NOT EXISTS rooms (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    floor SMALLINT,
    description TEXT,
    min_capacity INT NOT NULL,
    max_capacity INT NOT NULL,
    requires_special_approval BOOLEAN DEFAULT FALSE,
    room_img_url VARCHAR(255)
);
