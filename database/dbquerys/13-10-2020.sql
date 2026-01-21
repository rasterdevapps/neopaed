ALTER TABLE "site_settings"
ADD "api_key" text NULL,
ADD "api_user_name" text NULL,
ADD "api_password" text NULL,
ADD "warning_image_path" character varying NULL,
ADD "free_image_path" character varying NULL,
ADD "period" time without time zone Null;
COMMENT ON TABLE "site_settings" IS '';

ALTER TABLE "site_settings"
ADD "custom_toastr" jsonb NULL;
COMMENT ON TABLE "site_settings" IS '';

DROP TABLE IF EXISTS "ward";
DROP SEQUENCE IF EXISTS public.ward_id_seq;
CREATE SEQUENCE public.ward_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."ward" (
    "id" bigint DEFAULT nextval('public.ward_id_seq') NOT NULL,
    "name" text,
    "code" text,
    "doctorids" text,
    "departmentids" text,
    "specialityids" text,
    "branchid" text,
    "organizationid" text,
    "active" boolean,
    "createdDate" time with time zone,
    "createdBy" text,
    "modifiedDate" time with time zone,
    "modifiedBy" text,
    "ward_group_id" bigint
) WITH (oids = false);

INSERT INTO "ward" ("id", "name", "code", "doctorids", "departmentids", "specialityids", "branchid", "organizationid", "active", "createdDate", "createdBy", "modifiedDate", "modifiedBy", "ward_group_id") VALUES
(1,	'NICU',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'10:52:18+05:30',	'8',	'10:52:18+05:30',	'8',	5);

-- 2020-10-13 10:37:14.461352+05:30

-- Adminer 4.7.0 PostgreSQL dump

DROP TABLE IF EXISTS "ward_group";
DROP SEQUENCE IF EXISTS public.ward_group_id_seq;
CREATE SEQUENCE public.ward_group_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."ward_group" (
    "id" bigint DEFAULT nextval('public.ward_group_id_seq') NOT NULL,
    "name" text,
    "code" text,
    "branchid" text,
    "organizationid" text,
    "active" boolean,
    "createdDate" time with time zone,
    "createdBy" bigint,
    "modifiedDate" time with time zone,
    "modifiedBy" bigint,
    "blcok_id" bigint
) WITH (oids = false);

INSERT INTO "ward_group" ("id", "name", "code", "branchid", "organizationid", "active", "createdDate", "createdBy", "modifiedDate", "modifiedBy", "blcok_id") VALUES
(5,	'Neonatal',	NULL,	NULL,	NULL,	NULL,	'11:00:59+05:30',	8,	'10:52:30+05:30',	8,	2);

-- 2020-10-13 10:38:06.56961+05:30


-- Adminer 4.7.0 PostgreSQL dump

DROP TABLE IF EXISTS "room";
DROP SEQUENCE IF EXISTS public.room_id_seq;
CREATE SEQUENCE public.room_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."room" (
    "id" bigint DEFAULT nextval('public.room_id_seq') NOT NULL,
    "number" character varying,
    "doctorid" text,
    "branchid" text,
    "organizationid" text,
    "active" boolean,
    "createdDate" time with time zone,
    "createdBy" text,
    "modifiedDate" time with time zone,
    "modifiedBy" text,
    "ward_id" bigint
) WITH (oids = false);

INSERT INTO "room" ("id", "number", "doctorid", "branchid", "organizationid", "active", "createdDate", "createdBy", "modifiedDate", "modifiedBy", "ward_id") VALUES
(16,	'1',	NULL,	NULL,	NULL,	NULL,	'04:47:56+05:30',	'8',	'04:47:56+05:30',	'8',	1),
(17,	'2',	NULL,	NULL,	NULL,	NULL,	'04:48:43+05:30',	'8',	'04:48:43+05:30',	'8',	1),
(18,	'3',	NULL,	NULL,	NULL,	NULL,	'04:49:11+05:30',	'8',	'04:49:11+05:30',	'8',	1);

-- 2020-10-13 10:39:14.816567+05:30


-- Adminer 4.7.0 PostgreSQL dump

DROP TABLE IF EXISTS "bed";
DROP SEQUENCE IF EXISTS public.bed_id_seq;
CREATE SEQUENCE public.bed_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."bed" (
    "id" bigint DEFAULT nextval('public.bed_id_seq') NOT NULL,
    "number" text,
    "status" text,
    "assetid" text,
    "branchid" text,
    "organizationid" text,
    "room_id" bigint
) WITH (oids = false);

INSERT INTO "bed" ("id", "number", "status", "assetid", "branchid", "organizationid", "room_id") VALUES
(62,	'8',	NULL,	NULL,	NULL,	NULL,	17),
(71,	'17',	'Occupied',	NULL,	NULL,	NULL,	18),
(63,	'9',	NULL,	NULL,	NULL,	NULL,	17),
(66,	'12',	NULL,	NULL,	NULL,	NULL,	17),
(67,	'13',	'Occupied',	NULL,	NULL,	NULL,	17),
(70,	'16',	NULL,	NULL,	NULL,	NULL,	18),
(64,	'10',	NULL,	NULL,	NULL,	NULL,	17),
(65,	'11',	NULL,	NULL,	NULL,	NULL,	17),
(69,	'15',	NULL,	NULL,	NULL,	NULL,	18),
(74,	'20',	NULL,	NULL,	NULL,	NULL,	18),
(72,	'18',	NULL,	NULL,	NULL,	NULL,	18),
(73,	'19',	'',	NULL,	NULL,	NULL,	18),
(61,	'7',	NULL,	NULL,	NULL,	NULL,	17),
(68,	'14',	'Occupied',	NULL,	NULL,	NULL,	17),
(60,	'6',	NULL,	NULL,	NULL,	NULL,	16),
(59,	'5',	NULL,	NULL,	NULL,	NULL,	16),
(58,	'4',	NULL,	NULL,	NULL,	NULL,	16),
(57,	'3',	NULL,	NULL,	NULL,	NULL,	16),
(56,	'2',	NULL,	NULL,	NULL,	NULL,	16),
(55,	'1',	'Occupied',	NULL,	NULL,	NULL,	16);

-- 2020-10-13 10:40:23.94175+05:30


DROP TABLE IF EXISTS "emr_log_hdr";
DROP SEQUENCE IF EXISTS public.emr_log_hdr_id_seq;
CREATE SEQUENCE public.emr_log_hdr_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."emr_log_hdr" (
    "id" numeric DEFAULT nextval('public.emr_log_hdr_id_seq') NOT NULL,
    "intf_id" numeric DEFAULT '0',
    "intf_group_seq_id" numeric DEFAULT '0',
    "sender" character varying(255),
    "sender_time" timestamp,
    "interface_time" timestamp,
    "patient_id" numeric DEFAULT '0',
    "gender" character varying(100),
    "visit_id" numeric DEFAULT '0',
    "visit_date" timestamp,
    "loinc_version" character varying(100),
    "active_flag" character(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "proc_status" character varying(25),
    "app_id" numeric DEFAULT '0',
    "device_id" numeric DEFAULT '0',
    "day_id" bigint,
    "baby_id" bigint,
    "mother_id" bigint,
    "admission_id" bigint,
    "added_nurse" text,
    CONSTRAINT "emr_log_hdr_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

-- Adminer 4.7.0 PostgreSQL dump

DROP TABLE IF EXISTS "fihr_formated_values";
DROP SEQUENCE IF EXISTS fihr_formated_values_id_seq;
CREATE SEQUENCE fihr_formated_values_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."fihr_formated_values" (
    "name" character varying,
    "gender" character varying,
    "birthdate" character varying,
    "mrn" character varying,
    "visit_type" character varying,
    "date" character varying,
    "ip_number" character varying,
    "ward" character varying,
    "room" character varying,
    "bed" character varying,
    "model" character varying,
    "owner" character varying,
    "patient" character varying,
    "manufacturer" character varying,
    "loinc_code" character varying,
    "display" character varying,
    "issued" character varying,
    "status" character varying,
    "low" character varying,
    "first_quartile" character varying,
    "mean" character varying,
    "last_quartile" character varying,
    "close" character varying,
    "value_quality_unit" character varying,
    "id" bigint DEFAULT nextval('fihr_formated_values_id_seq') NOT NULL,
    "is_completed" boolean DEFAULT false NOT NULL,
    "asset_number" character varying,
    "start_time" character varying,
    "end_time" character varying,
    "from_id" character varying,
    "to_id" character varying,
    "snomed_ct" character varying,
    "snomed_code" character varying,
    "advice_id" character varying,
    "is_calculated" boolean DEFAULT false,
    "lab_number" character varying,
    "lab_sample_number" character varying,
    "range_low" character varying,
    "range_high" character varying
) WITH (oids = false);


DROP TABLE IF EXISTS "fihr_json_schema";
DROP SEQUENCE IF EXISTS public.fihr_json_schema_id_seq;
CREATE SEQUENCE public.fihr_json_schema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."fihr_json_schema" (
    "id" bigint DEFAULT nextval('public.fihr_json_schema_id_seq') NOT NULL,
    "resource_type" character varying,
    "resource_schema" text,
    "version" character varying
) WITH (oids = false);


DROP TABLE IF EXISTS "interface_machine";
DROP SEQUENCE IF EXISTS interface_machine_id_seq;
CREATE SEQUENCE interface_machine_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."interface_machine" (
    "id" bigint DEFAULT nextval('interface_machine_id_seq') NOT NULL,
    "received" jsonb,
    "received_time" time without time zone,
    "is_parsed" boolean DEFAULT false,
    "received_ip" character varying,
    "received_date" date,
    "device_type" character varying,
    "received_datetime" timestamp DEFAULT now(),
    "is_lab_value" boolean DEFAULT false
) WITH (oids = false);


DROP TABLE IF EXISTS "loinc_class_type_master";
DROP SEQUENCE IF EXISTS public.loinc_class_type_id_seq;
CREATE SEQUENCE public.loinc_class_type_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc_class_type_master" (
    "id" numeric DEFAULT nextval('public.loinc_class_type_id_seq') NOT NULL,
    "class_type_id" character varying(100) NOT NULL,
    "class_type_desc" character varying(100) NOT NULL,
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    CONSTRAINT "loinc_class_type_master_pk" PRIMARY KEY ("id"),
    CONSTRAINT "loinc_class_type_master_uk1" UNIQUE ("class_type_id"),
    CONSTRAINT "loinc_class_type_master_uk2" UNIQUE ("class_type_desc")
) WITH (oids = false);


DROP TABLE IF EXISTS "loinc_local_code_map_261";
DROP SEQUENCE IF EXISTS public.loinc_local_code_map_id_seq;
CREATE SEQUENCE public.loinc_local_code_map_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc_local_code_map_261" (
    "id" numeric DEFAULT nextval('public.loinc_local_code_map_id_seq') NOT NULL,
    "ref_loc_master_id" numeric DEFAULT '0' NOT NULL,
    "loinc_code" character varying(100),
    "loinc_version" character varying(100),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "device_map_flag" character varying(1),
    "loinc_component_description" character varying(255),
    "snomed_ct" text,
    "snomed_code" character varying
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fk_chk_loinc_06_trg" AFTER INSERT OR UPDATE ON "public"."loinc_local_code_map_261" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_chk_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_local_code_map_263";
DROP SEQUENCE IF EXISTS public.loinc_local_code_map_id_seq;
CREATE SEQUENCE public.loinc_local_code_map_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc_local_code_map_263" (
    "id" numeric DEFAULT nextval('public.loinc_local_code_map_id_seq') NOT NULL,
    "ref_loc_master_id" numeric DEFAULT '0' NOT NULL,
    "loinc_code" character varying(100),
    "loinc_version" character varying(100),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "device_map_flag" character varying(1),
    "loinc_component_description" character varying(255),
    "snomed_ct" text,
    "snomed_code" character varying
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fk_chk_loinc_07_trg" AFTER INSERT OR UPDATE ON "public"."loinc_local_code_map_263" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_chk_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_local_code_map_part";
DROP SEQUENCE IF EXISTS public.loinc_local_code_map_id_seq;
CREATE SEQUENCE public.loinc_local_code_map_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc_local_code_map_part" (
    "id" numeric DEFAULT nextval('public.loinc_local_code_map_id_seq') NOT NULL,
    "ref_loc_master_id" numeric DEFAULT '0' NOT NULL,
    "loinc_code" character varying(100),
    "loinc_version" character varying(100),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "device_map_flag" character varying(1),
    "loinc_component_description" character varying(255),
    "snomed_ct" text,
    "snomed_code" character varying,
    CONSTRAINT "loinc_local_code_map_part_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "fk_loinc_local_code_map_part_cons" FOREIGN KEY (ref_loc_master_id) REFERENCES local_code_group(id) NOT DEFERRABLE
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "ins_part_loinc_local_code_map_trgr" BEFORE INSERT ON "public"."loinc_local_code_map_part" FOR EACH ROW EXECUTE PROCEDURE loinc_local_code_map_part_ins_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_version";
DROP SEQUENCE IF EXISTS public.loinc_version_id_seq;
CREATE SEQUENCE public.loinc_version_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc_version" (
    "id" numeric DEFAULT nextval('public.loinc_version_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "version" character varying(50) NOT NULL,
    "description" character varying(250),
    "active_flag" character varying(1) NOT NULL,
    "start_tstamp" timestamp,
    "end_tstamp" timestamp,
    "create_user_id" character varying(50),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(50),
    "modify_tstamp" timestamp,
    CONSTRAINT "loinc_version_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "mas_drugs_and_insfusion";
DROP SEQUENCE IF EXISTS public."mas_drugs_and_insfusion_Id_seq";
CREATE SEQUENCE public."mas_drugs_and_insfusion_Id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_drugs_and_insfusion" (
    "Id" integer DEFAULT nextval('public."mas_drugs_and_insfusion_Id_seq"') NOT NULL,
    "Name" character varying(250),
    "Value" character varying(20),
    "Status" character varying(20),
    "DateAdded" timestamp(0),
    "DateModified" timestamp(0),
    "UserAdded" integer,
    "IsDeleted" character varying(255) DEFAULT '0' NOT NULL,
    "UserDeleted" integer,
    "UserModified" integer,
    "drug_group_id" integer,
    "generic_name" text,
    "concept_id" character varying,
    CONSTRAINT "mas_drugs_and_insfusion_pkey" PRIMARY KEY ("Id")
) WITH (oids = false);


DROP TABLE IF EXISTS "mas_investigation";
DROP SEQUENCE IF EXISTS public.mas_investigation_id_seq;
CREATE SEQUENCE public.mas_investigation_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_investigation" (
    "Id" bigint DEFAULT nextval('public.mas_investigation_id_seq') NOT NULL,
    "Name" character varying,
    "Status" character varying,
    "UserAdded" integer,
    "UserModified" integer,
    "UserDeleted" integer,
    "IsDeleted" boolean DEFAULT false,
    "DateAdded" date,
    "DateModified" date,
    "code" character varying,
    "hms_key" character varying
) WITH (oids = false);


DROP TABLE IF EXISTS "mas_ivfluid";
DROP SEQUENCE IF EXISTS public.mas_ivfluid_id_seq;
CREATE SEQUENCE public.mas_ivfluid_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_ivfluid" (
    "id" bigint DEFAULT nextval('public.mas_ivfluid_id_seq') NOT NULL,
    "name" text,
    "status" integer,
    "IsDeleted" integer,
    "UserAdded" integer,
    "DateAdded" time with time zone,
    "UserDeleted" integer,
    "UserModified" integer,
    "DateModified" time with time zone,
    "pharmacological_name" text,
    "group_id" bigint,
    "drug_library" text
) WITH (oids = false);


-- 2020-10-13 11:35:45.328771+05:30
