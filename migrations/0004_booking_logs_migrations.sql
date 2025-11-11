CREATE EXTENSION IF NOT EXISTS "pgcrypto";
DROP TABLE IF EXISTS booking_logs;
CREATE TYPE status AS ENUM ('checked_in', 'finished', 'cancelled', 'created');
CREATE TABLE IF NOT EXISTS booking_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    booking_id UUID NOT NULL,
    cancelled_by UUID,
    status status NOT NULL DEFAULT 'created',
    reason TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (cancelled_by) REFERENCES users(id)
);