-- Revert bcn_is_magic:20190709_1 from pg

BEGIN;

ALTER TABLE IMAGES
    DROP COLUMN posted_at,
    DROP COLUMN discarded,
    DROP COLUMN caption,
    DROP COLUMN rate;

COMMIT;
