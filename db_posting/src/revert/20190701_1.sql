-- Revert bcn_is_magic:20190701_1 from pg

BEGIN;

DROP TABLE images;

COMMIT;
