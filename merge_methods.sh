#!/bin/bash

# Extract enhanced method from backup (lines 715-1151)
sed -n '715,1151p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController_backup.php > /var/www/html/neopaed/enhanced_method.tmp

# Extract lines before the method (1-715)
sed -n '1,715p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php > /var/www/html/neopaed/part1.tmp

# Extract lines after the method (from createUpdateBabyDetails onwards)
sed -n '1084,$p' /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php > /var/www/html/neopaed/part2.tmp

# Combine all parts
cat /var/www/html/neopaed/part1.tmp /var/www/html/neopaed/enhanced_method.tmp /var/www/html/neopaed/part2.tmp > /var/www/html/neopaed/TranscribtionIntegrationController_new.php

# Backup current file
cp /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController_before_method_replace.php

# Replace with new file
mv /var/www/html/neopaed/TranscribtionIntegrationController_new.php /var/www/html/neopaed/app/Http/Controllers/TranscribtionIntegrationController.php

# Clean up temp files
rm -f /var/www/html/neopaed/enhanced_method.tmp /var/www/html/neopaed/part1.tmp /var/www/html/neopaed/part2.tmp

echo "Method replacement complete"
