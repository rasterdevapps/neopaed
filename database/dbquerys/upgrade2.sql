/*23-03-2018*/

ALTER TABLE "nicu_admission"
ADD "air_flow_temp" double precision NULL,
ADD "oxgen_flow_temp" double precision NULL;
COMMENT ON TABLE "nicu_admission" IS ;


/* run after the seeder */

ALTER TABLE "nicu_admission"
DROP "air_flow",
DROP "oxgen_flow",
ALTER "air_flow_temp" TYPE double precision,
ALTER "air_flow_temp" DROP DEFAULT,
ALTER "air_flow_temp" DROP NOT NULL,
ALTER "oxgen_flow_temp" TYPE double precision,
ALTER "oxgen_flow_temp" DROP DEFAULT,
ALTER "oxgen_flow_temp" DROP NOT NULL;
ALTER TABLE "nicu_admission" RENAME "air_flow_temp" TO "air_flow";
COMMENT ON COLUMN "nicu_admission"."air_flow" IS '';
ALTER TABLE "nicu_admission" RENAME "oxgen_flow_temp" TO "oxgen_flow";
COMMENT ON COLUMN "nicu_admission"."oxgen_flow" IS '';
COMMENT ON TABLE "nicu_admission" IS '';



ALTER TABLE "daycare"
ALTER "AaDO2" TYPE character varying(255),
ALTER "AaDO2" DROP DEFAULT,
ALTER "AaDO2" DROP NOT NULL;
COMMENT ON COLUMN "daycare"."AaDO2" IS '';
COMMENT ON TABLE "daycare" IS '';


UPDATE "daycare" SET "AaDO2" = '' WHERE "AaDO2" = 'NULL';

ALTER TABLE "neonatal_proforma"
ADD "timeofgasp_status" boolean NULL DEFAULT 'false',
ADD "regularrespiration_status" boolean NULL DEFAULT 'false',
ADD "insertion_status" boolean NULL DEFAULT 'false';
COMMENT ON TABLE "neonatal_proforma" IS '';


ALTER TABLE "neonatal_proforma"
ADD "ppv_status" boolean NULL DEFAULT 'false';

ALTER TABLE "neonatal_proforma"
ADD "cpr_status" boolean NULL DEFAULT 'false';


ALTER TABLE "daycare"
ALTER "Immunoglobulins" TYPE character varying,
ALTER "Immunoglobulins" SET DEFAULT 'NULL',
ALTER "Immunoglobulins" DROP NOT NULL;
COMMENT ON COLUMN "daycare"."Immunoglobulins" IS '';
COMMENT ON TABLE "daycare" IS '';

UPDATE "daycare" SET "Frequency" = '' WHERE "Frequency" = '0';

UPDATE "daycare" SET "TypeofFeeds" = '' WHERE "TypeofFeeds" = 'Not applicable';

ALTER TABLE "daycare"
ALTER "DayTime_AM" TYPE character varying,
ALTER "DayTime_AM" SET DEFAULT 'NULL',
ALTER "DayTime_AM" DROP NOT NULL;
COMMENT ON COLUMN "daycare"."DayTime_AM" IS '';
COMMENT ON TABLE "daycare" IS '';

ALTER TABLE "daycare"
ALTER "CGA" TYPE character varying,
ALTER "CGA" DROP DEFAULT,
ALTER "CGA" DROP NOT NULL,
ALTER "Care" TYPE character varying,
ALTER "Care" DROP DEFAULT,
ALTER "Care" DROP NOT NULL,
ALTER "Organism" TYPE text,
ALTER "Organism" DROP DEFAULT,
ALTER "Organism" DROP NOT NULL,
ALTER "pphn" TYPE text,
ALTER "pphn" DROP DEFAULT,
ALTER "pphn" DROP NOT NULL,
ALTER "pphn_treatement" TYPE text,
ALTER "pphn_treatement" DROP DEFAULT,
ALTER "pphn_treatement" DROP NOT NULL;


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

/* need to update for sks,mmh,wc */



ALTER TABLE "delivery_history"
ADD "details" text NULL;
COMMENT ON TABLE "delivery_history" IS '';

ALTER TABLE "postnatal_daycare"
ADD "SeenBy" integer NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';


ALTER TABLE "postnatal_daycare"
ADD "examination_normal" boolean NULL DEFAULT 'false';
COMMENT ON TABLE "postnatal_daycare" IS '';



ALTER TABLE "op_details"
ADD "fee_reason" text NULL;
COMMENT ON TABLE "op_details" IS '';

ALTER TABLE "op_details_audit"
ADD "fee_reason" text NULL;
COMMENT ON TABLE "op_details" IS '';


ALTER TABLE "op_details"
ADD "nextreviewindication" text NULL;

ALTER TABLE "op_details_audit"
ADD "nextreviewindication" text NULL;


ALTER TABLE "neonatal_proforma" 
ADD "reason_dcc" text NULL;

ALTER TABLE "neonatal_proforma_audit" 
ADD "reason_dcc" text NULL;


ALTER TABLE "echo_cardio"
ADD "age_year" integer NULL,
ADD "age_month" integer NULL,
ADD "age_days" integer NULL;
COMMENT ON TABLE "echo_cardio" IS '';


ALTER TABLE "baby"
ADD "UserModified" integer NULL DEFAULT '0';
COMMENT ON TABLE "baby" IS '';

ALTER TABLE "baby_audit"
ADD "UserModified" integer NULL DEFAULT '0';


ALTER TABLE "mother"
ALTER "UserModified" TYPE integer,
ALTER "UserModified" SET DEFAULT '0',
ALTER "UserModified" DROP NOT NULL;
COMMENT ON COLUMN "mother"."UserModified" IS '';
COMMENT ON TABLE "mother" IS '';



ALTER TABLE "discharge_summary"
ADD "vaccine" text NULL;
COMMENT ON TABLE "discharge_summary" IS '';

ALTER TABLE "discharge_summary_audit"
ADD "vaccine" text NULL;
COMMENT ON TABLE "discharge_summary" IS '';




/*06-07-2018*/

ALTER TABLE "baby_admission"
ALTER "BMrNo" TYPE character varying,
ALTER "BMrNo" DROP DEFAULT,
ALTER "BMrNo" DROP NOT NULL;
COMMENT ON COLUMN "baby_admission"."BMrNo" IS '';
COMMENT ON TABLE "baby_admission" IS '';


ALTER TABLE "postnatal_discharge"
ALTER "discharge_ofc" TYPE text,
ALTER "discharge_ofc" DROP DEFAULT,
ALTER "discharge_ofc" DROP NOT NULL,
ALTER "discharge_length" TYPE text,
ALTER "discharge_length" DROP DEFAULT,
ALTER "discharge_length" DROP NOT NULL;
COMMENT ON COLUMN "postnatal_discharge"."discharge_ofc" IS '';
COMMENT ON COLUMN "postnatal_discharge"."discharge_length" IS '';
COMMENT ON TABLE "postnatal_discharge" IS '';


ALTER TABLE "postnatal_discharge"
ALTER "postductal_spo2" TYPE text,
ALTER "postductal_spo2" DROP DEFAULT,
ALTER "postductal_spo2" DROP NOT NULL,
ALTER "discharge_hb" TYPE text,
ALTER "discharge_hb" DROP DEFAULT,
ALTER "discharge_hb" DROP NOT NULL,
ALTER "discharge_pcv" TYPE text,
ALTER "discharge_pcv" DROP DEFAULT,
ALTER "discharge_pcv" DROP NOT NULL,
ALTER "discharge_tsb" TYPE text,
ALTER "discharge_tsb" DROP DEFAULT,
ALTER "discharge_tsb" DROP NOT NULL,
ALTER "direct_bilirubin" TYPE text,
ALTER "direct_bilirubin" DROP DEFAULT,
ALTER "direct_bilirubin" DROP NOT NULL,
ALTER "dischargeserum_ca" TYPE text,
ALTER "dischargeserum_ca" DROP DEFAULT,
ALTER "dischargeserum_ca" DROP NOT NULL,
ALTER "dischargeserum_po4" TYPE text,
ALTER "dischargeserum_po4" DROP DEFAULT,
ALTER "dischargeserum_po4" DROP NOT NULL;
COMMENT ON COLUMN "postnatal_discharge"."postductal_spo2" IS '';
COMMENT ON COLUMN "postnatal_discharge"."discharge_hb" IS '';
COMMENT ON COLUMN "postnatal_discharge"."discharge_pcv" IS '';
COMMENT ON COLUMN "postnatal_discharge"."discharge_tsb" IS '';
COMMENT ON COLUMN "postnatal_discharge"."direct_bilirubin" IS '';
COMMENT ON COLUMN "postnatal_discharge"."dischargeserum_ca" IS '';
COMMENT ON COLUMN "postnatal_discharge"."dischargeserum_po4" IS '';
COMMENT ON TABLE "postnatal_discharge" IS '';


DROP TABLE IF EXISTS "pb_postnatal_list";
CREATE SEQUENCE pb_postnatal_list_pb_postnatal_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."pb_postnatal_list" (
    "pb_postnatal_id" bigint DEFAULT nextval('pb_postnatal_list_pb_postnatal_id_seq') NOT NULL,
    "baby_id" bigint,
    "mother_id" bigint,
    "admission_id" bigint,
    "problem_id" bigint,
    "IsDeleted" smallint DEFAULT 0,
    "UserDeleted" bigint DEFAULT 0,
    "DateDeleted" date
) WITH (oids = false);


DROP TABLE IF EXISTS "pb_postnatal_episode";
CREATE SEQUENCE pb_postnatal_episode_episode_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."pb_postnatal_episode" (
    "episode_id" bigint DEFAULT nextval('pb_postnatal_episode_episode_id_seq') NOT NULL,
    "mother_id" integer,
    "baby_id" integer,
    "admission_id" integer,
    "problem_id" integer,
    "problems_parameters" jsonb,
    "episode_name" text,
    "pp_id" integer,
    "pb_day_id" bigint,
    "start_date" date,
    "end_date" date,
    "IsDeleted" smallint DEFAULT 0,
    "UserDeleted" bigint DEFAULT 0,
    "DateDeleted" date,
    "UserModified" bigint DEFAULT 0,
    "DateModified" date,
    "UserAdded" bigint DEFAULT 0,
    "DateAdded" date
) WITH (oids = false);

COMMENT ON COLUMN "public"."pb_postnatal_episode"."pp_id" IS 'problem published id ';


ALTER TABLE postnatal_admission
    ALTER COLUMN ivantibiotic TYPE JSON USING ivantibiotic::JSON;

ALTER TABLE postnatal_admission
    ALTER COLUMN differentialdiagnosis TYPE JSON USING differentialdiagnosis::JSON;

ALTER TABLE postnatal_admission
    ALTER COLUMN additional_diagnosis TYPE JSON USING additional_diagnosis::JSON; 

   
ALTER TABLE postnatal_discharge
    ALTER COLUMN vaccine TYPE JSON USING vaccine::JSON;   

ALTER TABLE postnatal_discharge
    ALTER COLUMN cgd TYPE JSON USING cgd::JSON;  

ALTER TABLE postnatal_discharge
    ALTER COLUMN typeoftreatment_left TYPE JSON USING typeoftreatment_left::JSON;   
     
ALTER TABLE postnatal_discharge
    ALTER COLUMN typeoftreatment_right TYPE JSON USING typeoftreatment_right::JSON;                   



ALTER TABLE "postnatal_admission"
ALTER "matters_discussed" TYPE text,
ALTER "matters_discussed" DROP DEFAULT,
ALTER "matters_discussed" DROP NOT NULL;
COMMENT ON COLUMN "postnatal_admission"."matters_discussed" IS '';
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "postnatal_discharge"
ADD "procedures" jsonb NULL;
COMMENT ON TABLE "postnatal_discharge" IS '';

ALTER TABLE "culture_registry"
ALTER "AdmissionId" TYPE integer,
ALTER "AdmissionId" DROP DEFAULT,
ALTER "AdmissionId" DROP NOT NULL,
ALTER "DayOfLife" TYPE integer,
ALTER "DayOfLife" DROP DEFAULT,
ALTER "DayOfLife" DROP NOT NULL,
ALTER "CollectionDate" TYPE date,
ALTER "CollectionDate" DROP DEFAULT,
ALTER "CollectionDate" DROP NOT NULL,
ALTER "EntryDate" TYPE date,
ALTER "EntryDate" DROP DEFAULT,
ALTER "EntryDate" DROP NOT NULL,
ALTER "Isolate" TYPE character varying,
ALTER "Isolate" DROP DEFAULT,
ALTER "Isolate" DROP NOT NULL,
ALTER "Specimen" TYPE character varying,
ALTER "Specimen" DROP DEFAULT,
ALTER "Specimen" DROP NOT NULL,
ALTER "Amikacin" TYPE character varying,
ALTER "Amikacin" DROP DEFAULT,
ALTER "Amikacin" DROP NOT NULL,
ALTER "AmoxycillinClavulanate" TYPE character varying,
ALTER "AmoxycillinClavulanate" DROP DEFAULT,
ALTER "AmoxycillinClavulanate" DROP NOT NULL,
ALTER "AmpicillinSulbactum" TYPE character varying,
ALTER "AmpicillinSulbactum" DROP DEFAULT,
ALTER "AmpicillinSulbactum" DROP NOT NULL,
ALTER "Azithromycin" TYPE character varying,
ALTER "Azithromycin" DROP DEFAULT,
ALTER "Azithromycin" DROP NOT NULL,
ALTER "Cefazolin" TYPE character varying,
ALTER "Cefazolin" DROP DEFAULT,
ALTER "Cefazolin" DROP NOT NULL,
ALTER "Cefepime" TYPE character varying,
ALTER "Cefepime" DROP DEFAULT,
ALTER "Cefepime" DROP NOT NULL,
ALTER "Cefotaxime" TYPE character varying,
ALTER "Cefotaxime" DROP DEFAULT,
ALTER "Cefotaxime" DROP NOT NULL,
ALTER "Cefoxitin" TYPE character varying,
ALTER "Cefoxitin" DROP DEFAULT,
ALTER "Cefoxitin" DROP NOT NULL,
ALTER "Cefpodoxime" TYPE character varying,
ALTER "Cefpodoxime" DROP DEFAULT,
ALTER "Cefpodoxime" DROP NOT NULL,
ALTER "Ceftriaxone" TYPE character varying,
ALTER "Ceftriaxone" DROP DEFAULT,
ALTER "Ceftriaxone" DROP NOT NULL,
ALTER "Cefuroxime" TYPE character varying,
ALTER "Cefuroxime" DROP DEFAULT,
ALTER "Cefuroxime" DROP NOT NULL,
ALTER "Chloramphenicol" TYPE character varying,
ALTER "Chloramphenicol" DROP DEFAULT,
ALTER "Chloramphenicol" DROP NOT NULL,
ALTER "Ciprofloxacin" TYPE character varying,
ALTER "Ciprofloxacin" DROP DEFAULT,
ALTER "Ciprofloxacin" DROP NOT NULL,
ALTER "Clindamycin" TYPE character varying,
ALTER "Clindamycin" DROP DEFAULT,
ALTER "Clindamycin" DROP NOT NULL,
ALTER "CoTrimoxazole" TYPE character varying,
ALTER "CoTrimoxazole" DROP DEFAULT,
ALTER "CoTrimoxazole" DROP NOT NULL,
ALTER "Doxycycline" TYPE character varying,
ALTER "Doxycycline" DROP DEFAULT,
ALTER "Doxycycline" DROP NOT NULL,
ALTER "Gentamicin" TYPE character varying,
ALTER "Gentamicin" DROP DEFAULT,
ALTER "Gentamicin" DROP NOT NULL,
ALTER "Levofloxacin" TYPE character varying,
ALTER "Levofloxacin" DROP DEFAULT,
ALTER "Levofloxacin" DROP NOT NULL,
ALTER "Linezolid" TYPE character varying,
ALTER "Linezolid" DROP DEFAULT,
ALTER "Linezolid" DROP NOT NULL,
ALTER "Methicillin" TYPE character varying,
ALTER "Methicillin" DROP DEFAULT,
ALTER "Methicillin" DROP NOT NULL,
ALTER "Netillin" TYPE character varying,
ALTER "Netillin" DROP DEFAULT,
ALTER "Netillin" DROP NOT NULL,
ALTER "Ofloxacin" TYPE character varying,
ALTER "Ofloxacin" DROP DEFAULT,
ALTER "Ofloxacin" DROP NOT NULL,
ALTER "Teicoplanin" TYPE character varying,
ALTER "Teicoplanin" DROP DEFAULT,
ALTER "Teicoplanin" DROP NOT NULL,
ALTER "Tetracycline" TYPE character varying,
ALTER "Tetracycline" DROP DEFAULT,
ALTER "Tetracycline" DROP NOT NULL,
ALTER "Tobramycin" TYPE character varying,
ALTER "Tobramycin" DROP DEFAULT,
ALTER "Tobramycin" DROP NOT NULL,
ALTER "Vancomycin" TYPE character varying,
ALTER "Vancomycin" DROP DEFAULT,
ALTER "Vancomycin" DROP NOT NULL,
ALTER "Aztreonam" TYPE character varying,
ALTER "Aztreonam" DROP DEFAULT,
ALTER "Aztreonam" DROP NOT NULL,
ALTER "Carbenicillin" TYPE character varying,
ALTER "Carbenicillin" DROP DEFAULT,
ALTER "Carbenicillin" DROP NOT NULL,
ALTER "Cefaclor" TYPE character varying,
ALTER "Cefaclor" DROP DEFAULT,
ALTER "Cefaclor" DROP NOT NULL,
ALTER "Cefipime" TYPE character varying,
ALTER "Cefipime" DROP DEFAULT,
ALTER "Cefipime" DROP NOT NULL,
ALTER "Cefixime" TYPE character varying,
ALTER "Cefixime" DROP DEFAULT,
ALTER "Cefixime" DROP NOT NULL,
ALTER "Cefoperazone" TYPE character varying,
ALTER "Cefoperazone" DROP DEFAULT,
ALTER "Cefoperazone" DROP NOT NULL,
ALTER "Ceftazidime" TYPE character varying,
ALTER "Ceftazidime" DROP DEFAULT,
ALTER "Ceftazidime" DROP NOT NULL,
ALTER "Faropenem" TYPE character varying,
ALTER "Faropenem" DROP DEFAULT,
ALTER "Faropenem" DROP NOT NULL,
ALTER "Meropenem" TYPE character varying,
ALTER "Meropenem" DROP DEFAULT,
ALTER "Meropenem" DROP NOT NULL,
ALTER "Imipenem" TYPE character varying,
ALTER "Imipenem" DROP DEFAULT,
ALTER "Imipenem" DROP NOT NULL,
ALTER "Ertapenem" TYPE character varying,
ALTER "Ertapenem" DROP DEFAULT,
ALTER "Ertapenem" DROP NOT NULL,
ALTER "PiperacillinTazobactum" TYPE character varying,
ALTER "PiperacillinTazobactum" DROP DEFAULT,
ALTER "PiperacillinTazobactum" DROP NOT NULL,
ALTER "Colistin" TYPE character varying,
ALTER "Colistin" DROP DEFAULT,
ALTER "Colistin" DROP NOT NULL,
ALTER "PolymyxinB" TYPE character varying,
ALTER "PolymyxinB" DROP DEFAULT,
ALTER "PolymyxinB" DROP NOT NULL,
ALTER "NalidixicAcid" TYPE character varying,
ALTER "NalidixicAcid" DROP DEFAULT,
ALTER "NalidixicAcid" DROP NOT NULL,
ALTER "Nitrofurantoin" TYPE character varying,
ALTER "Nitrofurantoin" DROP DEFAULT,
ALTER "Nitrofurantoin" DROP NOT NULL,
ALTER "Norfloxacin" TYPE character varying,
ALTER "Norfloxacin" DROP DEFAULT,
ALTER "Norfloxacin" DROP NOT NULL,
ALTER "Erythromycin" TYPE character varying,
ALTER "Erythromycin" DROP DEFAULT,
ALTER "Erythromycin" DROP NOT NULL,
ALTER "PenicillinG" TYPE character varying,
ALTER "PenicillinG" DROP DEFAULT,
ALTER "PenicillinG" DROP NOT NULL,
ALTER "Tigecycline" TYPE character varying,
ALTER "Tigecycline" DROP DEFAULT,
ALTER "Tigecycline" DROP NOT NULL,
ALTER "SeenBy" TYPE integer,
ALTER "SeenBy" DROP DEFAULT,
ALTER "SeenBy" DROP NOT NULL,
ALTER "UserAdded" TYPE integer,
ALTER "UserAdded" DROP DEFAULT,
ALTER "UserAdded" DROP NOT NULL,
ALTER "UserDeleted" TYPE integer,
ALTER "UserDeleted" DROP DEFAULT,
ALTER "UserDeleted" DROP NOT NULL,
ALTER "IsDeleted" TYPE character varying,
ALTER "IsDeleted" SET DEFAULT '0',
ALTER "IsDeleted" DROP NOT NULL,
ALTER "UserModified" TYPE integer,
ALTER "UserModified" DROP DEFAULT,
ALTER "UserModified" DROP NOT NULL,
ALTER "DateAdded" TYPE timestamp(0),
ALTER "DateAdded" DROP DEFAULT,
ALTER "DateAdded" DROP NOT NULL,
ALTER "DateModified" TYPE timestamp(0),
ALTER "DateModified" DROP DEFAULT,
ALTER "DateModified" DROP NOT NULL;
COMMENT ON COLUMN "culture_registry"."AdmissionId" IS '';
COMMENT ON COLUMN "culture_registry"."DayOfLife" IS '';
COMMENT ON COLUMN "culture_registry"."CollectionDate" IS '';
COMMENT ON COLUMN "culture_registry"."EntryDate" IS '';
COMMENT ON COLUMN "culture_registry"."Isolate" IS '';
COMMENT ON COLUMN "culture_registry"."Specimen" IS '';
COMMENT ON COLUMN "culture_registry"."Amikacin" IS '';
COMMENT ON COLUMN "culture_registry"."AmoxycillinClavulanate" IS '';
COMMENT ON COLUMN "culture_registry"."AmpicillinSulbactum" IS '';
COMMENT ON COLUMN "culture_registry"."Azithromycin" IS '';
COMMENT ON COLUMN "culture_registry"."Cefazolin" IS '';
COMMENT ON COLUMN "culture_registry"."Cefepime" IS '';
COMMENT ON COLUMN "culture_registry"."Cefotaxime" IS '';
COMMENT ON COLUMN "culture_registry"."Cefoxitin" IS '';
COMMENT ON COLUMN "culture_registry"."Cefpodoxime" IS '';
COMMENT ON COLUMN "culture_registry"."Ceftriaxone" IS '';
COMMENT ON COLUMN "culture_registry"."Cefuroxime" IS '';
COMMENT ON COLUMN "culture_registry"."Chloramphenicol" IS '';
COMMENT ON COLUMN "culture_registry"."Ciprofloxacin" IS '';
COMMENT ON COLUMN "culture_registry"."Clindamycin" IS '';
COMMENT ON COLUMN "culture_registry"."CoTrimoxazole" IS '';
COMMENT ON COLUMN "culture_registry"."Doxycycline" IS '';
COMMENT ON COLUMN "culture_registry"."Gentamicin" IS '';
COMMENT ON COLUMN "culture_registry"."Levofloxacin" IS '';
COMMENT ON COLUMN "culture_registry"."Linezolid" IS '';
COMMENT ON COLUMN "culture_registry"."Methicillin" IS '';
COMMENT ON COLUMN "culture_registry"."Netillin" IS '';
COMMENT ON COLUMN "culture_registry"."Ofloxacin" IS '';
COMMENT ON COLUMN "culture_registry"."Teicoplanin" IS '';
COMMENT ON COLUMN "culture_registry"."Tetracycline" IS '';
COMMENT ON COLUMN "culture_registry"."Tobramycin" IS '';
COMMENT ON COLUMN "culture_registry"."Vancomycin" IS '';
COMMENT ON COLUMN "culture_registry"."Aztreonam" IS '';
COMMENT ON COLUMN "culture_registry"."Carbenicillin" IS '';
COMMENT ON COLUMN "culture_registry"."Cefaclor" IS '';
COMMENT ON COLUMN "culture_registry"."Cefipime" IS '';
COMMENT ON COLUMN "culture_registry"."Cefixime" IS '';
COMMENT ON COLUMN "culture_registry"."Cefoperazone" IS '';
COMMENT ON COLUMN "culture_registry"."Ceftazidime" IS '';
COMMENT ON COLUMN "culture_registry"."Faropenem" IS '';
COMMENT ON COLUMN "culture_registry"."Meropenem" IS '';
COMMENT ON COLUMN "culture_registry"."Imipenem" IS '';
COMMENT ON COLUMN "culture_registry"."Ertapenem" IS '';
COMMENT ON COLUMN "culture_registry"."PiperacillinTazobactum" IS '';
COMMENT ON COLUMN "culture_registry"."Colistin" IS '';
COMMENT ON COLUMN "culture_registry"."PolymyxinB" IS '';
COMMENT ON COLUMN "culture_registry"."NalidixicAcid" IS '';
COMMENT ON COLUMN "culture_registry"."Nitrofurantoin" IS '';
COMMENT ON COLUMN "culture_registry"."Norfloxacin" IS '';
COMMENT ON COLUMN "culture_registry"."Erythromycin" IS '';
COMMENT ON COLUMN "culture_registry"."PenicillinG" IS '';
COMMENT ON COLUMN "culture_registry"."Tigecycline" IS '';
COMMENT ON COLUMN "culture_registry"."SeenBy" IS '';
COMMENT ON COLUMN "culture_registry"."UserAdded" IS '';
COMMENT ON COLUMN "culture_registry"."UserDeleted" IS '';
COMMENT ON COLUMN "culture_registry"."IsDeleted" IS '';
COMMENT ON COLUMN "culture_registry"."UserModified" IS '';
COMMENT ON COLUMN "culture_registry"."DateAdded" IS '';
COMMENT ON COLUMN "culture_registry"."DateModified" IS '';
COMMENT ON TABLE "culture_registry" IS '';

/*update-query */

update mother set "MotherDOB"= NULL where "MotherDOB"='1970-01-01';
update mother set "PartnerDOB"= NULL where "PartnerDOB"='1970-01-01';

update neonatal_proforma set "Presentation" = 'Not Known' where "Presentation" = 'Unknown';
update daycare set "TypeofFeeds" = 'Not applicable' where "TypeofFeeds" ='N/A';
update daycare set "Cry"='Not applicable' where "Cry" = 'N/A' ;





ALTER TABLE "op_details"
ADD "investigations" text NULL;
COMMENT ON TABLE "op_details" IS '';

ALTER TABLE "op_details_audit"
ADD "investigations" text NULL;
COMMENT ON TABLE "op_details" IS '';

ALTER TABLE "baby_admission"
ALTER "AdmissionTime" TYPE time without time zone,
ALTER "AdmissionTime" DROP DEFAULT,
ALTER "AdmissionTime" DROP NOT NULL;
COMMENT ON COLUMN "baby_admission"."AdmissionTime" IS '';
COMMENT ON TABLE "baby_admission" IS '';

ALTER TABLE "neonatal_proforma"
ADD "reason_dcc" text NULL;


ALTER TABLE "delete_approval"
ADD "SubModuleId" integer NULL;
COMMENT ON TABLE "op_details" IS '';


update nicu_admission set "nicu_color" = 'Yellow' where "nicu_color" ='' ;


ALTER TABLE "postnatal_admission"
ADD "admission_examination" text NULL;
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "postnatal_discharge"
ADD "echocardiography_status" text NULL;
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "nicu_admission"
ADD "echocardiography_status" text NULL;
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "nicu_admission_audit"
ADD "echocardiography_status" text NULL;
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "postnatal_daycare"
ADD "differentialdiagnosis" jsonb NULL,
ADD "additional_diagnosis" jsonb NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';

ALTER TABLE "nicu_admission"
ADD "fio2_during_transfer" character varying NULL;
COMMENT ON TABLE "nicu_admission" IS '';

ALTER TABLE "nicu_admission_audit"
ADD "fio2_during_transfer" character varying NULL;
COMMENT ON TABLE "nicu_admission" IS '';


ALTER TABLE "nicu_admission"
ALTER "nicu_pupils" TYPE text,
ALTER "nicu_pupils" DROP DEFAULT,
ALTER "nicu_pupils" DROP NOT NULL;
ALTER TABLE "nicu_admission" RENAME "nicu_pupils" TO "nicu_pupils_findings";
COMMENT ON COLUMN "nicu_admission"."nicu_pupils_findings" IS '';
COMMENT ON TABLE "nicu_admission" IS ''

ALTER TABLE "nicu_admission_audit"
ALTER "nicu_pupils" TYPE text,
ALTER "nicu_pupils" DROP DEFAULT,
ALTER "nicu_pupils" DROP NOT NULL;
ALTER TABLE "nicu_admission_audit" RENAME "nicu_pupils" TO "nicu_pupils_findings";
COMMENT ON COLUMN "nicu_admission_audit"."nicu_pupils_findings" IS '';
COMMENT ON TABLE "nicu_admission_audit" IS ''

-- pupils
ALTER TABLE "nicu_admission" 
ADD "nicu_pupils" text NULL;

ALTER TABLE "nicu_admission_audit" 
ADD "nicu_pupils" text NULL;


ALTER TABLE "postnatal_admission"
ALTER "nicu_pupils" TYPE text,
ALTER "nicu_pupils" DROP DEFAULT,
ALTER "nicu_pupils" DROP NOT NULL;
ALTER TABLE "postnatal_admission" RENAME "nicu_pupils" TO "nicu_pupils_findings";
COMMENT ON COLUMN "postnatal_admission"."nicu_pupils_findings" IS '';
COMMENT ON TABLE "postnatal_admission" IS ''

ALTER TABLE "postnatal_admission" 
ADD "nicu_pupils" text NULL;

-- pupils


-- discharge gentila

ALTER TABLE "nicu_admission"
ALTER "gentila" TYPE text,
ALTER "gentila" DROP DEFAULT,
ALTER "gentila" DROP NOT NULL;
ALTER TABLE "nicu_admission" RENAME "gentila" TO "gentila_findings";
COMMENT ON COLUMN "nicu_admission"."gentila_findings" IS '';
COMMENT ON TABLE "nicu_admission" IS '';

ALTER TABLE "nicu_admission"
ADD "gentila" character varying NULL;
COMMENT ON TABLE "nicu_admission" IS '';


ALTER TABLE "nicu_admission_audit"
ALTER "gentila" TYPE text,
ALTER "gentila" DROP DEFAULT,
ALTER "gentila" DROP NOT NULL;
ALTER TABLE "nicu_admission_audit" RENAME "gentila" TO "gentila_findings";
COMMENT ON COLUMN "nicu_admission_audit"."gentila_findings" IS '';
COMMENT ON TABLE "nicu_admission_audit" IS '';

ALTER TABLE "nicu_admission_audit"
ADD "gentila" character varying NULL;
COMMENT ON TABLE "nicu_admission_audit" IS '';


ALTER TABLE "postnatal_discharge"
ALTER "discharge_gentila" TYPE text,
ALTER "discharge_gentila" DROP DEFAULT,
ALTER "discharge_gentila" DROP NOT NULL;
ALTER TABLE "postnatal_discharge" RENAME "discharge_gentila" TO "discharge_gentila_findings";
COMMENT ON COLUMN "postnatal_discharge"."discharge_gentila_findings" IS '';
COMMENT ON TABLE "postnatal_discharge" IS '';

ALTER TABLE "postnatal_discharge"
ADD "discharge_gentila" character varying NULL;
COMMENT ON TABLE "postnatal_discharge" IS '';
-- discharge gentila

-- admission gentila 

ALTER TABLE "nicu_admission"
ALTER "nicu_genitalia" TYPE text,
ALTER "nicu_genitalia" DROP DEFAULT,
ALTER "nicu_genitalia" DROP NOT NULL;
ALTER TABLE "nicu_admission" RENAME "nicu_genitalia" TO "nicu_genitalia_findings";
COMMENT ON COLUMN "nicu_admission"."nicu_genitalia_findings" IS '';
COMMENT ON TABLE "nicu_admission" IS '';

ALTER TABLE "nicu_admission"
ADD "nicu_genitalia" character varying NULL;
COMMENT ON TABLE "nicu_admission" IS '';

ALTER TABLE "nicu_admission_audit"
ALTER "nicu_genitalia" TYPE text,
ALTER "nicu_genitalia" DROP DEFAULT,
ALTER "nicu_genitalia" DROP NOT NULL;
ALTER TABLE "nicu_admission_audit" RENAME "nicu_genitalia" TO "nicu_genitalia_findings";
COMMENT ON COLUMN "nicu_admission_audit"."nicu_genitalia_findings" IS '';
COMMENT ON TABLE "nicu_admission_audit" IS '';

ALTER TABLE "nicu_admission_audit"
ADD "nicu_genitalia" character varying NULL;
COMMENT ON TABLE "nicu_admission_audit" IS '';

ALTER TABLE "postnatal_admission"
ALTER "genitalia" TYPE text,
ALTER "genitalia" DROP DEFAULT,
ALTER "genitalia" DROP NOT NULL;
ALTER TABLE "postnatal_admission" RENAME "genitalia" TO "genitalia_findings";
COMMENT ON COLUMN "postnatal_admission"."nicu_genitalia_findings" IS '';
COMMENT ON TABLE "postnatal_admission" IS '';

ALTER TABLE "postnatal_admission"
ADD "genitalia" character varying NULL;
COMMENT ON TABLE "postnatal_admission" IS '';



ALTER TABLE "flow_control"
ADD "multiple_pregnancy" character varying NULL,
ADD "remaining_baby" character varying NULL;
COMMENT ON TABLE "flow_control" IS '';

-- admission gentila 

ALTER TABLE "daycare_questions"
ALTER "iv_fluids" TYPE text,
ALTER "iv_fluids" SET DEFAULT '0',
ALTER "iv_fluids" DROP NOT NULL;
COMMENT ON COLUMN "daycare_questions"."iv_fluids" IS '';
COMMENT ON TABLE "daycare_questions" IS '';

ALTER TABLE "flow_control"
ADD "resource_id" integer NULL;
COMMENT ON TABLE "flow_control" IS '';


ALTER TABLE "complications"
ADD "duration_unit" text NULL;
COMMENT ON TABLE "complications" IS '';


ALTER TABLE "postnatal_daycare"
ADD "postnatal_sepsis" character varying NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';

ALTER TABLE "postnatal_daycare"
ADD "postnatal_antiboitic" json NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';

ALTER TABLE "postnatal_daycare"
ADD "postnatal_other_drugs" json NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';

ALTER TABLE "postnatal_daycare"
ADD "blood_culture" character varying NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';

ALTER TABLE "postnatal_daycare"
ADD "postnatal_organism" json NULL;
COMMENT ON TABLE "postnatal_daycare" IS '';


ALTER TABLE "flow_control"
ADD "multiple_pregnancy" character varying NULL,
ADD "remaining_baby" character varying NULL;
COMMENT ON TABLE "flow_control" IS '';

--21-11-2019 added delete option
ALTER TABLE "nurse_iv_infusion"
ADD "IsDeleted" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "nurse_iv_infusion" IS '';

ALTER TABLE "nurse_other_iv_drugs"
ADD "IsDeleted" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "nurse_other_iv_drugs" IS '';

ALTER TABLE "nurse_other_iv_infusion"
ADD "IsDeleted" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "nurse_other_iv_infusion" IS '';

ALTER TABLE "nurse_glucose_intake"
ADD "IsDeleted" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "nurse_glucose_intake" IS '';

ALTER TABLE "nurse_oral_drugs"
ADD "IsDeleted" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "nurse_oral_drugs" IS '';


