--
-- Creating Tables 'User', 'Question', 'Answer' and 'Comment'
--

--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "username" TEXT UNIQUE NOT NULL,
    "firstname" TEXT,
    "lastname" TEXT,
    "email" TEXT,
    "password" TEXT
);

--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "content" TEXT,
    "tags" TEXT,
    FOREIGN KEY(userId) REFERENCES User(id)
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "questionId" INTEGER NOT NULL,
    "content" TEXT,
    FOREIGN KEY(userId) REFERENCES User(id),
    FOREIGN KEY(questionId) REFERENCES Question(id)
);

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "answerId" INTEGER,
    "questionId" INTEGER,
    "content" TEXT,
    FOREIGN KEY(answerId) REFERENCES Answer(id),
    FOREIGN KEY(questionId) REFERENCES Question(id)
);
