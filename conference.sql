CREATE DATABASE Conference;
USE Conference;

-- is there a way to enforce total participation or joint/disjoint properties?

CREATE TABLE Person(
    id char(6) NOT NULL,
    firstName varchar(20),
    lastName varchar(30),
    aptNum int,
    street varchar(30),
    zipCode char(6),
    city varchar(30),
    province varchar(30),
    PRIMARY KEY (id)
);

CREATE TABLE CommitteeMember(
    id char(6) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Person(id) ON DELETE CASCADE
);

CREATE TABLE Attendee(
    id char(6) NOT NULL,
    email varchar(50),
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Person(id) ON DELETE CASCADE
);
-- ####################################################################
-- ############################STUDENTS################################
-- ####################################################################

CREATE TABLE Student(
    id char(6) NOT NULL,
    roomNumber CHAR(3) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (roomNumber) REFERENCES HotelRoom (roomNumber) ON DELETE SET NULL,
    FOREIGN KEY (id) REFERENCES Attendee(id) ON DELETE CASCADE
);

CREATE TABLE HotelRoom(
    rooomNumber char(3) NOT NULL,
    numberOfBeds int,
    PRIMARY KEY (roomNumber) 
);


CREATE TABLE Professional(
    id char(6) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Attendee(id) ON DELETE CASCADE
);

CREATE TABLE Sponsor(
    id char(6) NOT NULL,
    emailsSent int,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Attendee(id) ON DELETE CASCADE
);
-- ####################################################################
-- ############################MEMBERS#################################
-- ####################################################################


CREATE TABLE Subcommittee(
    subComitteeName varchar(30),
    PRIMARY KEY (subComitteeName)
);

CREATE TABLE isMember(
    memberId char(6) NOT NULL,
    subcommiteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommiteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), -- no cascading delete because of isChair property
    FOREIGN KEY (subcommiteeName) REFERENCES Subcommittee(subComitteeName)
);



