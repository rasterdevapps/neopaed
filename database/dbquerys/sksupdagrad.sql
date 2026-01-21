
DROP TABLE IF EXISTS "summary_statement";
DROP SEQUENCE IF EXISTS summary_statement_id_seq;
CREATE SEQUENCE summary_statement_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."summary_statement" (
    "id" bigint DEFAULT nextval('summary_statement_id_seq') NOT NULL,
    "statements" text,
    "word_split_up" json
) WITH (oids = false);


DROP TABLE IF EXISTS "mas_collection_method";
DROP SEQUENCE IF EXISTS mas_collection_method_id_seq;
CREATE SEQUENCE mas_collection_method_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_collection_method" (
    "id" integer DEFAULT nextval('mas_collection_method_id_seq') NOT NULL,
    "name" character varying,
    "status" boolean,
    "UserAdded" integer,
    "UserModified" integer,
    "UserDeleted" integer,
    "DateAdded" timestamp,
    "DateModified" timestamp,
    "IsDeleted" character varying DEFAULT '0',
    CONSTRAINT "mas_collection_method_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "bed";
DROP SEQUENCE IF EXISTS bed_id_seq;
CREATE SEQUENCE bed_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."bed" (
    "id" bigint DEFAULT nextval('bed_id_seq') NOT NULL,
    "number" text,
    "status" text,
    "assetid" text,
    "branchid" text,
    "organizationid" text,
    "room_id" bigint
) WITH (oids = false);


DROP TABLE IF EXISTS "block";
DROP SEQUENCE IF EXISTS block_id_seq;
CREATE SEQUENCE block_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."block" (
    "id" bigint DEFAULT nextval('block_id_seq') NOT NULL,
    "name" text,
    "code" character varying,
    "default" boolean,
    "departmentids" text,
    "specialityids" text,
    "branchid" text,
    "organizationid" text,
    "active" boolean,
    "createdDate" time with time zone,
    "createdBy" bigint,
    "modifiedDate" time with time zone,
    "modifiedBy" bigint
) WITH (oids = false);



DROP TABLE IF EXISTS "asset";
DROP SEQUENCE IF EXISTS asset_id_seq;
CREATE SEQUENCE asset_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."asset" (
    "id" bigint DEFAULT nextval('asset_id_seq') NOT NULL,
    "type" text,
    "manufacturer" text,
    "price" double precision,
    "branchid" text,
    "organizationid" text
) WITH (oids = false);

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
    "number" character varying,
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
    "id" bigint DEFAULT nextval('fihr_formated_values_id_seq') NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "fihr_json_schema";
DROP SEQUENCE IF EXISTS fihr_json_schema_id_seq;
CREATE SEQUENCE fihr_json_schema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."fihr_json_schema" (
    "id" bigint DEFAULT nextval('fihr_json_schema_id_seq') NOT NULL,
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
    "received_ip" character varying
) WITH (oids = false);


DROP TABLE IF EXISTS "patient_bed_log";
DROP SEQUENCE IF EXISTS patient_bed_log_id_seq;
CREATE SEQUENCE patient_bed_log_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."patient_bed_log" (
    "id" bigint DEFAULT nextval('patient_bed_log_id_seq') NOT NULL,
    "ward_id" bigint,
    "ward_name" character varying,
    "room_id" bigint,
    "room_no" character varying,
    "bed_no" character varying,
    "baby_id" bigint,
    "admission_id" bigint,
    "DateAdded" time with time zone,
    "UserAdded" bigint,
    "DateModified" time with time zone,
    "UserModified" bigint,
    "IsDeleted" smallint,
    "bed_id" bigint
) WITH (oids = false);


DROP TABLE IF EXISTS "patient_ip_visit";
DROP SEQUENCE IF EXISTS patient_ip_visit_id_seq;
CREATE SEQUENCE patient_ip_visit_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."patient_ip_visit" (
    "id" bigint DEFAULT nextval('patient_ip_visit_id_seq') NOT NULL,
    "ip_number" text,
    "patientid" bigint,
    "status" character varying,
    "referral_type_id" bigint,
    "referral_id" bigint,
    "primary_consultant_id" bigint,
    "secondary_consultant_id" bigint,
    "departmentid" bigint,
    "guardian_name" text,
    "guardian_mobile_number" text,
    "desired_room_type" boolean,
    "desired_room_type_id" bigint,
    "gender_based" boolean,
    "insurance_id" bigint,
    "policy_number" text,
    "valid_unit" text,
    "insurance_notes" text,
    "insurance_file_path" text,
    "claim_for_self" boolean,
    "relationshipid" bigint,
    "corporateid" bigint,
    "employee_name" text,
    "employee_code" text,
    "medicol_legal_case" boolean,
    "fir_number" text,
    "fir_copy_file_path" text,
    "accident_case" boolean,
    "createdby" bigint,
    "created_date" time with time zone,
    "modified_by" bigint,
    "modified_date" time with time zone
) WITH (oids = false);


DROP TABLE IF EXISTS "recorded_audio_history";
DROP SEQUENCE IF EXISTS recorded_audio_history_id_seq;
CREATE SEQUENCE recorded_audio_history_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."recorded_audio_history" (
    "id" bigint DEFAULT nextval('recorded_audio_history_id_seq') NOT NULL,
    "baby_id" bigint,
    "module_id" bigint,
    "admission_id" bigint,
    "audio_file_name" text,
    "field_id" text,
    "UserAdded" integer,
    "DateAdded" timestamp,
    "audio_file" text,
    "converted_text" text,
    "module_slug" text,
    "files_zipped" boolean DEFAULT false NOT NULL,
    "file_opened" boolean,
    "file_opened_by" bigint
) WITH (oids = false);


DROP TABLE IF EXISTS "room";
DROP SEQUENCE IF EXISTS room_id_seq;
CREATE SEQUENCE room_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."room" (
    "id" bigint DEFAULT nextval('room_id_seq') NOT NULL,
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


DROP TABLE IF EXISTS "room_type";
DROP SEQUENCE IF EXISTS room_type_id_seq;
CREATE SEQUENCE room_type_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."room_type" (
    "id" bigint DEFAULT nextval('room_type_id_seq') NOT NULL,
    "name" text,
    "price_book_id" bigint
) WITH (oids = false);


DROP TABLE IF EXISTS "search_log";
DROP SEQUENCE IF EXISTS search_log_id_seq;
CREATE SEQUENCE search_log_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."search_log" (
    "id" bigint DEFAULT nextval('search_log_id_seq') NOT NULL,
    "query" text,
    "bindings" text,
    "time" character varying,
    "search_module" smallint NOT NULL
) WITH (oids = false);

COMMENT ON COLUMN "public"."search_log"."search_module" IS '1 - neonatal_proforma ';


DROP TABLE IF EXISTS "snomed_map_local_column";
DROP SEQUENCE IF EXISTS snomed_map_local_column_id_seq;
CREATE SEQUENCE snomed_map_local_column_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."snomed_map_local_column" (
    "id" bigint DEFAULT nextval('snomed_map_local_column_id_seq') NOT NULL,
    "table_name" character varying,
    "schema" character varying,
    "column_name" character varying,
    "snomed_code" character varying,
    "loinc_code" character varying
) WITH (oids = false);

DROP TABLE IF EXISTS "waiting_list";
CREATE TABLE "public"."waiting_list" (
    "id" bigint,
    "patientid" bigint,
    "genderBased" boolean,
    "specialitywise" boolean,
    "desired_room_type_id" bigint,
    "current_ward_id" bigint,
    "roomstatus" text,
    "status" text,
    "waiting_time" character varying,
    "branchid" bigint,
    "organizationid" bigint
) WITH (oids = false);


DROP TABLE IF EXISTS "ward";
DROP SEQUENCE IF EXISTS ward_id_seq;
CREATE SEQUENCE ward_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."ward" (
    "id" bigint DEFAULT nextval('ward_id_seq') NOT NULL,
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


DROP TABLE IF EXISTS "ward_group";
DROP SEQUENCE IF EXISTS ward_group_id_seq;
CREATE SEQUENCE ward_group_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."ward_group" (
    "id" bigint DEFAULT nextval('ward_group_id_seq') NOT NULL,
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
(5, 'Neonatal', NULL,   NULL,   NULL,   NULL,   '11:00:59+05:30',   8,  '11:00:59+05:30',   8,  2);

DROP TABLE IF EXISTS "loinc_reference_nurse";
CREATE TABLE "public"."loinc_reference_nurse" (
    "loinc_code" character varying(100),
    "component" character varying(500),
    "property" character varying(100),
    "time_aspct" character varying(100),
    "system" character varying(500),
    "scale_typ" character varying(100),
    "method_typ" character varying(100),
    "class" character varying(100),
    "versionlastchanged" character varying(100),
    "chng_type" character varying(100),
    "definitiondescription" text,
    "status" character varying(100),
    "consumer_name" character varying(500),
    "classtype" numeric,
    "formula" text,
    "species" character varying(100),
    "exmpl_answers" text,
    "survey_quest_text" text,
    "survey_quest_src" character varying(100),
    "unitsrequired" character varying(100),
    "submitted_units" character varying(100),
    "relatednames2" text,
    "shortname" character varying(500),
    "order_obs" character varying(100),
    "cdisc_common_tests" character varying(100),
    "hl7_field_subfield_id" character varying(100),
    "external_copyright_notice" text,
    "example_units" character varying(500),
    "long_common_name" character varying(500),
    "unitsandrange" text,
    "document_section" character varying(500),
    "example_ucum_units" character varying(500),
    "example_si_ucum_units" character varying(500),
    "status_reason" character varying(100),
    "status_text" text,
    "change_reason_public" text,
    "common_test_rank" numeric,
    "common_order_rank" numeric,
    "common_si_test_rank" numeric,
    "hl7_attachment_structure" character varying(100),
    "externalcopyrightlink" character varying(500),
    "paneltype" character varying(100),
    "askatorderentry" character varying(500),
    "associatedobservations" character varying(500),
    "versionfirstreleased" character varying(100),
    "validhl7attachmentrequest" character varying(100),
    "ucum_code" character varying(100),
    "deprecated_flag" character varying(1),
    "loinc_version" character varying(100),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "class_type_id" numeric,
    "ref_loc_master_id" numeric,
    "local_code" character varying(100)
) WITH (oids = false);

DROP TABLE IF EXISTS "max_values_nurse";
CREATE TABLE "public"."max_values_nurse" (
    "local_code" character varying(100),
    "intf_ref_value" text,
    "baby_id" bigint,
    "admission_id" bigint
) WITH (oids = false);

CREATE OR REPLACE VIEW public.snomed_nurse_reference AS 
 SELECT loinc_part.loinc_code,
    loinc_part.component,
    loinc_part.property,
    loinc_part.time_aspct,
    loinc_part.system,
    loinc_part.scale_typ,
    loinc_part.method_typ,
    loinc_part.class,
    loinc_part.versionlastchanged,
    loinc_part.chng_type,
    loinc_part.definitiondescription,
    loinc_part.status,
    loinc_part.consumer_name,
    loinc_part.classtype,
    loinc_part.formula,
    loinc_part.species,
    loinc_part.exmpl_answers,
    loinc_part.survey_quest_text,
    loinc_part.survey_quest_src,
    loinc_part.unitsrequired,
    loinc_part.submitted_units,
    loinc_part.relatednames2,
    loinc_part.shortname,
    loinc_part.order_obs,
    loinc_part.cdisc_common_tests,
    loinc_part.hl7_field_subfield_id,
    loinc_part.external_copyright_notice,
    loinc_part.example_units,
    loinc_part.long_common_name,
    loinc_part.unitsandrange,
    loinc_part.document_section,
    loinc_part.example_ucum_units,
    loinc_part.example_si_ucum_units,
    loinc_part.status_reason,
    loinc_part.status_text,
    loinc_part.change_reason_public,
    loinc_part.common_test_rank,
    loinc_part.common_order_rank,
    loinc_part.common_si_test_rank,
    loinc_part.hl7_attachment_structure,
    loinc_part.externalcopyrightlink,
    loinc_part.paneltype,
    loinc_part.askatorderentry,
    loinc_part.associatedobservations,
    loinc_part.versionfirstreleased,
    loinc_part.validhl7attachmentrequest,
    loinc_part.ucum_code,
    loinc_part.deprecated_flag,
    loinc_part.loinc_version,
    loinc_part.active_flag,
    loinc_part.create_user_id,
    loinc_part.create_tstamp,
    loinc_part.modify_user_id,
    loinc_part.modify_tstamp,
    loinc_part.class_type_id,
    loinc_local_code_map_part.ref_loc_master_id,
    local_code_group.local_code,
    loinc_local_code_map_part.snomed_ct
   FROM local_code_group
     JOIN loinc_local_code_map_part ON loinc_local_code_map_part.ref_loc_master_id = local_code_group.id
     JOIN loinc_part ON loinc_part.loinc_code::text = loinc_local_code_map_part.loinc_code::text AND loinc_part.loinc_version::text = loinc_local_code_map_part.loinc_version::text;

ALTER TABLE public.snomed_nurse_reference
  OWNER TO postgres;
