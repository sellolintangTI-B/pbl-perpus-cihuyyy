CREATE TABLE bookings (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID,
    room_id UUID NOT NULL,
    start_time TIMESTAMP NOT NULL,
    duration INTEGER NOT NULL,
    end_time TIMESTAMP NOT NULL,
    booking_code VARCHAR(5) NOT NULL,
    special_requirement_attachments_url VARCHAR(100),
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);