CREATE DATABASE IF NOT EXISTS piechart;
Use piechart;

CREATE TABLE IF NOT EXISTS ProjectGrades  (
  Id int NOT NULL PRIMARY KEY,
  Grade int UNSIGNED DEFAULT 0
);

INSERT INTO ProjectGrades (Id, Grade) 
VALUES ('1','2')  ,  ('2','3') , ('3','4') , ('4','5') , ('5','6') , ('6','2') , ('7','4');
