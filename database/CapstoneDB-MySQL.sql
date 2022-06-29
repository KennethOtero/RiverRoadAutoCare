-- --------------------------------------------------------------------------------
-- Team B
-- Capstone Project: River Road Auto Care Database
-- Abstract: Database
-- Date Started: March 26, 2022
-- --------------------------------------------------------------------------------
-- USE dbcpdm; -- Use our local database

-- --------------------------------------------------------------------------------
-- TO DO:
-- - Fix delete triggers from logging twice into the audit table.
-- Changes:
-- - 04/09/2022: 
-- - - Removed TServices audit tables, triggers, & sprocs
-- - - Added TEvents audit tables, triggers, & sprocs
-- - - Edited TJobs (removed date and comment columns) and added a FK to TEvents
-- - - Edited TJobs audit tables, triggers, views, & sprocs to fit the above changes
-- --------------------------------------------------------------------------------

-- --------------------------------------------------------------------------------
-- Drop Tables
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS TMessages;
DROP TABLE IF EXISTS TMessageStatuses;
DROP TABLE IF EXISTS TReviews;
DROP TABLE IF EXISTS TReviewTypes;
DROP TABLE IF EXISTS TJobs;
DROP TABLE IF EXISTS TServices;
DROP TABLE IF EXISTS TVehicles;
DROP TABLE IF EXISTS TUsers;
DROP TABLE IF EXISTS TStates;
DROP TABLE IF EXISTS TUserTypes;
DROP TABLE IF EXISTS TJobStatuses;
DROP TABLE IF EXISTS TEvents;

-- --------------------------------------------------------------------------------
-- Drop Audit Tables
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS Z_TUsers;
DROP TABLE IF EXISTS Z_TVehicles;
DROP TABLE IF EXISTS Z_TEvents;
DROP TABLE IF EXISTS Z_TJobs;
DROP TABLE IF EXISTS Z_TReviews;
DROP TABLE IF EXISTS Z_TMessages;

-- --------------------------------------------------------------------------------
-- Drop Views
-- --------------------------------------------------------------------------------
DROP VIEW IF EXISTS vViewAllUsers;
DROP VIEW IF EXISTS vViewAllCustomers;
DROP VIEW IF EXISTS vViewAllTechnicians;
DROP VIEW IF EXISTS vViewAllVehicles;
DROP VIEW IF EXISTS vViewOpenJobs;
DROP VIEW IF EXISTS vViewFinishedJobs;
DROP VIEW IF EXISTS vReviews;
DROP VIEW IF EXISTS vHighestReviews;
DROP VIEW IF EXISTS vLowestReviews;
DROP VIEW IF EXISTS vViewAverageRating;

-- --------------------------------------------------------------------------------
-- Drop Stored Procedures
-- --------------------------------------------------------------------------------
-- Former Functions From MSSQL
DROP PROCEDURE IF EXISTS uspFindJob;
DROP PROCEDURE IF EXISTS uspFindJobsInTime;
DROP PROCEDURE IF EXISTS uspFindUser;
DROP PROCEDURE IF EXISTS uspFindVehicle;
DROP PROCEDURE IF EXISTS uspIfVehicleExists;
DROP PROCEDURE IF EXISTS uspUserLoginExists;
DROP PROCEDURE IF EXISTS uspUserEmailExists;

-- Stored Procedures
DROP PROCEDURE IF EXISTS uspAddUser;
DROP PROCEDURE IF EXISTS uspUpdateUser;
DROP PROCEDURE IF EXISTS uspAddVehicle;
DROP PROCEDURE IF EXISTS uspUpdateVehicle;
DROP PROCEDURE IF EXISTS uspAddJob;
DROP PROCEDURE IF EXISTS uspUpdateJob;
DROP PROCEDURE IF EXISTS uspAddReview;
DROP PROCEDURE IF EXISTS uspAddMessage;
DROP PROCEDURE IF EXISTS uspAddEvent;
DROP PROCEDURE IF EXISTS uspUpdateEvent;
DROP PROCEDURE IF EXISTS uspUpdatePassword;

-- --------------------------------------------------------------------------------
-- Create Tables
-- --------------------------------------------------------------------------------
CREATE TABLE TUserTypes
(
	intUserTypeID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strType							VARCHAR(250)			NOT NULL
   ,CONSTRAINT TUserTypes_PK PRIMARY KEY (intUserTypeID)
);

CREATE TABLE TStates
(
	intStateID						INTEGER AUTO_INCREMENT	NOT NULL
   ,strState						VARCHAR(250)			NOT NULL
   ,CONSTRAINT TStates_PK PRIMARY KEY (intStateID)
);

CREATE TABLE TUsers
(
	intUserID						INTEGER AUTO_INCREMENT	NOT NULL
   ,strFirstName					VARCHAR(250)			NOT NULL
   ,strLastName						VARCHAR(250)			NOT NULL
   ,strAddress						VARCHAR(250)			NOT NULL
   ,strApartmentNumber				VARCHAR(250)					
   ,strCity							VARCHAR(250)			NOT NULL
   ,intStateID						INTEGER					NOT NULL
   ,strZip							VARCHAR(250)			NOT NULL
   ,strPhoneNumber					VARCHAR(250)			NOT NULL
   ,strEmail						VARCHAR(250)			NOT NULL
   ,strPassword						VARCHAR(250)			NOT NULL
   ,intUserTypeID					INTEGER					NOT NULL
   ,strSecurity						VARCHAR(250)			NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TUsers_UQ UNIQUE (strEmail) -- Make sure each email can only be used on 1 account
   ,CONSTRAINT TUsers_PK PRIMARY KEY (intUserID)
);

CREATE TABLE TVehicles
(
	intVehicleID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strVIN							VARCHAR(250)			NOT NULL
   ,strMake							VARCHAR(250)			NOT NULL
   ,intYear							INTEGER					NOT NULL
   ,strModel						VARCHAR(250)			NOT NULL
   ,strColor						VARCHAR(250)			NOT NULL
   ,strLicensePlate					VARCHAR(250)			NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,strComments						TEXT
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TVehicles_UQ UNIQUE (strVIN) -- Make sure each vehicle's VIN number is unique
   ,CONSTRAINT TVehicles_PK PRIMARY KEY (intVehicleID)
);

CREATE TABLE TServices
(
	intServiceID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strService						VARCHAR(250)			NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TServices_PK PRIMARY KEY (intServiceID)
);

CREATE TABLE TJobStatuses
(
	intJobStatusID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strStatus						VARCHAR(250)			NOT NULL
   ,CONSTRAINT TJobStatuses_PK PRIMARY KEY (intJobStatusID)
);

CREATE TABLE TEvents 
(
	event_id						INTEGER AUTO_INCREMENT 	NOT NULL
   ,event_start						DATETIME				NOT NULL
   ,event_end						DATETIME				NOT NULL
   ,event_text						TEXT					NOT NULL
   ,event_color						VARCHAR(7)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TEvents_PK PRIMARY KEY (event_id)
);

CREATE TABLE TJobs
(
	intJobID						INTEGER AUTO_INCREMENT	NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,intVehicleID					INTEGER					NOT NULL
   ,event_id						INTEGER					NOT NULL
   ,intJobStatusID					INTEGER					NOT NULL
   ,intServiceID					INTEGER					NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TJobs_PK PRIMARY KEY (intJobID)
);

CREATE TABLE TReviewTypes
(
	intReviewTypeID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strReviewType					VARCHAR(250)			NOT NULL
   ,CONSTRAINT TReviewTypes_PK PRIMARY KEY (intReviewTypeID)
);

CREATE TABLE TReviews
(
	intReviewID						INTEGER AUTO_INCREMENT	NOT NULL
   ,strReview						TEXT					NOT NULL
   ,dtmDate							DATETIME				NOT NULL
   ,intReviewTypeID					INTEGER					NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,intRating						INTEGER					NOT NULL -- Values 1-5 for "5 star" ratings
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TReviews_PK PRIMARY KEY (intReviewID)
);

CREATE TABLE TMessageStatuses
(
	intMessageStatusID				INTEGER AUTO_INCREMENT	NOT NULL
   ,strStatus						VARCHAR(250)			NOT NULL
   ,CONSTRAINT TMessageStatuses_PK PRIMARY KEY (intMessageStatusID)
);

CREATE TABLE TMessages
(
	intMessageID					INTEGER AUTO_INCREMENT	NOT NULL
   ,strMessage						TEXT					NOT NULL
   ,intMessageStatusID				INTEGER					NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT TMessages_PK PRIMARY KEY (intMessageID)
);

-- --------------------------------------------------------------------------------
-- Create Audit Tables
-- --------------------------------------------------------------------------------
CREATE TABLE Z_TUsers
(
	intUserAuditID					INTEGER AUTO_INCREMENT	NOT NULL
   ,intUserID						INTEGER 				NOT NULL
   ,strFirstName					VARCHAR(250)			NOT NULL
   ,strLastName						VARCHAR(250)			NOT NULL
   ,strAddress						VARCHAR(250)			NOT NULL
   ,strApartmentNumber				VARCHAR(250)					
   ,strCity							VARCHAR(250)			NOT NULL
   ,intStateID						INTEGER					NOT NULL
   ,strZip							VARCHAR(250)			NOT NULL
   ,strPhoneNumber					VARCHAR(250)			NOT NULL
   ,strEmail						VARCHAR(250)			NOT NULL
   ,strPassword						VARCHAR(250)			NOT NULL
   ,intUserTypeID					INTEGER					NOT NULL
   ,strSecurity						VARCHAR(250)			NOT NULL
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TUsers_PK PRIMARY KEY (intUserAuditID)
);

CREATE TABLE Z_TVehicles
(
	intVehicleAuditID				INTEGER AUTO_INCREMENT	NOT NULL
   ,intVehicleID					INTEGER					NOT NULL
   ,strVIN							VARCHAR(250)			NOT NULL
   ,strMake							VARCHAR(250)			NOT NULL
   ,intYear							INTEGER					NOT NULL
   ,strModel						VARCHAR(250)			NOT NULL
   ,strColor						VARCHAR(250)			NOT NULL
   ,strLicensePlate					VARCHAR(250)			NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,strComments						TEXT
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TVehicles_PK PRIMARY KEY (intVehicleAuditID)
);

CREATE TABLE Z_TEvents
(
	intEventAuditID					INTEGER AUTO_INCREMENT	NOT NULL
   ,event_id						INTEGER					NOT NULL
   ,event_start						DATETIME				NOT NULL
   ,event_end						DATETIME				NOT NULL
   ,event_text						TEXT					NOT NULL
   ,event_color						VARCHAR(7)				NOT NULL
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TEvents_PK PRIMARY KEY (intEventAuditID)
);

CREATE TABLE Z_TJobs
(
	intJobAuditID					INTEGER AUTO_INCREMENT	NOT NULL
   ,intJobID						INTEGER					NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,intVehicleID					INTEGER					NOT NULL
   ,event_id						INTEGER					NOT NULL
   ,intJobStatusID					INTEGER					NOT NULL
   ,intServiceID					INTEGER					NOT NULL
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TJobs_PK PRIMARY KEY (intJobAuditID)
);

CREATE TABLE Z_TReviews
(
	intReviewAuditID				INTEGER AUTO_INCREMENT	NOT NULL
   ,intReviewID						INTEGER					NOT NULL
   ,strReview						TEXT					NOT NULL
   ,dtmDate							DATETIME				NOT NULL
   ,intReviewTypeID					INTEGER					NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,intRating						INTEGER					NOT NULL -- Values 1-5 for "5 star" ratings
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TReviews_PK PRIMARY KEY (intReviewAuditID)
);

CREATE TABLE Z_TMessages
(
	intMessageAuditID				INTEGER AUTO_INCREMENT	NOT NULL
   ,intMessageID					INTEGER					NOT NULL
   ,strMessage						TEXT					NOT NULL
   ,intMessageStatusID				INTEGER					NOT NULL
   ,intUserID						INTEGER					NOT NULL
   ,strUpdatedBy					VARCHAR(128)			NOT NULL
   ,dtmUpdatedOn					DATETIME				NOT NULL
   ,strAction						VARCHAR(1)				NOT NULL
   ,strModified_Reason				VARCHAR(250)
   ,CONSTRAINT Z_TMessages_PK PRIMARY KEY (intMessageAuditID)
);

-- --------------------------------------------------------------------------------
-- Create Triggers
-- --------------------------------------------------------------------------------
-- Insert trigger for TUsers
DELIMITER //
CREATE TRIGGER tr_InsertTUsers
AFTER INSERT ON TUsers
FOR EACH ROW
BEGIN
	-- Set strAction to Insert (I)
    SET @strAction = 'I';
	INSERT INTO Z_TUsers (intUserID, strFirstName, strLastName, strAddress, strApartmentNumber, strCity, 
						  intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID, strSecurity, strUpdatedBy, 
						  dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 intUserID
		,strFirstName
		,strLastName
		,strAddress
		,strApartmentNumber
		,strCity
		,intStateID
		,strZip
		,strPhoneNumber
		,strEmail
		,strPassword
		,intUserTypeID
        ,strSecurity
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TUsers WHERE intUserID = NEW.intUserID;
END //
DELIMITER ;

-- Update trigger for TUsers
DELIMITER //
CREATE TRIGGER tr_UpdateTUsers
AFTER UPDATE ON TUsers
FOR EACH ROW
BEGIN
	-- Set to updated (U)
	SET @strAction = 'U';
    
	INSERT INTO Z_TUsers (intUserID, strFirstName, strLastName, strAddress, strApartmentNumber, strCity, 
			  intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID, strSecurity, strUpdatedBy, 
			  dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.intUserID
		,NEW.strFirstName
		,NEW.strLastName
		,NEW.strAddress
		,NEW.strApartmentNumber
		,NEW.strCity
		,NEW.intStateID
		,NEW.strZip
		,NEW.strPhoneNumber
		,NEW.strEmail
		,NEW.strPassword
		,NEW.intUserTypeID
        ,NEW.strSecurity
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TUsers
	WHERE intUserID = NEW.intUserID;	
END //
DELIMITER ;

-- Delete trigger for TUsers
DELIMITER //
CREATE TRIGGER tr_DeleteTUsers
AFTER DELETE ON TUsers
FOR EACH ROW
BEGIN
	-- Set to delete (D)
	SET @strAction = 'D';
    
	INSERT INTO Z_TUsers (intUserID, strFirstName, strLastName, strAddress, strApartmentNumber, strCity, 
			  intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID, strSecurity, strUpdatedBy, 
			  dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.intUserID
		,OLD.strFirstName
		,OLD.strLastName
		,OLD.strAddress
		,OLD.strApartmentNumber
		,OLD.strCity
		,OLD.intStateID
		,OLD.strZip
		,OLD.strPhoneNumber
		,OLD.strEmail
		,OLD.strPassword
		,OLD.intUserTypeID
        ,OLD.strSecurity
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TUsers;	
END //
DELIMITER ;

-- Insert trigger for TVehicles
DELIMITER //
CREATE TRIGGER tr_InsertTVehicles
AFTER INSERT ON TVehicles
FOR EACH ROW
BEGIN
	-- Set to inserted (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TVehicles (intVehicleID, strVIN, strMake, intYear, strModel, strColor, strLicensePlate, 
								  intUserID, strComments, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 intVehicleID
		,strVIN
		,strMake
		,intYear
		,strModel
		,strColor
		,strLicensePlate
		,intUserID
		,strComments
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TVehicles WHERE intVehicleID = NEW.intVehicleID;
END //
DELIMITER ;

-- Update trigger for TVehicles
DELIMITER //
CREATE TRIGGER tr_UpdateTVehicles
AFTER UPDATE ON TVehicles
FOR EACH ROW
BEGIN
	-- Set action to updated (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TVehicles (intVehicleID, strVIN, strMake, intYear, strModel, strColor, strLicensePlate, 
								  intUserID, strComments, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.intVehicleID
		,NEW.strVIN
		,NEW.strMake
		,NEW.intYear
		,NEW.strModel
		,NEW.strColor
		,NEW.strLicensePlate
		,NEW.intUserID
		,NEW.strComments
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TVehicles WHERE intVehicleID = NEW.intVehicleID;
END //
DELIMITER ;

-- Delete trigger for TVehicles
DELIMITER //
CREATE TRIGGER tr_DeleteTVehicles
AFTER DELETE ON TVehicles
FOR EACH ROW
BEGIN
	-- Set action to delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TVehicles (intVehicleID, strVIN, strMake, intYear, strModel, strColor, strLicensePlate, 
								  intUserID, strComments, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.intVehicleID
		,OLD.strVIN
		,OLD.strMake
		,OLD.intYear
		,OLD.strModel
		,OLD.strColor
		,OLD.strLicensePlate
		,OLD.intUserID
		,OLD.strComments
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TVehicles;
END //
DELIMITER ;

-- Inserted trigger for TEvents
DELIMITER //
CREATE TRIGGER tr_InsertEvents
AFTER INSERT ON TEvents
FOR EACH ROW
BEGIN
	-- Set action to inserted (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TEvents(event_id, event_start, event_end, event_text, event_color, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 event_id
		,event_start
        ,event_end
        ,event_text
        ,event_color
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TEvents WHERE event_id = NEW.event_id;
END //
DELIMITER ;

-- Update trigger for TEvents
DELIMITER //
CREATE TRIGGER tr_UpdateTEvents
AFTER UPDATE ON TEvents
FOR EACH ROW
BEGIN
	-- Set action to update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TEvents(event_id, event_start, event_end, event_text, event_color, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.event_id
		,NEW.event_start
        ,NEW.event_end
        ,NEW.event_text
        ,NEW.event_color
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TEvents WHERE event_id = NEW.event_id;
END //
DELIMITER ;

-- Delete trigger for TEvents
DELIMITER //
CREATE TRIGGER tr_DeleteTEvents
AFTER DELETE ON TEvents
FOR EACH ROW
BEGIN
	-- Set action to delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TEvents(event_id, event_start, event_end, event_text, event_color, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.event_id
		,OLD.event_start
        ,OLD.event_end
        ,OLD.event_text
        ,OLD.event_color
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TEvents;
END //
DELIMITER ;

-- Insert trigger for TJobs
DELIMITER //
CREATE TRIGGER tr_InsertTJobs
AFTER INSERT ON TJobs
FOR EACH ROW
BEGIN
	-- Set action to insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TJobs (intJobID, intUserID, intVehicleID, event_id, intJobStatusID, intServiceID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 intJobID
		,intUserID
		,intVehicleID
		,event_id
		,intJobStatusID
		,intServiceID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TJobs WHERE intJobID = NEW.intJobID;
END //
DELIMITER ;

-- Update trigger for TJobs
DELIMITER //
CREATE TRIGGER tr_UpdateTJobs
AFTER UPDATE ON TJobs
FOR EACH ROW
BEGIN
	-- Set action to update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TJobs (intJobID, intUserID, intVehicleID, event_id, intJobStatusID, intServiceID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.intJobID
		,NEW.intUserID
		,NEW.intVehicleID
		,NEW.event_id
		,NEW.intJobStatusID
		,NEW.intServiceID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TJobs WHERE intJobID = NEW.intJobID;
END //
DELIMITER ;

-- Delete trigger for TJobs
DELIMITER //
CREATE TRIGGER tr_DeleteTJobs
AFTER DELETE ON TJobs
FOR EACH ROW
BEGIN
	-- Set action to delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TJobs (intJobID, intUserID, intVehicleID, event_id, intJobStatusID, intServiceID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.intJobID
		,OLD.intUserID
		,OLD.intVehicleID
		,OLD.event_id
		,OLD.intJobStatusID
		,OLD.intServiceID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TJobs;
END //
DELIMITER ;

-- Insert trigger for TReviews
DELIMITER //
CREATE TRIGGER tr_InsertTReviews
AFTER INSERT ON TReviews
FOR EACH ROW
BEGIN
	-- Set action to insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TReviews (intReviewID, strReview, dtmDate, intReviewTypeID, intUserID, intRating, 
									strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 intReviewID
		,strReview
		,dtmDate
		,intReviewTypeID
		,intUserID
		,intRating
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TReviews WHERE intReviewID = NEW.intReviewID;
END //
DELIMITER ;

-- Update trigger for TReviews
DELIMITER //
CREATE TRIGGER tr_UpdateTReviews
AFTER UPDATE ON TReviews
FOR EACH ROW
BEGIN
	-- Set action to update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TReviews (intReviewID, strReview, dtmDate, intReviewTypeID, intUserID, intRating, 
									strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.intReviewID
		,NEW.strReview
		,NEW.dtmDate
		,NEW.intReviewTypeID
		,NEW.intUserID
		,NEW.intRating
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TReviews WHERE intReviewID = NEW.intReviewID;
END //
DELIMITER ;

-- Delete trigger for TReviews
DELIMITER //
CREATE TRIGGER tr_DeleteTReviews
AFTER DELETE ON TReviews
FOR EACH ROW
BEGIN
	-- Set action to delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TReviews (intReviewID, strReview, dtmDate, intReviewTypeID, intUserID, intRating, 
									strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.intReviewID
		,OLD.strReview
		,OLD.dtmDate
		,OLD.intReviewTypeID
		,OLD.intUserID
		,OLD.intRating
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TReviews;
END //
DELIMITER ;

-- Insert trigger for TMessages
DELIMITER //
CREATE TRIGGER tr_InsertTMessages
AFTER INSERT ON TMessages
FOR EACH ROW
BEGIN
	-- Set action to insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TMessages (intMessageID, strMessage, intMessageStatusID, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 intMessageID
		,strMessage
		,intMessageStatusID
		,intUserID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TMessages WHERE intMessageID = NEW.intMessageID;
END //
DELIMITER ;

-- Update trigger for TMessages
DELIMITER //
CREATE TRIGGER tr_UpdateTMessages
AFTER UPDATE ON TMessages
FOR EACH ROW
BEGIN
	-- Set action to update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TMessages (intMessageID, strMessage, intMessageStatusID, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 NEW.intMessageID
		,NEW.strMessage
		,NEW.intMessageStatusID
		,NEW.intUserID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TMessages WHERE intMessageID = NEW.intMessageID;
END //
DELIMITER ;

-- Delete trigger for TMessages
DELIMITER //
CREATE TRIGGER tr_DeleteTMessages
AFTER DELETE ON TMessages
FOR EACH ROW
BEGIN
	-- Set action to delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TMessages (intMessageID, strMessage, intMessageStatusID, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
	SELECT 
		 OLD.intMessageID
		,OLD.strMessage
		,OLD.intMessageStatusID
		,OLD.intUserID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,OLD.strModified_Reason
	FROM TMessages;
END //
DELIMITER ;

-- --------------------------------------------------------------------------------
-- Identify and Create Foreign Keys
-- --------------------------------------------------------------------------------
--
-- #	Child								Parent						Column(s)
-- -	-----								------						---------
-- 1	TUsers								TStates						intStateID
-- 2	TVehicles							TUsers						intUserID
-- 3	TJobs								TUsers						intUserID
-- 4	TJobs								TVehicles					intVehicleID
-- 5	TReviews							TUsers						intUserID
-- 6	TReviews							TReviewTypes				intReviewTypeID
-- 7	TReviews							TJobs						intJobID -- No longer used
-- 8	TUsers								TUserTypes					intUserTypeID
-- 9	TJobs								TJobStatuses				intJobStatusID
-- 10	TMessages							TUsers						intUserID
-- 11	TMessages							TMessageStatuses			intMessageStatusID
-- 12	TJobs								TServices					intServiceID
-- 13	TJobs								TEvents						event_id
-- -	-----								------						---------
-- 1
ALTER TABLE TUsers ADD CONSTRAINT TUsers_TStates_FK
FOREIGN KEY (intStateID) REFERENCES TStates (intStateID);

-- 2
ALTER TABLE TVehicles ADD CONSTRAINT TVehicles_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- 3
ALTER TABLE TJobs ADD CONSTRAINT TJobs_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- 4
ALTER TABLE TJobs ADD CONSTRAINT TJobs_TVehicles_FK
FOREIGN KEY (intVehicleID) REFERENCES TVehicles (intVehicleID);

-- 5
ALTER TABLE TReviews ADD CONSTRAINT TReviews_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- 6
ALTER TABLE TReviews ADD CONSTRAINT TReviews_TReviewTypes_FK
FOREIGN KEY (intReviewTypeID) REFERENCES TReviewTypes (intReviewTypeID);

-- 7
-- ALTER TABLE TReviews ADD CONSTRAINT TReviews_TJobs_FK
-- FOREIGN KEY (intJobID) REFERENCES TJobs (intJobID);

-- 8
ALTER TABLE TUsers ADD CONSTRAINT TUsers_TUserTypes_FK
FOREIGN KEY (intUserTypeID) REFERENCES TUserTypes (intUserTypeID);

-- 9
ALTER TABLE TJobs ADD CONSTRAINT TJobs_TJobStatuses_FK
FOREIGN KEY (intJobStatusID) REFERENCES TJobStatuses (intJobStatusID);

-- 10
ALTER TABLE TMessages ADD CONSTRAINT TMessages_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- 11
ALTER TABLE TMessages ADD CONSTRAINT TMessages_TMessageStatuses_FK
FOREIGN KEY (intMessageStatusID) REFERENCES TMessageStatuses (intMessageStatusID);

-- 12
ALTER TABLE TJobs ADD CONSTRAINT TJobs_TServices_FK
FOREIGN KEY (intServiceID) REFERENCES TServices (intServiceID);

-- 13
ALTER TABLE TJobs ADD CONSTRAINT TJobs_TEvents_FK
FOREIGN KEY (event_id) REFERENCES TEvents (event_id);

-- Add unique constraints to all user's email
ALTER TABLE TUsers ADD CONSTRAINT Email_UQ UNIQUE (strEmail);

-- Add unique constraints to scheduled dates for jobs
-- ALTER TABLE TJobs ADD CONSTRAINT StartDate_UQ UNIQUE (dtmStartDate);
-- ALTER TABLE TJobs ADD CONSTRAINT EndDate_UQ UNIQUE (dtmEndDate);

-- Add a unique constraint to VIN numbers for vehicles
ALTER TABLE TVehicles ADD CONSTRAINT VIN_UQ UNIQUE (strVIN);

-- Add unique constraints to start/end dates for TEvents
ALTER TABLE TEvents ADD CONSTRAINT EventStart_UQ UNIQUE (event_start);
ALTER TABLE TEvents ADD CONSTRAINT EventEnd_UQ UNIQUE (event_end);

-- --------------------------------------------------------------------------------
-- Insert Data
-- --------------------------------------------------------------------------------
INSERT INTO TStates (strState)
VALUES	('Alabama')
	   ,('Alaska')
	   ,('Arizona')
	   ,('Arkansas')
	   ,('California')
	   ,('Colorado')
	   ,('Connecticut')
	   ,('Delaware')
	   ,('Florida')
	   ,('Georgia')
	   ,('Hawaii')
	   ,('Idaho')
	   ,('Illinois')
	   ,('Indiana')
	   ,('Iowa')
	   ,('Kansas')
	   ,('Kentucky')
	   ,('Louisiana')
	   ,('Maine')
	   ,('Maryland')
	   ,('Massachusetts')
	   ,('Michigan')
	   ,('Minnesota')
	   ,('Mississippi')
	   ,('Missouri')
	   ,('Montana')
	   ,('Nebraska')
	   ,('Nevada')
	   ,('New Hampshire')
	   ,('New Jersey')
	   ,('New Mexico')
	   ,('New York')
	   ,('North Carolina')
	   ,('North Dakota')
	   ,('Ohio')
	   ,('Oklahoma')
	   ,('Oregon')
	   ,('Pennsylvania')
	   ,('Rhode Island')
	   ,('South Carolina')
	   ,('South Dakota')
	   ,('Tennessee')
	   ,('Texas')
	   ,('Utah')
	   ,('Vermont')
	   ,('Virginia')
	   ,('Washington')
	   ,('West Virginia')
	   ,('Wisconsin')
	   ,('Wyoming');

INSERT INTO TServices (strService)
VALUES	('Oil Change')
	   ,('Engine Repair')
	   ,('Suspension Repair')
	   ,('Brake Repair')
	   ,('HVAC Repair')
	   ,('Electrical Repair')
	   ,('Exhaust Repair')
	   ,('Fog Light/Light Bar Install')
	   ,('Lift Kit Install')
	   ,('Winch Install')
	   ,('Aftermarket Engine Install')
	   ,('Aftermarket Suspension Install')
	   ,('Aftermarket Exhaust Install')
       ,('Custom');

INSERT INTO TJobStatuses (strStatus)
VALUES	('Open')
	   ,('Finished')
	   ,('Missed')
	   ,('Delayed');

INSERT INTO TMessageStatuses (strStatus)
VALUES	('Read')
	   ,('Unread');

INSERT INTO TReviewTypes (strReviewType)
VALUES	('Store')
	   ,('Job');

INSERT INTO TUserTypes (strType)
VALUES	('Customer')
	   ,('Technician')
	   ,('Admin');

-- --------------------------------------------------------------------------------
-- Mock Data for Testing Purposes
-- --------------------------------------------------------------------------------
INSERT INTO TUsers (strFirstName, strLastName, strAddress, strApartmentNumber, strCity, 
					intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID, strSecurity)
VALUES	('Ken', 'Otero', '123 Street', NULL, 'Cincinnati', 1, '45211', '111-222-3333', 'test@gmail.com', 'password', 1, 'New York City')
	   ,('Luke', 'Braun', '123 Street', NULL, 'Cincinnati', 1, '45211', '111-222-3333', 'test2@gmail.com', 'password', 1, 'Cincinnati')
	   ,('Kentaro', 'Watanabe', '123 Street', NULL, 'Cincinnati', 1, '45211', '111-222-3333', 'test3@gmail.com', 'password', 1, 'Kyoto')
       ,('Jeff', 'Henderson', '123 Street', NULL, 'Florence', 1, '41015', '222-222-3333', 'Jeff@riverroadauto.com', 'temppass123!@#', 3, 'Dayton');

INSERT INTO TVehicles (strVIN, strMake, intYear, strModel, strColor, strLicensePlate, intUserID, strComments)
VALUES	('111', 'Toyota', 2005, 'Corolla', 'Red', 'BIG1', 1, 'this is garbage')
	   ,('222', 'Honda', 2006, 'Civic', 'Blue', 'BIG2', 2, 'this is okay')
	   ,('333', 'Ford', 2007, 'Focus', 'Yellow', 'BIG3', 3, 'this is great!')
	   ,('4444', 'Tesla', 2005, 'Truck', 'Red', 'SMALL1', 1, 'this is a death trap');

/*
INSERT INTO TEvents (event_start, event_end, event_text, event_color)
VALUES	('2022-01-01', '2022-01-02', 'placeholder text', 'color')
	   ,('2022-01-03', '2022-01-04', 'placeholder text', 'color')
       ,('2022-01-05', '2022-01-06', 'placeholder text', 'color');
       
INSERT INTO TJobs (intUserID, intVehicleID, event_id, intJobStatusID, intServiceID)
VALUES	(1, 1, 1, 1, 1)
	   ,(2, 2, 2, 1, 2)
	   ,(3, 3, 3, 1, 3);
*/

INSERT INTO TReviews (strReview, dtmDate, intReviewTypeID, intUserID, intRating)
VALUES	('Nothing really negative to say, some great work for a small shop.', NOW(), 1, 1, 4)
	   ,('They did a GREAT JOB! Definitely will be coming back.', NOW(), 1, 2, 5)
	   ,('Wish they were faster.', NOW(), 1, 3, 3);

INSERT INTO TMessages (strMessage, intMessageStatusID, intUserID)
VALUES	('Hey man fix this already', 1, 1)
	   ,('I will be there tomorrow', 1, 2)
	   ,('Are you there?', 1, 3);
       
-- --------------------------------------------------------------------------------
-- Create Views
-- --------------------------------------------------------------------------------
-- View all users
CREATE VIEW vViewAllUsers
AS
	SELECT
		TU.intUserID
	   ,TU.strFirstName
	   ,TU.strLastName
	   ,TU.strAddress
	   ,TU.strApartmentNumber
	   ,TU.strCity
	   ,TS.strState
	   ,TU.strZip
	   ,TU.strPhoneNumber
	   ,TU.strEmail
	   ,TU.strPassword
	   ,TUT.strType
	FROM 
		TUsers as TU JOIN TStates as TS
			ON TU.intStateID = TS.intStateID
		JOIN TUserTypes as TUT
			ON TUT.intUserTypeID = TU.intUserTypeID;
            
-- View all customers
CREATE VIEW vViewAllCustomers
AS
	SELECT
		TU.intUserID
	   ,TU.strFirstName
	   ,TU.strLastName
	   ,TU.strAddress
	   ,TU.strApartmentNumber
	   ,TU.strCity
	   ,TS.strState
	   ,TU.strZip
	   ,TU.strPhoneNumber
	   ,TU.strEmail
	   ,TU.strPassword
	   ,TUT.strType
	FROM 
		TUsers as TU JOIN TStates as TS
			ON TU.intStateID = TS.intStateID
		JOIN TUserTypes as TUT
			ON TUT.intUserTypeID = TU.intUserTypeID 
	WHERE
		TU.intUserTypeID = 1;
        
-- View all technicians
CREATE VIEW vViewAllTechnicians
AS
	SELECT
		TU.intUserID
	   ,TU.strFirstName
	   ,TU.strLastName
	   ,TU.strAddress
	   ,TU.strApartmentNumber
	   ,TU.strCity
	   ,TS.strState
	   ,TU.strZip
	   ,TU.strPhoneNumber
	   ,TU.strEmail
	   ,TU.strPassword
	   ,TUT.strType
	FROM 
		TUsers as TU JOIN TStates as TS
			ON TU.intStateID = TS.intStateID
		JOIN TUserTypes as TUT
			ON TUT.intUserTypeID = TU.intUserTypeID 
	WHERE
		TU.intUserTypeID = 2;  
        
-- View all vehicles
CREATE VIEW vViewAllVehicles
AS
	SELECT
		TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	   ,TV.strComments
	FROM
		TVehicles as TV JOIN TUsers as TU
			ON TV.intUserID = TU.intUserID; 
            
-- View all open jobs            
CREATE VIEW vViewOpenJobs
AS
	SELECT
		TJ.intJobID
	   ,TE.event_start
       ,TE.event_end
       ,TE.event_text
	   ,TJS.strStatus
	   ,TS.strService
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	   ,TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,TV.strComments as VehicleComments
	FROM
		TJobs as TJ JOIN TUsers as TU
			ON TJ.intUserID = TU.intUserID
		JOIN TVehicles as TV
			ON TV.intVehicleID = TJ.intVehicleID
		JOIN TJobStatuses as TJS
			ON TJS.intJobStatusID = TJ.intJobStatusID
		JOIN TServices as TS
			ON TS.intServiceID = TJ.intServiceID
		JOIN TEvents as TE
			ON TE.event_id = TJ.event_id
	WHERE
		TJ.intJobStatusID = 1;       
        
-- View all finished jobs
CREATE VIEW vViewFinishedJobs
AS
	SELECT
		TJ.intJobID
	   ,TE.event_start
       ,TE.event_end
       ,TE.event_text
	   ,TJS.strStatus
	   ,TS.strService
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	   ,TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,TV.strComments as VehicleComments
	FROM
		TJobs as TJ JOIN TUsers as TU
			ON TJ.intUserID = TU.intUserID
		JOIN TVehicles as TV
			ON TV.intVehicleID = TJ.intVehicleID
		JOIN TJobStatuses as TJS
			ON TJS.intJobStatusID = TJ.intJobStatusID
		JOIN TServices as TS
			ON TS.intServiceID = TJ.intServiceID
		JOIN TEvents as TE
			ON TE.event_id = TJ.event_id
	WHERE
		TJ.intJobStatusID = 2; 
        
-- See all reviews
CREATE VIEW vReviews
AS
	SELECT
		TR.intReviewID
	   ,TR.strReview
	   ,TR.dtmDate
	   ,TR.intRating
	   ,TRT.strReviewType
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	FROM
		TReviews as TR JOIN TUsers as TU
			ON TR.intUserID = TU.intUserID
		JOIN TReviewTypes as TRT
			ON TRT.intReviewTypeID = TR.intReviewTypeID;  
            
-- See the top 3 rated reviews
CREATE VIEW vHighestReviews
AS
	SELECT
		TR.intReviewID
	   ,TR.strReview
	   ,TR.dtmDate
	   ,TR.intRating
	   ,TRT.strReviewType
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	FROM
		TReviews as TR JOIN TUsers as TU
			ON TR.intUserID = TU.intUserID
		JOIN TReviewTypes as TRT
			ON TRT.intReviewTypeID = TR.intReviewTypeID
	ORDER BY 
		TR.intRating DESC LIMIT 3; 
        
-- See the lowest 3 rated reviews
CREATE VIEW vLowestReviews
AS
	SELECT
		TR.intReviewID
	   ,TR.strReview
	   ,TR.dtmDate
	   ,TR.intRating
	   ,TRT.strReviewType
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	FROM
		TReviews as TR JOIN TUsers as TU
			ON TR.intUserID = TU.intUserID
		JOIN TReviewTypes as TRT
			ON TRT.intReviewTypeID = TR.intReviewTypeID
	ORDER BY 
		TR.intRating ASC LIMIT 3;   
        
-- View the average rating of all reviews
CREATE VIEW vViewAverageRating
AS
	SELECT
		AVG(intRating) as Rating
	FROM
		TReviews;     
        
-- --------------------------------------------------------------------------------
-- Create Stored Procedures - Former MSSQL Functions that couldn't port over to MySQL
-- functions due to MySQL not supporting the 'table' return type.
-- --------------------------------------------------------------------------------
-- Find a user based on email
DELIMITER //
CREATE PROCEDURE uspFindUser (
    IN p_strEmail VARCHAR(250)
)
BEGIN
    -- Find a user's info based on their email
    SELECT
        TU.intUserID
       ,TU.strFirstName
       ,TU.strLastName
       ,TU.strAddress
       ,TU.strApartmentNumber
       ,TU.strCity
       ,TS.strState
       ,TU.strZip
       ,TU.strPhoneNumber
       ,TU.strEmail
       ,TU.strPassword
       ,TUT.strType
       ,TU.strSecurity
    FROM 
        TUsers as TU JOIN TStates as TS
            ON TU.intStateID = TS.intStateID
        JOIN TUserTypes as TUT
            ON TUT.intUserTypeID = TU.intUserTypeID
    WHERE
        strEmail = p_strEmail;
END //
DELIMITER ;

-- Find a vehicle based on UserID
DELIMITER //
CREATE PROCEDURE uspFindVehicle (
    IN p_intUserID INT
)
BEGIN
	-- Find a vehicle's info based on the user ID
	SELECT
		TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,TV.strComments
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	FROM 
		TVehicles as TV JOIN TUsers as TU
			ON TV.intUserID = TU.intUserID
	WHERE
		TV.intUserID = p_intUserID;
END //
DELIMITER ;

-- Find a specific job based on UserID
DELIMITER //
-- Create a procedure to find a specific job
CREATE PROCEDURE uspFindJob (
    IN p_intUserID INT
)
BEGIN
	-- Find a job's info based on the user ID
	SELECT
		TJ.intJobID
	   ,TE.event_id
	   ,TE.event_start
	   ,TE.event_end
	   ,TE.event_text
	   ,TJS.strStatus
	   ,TS.strService
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	   ,TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,TV.strComments as VehicleComments
	FROM 
		TJobs as TJ JOIN TUsers as TU
			ON TJ.intUserID = TU.intUserID
		JOIN TVehicles as TV
			ON TJ.intVehicleID = TV.intVehicleID 
		JOIN TJobStatuses AS TJS
			ON TJS.intJobStatusID = TJ.intJobStatusID
		JOIN TServices as TS
			ON TS.intServiceID = TJ.intServiceID
		JOIN TEvents as TE
			ON TE.event_id = TJ.event_id
	WHERE
		TJ.intUserID = p_intUserID;
END //
DELIMITER ;

-- Find all open jobs within a timeframe
DELIMITER //
-- Find all open jobs within a timeframe
CREATE PROCEDURE uspFindJobsInTime (
    IN p_dtmStartDate DATETIME,
    IN p_dtmEndDate DATETIME
)
BEGIN
	-- Find all open jobs within a timeframe
	SELECT 
		TJ.intJobID
	   ,TE.event_id
	   ,TE.event_start
	   ,TE.event_end
	   ,TE.event_text
	   ,TJS.strStatus
	   ,TS.strService
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	   ,TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TV.strColor
	   ,TV.strLicensePlate
	   ,TV.strComments as VehicleComments
	FROM 
		TJobs as TJ JOIN TUsers as TU
			ON TJ.intUserID = TU.intUserID
		JOIN TVehicles as TV
			ON TJ.intVehicleID = TV.intVehicleID 
		JOIN TJobStatuses AS TJS
			ON TJS.intJobStatusID = TJ.intJobStatusID
		JOIN TServices as TS
			ON TS.intServiceID = TJ.intServiceID
		JOIN TEvents as TE
			ON TE.event_id = TJ.event_id
	WHERE TE.event_start >= p_dtmStartDate AND TE.event_end <= p_dtmEndDate AND TJ.intJobStatusID = 1;
END //
DELIMITER ;

-- Check if a login already exists in the database
DELIMITER //
-- Check if a login already exists in the database
CREATE PROCEDURE uspUserLoginExists (
    IN p_strEmail VARCHAR(250),
    IN p_strPassword VARCHAR(250)
)
BEGIN
	SELECT
		TU.intUserID
	   ,TU.strEmail
       ,TU.strPassword
	FROM
		TUsers as TU
	WHERE
		TU.strEmail = p_strEmail AND TU.strPassword = p_strPassword;
END //
DELIMITER ;

-- Check if an email exists in the DB
DELIMITER //
CREATE PROCEDURE uspUserEmailExists (
	IN p_strEmail VARCHAR(250)
)
BEGIN
	SELECT
		TU.intUserID
	   ,TU.strEmail
    FROM
		TUsers as TU
	WHERE TU.strEmail = p_strEmail;
END //
DELIMITER ;

-- Check if a vehicle already exists in the DB
DELIMITER //
-- Check if a vehicle already exists within the database
CREATE PROCEDURE uspIfVehicleExists (
    IN p_strVIN VARCHAR(250)
)
BEGIN
	SELECT
		TV.intVehicleID
	   ,TV.strVIN
	   ,TV.strMake
	   ,TV.strModel
	   ,TV.intYear
	   ,TU.intUserID
	   ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
	   ,CONCAT(TU.strPhoneNumber,' ',TU.strEmail) as ContactInfo
	FROM
		TVehicles as TV JOIN TUsers as TU
			ON TV.intUserID = TU.intUserID
	WHERE
		TV.strVIN = p_strVIN;
END //
DELIMITER ;

-- --------------------------------------------------------------------------------
-- Create Stored Procedures - Insert & Update Data
-- --------------------------------------------------------------------------------
DELIMITER //
-- Add a user
CREATE PROCEDURE uspAddUser (
    IN p_strFirstName 		VARCHAR(250),
    IN p_strLastName 		VARCHAR(250),
    IN p_strAddress 		VARCHAR(250),
    IN p_strApartmentNumber VARCHAR(250),
    IN p_strCity 			VARCHAR(250),
    IN p_intStateID 		INT,
    IN p_strZip 			VARCHAR(250),
    IN p_strPhoneNumber 	VARCHAR(250),
    IN p_strEmail 			VARCHAR(250),
    IN p_strPassword 		VARCHAR(250),
    IN p_intUserTypeID 		INT,
    IN p_strSecurity		VARCHAR(250),
    OUT p_intUserID			INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TUsers
	INSERT INTO TUsers (strFirstName, strLastName, strAddress, strApartmentNumber, 
						strCity, intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID, strSecurity)
	VALUES (p_strFirstName, p_strLastName, p_strAddress, p_strApartmentNumber, p_strCity, p_intStateID, p_strZip, 
			p_strPhoneNumber, p_strEmail, p_strPassword, p_intUserTypeID, p_strSecurity);
            
	-- Get the latest PK
	SELECT intUserID INTO p_intUserID FROM TUsers ORDER BY intUserID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update a user
DELIMITER //
CREATE PROCEDURE uspUpdateUser (
	IN p_intUserID 			INT,
    IN p_strFirstName 		VARCHAR(250),
    IN p_strLastName 		VARCHAR(250),
    IN p_strAddress 		VARCHAR(250),
    IN p_strApartmentNumber VARCHAR(250),
    IN p_strCity 			VARCHAR(250),
    IN p_intStateID 		INT,
    IN p_strZip 			VARCHAR(250),
    IN p_strPhoneNumber 	VARCHAR(250),
    IN p_strEmail 			VARCHAR(250),
    IN p_strPassword 		VARCHAR(250),
    IN p_intUserTypeID 		INT,
    IN p_strSecurity		VARCHAR(250),
    IN p_strModifiedReason 	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TUsers
	SET
	    strFirstName = p_strFirstName
	   ,strLastName = p_strLastName
	   ,strAddress = p_strAddress
	   ,strApartmentNumber = p_strApartmentNumber
	   ,strCity = p_strCity
	   ,intStateID = p_intStateID
	   ,strZip = p_strZip
	   ,strPhoneNumber = p_strPhoneNumber
	   ,strEmail = p_strEmail
	   ,strPassword = p_strPassword
	   ,intUserTypeID = p_intUserTypeID
       ,strSecurity = p_strSecurity
	   ,strModified_Reason = p_strModifiedReason
	WHERE
		intUserID = p_intUserID;
COMMIT;
END //
DELIMITER ;

-- Add a vehicle
DELIMITER //
CREATE PROCEDURE uspAddVehicle (
	IN p_strVIN				VARCHAR(250),
    IN p_strMake 			VARCHAR(250),
    IN p_intYear 			INT,
    IN p_strModel 			VARCHAR(250),
    IN p_strColor 			VARCHAR(250),
    IN p_strLicensePlate 	VARCHAR(250),
    IN p_intUserID 			INT,
    IN p_strComments 		TEXT,
    OUT p_intVehicleID		INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TVehicles
	INSERT INTO TVehicles (strVIN, strMake, intYear, strModel, strColor, strLicensePlate, intUserID, strComments)
	VALUES (p_strVIN, p_strMake, p_intYear, p_strModel, p_strColor, p_strLicensePlate, p_intUserID, p_strComments);
    
    -- Get latest PK
    SELECT intVehicleID INTO p_intVehicleID FROM TVehicles ORDER BY intVehicleID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update a vehicle
DELIMITER //
CREATE PROCEDURE uspUpdateVehicle (
	IN p_intVehicleID		INT,
	IN p_strVIN				VARCHAR(250),
    IN p_strMake 			VARCHAR(250),
    IN p_intYear 			INT,
    IN p_strModel 			VARCHAR(250),
    IN p_strColor 			VARCHAR(250),
    IN p_strLicensePlate 	VARCHAR(250),
    IN p_intUserID 			INT,
    IN p_strComments 		TEXT,
    IN p_strModifiedReason	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TVehicles
	SET
		strVIN = p_strVin
	   ,strMake = p_strMake
	   ,intYear = p_intYear
	   ,strModel = p_strModel
	   ,strColor = p_strColor
	   ,strLicensePlate = p_strLicensePlate
	   ,intUserID = p_intUserID
	   ,strComments = p_strComments
	   ,strModified_Reason = p_strModifiedReason
	WHERE
		intVehicleID = p_intVehicleID;
COMMIT;
END //
DELIMITER ;

-- Add a job
DELIMITER //
CREATE PROCEDURE uspAddJob (
	IN p_intUserID 			INT,
    IN p_intVehicleID 		INT,
    IN p_event_id			INT,
    IN p_intJobStatusID 	INT,
    IN p_intServiceID 		INT,
    OUT p_intJobID			INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TJobs
	INSERT INTO TJobs(intUserID, intVehicleID, event_id, intJobStatusID, intServiceID)
	VALUES (p_intUserID, p_intVehicleID, p_event_id, p_intJobStatusID, p_intServiceID);
    
    -- Get the latest PK
    SELECT intJobID INTO p_intJobID FROM TJobs ORDER BY intJobID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update a job
DELIMITER //
CREATE PROCEDURE uspUpdateJob (
	IN p_intJobID			INT,
	IN p_intUserID 			INT,
    IN p_intVehicleID 		INT,
    IN p_event_id			INT,
    IN p_intJobStatusID 	INT,
    IN p_intServiceID 		INT,
    IN p_strModifiedReason	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Update TJobs
	UPDATE TJobs
	SET
		intUserID = p_intUserID
	   ,intVehicleID = p_intVehicleID
	   ,event_id = p_event_id
	   ,intJobStatusID = p_intJobStatusID
	   ,intServiceID = p_intServiceID
	   ,strModified_Reason = p_strModifiedReason
	WHERE
		intJobID = p_intJobID;
COMMIT;
END //
DELIMITER ;

-- Add a review
DELIMITER //
CREATE PROCEDURE uspAddReview (
	IN p_strReview 			TEXT,
    IN p_dtmDate 			DATETIME,
    IN p_intReviewTypeID 	INT,
    IN p_intUserID 			INT,
    IN p_intRating 			INT,
    OUT p_intReviewID		INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TReviews
	INSERT INTO TReviews (strReview, dtmDate, intReviewTypeID, intUserID, intRating)
	VALUES (p_strReview, p_dtmDate, p_intReviewTypeID, p_intUserID, p_intRating);
    
    -- Get latest PK
    SELECT intReviewID INTO p_intReviewID FROM TReviews ORDER BY intReviewID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Add a message
DELIMITER //
CREATE PROCEDURE uspAddMessage (
	IN p_strMessage 		TEXT,
    IN p_intMessageStatusID INT,
    IN p_intUserID 			INT,
    OUT p_intMessageID		INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TMessages
	INSERT INTO TMessages (strMessage, intMessageStatusID, intUserID)
	VALUES (p_strMessage, p_intMessageStatusID, p_intUserID);
    
    -- Get latest PK
    SELECT intMessageID INTO p_intMessageID FROM TMessages ORDER BY intMessageID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Add an event
DELIMITER //
CREATE PROCEDURE uspAddEvent (
	IN p_event_start DATETIME,
    IN p_event_end DATETIME,
    IN p_event_text TEXT,
    IN p_event_color VARCHAR(7),
    OUT p_event_id INT
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert into TEvents
	INSERT INTO TEvents (event_start, event_end, event_text, event_color)
	VALUES (p_event_start, p_event_end, p_event_text, p_event_color);
    
    -- Get latest PK
    SELECT event_id INTO p_event_id FROM TEvents ORDER BY event_id DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update an event
DELIMITER //
CREATE PROCEDURE uspUpdateEvent (
	IN p_event_id			INT,
	IN p_event_start 		DATETIME,
    IN p_event_end			DATETIME,
    IN p_event_text			TEXT,
    IN p_event_color		VARCHAR(7),
    IN p_strModifiedReason 	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Update TEvents
	UPDATE TEvents
	SET
	    event_start = p_event_start
	   ,event_end = p_event_end
       ,event_text = p_event_text
       ,event_color = p_event_color
	   ,strModified_Reason = p_strModifiedReason
	WHERE
		event_id = p_event_id;
COMMIT;
END //
DELIMITER ;

-- Update user password
DELIMITER //
CREATE PROCEDURE uspUpdatePassword (
	IN p_strEmail			VARCHAR(250),
	IN p_strPassword 		VARCHAR(250),
    IN p_strModifiedReason	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Update TUsers
	UPDATE TUsers
	SET
		strEmail = p_strEmail,
	    strPassword = p_strPassword,
	    strModified_Reason = p_strModifiedReason
	WHERE
		strEmail = p_strEmail;
COMMIT;
END //
DELIMITER ;
   
-- Testing Triggers (Insert) - WORKS!
-- SELECT * FROM Z_TUsers;
-- INSERT INTO TUsers (strFirstName, strLastName, strAddress, strCity, intStateID, strZip, strPhoneNumber, strEmail, strPassword, intUserTypeID) VALUES ('boon', 'Adam', 'Fosser', '456 Main', 'City', 1, '45211', '555-555-5555', 'kill@gmail.com', 'kill', 1);
-- SELECT * FROM Z_TUsers;

-- Testing Triggers (Update) - WORKS! (Had to remove the UPDATE strModifiedReason statement)
-- SELECT * FROM Z_TUsers;
-- UPDATE TUsers SET strFirstName = 'MARY', strLastName = 'WATTSON' WHERE intUserID = 1;
-- SELECT * FROM Z_TUsers;

-- SELECT * FROM Z_TMessages;
-- DELETE FROM TMessages WHERE intUserID = 1;
-- SELECT * FROM Z_TMessages;
-- SELECT * FROM TMessages;

-- Sproc testing
-- CALL uspAddEvent('2022-01-01', '2022-01-02', 'text', 'color', @intEventID);
-- CALL uspAddJob(1, 1, 1, 1, 1, @intJobID);