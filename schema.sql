CREATE TABLE IF NOT EXISTS 'users' (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    `username` TEXT NOT NULL,
    `hashed_password` TEXT,
    `is_active` INTEGER DEFAULT 0,
    `tagline` TEXT DEFAULT '',
    `webpage` TEXT DEFAULT ''
);

CREATE TABLE IF NOT EXISTS 'cats' (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    `image_path` TEXT NOT NULL,
    `created_by` INTEGER NOT NULL,
    `created_at` TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`created_by`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS 'comments' (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    `comment` TEXT NOT NULL,
    `cat_id` INTEGER NOT NULL,
    `created_by` INTEGER NOT NULL,
    `created_at` TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`cat_id`) REFERENCES cats(`id`),
    FOREIGN KEY(`created_by`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS 'relations' (
    `follower_id` INTEGER NOT NULL,
    `following_id` INTEGER NOT NULL,
    FOREIGN KEY(`follower_id`) REFERENCES users(`id`),
    FOREIGN KEY(`following_id`) REFERENCES users(`id`)
);
