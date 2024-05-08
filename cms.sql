CREATE TABLE tblstudents (
    studID INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50),
    middlename VARCHAR(50),
    lastname VARCHAR(50),
    photo VARCHAR(1000)
);

CREATE TABLE tblaccounts (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    studID INT,
    username VARCHAR(50),
    password VARCHAR(50),
    FOREIGN KEY (studID) REFERENCES tblstudents(studID)
);