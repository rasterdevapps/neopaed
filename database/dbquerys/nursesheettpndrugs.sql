ALTER TABLE site_settings
Add period time without time zone NULL

UPDATE site_settings
SET period = '07:00:00';
