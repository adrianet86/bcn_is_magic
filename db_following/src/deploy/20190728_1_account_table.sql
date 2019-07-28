-- Deploy db_following:20190728_1_account_table to pg

BEGIN;

CREATE TABLE public.accounts
(
    id                     UUID PRIMARY KEY,
    created_at             TIMESTAMP    NOT NULL,
    following_requested_at TIMESTAMP    DEFAULT NULL,
    updated_at             TIMESTAMP    DEFAULT  NULL,
    from_account           VARCHAR(255) NOT NULL,
    username               VARCHAR(150) NOT NULL,
    name                   VARCHAR(255) NOT NULL,
    instagram_id           VARCHAR(255) NOT NULL,
    biography              VARCHAR(255) DEFAULT NULL,
    from_method            VARCHAR(255) NOT NULL,
    gender                 VARCHAR(255) DEFAULT NULL,
    followers              INTEGER,
    following              INTEGER,
    following_rating       FLOAT,
    media_count            INTEGER,
    follower_ratio         FLOAT,
    is_private             BOOLEAN,
    has_profile_picture    BOOLEAN,
    is_business            BOOLEAN,
    follow_back            INTEGER
);

COMMIT;
