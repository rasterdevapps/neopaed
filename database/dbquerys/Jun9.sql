ALTER TABLE spesis_details
RENAME COLUMN "piperacillin-tazobactam" TO "piperacillin_tazobactam";

ALTER TABLE demo_details
ADD gestation_weeks text NULL;

ALTER TABLE demo_details
ADD gestation_days text NULL;

ALTER TABLE "nicu_admission" RENAME COLUMN "DischargeCUSS" TO "discharge_cuss";

ALTER TABLE nicu_admission
ADD dcg_weeks integer NULL;

ALTER TABLE nicu_admission
ADD dcg_days integer NULL;

ALTER TABLE nicu_admission_audit
ADD cg_weeks integer NULL;

ALTER TABLE nicu_admission_audit
ADD cg_days integer NULL;

ALTER TABLE nicu_admission_audit
ADD dcg_weeks integer NULL;

ALTER TABLE nicu_admission_audit
ADD dcg_days integer NULL;

ALTER TABLE nicu_admission
ADD discharge_femoral_pulses text NULL;

ALTER TABLE nicu_admission_audit
ADD discharge_femoral_pulses text NULL;

ALTER TABLE nicu_admission
ADD hospital_name varchar(255) NULL;

ALTER TABLE nicu_admission_audit
ADD hospital_name varchar(255) NULL;

ALTER TABLE op_details
ADD hospital_name varchar(255) NULL;

ALTER TABLE op_details_audit
ADD hospital_name varchar(255) NULL;

ALTER TABLE postnatal_admission
ADD hospital_name varchar(255) NULL;

ALTER TABLE lab_request
ADD associate_doctor varchar(255) NULL;

ALTER TABLE lab_request
ADD is_processed boolean DEFAULT false NOT NULL;

DROP TABLE IF EXISTS "photo_video_upload";
CREATE SEQUENCE "photo_video_upload_Id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."photo_video_upload" (
    "BMrNo" character varying,
    "UploadType" text,
    "Photo" text,
    "Video" text,
    "created_at" date,
    "update_at" date,
    "Id" bigint DEFAULT nextval('"photo_video_upload_Id_seq"') NOT NULL,
    "description" character varying,
    CONSTRAINT "Id" PRIMARY KEY ("Id")
) WITH (oids = false);

ALTER TABLE pediatric_admission
ADD background varchar(255);

ALTER TABLE pediatric_admission
ADD anyotherabnormality varchar(255);

ALTER TABLE pediatric_admission
ADD anyothermass varchar(255);

UPDATE site_settings
SET custom_toastr = '{"debug": true, "timeOut": "5000", "hideEasing": "linear", "hideMethod": "fadeOut", "showEasing": "swing", "showMethod": "fadeIn", "closeButton": true, "newestOnTop": true, "progressBar": true, "hideDuration": "1000", "showDuration": "300", "positionClass": "toast-top-right", "toastTypeGroup": "info", "extendedTimeOut": "1000", "preventDuplicates": true}';

UPDATE site_settings
SET pagenation_limit_options = '{"limit_option":["50","10","25","12","22"],"default_limit":"12"}';

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

ALTER TABLE mas_doctors
ADD job_title text;

DROP TABLE IF EXISTS "complaint";

CREATE TABLE "public"."complaint" (
    "complaints_id" bigint DEFAULT nextval('public.complaint_complaints_id_seq') NOT NULL,
    "title" text,
    "madeby" text,
    "userdetails" text,
    "description" text,
    "Status" text,
    "UserAdded" integer,
    "UserDeleted" integer,
    "UserModified" integer,
    "IsDeleted" integer,
    "complaints" text,
    "DateModified" date,
    "DateAdded" date
) WITH (oids = false);
