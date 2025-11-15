CREATE EXTENSION IF NOT EXISTS "pgcrypto";
SET TIMEZONE = 'Asia/Jakarta';
DROP TYPE status;
CREATE TYPE status AS ENUM ('checked_in', 'finished', 'cancelled', 'created');
CREATE TABLE IF NOT EXISTS booking_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    booking_id UUID NOT NULL,
    cancelled_by UUID,
    is_approved BOOLEAN DEFAULT FALSE,
    status status NOT NULL DEFAULT 'created',
    reason TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (cancelled_by) REFERENCES users(id),
    created_at TIMESTAMPTZ DEFAULT NOW() 
);