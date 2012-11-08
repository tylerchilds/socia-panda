<?php

$uSQL = "CREATE TABLE User
(
userID int UNSIGNED AUTO_INCREMENT,
userURL varchar(255) NOT NULL,
userAlias varchar(20) NOT NULL,
UNIQUE (userURL),
UNIQUE (userAlias),
PRIMARY KEY (userID)
)";
$result = mysql_query($uSQL,$con);
echo "<h2>Users table created " . $result . " <h2>";

$profSQL = "CREATE TABLE Profile
(
profileID int UNSIGNED AUTO_INCREMENT, 
userID int NOT NULL, 
profileGender varchar(20) NOT NULL,
profileStatus varchar(50) NOT NULL,
profileInfo text NOT NULL,
profilePhoto varchar(255) NOT NULL,
profileSince TIMESTAMP,
profileRole varchar(1) DEFAULT '0' NOT NULL,
PRIMARY KEY (profileID),
FOREIGN KEY (userID) REFERENCES User (userID)
)";
$result = mysql_query($profSQL,$con);
echo "<h2>Profile table created " . $result . " <h2>";

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$postSQL = "CREATE TABLE Post
(
postID int UNSIGNED AUTO_INCREMENT,
userID int NOT NULL, 
postText mediumtext,
postCreated TIMESTAMP,
PRIMARY KEY (postID),
FOREIGN KEY (userID) REFERENCES User (userID)
)";
$result = mysql_query($postSQL,$con);
echo "<h2>Posts table created " . $result . " <h2>";

$typeSQL = "CREATE TABLE Type
(
typeID int UNSIGNED AUTO_INCREMENT,
typeTitle varchar(255),
PRIMARY KEY (typeID)
)";
$result = mysql_query($typeSQL,$con);
echo "<h2>Type table created " . $result . " <h2>";

$postTypeSQL = "CREATE TABLE PostType
(
postTypeID int UNSIGNED AUTO_INCREMENT,
postID int NOT NULL,
typeID int NOT NULL,
PRIMARY KEY (postTypeID),
FOREIGN KEY (postID) REFERENCES Post (postID),
FOREIGN KEY (typeID) REFERENCES Type (typeID)
)";
$result = mysql_query($postTypeSQL,$con);
echo "<h2>Post Tyoe table created " . $result . " <h2>";

$tagSQL = "CREATE TABLE Tag
(
tagID int UNSIGNED AUTO_INCREMENT,
tagTitle varchar(255),
PRIMARY KEY (tagID)
)";
$result = mysql_query($tagSQL,$con);
echo "<h2>Tag table created " . $result . " <h2>";

$postTagSQL = "CREATE TABLE PostTag
(
postTagID int UNSIGNED AUTO_INCREMENT,
postID int NOT NULL,
tagID int NOT NULL,
PRIMARY KEY (postTagID),
FOREIGN KEY (postID) REFERENCES Post (postID),
FOREIGN KEY (tagID) REFERENCES Tag (tagID)
)";
$result = mysql_query($postTagSQL,$con);
echo "<h2>Post Tag table created " . $result . " <h2>";


$thSQL = "CREATE TABLE Thread
(
threadID int UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (threadID)
)";
$result = mysql_query($thSQL,$con);
echo "<h2>Threads table created " . $result . " <h2>";

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$tuSQL = "CREATE TABLE ThreadUser
(
threadUserID int UNSIGNED AUTO_INCREMENT,
userID int NOT NULL,
threadID int NOT NULL,
threadUnread varchar(1) DEFAULT '0' NOT NULL,
PRIMARY KEY (threadUserID),
FOREIGN KEY (userID) REFERENCES User (userID),
FOREIGN KEY (threadID) REFERENCES Thread (threadID)
)";
$result = mysql_query($tuSQL,$con);
echo "<h2>Thread User table created " . $result . " <h2>";

$mgSQL = "CREATE TABLE Message
(
messageID int UNSIGNED AUTO_INCREMENT,
threadID int NOT NULL,
userID int NOT NULL,
messageBody mediumtext,
messageDate TIMESTAMP,
PRIMARY KEY (messageID),
FOREIGN KEY (userID) REFERENCES User (userID),
FOREIGN KEY (threadID) REFERENCES Thread (threadID)
)";
$result = mysql_query($mgSQL,$con);
echo "<h2>Messages table created " . $result . " <h2>";



if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}



$frSQL = "CREATE TABLE Friend
(
friendID int UNSIGNED AUTO_INCREMENT,
userID1 int NOT NULL,
userID2 int NOT NULL,
friendSince TIMESTAMP,
PRIMARY KEY (friendID),
FOREIGN KEY (userID1) REFERENCES User (userID),
FOREIGN KEY (userID2) REFERENCES User (userID)
)";
$result = mysql_query($frSQL,$con);
echo "<h2>Friends table created " . $result . " <h2>";



if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}



$pcSQL = "CREATE TABLE Comment
(
commentID int UNSIGNED AUTO_INCREMENT,
userID int NOT NULL,
postID int NOT NULL,
commentText mediumtext,
commentDate TIMESTAMP,
PRIMARY KEY (commentID),
FOREIGN KEY (userID) REFERENCES User (userID),
FOREIGN KEY (postID) REFERENCES Post (postID)
)";
$result = mysql_query($pcSQL,$con);
echo "<h2>ProfileComments table created " . $result . " <h2>";



if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$sessTable = "CREATE TABLE IF NOT EXISTS  `Sessions` (
    session_id varchar(40) DEFAULT '0' NOT NULL,
    ip_address varchar(16) DEFAULT '0' NOT NULL,
    user_agent varchar(255) NOT NULL,
    last_activity int(10) unsigned DEFAULT 0 NOT NULL,
    user_data text NOT NULL,
    PRIMARY KEY (session_id)
)";

$result = mysql_query($sessTable,$con);
echo "<h2>Session table created " . $result . " <h2>";

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


?>