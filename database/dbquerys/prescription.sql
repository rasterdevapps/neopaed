DROP TABLE IF EXISTS "nurse_other_iv_drugs";
CREATE SEQUENCE public.nurse_other_iv_drugs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."nurse_other_iv_drugs" (
    "other_iv_drugs_day" character varying,
    "other_iv_drugs_brandname" character varying,
    "other_iv_drugs_pharmacological" character varying,
    "other_iv_drugs_dose_required" character varying,
    "other_iv_drugs_frequency" character varying,
    "other_iv_drugs_syringe" character varying,
    "other_iv_drugs_additional" character varying,
    "other_iv_drugs_date_prescribed" date,
    "other_iv_drugs_time_prescribed" time without time zone,
    "other_iv_drugs_date_stopped" date,
    "other_iv_drugs_time_stopped" time without time zone,
    "baby_id" bigint,
    "admission_id" bigint,
    "mother_id" bigint,
    "day_id" bigint,
    "id" bigint DEFAULT nextval('public.nurse_other_iv_drugs_id_seq') NOT NULL,
    "IsDeleted" smallint DEFAULT 0 NOT NULL,
    "is_send" smallint DEFAULT 0 NOT NULL,
    "order_status" character varying DEFAULT RE NOT NULL,
    "infusion_type" character varying DEFAULT IV NOT NULL,
    "repeat_pattern" character varying,
    "reapat_start_time" character varying,
    "other_iv_drugs_rate" character varying,
    "other_iv_drugs_dose_units_g" character varying
) WITH (oids = false);


INSERT INTO "config_settings" ("id", "slug_code", "code_values", "status") VALUES
(44,    'DRUG_NAME_SNOMED_CT',  '430033006+410942007',  't'),
(45,    'INFUSED_SNOMED_CT',    '430033006+260507000+118565006',    't'),
(46,    'REMAINING_SNOMED_CT',  '430033006+418060005+262095001+118565006',  't'),
(47,    'VTBI_SNOMED_CT',   '430033006+118565006',  't'),
(48,    'RATE_SNOMED_CT',   '430033006+118544000',  't'),
(49,    'RUNNING_PRESSURE_SNOMED_CT',   '430033006+257893003',  't'),
(50,    'PROGRAMME_PRESSURE_SNOMED_CT', '430033006+386399006+257893003',    't');



DROP TABLE IF EXISTS "appointment_details";

CREATE TABLE "public"."appointment_details" (
    "category" text,
    "date" date,
    "review_time" text,
    "review_min" text,
    "review_session" text,
    "duration" text,
    "title" text,
    "status" text,
    "pdid" bigint DEFAULT nextval('public.patient_details_pdid_seq') NOT NULL,
    "consultant" integer,
    "reason" text,
    "appointmentDate" date,
    "new_review_time" integer,
    "new_review_min" integer,
    "new_review_session" text,
    "ref_op_id" integer,
    "patient" text,
    CONSTRAINT "pdid" PRIMARY KEY ("pdid")
) WITH (oids = false);

ALTER TABLE nurse_other_iv_drugs
DROP COLUMN repeat_prescription;
