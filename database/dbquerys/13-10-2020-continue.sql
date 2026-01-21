-- Adminer 4.7.0 PostgreSQL dump

DROP TABLE IF EXISTS "appointment_details";
DROP SEQUENCE IF EXISTS patient_details_pdid_seq;
CREATE SEQUENCE patient_details_pdid_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."appointment_details" (
    "category" text,
    "date" date,
    "review_time" text,
    "review_min" text,
    "review_session" text,
    "duration" text,
    "title" text,
    "status" text,
    "pdid" bigint DEFAULT nextval('patient_details_pdid_seq') NOT NULL,
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


DROP TABLE IF EXISTS "block";
DROP SEQUENCE IF EXISTS public.block_id_seq;
CREATE SEQUENCE public.block_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."block" (
    "id" bigint DEFAULT nextval('public.block_id_seq') NOT NULL,
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

INSERT INTO "block" ("id", "name", "code", "default", "departmentids", "specialityids", "branchid", "organizationid", "active", "createdDate", "createdBy", "modifiedDate", "modifiedBy") VALUES
(2,	'Block A',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'11:00:59+05:30',	8,	'11:00:59+05:30',	8);

DROP TABLE IF EXISTS "concept_f";
CREATE TABLE "public"."concept_f" (
    "id" character varying(20) NOT NULL,
    "effectivetime" character(20) NOT NULL,
    "active" character(20) NOT NULL,
    "moduleid" character varying(20) NOT NULL,
    "definitionstatusid" character varying(20) NOT NULL,
    CONSTRAINT "concept_f_pkey" PRIMARY KEY ("id", "effectivetime")
) WITH (oids = false);


DROP TABLE IF EXISTS "description_f";
CREATE TABLE "public"."description_f" (
    "id" character varying(20) NOT NULL,
    "effectivetime" character(20) NOT NULL,
    "active" character(20) NOT NULL,
    "moduleid" character varying(20) NOT NULL,
    "conceptid" character varying(20) NOT NULL,
    "languagecode" character varying(20) NOT NULL,
    "typeid" character varying(20) NOT NULL,
    "term" text NOT NULL,
    "casesignificanceid" character varying(20) NOT NULL,
    CONSTRAINT "description_f_pkey" PRIMARY KEY ("id", "effectivetime")
) WITH (oids = false);

CREATE INDEX "description_conceptid_idx" ON "public"."description_f" USING btree ("conceptid");


DROP TABLE IF EXISTS "emr_config_group";
DROP SEQUENCE IF EXISTS public.emr_config_group_id_seq;
CREATE SEQUENCE public.emr_config_group_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."emr_config_group" (
    "id" numeric DEFAULT nextval('public.emr_config_group_id_seq') NOT NULL,
    "config_group_name" character varying(100) NOT NULL,
    "description" character varying(500),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    CONSTRAINT "emr_config_group_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "emr_config_value";
DROP SEQUENCE IF EXISTS public.emr_config_value_id_seq;
CREATE SEQUENCE public.emr_config_value_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."emr_config_value" (
    "id" numeric DEFAULT nextval('public.emr_config_value_id_seq') NOT NULL,
    "config_group_id" numeric DEFAULT '0' NOT NULL,
    "config_name" character varying(100) NOT NULL,
    "config_char_value" character varying(100),
    "config_numeric_value" numeric DEFAULT '0' NOT NULL,
    "description" character varying(500),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    CONSTRAINT "emr_config_value_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "fk_emr_config_value_cons1" FOREIGN KEY (config_group_id) REFERENCES emr_config_group(id) NOT DEFERRABLE
) WITH (oids = false);


DROP TABLE IF EXISTS "emr_log_dtl";
DROP SEQUENCE IF EXISTS public.emr_log_dtl_id_seq;
CREATE SEQUENCE public.emr_log_dtl_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."emr_log_dtl" (
    "id" numeric DEFAULT nextval('public.emr_log_dtl_id_seq') NOT NULL,
    "log_hdr_id" numeric DEFAULT '0' NOT NULL,
    "emr_intf_data_id" numeric DEFAULT '0' NOT NULL,
    "loinc_local_map_id" numeric DEFAULT '0' NOT NULL,
    "loinc_code" character varying(100),
    "loinc_version" character varying(100),
    "intf_ref_name" character varying(100) NOT NULL,
    "intf_ref_value" character varying(100) DEFAULT '0',
    "component" character varying(100),
    "property" character varying(100),
    "time" character varying(100),
    "system" character varying(100),
    "scale" character varying(100),
    "method" character varying(100),
    "classtype" numeric DEFAULT '0',
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "device_parameter_map_id" numeric DEFAULT '0' NOT NULL,
    "observation_type_id" bigint DEFAULT '0',
    "emr_vendor_ans_list_map_id" integer DEFAULT '0',
    "intf_ref_code" character varying(100),
    "is_calulated" boolean DEFAULT false,
    CONSTRAINT "emr_log_dtl_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "fk_emr_log_dtl_cons1" FOREIGN KEY (log_hdr_id) REFERENCES emr_log_hdr(id) NOT DEFERRABLE
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fk_chk_loinc_02_trg" AFTER INSERT OR UPDATE ON "public"."emr_log_dtl" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_chk_fn();;

CREATE TRIGGER "fk_chk_loinc_local_01_trg" AFTER INSERT OR UPDATE ON "public"."emr_log_dtl" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_local_code_map_chk_fn();;

DELIMITER ;

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


DROP TABLE IF EXISTS "interface_machine_status";
DROP SEQUENCE IF EXISTS public.interface_machine_status_id_seq;
CREATE SEQUENCE public.interface_machine_status_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."interface_machine_status" (
    "id" bigint DEFAULT nextval('public.interface_machine_status_id_seq') NOT NULL,
    "mrn" character varying,
    "visit_number" character varying,
    "baby_name" character varying,
    "hospital_name" character varying,
    "date_time" time without time zone,
    "device_name" character varying,
    "request_ip_number" character varying,
    "received_datetime" timestamp DEFAULT now(),
    "issued_date_time" timestamp
) WITH (oids = false);


DROP TABLE IF EXISTS "lab_request";
DROP SEQUENCE IF EXISTS public.lab_request_id_seq;
CREATE SEQUENCE public.lab_request_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."lab_request" (
    "id" integer DEFAULT nextval('public.lab_request_id_seq') NOT NULL,
    "baby_id" integer,
    "department" character varying,
    "collection_site" character varying,
    "collection_method" character varying,
    "test_date" date,
    "symptoms" character varying,
    "diagnosis" character varying,
    "credit" boolean,
    "stat" boolean,
    "scheduled" boolean,
    "investigations" character varying,
    "procedure_name" character varying,
    "order_physician" character varying,
    "admission_time" character varying,
    "admissiontime_mins" character varying,
    "admissiontime_sesstion" character varying,
    "is_send" boolean DEFAULT false NOT NULL,
    "scheduled_date" date,
    "scheduled_time" character varying,
    "scheduled_mins" character varying,
    "scheduled_sesstion" character varying,
    "IsDeleted" boolean DEFAULT false,
    "associate_doctor" character varying,
    "is_send_mirth" boolean DEFAULT false,
    "is_processed" boolean DEFAULT false,
    "request_id" bigint,
    CONSTRAINT "lab_request_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "local_code_group";
DROP SEQUENCE IF EXISTS public.local_code_master_id_seq;
CREATE SEQUENCE public.local_code_master_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."local_code_group" (
    "id" numeric DEFAULT nextval('public.local_code_master_id_seq') NOT NULL,
    "local_code" character varying(100),
    "local_description" character varying(500),
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "local_code_parent_id" integer,
    CONSTRAINT "local_code_master_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "local_code_master_ukey" UNIQUE ("local_code")
) WITH (oids = false);


DROP TABLE IF EXISTS "loinc";
DROP SEQUENCE IF EXISTS public.loinc_loinc_id_seq;
CREATE SEQUENCE public.loinc_loinc_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."loinc" (
    "loinc_num" character varying NOT NULL,
    "component" character varying,
    "property" character varying,
    "time_aspct" character varying,
    "system" character varying,
    "scale_typ" character varying,
    "method_typ" character varying,
    "class" character varying,
    "VersionLastChanged" character varying,
    "chng_type" character varying,
    "DefinitionDescription" text,
    "status" character varying,
    "consumer_name" character varying,
    "classtype" integer,
    "formula" text,
    "species" character varying,
    "exmpl_answers" text,
    "survey_quest_text" text,
    "survey_quest_src" character varying,
    "unitsrequired" character varying,
    "submitted_units" character varying,
    "relatednames2" text,
    "shortname" character varying,
    "order_obs" character varying,
    "cdisc_common_tests" character varying,
    "hl7_field_subfield_id" character varying,
    "external_copyright_notice" text,
    "example_units" character varying,
    "long_common_name" character varying,
    "UnitsAndRange" text,
    "document_section" character varying,
    "example_ucum_units" character varying,
    "example_si_ucum_units" character varying,
    "status_reason" character varying,
    "status_text" text,
    "change_reason_public" text,
    "common_test_rank" integer,
    "common_order_rank" integer,
    "common_si_test_rank" integer,
    "hl7_attachment_structure" character varying,
    "ExternalCopyrightLink" character varying,
    "PanelType" character varying,
    "AskAtOrderEntry" character varying,
    "AssociatedObservations" character varying,
    "VersionFirstReleased" character varying,
    "ValidHL7AttachmentRequest" character varying,
    "loinc_id" bigint DEFAULT nextval('public.loinc_loinc_id_seq') NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "loinc_261";
CREATE TABLE "public"."loinc_261" (
    "loinc_code" character varying(100) NOT NULL,
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
    "classtype" numeric DEFAULT '0',
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
    "common_test_rank" numeric DEFAULT '0',
    "common_order_rank" numeric DEFAULT '0',
    "common_si_test_rank" numeric DEFAULT '0',
    "hl7_attachment_structure" character varying(100),
    "externalcopyrightlink" character varying(500),
    "paneltype" character varying(100),
    "askatorderentry" character varying(500),
    "associatedobservations" character varying(500),
    "versionfirstreleased" character varying(100),
    "validhl7attachmentrequest" character varying(100),
    "ucum_code" character varying(100),
    "deprecated_flag" character varying(1),
    "loinc_version" character varying(100) NOT NULL,
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "class_type_id" numeric DEFAULT '0'
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fkey_loinc_261_trgr" AFTER INSERT OR DELETE OR UPDATE ON "public"."loinc_261" FOR EACH ROW EXECUTE PROCEDURE loinc_part_fkey_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_263";
CREATE TABLE "public"."loinc_263" (
    "loinc_code" character varying(100) NOT NULL,
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
    "classtype" numeric DEFAULT '0',
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
    "common_test_rank" numeric DEFAULT '0',
    "common_order_rank" numeric DEFAULT '0',
    "common_si_test_rank" numeric DEFAULT '0',
    "hl7_attachment_structure" character varying(100),
    "externalcopyrightlink" character varying(500),
    "paneltype" character varying(100),
    "askatorderentry" character varying(500),
    "associatedobservations" character varying(500),
    "versionfirstreleased" character varying(100),
    "validhl7attachmentrequest" character varying(100),
    "ucum_code" character varying(100),
    "deprecated_flag" character varying(1),
    "loinc_version" character varying(100) NOT NULL,
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "class_type_id" numeric DEFAULT '0'
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fkey_loinc_263_trgr" AFTER INSERT OR DELETE OR UPDATE ON "public"."loinc_263" FOR EACH ROW EXECUTE PROCEDURE loinc_part_fkey_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_answer_list";
CREATE TABLE "public"."loinc_answer_list" (
    "AnswerListId" text,
    "AnswerListName" text,
    "AnswerListOID" text,
    "ExtDefinedYN" text,
    "ExtDefinedAnswerListCodeSystem" text,
    "ExtDefinedAnswerListLink" text,
    "AnswerStringId" text,
    "LocalAnswerCode" text,
    "LocalAnswerCodeSystem" text,
    "SequenceNumber" text,
    "DisplayText" text,
    "ExtCodeId" text,
    "ExtCodeDisplayName" text,
    "ExtCodeSystem" text,
    "ExtCodeSystemVersion" text,
    "ExtCodeSystemCopyrightNotice" text,
    "SubsequentTextPrompt" text,
    "Description" text,
    "Score" text
) WITH (oids = false);


DROP TABLE IF EXISTS "loinc_answer_list_link";
CREATE TABLE "public"."loinc_answer_list_link" (
    "LoincNumber" text,
    "LongCommonName" text,
    "AnswerListId" text,
    "AnswerListName" text,
    "AnswerListLinkType" text,
    "ApplicableContext" text
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

DROP TABLE IF EXISTS "loinc_local_code_map_part_keyval";
CREATE TABLE "public"."loinc_local_code_map_part_keyval" (
    "id" numeric NOT NULL,
    "ref_loc_master_id" numeric DEFAULT '0' NOT NULL,
    CONSTRAINT "loinc_local_code_map_part_keyval_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fk_del_loinc_local_code_map_part_trg" AFTER DELETE ON "public"."loinc_local_code_map_part_keyval" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_local_code_map_del_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_part";
CREATE TABLE "public"."loinc_part" (
    "loinc_code" character varying(100) NOT NULL,
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
    "classtype" numeric DEFAULT '0',
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
    "common_test_rank" numeric DEFAULT '0',
    "common_order_rank" numeric DEFAULT '0',
    "common_si_test_rank" numeric DEFAULT '0',
    "hl7_attachment_structure" character varying(100),
    "externalcopyrightlink" character varying(500),
    "paneltype" character varying(100),
    "askatorderentry" character varying(500),
    "associatedobservations" character varying(500),
    "versionfirstreleased" character varying(100),
    "validhl7attachmentrequest" character varying(100),
    "ucum_code" character varying(100),
    "deprecated_flag" character varying(1),
    "loinc_version" character varying(100) NOT NULL,
    "active_flag" character varying(1),
    "create_user_id" character varying(255),
    "create_tstamp" timestamp,
    "modify_user_id" character varying(255),
    "modify_tstamp" timestamp,
    "class_type_id" numeric DEFAULT '0',
    CONSTRAINT "hl7_loinc_part_pkey" PRIMARY KEY ("loinc_code", "loinc_version")
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "ins_part_loinc_trgr" BEFORE INSERT ON "public"."loinc_part" FOR EACH ROW EXECUTE PROCEDURE loinc_part_ins_fn();;

DELIMITER ;

DROP TABLE IF EXISTS "loinc_part_keyval";
CREATE TABLE "public"."loinc_part_keyval" (
    "loinc_code" character varying(100) NOT NULL,
    "loinc_version" character varying(100) NOT NULL,
    CONSTRAINT "loinc_part_key_pkey" PRIMARY KEY ("loinc_code", "loinc_version")
) WITH (oids = false);


DELIMITER ;;

CREATE TRIGGER "fk_del_loinc_part_trg" AFTER DELETE ON "public"."loinc_part_keyval" FOR EACH ROW EXECUTE PROCEDURE fkey_loinc_del_fn();;

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


DROP TABLE IF EXISTS "mapto";
CREATE TABLE "public"."mapto" (
    "loinc" character varying NOT NULL,
    "map_to" character varying NOT NULL,
    "comment" text
) WITH (oids = false);


DROP TABLE IF EXISTS "mas_collection_method";
DROP SEQUENCE IF EXISTS public.mas_collection_method_id_seq;
CREATE SEQUENCE public.mas_collection_method_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_collection_method" (
    "id" integer DEFAULT nextval('public.mas_collection_method_id_seq') NOT NULL,
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

INSERT INTO "mas_collection_method" ("id", "name", "status", "UserAdded", "UserModified", "UserDeleted", "DateAdded", "DateModified", "IsDeleted") VALUES
(7,	'sdfdsf',	'1',	NULL,	NULL,	8,	'2020-03-03 05:00:52',	'2020-03-05 05:45:18',	'1'),
(9,	'sdfds',	'1',	NULL,	NULL,	8,	'2020-03-03 05:02:25',	'2020-03-05 05:45:20',	'1'),
(10,	'sdf',	'1',	NULL,	NULL,	8,	'2020-03-03 05:02:25',	'2020-03-05 05:45:22',	'1'),
(8,	'sdfs',	'1',	NULL,	NULL,	8,	'2020-03-03 05:00:52',	'2020-03-05 05:45:24',	'1'),
(11,	'venepuncture',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:47:33',	'2020-03-05 05:47:33',	'0'),
(12,	'local swab of lesion',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:47:33',	'2020-03-05 05:47:33',	'0'),
(13,	'lumber puncture',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:47:33',	'2020-03-05 05:47:33',	'0'),
(14,	'arterial stab',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:47:33',	'2020-03-05 05:47:33',	'0'),
(15,	'umbilical catheter',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:47:33',	'2020-03-05 05:47:33',	'0'),
(16,	'thoracocentesis',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(17,	'abdominal paracentesis',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(18,	'suprapuhic aspirate',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(19,	'clean catch urine',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(20,	'catheter urine',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(21,	'stool from nappy',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(22,	'stool from stoma site/bag',	'1',	NULL,	NULL,	NULL,	'2020-03-05 05:51:20',	'2020-03-05 05:51:20',	'0'),
(6,	'sdfdsf',	'0',	NULL,	NULL,	8,	'2020-03-02 09:39:27',	'2020-03-03 06:36:31',	'1'),
(5,	'tdsf',	'1',	NULL,	NULL,	8,	'2020-03-02 09:39:27',	'2020-03-03 06:37:59',	'1'),
(24,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:06:49',	'2020-03-07 09:16:56',	'1'),
(23,	'dsfsdf',	'1',	NULL,	NULL,	8,	'2020-03-07 09:05:12',	'2020-03-07 09:17:00',	'1'),
(25,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:09:19',	'2020-03-07 09:17:04',	'1'),
(31,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:15:17',	'2020-03-07 09:17:09',	'1'),
(30,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:11:54',	'2020-03-07 09:17:13',	'1'),
(29,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:11:23',	'2020-03-07 09:17:18',	'1'),
(28,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:10:40',	'2020-03-07 09:17:22',	'1'),
(27,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:10:21',	'2020-03-07 09:17:26',	'1'),
(26,	'test',	'1',	NULL,	NULL,	8,	'2020-03-07 09:09:50',	'2020-03-07 09:17:28',	'1'),
(32,	'test1',	'1',	NULL,	NULL,	NULL,	'2020-03-07 09:29:33',	'2020-03-07 09:29:33',	'0');

DROP TABLE IF EXISTS "mas_collection_site";
DROP SEQUENCE IF EXISTS public.mas_collection_site_id_seq;
CREATE SEQUENCE public.mas_collection_site_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."mas_collection_site" (
    "id" integer DEFAULT nextval('public.mas_collection_site_id_seq') NOT NULL,
    "name" character varying,
    "status" boolean,
    "UserAdded" integer,
    "UserModified" integer,
    "DateAdded" timestamp,
    "DateModified" timestamp,
    "UserDeleted" integer,
    "IsDeleted" integer DEFAULT '0'
) WITH (oids = false);

INSERT INTO "mas_collection_site" ("id", "name", "status", "UserAdded", "UserModified", "DateAdded", "DateModified", "UserDeleted", "IsDeleted") VALUES
(2,	'sdfsdf',	'1',	NULL,	NULL,	'2020-03-02 12:08:17',	'2020-03-02 12:08:17',	NULL,	NULL),
(3,	'sdfdsf',	'1',	NULL,	NULL,	'2020-03-02 12:08:17',	'2020-03-02 12:08:17',	NULL,	NULL),
(4,	'sdfsd',	'1',	NULL,	NULL,	'2020-03-02 12:08:23',	'2020-03-02 12:08:23',	NULL,	NULL),
(5,	'sdfds',	'1',	NULL,	NULL,	'2020-03-02 12:08:23',	'2020-03-02 12:08:23',	NULL,	NULL),
(6,	'sdfsdf',	'1',	NULL,	NULL,	'2020-03-02 12:09:09',	'2020-03-02 12:09:09',	NULL,	NULL),
(11,	'sdfsdf',	'1',	NULL,	NULL,	'2020-03-02 13:09:21',	'2020-03-05 05:55:54',	8,	1),
(12,	'ear swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(13,	'nose swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(14,	'groin swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(15,	'axila swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(8,	'sdfsd',	'1',	NULL,	NULL,	'2020-03-02 12:59:25',	'2020-03-02 13:01:11',	8,	1),
(1,	'sdfdsf',	'1',	NULL,	NULL,	'2020-03-02 12:06:36',	'2020-03-02 13:09:25',	8,	1),
(7,	'sdfs',	'1',	NULL,	NULL,	'2020-03-02 12:59:25',	'2020-03-04 05:42:36',	8,	1),
(9,	'sdfds',	'1',	NULL,	NULL,	'2020-03-02 13:09:21',	'2020-03-04 05:43:11',	8,	1),
(10,	'sdfsdf',	'1',	NULL,	NULL,	'2020-03-02 13:09:21',	'2020-03-04 05:46:47',	8,	1),
(16,	'wound swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(17,	'lesion swab',	'1',	NULL,	NULL,	'2020-03-05 05:57:07',	'2020-03-05 05:57:07',	NULL,	'0'),
(18,	'pus',	'1',	NULL,	NULL,	'2020-03-05 05:58:00',	'2020-03-05 05:58:00',	NULL,	'0'),
(19,	'urine',	'1',	NULL,	NULL,	'2020-03-05 05:58:00',	'2020-03-05 05:58:00',	NULL,	'0'),
(20,	'csf',	'1',	NULL,	NULL,	'2020-03-05 05:58:00',	'2020-03-05 05:58:00',	NULL,	'0'),
(21,	'peripheral vein',	'1',	NULL,	NULL,	'2020-03-05 05:58:00',	'2020-03-05 05:58:00',	NULL,	'0'),
(22,	'peripheral artery',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(23,	'umbilical vein',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(24,	'umbilical artery',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(25,	'PICC Line tip',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(26,	'umbilical artery tip',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(27,	'umbilical vein tip',	'1',	NULL,	NULL,	'2020-03-05 06:01:51',	'2020-03-05 06:01:51',	NULL,	'0'),
(28,	'nasopharyngcal asphirate',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(29,	'pernasal swab',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(30,	'central venous blood via UVC',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(31,	'central arterial blood via UAC',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(32,	'pleural fluid',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(33,	'ascitic fluid',	'1',	NULL,	NULL,	'2020-03-05 07:22:57',	'2020-03-05 07:22:57',	NULL,	'0'),
(36,	'test2',	'1',	NULL,	NULL,	'2020-03-07 05:39:31',	'2020-03-07 09:16:37',	8,	1),
(35,	'test5',	'1',	NULL,	NULL,	'2020-03-07 05:38:34',	'2020-03-07 09:16:40',	8,	1),
(34,	'test1',	'1',	NULL,	NULL,	'2020-03-07 05:33:32',	'2020-03-07 09:16:43',	8,	1),
(37,	'test1',	'1',	NULL,	NULL,	'2020-03-07 09:29:19',	'2020-03-07 09:29:19',	NULL,	'0'),
(38,	'test11',	'1',	NULL,	NULL,	'2020-03-07 10:18:33',	'2020-03-07 10:18:33',	NULL,	'0');

-- 2020-10-13 10:55:43.207002+05:30
