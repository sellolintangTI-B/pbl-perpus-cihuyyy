CREATE OR REPLACE FUNCTION soft_delete_room_and_cancel_bookings(
    p_room_id UUID, 
    p_admin_id UUID
)
RETURNS TABLE (
    affected_user_id UUID
) AS $$
DECLARE 
    room_exists BOOLEAN;
BEGIN 
    -- 1. Validasi: Cek apakah ruangan ada
    SELECT EXISTS(SELECT 1 FROM rooms WHERE id = p_room_id) INTO room_exists;
    
    IF NOT room_exists THEN 
        RAISE EXCEPTION 'Ruangan dengan ID % tidak ditemukan', p_room_id;
    END IF;

    -- 2. Logic Utama dengan CTE
    RETURN QUERY
    WITH 
    -- [A] Ambil kandidat booking di masa depan untuk ruangan ini
    future_bookings AS (
        SELECT b.id, b.user_id
        FROM bookings b
        WHERE b.room_id = p_room_id
        AND b.start_time > NOW() -- Menggunakan 'start_time'
    ),

    -- [B] Filter: Hanya ambil booking yang status TERAKHIRNYA adalah 'pending' atau 'approved'
    -- Kita harus mengecek tabel logs untuk mengetahui status terkini.
    active_bookings AS (
        SELECT fb.id, fb.user_id
        FROM future_bookings fb
        WHERE (
            SELECT bl.status 
            FROM booking_logs bl 
            WHERE bl.booking_id = fb.id 
            ORDER BY bl.created_at DESC -- Urutkan dari log terbaru
            LIMIT 1
        ) IN ('created', 'checked_in') -- Sesuaikan dengan status aktif di sistemmu
        -- Pastikan status terakhir BUKAN 'cancelled', 'rejected', atau 'completed'
    ),
    
    -- [C] Soft Delete Ruangan (Set Operational jadi FALSE)
    deactivate_room AS (
        UPDATE rooms 
        SET is_deleted = true 
        WHERE id = p_room_id
    ),
    
    -- [D] Insert Log Pembatalan Baru
    -- Kita tidak update tabel bookings, tapi menambah log baru dengan status 'cancelled'
    insert_cancel_logs AS (
        INSERT INTO booking_logs (
            booking_id, 
            status, 
            reason, 
            created_at, 
           	cancelled_by
        )
        SELECT 
            ab.id,                  -- booking_id
            'cancelled',            -- status baru
            'Ruangan dihapus oleh Admin', -- reason
            NOW() AT TIME ZONE 'Asia/Jakarta',            -- created_at
            p_admin_id              -- actor_user_id (Admin yang menghapus)
        FROM active_bookings ab
        RETURNING booking_id -- Sekedar trigger execution
    )
    
    -- [E] Return User ID untuk Notifikasi PHP
    SELECT ab.user_id 
    FROM active_bookings ab;

END;
$$ LANGUAGE plpgsql;