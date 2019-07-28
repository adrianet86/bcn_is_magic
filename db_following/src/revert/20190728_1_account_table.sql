-- Revert db_following:20190728_1_account_table from pg

BEGIN;

DROP TABLE public.accounts;

COMMIT;
