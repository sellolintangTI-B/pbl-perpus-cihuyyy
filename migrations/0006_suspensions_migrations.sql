CREATE EXTENSION IF NOT EXISTS "pgcrypto";  
SET TIMEZONE = 'Asia/Jakarta';
DROP TABLE IF EXISTS suspensions;
CREATE TABLE suspensions(
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL,
    suspend_count SMALLINT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta')
);