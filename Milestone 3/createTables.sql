CREATE TABLE CourseName (Subject VARCHAR(10), Course INT, CourseTitle VARCHAR(10));
CREATE TABLE CourseRating (Subject VARCHAR(10), Course INT, CourseRating DECIMAL(3,2), AverageProfRating DECIMAL(3,2));
CREATE TABLE CourseDifficulty (Subject VARCHAR(10), Course INT, AverageGrade DECIMAL(3,2), AverageHours DECIMAL(4,2), WorkloadRaw DECIMAL(2,1));
CREATE TABLE GradeDistribution (Subject VARCHAR(10), Course INT, PCT_A VARCHAR(4), PCT_B VARCHAR(4), PCT_C VARCHAR(4), PCT_DF VARCHAR(4));
