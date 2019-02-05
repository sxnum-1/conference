CREATE DATABASE Conference;
USE Conference;

CREATE TABLE CommitteeMember(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    PRIMARY KEY (id)
);

CREATE TABLE HotelRoom(
    roomNumber char(3) NOT NULL,
    numberOfBeds int,
    PRIMARY KEY (roomNumber)
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
    PRIMARY KEY (id)
);

CREATE TABLE Subcommittee(
    name varchar(30),
    PRIMARY KEY (name)
);

CREATE TABLE isMember(
    memberId char(6) NOT NULL,
    subcommiteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommiteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), -- no cascading delete because of isChair property
    FOREIGN KEY (subcommiteeName) REFERENCES Subcommittee(subcommiteeName)
);