CREATE DATABASE Conference;
USE Conference;

CREATE TABLE CommitteeMember(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    PRIMARY KEY (id)
);

CREATE TABLE Student(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    PRIMARY KEY (id)
);

CREATE TABLE Professional(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    PRIMARY KEY (id)
);

CREATE TABLE Sponsor(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    email varchar(50),
    emailsSent int,
    companyName varchar(30),
    PRIMARY KEY (id),
    FOREIGN KEY (companyName) REFERENCES SponsorCompany(companyName)
);

CREATE TABLE SponsorCompany(
    companyName varchar(30) NOT NULL,
    jobAddress varchar(50) NOT NULL,
    ranking ENUM ('Platinum','Gold','Silver','Bronze'),
    PRIMARY KEY (companyName)
);

CREATE TABLE JobPostings(
    jobTitle varchar(30) NOT NULL,
    jobCity varchar(30) NOT NULL,
    jobProvince varchar(30) NOT NULL,
    payRate double,
    companyName varchar(30) NOT NULL,
    PRIMARY KEY (jobTitle, jobCity, jobProvince, companyName),
    FOREIGN KEY (companyName) REFERENCES SponsorCompany(companyName)
);

CREATE TABLE Subcommittee(
    subcommiteeName varchar(30),
    PRIMARY KEY (name)
);

CREATE TABLE isMember(
    memberId char(6) NOT NULL,
    subcommiteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommiteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id),
    FOREIGN KEY (subcommiteeName) REFERENCES Subcommittee(subcommiteeName)
);
