CREATE OR REPLACE VIEW v_booking_details AS
SELECT DISTINCT ON (b.id)
    b.id AS booking_id,
    b.booking_code,
    b.user_id,
    b.room_id,
    b.start_time,
    b.end_time,
    b.duration,
    bl.reason,
    u.first_name || ' ' || u.last_name AS pic_name,
    u.email AS pic_email,
    r.name AS room_name,
    r.floor,
    r.requires_special_approval,
    r.room_img_url,
    bl.status AS current_status,
    bl.created_at AS last_status_update
FROM bookings b
JOIN booking_logs bl ON b.id = bl.booking_id
JOIN rooms r ON b.room_id = r.id
LEFT JOIN users u ON b.user_id = u.id
ORDER BY b.id, bl.created_at DESC;