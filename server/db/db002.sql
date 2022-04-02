ALTER TABLE `4362_appkopernik`.`totals` 
ADD `unitname` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL AFTER `updated_at`;

UPDATE `totals` SET `unitname` = 'Aleksandrów Kujawski' WHERE `totals`.`scoutunit` = 'aleksandrowkujawski';
UPDATE `totals` SET `unitname` = 'Brodnica' WHERE `totals`.`scoutunit` = 'brodnica';
UPDATE `totals` SET `unitname` = 'Bydgoszcz Miasto' WHERE `totals`.`scoutunit` = 'bydgoszczmiasto';
UPDATE `totals` SET `unitname` = 'Chełmża' WHERE `totals`.`scoutunit` = 'chelmza';
UPDATE `totals` SET `unitname` = 'Chojnice' WHERE `totals`.`scoutunit` = 'chojnice';

UPDATE `totals` SET `unitname` = 'Golub-Dobrzyń' WHERE `totals`.`scoutunit` = 'golubdobrzyn';
UPDATE `totals` SET `unitname` = 'Grudziądz' WHERE `totals`.`scoutunit` = 'grudziadz';
UPDATE `totals` SET `unitname` = 'Inowrocław' WHERE `totals`.`scoutunit` = 'inowroclaw';
UPDATE `totals` SET `unitname` = 'komenda chorągwi' WHERE `totals`.`scoutunit` = 'komendachoragwi';
UPDATE `totals` SET `unitname` = 'Koronowo' WHERE `totals`.`scoutunit` = 'koronowo';

UPDATE `totals` SET `unitname` = 'Mogilno' WHERE `totals`.`scoutunit` = 'mogilno';
UPDATE `totals` SET `unitname` = 'Nakło nad Notecią' WHERE `totals`.`scoutunit` = 'naklonadnotecia';
UPDATE `totals` SET `unitname` = 'Nowe Miasto Lubawskie' WHERE `totals`.`scoutunit` = 'nowemiastolubawskie';
UPDATE `totals` SET `unitname` = 'Pałuki' WHERE `totals`.`scoutunit` = 'paluki';
UPDATE `totals` SET `unitname` = 'Powiat Włocławski' WHERE `totals`.`scoutunit` = 'powiatwloclawski';

UPDATE `totals` SET `unitname` = 'Rypin' WHERE `totals`.`scoutunit` = 'rypin';
UPDATE `totals` SET `unitname` = 'Solec Kujawski' WHERE `totals`.`scoutunit` = 'soleckujawski';
UPDATE `totals` SET `unitname` = 'Świecie' WHERE `totals`.`scoutunit` = 'swiecie';
UPDATE `totals` SET `unitname` = '* TEST *' WHERE `totals`.`scoutunit` = 'test';
UPDATE `totals` SET `unitname` = 'Toruń' WHERE `totals`.`scoutunit` = 'torun';

UPDATE `totals` SET `unitname` = 'Tuchola' WHERE `totals`.`scoutunit` = 'tuchola';
UPDATE `totals` SET `unitname` = 'Włocławek' WHERE `totals`.`scoutunit` = 'wloclawek';















