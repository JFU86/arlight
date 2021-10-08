BEGIN TRANSACTION;
/* SPLIT */
CREATE TABLE [banner] (
[banner_id] INTEGER PRIMARY KEY NOT NULL,
[format_id] INTEGER NULL,
[name] VARCHAR(50) NOT NULL,
[time] DATETIME  NOT NULL,
[url] VARCHAR(255) NULL,
[img] VARCHAR(255) NULL,
[alt] VARCHAR(255) NULL,
[code] TEXT NULL,
[adviews] INTEGER DEFAULT '0' NOT NULL,
[adclicks] INTEGER DEFAULT '0' NOT NULL,
[status] INTEGER DEFAULT '1' NULL
);
/* SPLIT */
CREATE TABLE [formats] (
[format_id] INTEGER NOT NULL PRIMARY KEY,
[width] INTEGER NOT NULL,
[height] INTEGER NOT NULL,
[name] VARCHAR(50) NOT NULL,
[alt_name] VARCHAR(50) NULL,
[desc] VARCHAR(255) NOT NULL
);
/* SPLIT */
CREATE TABLE [login] (
[user_id] INTEGER PRIMARY KEY NOT NULL,
[name] VARCHAR(50) NOT NULL,
[pass] VARCHAR(64) NOT NULL,
[status] INTEGER DEFAULT '1' NOT NULL
);
/* SPLIT */
CREATE TABLE [reload] (
[time] INTEGER NOT NULL,
[ipadress] VARCHAR(32) NOT NULL,
[type] VARCHAR(10) NOT NULL,
[banner_id] INTEGER NOT NULL
);
/* SPLIT */
CREATE TABLE IF NOT EXISTS [settings] (
[config_name] VARCHAR(50) UNIQUE NOT NULL,
[config_value] VARCHAR(255) NULL,
PRIMARY KEY ([config_name],[config_value])
);
/* SPLIT */
INSERT INTO [settings] (config_name,config_value) VALUES ('Arlight.dbVersion', '1500');
/* SPLIT */
INSERT INTO [formats] (width, height, name, [desc]) VALUES (468, 60, 'Standard Banner', 'Standard Banner');
/* SPLIT */
INSERT INTO [formats] (width, height, name, [desc]) VALUES (234, 60, 'Half-Size Banner', 'Half-Size Banner');
/* SPLIT */
INSERT INTO [formats] (width, height, name, [desc]) VALUES (120, 600, 'Skyscraper', 'Skyscraper');
/* SPLIT */
INSERT INTO [formats] (width, height, name, [desc]) VALUES (88, 31, 'Button', 'Button');
/* SPLIT */
CREATE VIEW [vwRandomBanner] AS 
SELECT b.format_id format_id, b.banner_id banner_id, RANDOM() as ran FROM banner b LEFT JOIN formats f ON (b.format_id=f.format_id) WHERE b.status = 1 GROUP BY f.format_id HAVING MAX(ran) ORDER BY f.format_id;
/* SPLIT */
CREATE VIEW [vwUsers] AS 
SELECT user_id, name, status FROM login ORDER BY LOWER(name);
/* SPLIT */
COMMIT TRANSACTION;