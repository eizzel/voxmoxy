<?php

class m140123_121958_initialize_schema extends CDbMigration
{
	public function up()
	{
		$sql = "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


			-- -----------------------------------------------------
			-- Table `Category`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `Category` (
			  `categoryId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `categoryName` VARCHAR(100) NULL DEFAULT NULL,
			  PRIMARY KEY (`categoryId`))
			ENGINE = MyISAM
			AUTO_INCREMENT = 10;


			-- -----------------------------------------------------
			-- Table `CategoryRelation`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `CategoryRelation` (
			  `categoryRelationId` INT(11) NOT NULL AUTO_INCREMENT,
			  `parentCategoryId` INT(11) NOT NULL,
			  `childCategoryId` INT(11) NOT NULL,
			  `depth` INT(11) NULL DEFAULT NULL,
			  PRIMARY KEY (`categoryRelationId`),
			  INDEX `fk_CategoryRelation_Category_idx` (`parentCategoryId` ASC),
			  INDEX `fk_CategoryRelation_Category1_idx` (`childCategoryId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 23;


			-- -----------------------------------------------------
			-- Table `MemberStatus`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `MemberStatus` (
			  `memberStatusId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `memberStatusName` VARCHAR(45) NULL DEFAULT NULL,
			  `memberStatusDescription` TEXT NULL DEFAULT NULL,
			  PRIMARY KEY (`memberStatusId`))
			ENGINE = MyISAM
			AUTO_INCREMENT = 9
			DEFAULT CHARACTER SET = latin1;


			-- -----------------------------------------------------
			-- Table `Member`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `Member` (
			  `memberId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `memberUserName` VARCHAR(100) NULL DEFAULT NULL,
			  `memberEmail` VARCHAR(100) NULL DEFAULT NULL,
			  `memberFirstName` VARCHAR(100) NULL DEFAULT NULL,
			  `memberLastName` VARCHAR(100) NULL DEFAULT NULL,
			  `memberPassword` VARCHAR(100) NULL DEFAULT NULL,
			  `memberLastLogin` DATETIME NULL DEFAULT NULL,
			  `memberStatusId` INT(11) NOT NULL,
			  PRIMARY KEY (`memberId`),
			  INDEX `fk_Member_MemberStatus1_idx` (`memberStatusId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 2;


			-- -----------------------------------------------------
			-- Table `MemberUpload`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `MemberUpload` (
			  `memberUploadId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `memberUploadTitle` VARCHAR(256) NULL DEFAULT NULL,
			  `memberUploadFilePath` VARCHAR(256) NULL DEFAULT NULL,
			  `memberId` INT(11) NOT NULL,
			  PRIMARY KEY (`memberUploadId`),
			  INDEX `fk_MemberUpload_Member1_idx` (`memberId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 6;


			-- -----------------------------------------------------
			-- Table `MemberUploadCategory`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `MemberUploadCategory` (
			  `memberUploadCategoryId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `categoryId` INT(11) NOT NULL,
			  `memberUploadId` INT(11) NOT NULL,
			  PRIMARY KEY (`memberUploadCategoryId`),
			  INDEX `fk_MemberUploadCategory_Category1_idx1` (`categoryId` ASC),
			  INDEX `fk_MemberUploadCategory_MemberUpload1_idx1` (`memberUploadId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 9;


			-- -----------------------------------------------------
			-- Table `tbl_migration`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `tbl_migration` (
			  `version` VARCHAR(255) NOT NULL,
			  `apply_time` INT(11) NULL DEFAULT NULL,
			  PRIMARY KEY (`version`))
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = latin1;


			-- -----------------------------------------------------
			-- Table `MemberConfirmation`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `MemberConfirmation` (
			  `memberConfirmationId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `memberConfirmationCode` VARCHAR(255) NOT NULL,
			  `memberConfirmationConfirmed` TINYINT(4) NULL DEFAULT NULL,
			  `memberId` INT(11) NOT NULL,
			  PRIMARY KEY (`memberConfirmationId`),
			  INDEX `fk_MemberConfirmation_Member1_idx` (`memberId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 69;


			-- -----------------------------------------------------
			-- Table `MemberSession`
			-- -----------------------------------------------------
			CREATE TABLE IF NOT EXISTS `MemberSession` (
			  `memberSessionId` INT(11) NOT NULL AUTO_INCREMENT,
			  `dateCreated` DATETIME NULL DEFAULT NULL,
			  `dateLastModified` DATETIME NULL DEFAULT NULL,
			  `memberSessionIdentifier` VARCHAR(100) NULL DEFAULT NULL,
			  `memberSessionPartialLogin` TINYINT(4) NULL DEFAULT NULL,
			  `memberId` INT(11) NOT NULL,
			  PRIMARY KEY (`memberSessionId`),
			  INDEX `fk_MemberSession_Member1_idx1` (`memberId` ASC))
			ENGINE = MyISAM
			AUTO_INCREMENT = 108;


			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;";
		$this->execute($sql);
	}

	public function down()
	{
		//echo "m140123_121958_initialize_schema does not support migration down.\n";
		//return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}