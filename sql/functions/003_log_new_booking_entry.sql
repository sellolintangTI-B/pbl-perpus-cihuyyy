CREATE OR REPLACE FUNCTION log_new_booking_entry()
RETURNS TRIGGER AS $$
BEGIN

INSERT INTO booking_logs(booking_id, status, created_at) 
VALUES (NEW.id, 'created', NOW() AT TIME ZONE 'Asia/Jakarta'); 

RETURN NEW;
END ;
$$ LANGUAGE plpgsql;