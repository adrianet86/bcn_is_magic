-- Deploy bcn_is_magic:20190708_1 to pg

BEGIN;
-- ADD required extension to generate UUIDs
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE public.search_terms
(
    id   UUID PRIMARY KEY,
    term VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- TODO: remove inserts from this repo ¿? Should be place in a different insert sql file¿?
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona');
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona beach');
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona architecture');
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona food');
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona style');
INSERT INTO public.search_terms VALUES(uuid_generate_v4(), 'barcelona history');

COMMIT;
