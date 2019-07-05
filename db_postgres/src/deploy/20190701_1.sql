-- Deploy bcn_is_magic:20190701_1 to pg

BEGIN;

CREATE TABLE public.images(
    id UUID PRIMARY KEY,
    created_at TIMESTAMP NOT NULL,
    provider_id VARCHAR(255) NOT NULL,
    provider VARCHAR(150) NOT NULL,
    provider_url VARCHAR(255) NOT NULL,
    path VARCHAR(255),
    description VARCHAR(255),
    likes INTEGER,
    number_of_comments INTEGER,
    author VARCHAR(150),
    tags JSONB
);

CREATE INDEX image_provider_idx ON public.images (provider);

CREATE INDEX image_provider_id_idx ON public.images (provider_id);

COMMIT;
