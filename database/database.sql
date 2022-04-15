PRAGMA foreign_keys = on;

BEGIN TRANSACTION;

DROP TABLE IF EXISTS TournamentChessClub;
DROP TABLE IF EXISTS MatchChessClub;
DROP TABLE IF EXISTS LevelOfSponsorTournament;
DROP TABLE IF EXISTS LevelOfSponsorUser;
DROP TABLE IF EXISTS MemberId;
DROP TABLE IF EXISTS ChessClub;
DROP TABLE IF EXISTS UserTournament;
DROP TABLE IF EXISTS UserMatch;
DROP TABLE IF EXISTS Sponsor;
DROP TABLE IF EXISTS Match;
DROP TABLE IF EXISTS Tournament;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Website;
DROP TABLE IF EXISTS FideRanking;
DROP TABLE IF EXISTS User;


-- Table: User


CREATE TABLE User (
    id_User   INTEGER PRIMARY KEY,
    first_name  TEXT CONSTRAINT null_User_firstName NOT NULL,
    last_name   TEXT CONSTRAINT null_User_lastName NOT NULL,
    address     TEXT,
    phone_number TEXT CONSTRAINT unique_User_phoneNumber UNIQUE,
    birthday    DATE CONSTRAINT null_User_birthday NOT NULL
);

-- Table: FideRanking


CREATE TABLE FideRanking (
    id_fide     INTEGER PRIMARY KEY,
    id_User   INTEGER REFERENCES User ON DELETE SET NULL ON UPDATE CASCADE,
    category    TEXT CONSTRAINT null_FideRanking_category NOT NULL CONSTRAINT check_FideRanking_category CHECK (
        (
            category = "MEN"
            OR category = "WOMEN"
            OR category = "JUNIORS"
            OR category = "GIRLS"
        )
    ),
    title TEXT,
    number_of_elo_points INTEGER CONSTRAINT zero_FideRanking_numberOfEloPoints CHECK(number_of_elo_points >= 0)
);

-- Table: Website


CREATE TABLE Website (
    id_website  INTEGER PRIMARY KEY,
    link        TEXT CONSTRAINT null_Website_link NOT NULL CONSTRAINT unique_Website_link UNIQUE,
    name        TEXT CONSTRAINT null_Website_name NOT NULL CONSTRAINT unique_Website_name UNIQUE
);

-- Table: Account


CREATE TABLE Account (
    id_account       INTEGER PRIMARY KEY,
    nickname         TEXT CONSTRAINT unique_Account_nickname UNIQUE CONSTRAINT null_Account_nickname NOT NULL,
    email            TEXT CONSTRAINT unique_Account_email UNIQUE CONSTRAINT null_Account_email NOT NULL,
    title            TEXT,
    number_of_points INTEGER CONSTRAINT zero_Account_numberOfPoints CHECK(number_of_points >= 0),
    id_website       INTEGER CONSTRAINT null_Account_id_website NOT NULL REFERENCES Website ON DELETE CASCADE ON UPDATE CASCADE,
    id_User        INTEGER CONSTRAINT null_Account_id_User NOT NULL REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table: Tournament


CREATE TABLE Tournament (
    id_tournament   INTEGER PRIMARY KEY,
    start_date      DATE CONSTRAINT null_Tournament_startDate NOT NULL,
    end_date        DATE CONSTRAINT null_Tournament_endDate NOT NULL,
    name            TEXT CONSTRAINT null_Tournament_name NOT NULL,
    id_website      INTEGER REFERENCES Website ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table: Match


CREATE TABLE Match (
    id_match        INTEGER PRIMARY KEY,
    details         TEXT,
    date            DATE CONSTRAINT null_Match_date NOT NULL,
    duration_white  TIME CONSTRAINT null_Match_durationWhite NOT NULL CONSTRAINT zero_Match_durationWhite CHECK(duration_white > 0),
    duration_black  TIME CONSTRAINT null_Match_durationBlack NOT NULL CONSTRAINT zero_Match_durationBlack CHECK(duration_black > 0),
    increment       INTEGER CONSTRAINT default_Match_increment DEFAULT 0 CONSTRAINT null_Match_increment NOT NULL CONSTRAINT zero_Match_increment CHECK(increment >= 0),
    number_of_moves INTEGER CONSTRAINT null_Match_numberOfMoves NOT NULL CONSTRAINT zero_Match_numberOfMoves CHECK(number_of_moves >= 0),
    type            TEXT CONSTRAINT null_Match_type NOT NULL CONSTRAINT check_Match_type CHECK (
        (
            type = "CLASSIC"
            AND duration_white >= '1:00:00'
            AND duration_black >= '1:00:00'
        )
        OR (
            type = "RAPID"
            AND duration_white >= '0:10:00'
            AND duration_black >= '0:10:00'
            AND duration_white < '1:00:00'
            AND duration_black < '1:00:00'
        )
        OR (
            type = "BLITZ"
            AND duration_white >= '0:03:00'
            AND duration_black >= '0:03:00'
            AND duration_white < '0:10:00'
            AND duration_black < '0:10:00'
        )
        OR (
            type = "BULLET"
            AND duration_white < '0:03:00'
            AND duration_black < '0:03:00'
        )
    ),
    id_tournament   INTEGER REFERENCES Tournament ON DELETE CASCADE ON UPDATE CASCADE,
    id_website      INTEGER REFERENCES Website ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table: Sponsor


CREATE TABLE Sponsor (
    id_sponsor   INTEGER PRIMARY KEY,
    name         TEXT CONSTRAINT null_Sponsor_name NOT NULL CONSTRAINT unique_Sponsor_name UNIQUE,
    phone_number INTEGER CONSTRAINT null_Sponsor_phone_number NOT NULL CONSTRAINT unique_Sponsor_phone_number UNIQUE,
    email        TEXT CONSTRAINT null_Sponsor_email NOT NULL CONSTRAINT unique_Sponsor_email UNIQUE,
    address      TEXT CONSTRAINT null_Sponsor_address NOT NULL CONSTRAINT unique_Sponsor_adress UNIQUE
);

-- Table: UserMatch


CREATE TABLE UserMatch (
    id_User   INTEGER CONSTRAINT null_UserMatch_id_User NOT NULL REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    id_match    INTEGER REFERENCES Match ON DELETE CASCADE ON UPDATE CASCADE,
    winner      BOOLEAN CONSTRAINT null_UserMatch_winner NOT NULL CONSTRAINT check_UserMatch_winner CHECK (winner IN (0, 1)),
    PRIMARY KEY(id_User, id_match)
);

-- Table: UserTournament


CREATE TABLE UserTournament (
    id_User     INTEGER REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    id_tournament INTEGER REFERENCES Tournament ON DELETE CASCADE ON UPDATE CASCADE,
    winner        BOOLEAN CONSTRAINT null_UserTournament_winner NOT NULL CONSTRAINT check_UserTournament_winner CHECK (winner IN (0, 1)),
    PRIMARY KEY(id_User, id_tournament)
);

-- Table: ChessClub


CREATE TABLE ChessClub (
    id_club           INTEGER PRIMARY KEY,
    name              TEXT CONSTRAINT null_ChessClub_name NOT NULL CONSTRAINT unique_ChessClub_name UNIQUE,
    address           TEXT CONSTRAINT null_ChessClub_adress NOT NULL CONSTRAINT unique_ChessClub_adress UNIQUE,
    ranking           INTEGER CONSTRAINT null_ChessClub_ranking NOT NULL CONSTRAINT zero_ChessClub_ranking CHECK (ranking >= 0),
    number_of_members INTEGER CONSTRAINT default_ChessClub_numberOfMembers DEFAULT 0
);

-- Table: MemberId


CREATE TABLE MemberId (
    id_club   INTEGER REFERENCES ChessClub ON DELETE CASCADE ON UPDATE CASCADE,
    id_User INTEGER REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    member_id INTEGER CONSTRAINT null_MemberId_member_id NOT NULL,
    PRIMARY KEY (id_club, id_User)
);

-- Table: LevelOfSponsorUser


CREATE TABLE LevelOfSponsorUser (
    id_User  INTEGER REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    id_sponsor INTEGER REFERENCES Sponsor ON DELETE CASCADE ON UPDATE CASCADE,
    type       TEXT CONSTRAINT null_LevelOfSponsorUser_type NOT NULL CONSTRAINT check_LevelOfSponsorUser_type CHECK (
        (
            type = "GOLD"
            OR type = "SILVER"
            OR type = "BRONZE"
        )
    ),
    PRIMARY KEY (id_User, id_sponsor)
);

-- Table: LevelOfSponsorTournament


CREATE TABLE LevelOfSponsorTournament (
    id_tournament INTEGER REFERENCES Tournament ON DELETE CASCADE ON UPDATE CASCADE,
    id_sponsor    INTEGER REFERENCES Sponsor ON DELETE CASCADE ON UPDATE CASCADE,
    type          TEXT CONSTRAINT null_LevelOfSponsorTournament_type NOT NULL CONSTRAINT check_LevelOfSponsorTournament_type CHECK (
        (
            type = "GOLD"
            OR type = "SILVER"
            OR type = "BRONZE"
        )
    ),
    PRIMARY KEY (id_tournament, id_sponsor)
);

-- Table: MatchChessClub


CREATE TABLE MatchChessClub (
    id_match INTEGER REFERENCES Match ON DELETE CASCADE ON UPDATE CASCADE,
    id_club  INTEGER REFERENCES ChessClub ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_match, id_club)
);

-- Table: TournamentChessClub


CREATE TABLE TournamentChessClub (
    id_tournament INTEGER REFERENCES Tournament ON DELETE CASCADE ON UPDATE CASCADE,
    id_club       INTEGER REFERENCES ChessClub ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_tournament, id_club)
);

COMMIT TRANSACTION;

PRAGMA foreign_keys = on;