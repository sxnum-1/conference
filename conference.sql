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

CREATE TABLE SessionEvent(
    sessionName varchar(50),
    startTime datetime NOT NULL,
    endTime datetime NOT NULL,
    room char(3) NOT NULL,
    PRIMARY KEY (startTime, room)
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

CREATE TABLE IsMember(
    memberId char(6) NOT NULL,
    subcommitteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommitteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), -- no cascading delete because of isChair property
    FOREIGN KEY (subcommitteeName) REFERENCES Subcommittee(subcommitteeName)
);

CREATE TABLE StudentSpeaksFor(
    studentId char(6) NOT NULL,
    sessionStartTime datetime NOT NULL,
    sessionRoom char(3) NOT NULL,
    PRIMARY KEY (studentId, sessionStartTime, sessionRoom),
    FOREIGN KEY (studentId) REFERENCES Student(id),
    FOREIGN KEY (sessionStartTime, sessionRoom) REFERENCES SessionEvent(startTime, room) ON DELETE CASCADE
);

CREATE TABLE ProfessionalSpeaksFor(
    professionalId char(6) NOT NULL,
    sessionStartTime datetime NOT NULL,
    sessionRoom char(3) NOT NULL,
    PRIMARY KEY (professionalId, sessionStartTime, sessionRoom),
    FOREIGN KEY (professionalId) REFERENCES Professional(id),
    FOREIGN KEY (sessionStartTime, sessionRoom) REFERENCES SessionEvent(startTime, room) ON DELETE CASCADE
);

CREATE TABLE SponsorSpeaksFor(
    sponsorId char(6) NOT NULL,
    sessionStartTime datetime NOT NULL,
    sessionRoom char(3) NOT NULL,
    PRIMARY KEY (sponsorId, sessionStartTime, sessionRoom),
    FOREIGN KEY (sponsorId) REFERENCES Sponsor(id),
    FOREIGN KEY (sessionStartTime, sessionRoom) REFERENCES SessionEvent(startTime, room) ON DELETE CASCADE
);
