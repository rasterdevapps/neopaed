-- Adminer 4.3.1 PostgreSQL dump

DROP TABLE IF EXISTS "prescription";
CREATE SEQUENCE prescription_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."prescription" (
    "id" bigint DEFAULT nextval('prescription_id_seq') NOT NULL,
    "prescription_id" character varying NOT NULL,
    "result_time" timestamp NOT NULL,
    "infused" character varying,
    "infused_snomed_code" character varying,
    "rate" character varying,
    "rate_snomed_code" character varying,
    "remain_volume" character varying,
    "remain_volume_snomed_code" character varying,
    "remain_time" character varying,
    "remain_time_snomed_code" character varying,
    "pressure" integer,
    "pressure_snomed_code" character varying,
    "pressure_level" integer,
    "pressure_level_snomed_code" character varying,
    "status" integer,
    "status_snomed_code" character varying,
    "created_date_time" timestamp NOT NULL,
    "created_user" character varying NOT NULL,
    CONSTRAINT "prescription_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2021-01-27 11:09:08.613224+05:30