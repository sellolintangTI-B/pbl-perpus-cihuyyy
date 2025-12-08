CREATE TRIGGER trg_after_booking_insert
AFTER INSERT on bookings 
FOR EACH ROW
EXECUTE FUNCTION log_new_booking_entry();