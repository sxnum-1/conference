CREATE DATABASE Conference;
USE Conference;

<<<<<<< HEAD
CREATE TABLE CommitteeMember(
=======
-- is there a way to enforce total participation or joint/disjoint properties?

CREATE TABLE Person(
>>>>>>> added hotel room entity and roomassigned relation
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
<<<<<<< HEAD
    PRIMARY KEY (id)
=======
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Person(id) ON DELETE CASCADE
);
-- ####################################################################
-- ############################STUDENTS################################
-- ####################################################################

CREATE TABLE Student(
    id char(6) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Attendee(id) ON DELETE CASCADE
>>>>>>> added hotel room entity and roomassigned relation
);

CREATE TABLE HotelRoom(
    rooomNumber char(3) NOT NULL,
    numberOfBeds int,
    PRIMARY KEY (roomNumber) 
);
CREATE TABLE RoomAssigned(
    id char(6) NOT NULL,
    roomNumber CHAR(3) NOT NULL,
    PRIMARY KEY (id, roomNumber),
    FOREIGN KEY (id) REFERENCES  Student(id),
    FOREIGN KEY (roomNumber) REFERENCES HotelRoom(roomNumber)
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



