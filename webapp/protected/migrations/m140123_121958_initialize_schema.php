<?php

class m140123_121958_initialize_schema extends CDbMigration
{
	public function up()
	{
		$sql = "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
		SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
		SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

		-- -----------------------------------------------------
		-- Table `Member`
		-- -----------------------------------------------------
		CREATE TABLE IF NOT EXISTS `Member` (
		  `memberId` INT NOT NULL AUTO_INCREMENT,
		  `dateCreated` DATETIME NULL,
		  `dateLastModified` DATETIME NULL,
		  `memberUserName` VARCHAR(100) NULL,
		  `memberEmail` VARCHAR(100) NULL,
		  `memberFirstName` VARCHAR(100) NULL,
		  `memberLastName` VARCHAR(100) NULL,
		  `memberPassword` VARCHAR(100) NULL,
		  PRIMARY KEY (`memberId`))
		ENGINE = MyISAM;


		-- -----------------------------------------------------
		-- Table `Category`
		-- -----------------------------------------------------
		CREATE TABLE IF NOT EXISTS `Category` (
		  `categoryId` INT NOT NULL AUTO_INCREMENT,
		  `dateCreated` DATETIME NULL,
		  `dateLastModified` DATETIME NULL,
		  `categoryName` VARCHAR(100) NULL,
		  PRIMARY KEY (`categoryId`))
		ENGINE = MyISAM;


		-- -----------------------------------------------------
		-- Table `CategoryRelation`
		-- -----------------------------------------------------
		CREATE TABLE IF NOT EXISTS `CategoryRelation` (
		  `categoryRelationId` INT NOT NULL AUTO_INCREMENT,
		  `parentCategoryId` INT NOT NULL,
		  `childCategoryId` INT NOT NULL,
		  `depth` INT NULL,
		  PRIMARY KEY (`categoryRelationId`),
		  INDEX `fk_CategoryRelation_Category_idx` (`parentCategoryId` ASC),
		  INDEX `fk_CategoryRelation_Category1_idx` (`childCategoryId` ASC))
		ENGINE = MyISAM;


		-- -----------------------------------------------------
		-- Table `MemberUpload`
		-- -----------------------------------------------------
		CREATE TABLE IF NOT EXISTS `MemberUpload` (
		  `memberUploadId` INT NOT NULL AUTO_INCREMENT,
		  `dateCreated` DATETIME NULL,
		  `dateLastModified` DATETIME NULL,
		  `memberUploadTitle` VARCHAR(256) NULL,
		  `memberUploadFilePath` VARCHAR(256) NULL,
		  `memberId` INT NOT NULL,
		  PRIMARY KEY (`memberUploadId`),
		  INDEX `fk_MemberUpload_Member1_idx` (`memberId` ASC))
		ENGINE = MyISAM;


		-- -----------------------------------------------------
		-- Table `MemberUploadCategory`
		-- -----------------------------------------------------
		CREATE TABLE IF NOT EXISTS `MemberUploadCategory` (
		  `memberUploadCategoryId` INT NOT NULL AUTO_INCREMENT,
		  `dateCreated` DATETIME NULL,
		  `dateLastModified` DATETIME NULL,
		  `memberUploadId` INT NOT NULL,
		  `categoryId` INT NOT NULL,
		  PRIMARY KEY (`memberUploadCategoryId`),
		  INDEX `fk_MemberUploadCategory_MemberUpload1_idx` (`memberUploadId` ASC),
		  INDEX `fk_MemberUploadCategory_Category1_idx` (`categoryId` ASC))
		ENGINE = MYISAM;

		SET SQL_MODE=@OLD_SQL_MODE;
		SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
		SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
		";
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