CREATE TRIGGER trg_after_library_close_insert
AFTER INSERT ON library_close_logs
FOR EACH ROW
EXECUTE FUNCTION cancel_bookings_on_close_date();