
ALTER TABLE "complications"
ALTER "Treatment" TYPE  character varying,
ALTER "Treatment" DROP DEFAULT,
ALTER "Treatment" DROP NOT NULL;
COMMENT ON COLUMN "complications"."Treatment" IS '';
COMMENT ON TABLE "complications" IS '';

ALTER TABLE "neonatal_proforma"
ALTER "ETTSize" TYPE numeric(5,1),
ALTER "ETTSize" DROP DEFAULT,
ALTER "ETTSize" DROP NOT NULL;
COMMENT ON COLUMN "neonatal_proforma"."ETTSize" IS '';
COMMENT ON TABLE "neonatal_proforma" IS '';



ALTER TABLE "newborn_examination"
ALTER "AbdomenShape" TYPE character varying,
ALTER "AbdomenShape" DROP DEFAULT,
ALTER "AbdomenShape" DROP NOT NULL,
ALTER "AddedSounds" TYPE character varying,
ALTER "AddedSounds" DROP DEFAULT,
ALTER "AddedSounds" DROP NOT NULL,
ALTER "AgeOfExamination" TYPE character varying,
ALTER "AgeOfExamination" DROP DEFAULT,
ALTER "AgeOfExamination" DROP NOT NULL,
ALTER "AirEntry" TYPE character varying,
ALTER "AirEntry" DROP DEFAULT,
ALTER "AirEntry" DROP NOT NULL,
ALTER "AnteriorFontanelle" TYPE character varying,
ALTER "AnteriorFontanelle" DROP DEFAULT,
ALTER "AnteriorFontanelle" DROP NOT NULL,
ALTER "Anus" TYPE character varying,
ALTER "Anus" DROP DEFAULT,
ALTER "Anus" DROP NOT NULL,
ALTER "AnyOtherAbnormality" TYPE character varying,
ALTER "AnyOtherAbnormality" DROP DEFAULT,
ALTER "AnyOtherAbnormality" DROP NOT NULL,
ALTER "ApicalImpulse" TYPE character varying,
ALTER "ApicalImpulse" DROP DEFAULT,
ALTER "ApicalImpulse" DROP NOT NULL,
ALTER "SeenBy" TYPE character varying,
ALTER "SeenBy" DROP DEFAULT,
ALTER "SeenBy" DROP NOT NULL,
ALTER "BoundingPulses" TYPE character varying,
ALTER "BoundingPulses" DROP DEFAULT,
ALTER "BoundingPulses" DROP NOT NULL,
ALTER "BreathSounds" TYPE character varying,
ALTER "BreathSounds" DROP DEFAULT,
ALTER "BreathSounds" DROP NOT NULL,
ALTER "CentralPulses" TYPE character varying,
ALTER "CentralPulses" DROP DEFAULT,
ALTER "CentralPulses" DROP NOT NULL,
ALTER "NbCFT" TYPE character varying,
ALTER "NbCFT" DROP DEFAULT,
ALTER "NbCFT" DROP NOT NULL,
ALTER "CharacterOfAddedSounds" TYPE character varying,
ALTER "CharacterOfAddedSounds" DROP DEFAULT,
ALTER "CharacterOfAddedSounds" DROP NOT NULL,
ALTER "CharacterofMurmur" TYPE character varying,
ALTER "CharacterofMurmur" DROP DEFAULT,
ALTER "CharacterofMurmur" DROP NOT NULL,
ALTER "NbChestMovement" TYPE character varying,
ALTER "NbChestMovement" DROP DEFAULT,
ALTER "NbChestMovement" DROP NOT NULL,
ALTER "Colour" TYPE character varying,
ALTER "Colour" DROP DEFAULT,
ALTER "Colour" DROP NOT NULL,
ALTER "Cry" TYPE character varying,
ALTER "Cry" DROP DEFAULT,
ALTER "Cry" DROP NOT NULL,
ALTER "Ears" TYPE character varying,
ALTER "Ears" DROP DEFAULT,
ALTER "Ears" DROP NOT NULL,
ALTER "Esophagus" TYPE character varying,
ALTER "Esophagus" DROP DEFAULT,
ALTER "Esophagus" DROP NOT NULL,
ALTER "Eyes" TYPE character varying,
ALTER "Eyes" DROP DEFAULT,
ALTER "Eyes" DROP NOT NULL,
ALTER "FemoralPulses" TYPE character varying,
ALTER "FemoralPulses" DROP DEFAULT,
ALTER "FemoralPulses" DROP NOT NULL,
ALTER "Flanks" TYPE character varying,
ALTER "Flanks" DROP DEFAULT,
ALTER "Flanks" DROP NOT NULL,
ALTER "GeneralBodyMovements" TYPE character varying,
ALTER "GeneralBodyMovements" DROP DEFAULT,
ALTER "GeneralBodyMovements" DROP NOT NULL,
ALTER "Genitalia" TYPE character varying,
ALTER "Genitalia" DROP DEFAULT,
ALTER "Genitalia" DROP NOT NULL,
ALTER "Hairs" TYPE character varying,
ALTER "Hairs" DROP DEFAULT,
ALTER "Hairs" DROP NOT NULL,
ALTER "Hepatomegaly" TYPE character varying,
ALTER "Hepatomegaly" DROP DEFAULT,
ALTER "Hepatomegaly" DROP NOT NULL,
ALTER "HernialOrifices" TYPE character varying,
ALTER "HernialOrifices" DROP DEFAULT,
ALTER "HernialOrifices" DROP NOT NULL,
ALTER "Hips" TYPE character varying,
ALTER "Hips" DROP DEFAULT,
ALTER "Hips" DROP NOT NULL,
ALTER "NbHR" TYPE character varying,
ALTER "NbHR" DROP DEFAULT,
ALTER "NbHR" DROP NOT NULL,
ALTER "Jaundice" TYPE character varying,
ALTER "Jaundice" DROP DEFAULT,
ALTER "Jaundice" DROP NOT NULL,
ALTER "LevelOfConsciousness" TYPE character varying,
ALTER "LevelOfConsciousness" DROP DEFAULT,
ALTER "LevelOfConsciousness" DROP NOT NULL,
ALTER "Lips" TYPE character varying,
ALTER "Lips" DROP DEFAULT,
ALTER "Lips" DROP NOT NULL,
ALTER "LiverSpan" TYPE character varying,
ALTER "LiverSpan" DROP DEFAULT,
ALTER "LiverSpan" DROP NOT NULL,
ALTER "LtLL" TYPE character varying,
ALTER "LtLL" DROP DEFAULT,
ALTER "LtLL" DROP NOT NULL,
ALTER "LtUL" TYPE character varying,
ALTER "LtUL" DROP DEFAULT,
ALTER "LtUL" DROP NOT NULL,
ALTER "Murmur" TYPE character varying,
ALTER "Murmur" DROP DEFAULT,
ALTER "Murmur" DROP NOT NULL,
ALTER "Neck" TYPE character varying,
ALTER "Neck" DROP DEFAULT,
ALTER "Neck" DROP NOT NULL,
ALTER "NeonatalReflexes" TYPE character varying,
ALTER "NeonatalReflexes" DROP DEFAULT,
ALTER "NeonatalReflexes" DROP NOT NULL,
ALTER "Nipples" TYPE character varying,
ALTER "Nipples" DROP DEFAULT,
ALTER "Nipples" DROP NOT NULL,
ALTER "Nose" TYPE character varying,
ALTER "Nose" DROP DEFAULT,
ALTER "Nose" DROP NOT NULL,
ALTER "Nostrils" TYPE character varying,
ALTER "Nostrils" DROP DEFAULT,
ALTER "Nostrils" DROP NOT NULL,
ALTER "Palate" TYPE character varying,
ALTER "Palate" DROP DEFAULT,
ALTER "Palate" DROP NOT NULL,
ALTER "Pallor" TYPE character varying,
ALTER "Pallor" DROP DEFAULT,
ALTER "Pallor" DROP NOT NULL,
ALTER "PeripheralPulses" TYPE character varying,
ALTER "PeripheralPulses" DROP DEFAULT,
ALTER "PeripheralPulses" DROP NOT NULL,
ALTER "PrecordialActivity" TYPE character varying,
ALTER "PrecordialActivity" DROP DEFAULT,
ALTER "PrecordialActivity" DROP NOT NULL,
ALTER "NbRR" TYPE character varying,
ALTER "NbRR" DROP DEFAULT,
ALTER "NbRR" DROP NOT NULL,
ALTER "RtLL" TYPE character varying,
ALTER "RtLL" DROP DEFAULT,
ALTER "RtLL" DROP NOT NULL,
ALTER "RtUL" TYPE character varying,
ALTER "RtUL" DROP DEFAULT,
ALTER "RtUL" DROP NOT NULL,
ALTER "S1S2" TYPE character varying,
ALTER "S1S2" DROP DEFAULT,
ALTER "S1S2" DROP NOT NULL,
ALTER "Scalp" TYPE character varying,
ALTER "Scalp" DROP DEFAULT,
ALTER "Scalp" DROP NOT NULL,
ALTER "Seizures" TYPE character varying,
ALTER "Seizures" DROP DEFAULT,
ALTER "Seizures" DROP NOT NULL,
ALTER "SiteofAddedSounds" TYPE character varying,
ALTER "SiteofAddedSounds" DROP DEFAULT,
ALTER "SiteofAddedSounds" DROP NOT NULL,
ALTER "SiteofMurmur" TYPE character varying,
ALTER "SiteofMurmur" DROP DEFAULT,
ALTER "SiteofMurmur" DROP NOT NULL,
ALTER "Skin" TYPE character varying,
ALTER "Skin" DROP DEFAULT,
ALTER "Skin" DROP NOT NULL,
ALTER "Spine" TYPE character varying,
ALTER "Spine" DROP DEFAULT,
ALTER "Spine" DROP NOT NULL,
ALTER "SpleenSpan" TYPE character varying,
ALTER "SpleenSpan" DROP DEFAULT,
ALTER "SpleenSpan" DROP NOT NULL,
ALTER "Splenomegaly" TYPE character varying,
ALTER "Splenomegaly" DROP DEFAULT,
ALTER "Splenomegaly" DROP NOT NULL,
ALTER "NbSpO2" TYPE character varying,
ALTER "NbSpO2" DROP DEFAULT,
ALTER "NbSpO2" DROP NOT NULL,
ALTER "SpontaneousActivity" TYPE character varying,
ALTER "SpontaneousActivity" DROP DEFAULT,
ALTER "SpontaneousActivity" DROP NOT NULL,
ALTER "TemperatureF" TYPE character varying,
ALTER "TemperatureF" DROP DEFAULT,
ALTER "TemperatureF" DROP NOT NULL,
ALTER "NbTone" TYPE character varying,
ALTER "NbTone" DROP DEFAULT,
ALTER "NbTone" DROP NOT NULL,
ALTER "TypeofSeizure" TYPE character varying,
ALTER "TypeofSeizure" DROP DEFAULT,
ALTER "TypeofSeizure" DROP NOT NULL,
ALTER "UmbilicalCord" TYPE character varying,
ALTER "UmbilicalCord" DROP DEFAULT,
ALTER "UmbilicalCord" DROP NOT NULL,
ALTER "Umbilicus" TYPE character varying,
ALTER "Umbilicus" DROP DEFAULT,
ALTER "Umbilicus" DROP NOT NULL,
ALTER "UserAdded" TYPE character varying,
ALTER "UserAdded" DROP DEFAULT,
ALTER "UserAdded" DROP NOT NULL,
ALTER "DateAdded" TYPE timestamp(0),
ALTER "DateAdded" DROP DEFAULT,
ALTER "DateAdded" DROP NOT NULL,
ALTER "DateModified" TYPE timestamp(0),
ALTER "DateModified" DROP DEFAULT,
ALTER "DateModified" DROP NOT NULL;
COMMENT ON COLUMN "newborn_examination"."AbdomenShape" IS '';
COMMENT ON COLUMN "newborn_examination"."AddedSounds" IS '';
COMMENT ON COLUMN "newborn_examination"."AgeOfExamination" IS '';
COMMENT ON COLUMN "newborn_examination"."AirEntry" IS '';
COMMENT ON COLUMN "newborn_examination"."AnteriorFontanelle" IS '';
COMMENT ON COLUMN "newborn_examination"."Anus" IS '';
COMMENT ON COLUMN "newborn_examination"."AnyOtherAbnormality" IS '';
COMMENT ON COLUMN "newborn_examination"."ApicalImpulse" IS '';
COMMENT ON COLUMN "newborn_examination"."SeenBy" IS '';
COMMENT ON COLUMN "newborn_examination"."BoundingPulses" IS '';
COMMENT ON COLUMN "newborn_examination"."BreathSounds" IS '';
COMMENT ON COLUMN "newborn_examination"."CentralPulses" IS '';
COMMENT ON COLUMN "newborn_examination"."NbCFT" IS '';
COMMENT ON COLUMN "newborn_examination"."CharacterOfAddedSounds" IS '';
COMMENT ON COLUMN "newborn_examination"."CharacterofMurmur" IS '';
COMMENT ON COLUMN "newborn_examination"."NbChestMovement" IS '';
COMMENT ON COLUMN "newborn_examination"."Colour" IS '';
COMMENT ON COLUMN "newborn_examination"."Cry" IS '';
COMMENT ON COLUMN "newborn_examination"."Ears" IS '';
COMMENT ON COLUMN "newborn_examination"."Esophagus" IS '';
COMMENT ON COLUMN "newborn_examination"."Eyes" IS '';
COMMENT ON COLUMN "newborn_examination"."FemoralPulses" IS '';
COMMENT ON COLUMN "newborn_examination"."Flanks" IS '';
COMMENT ON COLUMN "newborn_examination"."GeneralBodyMovements" IS '';
COMMENT ON COLUMN "newborn_examination"."Genitalia" IS '';
COMMENT ON COLUMN "newborn_examination"."Hairs" IS '';
COMMENT ON COLUMN "newborn_examination"."Hepatomegaly" IS '';
COMMENT ON COLUMN "newborn_examination"."HernialOrifices" IS '';
COMMENT ON COLUMN "newborn_examination"."Hips" IS '';
COMMENT ON COLUMN "newborn_examination"."NbHR" IS '';
COMMENT ON COLUMN "newborn_examination"."Jaundice" IS '';
COMMENT ON COLUMN "newborn_examination"."LevelOfConsciousness" IS '';
COMMENT ON COLUMN "newborn_examination"."Lips" IS '';
COMMENT ON COLUMN "newborn_examination"."LiverSpan" IS '';
COMMENT ON COLUMN "newborn_examination"."LtLL" IS '';
COMMENT ON COLUMN "newborn_examination"."LtUL" IS '';
COMMENT ON COLUMN "newborn_examination"."Murmur" IS '';
COMMENT ON COLUMN "newborn_examination"."Neck" IS '';
COMMENT ON COLUMN "newborn_examination"."NeonatalReflexes" IS '';
COMMENT ON COLUMN "newborn_examination"."Nipples" IS '';
COMMENT ON COLUMN "newborn_examination"."Nose" IS '';
COMMENT ON COLUMN "newborn_examination"."Nostrils" IS '';
COMMENT ON COLUMN "newborn_examination"."Palate" IS '';
COMMENT ON COLUMN "newborn_examination"."Pallor" IS '';
COMMENT ON COLUMN "newborn_examination"."PeripheralPulses" IS '';
COMMENT ON COLUMN "newborn_examination"."PrecordialActivity" IS '';
COMMENT ON COLUMN "newborn_examination"."NbRR" IS '';
COMMENT ON COLUMN "newborn_examination"."RtLL" IS '';
COMMENT ON COLUMN "newborn_examination"."RtUL" IS '';
COMMENT ON COLUMN "newborn_examination"."S1S2" IS '';
COMMENT ON COLUMN "newborn_examination"."Scalp" IS '';
COMMENT ON COLUMN "newborn_examination"."Seizures" IS '';
COMMENT ON COLUMN "newborn_examination"."SiteofAddedSounds" IS '';
COMMENT ON COLUMN "newborn_examination"."SiteofMurmur" IS '';
COMMENT ON COLUMN "newborn_examination"."Skin" IS '';
COMMENT ON COLUMN "newborn_examination"."Spine" IS '';
COMMENT ON COLUMN "newborn_examination"."SpleenSpan" IS '';
COMMENT ON COLUMN "newborn_examination"."Splenomegaly" IS '';
COMMENT ON COLUMN "newborn_examination"."NbSpO2" IS '';
COMMENT ON COLUMN "newborn_examination"."SpontaneousActivity" IS '';
COMMENT ON COLUMN "newborn_examination"."TemperatureF" IS '';
COMMENT ON COLUMN "newborn_examination"."NbTone" IS '';
COMMENT ON COLUMN "newborn_examination"."TypeofSeizure" IS '';
COMMENT ON COLUMN "newborn_examination"."UmbilicalCord" IS '';
COMMENT ON COLUMN "newborn_examination"."Umbilicus" IS '';
COMMENT ON COLUMN "newborn_examination"."UserAdded" IS '';
COMMENT ON COLUMN "newborn_examination"."DateAdded" IS '';
COMMENT ON COLUMN "newborn_examination"."DateModified" IS '';
COMMENT ON TABLE "newborn_examination" IS '';


ALTER TABLE "neonatal_proforma"
ADD "maximum_fio2_required" integer NULL;
COMMENT ON TABLE "neonatal_proforma" IS '';

ALTER TABLE "neonatal_proforma"
ADD "duration_of_cpr" integer NULL;
COMMENT ON TABLE "neonatal_proforma" IS '';

ALTER TABLE "neonatal_proforma"
ADD "resusciatation_drugs" json NULL;
COMMENT ON TABLE "neonatal_proforma" IS '';


ALTER TABLE "neonatal_proforma"
ADD "discharge_length" double precision NULL,
ADD "discharge_ofc" double precision NULL;
COMMENT ON TABLE "neonatal_proforma" IS '';


ALTER TABLE "neonatal_proforma"
ADD "wb_echo_report" text NULL,
ADD "wb_echo_status" text NULL;
COMMENT ON TABLE "neonatal_proforma" IS '';



ALTER TABLE "mother"
ALTER "MMrNo" TYPE character varying,
ALTER "MMrNo" DROP DEFAULT,
ALTER "MMrNo" DROP NOT NULL,
ALTER "MotherInitial" TYPE character varying,
ALTER "MotherInitial" DROP DEFAULT,
ALTER "MotherInitial" DROP NOT NULL,
ALTER "MotherTitle" TYPE character varying,
ALTER "MotherTitle" SET DEFAULT 'Mrs.',
ALTER "MotherTitle" SET NOT NULL,
ALTER "PartnerTitle" TYPE character varying,
ALTER "PartnerTitle" DROP DEFAULT,
ALTER "PartnerTitle" DROP NOT NULL,
ALTER "PartnerInitial" TYPE character varying,
ALTER "PartnerInitial" DROP DEFAULT,
ALTER "PartnerInitial" DROP NOT NULL,
ALTER "MotherName" TYPE character varying,
ALTER "MotherName" DROP DEFAULT,
ALTER "MotherName" DROP NOT NULL,
ALTER "MotherLastName" TYPE character varying,
ALTER "MotherLastName" DROP DEFAULT,
ALTER "MotherLastName" DROP NOT NULL,
ALTER "MotherBloodGroup" TYPE character varying,
ALTER "MotherBloodGroup" DROP DEFAULT,
ALTER "MotherBloodGroup" DROP NOT NULL,
ALTER "Email" TYPE character varying,
ALTER "Email" DROP DEFAULT,
ALTER "Email" DROP NOT NULL,
ALTER "Address1" TYPE character varying,
ALTER "Address1" DROP DEFAULT,
ALTER "Address1" DROP NOT NULL,
ALTER "Address2" TYPE character varying,
ALTER "Address2" DROP DEFAULT,
ALTER "Address2" DROP NOT NULL,
ALTER "Address3" TYPE character varying,
ALTER "Address3" DROP DEFAULT,
ALTER "Address3" DROP NOT NULL,
ALTER "Address4" TYPE character varying,
ALTER "Address4" DROP DEFAULT,
ALTER "Address4" DROP NOT NULL,
ALTER "City" TYPE character varying,
ALTER "City" DROP DEFAULT,
ALTER "City" DROP NOT NULL,
ALTER "State" TYPE character varying,
ALTER "State" DROP DEFAULT,
ALTER "State" DROP NOT NULL,
ALTER "Country" TYPE character varying,
ALTER "Country" DROP DEFAULT,
ALTER "Country" DROP NOT NULL,
ALTER "Mobile" TYPE character varying,
ALTER "Mobile" DROP DEFAULT,
ALTER "Mobile" DROP NOT NULL,
ALTER "LandLine" TYPE character varying,
ALTER "LandLine" DROP DEFAULT,
ALTER "LandLine" DROP NOT NULL,
ALTER "Occupation" TYPE character varying,
ALTER "Occupation" DROP DEFAULT,
ALTER "Occupation" DROP NOT NULL,
ALTER "PartnerName" TYPE character varying,
ALTER "PartnerName" DROP DEFAULT,
ALTER "PartnerName" DROP NOT NULL,
ALTER "PartnerContact" TYPE character varying,
ALTER "PartnerContact" DROP DEFAULT,
ALTER "PartnerContact" DROP NOT NULL,
ALTER "PartnerOccupation" TYPE character varying,
ALTER "PartnerOccupation" DROP DEFAULT,
ALTER "PartnerOccupation" DROP NOT NULL,
ALTER "IsDeleted" TYPE character varying,
ALTER "IsDeleted" SET DEFAULT '0',
ALTER "IsDeleted" SET NOT NULL,
ALTER "DateAdded" TYPE timestamp,
ALTER "DateAdded" DROP DEFAULT,
ALTER "DateAdded" DROP NOT NULL,
ALTER "DateModified" TYPE timestamp,
ALTER "DateModified" DROP DEFAULT,
ALTER "DateModified" DROP NOT NULL,
ALTER "MothercYear" TYPE character varying,
ALTER "MothercYear" DROP DEFAULT,
ALTER "MothercYear" DROP NOT NULL,
ALTER "MotherEmail" TYPE character varying,
ALTER "MotherEmail" DROP DEFAULT,
ALTER "MotherEmail" DROP NOT NULL,
ALTER "PartnerLastName" TYPE character varying,
ALTER "PartnerLastName" DROP DEFAULT,
ALTER "PartnerLastName" DROP NOT NULL,
ALTER "PartnercYear" TYPE character varying,
ALTER "PartnercYear" DROP DEFAULT,
ALTER "PartnercYear" DROP NOT NULL,
ALTER "PartnerMobile" TYPE character varying,
ALTER "PartnerMobile" DROP DEFAULT,
ALTER "PartnerMobile" DROP NOT NULL,
ALTER "Postcode" TYPE character varying,
ALTER "Postcode" DROP DEFAULT,
ALTER "Postcode" DROP NOT NULL,
ALTER "Address5" TYPE character varying,
ALTER "Address5" DROP DEFAULT,
ALTER "Address5" DROP NOT NULL,
ALTER "FatherAddress1" TYPE character varying,
ALTER "FatherAddress1" DROP DEFAULT,
ALTER "FatherAddress1" DROP NOT NULL,
ALTER "FatherAddress2" TYPE character varying,
ALTER "FatherAddress2" DROP DEFAULT,
ALTER "FatherAddress2" DROP NOT NULL;
COMMENT ON COLUMN "mother"."MMrNo" IS '';
COMMENT ON COLUMN "mother"."MotherInitial" IS '';
COMMENT ON COLUMN "mother"."MotherTitle" IS '';
COMMENT ON COLUMN "mother"."PartnerTitle" IS '';
COMMENT ON COLUMN "mother"."PartnerInitial" IS '';
COMMENT ON COLUMN "mother"."MotherName" IS '';
COMMENT ON COLUMN "mother"."MotherLastName" IS '';
COMMENT ON COLUMN "mother"."MotherBloodGroup" IS '';
COMMENT ON COLUMN "mother"."Email" IS '';
COMMENT ON COLUMN "mother"."Address1" IS '';
COMMENT ON COLUMN "mother"."Address2" IS '';
COMMENT ON COLUMN "mother"."Address3" IS '';
COMMENT ON COLUMN "mother"."Address4" IS '';
COMMENT ON COLUMN "mother"."City" IS '';
COMMENT ON COLUMN "mother"."State" IS '';
COMMENT ON COLUMN "mother"."Country" IS '';
COMMENT ON COLUMN "mother"."Mobile" IS '';
COMMENT ON COLUMN "mother"."LandLine" IS '';
COMMENT ON COLUMN "mother"."Occupation" IS '';
COMMENT ON COLUMN "mother"."PartnerName" IS '';
COMMENT ON COLUMN "mother"."PartnerContact" IS '';
COMMENT ON COLUMN "mother"."PartnerOccupation" IS '';
COMMENT ON COLUMN "mother"."IsDeleted" IS '';
COMMENT ON COLUMN "mother"."DateAdded" IS '';
COMMENT ON COLUMN "mother"."DateModified" IS '';
COMMENT ON COLUMN "mother"."MothercYear" IS '';
COMMENT ON COLUMN "mother"."MotherEmail" IS '';
COMMENT ON COLUMN "mother"."PartnerLastName" IS '';
COMMENT ON COLUMN "mother"."PartnercYear" IS '';
COMMENT ON COLUMN "mother"."PartnerMobile" IS '';
COMMENT ON COLUMN "mother"."Postcode" IS '';
COMMENT ON COLUMN "mother"."Address5" IS '';
COMMENT ON COLUMN "mother"."FatherAddress1" IS '';
COMMENT ON COLUMN "mother"."FatherAddress2" IS '';
COMMENT ON TABLE "mother" IS '';


ALTER TABLE "mother_audit"
ALTER "MMrNo" TYPE character varying,
ALTER "MMrNo" DROP DEFAULT,
ALTER "MMrNo" DROP NOT NULL,
ALTER "MotherInitial" TYPE character varying,
ALTER "MotherInitial" DROP DEFAULT,
ALTER "MotherInitial" DROP NOT NULL,
ALTER "MotherTitle" TYPE character varying,
ALTER "MotherTitle" SET DEFAULT 'Mrs.',
ALTER "MotherTitle" SET NOT NULL,
ALTER "PartnerTitle" TYPE character varying,
ALTER "PartnerTitle" DROP DEFAULT,
ALTER "PartnerTitle" DROP NOT NULL,
ALTER "PartnerInitial" TYPE character varying,
ALTER "PartnerInitial" DROP DEFAULT,
ALTER "PartnerInitial" DROP NOT NULL,
ALTER "MotherName" TYPE character varying,
ALTER "MotherName" DROP DEFAULT,
ALTER "MotherName" DROP NOT NULL,
ALTER "MotherLastName" TYPE character varying,
ALTER "MotherLastName" DROP DEFAULT,
ALTER "MotherLastName" DROP NOT NULL,
ALTER "MotherBloodGroup" TYPE character varying,
ALTER "MotherBloodGroup" DROP DEFAULT,
ALTER "MotherBloodGroup" DROP NOT NULL,
ALTER "Email" TYPE character varying,
ALTER "Email" DROP DEFAULT,
ALTER "Email" DROP NOT NULL,
ALTER "Address1" TYPE character varying,
ALTER "Address1" DROP DEFAULT,
ALTER "Address1" DROP NOT NULL,
ALTER "Address2" TYPE character varying,
ALTER "Address2" DROP DEFAULT,
ALTER "Address2" DROP NOT NULL,
ALTER "Address3" TYPE character varying,
ALTER "Address3" DROP DEFAULT,
ALTER "Address3" DROP NOT NULL,
ALTER "Address4" TYPE character varying,
ALTER "Address4" DROP DEFAULT,
ALTER "Address4" DROP NOT NULL,
ALTER "City" TYPE character varying,
ALTER "City" DROP DEFAULT,
ALTER "City" DROP NOT NULL,
ALTER "State" TYPE character varying,
ALTER "State" DROP DEFAULT,
ALTER "State" DROP NOT NULL,
ALTER "Country" TYPE character varying,
ALTER "Country" DROP DEFAULT,
ALTER "Country" DROP NOT NULL,
ALTER "Mobile" TYPE character varying,
ALTER "Mobile" DROP DEFAULT,
ALTER "Mobile" DROP NOT NULL,
ALTER "LandLine" TYPE character varying,
ALTER "LandLine" DROP DEFAULT,
ALTER "LandLine" DROP NOT NULL,
ALTER "Occupation" TYPE character varying,
ALTER "Occupation" DROP DEFAULT,
ALTER "Occupation" DROP NOT NULL,
ALTER "PartnerName" TYPE character varying,
ALTER "PartnerName" DROP DEFAULT,
ALTER "PartnerName" DROP NOT NULL,
ALTER "PartnerContact" TYPE character varying,
ALTER "PartnerContact" DROP DEFAULT,
ALTER "PartnerContact" DROP NOT NULL,
ALTER "PartnerOccupation" TYPE character varying,
ALTER "PartnerOccupation" DROP DEFAULT,
ALTER "PartnerOccupation" DROP NOT NULL,
ALTER "IsDeleted" TYPE character varying,
ALTER "IsDeleted" SET DEFAULT '0',
ALTER "IsDeleted" SET NOT NULL,
ALTER "DateAdded" TYPE timestamp,
ALTER "DateAdded" DROP DEFAULT,
ALTER "DateAdded" DROP NOT NULL,
ALTER "DateModified" TYPE timestamp,
ALTER "DateModified" DROP DEFAULT,
ALTER "DateModified" DROP NOT NULL,
ALTER "MothercYear" TYPE character varying,
ALTER "MothercYear" DROP DEFAULT,
ALTER "MothercYear" DROP NOT NULL,
ALTER "MotherEmail" TYPE character varying,
ALTER "MotherEmail" DROP DEFAULT,
ALTER "MotherEmail" DROP NOT NULL,
ALTER "PartnerLastName" TYPE character varying,
ALTER "PartnerLastName" DROP DEFAULT,
ALTER "PartnerLastName" DROP NOT NULL,
ALTER "PartnercYear" TYPE character varying,
ALTER "PartnercYear" DROP DEFAULT,
ALTER "PartnercYear" DROP NOT NULL,
ALTER "PartnerMobile" TYPE character varying,
ALTER "PartnerMobile" DROP DEFAULT,
ALTER "PartnerMobile" DROP NOT NULL,
ALTER "Postcode" TYPE character varying,
ALTER "Postcode" DROP DEFAULT,
ALTER "Postcode" DROP NOT NULL,
ALTER "Address5" TYPE character varying,
ALTER "Address5" DROP DEFAULT,
ALTER "Address5" DROP NOT NULL,
ALTER "FatherAddress1" TYPE character varying,
ALTER "FatherAddress1" DROP DEFAULT,
ALTER "FatherAddress1" DROP NOT NULL,
ALTER "FatherAddress2" TYPE character varying,
ALTER "FatherAddress2" DROP DEFAULT,
ALTER "FatherAddress2" DROP NOT NULL;


ALTER TABLE "discharge_medications"
ALTER "AdmissionId" TYPE integer,
ALTER "AdmissionId" DROP DEFAULT,
ALTER "AdmissionId" DROP NOT NULL,
ALTER "BabyId" TYPE integer,
ALTER "BabyId" DROP DEFAULT,
ALTER "BabyId" DROP NOT NULL,
ALTER "Medication" TYPE integer,
ALTER "Medication" DROP DEFAULT,
ALTER "Medication" DROP NOT NULL,
ALTER "Dose" TYPE character varying,
ALTER "Dose" DROP DEFAULT,
ALTER "Dose" DROP NOT NULL,
ALTER "Frequency" TYPE character varying,
ALTER "Frequency" DROP DEFAULT,
ALTER "Frequency" DROP NOT NULL,
ALTER "Duration" TYPE character varying,
ALTER "Duration" DROP DEFAULT,
ALTER "Duration" DROP NOT NULL;
COMMENT ON COLUMN "discharge_medications"."AdmissionId" IS '';
COMMENT ON COLUMN "discharge_medications"."BabyId" IS '';
COMMENT ON COLUMN "discharge_medications"."Medication" IS '';
COMMENT ON COLUMN "discharge_medications"."Dose" IS '';
COMMENT ON COLUMN "discharge_medications"."Frequency" IS '';
COMMENT ON COLUMN "discharge_medications"."Duration" IS '';
COMMENT ON TABLE "discharge_medications" IS '';


ALTER TABLE "medical_problems"
ALTER "MotherId" TYPE integer,
ALTER "MotherId" DROP DEFAULT,
ALTER "MotherId" DROP NOT NULL,
ALTER "BabyId" TYPE integer,
ALTER "BabyId" DROP DEFAULT,
ALTER "BabyId" DROP NOT NULL,
ALTER "Medication" TYPE character varying,
ALTER "Medication" DROP DEFAULT,
ALTER "Medication" DROP NOT NULL,
ALTER "Problem" TYPE integer,
ALTER "Problem" DROP DEFAULT,
ALTER "Problem" DROP NOT NULL,
ALTER "AdmissionId" TYPE integer,
ALTER "AdmissionId" SET DEFAULT '0',
ALTER "AdmissionId" DROP NOT NULL;
COMMENT ON COLUMN "medical_problems"."MotherId" IS '';
COMMENT ON COLUMN "medical_problems"."BabyId" IS '';
COMMENT ON COLUMN "medical_problems"."Medication" IS '';
COMMENT ON COLUMN "medical_problems"."Problem" IS '';
COMMENT ON COLUMN "medical_problems"."AdmissionId" IS '';
COMMENT ON TABLE "medical_problems" IS '';

ALTER TABLE "delivery_history"
ALTER "Year" TYPE character varying,
ALTER "Year" SET DEFAULT '0',
ALTER "Year" DROP NOT NULL,
ALTER "Place" TYPE character varying,
ALTER "Place" DROP DEFAULT,
ALTER "Place" DROP NOT NULL,
ALTER "Delivery" TYPE character varying,
ALTER "Delivery" DROP DEFAULT,
ALTER "Delivery" DROP NOT NULL,
ALTER "Complications" TYPE character varying,
ALTER "Complications" DROP DEFAULT,
ALTER "Complications" DROP NOT NULL,
ALTER "Gender" TYPE character varying,
ALTER "Gender" DROP DEFAULT,
ALTER "Gender" DROP NOT NULL,
ALTER "GA" TYPE character varying,
ALTER "GA" DROP DEFAULT,
ALTER "GA" DROP NOT NULL,
ALTER "BW" TYPE character varying,
ALTER "BW" DROP DEFAULT,
ALTER "BW" DROP NOT NULL,
ALTER "Health" TYPE character varying,
ALTER "Health" DROP DEFAULT,
ALTER "Health" DROP NOT NULL,
ALTER "DateAdded" TYPE timestamp,
ALTER "DateAdded" SET DEFAULT 'now()',
ALTER "DateAdded" DROP NOT NULL,
ALTER "Sequence" TYPE character varying,
ALTER "Sequence" SET DEFAULT '0',
ALTER "Sequence" DROP NOT NULL;
COMMENT ON COLUMN "delivery_history"."Year" IS '';
COMMENT ON COLUMN "delivery_history"."Place" IS '';
COMMENT ON COLUMN "delivery_history"."Delivery" IS '';
COMMENT ON COLUMN "delivery_history"."Complications" IS '';
COMMENT ON COLUMN "delivery_history"."Gender" IS '';
COMMENT ON COLUMN "delivery_history"."GA" IS '';
COMMENT ON COLUMN "delivery_history"."BW" IS '';
COMMENT ON COLUMN "delivery_history"."Health" IS '';
COMMENT ON COLUMN "delivery_history"."DateAdded" IS '';
COMMENT ON COLUMN "delivery_history"."Sequence" IS '';
COMMENT ON TABLE "delivery_history" IS '';


ALTER TABLE "daycare"
ALTER "DayTime" TYPE character varying,
ALTER "DayTime" DROP DEFAULT,
ALTER "DayTime" DROP NOT NULL,
ALTER "DayOfLife" TYPE character varying,
ALTER "DayOfLife" DROP DEFAULT,
ALTER "DayOfLife" DROP NOT NULL,
ALTER "PeripheralCannula" TYPE character varying,
ALTER "PeripheralCannula" DROP DEFAULT,
ALTER "PeripheralCannula" DROP NOT NULL,
ALTER "PvcSites" TYPE character varying,
ALTER "PvcSites" DROP DEFAULT,
ALTER "PvcSites" DROP NOT NULL,
ALTER "PvcDay" TYPE character varying,
ALTER "PvcDay" DROP DEFAULT,
ALTER "PvcDay" DROP NOT NULL,
ALTER "DayChange" TYPE character varying,
ALTER "DayChange" DROP DEFAULT,
ALTER "DayChange" DROP NOT NULL,
ALTER "PvcComplication" TYPE character varying,
ALTER "PvcComplication" DROP DEFAULT,
ALTER "PvcComplication" DROP NOT NULL,
ALTER "Picc" TYPE character varying,
ALTER "Picc" DROP DEFAULT,
ALTER "Picc" DROP NOT NULL,
ALTER "PiccSite" TYPE character varying,
ALTER "PiccSite" DROP DEFAULT,
ALTER "PiccSite" DROP NOT NULL,
ALTER "PiccDay" TYPE character varying,
ALTER "PiccDay" DROP DEFAULT,
ALTER "PiccDay" DROP NOT NULL,
ALTER "PiccComplication" TYPE character varying,
ALTER "PiccComplication" DROP DEFAULT,
ALTER "PiccComplication" DROP NOT NULL,
ALTER "Uvc" TYPE character varying,
ALTER "Uvc" DROP DEFAULT,
ALTER "Uvc" DROP NOT NULL,
ALTER "UvcPosition" TYPE character varying,
ALTER "UvcPosition" DROP DEFAULT,
ALTER "UvcPosition" DROP NOT NULL,
ALTER "UvcDay" TYPE character varying,
ALTER "UvcDay" DROP DEFAULT,
ALTER "UvcDay" DROP NOT NULL,
ALTER "UvcComplication" TYPE character varying,
ALTER "UvcComplication" DROP DEFAULT,
ALTER "UvcComplication" DROP NOT NULL,
ALTER "Uac" TYPE character varying,
ALTER "Uac" DROP DEFAULT,
ALTER "Uac" DROP NOT NULL,
ALTER "UacPosition" TYPE character varying,
ALTER "UacPosition" DROP DEFAULT,
ALTER "UacPosition" DROP NOT NULL,
ALTER "UacDay" TYPE character varying,
ALTER "UacDay" DROP DEFAULT,
ALTER "UacDay" DROP NOT NULL,
ALTER "UacComplication" TYPE character varying,
ALTER "UacComplication" DROP DEFAULT,
ALTER "UacComplication" DROP NOT NULL,
ALTER "Pac" TYPE character varying,
ALTER "Pac" DROP DEFAULT,
ALTER "Pac" DROP NOT NULL,
ALTER "PacSite" TYPE character varying,
ALTER "PacSite" DROP DEFAULT,
ALTER "PacSite" DROP NOT NULL,
ALTER "PacDay" TYPE character varying,
ALTER "PacDay" DROP DEFAULT,
ALTER "PacDay" DROP NOT NULL,
ALTER "PacComplication" TYPE character varying,
ALTER "PacComplication" DROP DEFAULT,
ALTER "PacComplication" DROP NOT NULL,
ALTER "Sepsis" TYPE character varying,
ALTER "Sepsis" DROP DEFAULT,
ALTER "Sepsis" DROP NOT NULL,
ALTER "BloodCulture" TYPE character varying,
ALTER "BloodCulture" DROP DEFAULT,
ALTER "BloodCulture" DROP NOT NULL,
ALTER "PositiveBlood" TYPE character varying,
ALTER "PositiveBlood" DROP DEFAULT,
ALTER "PositiveBlood" DROP NOT NULL,
ALTER "Meningitis" TYPE character varying,
ALTER "Meningitis" DROP DEFAULT,
ALTER "Meningitis" DROP NOT NULL,
ALTER "OtherDrugs" TYPE character varying,
ALTER "OtherDrugs" DROP DEFAULT,
ALTER "OtherDrugs" DROP NOT NULL,
ALTER "CRP" TYPE character varying,
ALTER "CRP" DROP DEFAULT,
ALTER "CRP" DROP NOT NULL,
ALTER "TLC" TYPE character varying,
ALTER "TLC" DROP DEFAULT,
ALTER "TLC" DROP NOT NULL,
ALTER "Percentage" TYPE character varying,
ALTER "Percentage" DROP DEFAULT,
ALTER "Percentage" DROP NOT NULL,
ALTER "ANC" TYPE character varying,
ALTER "ANC" DROP DEFAULT,
ALTER "ANC" DROP NOT NULL,
ALTER "Platelets" TYPE character varying,
ALTER "Platelets" DROP DEFAULT,
ALTER "Platelets" DROP NOT NULL,
ALTER "TotalFluid" TYPE character varying,
ALTER "TotalFluid" DROP DEFAULT,
ALTER "TotalFluid" DROP NOT NULL,
ALTER "PreviousWt" TYPE character varying,
ALTER "PreviousWt" DROP DEFAULT,
ALTER "PreviousWt" DROP NOT NULL,
ALTER "CurrentWt" TYPE character varying,
ALTER "CurrentWt" DROP DEFAULT,
ALTER "CurrentWt" DROP NOT NULL,
ALTER "WtChange" TYPE character varying,
ALTER "WtChange" DROP DEFAULT,
ALTER "WtChange" DROP NOT NULL,
ALTER "PercentageChange" TYPE character varying,
ALTER "PercentageChange" DROP DEFAULT,
ALTER "PercentageChange" DROP NOT NULL,
ALTER "UrineOutput" TYPE character varying,
ALTER "UrineOutput" DROP DEFAULT,
ALTER "UrineOutput" DROP NOT NULL,
ALTER "UO" TYPE character varying,
ALTER "UO" DROP DEFAULT,
ALTER "UO" DROP NOT NULL,
ALTER "BloodOut" TYPE character varying,
ALTER "BloodOut" DROP DEFAULT,
ALTER "BloodOut" DROP NOT NULL,
ALTER "DrainOutput" TYPE character varying,
ALTER "DrainOutput" DROP DEFAULT,
ALTER "DrainOutput" DROP NOT NULL,
ALTER "RBS" TYPE character varying,
ALTER "RBS" DROP DEFAULT,
ALTER "RBS" DROP NOT NULL,
ALTER "SerumNa" TYPE character varying,
ALTER "SerumNa" DROP DEFAULT,
ALTER "SerumNa" DROP NOT NULL,
ALTER "SerumK" TYPE character varying,
ALTER "SerumK" DROP DEFAULT,
ALTER "SerumK" DROP NOT NULL,
ALTER "Transfusion" TYPE character varying,
ALTER "Transfusion" DROP DEFAULT,
ALTER "Transfusion" DROP NOT NULL,
ALTER "AnteriorFontanelle" TYPE character varying,
ALTER "AnteriorFontanelle" DROP DEFAULT,
ALTER "AnteriorFontanelle" DROP NOT NULL,
ALTER "Activity" TYPE character varying,
ALTER "Activity" DROP DEFAULT,
ALTER "Activity" DROP NOT NULL,
ALTER "Tone" TYPE character varying,
ALTER "Tone" DROP DEFAULT,
ALTER "Tone" DROP NOT NULL,
ALTER "Cry" TYPE character varying,
ALTER "Cry" DROP DEFAULT,
ALTER "Cry" DROP NOT NULL,
ALTER "Seizures" TYPE character varying,
ALTER "Seizures" DROP DEFAULT,
ALTER "Seizures" DROP NOT NULL,
ALTER "TypeOfSeizures" TYPE character varying,
ALTER "TypeOfSeizures" DROP DEFAULT,
ALTER "TypeOfSeizures" DROP NOT NULL,
ALTER "NeonatalReflexes" TYPE character varying,
ALTER "NeonatalReflexes" DROP DEFAULT,
ALTER "NeonatalReflexes" DROP NOT NULL,
ALTER "Feeds" TYPE character varying,
ALTER "Feeds" DROP DEFAULT,
ALTER "Feeds" DROP NOT NULL,
ALTER "Volume" TYPE character varying,
ALTER "Volume" DROP DEFAULT,
ALTER "Volume" DROP NOT NULL,
ALTER "Frequency" TYPE character varying,
ALTER "Frequency" DROP DEFAULT,
ALTER "Frequency" DROP NOT NULL,
ALTER "Ivf" TYPE character varying,
ALTER "Ivf" DROP DEFAULT,
ALTER "Ivf" DROP NOT NULL,
ALTER "Tpn" TYPE character varying,
ALTER "Tpn" DROP DEFAULT,
ALTER "Tpn" DROP NOT NULL,
ALTER "MlKgd" TYPE character varying,
ALTER "MlKgd" DROP DEFAULT,
ALTER "MlKgd" DROP NOT NULL,
ALTER "AspirateVolume" TYPE character varying,
ALTER "AspirateVolume" DROP DEFAULT,
ALTER "AspirateVolume" DROP NOT NULL,
ALTER "AspirateNature" TYPE character varying,
ALTER "AspirateNature" DROP DEFAULT,
ALTER "AspirateNature" DROP NOT NULL,
ALTER "Stools" TYPE character varying,
ALTER "Stools" DROP DEFAULT,
ALTER "Stools" DROP NOT NULL,
ALTER "StoolNature" TYPE character varying,
ALTER "StoolNature" DROP DEFAULT,
ALTER "StoolNature" DROP NOT NULL,
ALTER "Abdomen" TYPE character varying,
ALTER "Abdomen" DROP DEFAULT,
ALTER "Abdomen" DROP NOT NULL,
ALTER "BowelSounds" TYPE character varying,
ALTER "BowelSounds" DROP DEFAULT,
ALTER "BowelSounds" DROP NOT NULL,
ALTER "AbdominalGirth" TYPE character varying,
ALTER "AbdominalGirth" DROP DEFAULT,
ALTER "AbdominalGirth" DROP NOT NULL,
ALTER "Umbilicus" TYPE character varying,
ALTER "Umbilicus" DROP DEFAULT,
ALTER "Umbilicus" DROP NOT NULL,
ALTER "Hepatomegaly" TYPE character varying,
ALTER "Hepatomegaly" DROP DEFAULT,
ALTER "Hepatomegaly" DROP NOT NULL,
ALTER "LiverSpan" TYPE character varying,
ALTER "LiverSpan" DROP DEFAULT,
ALTER "LiverSpan" DROP NOT NULL,
ALTER "Splenomegaly" TYPE character varying,
ALTER "Splenomegaly" DROP DEFAULT,
ALTER "Splenomegaly" DROP NOT NULL,
ALTER "SpleenSpan" TYPE character varying,
ALTER "SpleenSpan" DROP DEFAULT,
ALTER "SpleenSpan" DROP NOT NULL,
ALTER "Herina" TYPE character varying,
ALTER "Herina" DROP DEFAULT,
ALTER "Herina" DROP NOT NULL,
ALTER "Genitalia" TYPE character varying,
ALTER "Genitalia" DROP DEFAULT,
ALTER "Genitalia" DROP NOT NULL,
ALTER "Hips" TYPE character varying,
ALTER "Hips" DROP DEFAULT,
ALTER "Hips" DROP NOT NULL,
ALTER "TSB" TYPE character varying,
ALTER "TSB" DROP DEFAULT,
ALTER "TSB" DROP NOT NULL,
ALTER "NNJTreatment" TYPE character varying,
ALTER "NNJTreatment" DROP DEFAULT,
ALTER "NNJTreatment" DROP NOT NULL,
ALTER "HR" TYPE character varying,
ALTER "HR" DROP DEFAULT,
ALTER "HR" DROP NOT NULL,
ALTER "BP" TYPE character varying,
ALTER "BP" DROP DEFAULT,
ALTER "BP" DROP NOT NULL,
ALTER "MeanBP" TYPE character varying,
ALTER "MeanBP" DROP DEFAULT,
ALTER "MeanBP" DROP NOT NULL,
ALTER "PulsePressure" TYPE character varying,
ALTER "PulsePressure" DROP DEFAULT,
ALTER "PulsePressure" DROP NOT NULL,
ALTER "CentralPulses" TYPE character varying,
ALTER "CentralPulses" DROP DEFAULT,
ALTER "CentralPulses" DROP NOT NULL,
ALTER "PeripheralPulses" TYPE character varying,
ALTER "PeripheralPulses" DROP DEFAULT,
ALTER "PeripheralPulses" DROP NOT NULL,
ALTER "FemoralPulses" TYPE character varying,
ALTER "FemoralPulses" DROP DEFAULT,
ALTER "FemoralPulses" DROP NOT NULL,
ALTER "PrecordialActivity" TYPE character varying,
ALTER "PrecordialActivity" DROP DEFAULT,
ALTER "PrecordialActivity" DROP NOT NULL,
ALTER "S1S2" TYPE character varying,
ALTER "S1S2" DROP DEFAULT,
ALTER "S1S2" DROP NOT NULL,
ALTER "Murmur" TYPE character varying,
ALTER "Murmur" DROP DEFAULT,
ALTER "Murmur" DROP NOT NULL,
ALTER "CharacterOfMurmur" TYPE character varying,
ALTER "CharacterOfMurmur" DROP DEFAULT,
ALTER "CharacterOfMurmur" DROP NOT NULL,
ALTER "CFT" TYPE character varying,
ALTER "CFT" DROP DEFAULT,
ALTER "CFT" DROP NOT NULL,
ALTER "CentralTemperature" TYPE character varying,
ALTER "CentralTemperature" DROP DEFAULT,
ALTER "CentralTemperature" DROP NOT NULL,
ALTER "PeripheralTemperature" TYPE character varying,
ALTER "PeripheralTemperature" DROP DEFAULT,
ALTER "PeripheralTemperature" DROP NOT NULL,
ALTER "Color" TYPE character varying,
ALTER "Color" DROP DEFAULT,
ALTER "Color" DROP NOT NULL,
ALTER "Inotropes" TYPE character varying,
ALTER "Inotropes" DROP DEFAULT,
ALTER "Inotropes" DROP NOT NULL,
ALTER "Dopamine" TYPE character varying,
ALTER "Dopamine" DROP DEFAULT,
ALTER "Dopamine" DROP NOT NULL,
ALTER "Dobutamine" TYPE character varying,
ALTER "Dobutamine" DROP DEFAULT,
ALTER "Dobutamine" DROP NOT NULL,
ALTER "Adrenaline" TYPE character varying,
ALTER "Adrenaline" DROP DEFAULT,
ALTER "Adrenaline" DROP NOT NULL,
ALTER "ModeOfVentilation" TYPE character varying,
ALTER "ModeOfVentilation" DROP DEFAULT,
ALTER "ModeOfVentilation" DROP NOT NULL,
ALTER "RR" TYPE character varying,
ALTER "RR" DROP DEFAULT,
ALTER "RR" DROP NOT NULL,
ALTER "Retractions" TYPE character varying,
ALTER "Retractions" DROP DEFAULT,
ALTER "Retractions" DROP NOT NULL,
ALTER "AirEntry" TYPE character varying,
ALTER "AirEntry" DROP DEFAULT,
ALTER "AirEntry" DROP NOT NULL,
ALTER "ChestMovement" TYPE character varying,
ALTER "ChestMovement" DROP DEFAULT,
ALTER "ChestMovement" DROP NOT NULL,
ALTER "AddedSounds" TYPE character varying,
ALTER "AddedSounds" DROP DEFAULT,
ALTER "AddedSounds" DROP NOT NULL,
ALTER "DayCharacter" TYPE character varying,
ALTER "DayCharacter" DROP DEFAULT,
ALTER "DayCharacter" DROP NOT NULL,
ALTER "Indication" TYPE character varying,
ALTER "Indication" DROP DEFAULT,
ALTER "Indication" DROP NOT NULL,
ALTER "PIP" TYPE character varying,
ALTER "PIP" DROP DEFAULT,
ALTER "PIP" DROP NOT NULL,
ALTER "PEEP" TYPE character varying,
ALTER "PEEP" DROP DEFAULT,
ALTER "PEEP" DROP NOT NULL,
ALTER "MAP" TYPE character varying,
ALTER "MAP" DROP DEFAULT,
ALTER "MAP" DROP NOT NULL,
ALTER "FiO2" TYPE character varying,
ALTER "FiO2" DROP DEFAULT,
ALTER "FiO2" DROP NOT NULL,
ALTER "Rate" TYPE character varying,
ALTER "Rate" DROP DEFAULT,
ALTER "Rate" DROP NOT NULL,
ALTER "IT" TYPE character varying,
ALTER "IT" DROP DEFAULT,
ALTER "IT" DROP NOT NULL,
ALTER "LastBG" TYPE character varying,
ALTER "LastBG" DROP DEFAULT,
ALTER "LastBG" DROP NOT NULL,
ALTER "TypeOfBloodGas" TYPE character varying,
ALTER "TypeOfBloodGas" DROP DEFAULT,
ALTER "TypeOfBloodGas" DROP NOT NULL,
ALTER "Ph" TYPE character varying,
ALTER "Ph" DROP DEFAULT,
ALTER "Ph" DROP NOT NULL,
ALTER "PaO2" TYPE character varying,
ALTER "PaO2" DROP DEFAULT,
ALTER "PaO2" DROP NOT NULL,
ALTER "PaCo2" TYPE character varying,
ALTER "PaCo2" DROP DEFAULT,
ALTER "PaCo2" DROP NOT NULL,
ALTER "HCO3" TYPE character varying,
ALTER "HCO3" DROP DEFAULT,
ALTER "HCO3" DROP NOT NULL,
ALTER "BE" TYPE character varying,
ALTER "BE" DROP DEFAULT,
ALTER "BE" DROP NOT NULL,
ALTER "Lactate" TYPE character varying,
ALTER "Lactate" DROP DEFAULT,
ALTER "Lactate" DROP NOT NULL,
ALTER "EtTube" TYPE character varying,
ALTER "EtTube" DROP DEFAULT,
ALTER "EtTube" DROP NOT NULL,
ALTER "Size" TYPE character varying,
ALTER "Size" DROP DEFAULT,
ALTER "Size" DROP NOT NULL,
ALTER "Lips" TYPE character varying,
ALTER "Lips" DROP DEFAULT,
ALTER "Lips" DROP NOT NULL,
ALTER "SaO2PostDuctal" TYPE character varying,
ALTER "SaO2PostDuctal" DROP DEFAULT,
ALTER "SaO2PostDuctal" DROP NOT NULL,
ALTER "AaDO2" TYPE character varying,
ALTER "AaDO2" DROP DEFAULT,
ALTER "AaDO2" DROP NOT NULL,
ALTER "OI" TYPE character varying,
ALTER "OI" DROP DEFAULT,
ALTER "OI" DROP NOT NULL,
ALTER "DateAdded" TYPE timestamp(0),
ALTER "DateAdded" DROP DEFAULT,
ALTER "DateAdded" DROP NOT NULL,
ALTER "DateModified" TYPE timestamp(0),
ALTER "DateModified" DROP DEFAULT,
ALTER "DateModified" DROP NOT NULL,
ALTER "UserAdded" TYPE character varying,
ALTER "UserAdded" DROP DEFAULT,
ALTER "UserAdded" DROP NOT NULL,
ALTER "UserDeleted" TYPE character varying,
ALTER "UserDeleted" DROP DEFAULT,
ALTER "UserDeleted" DROP NOT NULL,
ALTER "PDA" TYPE character varying,
ALTER "PDA" DROP DEFAULT,
ALTER "PDA" DROP NOT NULL,
ALTER "PDATreatment" TYPE character varying,
ALTER "PDATreatment" DROP DEFAULT,
ALTER "PDATreatment" DROP NOT NULL,
ALTER "InvasiveVentilation" TYPE character varying,
ALTER "InvasiveVentilation" DROP DEFAULT,
ALTER "InvasiveVentilation" DROP NOT NULL,
ALTER "DayTime_MINS" TYPE character varying,
ALTER "DayTime_MINS" DROP DEFAULT,
ALTER "DayTime_MINS" DROP NOT NULL,
ALTER "DayTime_AM" TYPE character varying,
ALTER "DayTime_AM" DROP DEFAULT,
ALTER "DayTime_AM" DROP NOT NULL,
ALTER "NonInvasiveVentilation" TYPE character varying,
ALTER "NonInvasiveVentilation" DROP DEFAULT,
ALTER "NonInvasiveVentilation" DROP NOT NULL,
ALTER "OtherRespiratorySupport" TYPE character varying,
ALTER "OtherRespiratorySupport" DROP DEFAULT,
ALTER "OtherRespiratorySupport" DROP NOT NULL,
ALTER "FullEnteralFeeds" TYPE character varying,
ALTER "FullEnteralFeeds" DROP DEFAULT,
ALTER "FullEnteralFeeds" DROP NOT NULL,
ALTER "TypeofFeeds" TYPE character varying,
ALTER "TypeofFeeds" DROP DEFAULT,
ALTER "TypeofFeeds" DROP NOT NULL,
ALTER "NECtreatment" TYPE character varying,
ALTER "NECtreatment" DROP DEFAULT,
ALTER "NECtreatment" DROP NOT NULL,
ALTER "NEC" TYPE character varying,
ALTER "NEC" DROP DEFAULT,
ALTER "NEC" DROP NOT NULL,
ALTER "Hypoglycemia" TYPE character varying,
ALTER "Hypoglycemia" DROP DEFAULT,
ALTER "Hypoglycemia" DROP NOT NULL,
ALTER "Hyperglycemia" TYPE character varying,
ALTER "Hyperglycemia" DROP DEFAULT,
ALTER "Hyperglycemia" DROP NOT NULL,
ALTER "InsulinTherapy" TYPE character varying,
ALTER "InsulinTherapy" DROP DEFAULT,
ALTER "InsulinTherapy" DROP NOT NULL,
ALTER "Hyponatremia" TYPE character varying,
ALTER "Hyponatremia" DROP DEFAULT,
ALTER "Hyponatremia" DROP NOT NULL,
ALTER "Hypernatremia" TYPE character varying,
ALTER "Hypernatremia" DROP DEFAULT,
ALTER "Hypernatremia" DROP NOT NULL,
ALTER "Hypokalemia" TYPE character varying,
ALTER "Hypokalemia" DROP DEFAULT,
ALTER "Hypokalemia" DROP NOT NULL,
ALTER "Hyperkalemia" TYPE character varying,
ALTER "Hyperkalemia" DROP DEFAULT,
ALTER "Hyperkalemia" DROP NOT NULL,
ALTER "Hypocalcemia" TYPE character varying,
ALTER "Hypocalcemia" DROP DEFAULT,
ALTER "Hypocalcemia" DROP NOT NULL,
ALTER "Hypercalcemia" TYPE character varying,
ALTER "Hypercalcemia" DROP DEFAULT,
ALTER "Hypercalcemia" DROP NOT NULL,
ALTER "Immunoglobulins" TYPE character varying,
ALTER "Immunoglobulins" DROP DEFAULT,
ALTER "Immunoglobulins" DROP NOT NULL,
ALTER "therapeutic_hypothermia" TYPE character varying,
ALTER "therapeutic_hypothermia" DROP DEFAULT,
ALTER "therapeutic_hypothermia" DROP NOT NULL;
COMMENT ON COLUMN "daycare"."DayTime" IS '';
COMMENT ON COLUMN "daycare"."DayOfLife" IS '';
COMMENT ON COLUMN "daycare"."PeripheralCannula" IS '';
COMMENT ON COLUMN "daycare"."PvcSites" IS '';
COMMENT ON COLUMN "daycare"."PvcDay" IS '';
COMMENT ON COLUMN "daycare"."DayChange" IS '';
COMMENT ON COLUMN "daycare"."PvcComplication" IS '';
COMMENT ON COLUMN "daycare"."Picc" IS '';
COMMENT ON COLUMN "daycare"."PiccSite" IS '';
COMMENT ON COLUMN "daycare"."PiccDay" IS '';
COMMENT ON COLUMN "daycare"."PiccComplication" IS '';
COMMENT ON COLUMN "daycare"."Uvc" IS '';
COMMENT ON COLUMN "daycare"."UvcPosition" IS '';
COMMENT ON COLUMN "daycare"."UvcDay" IS '';
COMMENT ON COLUMN "daycare"."UvcComplication" IS '';
COMMENT ON COLUMN "daycare"."Uac" IS '';
COMMENT ON COLUMN "daycare"."UacPosition" IS '';
COMMENT ON COLUMN "daycare"."UacDay" IS '';
COMMENT ON COLUMN "daycare"."UacComplication" IS '';
COMMENT ON COLUMN "daycare"."Pac" IS '';
COMMENT ON COLUMN "daycare"."PacSite" IS '';
COMMENT ON COLUMN "daycare"."PacDay" IS '';
COMMENT ON COLUMN "daycare"."PacComplication" IS '';
COMMENT ON COLUMN "daycare"."Sepsis" IS '';
COMMENT ON COLUMN "daycare"."BloodCulture" IS '';
COMMENT ON COLUMN "daycare"."PositiveBlood" IS '';
COMMENT ON COLUMN "daycare"."Meningitis" IS '';
COMMENT ON COLUMN "daycare"."OtherDrugs" IS '';
COMMENT ON COLUMN "daycare"."CRP" IS '';
COMMENT ON COLUMN "daycare"."TLC" IS '';
COMMENT ON COLUMN "daycare"."Percentage" IS '';
COMMENT ON COLUMN "daycare"."ANC" IS '';
COMMENT ON COLUMN "daycare"."Platelets" IS '';
COMMENT ON COLUMN "daycare"."TotalFluid" IS '';
COMMENT ON COLUMN "daycare"."PreviousWt" IS '';
COMMENT ON COLUMN "daycare"."CurrentWt" IS '';
COMMENT ON COLUMN "daycare"."WtChange" IS '';
COMMENT ON COLUMN "daycare"."PercentageChange" IS '';
COMMENT ON COLUMN "daycare"."UrineOutput" IS '';
COMMENT ON COLUMN "daycare"."UO" IS '';
COMMENT ON COLUMN "daycare"."BloodOut" IS '';
COMMENT ON COLUMN "daycare"."DrainOutput" IS '';
COMMENT ON COLUMN "daycare"."RBS" IS '';
COMMENT ON COLUMN "daycare"."SerumNa" IS '';
COMMENT ON COLUMN "daycare"."SerumK" IS '';
COMMENT ON COLUMN "daycare"."Transfusion" IS '';
COMMENT ON COLUMN "daycare"."AnteriorFontanelle" IS '';
COMMENT ON COLUMN "daycare"."Activity" IS '';
COMMENT ON COLUMN "daycare"."Tone" IS '';
COMMENT ON COLUMN "daycare"."Cry" IS '';
COMMENT ON COLUMN "daycare"."Seizures" IS '';
COMMENT ON COLUMN "daycare"."TypeOfSeizures" IS '';
COMMENT ON COLUMN "daycare"."NeonatalReflexes" IS '';
COMMENT ON COLUMN "daycare"."Feeds" IS '';
COMMENT ON COLUMN "daycare"."Volume" IS '';
COMMENT ON COLUMN "daycare"."Frequency" IS '';
COMMENT ON COLUMN "daycare"."Ivf" IS '';
COMMENT ON COLUMN "daycare"."Tpn" IS '';
COMMENT ON COLUMN "daycare"."MlKgd" IS '';
COMMENT ON COLUMN "daycare"."AspirateVolume" IS '';
COMMENT ON COLUMN "daycare"."AspirateNature" IS '';
COMMENT ON COLUMN "daycare"."Stools" IS '';
COMMENT ON COLUMN "daycare"."StoolNature" IS '';
COMMENT ON COLUMN "daycare"."Abdomen" IS '';
COMMENT ON COLUMN "daycare"."BowelSounds" IS '';
COMMENT ON COLUMN "daycare"."AbdominalGirth" IS '';
COMMENT ON COLUMN "daycare"."Umbilicus" IS '';
COMMENT ON COLUMN "daycare"."Hepatomegaly" IS '';
COMMENT ON COLUMN "daycare"."LiverSpan" IS '';
COMMENT ON COLUMN "daycare"."Splenomegaly" IS '';
COMMENT ON COLUMN "daycare"."SpleenSpan" IS '';
COMMENT ON COLUMN "daycare"."Herina" IS '';
COMMENT ON COLUMN "daycare"."Genitalia" IS '';
COMMENT ON COLUMN "daycare"."Hips" IS '';
COMMENT ON COLUMN "daycare"."TSB" IS '';
COMMENT ON COLUMN "daycare"."NNJTreatment" IS '';
COMMENT ON COLUMN "daycare"."HR" IS '';
COMMENT ON COLUMN "daycare"."BP" IS '';
COMMENT ON COLUMN "daycare"."MeanBP" IS '';
COMMENT ON COLUMN "daycare"."PulsePressure" IS '';
COMMENT ON COLUMN "daycare"."CentralPulses" IS '';
COMMENT ON COLUMN "daycare"."PeripheralPulses" IS '';
COMMENT ON COLUMN "daycare"."FemoralPulses" IS '';
COMMENT ON COLUMN "daycare"."PrecordialActivity" IS '';
COMMENT ON COLUMN "daycare"."S1S2" IS '';
COMMENT ON COLUMN "daycare"."Murmur" IS '';
COMMENT ON COLUMN "daycare"."CharacterOfMurmur" IS '';
COMMENT ON COLUMN "daycare"."CFT" IS '';
COMMENT ON COLUMN "daycare"."CentralTemperature" IS '';
COMMENT ON COLUMN "daycare"."PeripheralTemperature" IS '';
COMMENT ON COLUMN "daycare"."Color" IS '';
COMMENT ON COLUMN "daycare"."Inotropes" IS '';
COMMENT ON COLUMN "daycare"."Dopamine" IS '';
COMMENT ON COLUMN "daycare"."Dobutamine" IS '';
COMMENT ON COLUMN "daycare"."Adrenaline" IS '';
COMMENT ON COLUMN "daycare"."ModeOfVentilation" IS '';
COMMENT ON COLUMN "daycare"."RR" IS '';
COMMENT ON COLUMN "daycare"."Retractions" IS '';
COMMENT ON COLUMN "daycare"."AirEntry" IS '';
COMMENT ON COLUMN "daycare"."ChestMovement" IS '';
COMMENT ON COLUMN "daycare"."AddedSounds" IS '';
COMMENT ON COLUMN "daycare"."DayCharacter" IS '';
COMMENT ON COLUMN "daycare"."Indication" IS '';
COMMENT ON COLUMN "daycare"."PIP" IS '';
COMMENT ON COLUMN "daycare"."PEEP" IS '';
COMMENT ON COLUMN "daycare"."MAP" IS '';
COMMENT ON COLUMN "daycare"."FiO2" IS '';
COMMENT ON COLUMN "daycare"."Rate" IS '';
COMMENT ON COLUMN "daycare"."IT" IS '';
COMMENT ON COLUMN "daycare"."LastBG" IS '';
COMMENT ON COLUMN "daycare"."TypeOfBloodGas" IS '';
COMMENT ON COLUMN "daycare"."Ph" IS '';
COMMENT ON COLUMN "daycare"."PaO2" IS '';
COMMENT ON COLUMN "daycare"."PaCo2" IS '';
COMMENT ON COLUMN "daycare"."HCO3" IS '';
COMMENT ON COLUMN "daycare"."BE" IS '';
COMMENT ON COLUMN "daycare"."Lactate" IS '';
COMMENT ON COLUMN "daycare"."EtTube" IS '';
COMMENT ON COLUMN "daycare"."Size" IS '';
COMMENT ON COLUMN "daycare"."Lips" IS '';
COMMENT ON COLUMN "daycare"."SaO2PostDuctal" IS '';
COMMENT ON COLUMN "daycare"."AaDO2" IS '';
COMMENT ON COLUMN "daycare"."OI" IS '';
COMMENT ON COLUMN "daycare"."DateAdded" IS '';
COMMENT ON COLUMN "daycare"."DateModified" IS '';
COMMENT ON COLUMN "daycare"."UserAdded" IS '';
COMMENT ON COLUMN "daycare"."UserDeleted" IS '';
COMMENT ON COLUMN "daycare"."PDA" IS '';
COMMENT ON COLUMN "daycare"."PDATreatment" IS '';
COMMENT ON COLUMN "daycare"."InvasiveVentilation" IS '';
COMMENT ON COLUMN "daycare"."DayTime_MINS" IS '';
COMMENT ON COLUMN "daycare"."DayTime_AM" IS '';
COMMENT ON COLUMN "daycare"."NonInvasiveVentilation" IS '';
COMMENT ON COLUMN "daycare"."OtherRespiratorySupport" IS '';
COMMENT ON COLUMN "daycare"."FullEnteralFeeds" IS '';
COMMENT ON COLUMN "daycare"."TypeofFeeds" IS '';
COMMENT ON COLUMN "daycare"."NECtreatment" IS '';
COMMENT ON COLUMN "daycare"."NEC" IS '';
COMMENT ON COLUMN "daycare"."Hypoglycemia" IS '';
COMMENT ON COLUMN "daycare"."Hyperglycemia" IS '';
COMMENT ON COLUMN "daycare"."InsulinTherapy" IS '';
COMMENT ON COLUMN "daycare"."Hyponatremia" IS '';
COMMENT ON COLUMN "daycare"."Hypernatremia" IS '';
COMMENT ON COLUMN "daycare"."Hypokalemia" IS '';
COMMENT ON COLUMN "daycare"."Hyperkalemia" IS '';
COMMENT ON COLUMN "daycare"."Hypocalcemia" IS '';
COMMENT ON COLUMN "daycare"."Hypercalcemia" IS '';
COMMENT ON COLUMN "daycare"."Immunoglobulins" IS '';
COMMENT ON COLUMN "daycare"."therapeutic_hypothermia" IS '';
COMMENT ON TABLE "daycare" IS '';

ALTER TABLE "delivery_history"
DROP "Sequence";
COMMENT ON TABLE "delivery_history" IS '';

UPDATE "neonatal_proforma" SET "NatureofLabour" = 'Spontaneous' WHERE "NatureofLabour" = 'Spontaneus';


ALTER TABLE "nicu_admission"
ALTER "diedTime" TYPE integer,
ALTER "diedTime" DROP DEFAULT,
ALTER "diedTime" DROP NOT NULL,
ALTER "diedMins" TYPE integer,
ALTER "diedMins" DROP DEFAULT,
ALTER "diedMins" DROP NOT NULL;
COMMENT ON COLUMN "nicu_admission"."diedTime" IS '';
COMMENT ON COLUMN "nicu_admission"."diedMins" IS '';
COMMENT ON TABLE "nicu_admission" IS '';


ALTER TABLE "op_details"
ALTER "CurrentLength" TYPE numeric(5,1),
ALTER "CurrentLength" DROP DEFAULT,
ALTER "CurrentLength" DROP NOT NULL,
ALTER "CurrentOFC" TYPE numeric(5,1),
ALTER "CurrentOFC" DROP DEFAULT,
ALTER "CurrentOFC" DROP NOT NULL;
COMMENT ON COLUMN "op_details"."CurrentLength" IS '';
COMMENT ON COLUMN "op_details"."CurrentOFC" IS '';
COMMENT ON TABLE "op_details" IS '';


ALTER TABLE "op_details_audit"
ALTER "CurrentLength" TYPE numeric(5,1),
ALTER "CurrentLength" DROP DEFAULT,
ALTER "CurrentLength" DROP NOT NULL,
ALTER "CurrentOFC" TYPE numeric(5,1),
ALTER "CurrentOFC" DROP DEFAULT,
ALTER "CurrentOFC" DROP NOT NULL;
COMMENT ON COLUMN "op_details_audit"."CurrentLength" IS '';
COMMENT ON COLUMN "op_details_audit"."CurrentOFC" IS '';
COMMENT ON TABLE "op_details_audit" IS '';

ALTER TABLE "op_details"
ADD "fee_status" boolean NULL,
ADD "fee_amount" integer NULL;
COMMENT ON TABLE "op_details" IS '';

ALTER TABLE "nicu_admission"
ADD "additional_information" text NULL,
ADD "oae_left" text NULL,
ADD "oae_right" text NULL,
ADD "abr_left" text NULL,
ADD "abr_right" text NULL,
ADD "result_rop_left" text NULL,
ADD "result_rop_right" text NULL,
ADD "typeoftreatment_left" jsonb NULL,
ADD "typeoftreatment_right" jsonb NULL,
ADD "cranial_ultrasound" text NULL,
ADD "echocardiography" text NULL,
ADD "advice" text NULL,
ADD "plan_follow_up" text NULL,
ADD "cardiacmurmur" text NULL,
ADD "PostductalSaturation" text NULL,
ADD "gentila" text NULL,
ADD "procedures" jsonb NULL,
ADD "Eyes" text NULL,
ADD "Hips" text NULL,
ADD "nicu_malformation" text NULL,
ADD "nicu_malformation_details" text NULL;
COMMENT ON TABLE "nicu_admission" IS '';

ALTER TABLE "nicu_admission_audit"
ADD "additional_information" text NULL,
ADD "oae_left" text NULL;
ADD "oae_right" text NULL;
ADD "abr_left" text NULL;
ADD "abr_right" text NULL;
ADD "result_rop_left" text NULL;
ADD "result_rop_right" text NULL;
ADD "typeoftreatment_left" jsonb NULL;
ADD "typeoftreatment_right" jsonb NULL;
ADD "cranial_ultrasound" text NULL;
ADD "echocardiography" text NULL;
ADD "advice" text NULL;
ADD "plan_follow_up" text NULL;
ADD "cardiacmurmur" text NULL;
ADD "PostductalSaturation" text NULL;
ADD "gentila" text NULL;
ADD "procedures" jsonb NULL;
ADD "Eyes" text NULL;
ADD "Hips" text NULL;
ADD "nicu_malformation" text NULL;
ADD "nicu_malformation_details" text NULL;



ALTER TABLE "op_details_audit"
ADD "fee_status" boolean NULL,
ADD "fee_amount" integer NULL;
COMMENT ON TABLE "op_details" IS '';


ALTER TABLE "op_details"
ALTER "fee_status" TYPE boolean,
ALTER "fee_status" SET DEFAULT '0',
ALTER "fee_status" DROP NOT NULL;
COMMENT ON COLUMN "op_details"."fee_status" IS '';
COMMENT ON TABLE "op_details" IS '';


ALTER TABLE "op_details_audit"
ALTER "fee_status" TYPE boolean,
ALTER "fee_status" SET DEFAULT '0',
ALTER "fee_status" DROP NOT NULL;
COMMENT ON COLUMN "op_details"."fee_status" IS '';
COMMENT ON TABLE "op_details" IS '';


update "daycare" set "AdmissionId" ='539' where "BabyId" ='588';



