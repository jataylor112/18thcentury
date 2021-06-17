CREATE DATABASE dbHistoricalSite
GO
USE [dbHistoricalSite]
GO
-------------------------------------------------------------------------------------------------
CREATE TABLE USER_ACCOUNT
	( userName				nvarchar(50)		NOT NULL,
	  firstName				nvarchar(50)		NOT NULL,
	  lastName				nvarchar(50)		NOT NULL,
	  user_email			nvarchar(80)		NOT NULL,
	  user_pw				nvarchar(80) 		NOT NULL,
	  user_role				nvarchar(50)		NOT NULL,
	  CHECK (LEN(user_pw) >= 4),
	  PRIMARY KEY (userName) )
	  GO

CREATE TABLE ARTICLE
	( article_id			int		IDENTITY(1,1)		NOT NULL,
	  article_title			nvarchar(100) 	UNIQUE      NOT NULL,
	  category				nvarchar(50)				NOT NULL,
	  link					nvarchar(200)	UNIQUE		NOT NULL,
	  PRIMARY KEY (article_id) )
	  GO

CREATE TABLE USER_SUBMITS_ARTICLE
	( userName				nvarchar(50)		NOT NULL,
	  article_id			int					NOT NULL,
	  time_of_article		datetime			NOT NULL,
	  PRIMARY KEY (userName, article_id), 
	  FOREIGN KEY (userName) REFERENCES USER_ACCOUNT(userName),
	  FOREIGN KEY (article_id) REFERENCES ARTICLE(article_id) )
	  GO

CREATE TABLE ENTRY_FROM_ARTICLE
	( entry_id				int		IDENTITY(1,1)		NOT NULL,
	  article_id			int							NOT NULL,
	  entry_content			nvarchar(MAX)				NOT NULL,
	  reference_content     nvarchar(MAX)				NOT NULL,
	  PRIMARY KEY (entry_id),
	  FOREIGN KEY (article_id) REFERENCES ARTICLE(article_id) )
	  GO

CREATE TABLE USER_SUBMITS_ENTRY
	( userName					nvarchar(50)	NOT NULL,
	  entry_id					int				NOT NULL,
	  time_of_entry				datetime		NOT NULL,
	  PRIMARY KEY (userName, entry_id),
	  FOREIGN KEY (userName) REFERENCES USER_ACCOUNT(userName),
	  FOREIGN KEY (entry_id) REFERENCES ENTRY_FROM_ARTICLE(entry_id) )
	  GO

CREATE ROLE [admin]
CREATE ROLE [user]
GO

CREATE USER [admin_JarrettT] WITHOUT LOGIN
ALTER ROLE [admin] ADD MEMBER [admin_JarrettT]
INSERT INTO [USER_ACCOUNT] VALUES ( 'theadminJarrett',
									'Jarrett',
									'Taylor',
									'thisisalsoanemail@gmail.com',
									HASHBYTES('SHA2_512', '1234'),
									'admin' );
GO

CREATE USER [admin_KatieM] WITHOUT LOGIN
ALTER ROLE [admin] ADD MEMBER [admin_KatieM]
INSERT INTO [USER_ACCOUNT] VALUES ( 'theadminKatie',
									'Katie',
									'McGrath',
									'thisisanemail@gmail.com',
									HASHBYTES('SHA2_512', '1234'),
									'admin' );
GO
-------------------------------------------------------------------------------------------------
-- Stored Procedures
CREATE PROC selectUsers
WITH ENCRYPTION
AS
BEGIN
	SELECT * FROM dbo.USER_ACCOUNT
END
GO

CREATE PROC selectTotalArticleLinks
	@category nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT COUNT(*) FROM dbo.ARTICLE WHERE category = @category';
    SET @params = N'@category NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @category;
END
GO

CREATE PROC	selectArticleLinks
	@category nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT link FROM dbo.ARTICLE WHERE category = @category';
    SET @params = N'@category NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @category;
END
GO

CREATE PROC	selectArticleTitle
	@link nvarchar(200)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT article_title FROM dbo.ARTICLE WHERE link = @link';
    SET @params = N'@link NVARCHAR(200)';
    EXECUTE sp_executesql @sqlcmd, @params, @link;
END
GO

CREATE PROC	selectUserEmail
	@username nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT user_email FROM dbo.USER_ACCOUNT WHERE userName = @username';
    SET @params = N'@username NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @username;
END
GO

CREATE PROC	selectUserLName
	@username nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT lastName FROM dbo.USER_ACCOUNT WHERE userName = @username';
    SET @params = N'@username NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @username;
END
GO

CREATE PROC	selectUserFName
	@username nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT firstName FROM dbo.USER_ACCOUNT WHERE userName = @username';
    SET @params = N'@username NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @username;
END
GO

CREATE PROC	selectUsername
	@username nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
    SET @sqlcmd = N'SELECT @username FROM dbo.USER_ACCOUNT WHERE userName = @username';
    SET @params = N'@username NVARCHAR(50)';
    EXECUTE sp_executesql @sqlcmd, @params, @username;
END
GO

CREATE PROC insertUser
	@username nvarchar(50),
	@fname nvarchar(50),
	@lname nvarchar(50),
	@email nvarchar(80),
	@password nvarchar(80)
WITH ENCRYPTION
AS
BEGIN
	CREATE USER [user_@username] WITHOUT LOGIN;
	ALTER ROLE [user] ADD MEMBER [user_@username];
    INSERT INTO dbo.USER_ACCOUNT VALUES(@username, @fname, @lname, @email, HASHBYTES('SHA2_512', @password), 'user');
END
GO

CREATE PROC	selectPassword
	@password nvarchar(50)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @returnNumber INT
	IF EXISTS(SELECT HASHBYTES('SHA2_512', @password) FROM dbo.USER_ACCOUNT WHERE user_pw = HASHBYTES('SHA2_512', @password))
	BEGIN
          SET @returnNumber = 1
    END
    ELSE
    BEGIN
          SET @returnNumber = 0
    END
 
    RETURN @returnNumber
END
GO

CREATE PROC selectLatestEntryID
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT COUNT(*) FROM dbo.ENTRY_FROM_ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectAllEntries
WITH ENCRYPTION
AS
BEGIN
	SELECT * FROM dbo.ENTRY_FROM_ARTICLE;
END
GO

CREATE PROC selectAllArticles
WITH ENCRYPTION
AS
BEGIN

	SELECT * FROM dbo.ARTICLE;
END
GO

CREATE PROC selectUserCreator
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT userName FROM dbo.USER_SUBMITS_ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectArticleID
	@articleTitle NVARCHAR(50)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT article_id FROM dbo.ARTICLE WHERE article_title = @articletitle';
	SET @params = N'@articleTitle nvarchar(50)';
	EXECUTE sp_executesql @sqlcmd, @params, @articleTitle;
END
GO

CREATE PROC selectArticle
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT article_title FROM dbo.ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectSpecificEntries
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT COUNT(entry_id) FROM dbo.ENTRY_FROM_ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectEntry
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT TOP 1 entry_content FROM dbo.ENTRY_FROM_ARTICLE WHERE article_id = @articleID ORDER BY entry_id DESC';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectSpecificReferences
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT COUNT(reference_content) FROM dbo.ENTRY_FROM_ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectReference
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT TOP 1 reference_content FROM dbo.ENTRY_FROM_ARTICLE WHERE article_id = @articleID ORDER BY entry_id DESC';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC selectCategory
	@articleID int
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'SELECT category FROM dbo.ARTICLE WHERE article_id = @articleID';
	SET @params = N'@articleID int';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID;
END
GO

CREATE PROC insertArticle
	@title nvarchar(50),
	@category varchar(25),
	@link nvarchar(200)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'INSERT INTO dbo.ARTICLE(article_title, category, link) VALUES(@title, @category, @link)';
	SET @params = N'@title nvarchar(50), @category nvarchar(25), @link nvarchar(200)';
	EXECUTE sp_executesql @sqlcmd, @params, @title, @category, @link;
END 
GO

CREATE PROC insertUserArticle
	@username nvarchar(50),
	@articleID int,
	@time datetime
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'INSERT INTO dbo.USER_SUBMITS_ARTICLE VALUES(@username, @articleID, @time)';
	SET @params = N'@username nvarchar(50), @articleID int, @time datetime';
	EXECUTE sp_executesql @sqlcmd, @params, @username, @articleID, @time;
END 
GO

CREATE PROC insertEntry
	@articleID int,
	@content NVARCHAR(MAX),
	@referenceContent NVARCHAR(MAX)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'INSERT INTO dbo.ENTRY_FROM_ARTICLE VALUES(@articleID, @content, @referenceContent)';
	SET @params = N'@articleID int, @content nvarchar(MAX), @referenceContent NVARCHAR(MAX)';
	EXECUTE sp_executesql @sqlcmd, @params, @articleID, @content, @referenceContent;
END 
GO

CREATE PROC insertUserEntry
	@username nvarchar(50),
	@entryID int,
	@time datetime
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'INSERT INTO dbo.USER_SUBMITS_ENTRY VALUES(@username, @entryID, @time)';
	SET @params = N'@username nvarchar(50), @entryID int, @time datetime';
	EXECUTE sp_executesql @sqlcmd, @params, @username, @entryID, @time;
END 
GO

CREATE PROC updateUser
	@originUsername   nvarchar(50),
	@fname			  nvarchar(50),
	@lname			  nvarchar(50),
	@email			  nvarchar(80)
WITH ENCRYPTION
AS
BEGIN
DECLARE @sqlcmd NVARCHAR(MAX);
DECLARE @params NVARCHAR(MAX);
	SET @sqlcmd = N'UPDATE dbo.USER_ACCOUNT SET firstName = @fname, lastName = @lname, user_email = @email WHERE userName = @originUsername';
	SET @params = N'@originUsername nvarchar(50), @fname nvarchar(50), @lname nvarchar(50), @email nvarchar(80)';
	EXECUTE sp_executesql @sqlcmd, @params, @originUsername, @fname, @lname, @email;
END 
GO