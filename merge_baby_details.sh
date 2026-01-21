#!/bin/bash

# Extract enhanced createUpdateBabyDetails from backup (lines 1152-1328)
sed -n '1152,1328p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController_backup.php > /var/www/html/neopaed/enhanced_baby_details.tmp

# Extract lines before the method (1-1152)
sed -n '1,1152p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php > /var/www/html/neopaed/part1.tmp

# Extract lines after the method (from storeTranscribedOpNeonatalData onwards, line 1290+)
sed -n '1290,$p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php > /var/www/html/neopaed/part2.tmp

# Combine all parts
cat /var/www/html/neopaed/part1.tmp /var/www/html/neopaed/enhanced_baby_details.tmp /var/www/html/neopaed/part2.tmp > /var/www/html/neopaed/TranscribtionIntegrationController_new.php

# Replace with new file
mv /var/www/html/neopaed/TranscribtionIntegrationController_new.php /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php

# Clean up temp files
rm -f /var/www/html/neopaed/enhanced_baby_details.tmp /var/www/html/neopaed/part1.tmp /var/www/html/neopaed/part2.tmp

echo "createUpdateBabyDetails replacement complete"
