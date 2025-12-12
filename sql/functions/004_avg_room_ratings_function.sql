CREATE OR REPLACE FUNCTION avg_room_ratings(rid UUID)
RETURNS FLOAT AS $$
    SELECT COALESCE(ROUND(AVG(f.rating)::numeric, 1), 0)::float 
    FROM feedbacks f
    JOIN bookings b ON f.booking_id = b.id -- Gunakan JOIN lebih standard
    WHERE b.room_id = rid;
$$ LANGUAGE sql;