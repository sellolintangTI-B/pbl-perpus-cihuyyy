CREATE TABLE library_close_logs(
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    close_date DATE NOT NULL UNIQUE,
    reason TEXT,
    created_by UUID NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id),
    created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta')
);