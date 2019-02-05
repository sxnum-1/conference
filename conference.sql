CREATE DATABASE Conference;
USE Conference;

CREATE TABLE Subcommittee(
    subcommitteeName varchar(30) NOT NULL,
    PRIMARY KEY (subcommitteeName)
);

CREATE TABLE CommitteeMember(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    PRIMARY KEY (id)
);

CREATE TABLE SponsorCompany(
    companyName varchar(30) NOT NULL,
    jobAddress varchar(50) NOT NULL,
    ranking ENUM ('Platinum','Gold','Silver','Bronze'),
    PRIMARY KEY (companyName)
);

CREATE TABLE HotelRoom(
    roomNumber char(3) NOT NULL,
    numberOfBeds int,
    PRIMARY KEY (roomNumber)
);

CREATE TABLE Professional(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    PRIMARY KEY (id)
);

CREATE TABLE Student(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    roomNumber char(3),
    PRIMARY KEY (id),
    FOREIGN KEY (roomNumber) REFERENCES HotelRoom (roomNumber) ON DELETE SET NULL
);

CREATE TABLE Sponsor(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    emailsSent int,
    companyName varchar(30),
    PRIMARY KEY (id),
    FOREIGN KEY (companyName) REFERENCES SponsorCompany(companyName) ON DELETE CASCADE
);

CREATE TABLE JobPostings(
    jobTitle varchar(30) NOT NULL,
    jobCity varchar(30) NOT NULL,
    jobProvince varchar(30) NOT NULL,
    payRate decimal(8,2),
    companyName varchar(30) NOT NULL,
    PRIMARY KEY (jobTitle, jobCity, jobProvince, companyName),
    FOREIGN KEY (companyName) REFERENCES SponsorCompany(companyName) ON DELETE CASCADE
);

CREATE TABLE isMember(
    memberId char(6) NOT NULL,
    subcommitteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommitteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), -- no cascading delete because of isChair property
    FOREIGN KEY (subcommitteeName) REFERENCES Subcommittee(subcommitteeName)
);
