DROP TABLE IF EXISTS CLARIFICATION_REQUESTS;

CREATE TABLE CLARIFICATION_REQUESTS (
  CLARIFICATION_ID int(11) NOT NULL auto_increment,
  TEAM_ID int(11) NOT NULL default '0',
  PROBLEM_ID int(11) NOT NULL default '0',
  SUBMIT_TS int(11) NOT NULL default '0',
  QUESTION char(100) NOT NULL,
  REPLY_TS int(11) NOT NULL default '0',
  RESPONSE char(100) NOT NULL,
  BROADCAST int(11) NOT NULL default '0',
  PRIMARY KEY  (CLARIFICATION_ID)
);

DROP TABLE IF EXISTS JUDGED_SUBMISSIONS;

CREATE TABLE JUDGED_SUBMISSIONS (
  JUDGED_ID int(11) NOT NULL auto_increment,
  TEAM_ID int(11) NOT NULL default '0',
  PROBLEM_ID int(11) NOT NULL default '0',
  TS int(11) NOT NULL default '0',
  ATTEMPT int(11) NOT NULL default '0',
  SOURCE_FILE char(255) NOT NULL default '',
  RESPONSE_ID int(11) NOT NULL default '0',
  AUTO_RESPONSE_ID int(11) NOT NULL default '0',
  VIEWED int(10) NOT NULL default '0',
  JUDGED int(10) NOT NULL default '0',
  PRIMARY KEY  (JUDGED_ID)
);

DROP TABLE IF EXISTS QUEUED_SUBMISSIONS;

CREATE TABLE QUEUED_SUBMISSIONS (
  QUEUE_ID int(11) NOT NULL auto_increment,
  TEAM_ID int(11) NOT NULL default '0',
  PROBLEM_ID int(11) NOT NULL default '0',
  TS int(11) NOT NULL default '0',
  ATTEMPT int(11) NOT NULL default '0',
  SOURCE_FILE char(255) NOT NULL default '',
  PRIMARY KEY  (QUEUE_ID)
);

DROP TABLE IF EXISTS AUTO_RESPONSES;

CREATE TABLE AUTO_RESPONSES (
	JUDGED_ID int(11) NOT NULL default '0',
	IN_FILE varchar(255) NOT NULL default 'null',
	AUTO_RESPONSE int(10) NOT NULL default'0',
	ERROR_NO int(10) default null,
	PRIMARY KEY (JUDGED_ID)
);

DROP TABLE IF EXISTS RESPONSES;

CREATE TABLE RESPONSES (
  RESPONSE_ID int(11) NOT NULL,
  RESPONSE char(50) NOT NULL default '',
  RESPONSE_COLOR char(255) NOT NULL default '',
  PRIMARY KEY  (RESPONSE_ID)
);


INSERT INTO RESPONSES VALUES("0","Pending","FFFF00");
INSERT INTO RESPONSES VALUES("1","Error (Reason Unknown)","00FF00");
INSERT INTO RESPONSES VALUES("2","Forbidden Word in Source","FF0000");
INSERT INTO RESPONSES VALUES("3","Undefined File Type","FF0000");
INSERT INTO RESPONSES VALUES("4","Compile Error","FF0000");
INSERT INTO RESPONSES VALUES("5","Exceeds Time Limit","FF0000");
INSERT INTO RESPONSES VALUES("6","Incorrect Output","FF0000");
INSERT INTO RESPONSES VALUES("7","Format Error","FF0000");
INSERT INTO RESPONSES VALUES("8","Runtime Error","FF0000");
INSERT INTO RESPONSES VALUES("9","Accepted","FF0000");

DROP TABLE IF EXISTS PROBLEMS;

CREATE TABLE PROBLEMS (
  PROBLEM_ID int(11) NOT NULL auto_increment,
  PROBLEM_NAME char(30) NOT NULL default '',
  PROBLEM_SHORT_NAME char(10) NOT NULL default '',
  PROBLEM_LOC char(20) NOT NULL default '',
  PROBLEM_NOTE char(100) NOT NULL default '',
  PRIMARY KEY  (PROBLEM_ID)
);

DROP TABLE IF EXISTS TEAMS;

CREATE TABLE TEAMS (
  TEAM_ID int(11) NOT NULL auto_increment,
  TEAM_NAME char(30) NOT NULL default '',
  ORGANIZATION char(50) NOT NULL default '',
  USERNAME char(30) NOT NULL default '',
  PASSWORD char(20) NOT NULL default '',
  SITE_ID int(11) NOT NULL default '0',
  COACH_NAME char(30) NOT NULL default '',
  CONTESTANT_1_NAME char(30) NOT NULL default '',
  CONTESTANT_2_NAME char(30) NOT NULL default '',
  CONTESTANT_3_NAME char(30) NOT NULL default '',
  ALTERNATE_NAME char(30) NOT NULL default '',
  EMAIL char(30) NOT NULL default '',
  NON_PARTICIPANT char(30) NOT NULL default 'unknown',
  TEST_TEAM boolean NOT NULL default true,
  PRIMARY KEY  (TEAM_ID)
);

DROP TABLE IF EXISTS CATEGORY_TEAM;

CREATE TABLE CATEGORY_TEAM (
  TEAM_ID int(11) NOT NULL default '0',
  CATEGORY_ID int(11) NOT NULL default'0',
  PRIMARY KEY  (TEAM_ID,CATEGORY_ID)
);

DROP TABLE IF EXISTS CATEGORIES;

CREATE TABLE CATEGORIES (
  CATEGORY_ID int(11) NOT NULL auto_increment,
  CATEGORY_NAME char(30) NOT NULL default '',
  PRIMARY KEY  (CATEGORY_ID)
);

DROP TABLE IF EXISTS SITE;

CREATE TABLE SITE (
  CONTEST_HOST char(30) NOT NULL default '',
  CONTEST_NAME char(30) NOT NULL default '',
  CONTEST_DATE date NOT NULL,
  SITE_ID int(11) NOT NULL auto_increment,
  SITE_NAME char(30) NOT NULL default '',
  START_TIME time NOT NULL,
  PRIMARY KEY  (SITE_ID),
  START_TS int(11) NOT NULL default '0',
  HAS_STARTED int(11) NOT NULL default '0',
  FREEZE_DELAY int(11) NOT NULL default '0',
  CONTEST_END_DELAY int(11) NOT NULL default '0',
  BASE_DIRECTORY char(255) NOT NULL default '',
  QUEUE_DIRECTORY char(255) NOT NULL default '',
  JUDGE_DIRECTORY char(255) NOT NULL default '',
  DATA_DIRECTORY char(255) NOT NULL default '',
  NUM_PROBLEMS int(11) NOT NULL default '0',
  IGNORE_STDERR int(1) NOT NULL default '0',
  JUDGE_USER char(30) NOT NULL default '',
  JUDGE_PASS char(30) NOT NULL default '',
  TEAM_SHOW smallint(1) NOT NULL default '0',
  TIME_PENALTY int(2) NOT NULL default '20'
);
/*
DROP TABLE IF EXISTS CONTEST_CONFIG;

CREATE TABLE CONTEST_CONFIG (
  HOST char(30) NOT NULL default '',
  CONTEST_NAME char(30) NOT NULL default '',
  CONTEST_DATE date NOT NULL,
  START_TIME time NOT NULL,
  FREEZE_DELAY int(11) NOT NULL default '0',
  CONTEST_END_DELAY int(11) NOT NULL default '0',
  BASE_DIRECTORY char(255) NOT NULL default '',
  QUEUE_DIRECTORY char(255) NOT NULL default '',
  JUDGE_DIRECTORY char(255) NOT NULL default '',
  DATA_DIRECTORY char(255) NOT NULL default '',
  NUM_PROBLEMS int(11) NOT NULL default '0',
  IGNORE_STDERR int(1) NOT NULL default '0',
  JUDGE_USER char(30) NOT NULL default '',
  JUDGE_PASS char(30) NOT NULL default '',
  START_TS int(11) NOT NULL default '0',
  HAS_STARTED int(11) NOT NULL default '0',
  TEAM_SHOW smallint(1) NOT NULL default '0',
  TIME_PENALTY int(2) NOT NULL default '20'
);
*/
DROP TABLE IF EXISTS LANGUAGE;

CREATE TABLE LANGUAGE (
  LANGUAGE_ID int(11) NOT NULL auto_increment,
  LANGUAGE_NAME char(30) NOT NULL default '',
  MAX_CPU_TIME int(11) NOT NULL default '0',
  CHROOT_DIRECTORY char(15) NOT NULL default '',
  REPLACE_HEADERS int(1) NOT NULL default '0',
  CHECK_BAD_WORDS int(1) NOT NULL default '0',
  PRIMARY KEY  (LANGUAGE_ID)
);


INSERT INTO LANGUAGE VALUES(NULL,"C","30","c_jail",
	"1","1");
INSERT INTO LANGUAGE VALUES(NULL,"CXX","30","cpp_jail",
	"1","1");
INSERT INTO LANGUAGE VALUES(NULL,"JAVA","60","java_jail",
	"0","0");

DROP TABLE IF EXISTS FILE_EXTENSIONS;
CREATE TABLE FILE_EXTENSIONS (
  EXT_ID int(11) NOT NULL auto_increment,
  EXT char(10) NOT NULL default '',
  PRIMARY KEY  (EXT_ID)
);


INSERT INTO FILE_EXTENSIONS VALUES(NULL,"c");
INSERT INTO FILE_EXTENSIONS VALUES(NULL,"C");
INSERT INTO FILE_EXTENSIONS VALUES(NULL,"cpp");
INSERT INTO FILE_EXTENSIONS VALUES(NULL,"cc");
INSERT INTO FILE_EXTENSIONS VALUES(NULL,"java");

DROP TABLE IF EXISTS LANGUAGE_FILE_EXTENSIONS;

CREATE TABLE LANGUAGE_FILE_EXTENSIONS (
  EXT_ID int(11) NOT NULL default '0',
  LANGUAGE_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (EXT_ID,LANGUAGE_ID)
);


INSERT INTO LANGUAGE_FILE_EXTENSIONS VALUES(1,1);
INSERT INTO LANGUAGE_FILE_EXTENSIONS VALUES(2,2);
INSERT INTO LANGUAGE_FILE_EXTENSIONS VALUES(3,2);
INSERT INTO LANGUAGE_FILE_EXTENSIONS VALUES(4,2);
INSERT INTO LANGUAGE_FILE_EXTENSIONS VALUES(5,3);

DROP TABLE IF EXISTS FORBIDDEN_WORDS;

CREATE TABLE FORBIDDEN_WORDS (
  LANGUAGE_ID int(11) NOT NULL default '0',
  WORD char(15) NOT NULL default ''
);


INSERT INTO FORBIDDEN_WORDS VALUES(1,"system");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"fstream");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"open");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"__asm__");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"socket");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"connect");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"accept");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"listen");
INSERT INTO FORBIDDEN_WORDS VALUES(1,"mmap");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"system");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"fstream");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"open");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"__asm__");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"socket");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"connect");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"accept");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"listen");
INSERT INTO FORBIDDEN_WORDS VALUES(2,"mmap");

DROP TABLE IF EXISTS HEADERS;

CREATE TABLE HEADERS (
  LANGUAGE_ID int(11) NOT NULL default '0',
  HEADER char(15) NOT NULL default ''
);


INSERT INTO HEADERS VALUES("1","stdio.h");
INSERT INTO HEADERS VALUES("1","stdlib.h");
INSERT INTO HEADERS VALUES("1","string.h");
INSERT INTO HEADERS VALUES("1","math.h");
INSERT INTO HEADERS VALUES("1","malloc.h");
INSERT INTO HEADERS VALUES("1","ctype.h");
INSERT INTO HEADERS VALUES("1","assert.h");
INSERT INTO HEADERS VALUES("1","limits.h");
INSERT INTO HEADERS VALUES("2","cassert");
INSERT INTO HEADERS VALUES("2","cstdio");
INSERT INTO HEADERS VALUES("2","cstdlib");
INSERT INTO HEADERS VALUES("2","cstring");
INSERT INTO HEADERS VALUES("2","cmath");
INSERT INTO HEADERS VALUES("2","climits");
INSERT INTO HEADERS VALUES("2","iostream");
INSERT INTO HEADERS VALUES("2","sstream");
INSERT INTO HEADERS VALUES("2","iomanip");
INSERT INTO HEADERS VALUES("2","string");
INSERT INTO HEADERS VALUES("2","new");
INSERT INTO HEADERS VALUES("2","stdexcept");
INSERT INTO HEADERS VALUES("2","cctype");
INSERT INTO HEADERS VALUES("2","list");
INSERT INTO HEADERS VALUES("2","queue");
INSERT INTO HEADERS VALUES("2","stack");
INSERT INTO HEADERS VALUES("2","vector");
INSERT INTO HEADERS VALUES("2","map");
INSERT INTO HEADERS VALUES("2","iterator");
INSERT INTO HEADERS VALUES("2","bitset");
INSERT INTO HEADERS VALUES("2","algorithm");
INSERT INTO HEADERS VALUES("2","iomanip");
INSERT INTO HEADERS VALUES("2","set");
INSERT INTO HEADERS VALUES("3","java.lang.*");
INSERT INTO HEADERS VALUES("3","java.io.*");
INSERT INTO HEADERS VALUES("3","java.util.*");
INSERT INTO HEADERS VALUES("3","java.math.*");


DROP TABLE IF EXISTS QUEUED_COMPILE;

CREATE TABLE QUEUED_COMPILE (
  COMPILE_ID int(11) NOT NULL auto_increment,
  TEAM_ID int(11) NOT NULL default '0',
  PROBLEM_ID int(11) NOT NULL default '0',
  TS int(11) NOT NULL default '0',
  SOURCE_FILE varchar(255) NOT NULL,
  PRIMARY KEY  (COMPILE_ID)
);


DROP TABLE IF EXISTS JUDGED_COMPILE;

CREATE TABLE JUDGED_COMPILE (
  COMPILE_ID int(11) NOT NULL auto_increment,
  TEAM_ID int(11) NOT NULL default '0',
  TS int(11) NOT NULL default '0',
  SOURCE_FILE varchar(255) NOT NULL,
  RESPONSE_ID int(11) NOT NULL default '0',
  AUTO_RESPONSE_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (COMPILE_ID)
);
