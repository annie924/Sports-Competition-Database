CREATE TABLE Sports(
S_name VARCHAR(50) PRIMARY KEY, 
e# INTEGER NOT NULL);

CREATE TABLE AquaticSports(
S_name VARCHAR(50), categories VARCHAR(50),
PRIMARY KEY(S_name, categories),
FOREIGN KEY (S_name)
REFERENCES Sports(S_name) ON DELETE CASCADE);

CREATE TABLE BallGames(
S_name VARCHAR(50), types VARCHAR(50),
PRIMARY KEY(S_name, types),
FOREIGN KEY (S_name)
REFERENCES Sports(S_name) ON DELETE CASCADE);

CREATE TABLE SnowSports(
S_name VARCHAR(50), types VARCHAR(50),
PRIMARY KEY (S_name, types),
FOREIGN KEY (S_name) REFERENCES Sports(S_name) ON DELETE CASCADE);

CREATE TABLE Platform(
URL VARCHAR(50) PRIMARY KEY,
name VARCHAR(50) NOT NULL );

CREATE TABLE Competition( 
CP_year INTEGER,
CP_name VARCHAR(50),
location VARCHAR(50) NOT NULL, 
PRIMARY KEY (CP_year, CP_name));

CREATE TABLE Sponsor1(
Type VARCHAR(50) PRIMARY KEY, 
sf INTEGER NOT NULL
);

CREATE TABLE Sponsor2(
sponsorName VARCHAR(50) PRIMARY KEY,
type VARCHAR(50), 
FOREIGN KEY (type)
REFERENCES Sponsor1(type) ON DELETE CASCADE);

CREATE TABLE Team(
tid INTEGER PRIMARY KEY, country VARCHAR(50) NOT NULL
);

CREATE TABLE Has(
CP_name VARCHAR(50),
CP_year INTEGER,
S_name VARCHAR(50) NOT NULL,
PRIMARY KEY (CP_name, CP_year, S_name),
FOREIGN KEY (CP_name,CP_year) REFERENCES Competition(CP_name,CP_year) ON DELETE CASCADE,
FOREIGN KEY (S_name) REFERENCES Sports(S_name) ON DELETE CASCADE);

CREATE TABLE Tickets_sells2( 
ticketName VARCHAR(50),
price INTEGER,
t# INTEGER PRIMARY KEY,
CP_year INTEGER,
CP_name VARCHAR(50),
FOREIGN KEY (CP_year, CP_name) REFERENCES Competition (CP_year, CP_name) ON DELETE CASCADE);

CREATE TABLE SoldOn(
t# INTEGER,
URL VARCHAR(50), 
PRIMARY KEY (t#, URL), 
FOREIGN KEY (t#) REFERENCES Tickets_Sells2 ON DELETE SET NULL,
FOREIGN KEY (URL) REFERENCES Platform ON DELETE SET NULL);

CREATE TABLE Holds(
sponsorName VARCHAR(50),
CP_Name VARCHAR(50),
CP_year INTEGER,
PRIMARY KEY (sponsorName, CP_name, CP_year),
FOREIGN KEY (sponsorName) REFERENCES Sponsor2 (sponsorName) ON DELETE CASCADE,
FOREIGN KEY (CP_name,CP_year) REFERENCES Competition (CP_name,CP_year) ON DELETE CASCADE);

CREATE TABLE Athletes_belongsTo( 
name VARCHAR(50),
age INTEGER,
aid INTEGER PRIMARY KEY, 
tid INTEGER NOT NULL, 
FOREIGN KEY (tid) REFERENCES Team(tid) ON DELETE CASCADE);

CREATE TABLE Plays( 
aid INTEGER,
S_Name VARCHAR(50), 
PRIMARY KEY(aid, S_Name), 
FOREIGN KEY(aid) REFERENCES Athletes_BelongsTo (aid) ON DELETE CASCADE,
FOREIGN KEY(S_Name) REFERENCES Sports (S_name) ON DELETE CASCADE);

CREATE TABLE Coach_Teaches( 
C_name VARCHAR(50),
tid INTEGER,
age INTEGER,
country VARCHAR(50), 
PRIMARY KEY (C_name, tid), 
FOREIGN KEY (tid) REFERENCES Team (tid) ON DELETE CASCADE);

CREATE TABLE Accomplishment_gets( 
aid INTEGER NOT NULL,
accompName VARCHAR(50),
type VARCHAR(50),
PRIMARY KEY (accompName,type), 
FOREIGN KEY (aid) REFERENCES Athletes_BelongsTo(aid) ON DELETE CASCADE);

insert into Platform(URL, Name) values('https://www.paris2024.org/en/tickets/', 'Paris 2024');
insert into Platform(URL, Name) values('https://www.ticketsonsale.com/events/sport', 'TicketsOnSale');
insert into Platform(URL, Name) values('https://www.ticketsales.com/sports-tickets', 'TicketSales');
insert into Platform(URL, Name) values('https://www.ticketmaster.ca/', 'TicketMaster');
insert into Platform(URL, Name) values('https://www.ticombo.com/en', 'Ticombo');

INSERT INTO Competition(CP_year, CP_name, location) VALUES (2024, 'Summer Olympic', 'Paris');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2024, 'Winter Olympic', 'Paris');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2016, 'Summer Olympic', 'Brazil');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2023, 'World Cup Rugby', 'Stade de France');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2020, 'Summer Olympic', 'Tokyo');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2024, 'World Table Tennis Championships', 'South Korea');
INSERT INTO Competition(CP_year, CP_name, location) VALUES (2022, 'World Aquatics Championships', 'Hungary');

INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('2024 Olympic', 1, 2024, 'Summer Olympic',150);
INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('World Cup Rugby', 2, 2023, 'World Cup Rugby',198);
INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('2020 Olympic', 3, 2020, 'Summer Olympic',170);
INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('2024 Olympic', 4, 2024, 'Winter Olympic',150);
INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('2024 WTT', 5, 2024, 'World Table Tennis Championships',150);
INSERT INTO Tickets_sells2(ticketName, t#, CP_year, CP_name, Price) VALUES ('2023 Olympic', 6, 2016, 'Summer Olympic',160);

INSERT INTO SoldOn(t#, URL) VALUES (3, 'https://www.paris2024.org/en/tickets/');
INSERT INTO SoldOn(t#, URL) VALUES (2, 'https://www.ticombo.com/en');
INSERT INTO SoldOn(t#, URL) VALUES (1, 'https://www.ticketmaster.ca/');
INSERT INTO SoldOn(t#, URL) VALUES (4, 'https://www.ticketsonsale.com/events/sport');
INSERT INTO SoldOn(t#, URL) VALUES (5, 'https://www.ticketsales.com/sports-tickets');

INSERT INTO Sports(S_name, e#) VALUES ('shooting', 15);
INSERT INTO Sports(S_name, e#) VALUES ('Rugby', 1);
INSERT INTO Sports(S_name, e#) VALUES ('50m Freestyle', 2);
INSERT INTO Sports(S_name, e#) VALUES ('100m Butterfly', 2);
INSERT INTO Sports(S_name, e#) VALUES ('400m Individual Medley', 2);
INSERT INTO Sports(S_name, e#) VALUES ('Badminton', 5);
INSERT INTO Sports(S_name, e#) VALUES ('Ski Jumping', 4);
INSERT INTO Sports(S_name, e#) VALUES ('Freestyle Skiing', 13);
INSERT INTO Sports(S_name, e#) VALUES ('Table Tennis', 5);
INSERT INTO Sports(S_name, e#) VALUES ('Ice Hockey', 2);

INSERT INTO BallGames(S_name, types) VALUES ('Badminton', 'Double Womens');
INSERT INTO BallGames(S_name, types) VALUES ('Badminton', 'Single Mens');
INSERT INTO BallGames(S_name, types) VALUES ('Badminton', 'Single Mixed');
INSERT INTO BallGames(S_name, types) VALUES ('Badminton', 'Single Womens');
INSERT INTO BallGames(S_name, types) VALUES ('Table Tennis', 'Team Womens');

INSERT INTO SnowSports(S_name, types) VALUES ('Freestyle Skiing', 'Mens');
INSERT INTO SnowSports(S_name, types) VALUES ('Freestyle Skiing', 'Womens');
INSERT INTO SnowSports(S_name, types) VALUES ('Ice Hockey', 'Team Mens');
INSERT INTO SnowSports(S_name, types) VALUES ('Ski Jumping', 'Womens');
INSERT INTO SnowSports(S_name, types) VALUES ('Ski Jumping', 'Mens');

INSERT INTO AquaticSports(S_name, categories) VALUES ('100m Butterfly','Womens');
INSERT INTO AquaticSports(S_name, categories) VALUES ('400m Individual Medley','Mens');
INSERT INTO AquaticSports(S_name, categories) VALUES ('400m Individual Medley','Womens');
INSERT INTO AquaticSports(S_name, categories) VALUES ('50m Freestyle','Mens');
INSERT INTO AquaticSports(S_name, categories) VALUES ('50m Freestyle','Womens');

INSERT INTO Team(tid, country) VALUES (1, 'China');
INSERT INTO Team(tid, country) VALUES (2, 'Japan');
INSERT INTO Team(tid, country) VALUES (3, 'USA');
INSERT INTO Team(tid, country) VALUES (4, 'Denmark');
INSERT INTO Team(tid, country) VALUES (5, 'South Korea');

INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Katie Ledecky', 26, 2, 3);
INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Mima Ito', 23, 3, 2);
INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Viktor Axelsen', 29, 4, 4);
INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Qian Yang', 23, 1, 1);
INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Long Ma', 23, 5, 1);
INSERT INTO Athletes_BelongsTo(name, age, aid, tid) VALUES ('Jike Zhang', 35, 6, 1);

INSERT INTO Coach_Teaches(C_name, tid, age, country) VALUES ('Ping Lang', 1, 62, 'China');
INSERT INTO Coach_Teaches(C_name, tid, age, country) VALUES ('Philippe Blain', 2, 63, 'France');
INSERT INTO Coach_Teaches(C_name, tid, age, country) VALUES ('Thomas Stavngaard', 4, 49, 'Denmark');
INSERT INTO Coach_Teaches(C_name, tid, age, country) VALUES ('Kim Hak-bum', 5, 63, 'South Korea');
INSERT INTO Coach_Teaches(C_name, tid, age, country) VALUES ('Rose Monday', 3, 60, 'America');

INSERT INTO Plays(aid, S_Name) VALUES (1, 'shooting');
INSERT INTO Plays(aid, S_Name) VALUES (2, '50m Freestyle');
INSERT INTO Plays(aid, S_Name) VALUES (3, 'Table Tennis');
INSERT INTO Plays(aid, S_Name) VALUES (4, 'Badminton');
INSERT INTO Plays(aid, S_Name) VALUES (5, 'Table Tennis');

INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (4, '2020 Olympic Badminton Mens Singles', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (4, '2016 Olympic Badminton Mens Singles', 'Bronze');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (1, '2020 10m Air Rifle Womens', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (2, '2020 Olympic Womens 1500m Freestyle', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (3, '2016 Olympic Table Tennis Team', 'Bronze');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (5, '2012 Olympic Table Tennis Team', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (5, '2016 Olympic Table Tennis Singles', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (5, '2016 Olympic Table Tennis Team one', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (6, '2012 Olympic Table Tennis Singles', 'Gold');
INSERT INTO Accomplishment_gets(aid, accompName, type) VALUES (6, '2016 Olympic Table Tennis Team two', 'Gold');

INSERT INTO Sponsor1(type, sf) VALUES ('The Olympic Partner', 500000000);
INSERT INTO Sponsor1(type, sf) VALUES ('IOC Top-Programme', 200000000);
INSERT INTO Sponsor1(type, sf) VALUES ('Gold Partners', 166000000);
INSERT INTO Sponsor1(type, sf) VALUES ('Official Partners', 300000000);
INSERT INTO Sponsor1(type, sf) VALUES ('Official Supporters', 120000000);

INSERT INTO Sponsor2(SponsorName, type) VALUES ('Airbnb','IOC Top-Programme');
INSERT INTO Sponsor2(SponsorName, type) VALUES ('Panasonic','IOC Top-Programme');
INSERT INTO Sponsor2(SponsorName, type) VALUES ('LVMH','Gold Partners');
INSERT INTO Sponsor2(SponsorName, type) VALUES ('Fairmont Singapore','Gold Partners');
INSERT INTO Sponsor2(SponsorName, type) VALUES ('Cisco','Official Partners');

INSERT INTO Holds(SponsorName, CP_year, CP_name) VALUES ('Airbnb',2020,'Summer Olympic');
INSERT INTO Holds(SponsorName, CP_year, CP_name) VALUES ('Cisco',2020,'Summer Olympic');
INSERT INTO Holds(SponsorName, CP_year, CP_name) VALUES ('Fairmont Singapore',2024,'World Table Tennis Championships');
INSERT INTO Holds(SponsorName, CP_year, CP_name) VALUES ('LVMH',2024,'Summer Olympic');
INSERT INTO Holds(SponsorName, CP_year, CP_name) VALUES ('Panasonic',2020,'Summer Olympic');

INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('Summer Olympic',2020,'100m Butterfly');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('Summer Olympic',2024,'50m Freestyle');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('World Aquatics Championships',2022,'50m Freestyle');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('World Cup Rugby',2023,'Rugby');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('World Table Tennis Championships',2024,'Table Tennis');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('Summer Olympic',2020,'400m Individual Medley');
INSERT INTO Has(CP_name, CP_year, S_name) VALUES ('Summer Olympic',2020,'50m Freestyle');














