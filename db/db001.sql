/* use ... */


CREATE TABLE `4362_appkopernik`.`activities` ( 
    `id` BIGINT NOT NULL AUTO_INCREMENT, 
    `scoutunit` VARCHAR(30) NOT NULL , 
    `activity` VARCHAR(20) NOT NULL , 
    `participants` SMALLINT NOT NULL DEFAULT '1' , 
    `distance` BIGINT NOT NULL DEFAULT '0' , 
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    `valid` BOOLEAN NULL DEFAULT NULL , 
    `image_name` VARCHAR(160) NULL , 
    `image_name_new` VARCHAR(160) NULL , 
    `image_hash` VARCHAR(160) NULL , 
    `comment` VARCHAR(160) NULL , 
    `admin_comment` VARCHAR(160) NULL , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `4362_appkopernik`.`totals` ( 
    `scoutunit` VARCHAR(30) NOT NULL , 
    `walking` BIGINT NOT NULL DEFAULT '0', 
    `running` BIGINT NOT NULL DEFAULT '0', 
    `cycling` BIGINT NOT NULL DEFAULT '0', 
    `swimming` BIGINT NOT NULL DEFAULT '0', 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAM, 
PRIMARY KEY (`scoutunit`)) ENGINE = InnoDB;

INSERT INTO `totals`(`scoutunit`) VALUES ('aleksandrowkujawski');
INSERT INTO `totals`(`scoutunit`) VALUES ('brodnica');
INSERT INTO `totals`(`scoutunit`) VALUES ('bydgoszczmiasto');
INSERT INTO `totals`(`scoutunit`) VALUES ('chelmza');
INSERT INTO `totals`(`scoutunit`) VALUES ('chojnice');

INSERT INTO `totals`(`scoutunit`) VALUES ('golubdobrzyn');
INSERT INTO `totals`(`scoutunit`) VALUES ('grudziadz');
INSERT INTO `totals`(`scoutunit`) VALUES ('inowroclaw');
INSERT INTO `totals`(`scoutunit`) VALUES ('jablonowopomorskie');
INSERT INTO `totals`(`scoutunit`) VALUES ('koronowo');

INSERT INTO `totals`(`scoutunit`) VALUES ('mogilno');
INSERT INTO `totals`(`scoutunit`) VALUES ('naklonadnotecia');
INSERT INTO `totals`(`scoutunit`) VALUES ('nowemiastolubawskie');
INSERT INTO `totals`(`scoutunit`) VALUES ('paluki');
INSERT INTO `totals`(`scoutunit`) VALUES ('powiatwloclawski');

INSERT INTO `totals`(`scoutunit`) VALUES ('rypin');
INSERT INTO `totals`(`scoutunit`) VALUES ('soleckujawski');
INSERT INTO `totals`(`scoutunit`) VALUES ('swiecie');
INSERT INTO `totals`(`scoutunit`) VALUES ('torun');
INSERT INTO `totals`(`scoutunit`) VALUES ('tuchola');

INSERT INTO `totals`(`scoutunit`) VALUES ('wloclawek');


delimiter //
CREATE TRIGGER insert_activity AFTER INSERT on activities
    FOR EACH ROW
    BEGIN
        IF NEW.activity = 'walking' THEN
            UPDATE totals SET `walking` = `walking`+(NEW.participants * NEW.distance) 
            WHERE totals.scoutunit = NEW.scoutunit; 
        ELSEIF NEW.activity = 'running' THEN
            UPDATE totals SET totals.running = running+(NEW.participants * NEW.distance) 
            WHERE totals.scoutunit = NEW.scoutunit; 
        ELSEIF NEW.activity = 'cycling' THEN
            UPDATE totals SET totals.cycling = cycling+(NEW.participants * NEW.distance) 
            WHERE totals.scoutunit = NEW.scoutunit; 
        ELSEIF NEW.activity = 'swimming' THEN
            UPDATE totals SET totals.swimming = swimming+(NEW.participants * NEW.distance) 
            WHERE totals.scoutunit = NEW.scoutunit;
        END IF;
    END;//
delimiter ;
