CREATE TABLE reset_password (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(100),
    token VARCHAR(255),
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta')
);