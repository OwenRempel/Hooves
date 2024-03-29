CREATE TABLE `Cattle` (
    `Tag` varchar(100)  DEFAULT NULL,
    `StartDate` date DEFAULT NULL,
    `HerdsMan` varchar(100)  DEFAULT NULL,
    `Investor` varchar(100)  DEFAULT NULL,
    `FeedPrice` text DEFAULT NULL,
    `Price` varchar(100)  DEFAULT NULL,
    `AgeState` varchar(100)  DEFAULT NULL,
    `PenDate` date DEFAULT NULL,
    `Pen` varchar(100)  DEFAULT NULL,
    `GroupId` text ,
    `LastWeight` text DEFAULT NULL,
    `DateWeight` date DEFAULT NULL,
    `SecondLastWeight` text DEFAULT NULL,
    `SecondLastDate` date DEFAULT NULL,
    `FirstWeight` text DEFAULT NULL,
    `FirstDate` text DEFAULT NULL,
    `RecNo` text ,
    `RegNo` text ,
    `CellNo` text ,
    `MegNo` text ,
    `BankNo` text ,
    `Remarks` varchar(1000)  DEFAULT NULL,
    `Description` varchar(1000)  DEFAULT NULL,
    `Source` varchar(10)  NOT NULL DEFAULT 'yes',
    `MotherTag` text DEFAULT NULL,
    `Death` varchar(100)  DEFAULT NULL,
    `DeathDate` date DEFAULT NULL,
    `Loging` longtext ,
    `Locker` longtext ,
    `Adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `ID` varchar(100)  NOT NULL,
    `RID` int unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`RID`)
) ENGINE=InnoDB;

CREATE TABLE `GroupData` (
    `Pen` varchar(100) DEFAULT NULL,
    `GroupName` text NOT NULL,
    `BcData` text,
    `Data` json DEFAULT NULL,
    `Stats` json DEFAULT NULL,
    `Package` json DEFAULT NULL,
    `SlDate` date DEFAULT NULL,
    `Done` varchar(20) DEFAULT 0 NOT NULL,
    `Adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `ID` varchar(100) NOT NULL,
    `RID` int unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`RID`)
) ENGINE=InnoDB;

CREATE TABLE `Medical` (
    `CowVaccine` varchar(100)  DEFAULT NULL,
    `MedDate` date DEFAULT NULL,
    `Adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `CowID` text ,
    `ID` varchar(100) NOT NULL,
    `RID` int unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`RID`)
) ENGINE=InnoDB;

CREATE TABLE `Weight` (
    `CowWeight` varchar(100)  DEFAULT NULL,
    `WeightDate` date DEFAULT NULL,
    `Adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `CowID` text ,
    `ID` varchar(100) NOT NULL,
    `RID` int unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`RID`)
) ENGINE=InnoDB;

CREATE TABLE `Pens` (
    `Name` text not null,
    `Adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ID` int unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

Insert Into Pens (Name) Values ('Main Pen');