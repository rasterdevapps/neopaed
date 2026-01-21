#!/bin/bash

BASE_URL="http://localhost/neopaed/public"
UHID="707806"
DATE=$(date +%Y-%m-%d)
TIME=$(date +%H:%M:%S)
DB_USER="postgres"
DB_NAME="neonatal_integration_live"

echo "========================================================"
echo "STARTING INTEGRATION VERIFICATION FOR UHID: $UHID"
echo "========================================================"

# 1. CLEANUP
echo "[1/6] Cleaning up previous data..."
psql -U $DB_USER -d $DB_NAME -c "DELETE FROM baby WHERE \"BMrNo\" = '$UHID';"
psql -U $DB_USER -d $DB_NAME -c "DELETE FROM mother WHERE \"MMrNo\" = '$UHID';"

# 2. NEONATAL PROFORMA
echo "[2/6] Posting Neonatal Proforma..."
curl -X POST "$BASE_URL/store-neonatal-proforma-transcribed-data" \
  -H "Content-Type: application/json" \
  -d '{
    "uhid": "'$UHID'",
    "dateTime": "'$DATE' '$TIME'",
    "baby": {
        "uhid": "'$UHID'",
        "name": "Integration Baby",
        "dob": "'$DATE'",
        "birthWeight": "2.5",
        "birthStatus": "Inborn",
        "sex": "Female"
    },
    "mother": {
        "name": { "first": "Integration Mother" },
        "mobile": "9999999999"
    },
    "consanguinity": "No"
}'
echo "Response:"

# 3. NICU ADMISSION
echo "[3/6] Posting NICU Admission..."
curl -X POST "$BASE_URL/store-nicu-admission-transcribed-data" \
  -H "Content-Type: application/json" \
  -d '{
    "uhid": "'$UHID'",
    "baby": {
        "uhid": "'$UHID'",
        "name": "Integration Baby",
        "dob": "'$DATE'",
        "birthWeight": "2.5",
        "birthStatus": "Inborn",
        "sex": "Female"
    },
    "admission": {
        "visitNumber": "IP-123456",
        "admissionDate": "'$DATE' '$TIME'",
        "typeOfCare": "Intensive",
        "admissionWt": "2.5",
        "surgeon": "Dr. Test"
    },
    "medicalHistory": {
        "smoking": "No"
    }
}'
echo "Response:"

# 4. DAYCARE
echo "[4/6] Posting Daycare Data..."
curl -X POST "$BASE_URL/store-daycare-transcribed-data" \
  -H "Content-Type: application/json" \
  -d '{
    "uhid": "'$UHID'",
    "dailyLog": {
        "date": "'$DATE'",
        "time": "'$TIME'",
        "vitals": {
            "hr": "140",
            "rr": "50",
            "temperature": "98.6"
        }
    }
}'
echo "Response:"

# 5. OP NEONATAL
echo "[5/6] Posting OP Neonatal Data..."
curl -X POST "$BASE_URL/store-op-neonatal-transcribed-data" \
  -H "Content-Type: application/json" \
  -d '{
    "uhid": "'$UHID'",
    "opDateTime": "'$DATE' '$TIME'",
    "baby": {
        "name": "Integration Baby",
        "dob": "'$DATE'",
        "sex": "Female"
    },
    "followUp": {
        "appointmentType": "Review"
    }
}'
echo "Response:"

# 6. FETCH IDs AND VERIFY
echo "[6/6] Fetching IDs and Verifying UI..."

BABY_ID=$(psql -U $DB_USER -d $DB_NAME -t -c "SELECT \"BabyId\" FROM baby WHERE \"BMrNo\" = '$UHID' LIMIT 1" | xargs)
MOTHER_ID=$(psql -U $DB_USER -d $DB_NAME -t -c "SELECT \"MotherId\" FROM mother WHERE \"MotherId\" = (SELECT \"MotherId\" FROM baby WHERE \"BMrNo\" = '$UHID' LIMIT 1)" | xargs)
NICU_ID=$(psql -U $DB_USER -d $DB_NAME -t -c "SELECT \"NicuId\" FROM nicu_admission WHERE \"BabyId\" = '$BABY_ID' ORDER BY \"NicuId\" DESC LIMIT 1" | xargs)
DAY_ID=$(psql -U $DB_USER -d $DB_NAME -t -c "SELECT \"DayId\" FROM daycare WHERE \"BabyId\" = '$BABY_ID' ORDER BY \"DayId\" DESC LIMIT 1" | xargs)
OP_ID=$(psql -U $DB_USER -d $DB_NAME -t -c "SELECT \"OpId\" FROM op_details WHERE \"BabyId\" = '$BABY_ID' ORDER BY \"OpId\" DESC LIMIT 1" | xargs)

echo "Fetched IDs:"
echo "BabyId: $BABY_ID"
echo "MotherId: $MOTHER_ID"
echo "NicuId: $NICU_ID"
echo "DayId: $DAY_ID"
echo "OpId: $OP_ID"

if [ -z "$BABY_ID" ]; then
    echo "ERROR: BabyId not found. API posts might have failed."
    exit 1
fi

php /var/www/html/neopaed/verify_ui_render_v8.php \
    --nicuId="$NICU_ID" \
    --daycareId="$DAY_ID" \
    --opId="$OP_ID" \
    --babyId="$BABY_ID"

echo "========================================================"
echo "VERIFICATION COMPLETE"
echo "========================================================"
