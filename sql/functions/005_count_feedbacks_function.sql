CREATE OR REPLACE FUNCTION count_feedbacks(rid UUID)
RETURNS FLOAT AS $$
    SELECT COUNT(f.id)
    FROM feedbacks f
    JOIN bookings b ON f.booking_id = b.id -- Gunakan JOIN lebih standard
    WHERE b.room_id = rid;
$$ LANGUAGE sql;