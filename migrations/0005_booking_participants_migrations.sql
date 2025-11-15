CREATE EXTENSION IF NOT EXISTS "pgcrypto";  
SET TIMEZONE = 'Asia/Jakarta';
DROP TABLE IF EXISTS booking_participants;
CREATE TABLE booking_participants(
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    booking_id UUID NOT NULL,
    user_id UUID NOT NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    created_at TIMESTAMPTZ DEFAULT NOW() 
);