CREATE EXTENSION IF NOT EXISTS "pgcrypto";  
SET TIMEZONE = 'Asia/Jakarta';
CREATE TABLE feedbacks(
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL,
    booking_id UUID NOT NULL,
    rating FLOAT,
    feedback TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    created_at TIMESTAMPTZ DEFAULT NOW() 
);