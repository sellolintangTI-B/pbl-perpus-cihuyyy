CREATE EXTENSION IF NOT EXISTS "pgcrypto";
DROP TABLE IF EXISTS bookings RESTRICT;
CREATE TABLE bookings (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL,
    room_id UUID NOT NULL,
    start_time TIMESTAMP NOT NULL,
    duration INTEGER NOT NULL,
    end_time TIMESTAMP NOT NULL,
    booking_code VARCHAR(5) NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    special_requirement_attachments_url VARCHAR(100),
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);