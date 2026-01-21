ALTER TABLE "fihr_formated_values"
ADD "lab_number" character varying NULL;
COMMENT ON TABLE "fihr_formated_values" IS '';

ALTER TABLE "fihr_formated_values"
ADD "lab_sample_number" character varying NULL;
COMMENT ON TABLE "fihr_formated_values" IS '';

ALTER TABLE "fihr_formated_values"
ADD "range_low" character varying NULL;
COMMENT ON TABLE "fihr_formated_values" IS '';

ALTER TABLE "fihr_formated_values"
ADD "range_high" character varying NULL;
COMMENT ON TABLE "fihr_formated_values" IS '';

ALTER TABLE "lab_request"
ADD "request_id" bigint NULL;
COMMENT ON TABLE "lab_request" IS '';

ALTER TABLE "discharge_summary"
ADD "is_send" integer NULL DEFAULT '1';
COMMENT ON TABLE "discharge_summary" IS '';

ALTER TABLE "discharge_summary_audit"
ADD "is_send" integer NULL DEFAULT '1';
COMMENT ON TABLE "discharge_summary" IS '';

ALTER TABLE "postnatal_discharge"
ADD "background" character varying NULL;
COMMENT ON TABLE "postnatal_discharge" IS '';

CREATE OR REPLACE VIEW public.op_search AS 
 SELECT op_details."BabyId",
    baby."BabyName",
    baby."DOB",
    baby."BMrNo",
    op_details."op_visite",
    op_details."OpId",
    op_details."Advice",
    op_details."AllergyHistory",
    op_details."FamilyHistory",
    op_details."TreatmentHistory",
    op_details."baby_background",
    op_details."Complaints",
    op_details."HPI",
    op_details."Development",
    op_details."Examination",
    op_details."Diagnosis",
    op_details."investigations",
    op_details."nextreviewindication"
   FROM baby
     JOIN op_details ON op_details."BabyId" = baby."BabyId";

ALTER TABLE public.op_search
  OWNER TO postgres;


ALTER TABLE "postnatal_discharge"
ADD "diagnosis" smallint NULL;
COMMENT ON TABLE "postnatal_discharge" IS '';

ALTER TABLE "postnatal_discharge"
ALTER "diagnosis" TYPE text,
ALTER "diagnosis" DROP DEFAULT,
ALTER "diagnosis" DROP NOT NULL;
COMMENT ON COLUMN "postnatal_discharge"."diagnosis" IS '';
COMMENT ON TABLE "postnatal_discharge" IS '';


