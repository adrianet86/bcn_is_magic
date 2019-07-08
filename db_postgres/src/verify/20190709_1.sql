-- Verify bcn_is_magic:20190709_1 on pg

BEGIN;

SELECT * FROM images WHERE false;

ROLLBACK;
