BEGIN TRANSACTION;
/* SPLIT */
CREATE TABLE IF NOT EXISTS [settings] (
[config_name] VARCHAR(50)  UNIQUE NOT NULL,
[config_value] VARCHAR(255)  NULL,
PRIMARY KEY ([config_name],[config_value])
);
/* SPLIT */
REPLACE INTO [settings] (config_name, config_value) VALUES ('Arlight.dbVersion', '1500');
/* SPLIT */
DROP VIEW IF EXISTS [vwRandomBanner];
/* SPLIT */
CREATE VIEW IF NOT EXISTS [vwRandomBanner] AS
SELECT b.format_id format_id,b.banner_id banner_id,RANDOM() as ran FROM banner b LEFT JOIN formats f ON (b.format_id=f.format_id) WHERE b.status = 1 GROUP BY f.format_id HAVING MAX(ran) ORDER BY f.format_id;
/* SPLIT */
ALTER TABLE [login] RENAME TO [login_backup];
/* SPLIT */
CREATE TABLE [login] (
[user_id] INTEGER  PRIMARY KEY NOT NULL,
[name] VARCHAR(50)  NOT NULL,
[pass] VARCHAR(64)  NOT NULL,
[status] INTEGER DEFAULT '1' NOT NULL
);
/* SPLIT */
INSERT INTO [login] SELECT * FROM [login_backup];
/* SPLIT */
DROP TABLE [login_backup];
/* SPLIT */
CREATE VIEW IF NOT EXISTS [vwUsers] AS 
SELECT user_id, name, status FROM login ORDER BY LOWER(name);
/* SPLIT */
COMMIT TRANSACTION;