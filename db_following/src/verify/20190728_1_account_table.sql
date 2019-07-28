-- Verify db_following:20190728_1_account_table on pg

BEGIN;

SELECT * FROM public.accounts;

ROLLBACK;
