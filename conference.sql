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
    PRIMARY KEY (id),
    FOREIGN KEY (companyName) REFERENCES SponsorCompany(companyName)
);

CREATE TABLE SponsorCompany(
    companyName varchar(30) NOT NULL,
    numEmailLimit int,
    ranking varchar(20),
    PRIMARY KEY (name)
);

CREATE TABLE JobPostings(
    jobTitle varchar(30) NOT NULL,
    jobAddress varchar(50) NOT NULL,
    payRate varchar(30),
    companyName varchar(30) NOT NULL,
    PRIMARY KEY (jobTitle, jobAddress, companyName)
);

CREATE TABLE Posted(
    jobTitle varchar(30) NOT NULL,
    jobAddress varchar(50) NOT NULL,
    companyName varchar(30) NOT NULL,
    PRIMARY KEY (jobTitle, jobAddress, companyName),
    FOREIGN KEY (jobTitle) REFERENCES JobPostings(jobTitle),
    FOREIGN KEY (jobAddress) REFERENCES JobPostings(jobAddress),
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
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), # no cascading delete because of isChair property
    FOREIGN KEY (subcommiteeName) REFERENCES Subcommittee(subcommiteeName)
);
