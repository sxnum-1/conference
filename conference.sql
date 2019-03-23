-- We'll assume that a database named 'Conference' doesn't already exist
CREATE DATABASE Conference;
USE Conference;

CREATE TABLE Subcommittee(
    subcommitteeName varchar(30) NOT NULL,
    PRIMARY KEY (subcommitteeName)
);

CREATE TABLE CommitteeMember(
    id char(6) NOT NULL,
    firstName varchar(20) NOT NULL,
    lastName varchar(30) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE SponsorCompany(
    companyName varchar(30) NOT NULL,
    companyLocation varchar(50) NOT NULL,
    ranking enum('Platinum','Gold','Silver','Bronze') NOT NULL,
    PRIMARY KEY (companyName)
);

CREATE TABLE HotelRoom(
    roomNumber char(3) NOT NULL,
    numberOfBeds int,
    PRIMARY KEY (roomNumber)
);

-- Models 'Session' from the ER
CREATE TABLE SessionEvent(
    sessionName varchar(50) NOT NULL,
    startTime datetime NOT NULL,
    endTime datetime NOT NULL,
    room char(3) NOT NULL,
    PRIMARY KEY (sessionName)
);

CREATE TABLE Professional(
    id int NOT NULL AUTO_INCREMENT,
    firstName varchar(20) NOT NULL,
    lastName varchar(30) NOT NULL,
    email varchar(50),
    PRIMARY KEY (id)
);

CREATE TABLE Student(
    id int NOT NULL AUTO_INCREMENT,
    firstName varchar(20) NOT NULL,
    lastName varchar(30) NOT NULL,
    email varchar(50),
    roomNumber char(3),
    PRIMARY KEY (id),
    FOREIGN KEY (roomNumber) REFERENCES HotelRoom (roomNumber) ON DELETE SET NULL
);

CREATE TABLE Sponsor(
    id int NOT NULL AUTO_INCREMENT,
    firstName varchar(20) NOT NULL,
    lastName varchar(30) NOT NULL,
    email varchar(50),
    emailsSent int NOT NULL,
    companyName varchar(30) NOT NULL,
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

-- 'Member Of' relation between Subcommittee and CommitteeMember
CREATE TABLE IsMember(
    memberId char(6) NOT NULL,
    subcommitteeName varchar(30) NOT NULL,
    isChair boolean,
    PRIMARY KEY (memberId, subcommitteeName),
    FOREIGN KEY (memberId) REFERENCES CommitteeMember(id), -- no cascading delete because of isChair property
    FOREIGN KEY (subcommitteeName) REFERENCES Subcommittee(subcommitteeName)
);

-- 'Speaker At' relation between Student and Session
CREATE TABLE StudentSpeaksFor(
    studentId int NOT NULL,
    sessionName varchar(30) NOT NULL,
    PRIMARY KEY (studentId, sessionName),
    FOREIGN KEY (studentId) REFERENCES Student(id),
    FOREIGN KEY (sessionName) REFERENCES SessionEvent(sessionName) ON DELETE CASCADE
);

-- 'Speaker At' relation between Professional and Session
CREATE TABLE ProfessionalSpeaksFor(
    professionalId int NOT NULL,
    sessionName varchar(30) NOT NULL,
    PRIMARY KEY (professionalId, sessionName),
    FOREIGN KEY (professionalId) REFERENCES Professional(id),
    FOREIGN KEY (sessionName) REFERENCES SessionEvent(sessionName) ON DELETE CASCADE
);

-- 'Speaker At' relation between Sponsor and Session
CREATE TABLE SponsorSpeaksFor(
    sponsorId int NOT NULL,
    sessionName varchar(30) NOT NULL,
    PRIMARY KEY (sponsorId, sessionName),
    FOREIGN KEY (sponsorId) REFERENCES Sponsor(id),
    FOREIGN KEY (sessionName) REFERENCES SessionEvent(sessionName) ON DELETE CASCADE
);

-- In the small case that table creation and data population needs to be separated,
-- deletion of tuples in existing tables should be useful
delete from SponsorSpeaksFor;
delete from ProfessionalSpeaksFor;
delete from StudentSpeaksFor;
delete from IsMember;
delete from JobPostings;
delete from Sponsor;
delete from Student;
delete from Professional;
delete from SessionEvent;
delete from HotelRoom;
delete from SponsorCompany;
delete from CommitteeMember;
delete from Subcommittee;

-- Populating the tables with some data
insert into Subcommittee values ('Registration Committee');
insert into Subcommittee values ('Program Committee');
insert into Subcommittee values ('Sponsor Committee');
insert into Subcommittee values ('Sleeping Committee');
insert into CommitteeMember values ('000000','Riki', 'Suzuki');
insert into CommitteeMember values ('000001', 'Cat', 'Woman');
insert into CommitteeMember values ('000002', 'Joe', 'Bombosa');
insert into CommitteeMember values ('000003','Moe', 'Rombosa');
insert into CommitteeMember values ('000004','Toe', 'Mombosa');
insert into SponsorCompany values ('lemonsRus','123MainSt', 'Platinum');
insert into SponsorCompany values ('lemonswereus','124MainSt', 'Platinum');
insert into SponsorCompany values ('lemonsnowus','125MainSt', 'Platinum');
insert into HotelRoom values ('001',2);
insert into HotelRoom values ('002',1);
insert into HotelRoom values ('003',2);
insert into HotelRoom values ('004',1);
insert into HotelRoom values ('005',2);
insert into HotelRoom values ('006',1);
insert into HotelRoom values ('007',2);
insert into HotelRoom values ('008',1);
insert into SessionEvent values ('learnToEat', '2019-02-09 09:30:01','2019-02-09 10:30:01','000');
insert into SessionEvent values ('learnToFat', '2019-02-09 09:30:01','2019-02-09 10:30:01','001');
insert into SessionEvent values ('learnedToEat', '2019-02-09 08:30:01','2019-02-09 09:30:01','001');
insert into SessionEvent values ('learnedToPlay', '2019-02-10 08:30:01','2019-02-10 09:30:01','300');
insert into SessionEvent values ('learnedToFly', '2019-02-10 10:30:01','2019-02-10 11:30:01','001');
insert into Professional(firstName, lastName, email) values ('John', 'Doe', 'johndoe@gmail.com');
insert into Professional(firstName, lastName, email) values ('Jane', 'Smith', 'janesmith@hotmail.com');
insert into Professional(firstName, lastName, email) values ('Abbey', 'Road', NULL);
insert into Professional(firstName, lastName, email) values ('Bob', 'Dylan', NULL);
insert into Student(firstName, lastName, email, roomNumber) values ('Riki', 'Suzuki', 'rs@queensu.ca','001');
insert into Student(firstName, lastName, email, roomNumber) values ('Cat', 'Woman', 'catWom@queensu.ca','001');
insert into Student(firstName, lastName, email, roomNumber) values ('Joe', 'Bombosa', 'jbombosa@queensu.ca','002');
insert into Student(firstName, lastName, email, roomNumber) values ('Moe', 'Rombosa', 'mRombosa@queensu.ca','002');
insert into Sponsor(firstName, lastName, email, emailsSent, companyName) values ('Toad', 'Stool', NULL, 0, 'lemonsRus');
insert into Sponsor(firstName, lastName, email, emailsSent, companyName) values ('Tony', 'Montana', 'mountain@gmail.com', 0, 'lemonswereus');
insert into Sponsor(firstName, lastName, email, emailsSent, companyName) values ('Dog', 'Goodboy', NULL, 0, 'lemonsnowus');
insert into Sponsor(firstName, lastName, email, emailsSent, companyName) values ('Bonjour', 'Chat', NULL, 0, 'lemonsnowus');
insert into JobPostings values ('Cat Flipper','narnia','nevereverland',3.14,'lemonsRus');
insert into JobPostings values ('Dog Watcher','narnia','nevereverland',3.14,'lemonsRus');
insert into JobPostings values ('Dog Flipper','narnia','nevereverland',3.14,'lemonsRus');
insert into JobPostings values ('Cow Tipper','narnia','nevereverland',3.14,'lemonswereus');
insert into JobPostings values ('Wizard','narnia','nevereverland',3.14,'lemonswereus');
insert into JobPostings values ('Lizard','narnia','nevereverland',3.14,'lemonsnowus');
insert into IsMember values ('000003','Program Committee', TRUE);
insert into IsMember values ('000002','Sponsor Committee', TRUE);
insert into IsMember values ('000001','Registration Committee', TRUE);
insert into IsMember values ('000004','Sleeping Committee', TRUE);
insert into StudentSpeaksFor values (1,'learnToEat');
insert into StudentSpeaksFor values (2,'learnToFat');
insert into StudentSpeaksFor values (3,'learnedToEat');
insert into ProfessionalSpeaksFor values (1,'learnToEat');
insert into ProfessionalSpeaksFor values (2,'learnToFat');
insert into ProfessionalSpeaksFor values (2,'learnedToPlay');
insert into SponsorSpeaksFor values (1,'learnedToPlay');
insert into SponsorSpeaksFor values (3,'learnedToFly');
insert into SponsorSpeaksFor values (4,'learnToEat');

