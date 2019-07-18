-- Revert bcn_is_magic:20190708_1 from pg

BEGIN;

DROP TABLE public.search_terms;

COMMIT;
