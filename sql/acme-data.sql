
-- test insert data, password 2Manytests!
-- update your user client level to 2 or above for admin
INSERT INTO users(email, displayName, password)
VALUES('test@me.com','testuser','$2y$10$tRt6YXsazkoiEdF572xmeeKXPNjvBTbdR8cSj8hK7zwI5mWN5OFMu'),
('guest','guestuser','shouldnotworktologin');

INSERT INTO users(email,displayName, password,clientLevel)
VALUES('admin@me.com','adminuser','$2y$10$tRt6YXsazkoiEdF572xmeeKXPNjvBTbdR8cSj8hK7zwI5mWN5OFMu', 3);

INSERT INTO pages(slug,lockedComments)
VALUES('test',0);

INSERT INTO contactForms(email,subject,message)
VALUES('test@me.com','test sub', 'test message');

-- select top 1 * from pages;
SELECT @pageId:=id FROM pages LIMIT 1;
SELECT @userId:=id FROM users LIMIT 1;
INSERT INTO comments(commentText, userId,pageId)
VALUES('teset text',@userId, @pageId)
,('teset text1',@userId, @pageId)
,('teset text2',@userId, @pageId)
,('teset text3',@userId, @pageId)
,('teset text4',@userId, @pageId)
,('teset text5',@userId, @pageId);

SELECT @parentId:=id FROM comments LIMIT 1;

INSERT INTO comments(commentText, userId,pageId, parentId)
VALUES('child text',@userId, @pageId, @parentId)
,('child text1',@userId, @pageId, @parentId)
,('child text2',@userId, @pageId, @parentId)
,('child text3',@userId, @pageId, @parentId)
,('child text4',@userId, @pageId, @parentId);



SELECT @parentId:=id FROM comments wHERE commentText = 'child text' LIMIT 1;

INSERT INTO comments(commentText, userId,pageId, parentId)
VALUES('child child text',@userId, @pageId, @parentId)
,('child child text1',@userId, @pageId, @parentId)
,('child child text2',@userId, @pageId, @parentId)
,('child child text3',@userId, @pageId, @parentId)
,('child child text4',@userId, @pageId, @parentId)
,('child child text5',@userId, @pageId, @parentId)
,('child child text6',@userId, @pageId, @parentId);

INSERT INTO flaggedComment(commentId, userId, message, type)
VALUES(@parentId, @userId, 'message is spam','spam');

-- select @pageId
select * from comments;

-- VALUES(uuid(),'test@me.com','has');

-- replace(uuid(),'-','')
-- varchar(32)
-- will wrok w/ binary, but unreadable from db, appears as blob, keep varchar for simplicity
-- unhex(replace(uuid(),'-',''))


select * from users;

select * from contactForms;

select * from pages;

select * from comments;

select * from configuration;