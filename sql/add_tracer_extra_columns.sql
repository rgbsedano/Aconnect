ALTER TABLE `tracer_survey_responses`
    ADD COLUMN `subjects` TEXT DEFAULT NULL,
    ADD COLUMN `satisfaction` VARCHAR(100) DEFAULT NULL,
    ADD COLUMN `intent` VARCHAR(255) DEFAULT NULL,
    ADD COLUMN `other_intent` VARCHAR(255) DEFAULT NULL,
    ADD COLUMN `performance_ratings` TEXT DEFAULT NULL,
    ADD COLUMN `further_study` TEXT DEFAULT NULL;

-- Run this SQL against your database to add the fields used by the updated tracer form.
